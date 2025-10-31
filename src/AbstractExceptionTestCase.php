<?php

declare(strict_types=1);

namespace Tourze\PHPUnitBase;

use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;

abstract class AbstractExceptionTestCase extends TestCase
{
    /**
     * 这个场景，没必要使用 RunTestsInSeparateProcesses 注解的
     */
    #[Test]
    final public function testShouldNotHaveRunTestsInSeparateProcesses(): void
    {
        $reflection = new \ReflectionClass($this);
        $this->assertEmpty(
            $reflection->getAttributes(RunTestsInSeparateProcesses::class),
            get_class($this) . '这个测试用例，不应使用 RunTestsInSeparateProcesses 注解'
        );
    }
}
