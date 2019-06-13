<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://hyperf.io
 * @document https://doc.hyperf.io
 * @contact  group@hyperf.io
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace Hyperf\Rpc;

class RequestIdGenerator
{
    public function generate(): int
    {
        $us = strstr(microtime(), ' ', true);
        return intval(strval($us * 1000 * 1000) . rand(100, 999));
    }
}