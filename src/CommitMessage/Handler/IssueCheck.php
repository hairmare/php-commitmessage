<?php

require_once 'src/CommitMessage/Handler/Issue.php';

/**
 * look if issue is in db
 */
class CommitMessage_Handler_IssueCheck extends CommitMessage_Handler_Issue
{
    protected $_statusMap = array(
        1 => 2
    );
    public function run() 
    {
        // get issue
        $this->_initRedmine();
        $this->_redmine->find($this->getIssueId());

        // check status
        $statusId = (int) $this->_redmine->status['id'];

        // change status if needed
        $statusMap = $this->_statusMap;
        $statusKeys = array_keys($statusMap);
        if (in_array($statusId, $statusKeys)) {
            $setdev = new CommitMessage_Handler_IssueChangeStatus;
            $setdev->setIssueId($this->getIssueId());
            $setdev->setNewStatus($statusMap[$statusId]);
            $this->getCaller()->append($setdev);
        }
    }
}

