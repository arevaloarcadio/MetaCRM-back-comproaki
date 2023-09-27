<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Api as ApiHelper;
use App\Http\Resources\Data;
use App\Traits\{ApiController,SendNotificationFcm};
use Illuminate\Support\Facades\Auth;
use App\Models\{Order,Store};
use Illuminate\Support\Str;

class OrderController extends Controller
{
    use ApiController, SendNotificationFcm;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request,$store_id)
    {
        $resource = ApiHelper::resource();

        try{

            $user = Auth::user();

            $orders = Order::where('user_id',$user->id)
                ->where('store_id',$store_id)
                ->with([
                    'product' => function($query) {
                        $query->with(['store']);
                    },
                    'user',
                    'store'
                ])->paginate(20);

            $data = new Data($orders);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }
        return $this->sendResponse($resource);
    }


    public function storeByOrders(Request $request)
    {
        $resource = ApiHelper::resource();

        try{

            $user = Auth::user();

            $store_ids = Order::select('store_id')
                ->where('user_id',$user->id)
                ->groupBy('store_id')
                ->orderBy('created_at','DESC')
                ->pluck('store_id');

            $stores = Store::whereIn('id',$store_ids)
                ->with(['tags'])
                ->paginate(20);

            $data = new Data($stores);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }

    public function showByToken(Request $request,$token)
    {
        $resource = ApiHelper::resource();

        try{

            $user = Auth::user();

            $orders = Order::where('token_link',$token)
                ->with([
                    'product' => function($query) {
                        $query->with(['store']);
                    },
                    'user',
                    'store'
                ])->paginate(20);

            $data = new Data($orders);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }

    public function generateTokenLink(Request $request)
    {
        $resource = ApiHelper::resource();

        try{
            
            $validator = \Validator::make($request->all(),[
                'store_id' => 'numeric|exists:stores,id',
            ]);

            if($validator->fails()){
                ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
                return $this->sendResponse($resource);
            }

            $user = Auth::user();
            $token = null;

            $order = Order::where('token_link', $token)
                ->whereRaw('token_link IS NOT NULL')
                ->first();

            if (is_null($order)) {
                
                do {
                    $token = Str::uuid();
                } while (Order::where('token_link', $token)->first() instanceof Order); 
                
                $store_ids = Order::where('user_id',$user->id)
                    ->where('store_id',$request->store_id)
                    ->update([
                        'token_link' => $token
                    ]); 
            }else{
                $token = $order->token_link;
            }
            
            $data = new Data(['token' => env('APP_URL').'/order/'.$token]);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }

    public function store(Request $request)
    {
        $resource = ApiHelper::resource();

        $validator = \Validator::make($request->all(),[
            'product_id' => 'numeric|exists:products,id',
            'store_id' => 'numeric|exists:stores,id',
        ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{

            $user = Auth::user();

            $order = Order::where('user_id', $user->id)
                ->where('product_id',$request->input('product_id'))
                ->where('store_id',$request->input('store_id'))
                ->first();
            
            if (is_null($order)) {
                $order = new Order;
                $order->user_id = $user->id;
                $order->product_id = $request->input('product_id');
                $order->store_id = $request->input('store_id');
                $order->save();
            }

            $data = new Data($order);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
