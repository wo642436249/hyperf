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

namespace Hyperf\Cache\Annotation;

use Hyperf\Cache\CacheListenerCollector;
use Hyperf\Di\Annotation\AbstractAnnotation;
use Hyperf\Di\Annotation\AnnotationCollector;

/**
 * @Annotation
 * @Target({"METHOD"})
 */
class Cacheable extends AbstractAnnotation
{
    public $prefix;

    public $value;

    public $ttl;

    public $listener;

    public $group = 'default';

    public $collect = false;

    public function collectMethod(string $className, ?string $target): void
    {
        if (isset($this->listener)) {
            CacheListenerCollector::set($this->listener, [
                'className' => $className,
                'method' => $target,
            ]);
        }

        AnnotationCollector::collectMethod($className, $target, static::class, $this);
    }
}
