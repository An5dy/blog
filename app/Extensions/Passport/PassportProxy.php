<?php

namespace App\Extensions\Passport;

use GuzzleHttp\Client;
use Illuminate\Contracts\Support\Arrayable;

class PassportProxy implements Arrayable
{
    /**
     * 响应数组
     *
     * @var array
     */
    protected $attributes = [];

    /**
     * GuzzleHttp 请求客户端
     *
     * @return \GuzzleHttp\Client
     */
    public function newHttpClient(): Client
    {
        return new Client();
    }

    /**
     * 获取令牌
     *
     * @param array $data
     * @param string $scope
     * @return array
     */
    public function passwordTokens(array $data, $scope = '*')
    {
        $formData = array_merge($data, [
            'client_id' => config('api.passport.password_client_id'),
            'client_secret' => config('api.passport.password_client_secret'),
            'scope' => $scope,
            'grant_type' => 'password',
        ]);

        return $this->post($formData);
    }

    /**
     * 刷新令牌
     *
     * @param array $data
     * @param string $scope
     * @return array
     */
    public function refreshPasswordTokens(array $data, $scope = '*')
    {
        $formData = array_merge($data, [
            'client_id' => config('api.passport.password_client_id'),
            'client_secret' => config('api.passport.password_client_secret'),
            'scope' => $scope,
            'grant_type' => 'refresh_token',
        ]);

        return $this->post($formData);
    }

    /**
     * 返回请求数据
     *
     * @param $data
     * @return PassportProxy
     */
    public function post($data): self
    {
        $response = $this->newHttpClient()->post($this->getRequestUrl(), [
            'form_params' => $data
        ]);

        $this->setAttributes(json_decode((string)$response->getBody(), true));

        return $this;
    }

    /**
     * 将 response 转为 array
     *
     * @return array
     */
    public function toArray(): array
    {
        return $this->attributes;
    }

    /**
     * 请求 url
     *
     * @return string
     */
    protected function getRequestUrl(): string
    {
        return url('oauth/token');
    }

    /**
     * @param array $attributes
     */
    protected function setAttributes(array $attributes)
    {
        $this->attributes = $attributes;
    }

    /**
     * 获取 response 值
     *
     * @param $key
     * @return mixed
     */
    protected function getAttribute($key)
    {
        return $this->attributes[$key] ?? null;
    }

    /**
     * 获取属性值
     *
     * @param $attribute
     * @return mixed
     */
    public function __get($attribute)
    {
        return $this->getAttribute($attribute);
    }
}