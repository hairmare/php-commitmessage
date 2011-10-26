<?php

require_once 'src/CommitMessage/Handler/Issue.php';

/**
 * add a comment to the issue and create a link to websvn in the comment
 */
class CommitMessage_Handler_IssueDecorate extends CommitMessage_Handler_Issue
{
    public function run()
    {
        $this->_initRedmine();
        $this->_redmine->find(
            $this->getIssueId(),
            array(
                'include' => 'journals'
            )
        );

        // hmm... not as pretty as it should be does the job
        $handlerStack = $this->getCaller();
        $analyser = $handlerStack->getCaller();
        $splitter = $analyser->getSplitter();
        $head = $splitter->getHead();
        $body = $splitter->getBody();

        $note  = "commit: *$head*\n\n";
        $note .= "* http://websvn/url/\n\n<pre>$body</pre>";

        $this->_redmine->set('notes', $note)->save();
    }
}


