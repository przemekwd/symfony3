<?php

namespace GamesBundle\Service;

class DeveloperLogoUploader extends FileUploader
{
    public function __construct($targetDir)
    {
        parent::__construct($targetDir);
    }
}