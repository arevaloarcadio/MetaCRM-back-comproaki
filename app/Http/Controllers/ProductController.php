<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Api as ApiHelper;
use App\Http\Resources\Data;
use App\Traits\ApiController;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;

class ProductController extends Controller
{   
    use ApiController;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $resource = ApiHelper::resource();

        try{

            $user = Auth::user();
            $products = $user->products()->with('store')->get();

            $data  =  new Data($products);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }


    public function all(Request $request)
    {
        $resource = ApiHelper::resource();

        try{

            $products = Product::with('store')->paginate(20);

            $data  =  new Data($products);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $resource = ApiHelper::resource();

        $validator = \Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
            'state' => 'required',
            'image' => 'nullable|file',
            'country' => 'required',
            'phone' => 'required',
            'store_id' => 'required|numeric|exists:stores,id',
        ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{

            $product = new Product;
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->state = $request->input('state');
            $product->image = $request->file('image');
            $product->country = $request->input('country');
            $product->phone = $request->input('phone');
            $product->store_id = $request->input('store_id');
            $product->user_id = Auth::user()->id;
            $product->save();

            $data  =  new Data($product);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
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
        $resource = ApiHelper::resource();

        $validator = \Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
            'state' => 'required',
            'image' => 'nullable',
            'country' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{

            $product = Product::where('id',$id)->first();
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->state = $request->input('state');
             $request->file('image') ? $product->image = $request->file('image') : null;
            $product->country = $request->input('country');
            $product->phone = $request->input('phone');
            $product->save();
            
            $data  =  new Data($product);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
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
