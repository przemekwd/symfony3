<?php

namespace GamesBundle\Service;

class GameCoverUploader extends FileUploader
{
    public function __construct($targetDir)
    {
        parent::__construct($targetDir);
    }
}