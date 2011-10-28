<?php

require_once 'src/CommitMessage/Handler/Issue.php';
require_once 'src/Redmine/IssueApi.php';

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
        // initialize issue api
        $this->_setRedmine($this->getFactory()->createRedmineIssueApi());

        // get issue
        $this->_getRedmine()->find($this->getIssueId());

        // check status
        $statusId = $this->_getRedmine()->getStatusId();

        // change status if needed
        $statusMap = $this->_statusMap;
        $statusKeys = array_keys($statusMap);
        if (in_array($statusId, $statusKeys)) {
            $setdev = $this->getFactory()->createHandlerIssueChangeStatus();
            $setdev->setIssueId($this->getIssueId());
            $setdev->setFactory($this->getFactory());
            $setdev->setNewStatus($statusMap[$statusId]);
            $this->getCaller()->append($setdev);
        }
    }
}

