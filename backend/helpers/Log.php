<?php

namespace Helpers;

use Config\LoggerConfig;

class Log
{
    // Logs de aplicación
    public static function info(string $message, array $context = []): void
    {
        LoggerConfig::info($message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        LoggerConfig::error($message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        LoggerConfig::warning($message, $context);
    }

    public static function debug(string $message, array $context = []): void
    {
        LoggerConfig::debug($message, $context);
    }

    // Logs específicos para diferentes contextos
    public static function auth(string $action, string $email, bool $success = true): void
    {
        $level = $success ? 'info' : 'warning';
        self::$level("Auth: $action", [
            'email' => $email,
            'success' => $success,
            'user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'unknown'
        ]);
    }

    public static function api(string $endpoint, string $method, int $statusCode, float $duration = 0): void
    {
        $level = $statusCode >= 400 ? 'error' : 'info';
        self::$level("API: $method $endpoint", [
            'status_code' => $statusCode,
            'duration_ms' => round($duration * 1000, 2),
            'memory_usage' => self::formatBytes(memory_get_usage(true))
        ]);
    }

    public static function database(string $query, array $params = [], float $duration = 0): void
    {
        self::debug("Database Query", [
            'query' => $query,
            'params' => $params,
            'duration_ms' => round($duration * 1000, 2)
        ]);
    }

    public static function exception(\Throwable $e, string $context = ''): void
    {
        self::error("Exception: " . $e->getMessage(), [
            'context' => $context,
            'file' => $e->getFile(),
            'line' => $e->getLine(),
            'trace' => $e->getTraceAsString()
        ]);
    }

    // Helpers
    private static function formatBytes(int $bytes, int $precision = 2): string
    {
        $units = ['B', 'KB', 'MB', 'GB'];

        for ($i = 0; $bytes > 1024 && $i < count($units) - 1; $i++) {
            $bytes /= 1024;
        }

        return round($bytes, $precision) . ' ' . $units[$i];
    }
}
