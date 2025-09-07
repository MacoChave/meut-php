<?php

namespace Config;

use Monolog\Formatter\LineFormatter;
use Monolog\Handler\RotatingFileHandler;
use Monolog\Handler\StreamHandler;
use Monolog\Logger;
use Monolog\Processor\UidProcessor;
use Monolog\Processor\WebProcessor;

class LoggerConfig
{
    private static ?Logger $logger = null;

    public static function getInstance(): Logger
    {
        if (self::$logger === null) {
            self::$logger = self::createLogger();
        }

        return self::$logger;
    }

    private static function createLogger(): Logger
    {
        $logger = new Logger('app');

        // Directorio de logs
        $logDir = __DIR__ . '/../../storage/logs';
        if (!file_exists($logDir)) {
            mkdir($logDir, 0755, true);
        }

        // Formato personalizado
        $formatter = new LineFormatter(
            "[%datetime%] %channel%.%level_name%: %message% %context% %extra%\n",
            'Y-m-d H:i:s'
        );

        // Handler para logs generales (rotación diaria)
        $generalHandler = new RotatingFileHandler(
            $logDir . '/app.log',
            30, // Mantener 30 días
            Logger::DEBUG
        );
        $generalHandler->setFormatter($formatter);

        // Handler para errores críticos (archivo separado)
        $errorHandler = new RotatingFileHandler(
            $logDir . '/errors.log',
            90, // Mantener 90 días para errores
            Logger::ERROR
        );
        $errorHandler->setFormatter($formatter);

        // Handler para desarrollo (consola)
        if (self::isDevelopment()) {
            $consoleHandler = new StreamHandler('php//stdout', Logger::DEBUG);
            $consoleHandler->setFormatter($formatter);
            $logger->pushHandler($consoleHandler);
        }

        // Agregar handlers
        $logger->pushHandler($generalHandler);
        $logger->pushHandler($errorHandler);

        // Procesadores para contexto adicional
        $logger->pushProcessor(new UidProcessor()); // UUID para tracking
        $logger->pushProcessor(new WebProcessor()); // Info de request web

        // Procesador personalizado para usuario
        $logger->pushProcessor(function ($record) {
            $record['extra']['user_id'] = $_SESSION['uer_id'] ?? 'guest';
            $record['extra']['ip'] = $_SESSION['REMOTE_ADDR'] ?? 'unknown';
            return $record;
        });

        return $logger;
    }

    private static function isDevelopment(): bool
    {
        return (getenv('APP_ENV') ?? 'production') === 'development';
    }

    // Métodos de conveniencia
    public static function info(string $message, array $context = []): void
    {
        self::getInstance()->info($message, $context);
    }

    public static function error(string $message, array $context = []): void
    {
        self::getInstance()->error($message, $context);
    }

    public static function warning(string $message, array $context = []): void
    {
        self::getInstance()->warning($message, $context);
    }

    public static function debug(string $message, array $context = []): void
    {
        self::getInstance()->debug($message, $context);
    }

    public static function critical(string $message, array $context = []): void
    {
        self::getInstance()->critical($message, $context);
    }
}
