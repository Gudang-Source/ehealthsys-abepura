<?php
Yii::import('akuntansi.controllers.JurnalPenerimaanKasController');
Yii::import('akuntansi.views.jurnalPenerimaanKas');

class JurnalPenjualanController extends JurnalPenerimaanKasController
{
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
					$criteria->addCondition("struktur_id = ".$val->rekening1_id);			
				}
				if(!empty($val->rekening2_id)){
					$criteria->addCondition("kelompok_id = ".$val->rekening2_id);			
				}
				if(!empty($val->rekening3_id)){
					$criteria->addCondition("jenis_id = ".$val->rekening3_id);			
				}
				if(!empty($val->rekening4_id)){
					$criteria->addCondition("obyek_id = ".$val->rekening4_id);			
				}
				if(!empty($val->rekening5_id)){
					$criteria->addCondition("rincianobyek_id = ".$val->rekening5_id);			
				}
                $rec_nama = AKRekeningakuntansiV::model()->find($criteria);
                
                if(isset($rec_nama['rincianobyek_id']))
                {
                    $nama_rekening = $rec_nama['nmrincianobyek'];
                    $kode_rekening = $rec_nama['kdstruktur'] . "-" . $rec_nama['kdkelompok'] . "-" . $rec_nama['kdjenis'] . "-" . $rec_nama['kdobyek'] . "-" . $rec_nama['kdrincianobyek'];
                    $status_rekening = $rec_nama['rincianobyek_nb'];
                }else{
                    if(isset($rec_nama['obyek_id']))
                    {
                        $nama_rekening = $rec_nama['nmobyek'];
                        $kode_rekening = $rec_nama['kdstruktur'] . "-" . $rec_nama['kdkelompok'] . "-" . $rec_nama['kdjenis'] . "-" . $rec_nama['kdobyek'];
                        $status_rekening = $rec_nama['obyek_nb'];
                    }else{
                        $nama_rekening = $rec_nama['nmjenis'];
                        $kode_rekening = $rec_nama['kdstruktur'] . "-" . $rec_nama['kdkelompok'] . "-" . $rec_nama['kdjenis'];
                        $status_rekening = $rec_nama['jenis_nb'];
                    }
                }
                $attributes['nama_rekening'] = $nama_rekening;
                $attributes['kode_rekening'] = $kode_rekening;
                $attributes['saldo_normal'] = ($status_rekening == "D" ? "Debit" : "Kredit");
//                $attributes['saldodebit'] = number_format($attributes['saldodebit']);
//                $attributes['saldokredit'] = number_format($attributes['saldokredit']);
                $result[] = $attributes;
            }
            echo json_encode($result);
        }
        Yii::app()->end();
    }
}