<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Helpers\Api as ApiHelper;
use App\Http\Resources\Data;
use App\Traits\ApiController;
use Illuminate\Support\Facades\Auth;
use App\Models\{Category};

class CategoryController extends Controller
{
    use ApiController;

    public function index(Request $request)
    {
        $resource = ApiHelper::resource();

        try{

            $categories = Category::where('user_id',Auth::user()->id)
                ->paginate(20);

            $data  =  new Data($categories);
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

            $categories = Category::where('user_id',Auth::user()->id)
                ->get();

            $data  =  new Data($categories);
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
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable|file'
        ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{

            $store = new Category;
            $store->name = $request->input('name');
            $store->description = $request->input('description');
            $store->image = $request->file('image');
            $store->user_id = Auth::user()->id;
            $store->save();

            $data  =  new Data($store);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }

        return $this->sendResponse($resource);
    }

    public function update(Request $request,$id)
    {
        $resource = ApiHelper::resource();

        $validator = \Validator::make($request->all(),[
            'name' => 'required',
            'description' => 'required',
            'image' => 'nullable'
        ]);

        if($validator->fails()){
            ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
            return $this->sendResponse($resource);
        }

        try{

            $store = Category::where('id',$id)->first();
            $store->name = $request->input('name');
            $store->description = $request->input('description');
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
}
