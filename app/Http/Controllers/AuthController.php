<?php

namespace App\Http\Controllers;

use Symfony\Component\HttpFoundation\Response;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use App\Helpers\Api as ApiHelper;
use App\Http\Resources\Data;
use App\Traits\ApiController;
use Illuminate\Http\Request;
use App\Models\{TokenAccess,Host, User};

class AuthController extends Controller
{   
    use ApiController;
    
    public function login(Request $request)
    {
        $credentials = $request->only("email", "password");
        
        $validate =  $request->only("email", "password");

        $validate['domain'] = $request->header("domain");

        $validator = Validator::make($validate, [
            'email' => 'required|email',
            'password' => 'required',
            'domain' => 'required|string|exists:hosts,domain'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'errors' => $validator->errors()
            ], 422);
        }

        $user = User::where('email',$request->email)->first();
        
        if (is_null($user)) {
            return response()->json(['error' => 'User not Found'], Response::HTTP_UNAUTHORIZED);
        }        
        
        if (!$user->active) {
            return response()->json(['error' => 'Unauthorized (Not Active)'], Response::HTTP_UNAUTHORIZED);
        }

        if(!Auth::attempt($credentials)) {
            return response()->json(['error' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);
        }
        
        $domain = $request->header("domain");

        $host_id = Host::where('domain',$domain)->first()->id;
        
        $token = $user->createToken($domain)->plainTextToken;

        $token_access = TokenAccess::where('user_id',$user->id)
            ->where('host_id',$host_id)
            ->first();
        
        if (is_null($token_access)){
            
            $token_access = new TokenAccess;
            $token_access->user_id = $user->id;
            $token_access->host_id = $host_id;
            $token_access->token = $token;
            $token_access->save();
        
        }else{
            
            TokenAccess::where('user_id',$user->id)
                ->where('host_id',$host_id)
                ->update(['token' => $token]);
        }

        return response()->json([
            'access_token' => $token,
            'user' => $user,
            'token_type' => 'bearer',
        ]);
    }

    public function update(Request $request) {

      $resource = ApiHelper::resource();

      $validator= \Validator::make($request->all(),[
        'firstname' => 'required',
        'lastname' => 'required',
        'password' => 'confirmed',
        'image' => 'nullable',
      ],
      [
        'firstname.required' => 'El nombre es requerido',
        'lastname.required' => 'El apellido es requerido',
      ]);
     
      if($validator->fails()){
          ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
          return $this->sendResponse($resource);
      }

      try{
        
        $user = Auth::user();

        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $request->input('password') ? $user->password = Hash::make($request->input('password')) : null;
        $request->file('image') ? $user->image = $request->file('image') : null;
        
        $user->save();
        
        $data  =  new Data($user);
        $resource = array_merge($resource, $data->toArray($request));
        ApiHelper::success($resource);
      }catch(\Exception $e){
        ApiHelper::setException($resource, $e);
      }

      return $this->sendResponse($resource);
    }

    public function logout(Request $request)
    {   

        $request->user()->currentAccessToken()->delete();

        return response()->json([
            'message' => 'Successfully logged out'
        ]);
    }


    public function me(Request $request)
    {
        return response()->json(
            $request->user()
        );
    }
}
