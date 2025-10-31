<?php

declare(strict_types=1);

namespace Tourze\PHPUnitBase;

/**
 * 测试辅助工具类
 */
class TestHelper
{
    /**
     * 生成测试用的临时目录
     *
     * @param string $testClass 测试类名
     * @param array<string> $bundles Bundle 列表
     * @param array<mixed> $options 配置选项
     * @param array<string, string> $entityMappings 实体映射
     * @return string 临时目录路径
     */
    public static function generateTempDir(string $testClass, array $bundles, array $options, array $entityMappings = []): string
    {
        $projectDir = '/tmp/symfony-test-'
            . explode('\\', $testClass)[0]
            . md5(serialize([$bundles, $options, $entityMappings]));

        if (!is_dir($projectDir)) {
            mkdir($projectDir, 0o777, true);
            file_put_contents($projectDir . '/test.json', json_encode([
                'bundles' => $bundles,
                'options' => $options,
                'entityMappings' => $entityMappings,
            ], JSON_PRETTY_PRINT | JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE));
        }

        return $projectDir;
    }
}
