
<?php
session_start();

require_once("./pdo.php");

var_dump($_POST);
var_dump($_SESSION);

  $name=$_SESSION["name"]?? '';
$message= $_SESSION["message"]?? '' ;
 ?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" href="./style.css"/>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
</head>
<body> 
   <div class="formulairei">
   
 
 <div class= "reussite"> 
      <?php
      if(isset($_SESSION["message"])){
    echo ('<p style=color:green;">'.htmlentities($_SESSION["message"])."</p>\n");
    unset($_SESSION["message"]); 
    }
 ?> 
 <h1>bienvenue dans la base de données des tâches</h1>
 </div>
    <p><a  href="./register.php">inscrivez-vous</a> / <a href="./connexion.php">connectez-vous</a></p>

<p> Essayez <a href="./app.php"> d'ajouter des données </a> sans vous connecter.</p> 
</div>
</body>
</html>