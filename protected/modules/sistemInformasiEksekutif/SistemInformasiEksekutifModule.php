<?php

class SistemInformasiEksekutifModule extends CWebModule
{
//        public $defaultController = 'default';
        public $defaultController = 'ModuleDashboardSE';
        public $kelompokMenu = array();
        public $menu = array();
        public $menu_side = array();
        
	public function init()
	{
		// this method is called when the module is being created
		// you may place code here to customize the module or the application
		// import the module-level models and components
		$this->setImport(array(
			'sistemInformasiEksekutif.models.*',
			'sistemInformasiEksekutif.components.*',
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
                    
			//Menu diatas dinonaktifkan
			$this->kelompokMenu = KelompokmenuK::model()->findAllAktif();
			$this->menu = MenumodulK::model()->findAllAktif(array('modulk.modul_id'=>Yii::app()->session['modul_id']));
			//Menu in sidebar
//			$this->menu_side = MenumodulK::model()->listAllMenu(Yii::app()->session['modul_id']);
			return true;
		}
		else
			return false;
	}
        
        public function getMenu()
        {
            return $this->menu;
        }
}
