<?php
/**
 * Subversion commit integration script
 *
 * This does most of the heavy lifting for tightly integrating
 * the redmine instance with the other tools needed for the job.
 */
require_once 'src/Bootstrap.php';

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
