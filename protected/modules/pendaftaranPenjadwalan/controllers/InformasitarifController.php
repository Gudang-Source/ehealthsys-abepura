<?php

class InformasiTarifController extends MyAuthController
{
        
	public function actionIndex()
	{
                //$idInstalasi=Yii::app()->user->getState('instalasi_id');
               // $idRuangan=Yii::app()->user->getState('ruangan_id');
                $modTarifTindakanRuanganV = new PPTarifTindakanPerdaRuanganV;
//                $modTarifTindakanRuanganV->instalasi_id=$idInstalasi;
//                $modTarifTindakanRuanganV->ruangan_id=$idRuangan;
                
                if(isset($_GET['PPTarifTindakanPerdaRuanganV'])){
                    $modTarifTindakanRuanganV->attributes=$_GET['PPTarifTindakanPerdaRuanganV'];
                   
                }
		$this->render('index',array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
	}
        
        public function actionDetailsTarif($idKelasPelayanan,$idDaftarTindakan, $idKategoriTindakan){
            
            $this->layout='//layouts/iframe';
            if($idKelasPelayanan!=''){
            $modTarifTindakan= PPTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id='.$idKelasPelayanan.' AND 
                                                               daftartindakan_id='.$idDaftarTindakan.'
                                                               AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'');
            }else{ 
                $modTarifTindakan=PPTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id='.$idDaftarTindakan.'
                                                               AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'
                                                               AND kelaspelayanan_id isNull');
            }
            $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$idDaftarTindakan.' and kelaspelayanan_id = '.$idKelasPelayanan.' and kategoritindakan_id = '.$idKategoriTindakan);
            $jumlahTarifTindakan=COUNT($modTarifTindakan);
            
            $this->render('detailsTarif',array('modTarif'=>$modTarif,
                                                'modTarifTindakan'=>$modTarifTindakan,
                                                'jumlahTarifTindakan'=>$jumlahTarifTindakan));
            
            
        }

}