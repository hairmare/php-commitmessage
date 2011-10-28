<?php

/**
 * allows us to create heaps of handlers
 */
class CommitMessage_Factory
{
    public function createRedmineIssueApi()
    {
        return new Redmine_IssueApi;
    }

    public function createHandlerWarnMissingText()
    {
        return new CommitMessage_Handler_WarnMissingText;
    }

    public function createHandlerIssueChangeStatus()
    {
        return new CommitMessage_Handler_IssueChangeStatus;
    }

    public function createHandlerIssueCheck()
    {
        return new CommitMessage_Handler_IssueCheck;
    }

    public function createHandlerIssueDecorate()
    {
        return new CommitMessage_Handler_IssueDecorate;
    }
}
