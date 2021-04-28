<?php
class Db
{
    private static $instance = null;
    private $_db;

    private function __construct()
    {
        try {
            $this->_db = new PDO('mysql:host=localhost;port=3306;dbname=studentvote;charset=utf8','root','');
            $this->_db->setAttribute(PDO::ATTR_ERRMODE,PDO::ERRMODE_EXCEPTION);
			$this->_db->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE,PDO::FETCH_OBJ);
        } 
		catch (PDOException $e) {
		    die('Erreur de connexion à la base de données : '.$e->getMessage());
        }
    }

	# Singleton Pattern
    public static function getInstance()
    {
        if (is_null(self::$instance)) {
            self::$instance = new Db();
        }
        return self::$instance;
    }

    public function validerUtilisateur($pseudo, $motdepasse){
        $query = 'SELECT password FROM members WHERE username = :pseudo ';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':pseudo',$pseudo);
        $ps->execute();

        if($ps->rowCount() == 0)
            return false;
        $hash = $ps->fetch()->password;
            return password_verify($motdepasse, $hash); #On verifie à l'aide de la fonction 
                                                        #password_verify le mot de passe entrer pas l'utilisateur
                                                        #hash-Bowlfish
    }

    # Fonction qui exécute un SELECT dans la table des ideas
    # et qui renvoie un tableau d'objet(s) de la classe Ideas
    public function selectIdea() {
        $query = 'SELECT i.*, m.username FROM ideas i, members m WHERE i.author=m.id_member';
        $ps = $this->_db->prepare($query);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            //var_dump($row);
            $tableau[] = new Idea($row->id_idea,$row->username,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date);
        }
        # Pour debug : affichage du tableau à renvoyer
        
        return $tableau;
    }
    public function selectMyIdea($pseudo) {
        $query = 'SELECT i.* FROM ideas i WHERE i.author = (SELECT m.id_member  FROM members m WHERE m.username = :pseudo)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':pseudo',$pseudo);
        $ps->execute();

        $tableau = array();
        while ($row = $ps->fetch()) {
            //var_dump($row);
            $tableau[] = new Idea($row->id_idea,$row->author,$row->title,$row->text,$row->status,$row->submitted_date,$row->accepted_date,$row->refused_date,$row->closed_date);
        }
        # Pour debug : affichage du tableau à renvoyer
        
        return $tableau;
    }

    public function insertMembers($username,$email,$password) {
        $query = 'INSERT INTO members (username, e_mail, password) values (:username, :email, :password)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':username',$username);
        $ps->bindValue(':email',$email);
        $ps->bindValue(':password',$password);
        $ps->execute();
    }

    public function validePseudo($pseudo){
        $query = 'SELECT count(username) AS "nbr" FROM members WHERE username LIKE :pseudo';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':pseudo',"$pseudo");
        $ps->execute();
        $raw = $ps->fetch();
        if ($raw->nbr>0)
            return false;
        return true;
    }
    public function insertIdea($login,$titel_idea,$idea,$time_start) {
        $query = 'INSERT INTO ideas (login, titel_idea, idea, time_start) values (:login, :titel_idea, :idea, :time_start)';
        $ps = $this->_db->prepare($query);
        $ps->bindValue(':login',$login);
        $ps->bindValue(':titel_idea',$titel_idea);
        $ps->bindValue(':idea',$idea);
        $ps->bindValue(':time_start',$time_start);
        $ps->execute();
    }

}