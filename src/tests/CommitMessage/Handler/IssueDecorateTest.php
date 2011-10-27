<?php

require_once 'src/CommitMessage/Handler/IssueDecorate.php';

/**
 * Test class for CommitMessage_Handler_IssueDecorate.
 * Generated by PHPUnit on 2011-10-26 at 22:08:01.
 */
class CommitMessage_Handler_IssueDecorateTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var CommitMessage_Handler_IssueDecorate
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_object = new CommitMessage_Handler_IssueDecorate;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     * @todo Implement testRun().
     */
    public function testRun()
    {
        $caller = $this->getMock(
            'CommitMessage_HandlerStack',
            array(
                'getIssueId',
            )
        );

        $factory = $this->getMock(
            'CommitMessage_Factory',
            array(
                'createRedmineIssueApi',
            )
        );

        $redmine = $this->getMock(
            'Redmine_Issue_Api',
            array(
                'find',
                'addNoteToTicket'
            )
        );

        $splitter = $this->getMock(
            'CommitMessage_Splitter',
            array(
                'getHead',
                'getBody'
            )
        );

        $factory->expects($this->once())
                ->method('createRedmineIssueApi')
                ->will($this->returnValue($redmine));

        $this->_object->setCaller($caller);
        $this->_object->setFactory($factory);
        $this->_object->setSplitter($splitter);
        $this->_object->setIssueId(1);
        $this->_object->run();
    }
}
