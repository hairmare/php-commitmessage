<?php

require_once 'src/CommitMessage/Handler/Abstract.php';

abstract class CommitMessage_Handler_Issue
    extends CommitMessage_Handler_Abstract
{
    protected $_redmine;
    private $_issueId;
    private $_factory = false;
    public function setIssueId($issueId)
    {
        $this->_issueId = $issueId;
    }
    public function getIssueId()
    {
        return $this->_issueId;
    }
    public function setFactory($factory)
    {
        $this->_factory = $factory;
    }
    public function getFactory()
    {
        return $this->_factory;
    }
    protected function _setRedmine($redmine)
    {
        $this->_redmine = $redmine;
    }
    protected function _getRedmine()
    {
        return $this->_redmine;
    }
}


