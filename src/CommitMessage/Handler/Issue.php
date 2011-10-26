<?php

abstract class CommitMessage_Handler_Issue extends CommitMessage_Handler_Abstract
{
    private $_issueId;
    protected $_redmine;
    public function setIssueId($issueId)
    {
        $this->_issueId = $issueId;
    }
    public function getIssueId()
    {
        return $this->_issueId;
    }
    protected function _initRedmine()
    {
        if (empty($this->_redmine)) $this->_redmine = new Issue;
    }
}


