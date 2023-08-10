<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Helpers\Api as ApiHelper;
use Illuminate\Http\Request;
use App\Http\Resources\Data;
use App\Traits\ApiController;
use App\Models\Tag;

class TagController extends Controller
{   
    use ApiController;
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $resource = ApiHelper::resource();

        try{
            
            $tags = Tag::paginate(20);
          
            $data  =  new Data($tags);
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
            
            $tags = Tag::all();
          
            $data  =  new Data($tags);
            $resource = array_merge($resource, $data->toArray($request));
            ApiHelper::success($resource);
        }catch(\Exception $e){
            ApiHelper::setException($resource, $e);
        }
        return $this->sendResponse($resource);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
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
