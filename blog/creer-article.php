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
    // var_dump($_SESSION);
    
    $catego = $bdd->prepare("SELECT * FROM `categories`");
    $catego->setFetchMode(PDO::FETCH_ASSOC);
    $catego->execute();
    $categorie_name = $catego->fetchAll();
    // var_dump($categorie_name);


if(isset($_POST['submit']))
    {
       
        if(!empty($_POST['article_contenu']))
        {
            $article_contenu = htmlspecialchars($_POST['article_contenu']);
            $user_id = htmlspecialchars($_SESSION['id']);
            $categorie = htmlspecialchars($_POST['categories']);

            $insert = $bdd->prepare("INSERT INTO `articles` ( `article`, `id_utilisateur`, `id_categorie`, `date`) VALUES (?,?,?,NOW())");
            $insert->execute(array($article_contenu, $user_id, $categorie));
            
            $erreur = 'Votre article a bien était posté';
            
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
        <!-- <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous"> -->
        <link rel="stylesheet" href="style.css">



    </head>
    <body>
        <form action="" method="POST">

            <select name="categories">
              
          
                <option value="">Choisir une catégorie</option>
                <?php foreach($categorie_name as $value)
                { ?>
                <option value="">---</option>
                    <option value="<?= $value['id']?>">
                        <?= $value['nom']?>
                    </option>
                <?php } ?>
            </select>
        
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