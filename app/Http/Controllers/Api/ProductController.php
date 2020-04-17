<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = auth('api')->user()->products();

        return response()->json($products->with('photos')->paginate(9), 200);
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
        $images = $request->file('fotos');
        
        try {
            $data['user_id'] = auth('api')->user()->id;

            $product = Product::create($data);

            if($images) {
                $imagesUploaded = [];

                foreach ($images as $image) {
                    $path = $image->store('images', 'public');
                    $fileName = $image->getClientOriginalName();
                    $title = pathinfo($fileName, PATHINFO_FILENAME);
                    $imagesUploaded[] = ['titulo' => $title, 'foto' => $path];
                }
                
                $product->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Produto cadastrado com sucesso!'
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
            $product = Product::with('photos')->findOrFail($id);

            return response()->json(['data' => $product], 200);
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
        $data = $request->all();
        $images = $request->file('fotos');

        try {
            $product = auth('api')->user()->products()->findOrFail($id);
            $product->update($data);

            if($images) {
                $imagesUploaded = [];

                foreach ($images as $image) {
                    $path = $image->store('images', 'public');
                    $fileName = $image->getClientOriginalName();
                    $title = pathinfo($fileName, PATHINFO_FILENAME);
                    $imagesUploaded[] = ['titulo' => $title, 'foto' => $path];
                }
                
                $product->photos()->createMany($imagesUploaded);
            }

            return response()->json([
                'data' => [
                    'msg' => 'Produto atualizado com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 401);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        try {
            $product = auth('api')->user()->products()->findOrFail($id);
            $images = $product->photos;
            foreach ($images as $image) {
                Storage::disk('public')->delete($image->foto);
                $image->delete();
            }
            $product->delete();

            return response()->json([
                'data' => [
                    'msg' => 'Produto removido com sucesso!'
                ]
            ], 200);
        } catch (\Exception $e) {
            $message = $e->getMessage();
            return response()->json(['message' => $message], 401);
        }
    }
}
