<?php

class Redmine_Issue_Api {

    private $_issue = false;
    private $_factory = false;
    public function find($id)
    {
        $this->_lazyInit();
        $this->_issue->find($id);
    }
    public function getStatusId()
    {
        return (int) $this->_issue->status['id'];
    }
    public function setFactory($factory)
    {
        $this->_factory = $factory;
    }
    private function _lazyInit()
    {
        if (!$this->_factory) {
            throw new Exception('Call setFactory() first.');
        }
        if (!$this->_issue) {
            $this->_issue = $this->_factory->create('Issue');
        }
    }

}
