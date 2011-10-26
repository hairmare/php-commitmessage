<?php

/**
 * allows us to create heaps of handlers
 */
class CommitMessage_HandlerFactory
{
    public function createHandler($classname)
    {
        return new $classname;
    }
}
