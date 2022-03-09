<?php
require_once 'bdd.php';
include('header.php');



    if(isset($_GET['id']) && !empty($_GET['id']))

    {
        $get_id = htmlspecialchars($_GET['id']);

    $article = $bdd->prepare("SELECT * FROM articles WHERE id = ?");
    $article->execute(array($get_id));

    if($article->rowCount() == 1)
    {
        $article = $article->fetch();
        $contenu = $contenu['article'];

    }else
    {
        die('Cet article n\'existe pas !');
    }

    }else
    {
        die('Erreur');
    }
?>
