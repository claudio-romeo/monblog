<?php
session_start();
try
{
    $bdd = new PDO('mysql:host=localhost;dbname=blog;charset=utf8','root', '');
}
catch(exception $erreur)
{
    die('Erreur' .$erreur->getMessage());
}

?>