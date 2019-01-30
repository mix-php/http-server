<?php

namespace Mix\Http\Server;

/**
 * Class HttpServerEvent
 * @package Mix\Http\Server
 * @author LIUJIAN <coder.keda@gmail.com>
 */
class HttpServerEvent
{

    /**
     * Start
     */
    const START = 'start';

    /**
     * ManagerStart
     */
    const MANAGER_START = 'managerStart';

    /**
     * WorkerStart
     */
    const WORKER_START = 'workerStart';

    /**
     * Request
     */
    const REQUEST = 'request';

}
