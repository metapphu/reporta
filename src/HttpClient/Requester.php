<?php

declare(strict_types=1);

namespace Metapp\Reporta\HttpClient;

use Curl\Curl;
use Metapp\Reporta\Project;

class Requester
{
    /**
     * @var Project
     */
    private $project;

    public function __construct(Project $project)
    {
        $this->project = $project;
    }

    /**
     * @return boolean
     */
    public function fetchProject()
    {
        $response = $this->call('projects/fetch');
        if ($response["status"] === 200) {
            return true;
        }
        return false;
    }

    public function sendException($params)
    {
        $this->call('projects/exception',$params);
    }

    /**
     * @param $endpoint
     * @return array
     */
    private function call($endpoint,$params = array())
    {
        $curl = new Curl();
        $curl->setHeader('X-Reporta-SecretKey', $this->project->getSecretKey());
        $curl->setHeader('X-Reporta-ProjectKey', $this->project->getProjectKey());
        $curl->setDefaultJsonDecoder($assoc = true);
        $curl->post(Config::getBaseEndpointUrl() . '/' . $endpoint,$params);
        return $curl->response;
    }
}