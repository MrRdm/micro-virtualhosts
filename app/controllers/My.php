<?php
namespace controllers;
use libraries\Auth;
use micro\orm\DAO;
use Ajax\semantic\html\content\view\HtmlItem;
/**
 * Controller My 
 **/
class My extends ControllerBase{
	
	/**
	 * Mes services
	 * Hosts et virtualhosts de l'utilisateur connecté
	 */
	
	
	public function index(){
		
		if(Auth::isAuth()){
			$user=Auth::getUser();
			$hosts=DAO::getAll("models\Host","idUser=".$user->getId());
			
	//permet d'affiche, obligé de l'appeler dans twig'
			$hostsItems=$this->semantic->htmlItems("list-hosts");
			$hostsItems->fromDatabaseObjects($hosts, function($host){
				$item=new HtmlItem("");
				$item->addImage("public/img/host.png")->setSize("tiny");
				$item->addItemHeaderContent($host->getName(),$host->getIpv4(),"");
				return $item;
				
			
			});

			
	//TODO1
		
				//Acceder à tous les vhosts en fonction de l'userID passé en paramètres
				//utilise un des models pour acceder à un des virtuals hosts 
				//met das un variable tous les vhosts grâce à la fonction memebre presente dans le modèle virtualhost.php qui lui même va les chercher dans la database
				// mais y a un paramètre idUser, que l'on applicuqe getID, pour avoir seulement ID du user (on choppe une donné de l'onjet user')
				$vhosts=DAO::getAll("models\Virtualhost","idUser=".$user->getId());
				

				//Permet de compiler en Java
				$this->jquery->compile($this->view);

				//Permet de charger dans la vue les variables instanciées dans le contrôleur(=cette page)
				$this->loadView("My/index.html"
						,array(
						"tableau_vhosts"=>$vhosts
						//"tableau_server"=>$vhosts_server


				) );
			
		}
		
	//TODO4

		/* PROTECTION DU CONTROLLEUR MY */
		
		else 
		{
			//Utilisation de PHP-MVUI
			//Pris dans le contrôler login
			//pas obligé twing parce qu'on l'appel directement ici avec echo $message
			//Créer un objet "message" et on lui applique la méthode semantic (pour dire utilise semanticui) et html message (permet de mettre "merci de vous connecter pour tester") 
			$message=$this->semantic->htmlMessage("error","Merci de vous connecter pour tester.");
			//rejoute l'icone au message affiché précedament avec la méthode setIcon créer par le grand dieu'
			$message->setIcon("announcement")->setError();
			//Ajouter la croix en haut à gauche pour fermer la mesage percedement affiché
			$message->setDismissable();
			//permet d'ajouter le bouton pour le test, on a changé la librairie Login:: en Auth::
			$message->addContent(Auth::getInfoUser($this,"-login"));
			//Affichage de l'objet $message
			echo $message;
			//Utilisation de Java pour pouvoir cliquer sur le bouton pour s'identifier'
			echo $this->jquery->compile($this->view);
		}
		
	}
}
