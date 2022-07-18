<?php
session_start();

require_once("./pdo.php");

if (isset($_POST["deconnexion"])) {
  header("Location: ./logout.php");
  return;
} 

if(isset($_POST["edit"]) && empty($_POST['task'])){

 $_SESSION['error'] = "Tous les champs sont requis";
  header("Location: edit.php?todos_id=".$_REQUEST['id']);
  return;

}
  
 if(isset($_POST["edit"]) && isset($_POST['task'])&& !empty($_POST["task"]))
 {
  $sql = "UPDATE tasks SET title = :title WHERE task_id = :task_id";
  $stmt = $pdo->prepare($sql);
  $stmt->execute([
    ":title" => $_POST["task"],
   ":task_id"=> $_SESSION["task_id"]
  ]);
 $_SESSION["success"] = "tache modifié";
 unset($_SESSION["erreur"]);
 header("location: app.php");
 return;   
}

 

$stmt= $pdo->query("SELECT * FROM tasks WHERE user_id={$_SESSION['user_id']}");
$rows = $stmt->fetchAll(PDO::FETCH_ASSOC)
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Application || TO DO LIST</title>
   
    <link rel="stylesheet" href="./style.css">
</head>
<body>
 
 <?php         
        
 
  foreach ($rows as $row) {
    $tab = <<<EOL
      <tr>
        <td>{$row["title"]}</td>
        
        <td>
          <form method="POST">
          <input type="hidden" name="user_id" value="{$row["task_id"]}">
          <input type="hidden" name="title" value="{$row["title"]}">
            <input type="submit" name="delete" value="supprimer">
          </form>
        </td>
      </tr>
    EOL;
   
  }
 
         if(isset($_SESSION["success"])){
    echo ('<p style=color:green;">'.htmlentities($_SESSION["success"])."</p>\n");
    unset($_SESSION["success"]); 
    } 
        
  ?> 
   
  
    <form action="" method="POST" class="formulaire">
        
    
           <h2>Modifier</h2>  
      <?php
                if(isset($_SESSION["success"])){
    echo ('<p style=color:green;">'.htmlentities($_SESSION["success"])."</p>\n");
    unset($_SESSION["success"]); 
    } 
        
                if (isset($_SESSION['error'] )) {
      echo('<p style="color: red;">'.htmlentities($_SESSION['error'])."</p>\n");
      unset($_SESSION['error']);

      }
                 if (isset($message)) {
                    echo('<p style="color: red;">'.htmlentities($message)."</p>\n");
                }
            ?>
  <input type="text" name="task" id="title"value="<?= $row["title"]
  ?>">
            <button type="submit" name="edit" class="btn">Modifier</button>
                             
         <a href="" name="videTotal">Vider La Liste</a>
 

     <button class="btn"name="deconnexion">Se Déconnecter</button>
       </form>
</body>
</html>