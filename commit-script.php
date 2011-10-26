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

/**
 * 
 */
class CommitMessage_HandlerStack extends ArrayObject
{
    private $_caller = false;
    public function setCaller($caller)
    {
        if ($this->_caller) {
            throw new Exception('You may not override the caller');
        }
        $this->_caller = $caller;
    }
    public function getCaller()
    {
        return $this->_caller;
    }
    public function run()
    {
        foreach ($this AS $handler)
        {
            printf("Running %s\n", get_class($handler));
            $handler->run();
        }
    }
    public function append($data)
    {
        $data->setCaller($this);
        return parent::append($data);
    }
}

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

/**
 * look if issue is in db and commiter has rights on issue
 */
class CommitMessage_Handler_IssueCheck extends CommitMessage_Handler_Issue
{
    protected $_statusMap = array(
        1 => 2
    );
    public function run() {
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
