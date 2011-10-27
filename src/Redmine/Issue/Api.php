<?php

require_once 'src/Redmine/ActiveResource.php';

class Issue extends Redmine_ActiveResource
{
}

class Redmine_Issue_Api
{
    private $_issue = false;
    private $_factory = false;

    public function find($search, $options = array())
    {
throw new Exception('boundary');
        $this->_lazyInit();
        $this->_issue->find($search, $options);
    }
    public function setFactory($factory)
    {
        $this->_factory = $factory;
    }
    public function getStatusId()
    {
        return (int) $this->_issue->status['id'];
    }
    public function setStatusId($status, $trackerId = NULL)
    {
        $this->_lazyInit();
        if (!$trackerId) {
            $this->_issue->find($trackerId);
        }
        return $this->_issue->set('status_id', $status)->save();
    }
    public function addNoteToTicket($note, $trackerId = NULL)
    {
        $this->_lazyInit();
        if (!$trackerId) {
            $this->_issue->find($trackerId);
        }
        $this->_issue->set('notes', $note)->save();
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
