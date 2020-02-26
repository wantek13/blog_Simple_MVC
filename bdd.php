<?php

//PDO = PHP Data Objects

try {
    $host = '127.0.0.1';
    $dbname   = 'initiation';
    $user = 'root';
    $pass = '';
    $charset = 'utf8mb4';
    
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];

    $bdd = new PDO("mysql:host=$host;dbname=$dbname;charset=$charset", $user, $pass, $options);
    
}
catch(PDOException $e)
{
    var_dump($e);
    die('Erreur : '.$e->getMessage());
}

catch(Exception $e)
{
    var_dump($e);
    die('Erreur : '.$e->getMessage());
    
}