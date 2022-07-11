
<?php
require_once('pdo.php');

session_start();
session_unset();

var_dump($_POST);
var_dump($_SESSION);


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

// on verifie que les champs existent et ne sont pas vides
if ((!isset($name) || strlen($name) < 1) ||(!isset($password) || strlen($password) < 1)) {


 $error["vide"]="tous les champs sont requis";
  //  on echappe et hash les donnees
}else{$password=$md5;
$name=htmlentities($name);
}
// on verifie que l utilisateur existe
if(empty($error)){
   $sql = "SELECT * FROM users WHERE name= :name";

   $stmt = $pdo->prepare($sql);

   $stmt->execute([
     ":name" => $name,
   ]);
$rows =$stmt->fetch(PDO::FETCH_ASSOC);
$_SESSION=$rows;
  if(!$rows){
    $error["inconnu"]="identifiants incorrects";
  }}


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





   <?php 
   if(isset($_POST["envoyer"]))
   if(isset($error["vide"])){
    echo $error["vide"];}
     if(isset($error["inconnu"])){
    echo $error["inconnu"];}
     
    
    ?>
      <form method="POST" class="formulairec">
       
        <h1>connectez-vous</h1> 
 

    <p class>Nom d'utilisateur:</p>
        <input type="text" name="name" id="namec">
        <p>Mot de Passe:</p>
             <input type="text" name="password" id="passwordc">
       
        <input type="submit" name="envoyer" value="Se connecter" class="btnc">
    
    <a class="lienc" href="./index.php">annuler</a>

 </form>
  
  </form>
</body>

</html>