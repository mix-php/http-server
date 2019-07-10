<?php

namespace Mix\Http\Server\Middleware;

use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Interface MiddlewareInterface
 * @package Mix\Http\Server\Middleware
 * @author liu,jian <coder.keda@gmail.com>
 */
interface MiddlewareInterface extends \Psr\Http\Server\MiddlewareInterface
{

    /**
     * MiddlewareInterface constructor.
     * @param ServerRequestInterface $request
     * @param ResponseInterface $response
     */
    public function __construct(ServerRequestInterface $request, ResponseInterface $response);

}
