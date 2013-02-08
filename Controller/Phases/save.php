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
