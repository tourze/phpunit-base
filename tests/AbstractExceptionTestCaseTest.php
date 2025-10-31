<?php

declare(strict_types=1);

namespace Tourze\PHPUnitBase\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\RunTestsInSeparateProcesses;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tourze\PHPUnitBase\AbstractExceptionTestCase;

/**
 * @internal
 */
#[CoversClass(AbstractExceptionTestCase::class)]
class AbstractExceptionTestCaseTest extends TestCase
{
    #[Test]
    public function testAbstractExceptionTestCaseDoesNotHaveRunTestsInSeparateProcesses(): void
    {
        // 直接检查 AbstractExceptionTestCase 类本身没有 RunTestsInSeparateProcesses 属性
        $reflection = new \ReflectionClass(AbstractExceptionTestCase::class);
        $attributes = $reflection->getAttributes(RunTestsInSeparateProcesses::class);

        $this->assertEmpty($attributes, 'AbstractExceptionTestCase不应该有RunTestsInSeparateProcesses属性');
    }

    #[Test]
    public function testAbstractExceptionTestCaseHasCorrectTestMethod(): void
    {
        // 验证 AbstractExceptionTestCase 确实有 testShouldNotHaveRunTestsInSeparateProcesses 方法
        $reflection = new \ReflectionClass(AbstractExceptionTestCase::class);
        $this->assertTrue(
            $reflection->hasMethod('testShouldNotHaveRunTestsInSeparateProcesses'),
            'AbstractExceptionTestCase应该包含testShouldNotHaveRunTestsInSeparateProcesses方法'
        );
    }

    #[Test]
    public function testAbstractExceptionTestCaseTestMethodIsFinal(): void
    {
        // 验证 testShouldNotHaveRunTestsInSeparateProcesses 方法是 final 的
        $reflection = new \ReflectionClass(AbstractExceptionTestCase::class);
        $method = $reflection->getMethod('testShouldNotHaveRunTestsInSeparateProcesses');

        $this->assertTrue($method->isFinal(), 'testShouldNotHaveRunTestsInSeparateProcesses方法应该是final的');
    }

    #[Test]
    public function testAbstractExceptionTestCaseExtendsTestCase(): void
    {
        // 验证 AbstractExceptionTestCase 继承自 TestCase
        $reflection = new \ReflectionClass(AbstractExceptionTestCase::class);

        $this->assertTrue($reflection->isSubclassOf(TestCase::class));
        $this->assertTrue($reflection->isAbstract());
    }

    #[Test]
    public function testAbstractExceptionTestCaseTestMethodHasTestAttribute(): void
    {
        // 验证 testShouldNotHaveRunTestsInSeparateProcesses 方法有 #[Test] 属性
        $reflection = new \ReflectionClass(AbstractExceptionTestCase::class);
        $method = $reflection->getMethod('testShouldNotHaveRunTestsInSeparateProcesses');

        $testAttributes = $method->getAttributes(Test::class);
        $this->assertNotEmpty($testAttributes, 'testShouldNotHaveRunTestsInSeparateProcesses方法应该有#[Test]属性');
    }

    #[Test]
    public function testAbstractExceptionTestCaseTestMethodIsPublic(): void
    {
        // 验证 testShouldNotHaveRunTestsInSeparateProcesses 方法是 public 的
        $reflection = new \ReflectionClass(AbstractExceptionTestCase::class);
        $method = $reflection->getMethod('testShouldNotHaveRunTestsInSeparateProcesses');

        $this->assertTrue($method->isPublic(), 'testShouldNotHaveRunTestsInSeparateProcesses方法应该是public的');
    }

    #[Test]
    public function testAbstractExceptionTestCaseHasCorrectNamespace(): void
    {
        // 验证命名空间正确
        $reflection = new \ReflectionClass(AbstractExceptionTestCase::class);

        $this->assertSame('Tourze\PHPUnitBase', $reflection->getNamespaceName());
    }
}
