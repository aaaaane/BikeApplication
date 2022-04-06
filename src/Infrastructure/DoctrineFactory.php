<?php

namespace Vanmoof\Infrastructure;

use Doctrine\DBAL\Connection;
use Doctrine\DBAL\DriverManager;

class DoctrineFactory
{
    public function buildConnection(
        string $dbName,
        string $user,
        string $password,
        string $host,
        string $driver,
        string $port,
    ): Connection
    {
        return DriverManager::getConnection(
            [
                'dbName' => $dbName,
                'user' => $user,
                'password' => $password,
                'host' => $host,
                'driver' => $driver,
                'port' => $port,
            ]
        );
    }
}
