<?php

require_once 'src/Redmine/ActiveResource.php';

class Issue extends Redmine_ActiveResource {}

class Redmine_Issue_Api {

    private $_issue = false;
    private $_factory = false;

    public function find($search, $options = array())
    {
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
    public function addNoteToTicket($note, $ticketId = NULL)
    {
        $this->_lazyInit();
        if (!$ticketId) {
            $this->_issue->find($ticketId);
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
