<?php

require_once 'src/CommitMessage/Handler/Interface.php';

/**
 *
 */
abstract class CommitMessage_Handler_Abstract
    implements CommitMessage_Handler_Interface
{
    private $_caller = false;
    public function setCaller($caller)
    {
        if ($this->_caller) {
            throw new Exception('Resetting caller is illegal');
        }
        $this->_caller = $caller;
    }
    public function getCaller()
    {
        return $this->_caller;
    }
}

