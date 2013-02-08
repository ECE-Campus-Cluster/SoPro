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
    
    <span class="span7">
    <br> &nbsp  Notre application a pour objectif de proposer aux utilisateurs un outil de brainstorming en ligne à des personnes réparties entre plusieurs endroits, nous avons fait le choix de l’appeler Réseau SoPro en référence aux Réseaux Sociaux d’Entreprise.
Notre application a été pensée dans un premier temps pour des consultants répartis entre plusieurs endroits qui ont besoin d’un outil de collaboration pour faire émerger les meilleures idées possibles d’une réflexion.<br>
Le brainstorming est un outil simple et efficace de réflexion qui a pour objectif de produire un maximum d’idée. Cette technique demande de prendre un groupe restreint d’individus, ils cherchent des idées pour répondre à une problématique puis les idées sont triées pour ne garder que l’essentiel.
En effet lorsque vous êtes au cœur de l’action, vous êtes la personne la plus à même de connaître les meilleurs solutions mais des échanges avec d’autres vous permettent de prendre du recul sur votre activité et vos idées.<br><br>
L’application principale qui avait été pensée initialement était avec Solucom, société de conseil en IT qui a des consultants chez le client. Ces consultants ont peu d’occasions de se retrouver pour échanger du fait de la distance mais ils ont accès à leur ordinateur et à leur téléphone. L’idée principale est de leur mettre à disposition un outil de brainstorming qui leur permette d’échanger à distance.
Ayant en place un intranet sous Drupal, nous avons eu l’idée de proposer un outil s’y intégrant sous forme de module. Faire des apports open source étant possible avec ce CMS, nous en avons fait un point important de notre projet puisqu’il représente notre valorisation actuelle.
En mettant en place cette aspect, nous pouvons imaginer ouvrir notre outil pas seulement aux consultants mais à toute personne ayant besoin d’un outil de brainstorming afin d’avancer sur un projet.
    </span>
    <div class="span4">
    						<img src="../../View/assets/img/bluetree.jpg"/>
    						</div>
 

  
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