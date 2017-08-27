<?php
    /*
    
    CONEXAO COM O BANCO DE DADOS
    
    $host      = 'localhost';
    $user      = 'root';
    $pass      = '';
    $dbname    = 'db30anos';
    */

    $host      = 'localhost';
    $user      = 'root';
    $pass      = '';
    $dbname    = 'dbrifas';

    try 
    {
        $pdo =  new PDO("mysql:host=".$host.";"."dbname=".$dbname, $user, $pass);  
    }
    catch(PDOException $e) 
    {
        die($e->getMessage());  
    }