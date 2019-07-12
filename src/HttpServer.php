<?php

namespace Mix\Http\Server;

use Mix\Bean\BeanInjector;
use Mix\Http\Message\Factory\ResponseFactory;
use Mix\Http\Message\Factory\ServerRequestFactory;

/**
 * Class HttpServer
 * @package Mix\Http\Server
 * @author liu,jian <coder.keda@gmail.com>
 */
class HttpServer
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
     * @param string $host
     * @param int $port
     * @param bool $ssl
     */
    public function __construct(string $host, int $port, bool $ssl)
    {
        $this->host         = $host;
        $this->port         = $port;
        $this->ssl          = $ssl;
        $this->swooleServer = new \Swoole\Coroutine\Http\Server($host, $port, $ssl);
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
            function (\Swoole\Http\Request $req, \Swoole\Http\Response $resp) use ($callback) {
                try {
                    // 生成psr的rep,res
                    $request  = (new ServerRequestFactory)->createServerRequestFromSwoole($req);
                    $response = (new ResponseFactory)->createResponseFromSwoole($resp);
                    // 执行回调
                    call_user_func($callback, $request, $response);
                } catch (\Throwable $e) {
                    $isMix = class_exists(\Mix::class) && class_exists(\Mix\Console\Error::class);
                    // 错误处理
                    if (!$isMix) {
                        throw $e;
                    }
                    // Mix错误处理
                    /** @var \Mix\Console\Error $error */
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
