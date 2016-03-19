<?php

class SaldoAwalController extends MyAuthController
{
    public function actionIndex()
    {
        $model = new AKSaldoawalT;
		$model->jmlanggaran=0;
		$model->jmlsaldoawald=0;
		$model->jmlsaldoawalk=0;
        $AKSaldorekeningV = new AKSaldorekeningV;
        $this->render('index', array(
                'model' => $model,
                'AKSaldorekeningV'=>$AKSaldorekeningV
            )
        );
    }
    
    public function actionSimpanSaldoRekening()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $result = array();
            $transaction = Yii::app()->db->beginTransaction();
            parse_str($_REQUEST['data'], $data_parsing);
            
            $is_simpan = true;
            $action = 'insert';
            $is_exist = false;
            try{
                $model = new AKSaldoawalT;
                $data_parsing['AKSaldoawalT']['create_ruangan'] = Yii::app()->user->getState('ruangan_id');
                $data_parsing['AKSaldoawalT']['update_loginpemakai_id'] = Yii::app()->user->id;
                $data_parsing['AKSaldoawalT']['update_time'] = date('Y-m-d');

                if(strlen($data_parsing['AKSaldoawalT']['saldoawal_id']) > 0)
                {

                    $model->rekperiod_id = $data_parsing['AKSaldoawalT']['rekperiod_id'];
                    $model->periodeposting_id = $data_parsing['AKSaldoawalT']['periodeposting_id'];
                    $is_exist = $model->isExis($data_parsing['AKSaldoawalT']['saldoawal_id']);
                    if(!$is_exist){
                        $attributes = array(
                            'rekperiod_id'=>$data_parsing['AKSaldoawalT']['rekperiod_id'],
                            'periodeposting_id'=>$data_parsing['AKSaldoawalT']['periodeposting_id'],
                            'matauang_id'=>$data_parsing['AKSaldoawalT']['matauang_id'],
                            'kursrp_id'=>$data_parsing['AKSaldoawalT']['kursrp_id'],
                            'jmlanggaran'=>$data_parsing['AKSaldoawalT']['jmlanggaran'],
                            'jmlsaldoawald'=>$data_parsing['AKSaldoawalT']['jmlsaldoawald'],
                            'jmlsaldoawalk'=>$data_parsing['AKSaldoawalT']['jmlsaldoawalk'],
                            /*
                            'jmlmutasid'=>$data_parsing['AKSaldoawalT']['jmlmutasid'],
                            'jmlmutasik'=>$data_parsing['AKSaldoawalT']['jmlmutasik'],
                            'jmlsaldoakhird'=>$data_parsing['AKSaldoawalT']['jmlsaldoakhird'],
                            'jmlsaldoakhirk'=>$data_parsing['AKSaldoawalT']['jmlsaldoakhirk'],
                             * 
                             */
                            'update_time'=>date('Y-m-d'),
                            'update_loginpemakai_id'=>Yii::app()->user->id
                        );
                        $is_simpan = AKSaldoawalT::model()->updateByPk($data_parsing['AKSaldoawalT']['saldoawal_id'], $attributes);                        
                    }else{
                        $is_simpan = false;
                    }
                    $action = 'update';
                    $id_rekening = $data_parsing['AKSaldoawalT'];
                }else{
                    $attributes = array(
                        'rekperiod_id' => $data_parsing['AKSaldoawalT']['rekperiod_id'],
                        'periodeposting_id' => $data_parsing['AKSaldoawalT']['periodeposting_id'],
//                        'rekening1_id' => $data_parsing['AKSaldoawalT']['rekening1_id'],
                        'rekening5_id' => $data_parsing['AKSaldoawalT']['rekening5_id']
                    );
					
//					if($data_parsing['AKSaldoawalT']['rekening3_id'] != null)
//                    {
//                        $attributes['rekening3_id'] = $data_parsing['AKSaldoawalT']['rekening3_id'];
//                    }
//                    if($data_parsing['AKSaldoawalT']['rekening4_id'] != null)
//                    {
//                        $attributes['rekening4_id'] = $data_parsing['AKSaldoawalT']['rekening4_id'];
//                    }

                    if($data_parsing['AKSaldoawalT']['rekening5_id'] != null)
                    {
                        $attributes['rekening5_id'] = $data_parsing['AKSaldoawalT']['rekening5_id'];
                    }

                    $id_rekening = $attributes;

                    $is_exist = $model->findByAttributes($attributes);
                    if(!$is_exist)
                    {

                        $data_parsing['AKSaldoawalT']['create_loginpemakai_id'] = Yii::app()->user->id;
                        $data_parsing['AKSaldoawalT']['create_time'] = date('Y-m-d');
                        $is_simpan = $this->simpanRekening($model, $data_parsing['AKSaldoawalT']);
//                        $this->simpanParentRekening($model, $data_parsing['AKSaldoawalT'], $attributes);
                    }else{

                        $is_simpan = false;
                    }
                }
                
                if($is_simpan)
                {
                    $transaction->commit();
                }else{
                    $transaction->rollback();
                }
            } catch (Exception $exc){
                $is_simpan = true;
                $action = $exc;
                $transaction->rollback();
            }
            
            $result = array(
                'id_rekening' => $id_rekening,
                'pesan' => ($is_exist == true ? 'exist' : $action),
                'status' => ($is_simpan == true ? 'ok' : 'not'),
            );
            
            echo json_encode($result);
            Yii::app()->end();            
        }        
    }
    
    protected function simpanRekening($model, $params)
    {

        $model->attributes = $params;
        if($model->validate()){
            if($model->save()){
                return true;
            }else{
                return false;
            }
        }else{
            print_r($model->getErrors());
            return false;
        }        
    }
    
    public function actionEditSaldoRekening()
    {
        $this->layout = '//layouts/iframe';
        $id = $_GET['id'];
        $model = AKSaldoawalT::model()->findByPk($id);
        
        if(isset($_POST['AKSaldoawalT']))
        {
            $attributes = array(
                'rekperiod_id'=>$_POST['AKSaldoawalT']['rekperiod_id'],
                'periodeposting_id' => $_POST['AKSaldoawalT']['periodeposting_id'],
                'matauang_id'=>$_POST['AKSaldoawalT']['matauang_id'],
                'kursrp_id'=>$_POST['AKSaldoawalT']['kursrp_id'],
                'jmlanggaran'=>$_POST['AKSaldoawalT']['jmlanggaran'],
                'jmlsaldoawald'=>$_POST['AKSaldoawalT']['jmlsaldoawald'],
                'jmlsaldoawalk'=>$_POST['AKSaldoawalT']['jmlsaldoawalk'],
                'jmlmutasid'=>$_POST['AKSaldoawalT']['jmlmutasid'],
                'jmlmutasik'=>$_POST['AKSaldoawalT']['jmlmutasik'],
                'jmlsaldoakhird'=>$_POST['AKSaldoawalT']['jmlsaldoakhird'],
                'jmlsaldoakhirk'=>$_POST['AKSaldoawalT']['jmlsaldoakhirk'],
                'update_time'=>date('Y-m-d'),
                'update_loginpemakai_id'=>Yii::app()->user->id
            );
            $update = AKSaldoawalT::model()->updateByPk($id, $attributes);
            
            if($update){
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
            }
        }
        
        $this->render('__formInputSaldoRekening', array(
                'model' => $model
            )
        );
    }

    public function actionGetInformasiSaldo()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $id = $_POST['id'];
            $model = AKSaldoawalT::model()->findByPk($id);
            echo json_encode($model->attributes);
            Yii::app()->end();
        }        
    }

    private function simpanParentRekening($model, $params, $attrb)
    {
        foreach ($attrb as $key => $value) {
            if($key != 'rekperiod_id')
            {
                
            }
        }
    }
    
    public function actionPrint()
    {
        $model= new AKSaldorekeningV;
		if(isset($_REQUEST['AKSaldorekeningV'])){
			$model->attributes=$_REQUEST['AKSaldorekeningV'];
		}
        $judulLaporan='Data Saldo Awal Rekening';
        $caraPrint=$_REQUEST['caraPrint'];
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
            $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
            $this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
        }
        else if($_REQUEST['caraPrint']=='PDF') {
            $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
            $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
            $mpdf = new MyPDF('',$ukuranKertasPDF); 
            $mpdf->useOddEven = 2;  
            $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
            $mpdf->WriteHTML($stylesheet,1);  
            $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
            $mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
            $mpdf->Output($judulLaporan.'-'.date('Y/m/d').'.pdf','I');
        }                       
    }
	
	/**
     * Mengatur dropdown priode posting
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownPeriodePosting($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $rekperiod_id = null;
            if($model_nama !=='' && $attr == ''){
                $rekperiod_id = $_POST["$model_nama"]['rekperiod_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $rekperiod_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $rekperiod_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(AKPeriodepostingM::model()->getTglPeriode($rekperiod_id),'periodeposting_id','deskripsiperiodeposting');

            if($encode){
                echo CJSON::encode($models);
            } else {
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(count($models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
}
