<?php

class InformasiTarifController extends MyAuthController
{
    public function actionIndex()
    {
            $modTarifTindakanRuanganV = new RDTarifTindakanPerdaRuanganV('search');
            $modTarifTindakanRuanganV->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;

            if(isset($_GET['RDTarifTindakanPerdaRuanganV'])){
                $modTarifTindakanRuanganV->attributes=$_GET['RDTarifTindakanPerdaRuanganV'];
            }

             if (Yii::app()->request->isAjaxRequest) {
                echo $this->renderPartial('_tableTarif', array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
            }else{
                $this->render('index',array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
            }

    }
        
    public function actionDetailsTarif($kelaspelayanan_id,$daftartindakan_id, $kategoritindakan_id, $jenistarif_id){

       $this->layout='//layouts/iframe';
       $kelaspelayanan_id = (isset($kelaspelayanan_id) ? $kelaspelayanan_id : null);
       $daftartindakan_id = (isset($daftartindakan_id) ? $daftartindakan_id : null);
       $kategoritindakan_id = (isset($kategoritindakan_id) ? $kategoritindakan_id : null);
       $jenistarif_id = (isset($jenistarif_id) ? $jenistarif_id : null);
       
       $modTarifTindakanform = new RDTarifTindakanPerdaRuanganV();
       if($kelaspelayanan_id!=''){
       $modTarifTindakan= RDTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id='.$kelaspelayanan_id.' AND 
                                                          daftartindakan_id='.$daftartindakan_id.'
                                                          AND jenistarif_id='.$jenistarif_id.'        
                                                          AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'');
       }else{ 
           $modTarifTindakan=RDTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id='.$daftartindakan_id.'
                                                          AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'
                                                          AND jenistarif_id='.$jenistarif_id.'        
                                                          AND kelaspelayanan_id isNull');
       }
       if(empty($kategoritindakan_id)){
           $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$daftartindakan_id.' and kelaspelayanan_id = '.$kelaspelayanan_id.' and jenistarif_id = '.$jenistarif_id.'');
       }else{
           $modTarif = TariftindakanperdaruanganV::model()->find('daftartindakan_id = '.$daftartindakan_id.' and kelaspelayanan_id = '.$kelaspelayanan_id.' and kategoritindakan_id = '.$kategoritindakan_id.'and jenistarif_id = '.$jenistarif_id.'');
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
            $modTarifRad = new RDTarifTindakanPerdaRuanganV('searchInformasi');
          //  $modTarifRad->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
            $modTarifRad->instalasi_id = Yii::app()->user->getState('instalasi_id');
            //$modTarifRad->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
            //$modTarifRad->penjamin_id = Params::PENJAMIN_ID_UMUM;
            if(isset($_GET['RDTarifTindakanPerdaRuanganV'])){
                    $modTarifRad->attributes=$_GET['RDTarifTindakanPerdaRuanganV'];
                    //$modTarifRad->carabayar_id=$_GET['ROTarifpemeriksaanradruanganV']['carabayar_id'];
                    //$modTarifRad->penjamin_id=$_GET['ROTarifpemeriksaanradruanganV']['penjamin_id'];
            }
            $this->render('print',array('modTarifRad'=>$modTarifRad));
        }

}