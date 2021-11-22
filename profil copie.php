<!DOCTYPE html>
<html>
 <head>
 <title>TinkerIT</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="style.css">
  <link rel="shortcut icon" type="image/jpg" href="content/favicon.ico"/>  <!-- ADD FAVICON !-->
 </head>

 <body>

<header>

<a href="index.php"> Home </a>
<?php 

include "header.php";

//_________________connect to SQL_________________//

$servername = "localhost";
$username = "root";
$password = "root";

// Create connection

$conn = new mysqli($servername, $username, $password, 'moduleconnexion');

//_________________select DATA_________________//

// get DATA from utilisateurs
$co_user = $_SESSION['connected'];

$sql = "SELECT * FROM `utilisateurs` WHERE `login` = '$co_user'" ;
$query = $conn->query($sql);
$user = $query->fetch_all();

$sql = "SELECT * FROM `utilisateurs`" ;
$query = $conn->query($sql);
$users = $query->fetch_all();

// Variables form // 

$login=$user[0][1];
$prenom=$user[0][2];
$nom=$user[0][3];
$password1=$user[0][4];
$password2=$user[0][4];

?>

     
</header>
<div class="tsignin">
 <h1>Change your personnal informations</h1>
</div>
<div class="container">
<form method="post" class="myform2">
    <label name="fname">Prénom</label>
        <input type="text" name="fname" value=<?php echo $prenom ?>></input>
    <label name="lname">Nom</label>
        <input type="text" name="lname" value=<?php echo $nom ?>></input>
    <label name="login">Login</label>
        <input type="text" name="login" value=<?php echo $login ?>></input>
    <label name="password1">old Password</label>
        <input type="password" name="password1" ></input>
    <label name="password2">new Password</label>
        <input type="password" name="password2" ></input>
    <input type="submit" name="submit"></input>
    </form>
</div>

 <?php 

//_________________Tests Formulaire_________________// 


if($_POST["submit"]=="Envoyer"){
    if ($login == NULL && $prenom == NULL && $nom == NULL && $password1 == NULL && $password2 == NULL){}
    else {
      $login=$_POST["login"];
      $prenom=$_POST["fname"];
      $nom=$_POST["lname"];
      echo $lname;
      $password1=$_POST["password1"];
      $password2=$_POST["password2"];
        if($login == NULL||$prenom == NULL||$nom == NULL||$password1 == NULL||$password2 == NULL){
            $_SESSION['update'] = 3;
            if($login == NULL){
            $_SESSION['update'] = 0;
            echo "
            <style>
            input[name='login'] {
                background-color: #FFBBBB ;
            }
            </style>         
            ";}
            if($prenom == NULL){
               $_SESSION['update'] = 0;
                echo "
                <style>
                input[name='fname'] {
                background-color: #FFBBBB ;
                }
                </style>         
                ";        }
            if($nom == NULL){
               $_SESSION['update'] = 0;
                echo "
                <style>
                input[name='lname'] {
                background-color: #FFBBBB ;
                }
                </style>         
                ";        }
            if($password1 == NULL){
               $_SESSION['update'] = 0;
                echo "
                <style>
                input[name='password1'] {
                background-color: #FFBBBB ;
                }
                </style>         
                ";        }
            if($password2 == NULL){
               $_SESSION['update'] = 0;
                echo "
                <style>
                input[name='password2'] {
                background-color: #FFBBBB ;
                }
                </style>         
                ";        
            }
        }
        else{
            foreach($users as $users){   // check if Login already exists
                if ( isset($_POST["login"]) && $_POST["login"] == $users[1] && $_POST["login"] !=$user[0][1]){
                  echo "<p id='update'>login alreay taken</p>";
                  $taken = 1;
                  $_SESSION['update'] = 0;
                }
            }
            echo "hey";
            foreach($users as $user){ // check password + store new one
               if ( isset($_POST["login"]) && $_POST["login"] == $user[1] && password_verify($_POST['password'],$user[4]) == true){
                  $password1 = password_hash($password2, PASSWORD_BCRYPT);
               }
            }
            if($taken == false){ // update user infos 
                $u_login = $user[0][1];
                $sql = "UPDATE `utilisateurs` SET prenom = '$prenom', login = '$login', nom ='$nom', password ='$password1' WHERE login = '$u_login'";
                $query = $conn->query($sql);
                $_SESSION['connected'] = $login;
                header("Location:profil.php");
                $_SESSION['update'] = 1;
            }
        }
    }
}   

if($_SESSION['update'] <= 2){
   echo "<p id='update'>update successful</p>   ";
   $_SESSION['update'] ++;
}

?>

<footer>
</footer>

 </body>
 
</html>