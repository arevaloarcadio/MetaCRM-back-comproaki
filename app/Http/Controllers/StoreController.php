<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Api as ApiHelper;
use App\Http\Resources\Data;
use App\Traits\ApiController;
use Illuminate\Support\Facades\Auth;
use App\Models\Store;
use App\Models\UserStore;

class StoreController extends Controller
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
            $stores =  $user->stores;
          
            $data  =  new Data($stores);
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
            'address' => 'required',
            'state' => 'required',
            'image' => 'nullable|file',
            'country' => 'required',
            'phone' => 'required',
        ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{

            $store = new Store;
            $store->name = $request->input('name');
            $store->address = $request->input('address');
            $store->state = $request->input('state');
            $store->image = $request->file('image');
            $store->country = $request->input('country');
            $store->phone = $request->input('phone');
            $store->save();

            $user_store = new UserStore;
            $user_store->store_id = $store->id;
            $user_store->user_id = Auth::user()->id;  
            $user_store->save();

            $data  =  new Data($store);
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

            $store =  Store::where('id',$id)->first();
          
            $data  =  new Data($store);
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
            'address' => 'required',
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

            $store = Store::where('id',$id)->first();
            $store->name = $request->input('name');
            $store->address = $request->input('address');
            $store->state = $request->input('state');
            $request->file('image') ? $store->image = $request->file('image') : null;
            $store->country = $request->input('country');
            $store->phone = $request->input('phone');
            $store->save();

            $data  =  new Data($store);
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
