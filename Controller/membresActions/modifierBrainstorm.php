<?php
	session_start();
	require_once "../../Controller/membresActions/cnx.php";
	if(!empty($_POST))
	{	
		if($_POST['action']==="modifier"){
			if($_POST['etape']==="1"){
				$error=0;
				if(strlen($_POST['NomProjet'])>=2&&strlen($_POST['description'])>=2){
					if($_POST['phase'] == '2' || $_POST['phase'] == '1' || $_POST['phase'] == '0'){
						if($_POST['dureePhase2']<=24 && $_POST['dureePhase2']>=1){
							$dureePhase2 = $_POST['dureePhase2'].":00:00";
							if($_POST['phase'] == '1' || $_POST['phase'] == '0'){
								if($_POST['dureePhase1']>=10 && $_POST['dureePhase1']<=60){
									$dureePhase1 = "00:".$_POST['dureePhase1'].':00';
									if($_POST['phase'] == '0'){
										if(strlen($_POST['source'])>=2){
											$source = addslashes($_POST['source']);
											$chosenDate = new DateTime($_POST['datedebut'].' '.$_POST['heuredebut']);
											$now = new DateTime("now");
											$chosenDate->add(date_interval_create_from_date_string("5 min"));
											$interval = $now->diff($chosenDate);
											if($interval->format('%R')=='+'){
												$datedebut = $_POST['datedebut'];
												$heuredebut = $_POST['heuredebut'];
											}else{
												$error=1;
												print('<div class="alert alert-error">
													<button type="button" class="close" data-dismiss="alert">&times;</button>
													<strong>Warning! </strong>L\'heure et la date de début du brainstorm ne sont pas correctes.
													</div>');
											}
										}else{
											$error=1;
											print('<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong>L\'idée source du brainstorm doit contenir au moins 2 caractères.
						</div>');

										}
									}
								}else{
									$error=1;
									print('<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong>La durée de la phase 1 doit être comprise entre 10 et 60 minutes.
						</div>');
								}
							}
						}else{
							$error=1;
							print('<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong>La durée de la phase 2 doit être comprise entre 1 et 24 heures.
						</div>');
						}
						
					}
					/*Première étape de la creation du brainstorm avec les données générales et les compétences taggées*/
					if($error==0){
						$nomProjet = ucwords(addslashes($_POST['NomProjet']));
						$description = addslashes($_POST['description']);
						$id = addslashes($_POST['id']);
						$competences = addslashes($_POST['competences']);
						
						$createur = addslashes($_SESSION['Auth']['email']);
						switch($_POST['phase']){
							case "0" :
									$q = Array('id'=>$id,'nom'=>$nomProjet, 'description'=>$description, "createur"=>$createur, 'source'=> $source, 'dateDebut'=> $datedebut, 'heureDebut'=>$heuredebut, 'dureePhase1'=>$dureePhase1, 'dureePhase2'=>$dureePhase2,'competences'=>$competences);
									 $sql = 'UPDATE brainstorming SET nom= :nom, description= :description, createur= :createur, source= :source, dateDebut= :dateDebut, heureDebut= :heureDebut, competences= :competences, dureePhase1= :dureePhase1, dureePhase2= :dureePhase2 WHERE id= :id';
									 $req = DBConnection::get()->prepare($sql);
									 $req->execute($q);
									 break;
							case "1" :
									$q = Array('id'=>$id,'nom'=>$nomProjet, 'description'=>$description, "createur"=>$createur, 'dureePhase1'=>$dureePhase1, 'dureePhase2'=>$dureePhase2,'competences'=>$competences);
									 $sql = 'UPDATE brainstorming SET nom= :nom, description= :description, createur= :createur,  competences= :competences, dureePhase1= :dureePhase1, dureePhase2= :dureePhase2 WHERE id= :id';
									 $req = DBConnection::get()->prepare($sql);
									 $req->execute($q);
									 print("executed");
									 break;
							case "2" : 
									 $q = Array('id'=>$id,'nom'=>$nomProjet, 'description'=>$description, "createur"=>$createur, 'dureePhase2'=>$dureePhase2,'competences'=>$competences);
									 $sql = 'UPDATE brainstorming SET nom= :nom, description= :description, createur= :createur,  competences= :competences, dureePhase2= :dureePhase2 WHERE id= :id';
									 $req = DBConnection::get()->prepare($sql);
									 $req->execute($q);
									 break;
							default : 
									 $q = Array('id'=>$id,'nom'=>$nomProjet, 'description'=>$description, "createur"=>$createur, 'competences'=>$competences);
									 $sql = 'UPDATE brainstorming SET nom= :nom, description= :description, createur= :createur,  competences= :competences WHERE id= :id';
									 $req = DBConnection::get()->prepare($sql);
									 $req->execute($q);
									 break;
						}
					
						print("<div class='alert alert-success alert-block'>
					    <button type='button' class='close' data-dismiss='alert'>&times;</button>
					    <h4>Félicitations!</h4> Les informations de votre brainstorm ont bien été modifiées.
					 	</div>");
					 }
				 }
				 else{
					 if(strlen($_POST['NomProjet'])<2){
						print('<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Warning! </strong>Le nom du brainstorm doit contenir au moins 2 caractères.
							</div>');
					}
					if(strlen($_POST['description'])<2){
						print('<div class="alert alert-error">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<strong>Warning! </strong>La description du brainstorm doit contenir au moins 2 caractères.
							</div>');
	
					} 
				 }										
				}else if($_POST['etape']=='2'){
					/*Suppression des anciennes permissions*/
					$q=Array("brainstorm"=>$_POST['id'], "admin"=>"O");
					$req = DBConnection::get()->prepare("DELETE FROM permission WHERE brainstorm = :brainstorm AND admin = :admin");
					$req->execute($q);
					/*Ajout des participants au brainstorm*/
					$users = preg_split('/;/',$_POST['users'],NULL,PREG_SPLIT_NO_EMPTY);
					$req = DBConnection::get()->prepare("INSERT INTO permission (brainstorm, user) VALUES (:brainstorm, :user)");
					foreach($users as $user){
						if($user!=$_SESSION['Auth']['email'])
							$req->execute(Array('brainstorm'=>$_POST['id'], 'user'=>$user)); 
					}
					$req = DBConnection::get()->prepare("UPDATE brainstorming SET active = :active WHERE id= :id");
					$req->execute(array("active"=>'1', "id"=>$_POST['id']));
					print("<div class='alert alert-success alert-block'>
				    <button type='button' class='close' data-dismiss='alert'>&times;</button>
				    <h4>Félicitations!</h4> Les informations de votre brainstorm ont bien été modifiées.
				 	</div>");
				}
		}elseif($_POST['action']==="supprimer"){
			print("dans supprimer");
			$id = addslashes($_POST['id']);
			$q = array("brainstorm" => $id);
			//Suppression dans la table brainstorm
			$req = DBConnection::get()->prepare("DELETE FROM brainstorming WHERE id = :brainstorm");
			$req->execute($q);
			//Suppression dans la table permission
			$req = DBConnection::get()->prepare("DELETE FROM permission WHERE brainstorm = :brainstorm");
			$req->execute($q);
			//suppression dans la table vote
			$req = DBConnection::get()->prepare("DELETE FROM vote WHERE brainstorm = :brainstorm");
			$req->execute($q);
		}
	}
?>