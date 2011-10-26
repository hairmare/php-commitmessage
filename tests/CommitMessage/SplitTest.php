<?php

require_once 'src/CommitMessage/Split.php';

/**
 * Test class for CommitMessage_Split.
 *
 * Generated by PHPUnit on 2011-10-26 at 14:58:06.
 */
class CommitMessage_SplitTest extends PHPUnit_Framework_TestCase
{
    /**
     * @var CommitMessage_Split
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_object = new CommitMessage_Split;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
        unset($this->_object);
    }

    /**
     * @todo Implement testSplit().
     */
    public function testSplit()
    {
        $head = 'head';
        $body = 'body';
        $commit = "$head\n\n$body";

        $this->_object->setMessage($commit);
        $this->_object->split();
        $this->assertEquals($head, $this->_object->getHead());
        $this->assertEquals($body, $this->_object->getBody());
    }
}
?>
