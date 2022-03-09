<?php

// Sur cette page, les utilisateurs peuvent voir l’ensemble des articles, triés du
// plus récents au plus anciens. S’il y a plus de 5 articles, seuls les 5 premiers
// sont affichés et un système de pagination permet d’afficher les 5 suivants
// (ou les 5 précédents). Pour cela, il faut utiliser l’argument GET “start”.
// ex : https://localhost/blog/articles.php/?start=5 affiche les articles 6 à 10.
// La page articles peut également filtrer les articles par catégorie à l’aide de
// l’argument GET “categorie” qui utilise les id des categories.
// ex : https://localhost/blog/articles.php/?categorie=1&start=10 affiche les
// articles 11 à 15 ayant comme id_categorie 1).


require_once 'bdd.php';
include('header.php');
?>

