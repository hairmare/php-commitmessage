<?php

/**
 * split message into parts
 */
class CommitMessage_Split
{
    private $_message = false;
    private $_data = false;
    public function setMessage($strMessage)
    {
        $this->_message = $strMessage;
    }
    public function getData()
    {
        if (!$this->_data) {
            throw new RuntimeException('No data found, have you called split() yet?');
        }
        return $this->_data;
    }
    public function getHead()
    {
        $data = $this->getData();
        return $data['head'];
    }
    public function getBody()
    {
        $data = $this->getData();
        return $data['body'];
    }
    public function split()
    {
        if (!$this->_message) {
            throw new RuntimeException('No message to split.');
        }
        $lines = explode("\n", $this->_message);
        $this->_data = array(
            'head' => $lines[0],
        );
        unset($lines[0]);
        if (empty($lines[1])) {
            unset($lines[1]);
        }
        $this->_data['body'] = implode("\n", $lines);
    }
}


