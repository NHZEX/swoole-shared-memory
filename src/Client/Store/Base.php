<?php
namespace Yurun\Swoole\SharedMemory\Client\Store;

use Yurun\Swoole\SharedMemory\Interfaces\IKV;
use Yurun\Swoole\SharedMemory\Interfaces\IClient;

abstract class Base
{
    /**
     * 客户端
     *
     * @var \Yurun\Swoole\SharedMemory\Interfaces\IClient
     */
    private $client;

    public function __construct(IClient $client)
    {
        $this->client = $client;
    }

    /**
     * 执行调用
     *
     * @param \Yurun\Swoole\SharedMemory\Message\Operation $operation
     * @return mixed
     */
    protected function doCall($operation)
    {
        $this->client->send($operation);
        $result = $this->client->recv();
        if(false === $result)
        {
            return false;
        }
        if(null === $result->throwable)
        {
            return $result->result;
        }
        else
        {
            throw $result->throwable;
        }
    }

    /**
     * Get 客户端
     *
     * @return \Yurun\Swoole\SharedMemory\Client\Client
     */ 
    public function getClient()
    {
        return $this->client;
    }

    /**
     * Set 客户端
     *
     * @param \Yurun\Swoole\SharedMemory\Interfaces\IClient $client 客户端
     *
     * @return self
     */ 
    public function setClient(IClient $client)
    {
        $this->client = $client;

        return $this;
    }
}