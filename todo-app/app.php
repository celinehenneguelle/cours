 <?php
 session_start();
require_once("./pdo.php");
$user=$_SESSION["user_id"] ??'';
$success= $_SESSION["success"]??'';
$error= $_SESSION["error"]??'';

 if (!isset($_SESSION["user_id"])) {
    die("ACCES REFUSÉ");
    return;
}

if (isset($_POST['title']) && isset($_POST['creer']) && isset($_SESSION["user_id"])){// On vérifie que la variable POST existe

    if (empty($_POST['title'])) {  // On vérifie qu'elle as une valeure
      $_SESSION['error'] = "Tous les champs sont requis";
      header("location: app.php");
      return;

}
   else {
        $title = $_POST['title'];
        $title=htmlentities($title); }



        
    if(empty($_SESSION['error'])){    
     $sql = "INSERT INTO tasks (title, user_id) VALUE (:title ,:user_id)";

  

   $stmt = $pdo->prepare($sql);

   $stmt->execute([
     ":title" => $_POST["title"],
     ":user_id"=>$_SESSION['user_id'],
    ]);
   $_SESSION["success"]="tache ajoutée";

  
   }
   
}

if (isset($_POST["delete"]) && isset($_POST["task_id"])) {
  $sql = "DELETE FROM tasks WHERE task_id= :task_id";

  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ":task_id" => $_POST["task_id"]
  ]);
  $_SESSION["success"] = "tache supprimée";
 header("location: app.php");
 return;  
}
    $stmt = $pdo->query("SELECT * FROM tasks");
 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);


 

if (isset($_POST["edit"]) && isset($_SESSION["user_id"])) {
    $_SESSION["task_id"] = $_POST["task_id"];
  unset($_SESSION["error"]);
    header("location:edit.php");
    return;
}

if(isset($_SESSION["user_id"]));
$sql="SELECT * FROM tasks WHERE user_id = :user_id";
 $stmt= $pdo->prepare($sql);
 $stmt->execute ([":user_id" => $_SESSION["user_id"]]);
 $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
 ?><!DOCTYPE html>
<html lang="en">
<link rel="stylesheet" href="style.css"/>

<head>
<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Document</title>
<link rel="stylesheet" href="style.css"/>
</head>
<body>


<form class="formulaireta" method="post" action="">
    <h2>Tâches à faire de <?php echo $_SESSION['name'] ?> </h2>
    <?php
  echo "<table>";
  foreach ($rows as $row) {
    $tab = <<<EOL
      <tr>
        <td>{$row["title"]}</td>
        <td>
          <input type="hidden" name="task_id" value="{$row["task_id"]}">
            <input type="submit" name="edit" value="édit"class="tab" >
        
        </td>
        <td>
          <form method="POST">
          <input type="hidden" name="task_id" value="{$row["task_id"]}">
            <input type="submit" name="delete" value="delete" class="tab">
          </form>
        </td>
      </tr>
    EOL;
    echo $tab;
  }
  echo "</table><br><br>";

  
  if(isset($_SESSION["success"])){
    echo ('<p style=color:green;">'.htmlentities($_SESSION["success"])."</p>\n");
    unset($_SESSION["success"]); 
    }

    if (isset($_SESSION['error'] )) {
      echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
      unset($_SESSION['error']);
 }
    ?>
     <label for="title"> Creer une tache </label><br><br>
     <input id="title" type="text" name="title"/><br><br>
    <button class="btn" name="creer">creer</button>
      <a href="./index.php">
        <button type="button" class="btn">annuler</button></a>
        <a href="./logout.php">  
               <button type="button" class="btn">deconnection</button></a>
</form>


 
 




