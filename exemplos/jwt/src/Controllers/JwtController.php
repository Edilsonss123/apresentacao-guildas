<?php
namespace App\Controllers;
use App\Exceptions\SistemaException;
use App\Exceptions\ValidacaoException;
use App\Services\JwtService;
use DomainException;
use App\Services\Interface\IUsuario;
use App\Services\Interface\IJwtService;
use App\Validacao\Interface\IUsuarioValidacao;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Throwable;
use App\Response\ResponseJson;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class JwtController
{
    private IUsuario $usuarioService;
    private IUsuarioValidacao $usuarioValidacao;
    private IJwtService $jwtService;

    public function __construct(IUsuario $usuarioService, IUsuarioValidacao $usuarioValidacao, IJwtService $jwtService) 
    {
        $this->usuarioService = $usuarioService;
        $this->usuarioValidacao = $usuarioValidacao;
        $this->jwtService = $jwtService;
    }

    public function gerarToken(Request $request) : ResponseJson
    {
        $response = new ResponseJson;
        try {
            $request = $request->getContentType() == "json" ? json_decode($request->getContent(), true): $request->request->all();

            $this->usuarioValidacao->validar($request);
            $usuario = $this->usuarioService->recuperarUsuario(
                $request["login"],
                $request['senha'],
            );
            
            $tokens = $this->jwtService->gerarToken($usuario);

            return $response->json([
                "message" => "Token gerado com sucesso",
                "token" => $tokens["token"],
                "refreshToken" => $tokens["refreshToken"],
            ], $response::HTTP_OK);

        } catch (ValidacaoException $th) {
            return $response->json([
                "message" => $th->getMessage(),
            ], $th->getCode());
        } catch (SistemaException $th) {
            return $response->json([
                "message" => $th->getMessage()
            ], $th->getCode());
        } catch (Throwable $th) {
            return $response->json([
                "message" => "Não foi possível gerar o token, tente novamente"
            ], $response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }

    public function atualizarToken(Request $request) : ResponseJson
    {
        $response = new ResponseJson;
        try {
            $headers = $request->headers->all();
            if (!isset($headers["authorization"]) || !isset($headers["authorization"][0])) {
                throw new SistemaException("Token não informado", $response::HTTP_UNAUTHORIZED);
            }
            $token = trim(str_replace("Bearer", "", $headers["authorization"][0]));
            
            $payloadDecode = $this->jwtService->validarToken($token, true);
            $usuario = $this->usuarioService->recuperarUsuarioPeloLogin($payloadDecode->login);
            
            $tokens = $this->jwtService->gerarToken($usuario);


            return $response->json([
                "message" => "Token atualizado com sucesso",
                "token" => $tokens["token"],
                "refreshToken" => $tokens["refreshToken"],
            ], $response::HTTP_OK);
        } catch (ExpiredException $th) {
            return $response->json([
                "message" => "Token refresh expirado, gere um novo e tente novamente",
            ], $response::HTTP_UNAUTHORIZED);
        } catch (SignatureInvalidException $th) {
            return $response->json([
                "message" => "Token invalido",
            ], $response::HTTP_UNAUTHORIZED);
        } catch (DomainException $th) {
            return $response->json([
                "message" => $th->getMessage(),
            ], $response::HTTP_UNAUTHORIZED);
        } catch (SistemaException $th) {
            return $response->json([
                "message" => $th->getMessage()
            ], $th->getCode());
        } catch (Throwable $th) {
            return $response->json([
                "message" => "Não foi possível atualizar o token, tente novamente"
            ], $response::HTTP_INTERNAL_SERVER_ERROR);
        }
    }
}