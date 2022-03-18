<?php 
{

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


    // pagination 
    @$start= $_GET['start'];

    $nbr_element_page = 5;
    
    $nbr_pages =ceil($Ecount[0]["cpt"]/$nbr_element_page);
    
    $debut=($start-1)*$nbr_element_page;

    // select l'id de la categorie 



    $id_category =$bdd->prepare("SELECT * FROM categories ");
    
    $id_category->setFetchMode(PDO::FETCH_ASSOC);
    
    $id_category->execute(array());
    
    $id_categorie = $id_category->fetchAll();
    // var_dump($id_categorie);



    
    // on affiche la liste des articles en BDD du plus recent au plus ancien toute categorie confondu

    $sel=$bdd->prepare("SELECT * FROM articles ORDER BY date DESC LIMIT $debut, $nbr_element_page");

    $sel->setFetchMode(PDO::FETCH_ASSOC);
    
    $sel->execute();
    
    $tab=$sel->fetchAll();
    // var_dump($tab);
    // print_r($_GET);
    

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
            <!-- <?php echo $Ecount[0]["cpt"];?> "Enregistrement total des articles !" -->
        </header>
    
            <select name="categorie" method="GET">
                <option value="nul">Choisir une categorie</option>
                <?php  foreach($id_categorie as $value)
            { ?> 
            <option value="<?= $value['id']?>">
                <?= $value['nom']?>
            </option>
            
            <?php }?>
            </select> 
        
            <form action="" method="GET">
            <button type="submit" value="id" name="categorie">Choisir</button>
            <?php
            if(isset($_GET['categorie']))
            {
              
                $select = $bdd->prepare("SELECT 

                nom,
                article,
                id_utilisateur,
                id_categorie,
                date
                
                FROM `categories` 
                
                INNER JOIN articles ON articles.id = categories.id");

                $select->execute();
              
            } else  
               
            
               
                // 
            ?>
            </form>

            
            
        <div id='pagination'>
        
            <?php ;
                for($i=1;$i<=$nbr_pages;$i++)
                {
                    if($start!=$i)
                    echo "<a href='?start=$i'>$i</a>&nbsp;";
                else echo "<a>$i</a>";

                    
                }            
            ?>
            </div>
        <section id="cont">
                <?php for($i=0;$i<count($tab);$i++)

                {
                    
                    ?>
                    <div>
                        <?php echo $tab[$i]["article"];  ?>
                        
                        <br>
                        <br>


                        <?php echo $tab[$i]["date"]; ?>

                    </div>
                <?php } ?>
                
                        
        </section>
        
        
            
    </body>
                    
                    
        
    </body>
</html>

<?php 
}
?>
