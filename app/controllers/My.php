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
				$vhosts=DAO::getAll("models\Virtualhost","idUser=".$user->getId());
				/* var_dump($vhosts); */
				
			
			
			
			
				$this->jquery->compile($this->view);
				$this->loadView("My/index.html"
						,array(
						"tableau_vhost"=>$vhosts
				) );
		}
		
		
		/* PROTECTION DU CONTROLLEUR MY */
		
		else 
		{
			$this->loadView("Auth/pleaselogin.html");
		}
		
	}
}