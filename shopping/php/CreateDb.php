<?php


class CreateDb
{
    public $server_name;
    public $username;
    public $password;
    public $dbname;
    public $table_name;
    public $con;

    public function __construct($dbname = "Newdb", $table_name = "Producttb", $server_name = "localhost",
                                $username = "root", $password = "")
    {
        $this->dbname = $dbname;
        $this->table_name = $table_name;
        $this->server_name = $server_name;
        $this->username = $username;
        $this->password = $password;


        $this->con = mysqli_connect($server_name, $username, $password);

        if (!$this->con) {
            die("Connection failed:" . mysqli_connect_error());
        }

        $sql = "CREATE DATABASE IF NOT EXISTS $dbname";
        if (mysqli_query($this->con, $sql)) {
            $this->con = mysqli_connect($server_name, $username, $password, $dbname);

            $sql = "CREATE TABLE IF NOT EXISTS $table_name
                (id INT(11) NOT NULL AUTO_INCREMENT PRIMARY KEY, 
                 product_name VARCHAR(25) NOT NULL,
                 product_price FLOAT, 
                 product_image VARCHAR(100)
                );
            ";

            if (!mysqli_query($this->con, $sql)) {
                echo "Error creating table: " . mysqli_error($this->con);
            }
        } else {
            return false;
        }
    }

    public function getData()
    {
        $sql = "SELECT * FROM $this->table_name";

        $result = mysqli_query($this->con, $sql);
        if (mysqli_num_rows($result) > 0) {
            return $result;
        }
    }
}