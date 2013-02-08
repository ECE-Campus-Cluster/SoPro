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
	require_once "../../Model/Classes/Brainstorm.php";
	print("inside");
	$bstrm = new Brainstorm($_POST['id']);
	print_r($bstrm);
	if(isset($_POST['cr'])){
		$q = Array('id'=> $_POST['id'], "cr"=> $_POST['cr']);
		$sql = 'UPDATE brainstorming SET compterendu = :cr WHERE id = :id';
		$req = DBConnection::get()->prepare($sql);
		$req->execute($q);
		$brainstorm = new Brainstorm($_POST['id']);
		print('saved');
		}
	$bstrm->nextPhase();
	print_r($bstrm);
?>