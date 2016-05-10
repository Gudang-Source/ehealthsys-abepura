<?php

class InformasiTarifController extends MyAuthController
{
    public function actionIndex()
    {          
        $idInstalasi=Yii::app()->user->getState('instalasi_id');
        $idRuangan=Yii::app()->user->getState('ruangan_id');
        $modTarifTindakanRuanganV = new BSTarifTindakanPerdaRuanganV;
        $modTarifTindakanRuanganV->instalasi_id=$idInstalasi;
        $modTarifTindakanRuanganV->ruangan_id=$idRuangan;
        $modTarifTindakanRuanganV->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
        
        if(isset($_GET['BSTarifTindakanPerdaRuanganV'])){
            $modTarifTindakanRuanganV->attributes=$_GET['BSTarifTindakanPerdaRuanganV'];

        }
        $this->render('index',array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
    }
    public function actionDetailsTarif($kelaspelayanan_id,$daftartindakan_id, $kategoritindakan_id, $jenistarif_id)
    {

            $this->layout='//layouts/iframe';
            $kelaspelayanan_id = (isset($kelaspelayanan_id) ? $kelaspelayanan_id : null);
            $daftartindakan_id = (isset($daftartindakan_id) ? $daftartindakan_id : null);
            $kategoritindakan_id = (isset($kategoritindakan_id) ? $kategoritindakan_id : null);
            $jenistarif_id = (isset($jenistarif_id) ? $jenistarif_id : null);

            $modTarifTindakanform = new BSTarifTindakanPerdaRuanganV();
            if($kelaspelayanan_id!=''){
            $modTarifTindakan= BSTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id='.$kelaspelayanan_id.' AND 
                                                               daftartindakan_id='.$daftartindakan_id.'
                                                               AND jenistarif_id='.$jenistarif_id.'      
                                                               AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'');
            }else{ 
                $modTarifTindakan=BSTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id='.$daftartindakan_id.'
                                                               AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'
                                                               AND jenistarif_id='.$jenistarif_id.'      
                                                               AND kelaspelayanan_id isNull');
            }
            if(empty($kategoritindakan_id)){
                $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$daftartindakan_id.' and kelaspelayanan_id = '.$kelaspelayanan_id.' and jenistarif_id = '.$jenistarif_id.'');
            }else{
                $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$daftartindakan_id.' and kelaspelayanan_id = '.$kelaspelayanan_id.' and kategoritindakan_id = '.$kategoritindakan_id.' and jenistarif_id = '.$jenistarif_id.'');
            }
            $jumlahTarifTindakan=COUNT($modTarifTindakan);

            $this->render('detailsTarif',array(
                                                'modTarif'=>$modTarif,
                                                'modTarifTindakan'=>$modTarifTindakan,
                                                'modTarifTindakanform'=>$modTarifTindakanform,
                                                'jumlahTarifTindakan'=>$jumlahTarifTindakan));


    }
}

