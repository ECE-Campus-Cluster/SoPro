<?php 
session_start();
require './membresActions/authentification.php';

if(Auth::islogged()){
}else{
	header("Location:index.php");	
	
}
?>
<!DOCTYPE html>
<html lang="en">
  
  <?php include './common/header.php' ?>
  
  <body>
    <?php include './common/navigation.php' ?>
   

    <div class="container">

<address>
  <strong>SoPro, Inc.</strong><br>
  15 Quai de Grenelle<br>
  France, Paris 75015<br>
  <abbr title="Phone">P:</abbr> 06 83 66 40 37
</address>
 
<address>
  <strong>Full Name</strong><br>
  <a href="mailto:#">first.last@example.com</a>
</address>


<!---------------------------------------------------------CONTAINER --------------------------------------------------------------->
      <?php include './common/footer.php'?>
      
    </div>