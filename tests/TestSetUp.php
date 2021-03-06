<?php

namespace Dframe\Database\Tests;

use Dframe\Database\Database;
use PDO;
use PHPUnit\Framework\TestCase;

abstract class TestSetUp extends TestCase
{
    protected $db;

    public function getConnection()
    {
        try {
            $dsn = [
                'dbtype' => 'mysql',
                'host' => 'localhost',
                'dbname' => 'test'
            ];

            $config = [
                'logDir' => APP_DIR . 'View/logs/',
                'options' => [
                    PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
                    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, // If you want to Show Class exceptions on Screen, Uncomment below code
                    PDO::ATTR_EMULATE_PREPARES => true, // Use this setting to force PDO to either always emulate prepared statements (if TRUE), or to try to use native prepared statements (if FALSE).
                    PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC, // Set default pdo fetch mode as fetch assoc
                ],
            ];

            $this->db = new Database($dsn, 'root', '', $config);
        } catch (\PDOException $e) {
            echo $e->getMessage();
        }

        return $this->db;
    }
}
