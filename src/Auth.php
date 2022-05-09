<?php

namespace Xyu\TtApp;

use Xyu\TtApp\Exception\TtAppException;

/**
 * 登陆
 * Class Auth
 */
class Auth
{
    const CODE = 'code';
    const ANONYMOUS_CODE = 'anonymous_code';

    protected $app;

    public function __construct(TtApp $ttApp)
    {
        $this->app = $ttApp;
    }

    /**
     * @param string $code
     * @param string $type code或者anonymous_code
     * @return array
     * @throws
     */
    public function session(string $code, $type = Auth::CODE)
    {
        if (!in_array($type, $limit = [Auth::ANONYMOUS_CODE, Auth::CODE])) {
            throw new TtAppException('type 只能是 ' . implode('或者', $limit));
        }

        return json_decode((string)$this->app->http->json('https://developer.toutiao.com/api/apps/v2/jscode2session', [
            'appid' => $this->app->getAppId(),
            'secret' => $this->app->getAppSecret(),
            $type => $code,
        ])->getBody(), true);
    }
}