<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Api as ApiHelper;
use App\Http\Resources\Data;
use App\Traits\ApiController;
use Illuminate\Support\Facades\Auth;
use App\Models\Follower;

class FollowerController extends Controller
{
    use ApiController;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
            'store_id' => 'required|numeric|exists:stores,id',
            'user_id' => 'required|numeric|exists:users,id',
        ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{

            $follower = new Follower;
            $follower->user_id = $request->input('user_id');
            $follower->store_id = $request->input('store_id');
            $follower->save();

            $data  =  new Data($follower);
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

    public function check(Request $request,$user_id,$store_id)
    {   
        $resource = ApiHelper::resource();

        try{

            $follower = Follower::where('user_id',$user_id)
                ->where('store_id',$store_id)
                ->count();
 
            $resource = array_merge($resource,['data' => $follower]);
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
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($user_id,$store_id)
    {
        $resource = ApiHelper::resource();

        $validator = \Validator::make(
            [
            'store_id' => $store_id,
            'user_id' => $user_id 
            ],
            [
            'store_id' => 'required|numeric|exists:stores,id',
            'user_id' => 'required|numeric|exists:users,id',
            ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{

            $follower = Follower::where('user_id',$user_id)
                ->where('store_id',$store_id)
                ->delete();

            $resource = array_merge($resource, ['data' => 'OK']);
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }
}
