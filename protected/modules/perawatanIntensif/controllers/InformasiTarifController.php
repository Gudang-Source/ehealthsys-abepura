<?php

class InformasiTarifController extends MyAuthController
{
	public function actionIndex()
	{
		$modTarifTindakanRuanganV = new RITarifTindakanPerdaRuanganV('search');
		
		$kom_unit = Params::KomponenUnitRuangan();
		if (isset($kom_unit[Yii::app()->user->getState('ruangan_id')]))
		{
			$modTarifTindakanRuanganV->komponenunit_id = $kom_unit[Yii::app()->user->getState('ruangan_id')];
		}
		
		
		$kel_tin = Params::KelompokTindakanInstalasi();
		
		if (isset($kel_tin[Yii::app()->user->getState('instalasi_id')]))
		{
			
			$modTarifTindakanRuanganV->kelompoktindakan_id = $kel_tin[Yii::app()->user->getState('instalasi_id')];
		}
		
		$modTarifTindakanRuanganV->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
		if(isset($_GET['RITarifTindakanPerdaRuanganV'])){
			$modTarifTindakanRuanganV->attributes=$_GET['RITarifTindakanPerdaRuanganV'];
		}
		$this->render('index',array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
	}
        
	public function actionDetailsTarif($kelaspelayanan_id,$daftartindakan_id, $kategoritindakan_id,$jenistarif_id){

		$this->layout='//layouts/iframe';
		$kelaspelayanan_id = (isset($kelaspelayanan_id) ? $kelaspelayanan_id : null);
		$daftartindakan_id = (isset($daftartindakan_id) ? $daftartindakan_id : null);
		$kategoritindakan_id = (isset($kategoritindakan_id) ? $kategoritindakan_id : null);
		$jenistarif_id = (isset($jenistarif_id) ? $jenistarif_id : null);
		if(empty($jenistarif_id)){
			$jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
		}

		$modTarifTindakanform = new RITarifTindakanPerdaRuanganV();
		if($kelaspelayanan_id!=''){
		$modTarifTindakan= RITariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id='.$kelaspelayanan_id.' AND 
														   daftartindakan_id='.$daftartindakan_id.'
														   AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.' AND t.jenistarif_id = '.$jenistarif_id.'');
		}else{ 
			$modTarifTindakan=RITariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id='.$daftartindakan_id.'
														   AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'
														   AND kelaspelayanan_id isNull AND t.jenistarif_id = '.$jenistarif_id.'');
		}
		if(empty($kategoritindakan_id)){
			$modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$daftartindakan_id.' and kelaspelayanan_id = '.$kelaspelayanan_id.' AND t.jenistarif_id = '.$jenistarif_id.'');
		}else{
			$modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$daftartindakan_id.' and kelaspelayanan_id = '.$kelaspelayanan_id.'  AND t.jenistarif_id = '.$jenistarif_id.' AND kategoritindakan_id = '.$kategoritindakan_id);
		}
		$jumlahTarifTindakan=COUNT($modTarifTindakan);

		$this->render('detailsTarif',array(
			'modTarif'=>$modTarif,
			'modTarifTindakan'=>$modTarifTindakan,
			'modTarifTindakanform'=>$modTarifTindakanform,
			'jumlahTarifTindakan'=>$jumlahTarifTindakan));


	 }
         
          public function actionPrint() {
            $this->layout = '//layouts/iframe';
            $modTarifRad = new RITarifTindakanPerdaRuanganV('searchInformasi');
          //  $modTarifRad->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
            $modTarifRad->instalasi_id = Yii::app()->user->getState('instalasi_id');
            //$modTarifRad->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
            //$modTarifRad->penjamin_id = Params::PENJAMIN_ID_UMUM;
            if(isset($_GET['RITarifTindakanPerdaRuanganV'])){
                    $modTarifRad->attributes=$_GET['RITarifTindakanPerdaRuanganV'];
                    //$modTarifRad->carabayar_id=$_GET['ROTarifpemeriksaanradruanganV']['carabayar_id'];
                    //$modTarifRad->penjamin_id=$_GET['ROTarifpemeriksaanradruanganV']['penjamin_id'];
            }
            $this->render('print',array('modTarifRad'=>$modTarifRad));
        }

}