<?php

require_once 'bdd.php';

// on verifie si on est bien connecté a la base de donné avec l'id utilisateur 
if (isset($_SESSION['id'])) {
    $requete = $bdd->prepare("SELECT * FROM utilisateurs WHERE id = ?");

    $requete->execute(array($_SESSION['id']));

    $user = $requete->fetch();





    if (isset($_POST['soumis'])) 
    {
        
        $newlog = htmlspecialchars($_POST['login']);

        $newmail = htmlspecialchars($_POST['newmail']);

        $password = htmlspecialchars($_POST['password']);

        if (isset($_POST['password']) && !empty($_POST['password']) && password_verify($_POST['password'], $user['password'])) 
        {
            
            
            if (!empty($_POST['pass1']) && !empty($_POST['pass2'])) 
            {
                
                $pass1 = ($_POST['pass1']);
                
                $pass2 = ($_POST['pass2']);
                
                var_dump('On avance mais ou ?');
                
                if ($pass1 != $pass2) 
                {
                    
                    $erreur = 'mdp erreur';
                } else 
                {
                    $newlog = htmlspecialchars($_POST['login']);
                    
                    $newmail = htmlspecialchars($_POST['newmail']);

                    $pass1 = password_hash($_POST['pass1'], PASSWORD_DEFAULT);

                    $pass2 = password_hash($_POST['pass2'], PASSWORD_DEFAULT);

                    $edit_pass = $bdd->prepare("UPDATE utilisateurs SET login = ?, password = ?, email = ? WHERE id = ?");

                    $edit_pass->execute(array($newlog,$pass1, $newmail, $_SESSION['id']));
                    var_dump('BOU');
                    // header("location: pp.php?id=" .$_SESSION['id']);
                }
            }
            
            
            


            if (isset($_POST['newmail']) && !empty($_POST['newmail'])) 
            {
                var_dump('ca va bien ');

                // $newlog = htmlspecialchars($_POST['login']);

                // $newmail = htmlspecialchars($_POST['newmail']);

                // $insertMail = $bdd->prepare("UPDATE utilisateurs SET login = ?, email = ? WHERE id = ?");

                // $insertMail->execute(array($newlog, $newmail, $_SESSION['id']));


                // header("location: pp.php?id=" .$_SESSION['id']);
                

                if (isset($_POST['login']) && !empty($_POST['login']) && $_POST['login'] != $user['login']) 
                {

                    var_dump('ca va ');


                    $newlog = htmlspecialchars($_POST['login']);

                    $newmail = htmlspecialchars($_POST['newmail']);

                    $verif = $bdd->prepare("SELECT * FROM utilisateurs WHERE login=?");

                    $verif->execute(array($newlog));

                    $count = $verif->rowCount();

                   var_dump($count);

                    // header("location: pp.php?id=" . $_SESSION['id']);

                    if ($count > 0) 
                    {
                        $erreur = 'login non disponible !';
    
                    } else 
                    { 
                        var_dump('ok');
                        $insert_log = $bdd->prepare("UPDATE utilisateurs SET login = ?, email = ? WHERE id = ?");
    
                        $insert_log->execute(array($newlog, $newmail, $_SESSION['id']));
    
                        // header("location: edition.php?id=" . $_SESSION['id']);
                        
                     
    
    
                    }
                } elseif (isset($_POST['login']) && !empty($_POST['login']) && $_POST['login'] == $user['login']) {
    
    
                
                    $newlog = htmlspecialchars($_POST['login']);
    
                    $newmail = htmlspecialchars($_POST['newmail']);
    
                    $insert_log = $bdd->prepare("UPDATE utilisateurs SET login = ?, email = ? WHERE id = ?");
    
                    $insert_log->execute(array($newlog, $newmail, $_SESSION['id']));
    
                    // header("location: edition.php?id=" . $_SESSION['id']);
                }
                }
            
        
        } else {
            $erreur = 'MDP erroné';
        }
    }










?>

    <!DOCTYPE html>
    <html lang="Fr">

    <head>
        <meta charset="UTF-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <!-- <link rel="stylesheet" href="style.css" /> -->

        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

        <?php
        // include("link.php"); 
        ?>

        <title>Profil</title>
    </head>

    <body>

        <?php include("header.php"); ?>

        <main class="text_profil">

            <h2 align="center">Profil de <?php echo $_SESSION['login']; ?></h2>



            <form action="" method="POST" class="profil_tab" align="center">
                <table>

                    <input type="text" name="login" placeholder="Modifier votre login" value="<?php echo $user['login']; ?>" /><br>
                    <input type="password" name="password" placeholder="Password" /><br>
                    <input type="email" name="newmail" placeholder="Nouveau Email" value="<?php echo  $user['email']; ?>" /><br>
                    <input type="password" name="pass1" placeholder="Nouveau Password" /><br>
                    <input type="password" name="pass2" placeholder="verifier votre password" /><br>
                    <input type="submit" name="soumis" value=" Mettre à jour mon profil !">

                    <?php
                    if (isset($erreur)) {
                        echo '<p style="color:red"> ' . $erreur . '</p>';
                    }

                    ?>
                </table>
            </form>

            <footer> <?php
                        include("footer.php"); ?></footer>


        </main>

    </body>

    </html>
    <?php
} else 
{
    // si l'utilisateur n'est pas connecté alors on redirect vers la page de connexion .
    header('location: connexion.php');
}



?>