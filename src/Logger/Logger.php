<?php

namespace Metapp\Reporta\Logger;

use Metapp\Reporta\HttpClient\Requester;
use Metapp\Reporta\Utils\Browser;

class Logger
{
    private $browserName;

    private $browserVersion;

    private $platform;

    private $phpVersion;

    private $exceptionMessage;

    private $exceptionTrace;

    public function __construct()
    {
        $browser = new Browser();
        $this->browserName = $browser->getName();
        $this->browserVersion = $browser->getVersion();
        $this->platform = $browser->getPlatform();
        $this->phpVersion = explode('PHP/',$_SERVER["SERVER_SOFTWARE"])[1];

    }

    /**
     * @param $error
     * @return void
     */
    public function addException($error){
        if(is_array($error)){
            $this->exceptionMessage = $error["message"];
            $this->exceptionTrace = $error["trace"];
        }
        if($error instanceof \Exception){
            $this->exceptionMessage = $error->getMessage();
            $this->exceptionTrace = $error->getTrace();
        }
    }

    /**
     * @param $project
     * @return void
     */
    public function send($project){
        $exceptionTrace = array();
        if(!empty($this->exceptionTrace)){
            foreach($this->exceptionTrace as $trace) {
                $lineContent = array();
                if(!empty($trace["file"])) {
                    $file = new \SplFileObject($trace["file"]);
                    $file->setFlags($file::READ_AHEAD);
                    $lines = iterator_count($file);

                    if ($file = fopen($trace["file"], "r")) {
                        $i = 0;
                        $startLine = $trace["line"] - 5 >= 0 ? $trace["line"] - 5 : 0;
                        $endLine = $trace["line"] + 5 <= $lines ? $trace["line"] + 5 : $lines;
                        while (!feof($file)) {
                            $i++;
                            $line = fgets($file);
                            if ($i >= $startLine) {
                                $lineContent[] = array(
                                    'current' => $i == $trace["line"],
                                    'line' => $line
                                );
                                if ($i > $endLine) {
                                    break;
                                }
                            }
                        }
                        fclose($file);
                        $trace["lines"] = $lineContent;
                    }
                }
                $exceptionTrace[] = $trace;
            }
        }
        (new Requester($project))->sendException(array(
            'browser' => array('name'=>$this->browserName,'version'=>$this->browserVersion),
            'platform' => $this->platform,
            'phpVersion' => $this->phpVersion,
            'exception' => array('message'=>$this->exceptionMessage,'trace'=>$exceptionTrace),
        ));
    }

}