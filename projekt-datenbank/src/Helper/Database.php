<?php
declare(strict_types=1);

namespace Helper;

/**
 * Class Database
 * @package Helper
 */
class Database
{
    protected string $hostname;
    protected string $username;
    protected string $password;
    protected string $database;

    /**
     * Database constructor.
     * @param string $hostname
     * @param string $username
     * @param string $password
     * @param string $database
     */
    public function __construct(string $hostname, string $username, string $password, string $database)
    {
        $this->hostname = $hostname;
        $this->username = $username;
        $this->password = $password;
        $this->database = $database;
    }

    /**
     * @return \mysqli
     */
    public function connect(): \mysqli
    {
        $conn = new \mysqli(
            $this->hostname,
            $this->username,
            $this->password,
            $this->database
        );

        // Check connection
        if ($conn->connect_error) {
            die("Connection failed: ".$conn->connect_error);
        } else {
            return $conn;
        }
    }
}