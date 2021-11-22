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
   <?php include "header.php";?> 
</header>

<h1 class="tsignin">Users details</h1>

<?php 

//_________________connect to SQL_________________//

$servername = "localhost";
$username = "root";
$password = "root";

// Create connection

$conn = new mysqli($servername, $username, $password, 'moduleconnexion');

//_________________select DATA_________________//

// get DATA from utilisateurs

$sql = "SELECT * FROM utilisateurs" ;
$query = $conn->query($sql);
$users = $query->fetch_all();

?>

<div class="admin">

<table style="text-align:center"> 

   <theader>
      <th>ID</th>
      <th>login</th>
      <th>prenom</th>
      <th>nom</th>
      <th>password</th>
   </theader>
   <tbody>
      <?php 
         for($i = 0;isset($users[$i]);$i++){
         echo "<tr>";
         foreach($users[$i] as $value){
         echo "<td>".$value."&nbsp"."</td>";
         }
         echo "</tr>";
         }
      ?>
   </tbody>

   </table>
   </div>
 </body>

 <footer>
</footer>

</html>