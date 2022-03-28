<?php

namespace Xyu\TtApp;

/**
 * 二维码
 * class QrCode
 */
class QrCode
{
    protected $app;

    public function __construct(TtApp $ttApp)
    {
        $this->app = $ttApp;
    }

    /**
     * 获取小程序/小游戏的二维码。该二维码可通过任意 app 扫码打开，能跳转到开发者指定的对应字节系 app 内拉起小程序/小游戏， 并传入开发者指定的参数。通过该接口生成的二维码，永久有效，暂无数量限制。
     * @param $params https://microapp.bytedance.com/docs/zh-CN/mini-app/develop/server/qr-code/create-qr-code
     * @return array|string
     */
    public function create(array $params = [])
    {
        $result = $this->app->http->json('https://developer.toutiao.com/api/apps/qrcode', array_merge([
            'access_token' => $this->app->access_token->getToken(),
        ], $params))->getBody();

        return json_decode((string)$result, true) ?: $result;
    }
}