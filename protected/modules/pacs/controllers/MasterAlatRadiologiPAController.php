<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterAlatRadiologiController');
class MasterAlatRadiologiPAController extends MasterAlatRadiologiController
{
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlAlatRadiologi(){
		return $this->module->id.'/AlatRadiologiPA/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlAlatPemeriksaanRad(){
		return $this->module->id.'/AlatPemeriksaanRadPA/admin';
	}	
}
