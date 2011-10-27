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

        $this->_setRedmine($this->getFactory()->createRedmineIssueApi());
        $this->_getRedmine()->setFactory($this->getFactory());

        $this->_getRedmine()->setStatusId(
            $this->_newStatus,
            $this->getIssueId()
        );
    }
}


