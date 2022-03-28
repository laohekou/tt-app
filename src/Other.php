<?php

namespace Xyu\TtApp;

class Other
{
    protected $app;

    public function __construct(TtApp $ttApp)
    {
        $this->app = $ttApp;
    }

    /**
     * @param string $uniqId 用户抖音号
     * @param int $type 1黑名单增加用户 2白名单增加用户 3黑名单删除用户 4白名单删除用户
     * @return mixed
     */
    public function shareName(string $uniqId, int $type = 2)
    {
        return json_decode((string)$this->app->http->json('https://developer.toutiao.com/api/apps/share_config', [
            'access_token' => $this->app->access_token->getToken(),
            'appid' => $this->app->getAppId(),
            'uniq_id' => $uniqId,
            'type' => $type,
        ])->getBody(), true);
    }

}