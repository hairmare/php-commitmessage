<?php

/**
 * 
 */
class CommitMessage_HandlerStack extends ArrayObject
{
    private $_caller = false;
    private $_factory = false;
    public function setCaller($caller)
    {
        if ($this->_caller) {
            throw new RuntimeException('You may not override the caller');
        }
        $this->_caller = $caller;
    }
    public function getCaller()
    {
        return $this->_caller;
    }
    public function setFactory($factory)
    {
        $this->_factory = $factory;
    }
    public function run()
    {
        foreach ($this AS $handler) {
            $handler->run();
        }
    }
    public function append($data)
    {
        $data->setCaller($this);
        $data->setFactory($this->_factory);
        return parent::append($data);
    }
}


