<?php

declare(strict_types=1);

namespace Tourze\PHPUnitBase\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\DataProvider;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use ReflectionClass;
use Tourze\PHPUnitBase\TestCaseHelper;

/**
 * @internal
 */
#[CoversClass(TestCaseHelper::class)]
class TestCaseHelperTest extends TestCase
{
    #[Test]
    #[DataProvider('isTestClassDataProvider')]
    public function testIsTestClass(string $className, bool $expected): void
    {
        $result = TestCaseHelper::isTestClass($className);

        $this->assertSame($expected, $result);
    }

    /**
     * @return array<array{0:string,1:bool}>
     */
    public static function isTestClassDataProvider(): array
    {
        return [
            // 包含 Tests 命名空间的类
            ['App\Tests\UserTest', true],
            ['App\Domain\Tests\ServiceTest', true],
            ['Some\Tests\Integration\DatabaseTest', true],

            // 以 Test 结尾的类
            ['UserTest', true],
            ['ServiceTest', true],
            ['DatabaseTest', true],

            // 以 TestCase 结尾的类
            ['UserTestCase', true],
            ['ServiceTestCase', true],
            ['DatabaseTestCase', true],

            // PHPUnit 命名空间
            ['PHPUnit\Framework\TestCase', true],
            ['PHPUnit\TextUI\Application', true],

            // Tests 命名空间开头
            ['Tests\Unit\UserTest', true],
            ['Tests\Integration\ServiceTest', true],

            // Test 命名空间开头
            ['Test\Unit\UserTest', true],
            ['Test\Integration\ServiceTest', true],

            // 非测试类
            ['App\Domain\User', false],
            ['App\Service\UserService', false],
            ['App\Controller\UserController', false],
            ['SomeRandomClass', false],
            ['App\Domain\UserTestHelper', false], // 包含Test但不是以Test结尾
            ['App\Domain\TestHelper', false], // 以Test开头但不是以Test结尾
        ];
    }

    #[Test]
    public function testExtractCoverClassWithCoversClassAttribute(): void
    {
        // 使用当前测试类本身，因为它有 CoversClass 属性
        $reflection = new \ReflectionClass(self::class);
        $result = TestCaseHelper::extractCoverClass($reflection);

        $this->assertSame(TestCaseHelper::class, $result);
    }

    #[Test]
    public function testExtractCoverClassWithoutCoversClassAttribute(): void
    {
        // 使用一个标准的 TestCase 类，它确实没有 CoversClass 属性
        $reflection = new \ReflectionClass(TestCase::class);
        $result = TestCaseHelper::extractCoverClass($reflection);

        $this->assertNull($result);
    }

    #[Test]
    public function testExtractCoverClassWithMultipleCoversClassAttributes(): void
    {
        // 使用当前测试类，它有一个 CoversClass 属性
        $reflection = new \ReflectionClass(self::class);
        $result = TestCaseHelper::extractCoverClass($reflection);

        // 应该返回 TestCaseHelper::class
        $this->assertSame(TestCaseHelper::class, $result);
    }

    #[Test]
    public function testExtractCoverClassWithCurrentTestClass(): void
    {
        // 测试当前测试类本身
        $reflection = new \ReflectionClass(self::class);
        $result = TestCaseHelper::extractCoverClass($reflection);

        $this->assertSame(TestCaseHelper::class, $result);
    }
}
