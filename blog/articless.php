<?php
require_once 'bdd.php';


if (isset($_GET['page'])&& !empty($_GET['page'])){
    $pageCourante=(int)strip_tags($_GET['page']);
}else{
    $pageCourante=1;
}

$sql= 'SELECT COUNT(*) AS nb_articles FROM `articles`';
@$lacateg= $_GET['categorie'];
$query=$bdd->prepare($sql);
$query->execute();
$result=$query->fetch();
$nbArticles=(int) $result['nb_articles'];

$article_par_page=5;

$pagestotales = ceil($nbArticles / $article_par_page);
$debut=($pageCourante*$article_par_page)-$article_par_page;

$sql='SELECT *, articles.id as art_id FROM articles INNER JOIN categories ON articles.id_categorie = categories.id WHERE id_categorie = :id_categorie ORDER BY date DESC LIMIT :debut, :article_par_page;';
$query=$bdd->prepare($sql);
$query-> bindValue(':debut', $debut, PDO ::PARAM_INT);
$query-> bindValue(':article_par_page', $article_par_page, PDO ::PARAM_INT);
$query-> bindValue(':id_categorie', $lacateg, PDO ::PARAM_INT);
$query->execute();

$articles=$query->fetchAll(PDO::FETCH_ASSOC);

?>
<!DOCTYPE html>
<html>

<head>
    <title>articles</title>
    <link rel="stylesheet" href="../style.css" />
    <meta charset="utf-8">
<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
</head>

<body id="al_body">
    <header>
        <?php
        require('header.php');
        ?>
    </header>
    <main id=al_articles>
        <?php       

            foreach ($articles as $article){
        ?>
        <div id=al_article>
        <a class="al_href" href="article.php?id=<?= $article['art_id']?>"><?= $article['titre']?> </a><br>
        <div id="al_date"><?= $article['date']?></div></div><br>
        <?php
        } 
        ?>
        <nav id= al_boutonart >
            <ul class="pagination">
                <li class="btn btn-secondary btn-lg <?=($pageCourante == 1) ? "disabled" :"" ?>">
                    <a href="articles.php?page=<?= $pageCourante-1 ?>&categorie=<?= $lacateg?>" class="btn btn-secondary btn-lg">Précédente</a>
                </li> &emsp;
                <?php
                for($page = 1; $page <= $pagestotales; $page++): ?>
                            <li class="btn btn-secondary btn-lg <?= ($pageCourante == $pages) ? "active" : "" ?>">
                                <a href="articles.php?page=<?=$page?>&categorie=<?=$lacateg?>"class="btn btn-secondary btn-lg"><?= $page ?></a>
                            </li>
                <?php endfor ?>&emsp;
                <li class="btn btn-secondary btn-lg <?=($pageCourante==$pagestotales) ? "disabled" :"" ?>">
                    <a href="articles.php?page=<?= $pageCourante+1 ?>&categorie=<?= $lacateg?>" class="btn btn-secondary btn-lg">Suivante</a>
                </li>
            </ul>
        </nav>
<?php
//  } }
?>
    </main>
    <footer>
        <?php 
        require('footer.php')
        ?>
    </footer>
</body>

</html>