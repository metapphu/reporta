<?php

declare(strict_types=1);

namespace Metapp\Reporta;

function init(Project $config)
{
    Client::init($config)->validate();
}

function captureException(\Exception $exception)
{
    Client::getProject()->exceptionHandler($exception);
}