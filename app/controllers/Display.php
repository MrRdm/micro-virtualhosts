<?php
namespace controllers;
use libraries\Auth;
use micro\orm\DAO;
use Ajax\semantic\html\content\view\HtmlItem;
use models\Virtualhost;

class Display extends ControllerBase
{
	
	
	public function index()
	{
		var_dump($_POST);
	}
	
	
	
	
/* TODO 2 */
	
	
	
	
	
	
	
	/*
	 * 
	 * 
	 * /!\ Besoin de la variable $id_host contenant L'ID HOST /!\
	 * 
	 */
	public function virtualhost ($idvirtualhost)
	{
		
		$vHost=DAO::getOne("models\Virtualhost","id=".$idvirtualhost);		
		$vHost_Propertys=DAO::getALL("models\Virtualhostproperty","idVirtualhost=".$idvirtualhost);
		
		
		
		$id_host=1; /*FAUSSE VARIABLE EN ATTENDANT DE RECUPER LA VRAIE*/
		
		
		$this->jquery->compile($this->view);
		
		$this->jquery->exec("Prism.highlightAll();",true);
		
		$this->loadView("Display/virtualhost.html"
		,array(
			"vHost"=>$vHost
			,"id_host"=>$id_host /*recuperer l'IDhost pour rediriger correctement l'utilisateur*/
			,"vhps"=>$vHost_Propertys 
		)); 
		
			
	}
	
	
	
	/*                                                            
	 * Arriver sur cette fonction si on clique sur le boutton de conf. dans My
	 */                                                        
	
	public function confvhost ($idvirtualhost)
	{
		
		$vHost=DAO::getOne("models\Virtualhost","id=".$idvirtualhost);
		
		
		
		/*
		 * setConf($_POST[newConfiguration])
		 * etc..
		 * 
		 */
		
		if ( isset( $_POST ["newConfiguration"]) )
		{
			
			if ( $_POST["newConfiguration"] !== "")
			{
				$vHost->setConfig($_POST["newConfiguration"]);
			}
			if ($_POST["newServeur"] !== "")
			{
				$vHost->setServer($_POST["newServeur"]);
			}
			if ($_POST["newAddresse"] !== "")
			{
				$vHost->setName($_POST["newAddresse"]);
			}
		
		}
		
		
		$this->loadView("Display/confvhost.html"
				,array(
						"id_vhost"=>$idvirtualhost
				));








		
		
		
		
		
		
		
		
		
		
	}
	
	
}
