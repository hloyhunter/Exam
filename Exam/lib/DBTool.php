<?php
        function SqlSelect($sql) {
                $servername = "52.192.151.100";
                $username = "test";
                $password = "test";
                $dbname = "test";

                // Create connection
                $conn = new mysqli($servername, $username, $password, $dbname);

                // Check connection
                if ($conn->connect_error) {
                    die("Connection failed: " . $conn->connect_error);
                }

                $result = $conn->query($sql);

                $conn->close();

                return $result;
        }