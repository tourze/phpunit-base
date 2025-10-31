<?php

declare(strict_types=1);

namespace Tourze\PHPUnitBase\Tests;

use PHPUnit\Framework\Attributes\CoversClass;
use PHPUnit\Framework\Attributes\Test;
use PHPUnit\Framework\TestCase;
use Tourze\PHPUnitBase\TestHelper;

/**
 * @internal
 */
#[CoversClass(TestHelper::class)]
class TestHelperTest extends TestCase
{
    #[Test]
    public function testGenerateTempDir(): void
    {
        $testClass = 'TestDemo';
        $bundles = ['TestBundle'];
        $options = ['debug' => true];
        $entityMappings = ['User' => 'TestBundle\Entity\User'];

        $tempDir = TestHelper::generateTempDir($testClass, $bundles, $options, $entityMappings);

        // 验证目录已创建
        $this->assertTrue(is_dir($tempDir));

        // 验证配置文件已创建
        $configFile = $tempDir . '/test.json';
        $this->assertFileExists($configFile);

        // 验证配置内容
        $configContent = file_get_contents($configFile);
        $this->assertIsString($configContent, 'Config file content should be a string');
        $config = json_decode($configContent, true);
        $this->assertIsArray($config, 'JSON config should be parsed as array');
        $this->assertSame($bundles, $config['bundles']);
        $this->assertSame($options, $config['options']);
        $this->assertSame($entityMappings, $config['entityMappings']);

        // 清理测试目录
        rmdir($tempDir);
    }

    #[Test]
    public function testGenerateTempDirWithSameParametersReturnsSameDir(): void
    {
        $testClass = 'TestDemo';
        $bundles = ['TestBundle'];
        $options = ['debug' => true];
        $entityMappings = [];

        $tempDir1 = TestHelper::generateTempDir($testClass, $bundles, $options, $entityMappings);
        $tempDir2 = TestHelper::generateTempDir($testClass, $bundles, $options, $entityMappings);

        $this->assertSame($tempDir1, $tempDir2);

        // 清理测试目录
        if (is_dir($tempDir1)) {
            rmdir($tempDir1);
        }
    }

    #[Test]
    public function testGenerateTempDirWithDifferentParametersReturnsDifferentDirs(): void
    {
        $testClass = 'TestDemo';
        $bundles = ['TestBundle'];
        $options = ['debug' => true];
        $entityMappings = [];

        $tempDir1 = TestHelper::generateTempDir($testClass, $bundles, $options, $entityMappings);

        // 使用不同的options
        $differentOptions = ['debug' => false];
        $tempDir2 = TestHelper::generateTempDir($testClass, $bundles, $differentOptions, $entityMappings);

        $this->assertNotSame($tempDir1, $tempDir2);

        // 清理测试目录
        if (is_dir($tempDir1)) {
            rmdir($tempDir1);
        }
        if (is_dir($tempDir2)) {
            rmdir($tempDir2);
        }
    }

    #[Test]
    public function testGenerateTempDirCreatesJsonConfig(): void
    {
        $testClass = 'MyTest';
        $bundles = ['AppBundle', 'UserBundle'];
        $options = ['env' => 'test', 'debug' => false];
        $entityMappings = ['User' => 'AppBundle\Entity\User', 'Product' => 'AppBundle\Entity\Product'];

        $tempDir = TestHelper::generateTempDir($testClass, $bundles, $options, $entityMappings);

        $configFile = $tempDir . '/test.json';
        $this->assertFileExists($configFile);

        $configContent = file_get_contents($configFile);
        $this->assertIsString($configContent, 'Config file content should be a string');
        $config = json_decode($configContent, true);
        $this->assertIsArray($config, 'JSON config should be parsed as array');

        // 验证JSON格式正确（包括JSON_PRETTY_PRINT）
        $this->assertJson($configContent);
        $this->assertStringContainsString("\n", $configContent); // 确认格式化

        $this->assertSame($bundles, $config['bundles']);
        $this->assertSame($options, $config['options']);
        $this->assertSame($entityMappings, $config['entityMappings']);

        // 清理测试目录
        rmdir($tempDir);
    }
}