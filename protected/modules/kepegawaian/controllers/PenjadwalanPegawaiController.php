<?php
class PenjadwalanPegawaiController extends MyAuthController
{
	protected  $path_view = 'kepegawaian.views.penjadwalanPegawai.';
	public $layout='//layouts/column1';
    public $defaultAction = 'index';
	public $penjadwalantersimpan = false;
	public $penjadwalandetailtersimpan = false;

    public function actionIndex($id = null){
        $model = new KPPenjadwalanT;
		$modPenjadwalanDetail = new KPPenjadwalandetailT;
		$instalasiAsal = CHtml::listData(KPInstalasiM::getInstalasiItems(),'instalasi_id','instalasi_nama');
        $ruanganAsal = CHtml::listData(KPRuanganM::getRuanganItems(),'ruangan_id','ruangan_nama');
		$model->no_pembuatanjadwal = '-Otomatis-';
		$model->periodebuatjadwal = date('Y-m-d');
		$model->sampaidengan = date('Y-m-d');
		$model->tglbuatjadwal = date('Y-m-d');
		$modDetails=array();
		
		if(isset($_POST['KPPenjadwalanT'])){
			$transaction = Yii::app()->db->beginTransaction();
            try {
				$model = $this->simpanPenjadwalan($model,$_POST['KPPenjadwalanT']);
				if(count($_POST['KPPenjadwalandetailT']) > 0){
					foreach($_POST['KPPenjadwalandetailT'] as $i=>$details){
						if($details['checklist'] == 1){
							foreach($details['shift'] as $j=>$shift){
								$modDetails[$j] = $this->simpanPenjadwalanDetail($_POST['KPPenjadwalandetailT'], $details, $shift, $model);
							}
						}
					}
				}

				if($this->penjadwalantersimpan && $this->penjadwalandetailtersimpan){
					$transaction->commit();
					$this->redirect(array('index','id'=>$model->penjadwalan_id,'sukses'=>1));       
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
			'model'=>$model,
			'modPenjadwalanDetail'=>$modPenjadwalanDetail,
			'instalasiAsal'=>$instalasiAsal,
			'ruanganAsal'=>$ruanganAsal
		));
    }
	
	/**
	 * proses simpan data penjadwalan pegawai
	 * @param type $model
	 * @param type $post
	 * @return type
	 */
	public function simpanPenjadwalan($model, $post){
		$format = new MyFormatter();
		$model = new KPPenjadwalanT;
		$model->attributes = $_POST['KPPenjadwalanT'];
		$model->no_pembuatanjadwal = MyGenerator::noPenjadwalanPegawai();
		$model->periodebuatjadwal = $format->formatDateTimeForDb($post['periodebuatjadwal']);
		$model->sampaidengan = $format->formatDateTimeForDb($post['sampaidengan']);
		$model->tglbuatjadwal = $format->formatDateTimeForDb($post['tglbuatjadwal']);
		$model->tglmengetahui = !empty($model->mengetahui_id) ? date('Y-m-d') : "";
		$model->tglmenyetujui = !empty($model->menyetujiu_id) ? date('Y-m-d') : "";
		$model->create_time = date('Y-m-d H:i:s');
		$model->create_loginpemakai_id = Yii::app()->user->id;
		$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
		
		if($model->validate()){
			$model->save();
			$this->penjadwalantersimpan = true;
		}else{
			$this->penjadwalantersimpan = false;
		}

		return $model;
	}
	
	/**
     * simpan PenjadwalandetailT
     * @param type $model
     * @param type $postPenjadwalan
     * @return \PenjadwalandetailT
     */
    protected function simpanPenjadwalanDetail($postPenjadwalanDetail,$details,$shift,$postPenjadwalan){
		$format = new MyFormatter;
		$modPenjadwalanDetail = new KPPenjadwalandetailT;
		$modPenjadwalanDetail->attributes = $details;
		$modPenjadwalanDetail->penjadwalan_id = $postPenjadwalan->penjadwalan_id;	
		$modPenjadwalanDetail->penjadwalan_id = $postPenjadwalan->penjadwalan_id;	
		$modPenjadwalanDetail->tgljadwalpegawai = $shift['tgljadwalpegawai'];	
		$modPenjadwalanDetail->shift_id = $shift['shift_id'];	

		if($modPenjadwalanDetail->validate()){
			$modPenjadwalanDetail->save();            
			$this->penjadwalandetailtersimpan = true;
		}else{
			$this->penjadwalandetailtersimpan = false;
		}
		return $modPenjadwalanDetail;
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
	 * menampilkan ruangan dan pola shift
	 */
	public function actionGetRuanganForCheckBox(){
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$model = new KPPenjadwalanT;
			$modPenjadwalanDetail = new KPShiftM;
			$instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
			//PROSES PENCARIAN RUANGAN
			$criteria = new CDbCriteria();
			if(!empty($instalasi_id)){
				$criteria->addCondition('instalasi_id = '.$instalasi_id);
			}else{
				$criteria->addCondition('instalasi_id = null');
			}
			$modRuangan = KPRuanganM::model()->findAll($criteria);
//			$modShift	= KPShiftM::getData();
			//END PENCARIAN
			$form= "";
			if(count($modRuangan) > 0){
				foreach($modRuangan AS $i => $ruangan){			
					$criteria = new CDbCriteria();
					$criteria->select = 't.*,shift_m.*,ruangan_m.*';
					if(!empty($ruangan->ruangan_id)){
						$criteria->addCondition('t.ruangan_id = '.$ruangan->ruangan_id);
					}
					$criteria->addCondition('shift_m.shift_aktif = TRUE');
					$criteria->order ='shift_m.shift_urutan ASC';
					$criteria->join = 'JOIN shift_m ON shift_m.shift_id = t.shift_id'
							. ' JOIN ruangan_m ON ruangan_m.ruangan_id = t.ruangan_id';
					$modShift = KPFormasishiftM::model()->findAll($criteria);
					$modRuangan = KPRuanganM::model()->findAllByAttributes(array('ruangan_id'=>$ruangan->ruangan_id));
					$modPenjadwalanDetail->ruangan_id = $ruangan->ruangan_id;
					$modPenjadwalanDetail->ruangan_nama = $ruangan->ruangan_nama;
					$form .= $this->renderPartial('_dataRuangan', array(
						'model'=>$model,
						'modPenjadwalanDetail'=>$modPenjadwalanDetail,
						'modRuangan'=>$modRuangan,
						'modShift'=>$modShift,
						'ruangan'=>$ruangan
					), true);
				}
			}else{
				$form = '<label>Data Tidak Ditemukan</label>';
			}
			$data['form'] = $form;
			echo json_encode($data);
		}
		Yii::app()->end();
	}
	
	/**
	 * menampilkan ruangan dan pola shift
	 */
	public function actionGetPenjadwalan(){
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$format = new MyFormatter();
			$model = new KPPenjadwalanT;
			$modShift = new KPShiftM;
			$modPenjadwalanDetail = new KPPenjadwalandetailT;
			
			
			$pegawai_id = isset($_POST['pegawai_id']) ? $_POST['pegawai_id'] : null;
			$instalasi_id = isset($_POST['instalasi_id']) ? $_POST['instalasi_id'] : null;
			$ruangan_id = isset($_POST['ruangan_id']) ? $_POST['ruangan_id'] : null;
			$pola_shift = isset($_POST['pola_shift']) ? $_POST['pola_shift'] : "";
			$kelompokpegawai_id = isset($_POST['kelompokpegawai_id']) ? $_POST['kelompokpegawai_id'] : "";
			$periodepenjadwalan = isset($_POST['periodepenjadwalan']) ? $_POST['periodepenjadwalan'] : "";
			$sampaidengan = isset($_POST['sampaidengan']) ? $_POST['sampaidengan'] : "";
			
			$tgl_awal = $format->formatDateTimeForDb($periodepenjadwalan);
			$tgl_akhir = $format->formatDateTimeForDb($sampaidengan);
						
			$jumlah_hari = ((abs(strtotime ($tgl_akhir) - strtotime ($tgl_awal)))/(60*60*24));
			
			if(!empty($ruangan_id)){
				$criteria = new CDbCriteria();
				$criteria->with = array('pegawai');
				$criteria->addCondition("t.ruangan_id = ".$ruangan_id);
				if(!empty($kelompokpegawai_id)){
					$criteria->addCondition("pegawai.kelompokpegawai_id = ".$kelompokpegawai_id);
				}
				$modPegawaiRuangan = KPRuanganpegawaiM::model()->findAll($criteria);
			}
//			$modShift	= KPShiftM::getData();
			$criteria = new CDbCriteria();
			$criteria->select = 't.*,shift_m.*,ruangan_m.*';
			if(!empty($ruangan_id)){
				$criteria->addCondition('t.ruangan_id = '.$ruangan_id);
			}
			$criteria->addCondition('shift_m.shift_aktif = TRUE');
			$criteria->order ='shift_m.shift_urutan ASC';
			$criteria->join = 'JOIN shift_m ON t.shift_id = shift_m.shift_id'
					. ' JOIN ruangan_m ON t.ruangan_id = ruangan_m.ruangan_id';
			$modFormasiShift = KPFormasishiftM::model()->findAll($criteria);
			
			//==== POLA SHIFT
			$pola = $pola_shift;
			$jmlpola = strlen($pola);
			$shift = array();
			for($i=0;$i<$jmlpola;$i++){
				$shift[$i] = substr($pola,($i),1);
			}
			//===
			$jmlpegawai = array();
			if(count($modFormasiShift) > 0){
				foreach ($modFormasiShift AS $i => $cekshift){
					if (strpos(strtoupper($pola),strtoupper($cekshift->shift_kode)) !== false) { //hanya masukan yg ada di pola saja
						$jmlpegawai[$cekshift->shift_kode] = $_POST['jmlpegawais'][$i];
					}
				}
			}
			$form= "";
			if(!empty($pegawai_id)){ //Load dari Autocomplete
				$modRuangan = KPRuanganM::model()->findByPk($ruangan_id);
				$modPegawai = KPPegawaiM::model()->findByPk($pegawai_id);
				$modPenjadwalanDetail->instalasi_nama = isset($modRuangan->instalasi->instalasi_nama) ? $modRuangan->instalasi->instalasi_nama : "";
				$modPenjadwalanDetail->ruangan_nama = $modRuangan->ruangan_nama;
				$modPenjadwalanDetail->ruangan_id = $modRuangan->ruangan_id;
				$modPenjadwalanDetail->pegawai_id = $modPegawai->pegawai_id;
				$modPenjadwalanDetail->nama_pegawai = $modPegawai->NamaLengkap;
				$modPenjadwalanDetail->checklist = 1;
				$form = $this->renderPartial('_rowPenjadwalan', array(
					'model'=>$model,
					'modPenjadwalanDetail'=>$modPenjadwalanDetail,
					'modShift'=>$modShift,
					'modFormasiShift'=>$modFormasiShift,
					'jml_hari'=>$jumlah_hari,
					'tgl_awal'=>$tgl_awal,
					'tgl_akhir'=>$tgl_akhir,
					'shift'=>$shift,
				), true);
			}else{
				if(count($modPegawaiRuangan) > 0){
					$polaawal = $shift;
					$selectedoptions = true;
					foreach($modPegawaiRuangan AS $i => $ruangan){				
						$modPenjadwalanDetail->instalasi_nama = isset($ruangan->ruangan->instalasi->instalasi_nama) ? $ruangan->ruangan->instalasi->instalasi_nama : "";
						$modPenjadwalanDetail->ruangan_nama = isset($ruangan->ruangan->ruangan_nama) ? $ruangan->ruangan->ruangan_nama : "";
						$modPenjadwalanDetail->nama_pegawai = isset($ruangan->pegawai->NamaLengkap) ? $ruangan->pegawai->NamaLengkap : "";
						$modPenjadwalanDetail->ruangan_id = isset($ruangan->ruangan_id) ? $ruangan->ruangan_id : "";
						$modPenjadwalanDetail->pegawai_id = isset($ruangan->pegawai_id) ? $ruangan->pegawai_id : "";
						$modPenjadwalanDetail->checklist = 1;
						if($jmlpegawai[$shift[0]] == 0){ 
							while(1){ //ubah pola ke jmlpegawai yg tersedia
								$tempshift = $shift[0];
								unset($shift[0]);
								$shift = array_values($shift);
								$shift[count($shift)] = $tempshift;
								if($jmlpegawai[$shift[0]] > 0) break;
								if($polaawal == $shift){ // jika pola kembali ke awal
									$selectedoptions = false;
									break;
								}
							}
							
						}
						$form .= $this->renderPartial('_rowPenjadwalan', array(
							'model'=>$model,
							'modPenjadwalanDetail'=>$modPenjadwalanDetail,
							'modShift'=>$modShift,
							'modFormasiShift'=>$modFormasiShift,
							'jml_hari'=>$jumlah_hari,
							'tgl_awal'=>$tgl_awal,
							'tgl_akhir'=>$tgl_akhir,
							'shift'=>$shift,
							'jmlpegawai'=>$jmlpegawai,
							'selectedoptions'=>$selectedoptions,
						), true);
						if($jmlpegawai[$shift[0]] > 0){
							$jmlpegawai[$shift[0]] --;
						}
					}
				}else{
					$form = '<label>Data Tidak Ditemukan</label>';
				}
				
			}
			
			$data['form'] = $form;
			$data['jumlah_hari'] = $jumlah_hari;
			
			$data['kolom_tanggal'] =  $this->renderPartial('_rowTanggal', array(
						'jumlah_hari'=>$jumlah_hari,
						'tgl_awal'=>$tgl_awal,
					), true);
			echo json_encode($data);
		}
		Yii::app()->end();
	}
	
	
}