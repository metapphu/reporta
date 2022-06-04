<?php

declare(strict_types=1);

namespace Metapp\Reporta;

use Metapp\Reporta\HttpClient\Requester;
use Metapp\Reporta\Logger\Handler;

class Project extends Handler
{
    /**
     * @var string $privateKey
     */
    private $secretKey;

    /**
     * @var string $projectKey
     */
    private $projectKey;

    /**
     * @return string
     */
    public function getSecretKey()
    {
        return $this->secretKey;
    }

    /**
     * @param string $secretKey
     * @return Project
     */
    public function setSecretKey($secretKey)
    {
        $this->secretKey = $secretKey;
        return $this;
    }

    /**
     * @return string
     */
    public function getProjectKey()
    {
        return $this->projectKey;
    }

    /**
     * @param string $projectKey
     * @return Project
     */
    public function setProjectKey($projectKey)
    {
        $this->projectKey = $projectKey;
        return $this;
    }

    /**
     * @throws \ErrorException
     */
    public function validate(){
        if (!empty($this->getProjectKey()) && !empty($this->getSecretKey())) {
            if ((new Requester($this))->fetchProject()) {
                set_error_handler(array($this, 'errorHandler'));
                set_exception_handler(array($this, 'exceptionHandler'));
                register_shutdown_function(array($this, 'shutdownException'));
            } else {
                throw new \ErrorException('Reporta failed to get informations');
            }
        } else {
            throw new \ErrorException('Reporta failed to init');
        }
    }
}