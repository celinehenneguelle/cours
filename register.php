<?php
session_start();


require_once("./pdo.php");



$name=isset($_POST["name"]) ? $_POST["name"] : "";
$password=isset($_POST["password"]) ? $_POST["password"] : "";
$confirm=isset($_POST["confirm"]) ? $_POST["confirm"] : "";
$message= $_SESSION["message"] ??'';
$salt = 'XyZzy12*_';
$stored_hash = 'a3eb43430f110b907f5f50c89d22035c';
 $md5 = hash('md5', 'XyZzy12\*\_h'. htmlentities($password)); 
$md51=hash('md5', 'XyZzy12\*\_h'. htmlentities($confirm));
$error=[];

//on verifie que les champs existent
 if (isset($_POST["name"])  && isset($_POST["password"]) && isset($_POST["confirm"])) {
  $post["name"]=$name;
  $post["password"]=$password;
  $post["confirm"]=$confirm; 

}

//on verifie que les champs ne sont pas vides

 if (empty($_POST['name']) ||empty($_POST['password']) ||empty($_POST['confirm'])) {

$error["remplir"]="vous devez remplir tous les champs";


}

// on hash et on echappe les donnees utilisateur
$password=$md5;
$confirm=$md51;
$name=htmlentities($name);

// on verifie que les mots de passes concordent

 if($password !== $confirm){
 $error["password"]="les mots de passe ne sont pas identiques";}

// on verifie si l utilisateur existe ds la bdd
 $stmt = $pdo->prepare("SELECT * FROM users WHERE name=?");
 $stmt->execute([$name]); 
 $user = $stmt->fetch();
 if ($user) {
   $error["doublon"]="ce nom d'utilisateur existe déja";
 }



if(empty($error)){

  
   $sql = "INSERT INTO users (name,password) VALUE (:name, :password)";

   echo ("<pre>" . $sql . "</pre>");

   $stmt = $pdo->prepare($sql);

   $stmt->execute([
     ":name" => $name,
    ":password" => $md5,
    
   ]);

  header("location: index.php") ;
  $_SESSION["message"]="inscription reussie!connectez vous";
  die();
}



if (isset($_POST["delete"]) && isset($_POST["user_id"])) {
  $sql = "DELETE FROM users WHERE user_id= :id";

  echo "<pre>\n$sql\n</pre>";

  $stmt = $pdo->prepare($sql);

  $stmt->execute([
    ":id" => $_POST["user_id"]
  ]);
}
   $stmt = $pdo->query("SELECT * FROM users");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC);

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

<body>

 
 
  
    
    <form method="POST" class="formulaire">

    <div class="erreur">
           <?php
    if (isset($_POST["envoyer"])){
    
    if(isset($error["remplir"])){
    echo $error["remplir"];}
     if(isset($error["doublon"])){
    echo $error["doublon"];}
 if(isset($error["password"])){
    echo $error["password"];}
    }
   
    ?>
   </div>
        <h1>Enregistrez-vous</h1> 
 

    <p class>Nom d'utilisateur:</p>
        <input type="text" name="name" id="name">
        <p>Mot de Passe:</p>
             <input type="text" name="password" id="password">
        <p>confirmer votre mot de passe:</p>
            <input type="text" name="confirm" id="confirm">
        <input type="submit" name="envoyer" value="S'inscrire" class="btn1">
    
    <a class="lien" href="./index.php">annuler</a>

 </form>
  
 
    
 
</body>

</html>
