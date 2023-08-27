<?php
namespace App\Controllers;
use App\Exceptions\SistemaException;
use App\Exceptions\ValidacaoException;
use App\Services\Interface\ICampanha;
use App\Validacao\Interface\ICampanhaValidacao;
use Throwable;
use App\Response\ResponseJson;
use Symfony\Component\HttpFoundation\Request;

class CampanhaController
{
    private ICampanha $campanhaService;
    private ICampanhaValidacao $campanhaValidacao;
    private static $conection;

    public function __construct(\Illuminate\Database\Connection $connection, ICampanha $campanhaService, ICampanhaValidacao $campanhaValidacao) 
    {
        $this->campanhaService = $campanhaService;
        $this->campanhaValidacao = $campanhaValidacao;
        self::$conection = $connection;
    }

    public function recuperarCampanhas()
    {
        $response = new ResponseJson;
        try {      
            $campanhas = $this->campanhaService->recuperarCampanhas();

            return $response->json([
                "message" => "Campanhas",
                "campanhas" => $campanhas,
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
                "message" => "Não foi possível consultar as campanhas, tente novamente"
            ], $response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function recuperarCampanhaPeloId(int $id)
    {
        $response = new ResponseJson;
        try {
            $campanha = $this->campanhaService->recuperarCampanhaPeloId($id);

            return $response->json([
                "message" => "Campanha",
                "campanhas" => $campanha,
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
                "message" => "Não foi possível consultar as campanhas, tente novamente"
            ], $response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function novaCampanha(Request $request) : ResponseJson
    {
        $response = new ResponseJson;
        try {
            self::$conection->beginTransaction();
                $this->campanhaValidacao->validar(array_merge($request->request->all(), $_FILES));

                $request = array_merge($request->request->all(), $request->files->all());
                $campanha = $this->campanhaService->novaCampanha($request);

            self::$conection->commit();

            return $response->json([
                "message" => "Campanha criada com sucesso",
                "campanha" => [
                    "id" => $campanha->id
                ],
            ], $response::HTTP_CREATED);

        } catch (ValidacaoException $th) {
            self::$conection->rollback();
            return $response->json([
                "message" => $th->getMessage(),
                "camposInvalidos" => $th->getCamposInvalidos(),
            ], $th->getCode());
        } catch (Throwable $th) {
            self::$conection->rollback();
            return $response->json([
                "message" => "Não foi possível realizar o cadastro da nova campanha, tente novamente"
            ], $response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function atualizarCampanha(int $id, Request $request) : ResponseJson
    {
        $response = new ResponseJson;
        try {
            self::$conection->beginTransaction();
                $this->campanhaValidacao->validar(array_merge($request->request->all(),["id" => $id], $_FILES));
                
                $request = array_merge($request->request->all(), $request->files->all());
                $this->campanhaService->atualizarCampanha($id, $request);

            self::$conection->commit();
            return $response->json([
                "message" => "Campanha atualizada com sucesso",
                "campanha" => [
                    "id" => $id
                ],
            ], $response::HTTP_CREATED);

        } catch (ValidacaoException $th) {
            self::$conection->rollback();
            return $response->json([
                "message" => $th->getMessage(),
                "camposInvalidos" => $th->getCamposInvalidos(),
            ], $th->getCode());
        } catch (SistemaException $th) {
            self::$conection->rollback();
            return $response->json([
                "message" => $th->getMessage()
            ], $th->getCode());
        } catch (Throwable $th) {
            self::$conection->rollback();
            return $response->json([
                "message" => "Não foi possível atualizar a campanha, tente novamente"
            ], $response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }

    public function deletarCampanha(int $id)
    {
        $response = new ResponseJson;
        try {
            self::$conection->beginTransaction();
                $this->campanhaService->deletarCampanha($id);
            self::$conection->commit();

            return $response->json([
                "message" => "Campanha deletada com sucesso",
                "campanha" => [
                    "id" => $id
                ],
            ], $response::HTTP_CREATED);

        } catch (ValidacaoException $th) {
            self::$conection->rollback();
            return $response->json([
                "message" => $th->getMessage(),
                "camposInvalidos" => $th->getCamposInvalidos(),
            ], $th->getCode());
        } catch (SistemaException $th) {
            self::$conection->rollback();
            return $response->json([
                "message" => $th->getMessage()
            ], $th->getCode());
        } catch (Throwable $th) {
            self::$conection->rollback();
            return $response->json([
                "message" => "Não foi possível deletar a campanha, tente novamente"
            ], $response::HTTP_INTERNAL_SERVER_ERROR);

        }
    }
}