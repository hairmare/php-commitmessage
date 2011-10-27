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
    protected function _initRedmine()
    {
        if (empty($this->_redmine)) {
            if (!$this->_factory) {
                throw new Exception('Called _initRedmine() without a _factory.');
            }
            $this->_redmine = $this->_factory->create('Issue');
        }
    }
    protected function _getRedmine()
    {
        return $this->_redmine;
    }
}


