<?php

require_once 'src/CommitMessage/Handler/IssueChangeStatus.php';

/**
 * Test class for CommitMessage_Handler_IssueChangeStatus.
 * Generated by PHPUnit on 2011-10-27 at 11:50:03.
 */
class CommitMessage_Handler_IssueChangeStatusTest 
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var CommitMessage_Handler_IssueChangeStatus
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_object = new CommitMessage_Handler_IssueChangeStatus;
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
        $factory = $this->getMock(
            'Comittmessage_Factory',
            array(
                'createRedmineIssueApi'
            )
        );

        $redmine = $this->getMock(
            'Redmine_Issue_Api',
            array(
                'find',
                'setStatusId',
                'setFactory',
            )
        );

        $saver = $this->getMock(
            'stdClass',
            array(
                'save'
            )
        );

        $redmine->expects($this->once())
                ->method('setStatusId')
                ->with(2)
                ->will($this->returnValue($saver));

        $factory->expects($this->any())
                ->method('createRedmineIssueApi')
                ->will($this->returnValue($redmine));

        $this->_object->setFactory($factory);

        $this->_object->setNewStatus(2);
        $this->_object->run();
    }

    public function testRunNoStatusException()
    {
        $this->setExpectedException('Exception');
        $this->_object->run();
    }
}
