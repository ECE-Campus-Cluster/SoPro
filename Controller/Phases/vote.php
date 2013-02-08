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
	require_once '../../Controller/membresActions/authentification.php';
	require_once '../../Model/Classes/Brainstorm.php';
	$brainstorm = new Brainstorm($_POST['id']);
	if($brainstorm->hasRights($_SESSION['Auth']['email'])&& !($brainstorm->hasVoted($_SESSION['Auth']['email'])))
	{
		$ideas = preg_split('/;/',$_POST['ideas'],NULL,PREG_SPLIT_NO_EMPTY);
		$sql = 'UPDATE vote SET nombre = nombre + 1 WHERE brainstorm = :brainstorm AND idea = :idea';
		$req = DBConnection::get()->prepare($sql);
		foreach($ideas as $idea){
			$q = Array('brainstorm'=>$_POST['id'], 'idea'=>$idea);
			$req->execute($q);
		}
		$q = Array('brainstorm'=>$_POST['id'], 'user'=>$_SESSION['Auth']['email']);
		$sql = 'UPDATE permission SET vote = 1 WHERE brainstorm = :brainstorm AND user = :user';
		$req = DBConnection::get()->prepare($sql);
		$req->execute($q);
	}
?>