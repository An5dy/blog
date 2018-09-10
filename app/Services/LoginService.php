<?php
declare(strict_types=1);

namespace App\Services;

use DB;
use Illuminate\Http\Request;
use App\Extensions\Common\Code;
use App\Exceptions\ApiException;
use App\Extensions\Common\Message;
use Illuminate\Support\Facades\Hash;
use App\Extensions\Passport\PassportProxy;

class LoginService
{
    protected $proxy;

    /**
     * 依赖注入 PassportProxy
     *
     * LoginService constructor.
     * @param PassportProxy $proxy
     */
    public function __construct(PassportProxy $proxy)
    {
        $this->proxy = $proxy;
    }

    /**
     * 登录
     *
     * @param Request $request
     * @return \Illuminate\Support\Facades\Response
     * @throws ApiException
     */
    public function login(Request $request)
    {
        // 认证字段
        $credentials = $request->only(['username', 'password']);
        try {
            $passportProxy = $this->proxy->passwordTokens($credentials);
        } catch (\Exception $exception) {
            throw new ApiException(Message::AUTH_FAIL, Code::AUTH_FAIL);
        }

        return $this->response($passportProxy);
    }

    /**
     * 退出登录
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function logout()
    {
        DB::transaction(function () {
            $accessToken = user('api')->token();

            // 移除 refresh_token
            DB::table('oauth_refresh_tokens')
                ->where('access_token_id', optional($accessToken)->id)
                ->delete();

            optional($accessToken)->delete();// 移除 access_token
        }, 3);

        // 清除 refresh_token
        return response()->json(api_success())
            ->withCookie(cookie()->forget('admin_refresh_token'));
    }

    /**
     * 刷新令牌
     *
     * @return \Illuminate\Support\Facades\Response
     */
    public function refresh()
    {
        try {
            $passportProxy = $this->proxy->refreshPasswordTokens([
                'refresh_token' => request()->cookie('admin_refresh_token'),
            ]);
        } catch (\Exception $exception) {
            throw new ApiException(Message::OAUTH_REFRESH_FAIL, Code::OAUTH_REFRESH_FAIL);
        }

        return $this->response($passportProxy);
    }

    /**
     * 修改账号和密码
     *
     * @param Request $request
     * @return bool
     * @throws ApiException
     */
    public function update(Request $request): bool
    {
        $user = user('api');
        // 认证字段
        $credentials = ['name' => $user->name, 'password' => $request->old_password];
        // 用户密码认证
        if (auth()->guard('web')->once($credentials)) {
            // 修改账号、密码
            if ($request->filled('username')) {
                $user->name = $request->username;
            }
            if ($request->filled('new_password')) {
                $user->password = Hash::make($request->new_password);
            }

            return $user->save();
        } else {
            throw new ApiException(Message::AUTH_FAIL, Code::AUTH_FAIL);
        }
    }

    /**
     * 返回响应
     *
     * @param PassportProxy $passportProxy
     * @return \Illuminate\Support\Facades\Response
     */
    protected function response(PassportProxy $passportProxy)
    {
        return response()->json(api_success([
            'access_token' => $passportProxy->access_token,
            'expires_in' => $passportProxy->expires_in,
            'token_type' => $passportProxy->token_type,
        ]))->cookie(
            'admin_refresh_token',
            $passportProxy->refresh_token,
            config('api.passport.refresh_token_expire'),
            null,
            null,
            false,
            true
        );
    }
}