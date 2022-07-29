<?php

namespace Xyu\TtApp;

use Xyu\TtApp\Contract\AbstractGateway;

/**
 * 模版订阅消息
 * class TempMsg
 */
class TempMsg extends AbstractGateway
{
    /**
     * 抖音小程序订阅消息
     * @param string $openId
     * @param string $tempId
     * @param array $data
     * @param string $page
     * @return mixed
     */
    public function notify(string $openId, string $tempId, array $data, string $page = null)
    {
        return json_decode((string)$this->app->http->json('https://developer.toutiao.com/api/apps/subscribe_notification/developer/v1/notify', [
            'access_token' => $this->app->access_token->get_lock_token(),
            'app_id' => $this->app->getAppId(),
            'tpl_id' => $tempId,
            'open_id' => $openId,
            'page' => $page,
            'data' => $data,
        ])->getBody(), true);
    }

    /**
     * 发送模版消息 (今日头条支持)
     * @param string $to
     * @param string $tempId
     * @param string $formId
     * @param array $data
     * @param string $page
     * @return mixed
     */
    public function send(string $to, string $tempId, string $formId, array $data, string $page = null)
    {
        return json_decode((string)$this->app->http->json('https://developer.toutiao.com/api/apps/game/template/send', [
            'access_token' => $this->app->access_token->get_lock_token(),
            'touser' => $to,
            'template_id' => $tempId,
            'page' => $page,
            'form_id' => $formId,
            'data' => $data,
        ])->getBody(), true);
    }
}