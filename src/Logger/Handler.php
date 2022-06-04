<?php

namespace Metapp\Reporta\Logger;

class Handler
{
    public function shutdownException()
    {
        $error = error_get_last();
        $logger = new Logger();
        $logger->addException($error);
        $logger->send($this);
    }

    /**
     * @param $severity
     * @param $message
     * @param $file
     * @param $line
     */
    public function errorHandler($severity, $message, $file, $line)
    {
        $logger = new Logger();
        $logger->addException(array(
            'trace' => $severity,
            'message' => $message,
        ));
        $logger->send($this);
    }

    /**
     * @param $exception
     * @return void
     */
    public function exceptionHandler($exception)
    {
        $logger = new Logger();
        $logger->addException($exception);
        $logger->send($this);
    }
}