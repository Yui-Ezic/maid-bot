<?php

declare(strict_types=1);

namespace Test\Mock\Vk;

use Test\Mock\ExpectableTrait;
use Test\Mock\Invocation;
use VK\Client\VKApiRequest;

class VkApiRequestMock extends VKApiRequest
{
    use ExpectableTrait;

    private const HOST = '';

    private mixed $postReturn;
    private mixed $uploadReturn;

    public function __construct(string $api_version, ?string $language = null)
    {
        parent::__construct($api_version, $language, self::HOST);
    }

    public function post(string $method, string $access_token, array $params = [])
    {
        $this->addInvocation(new Invocation(__FUNCTION__, [
            'method' => $method,
            'access_token' => $access_token,
            'params' => $params,
        ]));
        return $this->postReturn;
    }

    public function setPostReturn(mixed $value): self
    {
        $this->postReturn = $value;
        return $this;
    }

    public function upload(string $upload_url, string $parameter_name, string $path)
    {
        $this->addInvocation(new Invocation(__FUNCTION__, [
            'upload_url' => $upload_url,
            'parameter_name' => $parameter_name,
            'path' => $path,
        ]));
        return $this->uploadReturn;
    }

    public function setUploadReturn(mixed $value): self
    {
        $this->uploadReturn = $value;
        return $this;
    }
}
