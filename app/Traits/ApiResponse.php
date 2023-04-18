<?php 

namespace App\Traits; 
/**
 * 
 */
trait ApiResponse{
    public function result_ok($message , $status=false, $token=null, $data=[]){
       return response()->json([
            'message' => $message,
            'status' => $status,
            'token' => $token,
            'data' => $data
       ],201);
    }

    public function result_fail($message , $status=false,$token=null,$data=[]){
        return response()->json([
            'message' => $message,
            'status' => $status,
            'token'  => $token,
            'data'  => $data
        ],400);
    }
}
