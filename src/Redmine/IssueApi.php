<?php

require_once 'src/Redmine/ActiveResource.php';

class Issue extends Redmine_ActiveResource
{
}

class Redmine_IssueApi
{
    private $_issue = false;

    public function find($searchExpr, $options = array())
    {
        $this->_lazyInit();
        $this->_issue->find($searchExpr, $options);
    }
    public function getStatusId()
    {
        return (int) $this->_issue->status['id'];
    }
    public function setStatusId($trackerId, $newStatusId)
    {
        $this->_lazyInit();
        $this->_issue->find($trackerId);
        return $this->_issue->set('status_id', $newStatusId)->save();
    }
    public function addNoteToTicket($trackerId, $newNoteText)
    {
        $this->_lazyInit();
        
        // add issues/ to oath so activeresource.php creates working URLs
        $this->_issue->element_name = 'issue';
        
        $this->_issue->find('issues/'.$trackerId);
        
        // make clone with new note
        $newNote = $this->_issue->set('notes', $newNoteText);
        
        // this is needed so activeresource.php creates working URLs 
        $newNote->site .= '/issues';
        $newNote->element_name = 'issue';
        
        $newNote->save();
    }
    protected function _setIssue($issue)
    {
        $this->_issue = $issue;
    }

    /**
     * not aiming for nice code here
     *
     * The whole api is full of state from my pov. It
     * also looks like it has some automated test of
     * its own which is why i will be concentrating
     * on solving other problems.
     * 
     * @return void
     */
    protected function _lazyInit()
    {
        if (!$this->_issue) {
            // @codeCoverageIgnoreStart
            $this->_setIssue(new Issue);
            // @codeCoverageIgnoreEnd
        }
    }
}
