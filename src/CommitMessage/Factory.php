<?php

/**
 * allows us to create heaps of handlers
 */
class CommitMessage_Factory
{
    /**
     * @obsolete
     */
    public function create($classname)
    {
        return $this->_create($classname);
    }

    public function createRedmineIssueApi()
    {
        return new Redmine_Issue_Api;
    }

    public function createHandlerIssueChangeStatus()
    {
        return new CommitMessage_Handler_IssueChangeStatus;
    }

    private function _create($classname)
    {
        return new $classname;
    }
}
