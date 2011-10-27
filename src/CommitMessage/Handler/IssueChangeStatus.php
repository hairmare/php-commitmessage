<?php

require_once 'src/CommitMessage/Handler/Issue.php';

class CommitMessage_Handler_IssueChangeStatus
    extends CommitMessage_Handler_Issue
{
    private $_newStatus = false;

    public function setNewStatus($newStatus)
    {
        $this->_newStatus = $newStatus;
    }

    public function run()
    {
        if (!$this->_newStatus) {
            throw new Exception('IssueChangeStatus called without newStatus');
        }

        $this->_initRedmine();
        $this->_redmine->find($this->getIssueId());
        $this->_redmine
             ->set('status_id', $this->_newStatus)
             ->save();
    }
}


