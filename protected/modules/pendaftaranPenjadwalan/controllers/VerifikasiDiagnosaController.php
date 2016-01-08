<?php

class VerifikasiDiagnosaController extends MyAuthController
{
    public $path_view = 'pendaftaranPenjadwalan.views.verifikasiDiagnosa.';

    
    public function actionIndex($id)
    {
		$this->layout='//layouts/iframe';
        $model = $this->loadModel($id);
        $modUraian = new PPPasienMorbiditasT();
        $modUraianIx = new PPPasienMorbiditasIx();
        $menu = (isset($_REQUEST['menu']) ? $_REQUEST['menu'] : "");
        if($menu == 'RJ')
        {
            $modPendaftaran = PPInfoKunjunganRJV::model()->findByPk($id);
        }else if($menu == 'RD')
        {
            $modPendaftaran = PPInfoKunjunganRDV::model()->findByPk($id);
        }else if($menu == 'RI')
        {
            $modPendaftaran = PPInfoKunjunganRIV::model()->findByPk($id);
        }
        $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
        
        $criteria=new CDbCriteria;
		if(!empty($id)){
			$criteria->addCondition("pendaftaran_id = ".$id); 			
		}
        $criteria->addCondition('diagnosaicdix_id IS NOT NULL');
        $model_ix = PPPasienMorbiditasIx::model()->findAll($criteria);
        
        $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
        $modDiagnosaix = new DiagnosaicdixM();
        
        if(isset($_REQUEST['PPPasienMorbiditasT']))
        {
            $diagnosax = $_REQUEST['PPPasienMorbiditasT'];
            $insert_form = $this->validasiTabular($diagnosax, $modPendaftaran['pendaftaran_id']);
            
            $transaction = Yii::app()->db->beginTransaction();
            try {
                $is_simpan = false;
                $is_create = false;
                $is_insert = false;
                $x = 0;
                foreach($insert_form as $val)
                {
                    if($val['pasienmorbiditas_id'] == null || $val['pasienmorbiditas_id'] == "")
                    {
                        $is_create = true;
                        $insert = new PPPasienMorbiditasT();
                        $insert->attributes = $val;
                        $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
                        $insert->kelompokumur_id = $modPasien->kelompokumur_id;
                        $insert->golonganumur_id = $modPendaftaran->golonganumur_id;
                        $insert->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                        $insert->ruangan_id = Yii::app()->user->getState('ruangan_id');
                        $insert->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $val['diagnosa_id']);
                        $insert->pasien_id = $modPendaftaran->pasien_id;
                        $insert->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                        $insert->$golUmur = 1;
                        if($insert->save())
                        {
                            $is_insert = true;
                        }
                    }else{
                        $attributes = array(
                            'pegawai_id' => $val['pegawai_id'],
                            'diagnosa_id' => $val['diagnosa_id'],
                            'kelompokdiagnosa_id' => $val['kelompokdiagnosa_id']
                        );
                        $update = PPPasienMorbiditasT::model()->updateByPk($val['pasienmorbiditas_id'], $attributes);
                        if($update)
                        {
                            $is_simpan = true;
                        }
                    }
                    $x++;
                }
                
                if(isset($_REQUEST['PPPasienMorbiditasix']))
                {
//					echo "<pre>";
//					print_r($_POST);
//					exit;
                    $diagnosaix = $_REQUEST['PPPasienMorbiditasix'];
                    $insert_ix_form = $this->validasiTabular($diagnosaix, $modPendaftaran['pendaftaran_id'], false);
					
                    $modDiagnosa = $this->loadModel($id);
                    foreach($insert_ix_form as $value)
                    {
                        if($value['pasienmorbiditas_id'] == null || $value['pasienmorbiditas_id'] == "")
                        {
                            $is_create = true;
                            $insert_ix = new PPPasienMorbiditasIx();
                            $insert_ix->diagnosa_id = $modDiagnosa[0]->diagnosa_id;
                            $insert_ix->tglmorbiditas = $value['tglmorbiditas'];
                            $insert_ix->kelompokdiagnosa_id = $value['kelompokdiagnosa_id'];
                            $insert_ix->pegawai_id = $value['pegawai_id'];
                            $insert_ix->diagnosaicdix_id = $value['diagnosaicdix_id'];
                            $insert_ix->ruangan_id = Yii::app()->user->getState('ruangan_id');

                            $golUmur = $this->cekGolonganUmur($modPendaftaran->golonganumur_id);
                            $insert_ix->kelompokumur_id = $modPasien->kelompokumur_id;
                            $insert_ix->golonganumur_id = $modPendaftaran->golonganumur_id;
                            $insert_ix->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
                            $insert_ix->ruangan_id = Yii::app()->user->getState('ruangan_id');
                            $insert_ix->kasusdiagnosa = $this->getKasusDiagnosa($modPendaftaran->pasien_id, $val['diagnosa_id']);
                            $insert_ix->pasien_id = $modPendaftaran->pasien_id;
                            $insert_ix->pendaftaran_id = $modPendaftaran->pendaftaran_id;
                            $insert_ix->$golUmur = 1;
                            
                            if($insert_ix->save())
                            {
                                $is_insert = true;
                            }
                        }else{
                            $attributes = array(
                                'pegawai_id' => $value['pegawai_id'],
                                'diagnosaicdix_id' => $value['diagnosaicdix_id'],
                                'kelompokdiagnosa_id' => $value['kelompokdiagnosa_id']
                            );
                            $update = PPPasienMorbiditasT::model()->updateByPk($value['pasienmorbiditas_id'], $attributes);
                            if($update)
                            {
                                $is_simpan = true;
                            }                            
                        }
                    }
                }
                
                if($is_create)
                {
                    if($is_insert && $is_insert)
                    {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data berhasil disimpan");
                        
                        $criteria=new CDbCriteria;
						if(!empty($id)){
							$criteria->addCondition("pendaftaran_id = ".$id); 			
						}
                        $criteria->addCondition('diagnosaicdix_id IS NOT NULL');
                        $model_ix = PPPasienMorbiditasIx::model()->findAll($criteria);
                        
                        $model = $this->loadModel($id);
                        $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
                        $modDiagnosaix = new DiagnosaicdixM();
                    }else{
                        Yii::app()->user->setFlash('danger',"Data tidak berhasil disimpan");
                    }
                }else{
                    if($is_simpan)
                    {
                        $transaction->commit();
                        Yii::app()->user->setFlash('success',"Data berhasil update");
                        
                        $criteria=new CDbCriteria;
						if(!empty($id)){
							$criteria->addCondition("pendaftaran_id = ".$id); 			
						}
                        $criteria->addCondition('diagnosaicdix_id IS NOT NULL');
                        $model_ix = PPPasienMorbiditasIx::model()->findAll($criteria);
                        
                        $model = $this->loadModel($id);
                        $modDiagnosa = new PPDiagnosaM('searchDiagnosis');
                        $modDiagnosaix = new DiagnosaicdixM();                        
                    }else{
                        Yii::app()->user->setFlash('danger',"Data tidak berhasil update");
                    }
                }
            } catch (Exception $exc) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
            }
        }
        
        $this->render($this->path_view . 'index',
            array(
                'model'=>$model, 
                'modPendaftaran'=>$modPendaftaran, 
                'modDiagnosa'=>$modDiagnosa, 
                'modDiagnosaix'=>$modDiagnosaix, 
                'modUraian'=>$modUraian, 
                'modUraianIx'=>$modUraianIx, 
                'model_ix'=>$model_ix,
                'path_view' =>$this->path_view, 
            )
        );
    }
	
	public function actionGetDiagnosaixM()
	{
		if (Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria;
			$returnVal = array();

			if($_GET['param'] == "kode")
			{
				$criteria->compare('LOWER(diagnosaicdix_kode)',strtolower($_GET['term']), true);
			}

			if($_GET['param'] == "nama")
			{
				$criteria->compare('LOWER(diagnosaicdix_nama)',strtolower($_GET['term']), true);
			}

			if($_GET['param'] == "lainnya")
			{
				$criteria->compare('LOWER(diagnosaicdix_namalainnya)',strtolower($_GET['term']), true);
			}
			$criteria->order = 'diagnosaicdix_nama';
			$criteria->addCondition("diagnosaicdix_aktif = true");
			$models = DiagnosaicdixM::model()->findAll($criteria);
			foreach ($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach ($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = ($_GET['param'] == "lainnya" ? $model->diagnosaicdix_kode . ' - ' . $model->diagnosaicdix_namalainnya : $model->diagnosaicdix_kode . ' - ' . $model->diagnosaicdix_nama);
				$returnVal[$i]['value'] = $model->diagnosaicdix_id;
			}
			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
	public function actionGetDiagnosaM()
	{
		if (Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria;
			$returnVal = array();

			if($_GET['param'] == "kode")
			{
				$criteria->compare('LOWER(diagnosa_kode)',strtolower($_GET['term']), true);
			}

			if($_GET['param'] == "nama")
			{
				$criteria->compare('LOWER(diagnosa_nama)',strtolower($_GET['term']), true);
			}

			if($_GET['param'] == "lainnya")
			{
				$criteria->compare('LOWER(diagnosa_namalainnya)',strtolower($_GET['term']), true);
			}
			$criteria->order = 'diagnosa_nama';
			$criteria->addCondition("diagnosa_aktif = true");
			$models = DiagnosaM::model()->findAll($criteria);
			foreach ($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach ($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = ($_GET['param'] == "lainnya" ? $model->diagnosa_kode . ' - ' . $model->diagnosa_namalainnya : $model->diagnosa_kode . ' - ' . $model->diagnosa_nama);
				$returnVal[$i]['value'] = $model->diagnosa_id;
			}
			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
    
    protected function validasiTabular($params, $pendaftaran_id, $is_diagnosa = true)
    {
        $result = array();
        foreach($params as $i => $val)
        {
            if($val['pasienmorbiditas_id'] == null || $val['pasienmorbiditas_id'] == "" || (strlen($val['pasienmorbiditas_id']) == 0))
            {
                if($is_diagnosa)
                {
                    $attributes = array(
                        'pendaftaran_id'=>$pendaftaran_id,
                        'diagnosa_id'=>$val['diagnosa_id']
                    );                    
                }else{
                    $attributes = array(
                        'pendaftaran_id'=>$pendaftaran_id,
                        'diagnosaicdix_id'=>$val['diagnosaicdix_id']
                    );                    
                }
//				if($i == 0){
//					echo "<pre>";
//					print_r($_POST);
//					
//					echo "<pre>";
//					print_r($val);
//					exit;
//				}
                $model = PPPasienMorbiditasT::model()->findByAttributes($attributes);
                if(!$model)
                {
                    $result[] = $val;
                }
            }else{
                $result[] = $val;
                /*
                $attributes = array(
                    'pendaftaran_id'=>$pendaftaran_id,
                    'diagnosa_id'=>$val['diagnosa_id']
                );
                $model = PPPasienMorbiditasT::model()->findByAttributes($attributes);
                if(!$model)
                {
                    $result[] = $val;
                }
                 */
            }
        }
        return $result;
    }
    
    public function actionHapusDiagnosax()
    {
        $delete = 'false';
        $id = (isset($_POST['pasienmorbiditas_id']) ? $_POST['pasienmorbiditas_id'] : null);
        
        $transaction = Yii::app()->db->beginTransaction();
        $remove = PPPasienMorbiditasT::model()->deleteByPk($id);
        if($remove){
            $transaction->commit();
            $delete = 'ok';
        }else{
            $transaction->rollback();
        }
        echo CJSON::encode(array('status'=>$delete));
    }
    
    public function loadModel($id)
    {
        $criteria=new CDbCriteria;
		if(!empty($id)){
			$criteria->addCondition("pendaftaran_id = ".$id); 			
		}
        $criteria->addCondition('diagnosaicdix_id IS NULL');
        $model = PPPasienMorbiditasT::model()->findAll($criteria);
        /*
        $attributes = array('pendaftaran_id'=>$id);
        $model = PPPasienMorbiditasT::model()->findAllByAttributes($attributes);
         * 
         */
        if($model === null)
            throw new CHttpException(404,'The requested page does not exist.');
        return $model;
    }
    
    protected function getKasusDiagnosa($pasien_id,$idDiagnosa)
    {
        $modMorbiditas = PasienmorbiditasT::model()->findByAttributes(array('pasien_id'=>$pasien_id,'diagnosa_id'=>$idDiagnosa));
        if(!empty($modMorbiditas))
            return Params::KASUSDIAGNOSA_KASUS_LAMA;
        else 
            return Params::KASUSDIAGNOSA_KASUS_BARU;
    }
    
    private function cekGolonganUmur($idGolonganUmur)
    {
        switch ($idGolonganUmur) {
            case 1:return 'umur_0_28hr';
            case 2:return 'umur_28hr_1thn';
            case 3:return 'umur_1_4thn';
            case 4:return 'umur_5_14thn';
            case 5:return 'umur_15_24thn';
            case 6:return 'umur_25_44thn';
            case 7:return 'umur_45_64thn';
            case 8:return 'umur_65';

            default:
                break;
        }

    }    
    
}