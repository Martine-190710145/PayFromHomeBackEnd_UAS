<?php

namespace App\Http\Controllers\API;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Mail\EmailVerification;
use App\Models\User;
use Exception;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

class UserController extends Controller
{
    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function login(Request $request){
        $validator = Validator::make($request->all(), [
            'email' => ['required', 'email'],
            'password' => ['required']
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        }

        $credentials = request(['email', 'password']);

        if (!Auth::attempt($credentials)) {
            return response()->json([
                'status' => 'error',
                'message' => 'Email & password tidak sesuai'
            ], 200);
        }

        $user = User::where('email', $request->email)->first();

        if (!$user->hasVerifiedEmail()){
            return response()->json([
                'status' => 'error',
                'message' => 'Email belum diverifikasi'
            ], 200);
        }
        
        return response()->json([
            'status' => 'success',
            'message' => 'Login berhasil',
            'data' => $user
        ], 200);
    }

    /**
     * @param Request $request
     * @return \Illuminate\Http\JsonResponse
     * @throws \Exception
     */
    public function register(Request $request){
        $validator = Validator::make($request->all(), [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required']
        ]);

        if($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        } else {
            $token = Str::random(32);

            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                'balance' => 1000000,
                'token' => $token
            ]);

            $user = User::where('email', $request->email)->first();
            
            // Mail::send('email.emailVerificationEmail', ['name' => $user->name, 'id' => $user->id, 'token' => $token], function($message) use($request){
            //     $message->to($request->email);
            //     $message->subject('Konfirmasi Alamat E-mail');
            // });

            Mail::to($user->email)->send(new EmailVerification('Konfirmasi Alamat E-mail', $user->name, $user->id, $user->token));

            return response()->json([
                'status' => 'success',
                'message' => 'Pendaftaran Berhasil',
                'data' => $user
            ], 200);
        }
    }

    public function updateBalance(Request $request){

        User::where('id', $request->id)->update(['balance' => $request->nominal]);

        $user = User::find($request->id);
        return response()->json([
            'status' => 'success',
            'message' => 'Data saldo berhasil diupdate',
            'data' => [
                'balance' => $user->balance
            ] 
        ], 200);
    }

    public function getBalance(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        }

        $user = User::find($request->id);

        return response()->json([
            'status' => 'success',
            'message' => 'Data saldo berhasil',
            'data' => [
                'balance' => $user->balance
            ] 
        ], 200);
    }

    public function getUser($id){
        $user = User::find($id);

        if($user!=null){
            return response()->json([
                'status' => 'success',
                'message' => 'Data user ditemukan',
                'data' => $user
            ], 200);
        }

        return response()->json([
            'status' => 'error',
            'message' => 'User tidak ditemukan'
        ], 200);
    }

    public function updateUser(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:users,id',
            'name' => 'required|string',
            'email' => 'required|unique:users,email,'.$request->id,
            'password' => 'nullable'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first()
            ], 200);
        }

        try{
            $user = User::find($request->id);
            $user->name = $request->name;
            $user->email = $request->email;
            if($request->has('password') && $request->password != ""){
                $user->password = Hash::make($request->password);
            }
            $user->save();

            
            return response()->json([
                'status' => 'success',
                'message' => 'Data user berhasil diperbarui',
                'data' => $user
            ], 200);
        }catch (Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage()
            ], 200);
        }
    }
}
