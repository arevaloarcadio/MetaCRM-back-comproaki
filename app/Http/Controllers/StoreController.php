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
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'phone' => 'nullable',
            'address' => 'nullable',
            'image' => 'nullable|file',
        ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{

            $store = new Store;
            $store->name = $request->input('name');
            $store->state = $request->input('state');
            $store->city = $request->input('city');
            $store->postal_code = $request->input('postal_code');
            $store->phone = $request->input('phone');
            $store->address = $request->input('address');
            $store->image = $request->file('image');
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
            'state' => 'required',
            'city' => 'required',
            'postal_code' => 'required',
            'phone' => 'nullable',
            'address' => 'nullable',
            'image' => 'nullable',
        ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{

            $store = Store::where('id',$id)->first();
            
            $store->name = $request->input('name');
            $store->state = $request->input('state');
            $store->city = $request->input('city');
            $store->postal_code = $request->input('postal_code');
            $store->phone = $request->input('phone');
            $store->address = $request->input('address');
            $request->file('image') ? $store->image = $request->file('image') : null;
            
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
