<?php

class InformasiTarifController extends MyAuthController
{
	public function actionIndex()
	{
                //$idInstalasi=Yii::app()->user->getState('instalasi_id');
//                $idRuangan=Yii::app()->user->getState('ruangan_id');
                $modTarifTindakanRuanganV = new RMTariftindakanperdaruanganV('searchInformasi');
                $modTarifTindakanRuanganV->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
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
		//$modTarifTindakanRuanganV->instalasi_id = Yii::app()->user->getState('instalasi_id');
//                $modTarifTindakanRuanganV->instalasi_id=$idInstalasi;
//                $modTarifTindakanRuanganV->ruangan_id=$idRuangan;
                
                if(isset($_GET['RMTariftindakanperdaruanganV'])){
                    $modTarifTindakanRuanganV->attributes=$_GET['RMTariftindakanperdaruanganV'];
                   
                }
		$this->render('index',array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
	}
        
        public function actionDetailsTarif($idKelasPelayanan,$idDaftarTindakan, $idKategoriTindakan, $jenistarif_id){
            
            $this->layout='//layouts/iframe';
            if($idKelasPelayanan!=''){
            $modTarifTindakan= RMTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id='.$idKelasPelayanan.' AND 
                                                               daftartindakan_id='.$idDaftarTindakan.'
                                                               and t.jenistarif_id='.$jenistarif_id.'
                                                               AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'');
            }else{ 
                $modTarifTindakan=RMTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id='.$idDaftarTindakan.'
                                                               AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'
                                                               and t.jenistarif_id='.$jenistarif_id.'
                                                               AND kelaspelayanan_id isNull');
            }
            $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$idDaftarTindakan.' and kelaspelayanan_id = '.$idKelasPelayanan.' and kategoritindakan_id = '.$idKategoriTindakan.' and jenistarif_id = '.$jenistarif_id);
            $jumlahTarifTindakan=COUNT($modTarifTindakan);
            
            $this->render('detailsTarif',array('modTarif'=>$modTarif,
                                                'modTarifTindakan'=>$modTarifTindakan,
                                                'jumlahTarifTindakan'=>$jumlahTarifTindakan));
            
            
        }
        
        public function actionPrint() {
            $this->layout = '//layouts/iframe';
            $modTarifTindakanRuanganV = new RMTariftindakanperdaruanganV;

            if(isset($_GET['RMTariftindakanperdaruanganV'])){
                $modTarifTindakanRuanganV->attributes=$_GET['RMTariftindakanperdaruanganV'];

            }
            $this->render('print',array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
        }

}