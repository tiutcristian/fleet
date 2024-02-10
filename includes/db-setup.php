<?php

function connect_db() 
{
    $host = 'localhost';
    $dbname = 'fleet';
    $dbusername = 'root';
    $dbpassword = '';

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    return $pdo;
}