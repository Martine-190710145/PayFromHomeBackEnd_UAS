<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class TransactionController extends Controller
{
    public function index(Request $request){
        $validator = Validator::make($request->all(), [
            'user_id' => 'required'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => 'user_id tidak ada',                
                
            ], 200);
        }

        $user = User::find($request->user_id);

        if ($user==null){
            return response()->json([
                'status' => 'error',
                'message' => 'User tidak ditemukan',
                
            ], 200);
        }

        return response()->json([
            'status' => 'success',
            'message' => 'Data Semua Transaksi',
            'data' => Transaction::where('user_id', $request->user_id)->get()
        ], 200);
    }

    public function create(Request $request){
        $validator = Validator::make($request->all(), [
            'type' => 'required|string',
            'serial_id' => 'required|string',
            'nominal' => 'required|string',
            'payment' => 'required|string',
            'date' => 'required|string',
            'user_id' => 'required|exists:users,id'
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
                
            ], 200);
        }

        $user = User::find($request->user_id);

        if ($request->payment == "transfer"){
            try{
                Transaction::create([
                    'type' => $request->type,
                    'serial_id' => $request->serial_id,
                    'nominal' => $request->nominal,
                    'payment' => $request->payment,
                    'date' => $request->date,
                    'user_id' => $request->user_id
                ]);

                return response()->json([
                    'status' => 'success',
                    'message' => 'Transaksi berhasil ditambahkan',
                    
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    
                ], 200);
            }
        }

        if ($request->payment == "balance"){
            if ($request->nominal > $user->balance){
                return response()->json([
                    'status' => 'error',
                    'message' => 'Saldo tidak mencukupi',
                    
                ], 200);
            }

            try{
                Transaction::create([
                    'type' => $request->type,
                    'serial_id' => $request->serial_id,
                    'nominal' => $request->nominal,
                    'payment' => $request->payment,
                    'date' => $request->date,
                    'user_id' => $request->user_id
                ]);

                $user->balance = $user->balance - $request->nominal;
                $user->save();

                return response()->json([
                    'status' => 'success',
                    'message' => 'Transaksi berhasil ditambahkan',
                    
                ], 200);
            } catch (Exception $e) {
                return response()->json([
                    'status' => 'error',
                    'message' => $e->getMessage(),
                    
                ], 200);
            }

            
        }
    }

    public function destroy(Request $request){
        $validator = Validator::make($request->all(), [
            'id' => 'required|exists:transactions,id',
        ]);

        if ($validator->fails()){
            return response()->json([
                'status' => 'error',
                'message' => $validator->errors()->first(),
            ], 200);
        }

        try{
            Transaction::where('id', $request->id)->delete();

            return response()->json([
                'status' => 'success',
                'message' => 'Data transaksi berhasil dihapus'
            ], 200);
        } catch(Exception $e){
            return response()->json([
                'status' => 'error',
                'message' => $e->getMessage(),
            ], 200);
        }
    }
}
