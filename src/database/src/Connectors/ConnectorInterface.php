<?php

declare(strict_types=1);
/**
 * This file is part of Hyperf.
 *
 * @link     https://hyperf.org
 * @document https://wiki.hyperf.org
 * @contact  group@hyperf.org
 * @license  https://github.com/hyperf-cloud/hyperf/blob/master/LICENSE
 */

namespace Hyperf\Database\Connectors;

interface ConnectorInterface
{
    /**
     * Establish a database connection.
     *
     * @return \PDO
     */
    public function connect(array $config);
}