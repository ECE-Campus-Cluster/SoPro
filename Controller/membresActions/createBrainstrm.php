<?php
	session_start();
	require_once "../../Controller/membresActions/cnx.php";
	require_once "../../Model/Classes/users.php";
	
	if(!empty($_POST))
	{	
		
		if($_POST['etape']==="1"){
			
			if(strlen($_POST['NomProjet'])>=2 &&  strlen($_POST['description'])>=2 &&  strlen($_POST['source'])>=2 &&  $_POST['dureePhase1']>=10 && $_POST['dureePhase1']<=60 && $_POST['dureePhase2']>=1 && $_POST['dureePhase2']<=24){
				/*Vérification de la date et de l'heure*/
				$chosenDate = new DateTime($_POST['datedebut'].' '.$_POST['heuredebut']);
				$now = new DateTime("now");
				$chosenDate->add(date_interval_create_from_date_string("5 min"));
				$interval = $now->diff($chosenDate);
				if($interval->format('%R')=='+'){
					/*Première étape de la creation du brainstorm avec les données générales et les compétences taggées*/
					$nomProjet = ucwords(addslashes($_POST['NomProjet']));
					$description = addslashes($_POST['description']);
					$id = addslashes($_POST['id']);
					$competences = addslashes($_POST['competences']);
					$createur = addslashes($_SESSION['Auth']['email']);
					$source = addslashes($_POST['source']);
					$dureePhase1 = "00:".$_POST['dureePhase1'].':00';
					$dureePhase2 = $_POST['dureePhase2'].":00:00";
					$q = Array('id'=>$id,'nom'=>$nomProjet, 'description'=>$description, "createur"=>$createur, 'source'=>$source, 'dateDebut'=>$_POST['datedebut'], 'heureDebut'=>$_POST['heuredebut'], 'dureePhase1'=>$dureePhase1, 'dureePhase2'=>$dureePhase2,'competences'=>$competences);
					$sql = 'INSERT INTO brainstorming (id, nom, createur, source, description, dateDebut, heureDebut, dureePhase1, dureePhase2, competences) VALUES (:id, :nom, :createur, :source,:description, :dateDebut, :heureDebut, :dureePhase1, :dureePhase2, :competences)';
					$req = DBConnection::get()->prepare($sql);
					$req->execute($q);
					$req2 = DBConnection::get()->prepare("INSERT INTO permission (brainstorm, user, admin) VALUES (:brainstorm, :user, :admin)");
					$req2->execute(Array('brainstorm'=>$id,'user'=>$_SESSION['Auth']['email'], 'admin'=>'1'));	
				}else{
					print('<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong>L\'heure et la date de début du brainstorm ne sont pas correctes.
						</div>');
				}
			}else{
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
				if(strlen($_POST['source'])<2){
					print('<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong>L\'idée source du brainstorm doit contenir au moins 2 caractères.
						</div>');
				} 
				if( $_POST['dureePhase1']<10 || $_POST['dureePhase1']>60){
					print('<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong>La durée de la phase 1 doit être comprise entre 10 et 60 minutes.
						</div>');
				}
				if($_POST['dureePhase2']<0 || $_POST['dureePhase2']>24){
					print('<div class="alert alert-error">
						<button type="button" class="close" data-dismiss="alert">&times;</button>
						<strong>Warning! </strong>La durée de la phase 2 doit être comprise entre 1 et 24 heures.
						</div>');
				}
			}
			
		}else if($_POST['etape']=='2'){
			/*Ajout des participants au brainstorm*/
				$users = preg_split('/;/',$_POST['users'],NULL,PREG_SPLIT_NO_EMPTY);
				$req = DBConnection::get()->prepare("INSERT INTO permission (brainstorm, user) VALUES (:brainstorm, :user)");
				foreach($users as $user){
					if($user!=$_SESSION['Auth']['email'])
						$req->execute(Array('brainstorm'=>$_POST['id'], 'user'=>$user)); 
				}
			$req = DBConnection::get()->prepare("UPDATE brainstorming SET active = :active WHERE id= :id");
			$req->execute(array("active"=>'1', "id"=>$_POST['id']));
		}
	}
	
	

?>