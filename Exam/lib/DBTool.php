<?php
    class Database {
        private $Server;
        private $User;
        private $Password;
        private $Database;

        function __construct()
        {
            $config = parse_ini_file($_SERVER["DOCUMENT_ROOT"]."/Exam/Config.ini", true);
            $this->Server = $config["Database"]["Server"];
            $this->User = $config["Database"]["User"];
            $this->Password = $config["Database"]["Password"];
            $this->Database = $config["Database"]["Database"];
        }

        function Query($sql) {

            //Create connection
            $conn = new mysqli($this->Server, $this->User, $this->Password, $this->Database);

            // Check connection
            if ($conn->connect_error) {
                die("Connection failed: ".$conn->connect_error);
            }

            $result = $conn->query($sql);

            $conn->close();
            return $result;
        }
    }