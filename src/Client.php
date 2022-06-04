<?php

declare(strict_types=1);

namespace Metapp\Reporta;

final class Client
{
    /**
     * @var Project $project
     */
    public static $project;

    public static function init(Project $project){
        self::setProject($project);
        return self::getProject();
    }

    /**
     * @return Project
     */
    public static function getProject()
    {
        return self::$project;
    }

    /**
     * @param Project $project
     */
    public static function setProject($project)
    {
        self::$project = $project;
    }
}