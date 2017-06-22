<?php

namespace Core;

/**
 * This class responsible for handling mysql database via mysqli functions.
 * Class provides 2 connections based on read and write abilities.
 * 
 */
class DbManager {

    private static $_instance;
    public $mysqli_read, $mysqli_write;

    /**
     * intialize the connections
     */
    private function __construct() {
        $this->mysqli_read = new \mysqli(DB_READ_HOST, DB_READ_USER, DB_READ_PASSWORD, DB_READ_NAME);
        $this->mysqli_read->set_charset("utf8");
        $this->mysqli_write = new \mysqli(DB_READ_HOST, DB_READ_USER, DB_READ_PASSWORD, DB_READ_NAME);
        $this->mysqli_write->set_charset("utf8");
    }

    /**
     * get the instance of the class
     * @return SQLQuery Object
     */
    public static function getInstance() {
        if (!self::$_instance) {
            self::$_instance = new self();
        }
        return self::$_instance;
    }

    /**
     * execute read queries
     * @param string sql statement
     * @return mysqli_query result
     */
    public function read_query($query) {
        return self::getInstance()->mysqli_read->query($query);
    }

    /**
     * execute write queries
     * @param string sql statement
     * @return mysqli_query result
     */
    public function write_query($query) {
        return self::getInstance()->mysqli_write->query($query);
    }

    /**
     * execute real escape string before queries executes
     * @param string sql statement
     * @return mysqli_query result
     */
    public function senitize($data, $write = 1) {
        if ($write == 1)
            return self::getInstance()->mysqli_write->real_escape_string($data);
        else
            return self::getInstance()->mysqli_read->real_escape_string($data);
    }

}
