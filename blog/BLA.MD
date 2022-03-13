$articles = $bdd->query("SELECT * FROM articles  ORDER BY date DESC ");



?>



faire une requete en base de donnée pour recup les categories et leur id 

    faire un foreach pour afficher autant de catégorie qu'il y a en base de donné avec leur valeur en id 

    

       <!-- <ul>
                <?php   while($a = $sel->fetch()) { echo 'plutot';?>
                    <li><a href="article.php?id=<?= $a[''] ?>">Modifier</a></li>
                    
                    <?php 
                        
                } ?>
            


                </ul> -->