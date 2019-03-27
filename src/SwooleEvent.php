<?php

namespace Mix\Http\Server;

/**
 * Class SwooleEvent
 * @package Mix\Http\Server
 * @author liu,jian <coder.keda@gmail.com>
 */
class SwooleEvent
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
