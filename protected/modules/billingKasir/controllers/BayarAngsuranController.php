<?php

class BayarAngsuranController extends PembayaranTagihanPasienController
{
        protected $successSave = false;
        
        public function actionIndex($view=null, $id=null)
	{
            
            if(isset($_GET['frame']) && !empty($_GET['idPembayaran']))
            {
                $this->layout = 'iframe';
                $idPembayaran = $_GET['idPembayaran'];
                
                $modPembayaran = BKPembayaranpelayananT::model()->findByPk($idPembayaran);
                $tandaBukti = BKTandabuktibayarT::model()->findByPk($modPembayaran->tandabuktibayar_id);
                $model = BKBayarAngsuranPelayananT::model()->findByAttributes(
                    array('pembayaranpelayanan_id'=>$idPembayaran),
                    array('order'=>'bayarke DESC')
                );
                
                $modAngsuran = new BKBayarAngsuranPelayananT;
                $modAngsuran->pembayaranpelayanan_id = $idPembayaran;
                $modAngsuran->tandabuktibayar_id = $modPembayaran->tandabuktibayar_id;
                $modAngsuran->sisaangsuran = $modPembayaran->totalsisatagihan;
                $modAngsuran->tglbayarangsuran = date('d M Y H:i:s');
                $modAngsuran->jmlbayarangsuran = 0;
                
                $modTandaBukti = new BKTandabuktibayarT;
                $modTandaBukti->attributes = $tandaBukti->attributes;
                $modTandaBukti->carapembayaran = 'CICILAN';
                $modTandaBukti->jmlpembayaran = 0;
                $modTandaBukti->uangditerima = 0;
                $modTandaBukti->uangkembalian = 0;
                
                if(!empty($model))
                {
                    $modAngsuran->bayarke = $model->bayarke + 1;
                } 
                
            }
            
            if(isset($_POST['BKBayarAngsuranPelayananT']))
            {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $tandaBukti = $this->saveTandabuktiBayarAngsuran($_POST['BKTandabuktibayarT'],$idPembayaran);
                    $modAngsuran = $this->saveBayarAngsuran($_POST['BKBayarAngsuranPelayananT'], $tandaBukti);
                    $this->updatePembayaran($idPembayaran, $_POST['BKBayarAngsuranPelayananT']['sisaangsuran']);
                    $this->updateTindakanSudahBayar($idPembayaran, $tandaBukti);
                    $this->updateOASudahBayar($idPembayaran, $tandaBukti);
                    
                    if($this->successSave)
                    {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                    }else{
                        Yii::app()->user->setFlash('error',"Data gagal disimpan "."<pre>".print_r($modAngsuran->getErrors(),1)."</pre>");
                        $transaction->rollback();
                    }
                } catch (Exception $exc) {
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                    $transaction->rollback();
                }
            }
		
            $this->render('index',
                array(
                    'modAngsuran'=>$modAngsuran,
                    'modTandaBukti'=>$modTandaBukti,
                    'modPembayaran'=>$modPembayaran
                )
            );
	}
        
        
        
        protected function saveTandabuktiBayarAngsuran($postTandaBuktiBayar,$idPembayaran)
        {
            $modTandaBukti = new TandabuktibayarT;
            $modTandaBukti->attributes = $postTandaBuktiBayar;
            
            if($modTandaBukti->carapembayaran == 'HUTANG')
            {
                $modTandaBukti->uangditerima = 0;
            }
            
            $modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
            $modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayar();
            $modTandaBukti->pembayaranpelayanan_id = $idPembayaran;
                        
            if($modTandaBukti->validate())
            {
                $modTandaBukti->save();
            } else {
                echo "saveTandabuktiBayar tidak valid";
                echo "<pre>".print_r($modTandaBukti->errors,1)."</pre>";
                echo "<pre>".print_r($modTandaBukti->attributes,1)."</pre>";
            }
            
            return $modTandaBukti;
        }
        
        protected function saveBayarAngsuran($postAngsuran,$modTandaBukti)
        {
            $modAngsuran = new BKBayarAngsuranPelayananT;
            $modAngsuran->attributes = $postAngsuran;
            $modAngsuran->tandabuktibayar_id = $modTandaBukti->tandabuktibayar_id;
            if($modAngsuran->validate())
            {
                if($modAngsuran->save())
                    $this->successSave = true;
            }
            
            return $modAngsuran;
        }

        protected function updatePembayaran($idPembayaran,$sisaTagihan)
        {
            $statusBayar = $this->cekStatusBayar($sisaTagihan);
            BKPembayaranpelayananT::model()->updateByPk(
                $idPembayaran,
                array(
                    'totalsisatagihan'=>$sisaTagihan,
                    'statusbayar'=>$statusBayar
                )
            );
        }
        
        protected function updateOASudahBayar($idPembayaran,$modTandaBukti)
        {
            $modOaSudahbayar = OasudahbayarT::model()->findAllByAttributes(
                array(
                    'pembayaranpelayanan_id'=>$idPembayaran
                )
            );
            foreach ($modOaSudahbayar as $i => $oaSudahbayar) {
                $biayaOa = $oaSudahbayar->jmliurbiaya;
                $jmlBayar = $oaSudahbayar->jmlbayar_oa;
                $bayarOa = $modTandaBukti->jmlpembayaran / $_POST['totTagihan'] * $biayaOa;
                $jmlBayar = $jmlBayar + $bayarOa;
                $sisaBayar = $biayaOa - $jmlBayar;
                OasudahbayarT::model()->updateByPk(
                    $oaSudahbayar->oasudahbayar_id,
                    array(
                        'jmlbayar_oa'=>$jmlBayar,
                        'jmlsisabayar_oa'=>$sisaBayar
                    )
                );
            }
        }
        
        protected function updateTindakanSudahBayar($idPembayaran,$modTandaBukti)
        {
            $modTindakan = TindakansudahbayarT::model()->findAllByAttributes(
                array(
                    'pembayaranpelayanan_id'=>$idPembayaran
                )
            );
            foreach ($modTindakan as $i => $tindSudahbayar) {
                $biayaTindakan = $tindSudahbayar->jmlbiaya_tindakan;
                $jmlBayar = $tindSudahbayar->jmlbayar_tindakan;
                $bayarTindakan = $modTandaBukti->jmlpembayaran / $_POST['totTagihan'] * $biayaTindakan;
                $jmlBayar = $jmlBayar + $bayarTindakan;
                $sisaBayar = $biayaTindakan - $jmlBayar;
                TindakansudahbayarT::model()->updateByPk(
                    $tindSudahbayar->tindakansudahbayar_id,
                    array(
                        'jmlbayar_tindakan'=>$jmlBayar,
                        'jmlsisabayar_tindakan'=>$sisaBayar
                    )
                );
            }
        }
        
        protected function cekStatusBayar($sisaTagihan)
        {
            if($sisaTagihan>0){
                return 'BELUM LUNAS';
            } else {
                return 'LUNAS';
            }
        }
        // Uncomment the following methods and override them if needed
	/*
	public function filters()
	{
		// return the filter configuration for this controller, e.g.:
		return array(
			'inlineFilterName',
			array(
				'class'=>'path.to.FilterClass',
				'propertyName'=>'propertyValue',
			),
		);
	}

	public function actions()
	{
		// return external action classes, e.g.:
		return array(
			'action1'=>'path.to.ActionClass',
			'action2'=>array(
				'class'=>'path.to.AnotherActionClass',
				'propertyName'=>'propertyValue',
			),
		);
	}
	*/
}