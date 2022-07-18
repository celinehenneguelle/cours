
<?php
require_once('pdo.php');

session_start();
session_unset();




$name = $_POST["name"] ?? '';
$password = $_POST["password"] ?? '';
$error=[];
$salt = 'XyZzy12*_';
$stored_hash = 'a3eb43430f110b907f5f50c89d22035c';
 $md5 = hash('md5', 'XyZzy12\*\_h'. htmlentities($password)); 

if (isset($_POST["cancel"])) {
  header("Location: ./index.php");
   return;
 }
if ((!isset($name) || strlen($name) < 1) ||(!isset($password) || strlen($password) < 1)) {

 $error["vide"]="tous les champs sont requis";

}else{$password=$md5;
$name=htmlentities($name);
}

if(empty($error)){
 if(!empty(trim($_POST['name'])) AND !empty(trim($_POST['password']))){

      $requser = $pdo->prepare("SELECT * FROM users WHERE  name = ? AND password = ?");
      $requser->execute(array($name, $password,));
      $userexist = $requser->rowCount();
      if($userexist == 1) {
         $userinfo = $requser->fetch(PDO::FETCH_ASSOC);
         var_dump($userinfo);
         $_SESSION['user_id'] = $userinfo['user_id'];
         $_SESSION['name'] = $userinfo['name'];
         $_SESSION['password'] = $userinfo['password'];
         header("Location: app.php?user_id=".$_SESSION['user_id']);
      } else {
         $error['inconnu'] = "Mauvais identifiant ou mot de passe !";
      }
   } else {
      $message = "Tous les champs doivent être complétés !";
   }
}

if(empty($error)){ 
  
  header("Location: ./app.php");
   return;}

?>

<!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="style.css"/>

<head>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
</head>

<body class="c">





  
    
    
      <form method="POST" class="formulairec">
       
        <h1>connectez-vous</h1> 
  <?php 
 if (isset($_POST["envoyer"])){
   if(isset($error["vide"])){
    echo"<p style='color: red'> {$error["vide"]}";}
     if(isset($error["inconnu"])){
    echo"<p style='color: red'> {$error["inconnu"]}";}
   }
     ?>

    <p>Nom d'utilisateur:</p>
        <input type="text" name="name" id="namec">
        <p>Mot de Passe:</p>
             <input type="text" name="password" id="passwordc">
       
        <input type="submit" name="envoyer" value="Se connecter" class="btnc">
    
    <a class="lienc" href="./index.php">annuler</a>

 </form>
  
  </form>
</body>

</html>