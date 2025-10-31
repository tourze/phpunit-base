<?php

declare(strict_types=1);

namespace Tourze\PHPUnitBase;

use PHPUnit\Framework\Attributes\CoversClass;

class TestCaseHelper
{
    public static function isTestClass(string $className): bool
    {
        // 检查命名空间是否包含 Tests
        if (str_contains($className, '\Tests\\')) {
            return true;
        }

        // 检查类名是否以 Test 或 TestCase 结尾
        if (str_ends_with($className, 'Test') || str_ends_with($className, 'TestCase')) {
            return true;
        }

        // 检查是否在测试相关的命名空间
        $testNamespaces = [
            'PHPUnit\\',
            'Tests\\',
            'Test\\',
        ];

        foreach ($testNamespaces as $namespace) {
            if (str_starts_with($className, $namespace)) {
                return true;
            }
        }

        return false;
    }

    /**
     * @param \ReflectionClass<object> $classReflection
     */
    public static function extractCoverClass(\ReflectionClass $classReflection): ?string
    {
        foreach ($classReflection->getAttributes(CoversClass::class) as $attribute) {
            $attribute = $attribute->newInstance();

            /** @var CoversClass $attribute */
            return $attribute->className();
        }

        return null;
    }
}
