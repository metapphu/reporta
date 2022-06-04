<?php

declare(strict_types=1);

namespace Metapp\Reporta\HttpClient;

class Config
{
    /**
     * @var string
     */
    const API_SCHEME = 'https://';

    /**
     * @var string
     */
    const API_HOST = 'reporter.metapp.hu';

    /**
     * @var string
     */
    const API_ENDPOINT = 'api';

    /**
     * @var string
     */
    const API_VERSION = '1.0';

    /**
     * @return string
     */
    public static function getBaseEndpointUrl()
    {
        return implode(DIRECTORY_SEPARATOR, array(self::API_SCHEME, self::API_HOST, self::API_ENDPOINT, self::API_VERSION));
    }
}