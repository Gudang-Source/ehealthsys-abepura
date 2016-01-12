<?php
Yii::import('rawatJalan.controllers.InformasiTarifController');
Yii::import('rawatJalan.models.*');
Yii::import('rawatJalan.views.informasiTarif');
class InformasiTarifMCController extends InformasiTarifController
{
	public $path_view = 'mcu.views.informasiTarifMC.';
	
	public function actionIndex()
	{
		$modTarifTindakanRuanganV = new RJTarifTindakanPerdaRuanganV('search');
		$modTarifTindakanRuanganV->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
		if(isset($_GET['RJTarifTindakanPerdaRuanganV'])){
			$modTarifTindakanRuanganV->attributes=$_GET['RJTarifTindakanPerdaRuanganV'];
		}

		if (Yii::app()->request->isAjaxRequest) {
			echo $this->renderPartial($this->path_view.'_table', array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV),true);
		}else{
		   $this->render($this->path_view.'index',array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
		}		
	}
}