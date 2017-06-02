<?php
namespace controllers;
use micro\orm\DAO;
use models\Virtualhost;

class Display extends ControllerBase
{
	
	
	public function index()
	{
		var_dump($_POST);
	}
	
	
	
	public function host ($idhost)
	{
		
		
		$host=DAO::getOne("models\Host","id=".$idhost);
		$servers=DAO::getAll("models\Server","idHost=".$idhost);
		$virtualhosts=DAO::getAll("models\Virtualhost");
		
		
		
		
		
		
		
		$this->jquery->compile($this->view);
		
		$this->loadView("Display/host.html"
				,array(
						"host"=>$host,
						"servers"=>$servers,
						"vHosts"=>$virtualhosts
					   ) ); 
		
		
		
	}
	
	
	public function virtualhost ($idvirtualhost)
	{
		
		$vHost=DAO::getOne("models\Virtualhost","id=".$idvirtualhost);		
		$vHost_Propertys=DAO::getALL("models\Virtualhostproperty","idVirtualhost=".$idvirtualhost);
		
		
		
		$id_host=1; /*FAUSSE VARIABLE EN ATTENDANT DE RECUPER LA VRAIE*/
		
		
		$this->jquery->compile($this->view);
		
		$this->jquery->exec("Prism.highlightAll();",true);
		
		$this->loadView("Display/virtualhost.html"
		,array(
			"vHost"=>$vHost //Tableau contenant la conf du Vhost concerné
			,"id_host"=>$id_host /*recuperer l'IDhost pour rediriger correctement l'utilisateur*/
				,"vhps"=>$vHost_Propertys //Tableau contenant les properties du Vhost concerné
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