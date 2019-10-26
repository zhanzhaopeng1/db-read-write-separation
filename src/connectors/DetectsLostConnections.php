<?php

namespace dbrw\connectors;

use dbrw\support\Str;
use Exception;

trait DetectsLostConnections
{
    protected function causedByLostConnection(Exception $e)
    {
        $message = $e->getMessage();

        return Str::contains(
            $message, [
                'server has gone away',
                'no connection to the server',
                'Lost connection',
                'is dead or not enabled',
                'Error while sending',
                'decryption failed or bad record mac',
                'server closed the connection unexpectedly',
                'SSL connection has been closed unexpectedly',
                'Error writing data to the connection',
                'Resource deadlock avoided',
            ]
        );
    }

}