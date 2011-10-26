<?php
/**
 * Subversion commit integration script
 *
 * This does most of the heavy lifting for tightly integrating
 * the redmine instance with the other tools needed for the job.
 */

require_once 'src/CommitMessage/Split.php';
require_once 'src/CommitMessage/Analyse.php';
require_once 'src/CommitMessage/HandlerFactory.php';
require_once 'src/CommitMessage/HandlerStack.php';
require_once 'src/CommitMessage/Handler/Issue.php';
require_once 'src/CommitMessage/Handler/IssueCheck.php';
/**
 * add a comment to the issue and create a link to websvn in the comment
 */
class CommitMessage_Handler_IssueDecorate extends CommitMessage_Handler_Issue
{
    public function run()
    {
        $this->_initRedmine();
        $this->_redmine->find($this->getIssueId(), array('include'=>'journals'));

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

class CommitMessage_Handler_IssueChangeStatus extends CommitMessage_Handler_Issue
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

        $this->_initRedmine();
        $this->_redmine->find($this->getIssueId());
        $this->_redmine
             ->set('status_id', $this->_newStatus)
             ->save();
    }
}

require_once('lib/phpactiveresource-0.14-beta/ActiveResource.php');

class Redmine extends ActiveResource
{
    var $site = 'http://b3126476278c49215556ed00592bd331bb8e65d3:@192.168.1.109:3000/';
    var $request_format = 'xml';
}
class Issue extends Redmine {}

// testing...


$test = 'ich commit mal was...

in richtigem format und mit issue #27';

// split message in parts
$splitter = new CommitMessage_Split;
$splitter->setMessage($test);
$splitter->split();

// a stack of needed treatments to the message
$handlerStack = new CommitMessage_HandlerStack;

$handlerFactory = new CommitMessage_handlerFactory;

// that will be filled with stuff while analysing
$analyser = new CommitMessage_Analyse;
$analyser->setSplitter($splitter);
$analyser->setHandlerStack($handlerStack);
$analyser->setHandlerFactory($handlerFactory);
$analyser->analyse();

// last we execute all the stuff on the handler stack
$handlerStack->run();
