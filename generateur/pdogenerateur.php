<?php

try
{
    $connexion = new PDO('mysql:host='.$host.';dbname='.$dbname,$user,$pswd, array(
       PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(Exception $e)
{
    echo 'Erreur : '.$e->getMessage().'<br />';
    echo 'N° : '.$e->getCode();
}



?>