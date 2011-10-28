<?php

require_once 'src/CommitMessage/Factory.php';

/**
 * Test class for CommitMessage_Factory.
 * Generated by PHPUnit on 2011-10-27 at 13:11:56.
 */
class CommitMessage_FactoryTest
    extends PHPUnit_Framework_TestCase
{
    /**
     * @var CommitMessage_Factory
     */
    protected $_object;

    /**
     * Sets up the fixture, for example, opens a network connection.
     * This method is called before a test is executed.
     */
    protected function setUp()
    {
        $this->_object = new CommitMessage_Factory;
    }

    /**
     * Tears down the fixture, for example, closes a network connection.
     * This method is called after a test is executed.
     */
    protected function tearDown()
    {
    }

    /**
     */
    public function testCreateRedmineIssueApi()
    {
        $this->assertInstanceOf(
            'Redmine_IssueApi',
            $this->_object->createRedmineIssueApi()
        );
    }

    /**
     */
    public function testCreateHandlerIssueChangeStatus()
    {
        $this->assertInstanceOf(
            'CommitMessage_Handler_IssueChangeStatus',
            $this->_object->createHandlerIssueChangeStatus()
        );
    }

    public function testCreateHandlerWarnMissingText()
    {
        $this->assertInstanceOf(
            'CommitMessage_Handler_WarnMissingText',
            $this->_object->createHandlerWarnMissingText()
        );
    }

    public function testCreateHandlerIssueCheck()
    {
        $this->assertInstanceOf(
            'CommitMessage_Handler_IssueCheck',
            $this->_object->createHandlerIssueCheck()
        );
    }

    public function testCreateHandlerIssueDecorate()
    {
        $this->assertInstanceOf(
            'CommitMessage_Handler_IssueDecorate',
            $this->_object->createHandlerIssueDecorate()
        );
    }
}
