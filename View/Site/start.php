<!--  Sopro in an interactive web-based collaborative brainstorming tool.
      SoPro Copyright (C) 2013  Alvynn CONHYE, Marion DISTLER, Elodie DUFILH, Anthony OSMAR & Maxence VERNEUIL

        This program is free software: you can redistribute it and/or modify
        it under the terms of the GNU General Public License as published by
        the Free Software Foundation, either version 3 of the License, or
        (at your option) any later version.
    
        This program is distributed in the hope that it will be useful,
       but WITHOUT ANY WARRANTY; without even the implied warranty of
        MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
        GNU General Public License for more details.
    
        You should have received a copy of the GNU General Public License
        along with this program.  If not, see <http://www.gnu.org/licenses/>. -->
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