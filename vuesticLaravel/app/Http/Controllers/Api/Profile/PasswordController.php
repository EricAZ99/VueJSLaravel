<?php

namespace App\Http\Controllers\Api\Profile;

use App\Customs\Services\PasswordService;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use Illuminate\Http\Request;


class PasswordController extends Controller
{
    public function __construct(private PasswordService $service){

    }
    public function changeUserPassword(ChangePasswordRequest $request){
        return $this->service->changePassword($request->validated());
    }
}
