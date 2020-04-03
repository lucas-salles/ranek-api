<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use App\Repository\TransactionRepository;
use App\Transaction;
use Illuminate\Http\Request;

class TransactionController extends Controller
{
    private $transaction;

    public function __construct(Transaction $transaction)
    {
        $this->transaction = $transaction;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $user = auth('api')->user()->id;
        $repository = new TransactionRepository($this->transaction);

        if($request->has('type')) {
            $data = $request->only(['type']);
		    $repository->getUserTransactions($data['type'], $user);
	    } else {
            $repository->getUserTransactions('purchaser_id', $user);
        }

        return response()->json([
            'data' => $repository->getResult()->paginate(10)
        ], 200);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $data = $request->all();

        $product = Product::findOrFail($data['product_id']);
        if($product->sold) {
            $message = 'Não é possível fazer a compra. Produto já comprado';
            return response()->json(['message' => $message], 401);
        }
        
        try {
            $data['purchaser_id'] = auth('api')->user()->id;
            $data['vendor_id'] = $product->user_id;
            $transaction = Transaction::create($data);
            $product->sold = true;
            $product->update();

            return response()->json([
                'data' => [
                    'msg' => 'Transação cadastrada com sucesso!'
                ]
            ], 201);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 401);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $transaction = Transaction::with('product')->findOrFail($id);

            return response()->json(['data' => $transaction], 200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 401);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
