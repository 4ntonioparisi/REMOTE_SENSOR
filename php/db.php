<?php
    $driver = 'mysql';
    $hostDb = 'localhost';
    $usernameDb = 'root';
    $passwordDb = '';
    $databaseDb = 'my_iotprogetto';
    $e = '';
    try{
        $col = $driver.':host='.$hostDb.';dbname='.$databaseDb;
        $db = new PDO ($col, $usernameDb, $passwordDb);
    }catch(PDOException $e){
        
    }
