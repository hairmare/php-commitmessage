<?php

/**
 * 
 */
class CommitMessage_HandlerStack extends ArrayObject
{
    private $_caller = false;
    public function setCaller($caller)
    {
        if ($this->_caller) {
            throw new Exception('You may not override the caller');
        }
        $this->_caller = $caller;
    }
    public function getCaller()
    {
        return $this->_caller;
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
        return parent::append($data);
    }
}


