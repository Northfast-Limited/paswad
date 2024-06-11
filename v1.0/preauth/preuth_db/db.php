<?php
    class preauth_database {
        //has access to config.php
                function cooker($properties) {
                    $config = new config;
                    $dsn = 'mysql:host ='. $config->host .';dbname='.$config->database;
                    $sql = new PDO($dsn , $config->username,$config->password);
                    $sql->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
                        $realStatement = 'SELECT * FROM  profile WHERE firstName = :firstName';
                        $stmnt = $sql ->prepare($realStatement);
                        $stmnt->execute(['firstName' => $properties['firstName']]);
                        $response = $stmnt->fetchAll(PDO::FETCH_OBJ);
                        $sql ->prepare($realStatement);
                                       
                        foreach($response as $data) {
                            echo( json_encode([ $data]) );
                        }
                }
            }