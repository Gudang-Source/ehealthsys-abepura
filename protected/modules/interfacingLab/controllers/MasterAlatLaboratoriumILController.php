<?php
Yii::import('sistemAdministrator.models.*');
Yii::import('sistemAdministrator.controllers.MasterAlatLaboratoriumController');
class MasterAlatLaboratoriumILController extends MasterAlatLaboratoriumController
{
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlAlatLaboratorium(){
		return $this->module->id.'/AlatLaboratoriumIL/Admin';
	}
	/**
	 * url untuk tab menu
	 * @return type
	 */
	public function getUrlAlatPemeriksaanLab(){
		return $this->module->id.'/AlatPemeriksaanLabIL/admin';
	}
	
}
