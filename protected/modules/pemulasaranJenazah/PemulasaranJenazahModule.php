<?php

class PemulasaranJenazahModule extends CWebModule
{
        public $defaultController = 'moduleDashboardPJ';
        public $kelompokMenu = array();
        public $menu = array();
        
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application

		// import the module-level models and components
		$this->setImport(array(
			'pemulasaranJenazah.models.*',
			'pemulasaranJenazah.components.*',
			//RND-8181
//			'laboratorium.controllers.RinciantagihanpasienpenunjangVController',
//			'laboratorium.models.LKRinciantagihanpasienpenunjangV',
//			'laboratorium.models.LBPendaftaranT',
//			'gudangUmum.controllers.PesanbarangTController',
//			'gudangUmum.controllers.MutasibrgTController',
//			'gudangUmum.models.*',
		));
                                
                if(!empty($_REQUEST['modul_id']))
                    Yii::app()->session['modul_id'] = $_REQUEST['modul_id']; 
	}

	public function beforeControllerAction($controller, $action)
	{
		if(parent::beforeControllerAction($controller, $action))
		{
			// this method is called before any module controller action is performed
			// you may place customized code here
                    
                        $this->kelompokMenu = KelompokmenuK::model()->findAllAktif();
                        $this->menu = MenumodulK::model()->findAllAktif(array('modulk.modul_id'=>Yii::app()->session['modul_id']));
			return true;
		}
		else
			return false;
	}
}
