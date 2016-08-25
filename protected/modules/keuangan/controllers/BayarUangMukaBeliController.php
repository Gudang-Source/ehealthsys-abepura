<?php

class BayarUangMukaBeliController extends MyAuthController
{
        protected $successSave=true;
	public $path_view = 'keuangan.views.bayarUangMukaBeli.';
        
	public function actionIndex($tandabuktikeluar_id=null)
	{
            $modSupplier = new KUSupplierM;
            $modUangMuka = new KUUangMukaBeliT;
            $modBuktiKeluar = new KUTandabuktikeluarT;
            $modBuktiKeluar->tahun = date('Y');
            $modBuktiKeluar->untukpembayaran = 'Pembayaran Uang Muka Pembelian';
            $modBuktiKeluar->nokaskeluar = MyGenerator::noKasKeluar();
            $modBuktiKeluar->biayaadministrasi = 0;
            $modBuktiKeluar->jmlkaskeluar = 0;
			if(!empty($tandabuktikeluar_id)){
				$modBuktiKeluar = KUTandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);
			}
            if(isset($_POST['KUTandabuktikeluarT'])){
                $idSupplier = $_POST['KUSupplierM']['supplier_id'];
                $modSupplier->attributes = $_POST['KUSupplierM'];
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $modBuktiKeluar = $this->saveBuktiKeluar($_POST['KUTandabuktikeluarT']);
                    $modUangMuka = $this->saveBayarUangMukaBeli($modBuktiKeluar, $idSupplier);
                    $modBuktiKeluar->uangmukabeli_id = $modUangMuka->uangmukabeli_id;
                    $modBuktiKeluar->save();
                    if($this->successSave){
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
						$this->redirect(array('index','tandabuktikeluar_id'=>$modBuktiKeluar->tandabuktikeluar_id,'sukses'=>1));
                    } else {
                        $transaction->rollback();
                        Yii::app()->user->setFlash('error',"Data gagal disimpan ");
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                }
            }
            
            $this->render($this->path_view.'index',array('modSupplier'=>$modSupplier,
                                        'modUangMuka'=>$modUangMuka,
                                        'modBuktiKeluar'=>$modBuktiKeluar));
	}
        
        protected function saveBuktiKeluar($postBuktiKeluar)
        {
            $format = new MyFormatter;
            $modBuktiKeluar = new KUTandabuktikeluarT;
            $modBuktiKeluar->attributes = $postBuktiKeluar;
            $modBuktiKeluar->ruangan_id = Yii::app()->user->getState('ruangan_id');
			$modBuktiKeluar->shift_id = Yii::app()->user->getState('shift_id');
			$modBuktiKeluar->create_time = date('Y-m-d H:i:s');
			$modBuktiKeluar->create_loginpemakai_id = Yii::app()->user->id;
			$modBuktiKeluar->create_ruangan = Yii::app()->user->getState('ruangan_id');
			$modBuktiKeluar->tglkaskeluar = $format->formatDateTimeForDb($modBuktiKeluar->tglkaskeluar);
            // $modBuktiKeluar->jmlkaskeluar = $format->formatNumberForDb($postBuktiKeluar['jmlkaskeluar']);
            // echo "<pre>"; print_r($modBuktiKeluar->jmlkaskeluar); exit;

            if($modBuktiKeluar->validate()){
                $modBuktiKeluar->save();
                $this->successSave = $this->successSave && true;
            } else {
                $this->successSave = false;
            }
            
            return $modBuktiKeluar;
        }

        protected function saveBayarUangMukaBeli($modBuktiKeluar,$idSupplier)
        {
            $modBayarUangMuka = new KUUangMukaBeliT;
            $modBayarUangMuka->supplier_id = $idSupplier;
            $modBayarUangMuka->namabank = $modBuktiKeluar->melalubank;
            $modBayarUangMuka->norekening = $modBuktiKeluar->denganrekening;
            $modBayarUangMuka->rekatasnama = $modBuktiKeluar->atasnamarekening;
            $modBayarUangMuka->jumlahuang = $modBuktiKeluar->jmlkaskeluar;
			$modBayarUangMuka->tgluangmukabeli = $modBuktiKeluar->tglkaskeluar;
			
            if($modBayarUangMuka->validate()){
                $modBayarUangMuka->save();
                $this->successSave = $this->successSave && true;
            } else {
                $this->successSave = false;
            }
			
			// var_dump($modBuktiKeluar->attributes, $modBayarUangMuka->attributes); die;
            
            return $modBayarUangMuka;
        }
		
	public function actionDaftarSupplier()
    {
        if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                //$criteria->with = array();
                $criteria->compare('LOWER(supplier_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'supplier_nama DESC';
                $models = KUSupplierM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->supplier_kode.' - '.$model->supplier_nama;
                    $returnVal[$i]['value'] = $model->supplier_nama;
                }

                echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	public function actionPrint($tandabuktikeluar_id)
	{
		$this->layout='//layouts/printWindows';
		$modBuktiKeluar = KUTandabuktikeluarT::model()->findByPk($tandabuktikeluar_id);
		
		$this->render($this->path_view.'print',array(
					'modBuktiKeluar'=>$modBuktiKeluar,
				));
	}
}