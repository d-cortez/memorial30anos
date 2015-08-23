<?php
    /*
    
    CONEXAO COM O BANCO DE DADOS
    
    $host      = 'mysql1.paroquiadesantana.site.br.com';
    $user      = 'paroquiadesanta2';
    $pass      = 'P@ssw0rd';
    $dbname    = 'paroquiadesantana1';

    $host      = 'localhost';
    $user      = 'root';
    $pass      = '';
    $dbname    = 'db30anos';
    */

    $host      = 'localhost';
    $user      = 'root';
    $pass      = '';
    $dbname    = 'db30anos';

    try 
    {
        $pdo =  new PDO("mysql:host=".$host.";"."dbname=".$dbname, $user, $pass);  
    }
    catch(PDOException $e) 
    {
        die($e->getMessage());  
    }