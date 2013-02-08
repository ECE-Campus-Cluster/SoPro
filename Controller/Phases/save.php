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
require_once '../../Model/Classes/Brainstorm.php';


	if(isset($_POST['tabN']))
	{		
		$tableauN = array();
		$tableauL = array();
		$tabL = array();
		$tabN = array();
		
		$tabN = json_decode($_POST['tabN'], true);
		
		//tabN de node
		
		for($i=0; $i < sizeof($tabN); $i++){
			$tableauN[$i]['x'] = $tabN[$i]['x'];
			$tableauN[$i]['y'] = $tabN[$i]['y'];	
			$tableauN[$i]['id'] = $tabN[$i]['id'];
			$tableauN[$i]['name'] = $tabN[$i]['name'];
			$tableauN[$i]['parent'] = $tabN[$i]['parent'];
			$tableauN[$i]['degree'] = $tabN[$i]['degree'];
			$tableauN[$i]['hasChild'] = $tabN[$i]['hasChild'];
			$tableauN[$i]['comment'] = $tabN[$i]['comment'];
			$tableauN[$i]['group'] = $tabN[$i]['group'];
	
		}
		$tabN=json_encode($tableauN);

	}
	
	if(isset($_POST['tabL']))
	{	

		$tabL = json_decode($_POST['tabL'], true);
		
		for($i = 0; $i < sizeof($tabL); $i++){
			$tableauL[$i]['source'] = $tabL[$i]['source']['id'];
			$tableauL[$i]['target'] = $tabL[$i]['target']['id'];
	
		}
		$tabL=json_encode($tableauL);

	}
	
	
	if(isset($_POST['lastGroup'])) $group=$_POST['lastGroup'];


	$fp = fopen("../../View/assets/json/".$_POST['id'].".json", 'w');
	fwrite($fp, '{"nodes":' .$tabN . ',"links":'.$tabL.',"lastGroup":'.$group.'}');
	fclose($fp);
	
		
	$brainstorm = new Brainstorm($_POST['id']);
	if($brainstorm->phase==3)
		$brainstorm->nextPhase();


?>
