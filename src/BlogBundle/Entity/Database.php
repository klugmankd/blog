<?php

namespace BlogBundle\Entity;
require "constants.php";

class Database
{
    /**
     * @return bool
     */
    public function connectDB() {
        $connection = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD);
        if ($connection) {
            mysqli_select_db($connection, DB_NAME);
            mysqli_set_charset($connection, "utf8");
        }
        return $connection;
    }

    /**
     * @param $connection
     * @param $tableName
     * @return array
     */
    public function selectTable($connection, $tableName) {
        $query_string = "SELECT * FROM $tableName ORDER BY id DESC;";
        $query = mysqli_query($connection, $query_string);
        while ($record = mysqli_fetch_array($query))
            $records[] = $record;
        return $records;
    }

    /**
     * @param $connection
     * @param $tableName
     * @param $id
     * @return array
     */
    public function selectRecordById($connection, $tableName, $id) {
        $query_string = "SELECT * FROM $tableName WHERE id = $id";
        $query = mysqli_query($connection, $query_string);
        return mysqli_fetch_assoc($query);
    }

    /**
     * @param bool $connection
     */
    public function disconnectDB ($connection) {
        mysqli_close($connection);
    }
}