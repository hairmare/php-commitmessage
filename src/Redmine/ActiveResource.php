<?php

class Redmine_ActiveResource extends ActiveResource
{
    public function __construct()
    {
        $this->request_format = 'xml';
        
        $iniData = parse_ini_file(__DIR__.'/../../localConfig.ini');
        $this->setSite($iniData['redmine.site']);
    }
    public function setSite($site)
    {
        $this->site = $site;
    }
}

