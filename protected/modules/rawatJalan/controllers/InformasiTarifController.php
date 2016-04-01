<?php

class InformasiTarifController extends MyAuthController
{
	public $path_view = 'rawatJalan.views.informasiTarif.';
	
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
        
	public function actionDetailsTarif($kelaspelayanan_id,$daftartindakan_id,$kategoritindakan_id, $jenistarif_id){

		$this->layout='//layouts/iframe';
		$kelaspelayanan_id = (isset($kelaspelayanan_id) ? $kelaspelayanan_id : null);
		$daftartindakan_id = (isset($daftartindakan_id) ? $daftartindakan_id : null);
		$kategoritindakan_id = (isset($kategoritindakan_id) ? $kategoritindakan_id : null);
		if($kelaspelayanan_id!=''){
		$modTarifTindakan= RJTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id='.$kelaspelayanan_id.' AND 
														   daftartindakan_id='.$daftartindakan_id.'
														   AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL
                                                                                                                . ' AND t.jenistarif_id = '.$jenistarif_id);
		}else{ 
			$modTarifTindakan=RJTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id='.$daftartindakan_id.'
														   AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.
														  ' AND kelaspelayanan_id isNull'
                                                                                                                . ' AND t.jenistarif_id = '.$jenistarif_id);
		}
		if(empty($kategoritindakan_id)){
			$modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$daftartindakan_id.' and kelaspelayanan_id = '.$kelaspelayanan_id.' and jenistarif_id = '.$jenistarif_id);
		}else{
			$modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$daftartindakan_id.' and kelaspelayanan_id = '.$kelaspelayanan_id.' and kategoritindakan_id = '.$kategoritindakan_id.' and jenistarif_id = '.$jenistarif_id);
		}
		$jumlahTarifTindakan=COUNT($modTarifTindakan);
		$this->render($this->path_view.'detailsTarif',array('modTarif'=>$modTarif,
											'modTarifTindakan'=>$modTarifTindakan,
											'jumlahTarifTindakan'=>$jumlahTarifTindakan));


	}

}