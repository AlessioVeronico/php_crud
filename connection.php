<?php

try {
    $hostname = 'localhost';
    $dbname = 'project8';
    $user = 'root';
    $pass = '';
    $db = new PDO("mysql:host=$hostname;dbname=$dbname", $user, $pass);
    
} catch (PDOException $e){
    echo 'Errore: '.$e->getMessage();
    die();
}
