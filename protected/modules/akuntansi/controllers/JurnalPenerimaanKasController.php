<?php

class JurnalPenerimaanKasController extends MyAuthController
{
    protected $path_view = 'akuntansi.views.jurnalPenerimaanKas.';
    
    public $success = true;
    public $is_action = 'insert';
    public $pesan = 'succes';
    
    
    public function actionIndex()
    {
        $model = new AKJurnalrekeningT();
        $format = new MyFormatter();
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
//        print_r(Yii::app()->controller->id);
        if(isset($_GET['AKJurnalrekeningT'])){
            $model->attributes=$_GET['AKJurnalrekeningT'];
            $model->tgl_awal = $_GET['AKJurnalrekeningT']['tgl_awal'];
            $model->tgl_akhir = $_GET['AKJurnalrekeningT']['tgl_akhir'];
        }        
        $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
        $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
        $this->render($this->path_view.'index', array('model'=>$model, 'path_view'=>$this->path_view));
    }
    
    public function actionGetDaftarRekening()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            parse_str($_REQUEST['data'], $data_parsing);
            
            $format = new MyFormatter();
            $model = new AKJurnaldetailT();
            $model->attributes = $data_parsing['AKJurnalrekeningT'];
            $model->is_posting = 1;
            $model->tgl_awal = $format->formatDateTimeForDb($data_parsing['AKJurnalrekeningT']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($data_parsing['AKJurnalrekeningT']['tgl_akhir']);     
            $model->jenisjurnal_id = Params::JENISJURNAL_ID_PENERIMAAN_KAS;
            $record = $model->searchWithJoin();
            $result = array();
            foreach($record->getData() as $key=>$val)
            {
                $attributes = $val->attributes;
                $attributes['tglbuktijurnal'] = date("d-m-Y", strtotime($val->jurnalRekening->tglbuktijurnal));
                $attributes['nobuktijurnal'] = $val->jurnalRekening->nobuktijurnal;
                $attributes['kodejurnal'] = $val->jurnalRekening->kodejurnal;
                $attributes['urianjurnal'] = $val->jurnalRekening->urianjurnal;
                
                $criteria = new CDbCriteria;
				if(!empty($val->rekening1_id)){
					$criteria->addCondition("rekening1_id = ".$val->rekening1_id);			
				}
				if(!empty($val->rekening2_id)){
					$criteria->addCondition("rekening2_id = ".$val->rekening2_id);			
				}
				if(!empty($val->rekening3_id)){
					$criteria->addCondition("rekening3_id = ".$val->rekening3_id);			
				}
				if(!empty($val->rekening4_id)){
					$criteria->addCondition("rekening4_id = ".$val->rekening4_id);			
				}
				if(!empty($val->rekening5_id)){
					$criteria->addCondition("rekening5_id = ".$val->rekening5_id);			
				}
                $rec_nama = AKRekeningakuntansiV::model()->find($criteria);
                
                if(isset($rec_nama['rekening5_id']))
                {
                    $nama_rekening = $rec_nama['nmrekening5'];
                    $kode_rekening = $rec_nama['kdrekening1'] . "-" . $rec_nama['kdrekening2'] . "-" . $rec_nama['kdrekening3'] . "-" . $rec_nama['kdrekening4'] . "-" . $rec_nama['kdrekening5'];
                    $status_rekening = $rec_nama['rekening5_nb'];
                }else{
                    if(isset($rec_nama['rekening4_id']))
                    {
                        $nama_rekening = $rec_nama['nmrekening4'];
                        $kode_rekening = $rec_nama['kdrekening1'] . "-" . $rec_nama['kdrekening2'] . "-" . $rec_nama['kdrekening3'] . "-" . $rec_nama['kdrekening4'];
                        $status_rekening = $rec_nama['rekening4_nb'];
                    }else{
                        $nama_rekening = $rec_nama['nmjenis'];
                        $kode_rekening = $rec_nama['kdrekening1'] . "-" . $rec_nama['kdrekening2'] . "-" . $rec_nama['kdrekening3'];
                        $status_rekening = $rec_nama['rekening3_nb'];
                    }
                }
                $attributes['nama_rekening'] = $nama_rekening;
                $attributes['kode_rekening'] = $kode_rekening;
                $attributes['saldo_normal'] = ($status_rekening == "D" ? "Debit" : "Kredit");
//                $attributes['saldodebit'] = number_format($attributes['saldodebit']);
//                $attributes['saldokredit'] = number_format($attributes['saldokredit']);
                
//                $result[] = $val->attributes;
                $result[] = $attributes;
            }
            echo json_encode($result);
        }
        Yii::app()->end();
    }
    
    public function actionSimpanJurnalPosting()
    {
        if(Yii::app()->request->isAjaxRequest)
        {
            $format = new MyFormatter();
            parse_str($_REQUEST['data'], $data_parsing);
            $transaction = Yii::app()->db->beginTransaction();
            
            try{
                $record = $this->validasiTabular($data_parsing['AKJurnalrekeningT']);
                if(count($record) > 0)
                {
                    $index = "";
                    foreach($record as $key=>$val)
                    {
                        if($index != $val['jurnalrekening_id'])
                        {
                            $model = new AKJurnalpostingT();
                            $model->tgljurnalpost = date("Y-m-d H:i:s");
                            $model->keterangan = $val['urianjurnal'];
                            $model->create_time = date("Y-m-d H:i:s");
                            $model->create_loginpemekai_id = Yii::app()->user->id;
                            $model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                            if($model->validate())
                            {
                                $model->save();
                            }else{
                                $this->pesan = $model->getErrors();
                                $this->success = false;
                            }
                        }
                        $parameter = array(
                            'jurnalposting_id' => $model->jurnalposting_id,
                            'koreksi' => true,
                            'rekening1_id' => $val['rekening1_id'],
                            'rekening2_id' => $val['rekening2_id'],
                            'rekening3_id' => $val['rekening3_id'],
                            'rekening4_id' => $val['rekening4_id'],
                            'rekening5_id' => $val['rekening5_id'],
                            'saldodebit' => $val['saldodebit'],
                            'saldokredit' => $val['saldokredit']
                        );
                        $update = AKJurnaldetailT::model()->updateByPk($val['jurnaldetail_id'], $parameter);
                        $index = $val['jurnalrekening_id'];
                    }
                }
                
                if($this->success)
                {
                    $transaction->commit();
                }
                
            }catch(Exception $exc){
                $transaction->rollback();
                print_r($exc);
                $this->pesan = $exc;
                $this->success = false;
            }
            
            $result = array(
                'action' => $this->is_action,
                'pesan' => $this->pesan,
                'status' => ($this->success == true) ? 'ok' : 'not',
            );
            echo json_encode($result);            
            
        }
        Yii::app()->end();
    }
    
    private function validasiTabular($params)
    {
        $result = array();
        $index = null;
        $i=1;
        foreach ($params as $key=>$val)
        {
            if($val['is_checked'] == 1)
            {
                $result[] = $val;
            }
        }
        return $result;
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