<?php
require_once 'bdd.php';
include('header.php');

// on commence par verifier si les input existe
if (isset($_POST['login']) && isset($_POST['password'])) 
{
    
    // ensuite on stock dans des html specialchars pour eviter les fails xss

    $login = htmlspecialchars($_POST['login']);
    $password = htmlspecialchars($_POST['password']);

    // ensuite on check si l'utilisateur exist en BDD 

    $check = $bdd->prepare('SELECT id, login, password, email, id_droits FROM utilisateurs WHERE login = ?');
    $check->execute(array($login));
    $data = $check->fetch();
    $row = $check->rowCount();
    var_dump($data);
    if ($row == 1) 
    {
        


         if (password_verify($password,$data['password'])) 
         {
            $_SESSION['login'] = $data['login'];
            $_SESSION['id'] = $data['id'];
            $_SESSION['password'] = $data['password'];
            $_SESSION['email'] = $data['email'];
            $_SESSION['id_droits'] = $data['id_droits'];

         header('location:index.php');
         }
         else  $erreur = 'Vôtre login ou mot de pass est éronné !';
    }     else  $erreur = 'Vôtre login ou mot de pass est éronné !';
}    

?>


<!DOCTYPE html>
<html lang="fr">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>connexion</title>
</head>

<body>
    <div class="login_form">
        <form action="connexion.php" method="post">
            <h2 class="text_center">Connexion</h2>
            <div class="form_groupe">
                <input type="login" name="login" class="form_control" placeholder="Login" required="required" autocomplete="off">
            </div>
            <div class="form_groupe">
                <input type="password" name="password" class="form_control" placeholder="Mot de passe" required="required" autocomplete="off">
            </div>
            <div class="form_group">
                <button type="submit" class="">Connexion</button>
            </div>
        </form>
        <p class="text_center"><a href="inscription.php">Inscription</a></p>
    </div>
</body>
<?php
    if (isset($erreur)) {
      echo '<p style="color:red"> ' . $erreur . '</p>';
    }

    ?>

</html>