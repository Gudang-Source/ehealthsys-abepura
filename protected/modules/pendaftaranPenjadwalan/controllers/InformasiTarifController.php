<?php

class InformasiTarifController extends MyAuthController
{
        public $layout='//layouts/column1';
	public function actionIndex()
	{
                $modTarifTindakanRuanganV = new PPTarifTindakanPerdaRuanganV('search');
				$modTarifTindakanRuanganV->instalasi_id = Params::INSTALASI_ID_RJ;
				$modTarifTindakanRuanganV->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
                if(isset($_GET['PPTarifTindakanPerdaRuanganV'])){
                    $modTarifTindakanRuanganV->attributes=$_GET['PPTarifTindakanPerdaRuanganV'];
                    $modTarifTindakanRuanganV->komponenunit_nama=$_GET['PPTarifTindakanPerdaRuanganV']['komponenunit_nama'];
                }
                
		$this->render('index',array('modTarifTindakanRuanganV'=>$modTarifTindakanRuanganV));
	}
        
        public function actionDetailsTarif($kelaspelayanan_id,$daftartindakan_id,$kategoritindakan_id, $jenistarif_id){
            
            $this->layout='//layouts/iframe';
            $kelaspelayanan_id = (isset($kelaspelayanan_id) ? $kelaspelayanan_id : null);
            $daftartindakan_id = (isset($daftartindakan_id) ? $daftartindakan_id : null);
            $kategoritindakan_id = (isset($kategoritindakan_id) ? $kategoritindakan_id : null);
            $jenistarif_id = (isset($jenistarif_id) ? $jenistarif_id : null);
            if($kelaspelayanan_id!=''){
            $modTarifTindakan= PPTariftindakanM::model()->with('komponentarif')->findAll('kelaspelayanan_id='.$kelaspelayanan_id.' AND 
                                                               daftartindakan_id='.$daftartindakan_id.'
                                                               AND jenistarif_id='.$jenistarif_id.'
                                                               AND t.komponentarif_id!='.Params::KOMPONENTARIF_ID_TOTAL.'');
            }else{ 
                $modTarifTindakan=PPTariftindakanM::model()->with('komponentarif')->findAll('daftartindakan_id='.$daftartindakan_id.'
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
            $this->render('detailsTarif',array('modTarif'=>$modTarif,
                                                'modTarifTindakan'=>$modTarifTindakan,
                                                'jumlahTarifTindakan'=>$jumlahTarifTindakan));
            
            
        }

    public function actionRuanganDariInstalasi($encode=false,$namaModel='')
    {
        if(Yii::app()->request->isAjaxRequest) {
  
            $idInstalasi = $_POST["$namaModel"]['instalasi_id'];
            if (empty($idInstalasi)){
                $ruangan = RuanganM::model()->findAll();
            }
            else{
                $ruangan = RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$idInstalasi, 'ruangan_aktif'=>true), array('order'=>'ruangan_nama'));
            }
            
            $ruangan=CHtml::listData($ruangan,'ruangan_id','ruangan_nama');
            
            echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                foreach($ruangan as $value=>$name)
                {
                    echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                }
            
        }
        Yii::app()->end();
    }    
    
     public function actionPrint() {
            $this->layout = '//layouts/iframe';
            $modTarifRad = new PPTarifTindakanPerdaRuanganV('searchInformasi');
          //  $modTarifRad->jenistarif_id = Params::JENISTARIF_ID_PELAYANAN;
            $modTarifRad->instalasi_id = Yii::app()->user->getState('instalasi_id');
            //$modTarifRad->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
            //$modTarifRad->penjamin_id = Params::PENJAMIN_ID_UMUM;
            if(isset($_GET['PPTarifTindakanPerdaRuanganV'])){
                    $modTarifRad->attributes=$_GET['PPTarifTindakanPerdaRuanganV'];
                    //$modTarifRad->carabayar_id=$_GET['ROTarifpemeriksaanradruanganV']['carabayar_id'];
                    //$modTarifRad->penjamin_id=$_GET['ROTarifpemeriksaanradruanganV']['penjamin_id'];
            }
            $this->render('print',array('modTarifRad'=>$modTarifRad));
        }

}