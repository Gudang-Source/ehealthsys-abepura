
<?php

class AnamnesaController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/iframe';
	public $defaultAction = 'index';
	public $path_view = 'rawatJalan.views.anamnesa.';

	public function actionIndex($pendaftaran_id)
	{
			$format = new MyFormatter();
//            $this->layout='//layouts/iframe';
			$modPendaftaran=RJPendaftaranT::model()->findByPk($pendaftaran_id);
            
            $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
            
            $dataPendaftaran = RJPendaftaranT::model()->findAllByAttributes(array('pasien_id'=>$modPasien->pasien_id), array('order'=>'tgl_pendaftaran DESC'));
	    
            $i = 1;
            if (count($dataPendaftaran) > 1){
                foreach ($dataPendaftaran as $row){
                    if ($i == 2){
                        $lastPendaftaran = $row->pendaftaran_id;
                    }
                    $i++;
                }
            }else{
                $lastPendaftaran = $pendaftaran_id;
            }

            
            $cekAnamnesa=RJAnamnesaT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
            $modDiagnosa = new RJDiagnosaM;
           
            if(COUNT($cekAnamnesa)>0) {  //Jika Pasien Sudah Melakukan Anamnesa Sebelumnya				
				$modAnamnesa=new RJAnamnesaT;
				
				$detTriase = (isset($_POST['RJTriase']) ? $_POST['RJTriase'] : null);
                if(isset($detTriase)){
                    if(count($detTriase) > 0){
                        foreach($detTriase as $i=>$triase){
                            $modAnamnesa->triase_id = $triase['triase_id'];
                        }
                    }
                }
				
                $modAnamnesa=$cekAnamnesa;
                
                $lama = explode(" ",$modAnamnesa->lamasakit);
                $modAnamnesa->lamasakit = $lama[0];
                if (!empty($lama[1])) $modAnamnesa->satuanWaktu = $lama[1];
                
		//if ($modAnamnesa->paramedis_nama) $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                //$modAnamnesa->paramedis_nama = empty($pegawai)?null:$pegawai->nama_pegawai;
				
                //$modAnamnesa->riwayatimunisasi = $modPendaftaran->statuspasien;
            } else {  
                ////Jika Pasien Belum Pernah melakukan Anamnesa
                $modAnamnesa=new RJAnamnesaT;
                $modAnamnesa->pegawai_id=$modPendaftaran->pegawai_id;
//                $modAnamnesa->paramedis_nama = "Rina Trianasari, AMd. AK";
		$pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                $modAnamnesa->paramedis_nama = empty($pegawai)?null:$pegawai->nama_pegawai;
                $modAnamnesa->pendaftaran_id=$modPendaftaran->pendaftaran_id;
                $modAnamnesa->pasien_id=$modPendaftaran->pasien_id;
                $modAnamnesa->tglanamnesis=date('Y-m-d H:i:s');
                $modAnamnesa->update_loginpemakai_id = Yii::app()->user->id;
				$modAnamnesa->create_time=date('Y-m-d H:i:s');
				$modAnamnesa->statusmerokok=0;
                //$isPasien = RJPendaftaranT::model()->findByPk($pendaftaran_id)->statuspasien;
//                $sql = "SELECT c(diagnosa_id) FROM pasienimunisasi_t WHERE pendaftaran_id = $pendaftaran_id";
//                $stoks = Yii::app()->db->createCommand($sql)->queryAll();
                
            }
            
            if ($modPendaftaran->statuspasien == "PENGUNJUNG LAMA"){
                $modDiagnosaTerdahulu = RJPasienMorbiditasT::model()->with('diagnosa')->findAllByAttributes(array('pasien_id'=>$modPasien->pasien_id, 'pendaftaran_id'=>$lastPendaftaran));
                
                $hasilImunisasi = array();
                $hasilDiagnosaDahulu = array();
                foreach($modDiagnosaTerdahulu as $row){
                    if ($row->diagnosa->diagnosa_imunisasi == true)
                        $hasilImunisasi[] = (isset($row->diagnosa->diagnosa_nama) ? $row->diagnosa->diagnosa_nama : "");
                    else
                        $hasilDiagnosaDahulu[] = (isset($row->diagnosa->diagnosa_nama) ? $row->diagnosa->diagnosa_nama : "");
                }
                if (empty($modAnamnesa->riwayatimunisais)){
                    $modAnamnesa->riwayatimunisasi = implode(', ',$hasilImunisasi);
                }
                if (empty($modAnamnesa->riwayatpenyakitterdahulu)){
                    $modAnamnesa->riwayatpenyakitterdahulu = implode(', ',$hasilDiagnosaDahulu);
                }
            }
            
            //echo $modAnamnesa->riwayatpenyakitterdahulu;exit();
            if(isset($_POST['RJAnamnesaT'])) {
                $transaction = Yii::app()->db->beginTransaction();
                try {
                    $detTriase = (isset($_POST['RJTriase']) ? $_POST['RJTriase'] : null);
                    $modAnamnesa->attributes=$_POST['RJAnamnesaT'];
                    $modAnamnesa->lamasakit .= " ".$_POST['RJAnamnesaT']['satuanWaktu'];
                    
                    if (empty($modAnamnesa->hpht)) $modAnamnesa->hpht = null;
                    if (empty($modAnamnesa->tgl_persalinan)) $modAnamnesa->tgl_persalinan = null;
                    if(isset($detTriase)){
                        if(count($detTriase) > 0){
                            foreach($detTriase as $i=>$triase){
                                $modAnamnesa->triase_id = $triase['triase_id'];
                            }
                        }
                    }
					$modAnamnesa->tglanamnesis = $format->formatDateTimeForDb($modAnamnesa->tglanamnesis);
                    $modAnamnesa->keluhanutama = isset($_POST['RJAnamnesaT']['keluhanutama']) ? ((count($_POST['RJAnamnesaT']['keluhanutama'])>0) ? implode(', ', $_POST['RJAnamnesaT']['keluhanutama']) : '') : '';
                    $modAnamnesa->keluhantambahan = isset($_POST['RJAnamnesaT']['keluhantambahan']) ? ((count($_POST['RJAnamnesaT']['keluhantambahan'])>0) ? implode(', ', $_POST['RJAnamnesaT']['keluhantambahan']) : '') : '';
                    $modAnamnesa->riwayatperjalananpasien = isset($_POST['RJAnamnesaT']['riwayatperjalananpasien'])?$_POST['RJAnamnesaT']['riwayatperjalananpasien']:null;
                    $modAnamnesa->tglanamnesis = $format->formatDateTimeForDb($_POST['RJAnamnesaT']['tglanamnesis']);
                    $modAnamnesa->petugas_triase_id = isset($_POST['RJAnamnesaT']['petugas_triase_id']) ? $_POST['RJAnamnesaT']['petugas_triase_id'] : null;
                    
                    
                    $updateStatusPeriksa=PendaftaranT::model()->updateByPk($pendaftaran_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));

                    /* ================================================ */
                    /* Proses update status periksa KonsulPoli EHS-179  */
                    /* ================================================ */
					$ruangan_id = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
                    $konsulPoli = KonsulpoliT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id, 'ruangan_id'=>$ruangan_id));
                    if(count($konsulPoli)>0){
                        $updateStatusPeriksa=KonsulpoliT::model()->updateByPk($konsulPoli->konsulpoli_id,array('statusperiksa'=>Params::STATUSPERIKSA_SEDANG_PERIKSA));
                    }
                    $modAnamnesa->create_time = date("Y-m-d H:i:s");
                    $modAnamnesa->create_loginpemakai_id = Yii::app()->user->id;
                    $modAnamnesa->create_ruangan = isset($_GET['ruangan_id']) ? $_GET['ruangan_id'] : Yii::app()->user->getState('ruangan_id');
//					echo print_r($modAnamnesa->attributes);exit;
                    /* ================================================ */
                    
                    if($modAnamnesa->save()){
                        $transaction->commit();
                        $this->redirect(array('index','pendaftaran_id'=>$pendaftaran_id,'sukses'=>1));       
                    }else{
                        Yii::app()->user->setFlash('error',"Data anamnesa gagal disimpan ".CHtml::errorSummary($modAnamnesa));
                    }
                } catch (Exception $exc) {
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
                }
            }
                
            $modAnamnesa->tglanamnesis = $format->formatDateTimeForUser($modAnamnesa->tglanamnesis);
            
            $modDiagnosa = new RJDiagnosaM('searchDiagnosaAnamnesa');
            $modDiagnosa->unsetAttributes();
            if(isset($_GET['RJDiagnosaM']))
                $modDiagnosa->attributes = $_GET['RJDiagnosaM'];
            
            $this->render($this->path_view.'index',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,
							'modAnamnesa'=>$modAnamnesa, 'modDiagnosa'=>$modDiagnosa,
			));
	}

    /**
     * @param type $pendaftaran_id
     */
    public function actionPrintAnamnesa($pendaftaran_id) 
    {
        $this->layout='//layouts/printWindows';
        $format = new MyFormatter;
        $modPendaftaran=RJPendaftaranT::model()->findByPk($pendaftaran_id);
        $modPasien = RJPasienM::model()->findByPk($modPendaftaran->pasien_id);
        $modAnamnesa=RJAnamnesaT::model()->findByAttributes(array('pendaftaran_id'=>$pendaftaran_id));
        
        $judul_print = 'ANAMNESIS';
        $this->render($this->path_view.'printAnamnesa', array(
                            'format'=>$format,
                            'modPendaftaran'=>$modPendaftaran,
                            'judul_print'=>$judul_print,
                            'modPasien'=>$modPasien,
                            'modAnamnesa'=>$modAnamnesa,
        ));
    } 
	
	public function actionMasterKeluhan() 
    {
        if (Yii::app()->request->isAjaxRequest){
            $criteria = new CDbCriteria;
            $criteria->compare('LOWER(keluhananamnesis_nama)', strtolower($_GET['tag']),true);
            $criteria->order = "keluhananamnesis_nama ASC";
            $keluhans = KeluhananamnesisM::model()->findAll($criteria);
            $data = array();
            foreach ($keluhans as $i => $keluhan) {
                $data[$i] = array('key'=>$keluhan->keluhananamnesis_nama,
                                  'value'=>$keluhan->keluhananamnesis_nama);
            }

            echo CJSON::encode($data);
        }
        Yii::app()->end();
    }
	
	/**
     * actionGetTriasePasien untuk Triase Tabulasi Anamnesa:
     * issue		: RND-6415
     */
    public function actionGetTriasePasien()
    {
        
        if(Yii::app()->request->isAjaxRequest) { 
            $triase_id=$_POST['triase_id'];
            
            $modDetail = new RJTriase;
            $modTriase=RJTriase::model()->findByPk($triase_id);
            $warna = RJTriase::model()->getKodeWarnaId($triase_id);
                  $tr ="<tr>
                            <td> ".CHtml::hiddenField('noUrut','',array('class'=>'span1 noUrut','readonly'=>TRUE)).
                                   CHtml::activeHiddenField($modDetail,'['.$triase_id.']triase_id',array('value'=>$modTriase->triase_id, 'class'=>'triase_id'))
                                  ."<div class='colorPicker-picker' style='background-color:#".$warna.";'> </div>".
                           "</td>
                            <td>".$modTriase->triase_nama."</td>
                            <td>".$modTriase->keterangan_triase."</td>
                            <td>".CHtml::link("<span class='icon-remove'>&nbsp;</span>",'',
                                    array('href'=>'#','onClick'=>'batalTriase();return false;','style'=>'text-decoration:none;'))."</td>
                         </tr>   
                        ";
           $data['tr']=$tr;
           echo json_encode($data);
         Yii::app()->end();
        }
    }
	
	public function actionHapusTriase(){ 
		if(Yii::app()->request->isPostRequest)
		{
			$anamesa_id = $_POST['anamesa_id'];
			$triase_id = $_POST['triase_id'];
			$modAnamnesa = AnamnesaT::model()->findByPk($anamesa_id);
			if(!empty($modAnamnesa->triase_id)){
				$update = AnamnesaT::model()->updateByPk($anamesa_id,array('triase_id'=>null));
			}

			if($update){
				if (Yii::app()->request->isAjaxRequest)
				{
					echo CJSON::encode(array(
						'status'=>'proses_form', 
						'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
						));
					exit;               
				}
			}

			// if AJAX request (triggered by deletion via admin grid view), we should not redirect the browser
			if(!isset($_GET['ajax']))
					$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
				throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}
	
	public function actionGetPegawaiTriase()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->order = 'nama_pegawai ASC';
			$models = RJPegawaiM::model()->findAll($criteria);
			$returnVal = array();
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]['label'] = $model->NamaLengkap;
					$returnVal[$i]['value'] = $model->NamaLengkap;
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
			}

			echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
        
}
