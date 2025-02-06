<?php

namespace App\Customs\Services;

use Illuminate\Support\Facades\Hash;

final class PasswordService
{
    private function validateCurrentPassword($current_password){
        if(!password_verify($current_password, auth()->user()->password)){
            return response()->json([
                'status'=>'failed',
                'message'=> 'Password did not match the current password'
            ])->send();
            exit;
        }
    }
    public function changePassword($data)
    {
        #password current_password

        $this->validateCurrentPassword($data['current_password']);
        $updatePassword = auth()->user()->update([
            'password' => Hash::make($data['password'])
        ]);

        if ($updatePassword) {
            return response()->json([
                'status' => 'success',
                'message' => 'Password updated successfully.'
            ]);
        } else {
            return response()->json([
                'status' => 'failed',
                'message' => 'An error occured while updating password'
            ]);
        }
    }
}
