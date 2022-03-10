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

// on recupere le nombre d'enregistrement.
$count=$bdd->prepare("SELECT count(id) AS cpt FROM articles");
$count->setFetchMode(PDO::FETCH_ASSOC);
$count->execute();
$Ecount=$count->fetchAll();

@$pages= $_GET['start'];
$Nbr_element_page = 5;
$nbr_pages =ceil($Ecount[0]["cpt"]/$Nbr_element_page);
$debut=($pages-1)*$Nbr_element_page;



$sel=$bdd->prepare("SELECT article FROM articles ORDER BY date DESC $debut, $Nbr_element_page ");
$sel->setFetchMode(PDO::FETCH_ASSOC);
$sel->execute();
$tab=$sel->fetchAll();
if(count($tab)==0)

?>

<!DOCTYPE html>
<html>
    <head>
        <title>Articles</title>
        <meta charset="UTF-8">
        <link rel="stylesheet" href="style.css">
    </head>
    <body>
        <header>
            <?php echo $Ecount[0]["cpt"];?> "Enregistrement total des articles !"
        </header>

        <div id='pagination'>
            <?php 
                for($i=1;$i<=$nbr_pages;$i++)
                {
                    if($pages!=$i)
                    echo "<a href='?start=$i'>$i</a>&nbsp;";
                   else echo "<a>$i</a>";

                    
                }            
            ?>
        <section id="cont">
                <?php for($i=0;$i<count($tab);$i++)

                {
                    
                    ?>
                    <div>
                        <?php echo $tab[$i]["article"]; ?>

                    </div>
                <?php } ?>
                
                           
        </section>
        </div>
            <ul>
            <?php while($a = $sel->fetch()) {?>
                <li><?= $a['article'] ?></li>
                
                <?php 
                      
            } ?>



            </ul>
    </body>
                       
                       
        
    </body>
</html>
