<!-- // Une page contenant un formulaire d’inscription (inscription.php) :
//     Le formulaire doit contenir l’ensemble des champs présents dans la table
//     “utilisateurs”  
// id, int, clé primaire et Auto Incrément
// - login, varchar de taille 255
// - password, varchar de taille 255
// - email, varchar de taille 255
// - id_droits, int 
//  ainsi qu’une confirmation de mot de passe. 
//  Dès qu’un utilisateur remplit ce formulaire, les données sont insérées dans la base de données et l’utilisateur est dirigé vers la page de connexion. -->

<?php
require_once 'bdd.php';








if (isset($_POST['form_inscription']))
// si le formulaire est soumis alors 
{
 
    if (!empty($_POST['login']) && !empty($_POST['password']) && !empty($_POST['password2']) && !empty($_POST['email']))
    {
        // on verifie que tous les champs sont différent de vide et 
     
        if ($_POST['password'] === $_POST['password2'])
        //si les deux mot de pass sont identique alors 
        {
                        
            $requete = $bdd->query("SELECT COUNT(*) FROM `utilisateurs` WHERE login = '$_POST[login]'");
            
            $requete->execute();
            $result = $requete->fetch();
           
            // on fait une requete en BDD pour compter le nombre de login correspondant a celui rentrer par l'utilisateur
        
            if ($result['COUNT(*)'] == 1)
            { // et on vérifie que le login est bien disponible
               
                $erreur = 'Login non disponible !';
            }
            // Si tout est ok alors on inscrit en base de donné 
            else {
             
                $login = htmlspecialchars($_POST['login']);
                $password = password_hash($_POST['password'], PASSWORD_DEFAULT);
                $email = htmlspecialchars($_POST['email']);
        
             
                $requete_insert = $bdd->prepare("INSERT INTO utilisateurs (login, password, email, id_droits) VALUES (?,?,?,?)");
                $requete_insert->execute(array($login,$password,$email,1));
               

              
                // si tout est ok alors on redirige vers la page de connexion 
                header('location: connexion.php');
            }
        } else {
            $erreur = "Vos password ne correspondent pas !";
        }
    }  
    else {
        $erreur = 'Tous les champs doivent être complété !';
    }
}

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <link rel="stylesheet" href="style.css" />
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <?php
    // include("link.php") ?>

    <title>inscription</title>
</head>

<body>
    <header>
        <?php
        include("header.php")
        ?>
    </header>


    <body>
        <div align="center">
            <h2>Inscription</h2>
            <br /> <br />
            <form action="" method="POST">
                <table>
                    <tr>
                        <td>
                            <label for="login">Votre pseudo:</label>
                        </td>

                        <td>
                            <input type="text" placeholder="Votre pseudo" name="login" value="<?php if (isset($login)) {
                                                                                                    echo $login;
                                                                                                } ?>">
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password">Password:</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Mot de pass" id="password" name="password"> <br>
                        </td>
                        <td>
                    </tr>
                    <tr>
                        <td>
                            <label for="password">Confirmer votre password:</label>
                        </td>
                        <td>
                            <input type="password" placeholder="Confirmer votre mot de pass" id="password2" name="password2"> <br>
                        </td>
                        
                        <tr>
                        <td>
                            <label for="email">Votre Email:</label>
                        </td>
                        <td>
                            <input type="email" placeholder="Email" id="email" name="email"> <br>
                        </td>
                        </tr>
                        </td> <br>
                    <tr>
                        <td></td>
                        <td>
                            <input type="submit" value="envoyer" name="form_inscription">
                        </td>
                    </tr>
                    </tr>
                </table>
            </form>

            <?php
    if (isset($erreur)) {
      echo '<p style="color:red"> ' . $erreur . '</p>';
    }

    ?>
        </div>
        <footer>
            <?php
            include("footer.php")
            ?>
        </footer>
    </body>

</html>