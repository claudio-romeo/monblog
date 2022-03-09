<?php
require_once 'bdd.php';
// Cette page possède un formulaire permettant aux modérateurs et
// administrateurs de créer de nouveaux articles. Le formulaire contient donc
// le texte de l’article, une liste déroulante contenant les catégories existantes
// en base de données et un bouton submit.
include('header.php');


if (isset($_SESSION['id'])) {
    // Si l'utilisateur est connecté et qu'il a bien un id dans la bdd alors
    $requete = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");

    $requete->execute(array($_SESSION['id']));

    $user = $requete->fetch();

if(isset($_POST['submit']))
    {
        if(!empty($_POST['article_contenu']))
        {

            $article_contenu = htmlspecialchars($_POST['article_contenu']);

            $insert = $bdd->prepare("INSERT INTO `articles` ( `article`, `id_utilisateur`, `id_categorie`, `date`) VALUES (?,?,1,NOW())");
            $insert->execute(array($article_contenu, $_SESSION['id']));

            
        }else 
        {
            $erreur = 'Veuillez remplir tout les champs';
        }
    }


?>

<!DOCTYPE html>
<html>
    <head>
        <title>Articles</title>
        <meta charset="UTF-8">
    </head>
    <body>
        <form method="POST">

            <textarea name="article_contenu" placeholder="Contenu de l'article" id="articles"></textarea> <br>
            <input type="submit" name="submit" value="Envoyer">

            
            <?php
                        if (isset($erreur)) {
                            echo '<p style="color:red"> ' . $erreur . '</p>';
                        }

                        ?>
        </form>
    </body>
</html>

<?php
    } else {
        // si l'utilisateur n'est pas connecté alors on redirect vers la page de connexion .
        header('location: connexion.php');
    }
    ?>