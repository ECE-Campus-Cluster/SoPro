<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
  <?php include '../../View/common/header.php'   ?>
  
  <body>
    <?php include '../../View/common/navigation.php' ?>
  


    <div class="container">
    
    <span class="span12" style="margin-left:-50px;">
    <br> <object type="application/pdf" name="PDF" id="PDF" style="width:1250px; height:700px"> 
<param name="src" value="../../View/assets/sopro_manuel.pdf" /> 
</object> 

<script type="text/javascript"> 
PDF.SetShowToolBar("true"); //--- barre d'outils true(visible) false(non visible) ---// 
PDF.SetShowScrollbar("false"); //--- barre de scroll true(visible) false(non visible) ---// 
PDF.SetPageMode("none"); //--- cache les signets ---// 
PDF.setZoom(80%); //--- Zoom le document à 80% ---// 
</script>


    
    </span>
  
</div>    
     <!---------------------------------------------------------CONTAINER --------------------------------------------------------------->
      <?php include '../../View/common/footer.php'?>
    <!-- /container -->

    <!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
     <script src="../../View/assets/js/jquery.js"></script>
    <script src="../../View/assets/js/bootstrap-dropdown.js"></script>


  </body>
</html>