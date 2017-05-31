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
			
	
			$hostsItems=$this->semantic->htmlItems("list-hosts");
			$hostsItems->fromDatabaseObjects($hosts, function($host){
				$item=new HtmlItem("");
				$item->addImage("public/img/host.png")->setSize("tiny");
				$item->addItemHeaderContent($host->getName(),$host->getIpv4(),"");
				return $item;
				
			
			});

			
			
			
				//A faire : ajouter virtualhosts
				//Acceder à tous les vhosts en fonction de l'userID passé en paramètres
				//utilise un des models pour acceder à un des virtuals hosts 
				$vhosts=DAO::getAll("models\Virtualhost","idUser=".$user->getId());
				
				//Acceder au server des vhosts [NON FONCTIONNEL]
				$vhosts_server=$vhosts->getServer();

				//Permet de compiler
				$this->jquery->compile($this->view);

				//Permet de charger dans la vue les variables instanciées dans le contrôleur(=cette page)
				$this->loadView("My/index.html"
						,array(
						"tableau_vhosts"=>$vhosts,
						"tableau_server"=>$vhosts_server


				) );
			
		}
		
		
		/* PROTECTION DU CONTROLLEUR MY */
		
		else 
		{
			$this->loadView("Auth/pleaselogin.html");
		}
		
	}
}