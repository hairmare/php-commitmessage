<?php

require_once 'src/CommitMessage/Handler/Issue.php';

/**
 * add a comment to the issue and create a link to websvn in the comment
 */
class CommitMessage_Handler_IssueDecorate extends CommitMessage_Handler_Issue
{
    private $_splitter = false;
    public function setSplitter($splitter)
    {
        $this->_splitter = $splitter;
    }
    private function _getSplitter()
    {
        return $this->_splitter;
    }
    public function run()
    {
        $this->_setRedmine($this->getFactory()->createRedmineIssueApi());
        $this->_getRedmine()->setFactory($this->getFactory());

        $this->_getRedmine()->find(
            $this->getIssueId(),
            array(
                'include' => 'journals'
            )
        );

        $splitter = $this->_getSplitter();

        $head = $splitter->getHead();
        $body = $splitter->getBody();

        $note  = "commit: *$head*\n\n";
        $note .= "* http://websvn/url/\n\n<pre>$body</pre>";

        $this->_getRedmine()->addNoteToTicket($note);
    }
}

