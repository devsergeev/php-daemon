<?php

declare(strict_types=1);

class Daemon
{
    private bool $run = true;

    public function __construct()
    {
        $pid = pcntl_fork();

        if ($pid == -1) {
            die('Error fork process' . PHP_EOL);
        } elseif ($pid) {
            die('Die parent process' . PHP_EOL);
        } else {
            $baseDir = dirname(__FILE__);
            ini_set('error_log',$baseDir.'/error.log');
            fclose(STDIN);
            fclose(STDOUT);
            fclose(STDERR);
            $stdin = fopen('/dev/null', 'r');
            $stdout = fopen($baseDir.'/application.log', 'ab');
            $stderr = fopen($baseDir.'/daemon.log', 'ab');

            echo "Установка обработчиков сигналов...\n";
            pcntl_signal(SIGTERM, [$this, "signalHandler"]);
            pcntl_signal(SIGTERM, [$this, "signalHandler"]);
            pcntl_signal(SIGTERM, [$this, "signalHandler"]);

            while ($this->run) {
                /*
                 * Тело демона
                 */
                $time = time();
                echo "Демон выполняет код - $time" . PHP_EOL;
                sleep(15);
                pcntl_signal_dispatch();
            }

            echo "Демон остановлен" . PHP_EOL;
        }
        /**
         * Установим дочерний процесс основным, это необходимо для создания процессов
         */
        posix_setsid();
    }

    private function signalHandler(int $signo): void
    {
        switch ($signo) {
            case SIGTERM:
                // Обработка задач остановки
                echo "Получен сигнал SIGTERM...\n";
                $this->run = false;
                break;
            case SIGHUP:
                // обработка задач перезапуска
                echo "Получен сигнал SIGHUP...\n";
                break;
            case SIGUSR1:
                echo "Получен сигнал SIGUSR1...\n";
                break;
            default:
                echo "Получен сигнал $signo...\n";
        }
    }
}
