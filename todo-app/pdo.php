<?php
$host ="localhost";
$user="root";
$password ="";
$dbname="todo_app";
// dsn
$dsn = "mysql:host = $host;dbname=$dbname";

//creer une instance pdo
try{
$pdo = new PDO($dsn, $user,$password,);
// pdo errmode_exetion affic un fatal error
}catch(Exception $e){
echo "exeption message: ".
$e->getMessage();

}
$pdo->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);