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
        
        $validate = $request->only("email", "password");

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

      }catch(\Exception $e){
        ApiHelper::setException($resource, $e);
      }

      return $this->sendResponse($resource);
    }

    public function registerProvider(Request $request) {

      $resource = ApiHelper::resource();
      
      $validate = $request->only("name","email","image","auth_provider");
      
      $validate['domain'] = $request->header("domain");

      $validator= \Validator::make($validate,[
        'name' => 'required',
        'email' => 'required',
        'image' => 'nullable',
        'auth_provider' => 'required',
        'domain' => 'required'
      ],
      [
        'name.required' => 'El nombre es requerido',
        'email.required' => 'El correo es requerido',
        'auth_provider.required' => 'El auth provider es requerido',
        'domain.required' => 'El dominio es requerido',
      ]);
     
      if($validator->fails()){
          ApiHelper::setError($resource, 0, 422, $validator->errors()->all());
          return $this->sendResponse($resource);
      }

      try{
        

        $user = User::where('email',$request->input('email'))->first();

        if(is_null($user)){
            $user = new User;
            $user->firstname = $request->input('name');
            $user->email = $request->input('email');
            $user->lastname = '';
            $user->password = null;
            $user->admin = false;
            $user->active = true;
            $user->image = '/storage/profiles/default.png';
            $user->auth_provider = $request->input('auth_provider');
            $user->save();   
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

    public function saveToken(Request $request)
    {   
        $user = Auth::user();

        $user->device_token = $request->token;
        $user->save();

        return response()->json([
            'message' => 'OK'
        ]);
    }
}
