<?php

class PembayaranTarifKapitasiBPJSController extends MyAuthController {

	protected $succesSave = true;
	public $defaultAction = 'index';
	public $path_view = 'asuransi.views.pembayaranTarifKapitasiBPJS.';
	public $pembayaranKapitasiSimpan = false;
	public $pembKapitasiDetSimpan = true;
	public $tandaBuktiSimpan = true;

	public function actionIndex(){
		$this->pageTitle = Yii::app()->name . ' - ' . 'Transaksi Pembayaran Tarif Kapitasi BPJS';
		$modPembayaranKapitasi = new ARPembayarankapitasiT;
		$modPembayaranKapitasiDetail = new ARPembayarankapitasidetailT;
		$modTandaBukti = new ARTandabuktibayarT;
		$modPendaftaran = new ARPendaftaranT;
		$modPendaftaran->tgl_awal = date('Y-m-d');
		$modPendaftaran->tgl_akhir = date('Y-m-d');
		$modPendaftarans = array();
		$tr ='';
		$format = new MyFormatter();

		$modPembayaranKapitasi->pembayarankapitasi_tgl = date('Y-m-d H:i:s');

		$modTandaBukti->tglbuktibayar = date('Y-m-d H:i:s');
		$modTandaBukti->jmlpembulatan = 0;
		$modTandaBukti->biayaadministrasi = 0;
		$modTandaBukti->biayamaterai = 0;

			if(isset($_POST['ARPembayarankapitasiT'])){
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$modPembayaranKapitasi = $this->savePembayaran($_POST['ARPembayarankapitasiT']);
					if($this->pembayaranKapitasiSimpan){
						if(count($_POST['ARPembayarankapitasidetailT']) > 0){
							foreach($_POST['ARPembayarankapitasidetailT'] as $i => $postDetail){
								$modPembayaranKapitasiDetail[$i] = $this->saveDetailPembayaran($_POST['ARPembayarankapitasidetailT'], $modPembayaranKapitasi);
								if($this->pembKapitasiDetSimpan){
									$modTandaBukti[$i] = $this->saveTandaBukti($_POST['ARTandabuktibayarT'], $modPembayaranKapitasiDetail[$i]);
								}
							}
						}
					}
					if($this->pembKapitasiDetSimpan&&$this->tandaBuktiSimpan){

						$transaction->commit();
						Yii::app()->user->setFlash('success',"Data berhasil disimpan");
						// $this->refresh();
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data gagal disimpan ");
					}
				} catch (Exception $exc) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
				}
		}
			if ((isset($_GET['tgl_awal'])) && (isset($_GET['tgl_akhir'])) && (isset($_GET['carabayar_id'])) && (isset($_GET['penjamin_id'])&& (isset($_GET['no_pendaftaran'])))) 
			{
				if (Yii::app()->request->isAjaxRequest) {
					$tgl_awal  = $format->formatDateTimeForDb($_GET['tgl_awal']);
					$tgl_akhir = $format->formatDateTimeForDb($_GET['tgl_akhir']);
					$carabayar_id = $_GET['carabayar_id'];
					$penjamin_id = $_GET['penjamin_id'];
					$no_pendaftaran = $_GET['no_pendaftaran'];
					$modPendaftarans = $modPembayaranKapitasi->getPendaftaran($tgl_awal, $tgl_akhir, $carabayar_id, $penjamin_id, $no_pendaftaran);
					$tr = $this->renderPartial($this->path_view.'_tabelPerhitungan', array('modPendaftarans'=>$modPendaftarans),true);
					echo $tr;
					Yii::app()->end();
				}
			}

			$this->render('index',array('modPembayaranKapitasi'=>$modPembayaranKapitasi,
										'modPembayaranKapitasiDetail'=>$modPembayaranKapitasiDetail,
										'modTandaBukti'=>$modTandaBukti,
										'modPendaftaran'=>$modPendaftaran,
										'modPendaftarans'=>$modPendaftarans,
										'format'=>$format,
										'tr'=>$tr,
					));
	}

	protected function savePembayaran($postPembayaran){
		$modPembayaranKapitasi = new ARPembayarankapitasiT;
		$format = new MyFormatter();
		$modPembayaranKapitasi->attributes = $postPembayaran;
		$modPemabayaranKapitasi->create_time =  date('Y-m-d');
		$modPemabayaranKapitasi->create_loginpemakai_id = Yii::app()->user->id;
		$modPemabayaranKapitasi->create_ruangan = Yii::app()->user->getState('ruangan_id');
		if($modPembayaranKapitasi->validate()){
			$modPembayaranKapitasi->save();
			$this->pembayaranKapitasiSimpan &= true;
		} else {
			$this->pembayaranKapitasiSimpan &= false;
			Yii::app()->user->setFlash('error',"Data Tidak valid");
		}

		return $modPembayaranKapitasi;
	}

	protected function saveDetailPembayaran($arrPostDetailPembayaran,$modPembayaranKapitasi){
		$modPembayaranKapitasiDetail = new ARPembayarankapitasidetailT;
		$modPembayaranKapitasiDetail->attributes = $arrPostDetailPembayaran;
		$modPembayaranKapitasiDetail->pembayarankapitasi_id = $modPembayaranKapitasi->pembayarankapitasi_id;
		if($modPembayaranKapitasiDetail->save()){
			$this->pembKapitasiDetSimpan &= true;
		} else {
			$this->pembKapitasiDetSimpan &= false;
		}
		return $modPembayaranKapitasiDetail;
	}

	protected function saveTandaBukti($postTandaBukti, $modPembayaranKapitasiDetail){
		$modTandaBukti = new ARTandabuktibayarT;
		$modTandaBukti->attributes = $postTandaBukti;
		$modTandaBukti->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modTandaBukti->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
		$modTandaBukti->nobuktibayar = MyGenerator::noBuktiBayar();
		$modTandaBukti->pembayarankapitasidetail_id = $modPembayaranKapitasiDetail->pembayarankapitasidetail_id;
		$modTandaBukti->jmlpembayaran = $modPembayaranKapitasiDetail->pembayarankapitasidetail_totalpembayaran;
		if($modTandaBukti->save()){
			$this->tandaBuktiSimpan &= true;
		} else {
			$this->tandaBuktiSimpan &= false;
		}

		return $modTandaBukti;
	}

	public function actionGetPenjaminPasien($encode=false,$namaModel=''){
		if(Yii::app()->request->isAjaxRequest) {
			$carabayar_id = $_POST["$namaModel"]['carabayar_id'];

		   if($encode)
		   {
				echo CJSON::encode($penjamin);
		   } else {
				if(empty($carabayar_id)){
					echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
				} else {
					$penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id'=>$carabayar_id), array('order'=>'penjamin_nama ASC'));
					if(count($penjamin) > 1)
					{
						echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
					}
					$penjamin = CHtml::listData($penjamin,'penjamin_id','penjamin_nama');
					foreach($penjamin as $value=>$name) {
						echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
					}
				}
		   }
		}
		Yii::app()->end();
	}
}
