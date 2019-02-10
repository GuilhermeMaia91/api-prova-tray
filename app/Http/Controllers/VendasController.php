<?php

namespace App\Http\Controllers;

use App\Http\Requests\OrderRequest as Request;
use App\Models\Order;
use App\Models\User;

class VendasController extends Controller
{
    /**
     * @OA\Get(
     *   path="/venda/lista",
     *   tags={"Vendas"},
     *   summary="Obtém todas as vendas",
     *   @OA\Response(
     *     response=200,
     *     description="Retorna uma lista de todas as vendas",
     *     @OA\JsonContent(
     *         type="array",
     *         @OA\Items(ref="#/components/schemas/Order")
     *     ),
     *   ),
     *   @OA\Response(
     *     response="500",
     *     description="Erro interno da API, consulte o log"
     *   )
     * )
     */
    public function index(){
        $sales = Order::all();
        $dataResponse = [];

        if ($sales->count() > 0) {
            foreach ($sales as $sale) {
                $user = User::find($sale->user_id);

                $dataResponse[] = [
                    'id' => $sale->id,
                    'name' => $user->name ?? null,
                    'email' => $user->email ?? null,
                    'commission' => $sale->commission,
                    'price_sale' => $sale->price_sale,
                    'created_at' => $sale->created_at->format('Y-m-d H:i:s')
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
     *     path="/venda/incluir",
     *     tags={"Venda"},
     *     operationId="addNovaVenda",
     *     summary="Insere uma nova venda",
     *     description="Inclui uma nova venda",
     *     @OA\RequestBody(
     *         description="Dados da venda que deve ser armazenado.",
     *         required=true,
     *         @OA\MediaType(
     *             mediaType="multipart/form-data",
     *             @OA\Schema(ref="#/components/schemas/Order")
     *         )
     *     ),
     *     @OA\Response(
     *         response=200,
     *         description="Objeto com os dados da empresa",
     *         @OA\JsonContent(ref="#/components/schemas/Order")
     *     ),
     *     @OA\Response(
     *         response="500",
     *         description="Erro interno, consulte o log",
     *     )
     * )
     */
    public function store(Request $request){
        $sale = null;
        $user = null;
        $comissao = 8.5;

        try {
            $validated = $request->validated();

            $validated['commission'] = (($validated['price_sale'] * $comissao)/100);
            $sale = Order::create($validated);

            $user = User::find($validated['user_id']);
        }
        catch (\Exception $e){
            if (strpos($e->getMessage(), 'SQLSTATE[22P02]') !== false){
                return response()->json([
                    'data' => $request->all(),
                    'code' => 500,
                    'message' => 'Houve uma falha na inclusão da venda.\\nError: ' . substr($e->getMessage(), 0, stripos($e->getMessage(), '(SQL')),
                    'errors' => [
                        $e->getFile()
                    ]
                ]);
            }

            return response()->json([
                'data' => $request->all(),
                'code' => 500,
                'message' => 'Houve uma falha na inclusão da venda.\\nError: ' . $e->getMessage(),
                'errors' => [
                    $e->getFile()
                ]
            ]);
        }

        return response()->json([
            'code' => 200,
            'data' => [
                'id' => $sale->id,
                'name' => $user->name,
                'email' => $user->email,
                'commission' => $sale->commission,
                'price_sale' => $sale->price_sale,
                'created_at' => $sale->created_at->format('Y-m-d H:i:s')
            ]
        ]);
    }
}
