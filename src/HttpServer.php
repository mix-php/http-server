<?php

namespace Mix\Http\Server;

use Co\Http\Server;
use Mix\Bean\BeanInjector;
use Mix\Console\Error;

/**
 * Class HttpServer
 * @package Mix\Http\Server
 * @author liu,jian <coder.keda@gmail.com>
 */
class HttpServer extends Server
{

    /**
     * @var string
     */
    public $host = '127.0.0.1';

    /**
     * @var int
     */
    public $port = 9501;

    /**
     * @var bool
     */
    public $ssl = false;

    /**
     * @var Server
     */
    public $swooleServer;

    /**
     * HttpServer constructor.
     * @param array $config
     * @throws \PhpDocReader\AnnotationException
     * @throws \ReflectionException
     */
    public function __construct(array $config)
    {
        BeanInjector::inject($this, $config);
    }

    /**
     * set
     * @param array $options
     */
    public function set(array $options)
    {
        return $this->swooleServer->set($options);
    }

    /**
     * handle
     * @param string $pattern
     * @param callable $callback
     */
    public function handle(string $pattern, callable $callback)
    {
        return $this->swooleServer->handle(
            $pattern,
            function () use ($callback) {
                try {
                    call_user_func($callback);
                } catch (\Throwable $e) {
                    $isMix = class_exists(\Mix::class);
                    // 错误处理
                    if (!$isMix) {
                        throw $e;
                    }
                    // Mix错误处理
                    /** @var Error $error */
                    $error = \Mix::$app->get('error');
                    $error->handleException($e);
                }
            }
        );
    }

    /**
     * start
     */
    public function start()
    {
        return $this->swooleServer->start();
    }

    /**
     * shutdown
     */
    public function shutdown()
    {
        return $this->swooleServer->shutdown();
    }

}
