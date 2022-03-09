<?php
require_once 'bdd.php';

?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  

    <ul class="listindex">
        <?php
        if (!isset($_SESSION['login'])) {
        ?>
            <li><a href="index.php">Accueil</a></li>
            <li><a href="connexion.php">connexion</a></li>
            <li><a href="inscription.php">inscription</a></li>
        <?php
        } elseif ($_SESSION['login'] == "admin") { ?>

            <li><a href="deconnexion.php">deconnexion</a></li>
            <li><a href="profil.php">profil</a></li>
            <li><a href="creer-article.php">Poster</a></li>
            <li><a href="article.php">Article</a></li>
            <li><a href="admin.php">admin</a></li>
        <?php
        } else {
        ?>
            <li><a href="deconnexion.php">deconnexion</a></li>
            <li><a href="profil.php">profil</a></li>
            <li><a href="creer-article.php">Poster</a></li>
            <li><a href="article.php">Article</a></li>
            


        <?php
        }

        ?>
    </ul>
</nav>

</body>
</html>

