<?php

class Redmine_ActiveResource extends ActiveResource
{
    public function __construct()
    {
        $this->request_format = 'xml';
    }
    public function setSite($site)
    {
        $this->site = $site;
    }
    var $site = 'http://b3126476278c49215556ed00592bd331bb8e65d3:@192.168.1.109:3000/';
}

