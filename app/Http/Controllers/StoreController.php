<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Api as ApiHelper;
use App\Http\Resources\Data;
use App\Traits\ApiController;
use Illuminate\Support\Facades\Auth;
use App\Models\{Tag,Store,UserStore};
use Illuminate\Support\Arr;
use Carbon\Carbon;

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

            $stores =  Store::with('tags')->paginate(20);
          
            $data  =  new Data($stores);
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
            $stores =  $user->stores()->with('tags')->paginate(20);
          
            $data  =  new Data($stores);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }

    public function byUserAll(Request $request)
    {
        $resource = ApiHelper::resource();

        try{

            $user = Auth::user();
            $stores =  $user->stores()->with('tags')->get();
          
            $data  =  new Data($stores);
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

            $search_store = $this->searchStore($search);
            
            $search_store_by_tags = $this->searchStoreByTags($search);

            $store_ids = Arr::collapse([$search_store,$search_store_by_tags]);

            $stores = Store::whereIn('id',$store_ids)
                ->with('tags');
            
            if($request->all){
                $stores = $stores->get();
            }else{
                $stores = $stores->paginate(20);
            }
            
            $data  = new Data($stores);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }


    public function searchStore($search)
    {
        $stores = Store::select('stores.id')
                ->where('name','LIKE','%'.$search.'%')
                ->get()
                ->toArray();

        $store_ids = array_column($stores, 'id');

        return $store_ids;
    }


    public function searchStoreByTags($search)
    {
        $tags = Tag::select('tags.id')
            ->where('name','LIKE','%'.$search.'%');

        $stores = Store::select('stores.id')
            ->join('store_tags','store_tags.store_id','stores.id')
            ->whereIn('tag_id',$tags)
            ->get()
            ->toArray();

        $store_ids = array_column($stores, 'id');

        return $store_ids;
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
            'tags' => 'required|array',
            'tags.*' => 'numeric|exists:tags,id'
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

            foreach ($request->input('tags') as $tag) {
                $store->tags()->attach($tag,[
                  'created_at' => Carbon::now(), 
                  'updated_at' => Carbon::now()
                ]);
            }

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
