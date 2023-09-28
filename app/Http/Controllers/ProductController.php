<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Api as ApiHelper;
use App\Http\Resources\Data;
use App\Traits\{ApiController,SendNotificationFcm};
use Illuminate\Support\Facades\Auth;
use App\Models\{Product,Store,Tag};

class ProductController extends Controller
{   
    use ApiController,SendNotificationFcm;

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function index(Request $request)
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
    
    public function byUser(Request $request)
    {
        $resource = ApiHelper::resource();

        try{

            $user = Auth::user();
            $products = $user->products()->with('store')->paginate(20);

            $data  =  new Data($products);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }


    public function byStore(Request $request,$store_id)
    {
        $resource = ApiHelper::resource();

        try{

            $products = Product::where('store_id',$store_id)->with('store')->paginate(20);

            $data  =  new Data($products);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }

    public function byStoreUser(Request $request)
    {
        $resource = ApiHelper::resource();

        try{
            
            $user = Auth::user();
          
            $stores = $user->likeStores()
                ->select('stores.id')
                ->get()
                ->toArray();
            
            $store_ids = array_column($stores,'id');

            $products = Product::whereIn('store_id',$store_ids)
                ->with('store')
                ->orderBy('products.created_at','DESC')
                ->paginate(20);

            $data  =  new Data($products);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }


    public function byCategory(Request $request,$category_id)
    {
        $resource = ApiHelper::resource();

        try{

            $products = Product::where('category_id',$category_id)
                ->with('store')
                ->paginate(20);

            $data  =  new Data($products);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }

    public function filter(Request $request)
    {
        $resource = ApiHelper::resource();

        try{
            
            $search = $request->input('search');
            
            $store_controller = new StoreController;
            $store_ids = $store_controller->searchStoreByTags($search);
            
            $products = Product::where(function ($query) use ($search,$store_ids) {
                    $query->where('name','LIKE','%'.$search.'%')
                          ->orWhereIn('store_id',$store_ids);
                })
                ->with('store')
                ->orderBy('products.created_at','DESC');
            
            if ($request->all){
                $products =  $products->get();
            }else{
                $products = $products->paginate(20);
            }

            $data  =  new Data($products);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }

    public function relatedProducts(Request $request,$store_id)
    {
        $resource = ApiHelper::resource();

        $validator = \Validator::make([
            'store_id' => $store_id
        ],[
            'store_id' => 'required|numeric|exists:stores,id'
        ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{
            
            $related_products = Product::where('store_id',$store_id)
                ->limit(4)
                ->inRandomOrder()
                ->get();

            $data = new Data($related_products);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resou-ce, $e);
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
            'price' => 'required|numeric',
            'image' => 'nullable|file',
            'store_id' => 'required|numeric|exists:stores,id',
            'has_category' => 'required|boolean',
            'category_id' => 'nullable|exists:categories,id',
        ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{

            $product = new Product;
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $product->image = $request->file('image');
            $product->store_id = $request->input('store_id');
            $product->category_id = $request->input('category_id');
            $product->user_id = Auth::user()->id;
            $product->save();

            $title = "Comproaki";
            $body = $product->store->name." ha publicado un nuevo producto";
            $image = env('APP_URL').$product->image;

            $this->sendNotification($product->store_id,$title,$body,$image);

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
    public function show(Request $request,$id)
    {
        $resource = ApiHelper::resource();

        try{

            $product = Product::where('id',$id)->with('store')->first();

            $data  =  new Data($product);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
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
            'image' => 'nullable',
            'category_id' => 'required|numeric|exists:categories,id'
        ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{

            $product = Product::where('id',$id)->first();
            $product->name = $request->input('name');
            $product->description = $request->input('description');
            $product->price = $request->input('price');
            $request->file('image') ? $product->image = $request->file('image') : null;
            $product->category_id = $request->input('category_id');
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
