<?php
class PertukaranShiftController extends MyAuthController{
	protected $path_view = 'kepegawaian.views.pertukaranShift.';
	public $layout='//layouts/column1';
    public $defaultAction = 'index';
	public $pertukaranjadwaltersimpan = true;
	public $pertukaranjadwaldetailtersimpan = true;
	
	public function actionIndex($id = null){
		$format = new MyFormatter();
		$model = new KPPertukaranjadwalT();
		$model->tglpermohonanpertukaran = date('Y-m-d');
		$model->no_permohonanpertukaran = '-Otomatis-';
		$modDetail = new KPPertukaranjadwaldetT();
		
		if(!empty($id)){
			$model = KPPertukaranjadwalT::model()->findByPk($id);
			$model->ygmengajukan1_nama = isset($model->ygmengajukan1->NamaLengkap) ?  $model->ygmengajukan1->NamaLengkap : "";
			$model->ygmengajukan2_nama = isset($model->ygmengajukan2->NamaLengkap) ?  $model->ygmengajukan2->NamaLengkap : "";
			$model->ygmenyetujui1_nama = isset($model->ygmenyetujui1->NamaLengkap) ?  $model->ygmenyetujui1->NamaLengkap : "";
			$model->ygmenyetujui2_nama = isset($model->ygmenyetujui2->NamaLengkap) ?  $model->ygmenyetujui2->NamaLengkap : "";
			$model->ygmengetahui_nama = isset($model->ygmengetahui->NamaLengkap) ?  $model->ygmengetahui->NamaLengkap : "";
		}
		if(isset($_POST['KPPertukaranjadwalT'])){
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$model = $this->simpanPertukaranShift($model,$_POST['KPPertukaranjadwalT']);
				if(count($_POST['KPPertukaranjadwaldetT'])){
					foreach($_POST['KPPertukaranjadwaldetT'] as $i=>$details){
						$modDetails[$i] = $this->simpanPertukaranDetail($_POST['KPPertukaranjadwaldetT'], $details, $model);
					}
				}
				
				if($this->pertukaranjadwaltersimpan && $this->pertukaranjadwaldetailtersimpan){
					$transaction->commit();
					$this->redirect(array('index','id'=>$model->pertukaranjadwal_id,'sukses'=>1));       
				}else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data Penjadwalan Pegawai gagal disimpan !");
				}
			} catch (Exception $ex) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($ex,true));
			}
		}
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$model,
			'modDetail'=>$modDetail
		));
	}
	
	/**
	 * proses simpan data pertukaran jadwal pegawai
	 * @param type $model
	 * @param type $post
	 * @return type
	 */
	public function simpanPertukaranShift($model, $post){
		$format = new MyFormatter();
		$model = new KPPertukaranjadwalT();
		$model->attributes = $post;
		$model->no_permohonanpertukaran = MyGenerator::noPertukaranJadwal();
		$model->tglpermohonanpertukaran = $format->formatDateTimeForDb($post['tglpermohonanpertukaran']);
		$model->ruangan_id = Yii::app()->user->getState('ruangan_id');
		
		if($model->validate()){
			$model->save();
			$this->pertukaranjadwaltersimpan = true;
		}else{
			$this->pertukaranjadwaltersimpan = false;
		}

		return $model;
	}
	
	/**
     * simpan KPPertukaranjadwaldetT
     * @param type $model
     * @param type $postPertukaran
     * @return \KPPertukaranjadwaldetT
     */
    protected function simpanPertukaranDetail($postPenjadwalanDetail,$details,$postPertukaran){
		$format = new MyFormatter;
		$modDetail = new KPPertukaranjadwaldetT();
		$modDetail->attributes = $details;
		$modDetail->pertukaranjadwal_id = $postPertukaran->pertukaranjadwal_id;		
		$modDetail->tglpertukaranjadwal = $postPertukaran->tglpermohonanpertukaran;	
		$modDetail->shift_id = $details['shift_id'];	
		$modDetail->create_time = date('Y-m-d H:i:s');
		$modDetail->create_loginpemakai_id = Yii::app()->user->id;
		$modDetail->create_ruangan = Yii::app()->user->getState('ruangan_id');	
		$modDetail->ruangan_id = Yii::app()->user->getState('ruangan_id');	

		if($modDetail->validate()){
			$modDetail->save();   
			
			$criteria = new CDbCriteria();
			$criteria->addCondition('penjadwalan_id = '.$details['penjadwalan_id']);
			$criteria->addCondition('pegawai_id = '.$details['pegawai_id']);
			$criteria->addCondition('shift_id = '.$details['shiftasal_id']);
			$modPenjadwalanDetail = KPPenjadwalandetailT::model()->find($criteria);
			$modPenjadwalanDetail->pertukaranjadwaldet_id = $modDetail->pertukaranjadwaldet_id;
			$modPenjadwalanDetail->update();
			$modDetail->ruangan_id = $modPenjadwalanDetail->ruangan_id;
			$modDetail->update();
			$this->pertukaranjadwaldetailtersimpan = true;
		}else{
			$this->pertukaranjadwaldetailtersimpan = false;
		}
		return $modDetail;
    }
	
	/**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(KPRuanganM::getRuanganItems($instalasi_id),'ruangan_id','ruangan_nama');

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
	
	public function actionAutocompletePegawai()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$pegawai_id = isset($_GET['pegawai_id']) ? $_GET['pegawai_id'] : null;
			$nama_pegawai = isset($_GET['nama_pegawai']) ? $_GET['nama_pegawai'] : null;
			
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($nama_pegawai), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = KPPegawaiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
                $returnVal[$i]['nama_pegawai'] = $model->NamaLengkap;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	/**
	 * menampilkan data shift berdasarkan
	 * @pegawai_id,@tgl_shift
	 */
	public function actionGetDataShift(){
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$form = "";
			$pesan = "";
			$asal_shift ='';
			$dropdownShift = '';
			
			$format = new MyFormatter();
			$model = new KPPenjadwalanT;
			$modPenjadwalanDetail = new KPShiftM;
			$pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
			$tglshift = isset($_POST['tglshift']) ? $_POST['tglshift'] : null;
			
			$modPegawai = KPPegawaiM::model()->findByPk($pegawai_id);
			//PROSES PENCARIAN DATA SHIFT
			$tgl = isset($tglshift) ? $format->formatDateTimeForDb($tglshift) : "";
			
			$criteria = new CDbCriteria();
			if(!empty($tgl)){
				$criteria->addBetweenCondition('DATE(tgljadwalpegawai)', $tgl, $tgl);
			}			
			if(!empty($pegawai_id)){
				$criteria->addCondition('pegawai_id = '.$pegawai_id);
			}
			$modDataShifts = KPPenjadwalandetailT::model()->findAll($criteria);
			$modDataShift = KPPenjadwalandetailT::model()->find($criteria);
			//END PENCARIAN
			
			if(count($modDataShifts) > 0){
				foreach($modDataShifts AS $i => $shift){				
					$asal_shift .= $shift->shift_id;
				}
			}else{
				$pesan = 'Penjadwalan Shift Atas Nama Pegawai : '.$modPegawai->NamaLengkap.' belum disetting';
			}
			//==== POLA SHIFT
			$asal_shift = $asal_shift;
			$jmlshift = strlen($asal_shift);
			$shift = array();
			for($i=0;$i<$jmlshift;$i++){
				$shift[$i] = substr($asal_shift,($i),1);
			}
			
			$criteriaShift = new CDbCriteria();
			if(count($shift) > 0){
				$criteriaShift->addInCondition('shift_id', $shift);
			}
			$modShift = KPShiftM::model()->findAll($criteriaShift);
			$models = CHtml::listData($modShift,'shift_id','shift_kode');

            if(isset($models)){
                $dropdownShift .= CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(count($models) > 0){
                    foreach($models as $value=>$name){
                        $dropdownShift .= CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
			//===
			$data['form'] = $form;
			$data['pesan'] = $pesan;
			$data['dropdownShift'] = $dropdownShift;
			$data['penjadwalan_id'] = isset($modDataShift->penjadwalan_id) ? $modDataShift->penjadwalan_id : null;
			echo json_encode($data);
		}
		Yii::app()->end();
	}
	
	/**
     * untuk print data pertukaran shift
     */
    public function actionPrint($pertukaranjadwal_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $modPertukaranJadwal = KPPertukaranjadwalT::model()->findByPk($pertukaranjadwal_id);     
        $modPertukaranJadwalDetail = KPPertukaranjadwaldetT::model()->findAllByAttributes(array('pertukaranjadwal_id'=>$modPertukaranJadwal->pertukaranjadwal_id));
		
        $judul_print = 'Permohonan Pertukaran Dinas';
        
        $this->render($this->path_view.'Print', array(
                'format'=>$format,
                'judul_print'=>$judul_print,
                'modPertukaranJadwal'=>$modPertukaranJadwal,
                'modPertukaranJadwalDetail'=>$modPertukaranJadwalDetail,
                'caraprint'=>$caraprint
        ));
    } 
	
}
