<?php
/**
 * Subversion commit integration script
 *
 * This does most of the heavy lifting for tightly integrating
 * the redmine instance with the other tools needed for the job.
 */

/* active resource gets include here so i can haz clean
 * coverge in builds. This should be in ActiveResource.php
 * and it will get removed when i do autoloading anyhow.
 */
require_once 'lib/phpactiveresource/ActiveResource.php';

/* these are my own working, they to need autoloading
 */
require_once 'src/CommitMessage/Split.php';
require_once 'src/CommitMessage/Analyse.php';
require_once 'src/CommitMessage/Factory.php';
require_once 'src/CommitMessage/HandlerStack.php';
require_once 'src/CommitMessage/Handler/Issue.php';
require_once 'src/CommitMessage/Handler/IssueCheck.php';
require_once 'src/CommitMessage/Handler/IssueDecorate.php';
require_once 'src/CommitMessage/Handler/IssueChangeStatus.php';

// testing...
$test = 'ich commit mal was...

in richtigem format und mit issue #27

dr boerner';

// split message in parts
$splitter = new CommitMessage_Split;
$splitter->setMessage($test);
$splitter->split();

$factory = new CommitMessage_Factory;

// a stack of needed treatments to the message
$handlerStack = new CommitMessage_HandlerStack;
$handlerStack->setFactory($factory);


// that will be filled with stuff while analysing
$analyser = new CommitMessage_Analyse;
$analyser->setSplitter($splitter);
$analyser->setHandlerStack($handlerStack);
$analyser->setFactory($factory);
$analyser->analyse();

// last we execute all the stuff on the handler stack
$handlerStack->run();
