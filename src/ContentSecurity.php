<?php

namespace Xyu\TtApp;

use GuzzleHttp\RequestOptions;

/**
 * 内容安全
 * class ContentSecurity
 */
class ContentSecurity
{
    protected $app;

    public function __construct(TtApp $ttApp)
    {
        $this->app = $ttApp;
    }

    /**
     * 检测一段文本是否包含违法违规内容
     * @param array $contents
     * @return mixed
     */
    public function text(array $contents)
    {
        return json_decode((string)$this->app->http->request('POST', 'https://developer.toutiao.com/api/v2/tags/text/antidirt', [
            RequestOptions::HEADERS => [
                'X-Token' => $this->app->access_token->getToken(),
            ],
            RequestOptions::JSON => [
                'tasks' => array_map(function ($content) {
                    return compact('content');
                }, $contents)
            ]
        ])->getBody(), true);
    }

    /**
     * 检测图片是否包含违法违规内容
     * @param array $images
     * @param array $targets
     * @return mixed
     */
    public function image(array $images, array $targets)
    {
        return json_decode((string)$this->app->http->request('POST', 'https://developer.toutiao.com/api/apps/censor/image', [
            RequestOptions::HEADERS => [
                'X-Token' => $this->app->access_token->getToken(),
            ],
            RequestOptions::JSON => [
                'tasks' => array_map(function ($image) {
                    return compact('image');
                }, $images),
                'targets' => $targets,
            ]
        ])->getBody(), true);
    }
}