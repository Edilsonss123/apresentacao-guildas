<?php
namespace App\Middlewares;

use App\Exceptions\SistemaException;
use App\Exceptions\ValidacaoException;
use App\Response\ResponseJson;
use App\Services\JwtService;
use Buki\Router\Http\Middleware;
use DomainException;
use Firebase\JWT\ExpiredException;
use Firebase\JWT\SignatureInvalidException;
use Symfony\Component\HttpFoundation\Request;
use Throwable;

class JwtMiddleware extends Middleware
{
    public function handle(Request $request)
    {   $response = new ResponseJson;
        try {
            $headers = $request->headers->all();
            if (!isset($headers["authorization"]) || !isset($headers["authorization"][0])) {
                throw new SistemaException("Token não informado", $response::HTTP_UNAUTHORIZED);
            }

            $jwtService = new JwtService;
            $token = trim(str_replace("Bearer", "", $headers["authorization"][0]));
            $payloadDecode = $jwtService->validarToken($token);
            return $payloadDecode !== null;

        } catch (ExpiredException $th) {
            return $response->json([
                "message" => "Token expirado, gere um novo e tente novamente",
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
                "message" => "Não foi autenticar o token, gere um novo e tente novamente"
            ], $response::HTTP_UNAUTHORIZED);
        }
    }
}