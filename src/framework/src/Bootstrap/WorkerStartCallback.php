<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://www.hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace Hyperf\Framework\Bootstrap;

use Hyperf\Contract\StdoutLoggerInterface;
use Hyperf\Di\Container;
use Hyperf\Framework\Event\AfterWorkerStart;
use Hyperf\Framework\Event\BeforeWorkerStart;
use Hyperf\Framework\Event\MainWorkerStart;
use Hyperf\Framework\Event\OtherWorkerStart;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Swoole\Server as SwooleServer;

class WorkerStartCallback
{
    /**
     * @var Container
     */
    private $container;

    /**
     * @var StdoutLoggerInterface
     */
    private $logger;

    /**
     * @var EventDispatcherInterface
     */
    private $eventDispatcher;

    public function __construct(ContainerInterface $container, StdoutLoggerInterface $logger, EventDispatcherInterface $eventDispatcher)
    {
        $this->container = $container;
        $this->logger = $logger;
        $this->eventDispatcher = $eventDispatcher;
    }

    /**
     * Handle Swoole onWorkerStart event.
     */
    public function onWorkerStart(SwooleServer $server, int $workerId)
    {
        $this->eventDispatcher->dispatch(new BeforeWorkerStart($server, $workerId));

        if ($workerId === 0) {
            $this->eventDispatcher->dispatch(new MainWorkerStart($server, $workerId));
        } else {
            $this->eventDispatcher->dispatch(new OtherWorkerStart($server, $workerId));
        }

        $this->logger->info("Worker#{$workerId} started.");

        $this->eventDispatcher->dispatch(new AfterWorkerStart($server, $workerId));
    }
}
