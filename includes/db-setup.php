<?php

require_once 'config.php';

function connect_db() 
{
    global $config;
    $host = $config['db_host'];
    $dbname = $config['db_name'];
    $dbusername = $config['db_username'];
    $dbpassword = $config['db_password'];

    try {
        $pdo = new PDO("mysql:host=$host;dbname=$dbname", $dbusername, $dbpassword);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    } 
    catch (PDOException $e) {
        die("Connection failed: " . $e->getMessage());
    }

    return $pdo;
}