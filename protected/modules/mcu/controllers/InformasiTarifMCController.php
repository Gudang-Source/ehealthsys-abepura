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
        
        public function actionPrint() {
            $this->layout = '//layouts/iframe';
            $modTarifRad = new RJTarifTindakanPerdaRuanganV('searchInformasi');
          //  $modTarifRad->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
            $modTarifRad->instalasi_id = Yii::app()->user->getState('instalasi_id');
            //$modTarifRad->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
            //$modTarifRad->penjamin_id = Params::PENJAMIN_ID_UMUM;
            if(isset($_GET['RJTarifTindakanPerdaRuanganV'])){
                    $modTarifRad->attributes=$_GET['RJTarifTindakanPerdaRuanganV'];
                    //$modTarifRad->carabayar_id=$_GET['ROTarifpemeriksaanradruanganV']['carabayar_id'];
                    //$modTarifRad->penjamin_id=$_GET['ROTarifpemeriksaanradruanganV']['penjamin_id'];
            }
            $this->render('print',array('modTarifRad'=>$modTarifRad));
        }
}