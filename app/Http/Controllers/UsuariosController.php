<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Requests\UserRequest as Request;


class UsuariosController extends Controller
{
    /**
     * @OA\Get(
     *   path="/vendedor/lista",
     *   tags={"Vendedor"},
     *   summary="Obtém todas os vendedores",
     *   @OA\Response(
     *     response=200,
     *     description="Retorna uma lista de vendedores",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/User")
     *     ),
     *   ),
     *   @OA\Response(
     *     response="500",
     *     description="Erro interno da API, consulte o log"
     *   )
     * )
     */
    public function index(){
        $users = User::all();
        $dataResponse = [];

        if ($users->count() > 0) {
            foreach ($users as $user) {
                $dataResponse[] = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'comissao' => 8.5
                ];
            }
        }

        return response()->json([
            'code' => 200,
            'data' => $dataResponse
        ]);
    }

    /**
     * @OA\Post(
     *     path="/vendedor/incluir",
     *     tags={"Vendedor"},
     *     operationId="addNovoVendedor",
     *     summary="Insere um novo vendedor",
     *     description="Inclui um novo vendedor",
     *     @OA\RequestBody(
     *         description="Dados do vendedor que deve ser armazenado.",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/User")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Objeto com os dados do vendedor",
     *         @OA\JsonContent(ref="#/components/schemas/User")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Erro interno da API, consulte o log"
     *     )
     * )
     */
    public function store(Request $request){
        $user = null;
        try {
            $validated = $request->validated();

            $user = User::create($validated);
        }
        catch (\Exception $e){
            if (strpos($e->getMessage(), 'SQLSTATE[22P02]') !== false){
                return response()->json([
                    'data' => $request->all(),
                    'code' => 500,
                    'message' => 'Houve uma falha na inclusão do vendedor.\\nError: ' . substr($e->getMessage(), 0, stripos($e->getMessage(), '(SQL')),
                    'errors' => [
                        $e->getFile()
                    ]
                ]);
            }

            return response()->json([
                'data' => $request->all(),
                'code' => 500,
                'message' => 'Houve uma falha na inclusão do vendedor.\\nError: ' . substr($e->getMessage(), 0, stripos($e->getMessage(), '(SQL')),
                'errors' => [
                    $e->getFile()
                ]
            ]);
        }

        return response()->json([
            'code' => 200,
            'data' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email
            ]
        ]);
    }
}
