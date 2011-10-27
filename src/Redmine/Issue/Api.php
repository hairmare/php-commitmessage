<?php

require_once 'src/Redmine/ActiveResource.php';

class Issue extends Redmine_ActiveResource
{
}

class Redmine_Issue_Api
{
    private $_issue = false;

    public function find($search, $options = array())
    {
        $this->_lazyInit();
        $this->_issue->find($search, $options);
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
        if (!$this->_issue) {
            $this->_issue = new Issue;
        }
    }

}
