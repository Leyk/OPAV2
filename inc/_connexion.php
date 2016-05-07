<?php
// https://sqlprive.ovh.net
try
{
    $connexion = new PDO('mysql:host=127.0.0.1;dbname=forcesviueopa','root', '', array(
       PDO::MYSQL_ATTR_INIT_COMMAND => "SET NAMES utf8"));
}
catch(Exception $e)
{
    echo 'Erreur : '.$e->getMessage().'<br />';
    echo 'N° : '.$e->getCode();
}
?>