<?php

/**
 * allows us to create heaps of handlers
 */
class CommitMessage_Factory
{
    public function createHandler($classname)
    {
        return new $classname;
    }
}
