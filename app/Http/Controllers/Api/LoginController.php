<?php

namespace App\Http\Controllers\Api;

use App\Services\LoginService;
use App\Http\Requests\LoginRequest;
use App\Http\Requests\UserUpdateRequest;

class LoginController extends ApiController
{
    protected $loginService;

    /**
     * 注入 LoginService
     *
     * LoginController constructor.
     * @param LoginService $loginService
     */
    public function __construct(LoginService $loginService)
    {
        $this->loginService = $loginService;
    }

    /**
     * 登录
     *
     * @param LoginRequest $request
     * @return \Illuminate\Support\Facades\Response
     */
    public function login(LoginRequest $request)
    {
        $response = $this->loginService->login($request);

        return $response;
    }

    /**
     * 退出登录
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function logout()
    {
        $response = $this->loginService->logout();

        return $response;
    }

    /**
     * 刷新令牌
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function refresh()
    {
        $response = $this->loginService->refresh();

        return $response;
    }

    /**
     * 修改账号和密码
     *
     * @param UserUpdateRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UserUpdateRequest $request)
    {
        $response = $this->loginService->update($request);

        return $response ? $this->successResponseWithJson() : $this->failResponseWithJson();
    }
}
