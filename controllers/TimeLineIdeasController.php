<?php 
class TimeLineIdeasController {

	private $_db;
		
	public function __construct($db){	
		$this->_db = $db;
	}
	
	public function run(){


		$notification = '';
		$notificationIdea = '';
		if (!empty($_POST['form_publish_idea'])){ #il faut verifier si le formulaire n'est pas vifr
			if(empty($_POST['title_idea']) && empty($_POST['text_idea'])){
				$notificationIdea = 'Veuillez entrer un titre et un texte pour votre nouvelle idée';
			}else if (empty($_POST['title_idea'])){
				$notificationIdea = 'Veuillez entrer un titre!';
			}else if (empty($_POST['text_idea'])){
				$notificationIdea = 'Veuillez entrer du texte, les idées vides n\'ont pas leur place ici.';
			}else{
			date_default_timezone_set('Australia/Melbourne');
			$date = date('m/d/Y h:i:s a', time());

			$date = date('Y-m-d h:i:s');
			$id_member = $this->_db->getIdMember($_SESSION['login']);
				$this->_db->insertIdea($id_member,$_POST['title_idea'],$_POST['text_idea'],$date);
				$notificationIdea='Ajout bien fait';
			}
		}
        
		
		/*if(!empty($_POST['form_idea'])){
			if(empty($_POST['titel_idea'])){
				$notification="il faut un titre a votre idée";
			}else if(empty($_POST['idea'])){
				$notification="il vous faut une idée";
			}else {
				$this->_db->insertIdea($_POST['login'],$_POST['titel_idea'],$_POST['idea'],$time_start);
				$pseudo = $_POST['login'];
				$notification='votre idea a bien été uploder';
			}

		}*/
		$notification = "Fil d'idées";
		$tabIdeas = $this->_db->selectIdea();
		
		require_once(VIEWS_PATH.'timelineideas.php');
	}
	
}
?>