<?php
class CekVerifikasiKlaimInasisController extends MyAuthController{
	
	public $path_view = 'asuransi.views.cekVerifikasiKlaimInasis.';
	public $verifikasiinasis = true;
	public $verifikasiklaiminasis = true;
	
	public function actionIndex(){
		$modVerifikasiInasis = new ARVerifikasiinasisT;
		$modVerifikasiKlaimInasis = new ARVerifikasiklaiminasisT;
		$detailVerifikasiKlaim = array();
		
		if(isset($_POST['ARVerifikasiinasisT'])){
			$transaction = Yii::app()->db->beginTransaction();
            try 
			{
				$modVerifikasiInasis->attributes = $_POST['ARVerifikasiinasisT'];
				$modVerifikasiInasis = $this->simpanVerifikasiInasis($modVerifikasiInasis,$_POST['ARVerifikasiinasisT']);
				
				if($modVerifikasiInasis){
					// dicomment karena hasil bridging belum berhasil
//					if(isset($_POST['ARVerifikasiklaiminasisT'])){
//						if(count($_POST['ARVerifikasiklaiminasisT']) > 0){
//							foreach($_POST['ARVerifikasiklaiminasisT'] as $i=>$detail){
//								$detailVerifikasiKlaim[$i] = $this->simpanVerifikasiKlaimInasisi($modVerifikasiInasis,$modVerifikasiKlaimInasis,$detail);
//							}
//						}
//					}
					$modVerifikasiKlaimInasis = $this->simpanVerifikasiKlaimInasisi($modVerifikasiInasis,$modVerifikasiKlaimInasis);
					if($this->verifikasiinasis == false){
						$status = 'Data Verifikasi Inasis gagal disimpan';
					}else if($this->verifikasiklaiminasis == false){
						$status = 'Data Vefifikasi Klaim Inasisi gagal disimpan';
					}else{
						$status = 'Data Verifikasi Klaim Inasisi berhasil disimpan';
					}
					if($this->verifikasiinasis && $this->verifikasiklaiminasis){
						$transaction->commit();						
						Yii::app()->user->setFlash('success',$status);
						$this->redirect(array('index','verifikasiinasis_id'=>$modVerifikasiInasis->verifikasiinasis_id,'sukses'=>1));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',$status);
					}
				}
			} catch (Exception $ex) {
				$transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Verifikasi Klaim Inasis gagal disimpan ! ".MyExceptionMessage::getMessage($ex,true));
			}
		}
		
		$this->render($this->path_view.'index',array(
			'modVerifikasiInasis'=>$modVerifikasiInasis,
			'modVerifikasiKlaimInasis'=>$modVerifikasiKlaimInasis,
		));
	}
	
	public function simpanVerifikasiInasis($modVerifikasiInasis,$postVerifikasi){
		$format = new MyFormatter();
		$modVerifikasiInasis = new ARVerifikasiinasisT();
		
		$modVerifikasiInasis->attributes = $postVerifikasi;
		$modVerifikasiInasis->attribute_6138 = '1';
		$modVerifikasiInasis->verifikasiinasis_tglmasuk = isset($postVerifikasi['verifikasiinasis_tglmasuk']) ? $format->formatDateTimeForUser($modVerifikasiInasis->verifikasiinasis_tglmasuk): null;
		$modVerifikasiInasis->verifikasiinasis_tglkeluar = isset($postVerifikasi['verifikasiinasis_tglkeluar']) ? $format->formatDateTimeForUser($modVerifikasiInasis->verifikasiinasis_tglkeluar): null;
		$modVerifikasiInasis->create_time = date('Y-m-d H:i:s');
		$modVerifikasiInasis->create_loginpemakai_id = Yii::app()->user->id;
		$modVerifikasiInasis->create_ruangan = Yii::app()->user->getState('ruangan_id');
		
		if($modVerifikasiInasis->save()){
			$this->verifikasiinasis = true;
		}else{
			$this->verifikasiinasis = false;
		}
		
		return $modVerifikasiInasis;
	}
	
	public function simpanVerifikasiKlaimInasisi($modVerifikasiInasis,$modVerifikasiKlaimInasisi){		
		$format = new MyFormatter();
		$modVerifikasiKlaimInasisi = new ARVerifikasiklaiminasisT();
		
		$modVerifikasiKlaimInasisi->inacbg_id = 1;
		$modVerifikasiKlaimInasisi->verifikasiinasis_id = $modVerifikasiInasis->verifikasiinasis_id;
		$modVerifikasiKlaimInasisi->sep_id = 1;
		$modVerifikasiKlaimInasisi->pasien_id = 1;
		$modVerifikasiKlaimInasisi->verifikasi_tglsep = date('Y-m-d');
		$modVerifikasiKlaimInasisi->verifikasi_tglpulang = date('Y-m-d');;
		$modVerifikasiKlaimInasisi->verifikasi_jnspelayanan = $modVerifikasiInasis->verifikasiinasis_jnspelayanan;
		$modVerifikasiKlaimInasisi->verifikasi_kelasrawat = $modVerifikasiInasis->verifikasiinasis_kelaspelayanan;
		$modVerifikasiKlaimInasisi->verifikasi_kdstatsep = '1';
		$modVerifikasiKlaimInasisi->verifikasi_nmstatsep = '1';
		$modVerifikasiKlaimInasisi->verifikasi_nomr = '1';
		$modVerifikasiKlaimInasisi->verifikasi_nokartu = '1';
		$modVerifikasiKlaimInasisi->verifikasi_nama = '1';
		$modVerifikasiKlaimInasisi->verifikasi_nosep = '1';
		$modVerifikasiKlaimInasisi->verifikasi_kdinacbg = '1';
		$modVerifikasiKlaimInasisi->verifikasi_kdseverity = '1';
		$modVerifikasiKlaimInasisi->verifikasi_nminacbg = '1';
		$modVerifikasiKlaimInasisi->verifikasi_bytagihan = 0;
		$modVerifikasiKlaimInasisi->verifikasi_bytarifgruper = 0;
		$modVerifikasiKlaimInasisi->verifikasi_bytarifrs = 0;
		$modVerifikasiKlaimInasisi->verifikasi_bytopup = 0;
		
		if($modVerifikasiKlaimInasisi->save()){
			$this->verifikasiklaiminasis = true;
		}else{
			$this->verifikasiklaiminasis = false;
		}
		
		return $modVerifikasiKlaimInasisi;
	}
	
	/**
	* set bpjs Interface
	*/
	public function actionBpjsInterface()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			if(empty( $_GET['param'] ) OR $_GET['param'] === ''){
				die('param can\'not empty value');
			}else{
				$param = $_GET['param'];
			}

 //                if(empty( $_GET['server'] ) OR $_GET['server'] === ''){
 //                    
 //                }else{
 //                    $server = 'http://'.$_GET['server'];
 //                }

			$bpjs = new Bpjs();

			switch ($param) {
				case '1':
					$tglmasuk = $_GET['tglmasuk'];
					$tglkeluar = $_GET['tglkeluar'];
					$jnspelayanan = $_GET['jnspelayanan'];
					$klspelayanan = $_GET['klspelayanan'];
					$status = $_GET['status'];
					$tipepencarian = '';
					print_r( $bpjs->create_verifikasi_klaim($tglmasuk,$tglkeluar,$klspelayanan,$jnspelayanan,$tipepencarian,$status) );
					break;
				case '99':
					$bpjs->identity_magic();
					break;
				case '100':
					print_r( $bpjs->help() );
					break;
				default:
					die('error number, please check your parameter option');
					break;
			}
			Yii::app()->end();
		}
	}
	
	/**
	* @param type $verifikasiinasis_id
	*/
	public function actionPrintVerifikasi($verifikasiinasis_id = null, $caraPrint = null)
	{
		$this->layout='//layouts/printWindows';
		$format = new MyFormatter;
		$model = ARVerifikasiinasisT::model()->findByPk($verifikasiinasis_id);
		$modVerifikasiKlaim = ARVerifikasiklaiminasisT::model()->findAllByAttributes(array('verifikasiinasis_id'=>$model->verifikasiinasis_id));
		$judul_print = 'VERIFIKASI KLAIM';
		$this->render($this->path_view.'print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'model'=>$model,
			'modVerifikasiKlaim'=>$modVerifikasiKlaim
		));
	} 
}