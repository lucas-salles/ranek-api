<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use App\Repository\AbstractRepository;
use Illuminate\Http\Request;

class ProductSearchController extends Controller
{
    private $product;

    public function __construct(Product $product)
    {
        $this->product = $product;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $repository = new AbstractRepository($this->product);

        if($request->has('conditions')) {
		    $repository->selectConditions($request->get('conditions'));
	    }

	    if($request->has('fields')) {
		    $repository->selectFilter($request->get('fields'));
        }

        return response()->json([
            'data' => $repository->getResult()->where('sold', false)->paginate(10)
        ], 200);
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
            $product = $this->product->with('photos')->findOrFail($id);

            return response()->json([
                'data' => $product
            ], 200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 401);
        }
    }
}
