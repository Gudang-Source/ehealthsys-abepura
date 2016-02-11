<?php

class PembayaranTarifKapitasiBPJSController extends MyAuthController {
	
    protected $succesSave = true;
	public $defaultAction = 'index';
    public $path_view = 'asuransi.views.pembayaranTarifKapitasiBPJS.';
	
    public function actionIndex()
	{
        $this->pageTitle = Yii::app()->name . ' - ' . 'Transaksi Pembayaran Tarif Kapitasi BPJS';
		$modPembayaranKapitasi = new ARPembayarankapitasiT;
		$modPembayaranKapitasiDetail = new ARPembayarankapitasidetailT;
		$modTandaBukti = new ARTandabuktibayarT;
		$modPendaftaran = new ARPendaftaranT;
		$modPendaftaran->tgl_awal = date('Y-m-d');
		$modPendaftaran->tgl_akhir = date('Y-m-d');
		$format = new MyFormatter();

		$modPembayaranKapitasi->pembayarankapitasi_tgl = date('Y-m-d H:i:s');
		
		$modTandaBukti->tglbuktibayar = date('Y-m-d H:i:s');
		$modTandaBukti->jmlpembulatan = 0;
		$modTandaBukti->biayaadministrasi = 0;
		$modTandaBukti->biayamaterai = 0;
		$modTandaBukti->jmlpembayaran = $modPembayaranKapitasiDetail->pembayarankapitasidetail_totalpembayaran;
        $tr ='';
		
            if(isset($_POST['ARPembayarankapitasiT'])){
                $transaction = Yii::app()->db->beginTransaction();
                try {
					$modPembayaranKapitasi = $this->savePembayaran($_POST['ARPembayarankapitasiT']);
                    if(isset($_POST['detailPembayaran'])){
                        if(($_POST['detailPembayaran'] == true) && isset($_POST['ARPembayarankapitasidetailT'])){
                            $modPembayaranKapitasiDetail = $this->saveDetailPembayaran($_POST['ARPembayarankapitasidetailT'], $modPembayaranKapitasi);
							if($modPembayaranKapitasiDetail->save()){
								$modTandaBukti = $this->saveTandaBukti($_POST['ARTandabuktibayarT'], $modPembayaranKapitasiDetail);
							}
                        }
                    }
                    if($this->succesSave){
                        
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
					if (Yii::app()->request->isAjaxRequest) 
						{
							$form = "";
							$pesan = "";
							$tgl_awal  = $format->formatDateTimeForDb($_GET['tgl_awal']);
							$tgl_akhir = $format->formatDateTimeForDb($_GET['tgl_akhir']);
							$carabayar_id = $_GET['carabayar_id'];
							$penjamin_id = $_GET['penjamin_id'];
							$no_pendaftaran = $_GET['no_pendaftaran'];
							$tr = $this->createList($tgl_awal, $tgl_akhir, $carabayar_id, $penjamin_id, $no_pendaftaran, true);
							echo $tr;
							 
				Yii::app()->end(); 
			}
		}
            
            $this->render('index',array('modPembayaranKapitasi'=>$modPembayaranKapitasi,
                                        'modPembayaranKapitasiDetail'=>$modPembayaranKapitasiDetail,
                                        'modTandaBukti'=>$modTandaBukti,
										'modPendaftaran'=>$modPendaftaran,
										'format'=>$format,
										'tr'=>$tr,
					));
	}
	
	protected function createList($tgl_awal, $tgl_akhir, $carabayar_id, $penjamin_id, $no_pendaftaran,$status=null) 
	{  
		$criteria = new CDbCriteria();
		$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $tgl_awal, $tgl_akhir,true);
		if(isset($no_pendaftaran)){
			$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($no_pendaftaran),true);
		}
		if(!empty($carabayar_id)){
			$criteria->addCondition('t.carabayar_id = '.$carabayar_id);
		}
		if(!empty($penjamin_id)){
			$criteria->addCondition('t.penjamin_id = '.$penjamin_id);
		}
		$criteria->join = 'JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id';
		$perhitungan = ARPendaftaranT::model()->findAll($criteria);
		//$tr = $this->renderPartial($this->path_view.'_tabelPerhitungan', array('perhitungan'=>$perhitungan), true);

		$tr = $this->rowPerhitungan($perhitungan, isset($data['totaltransaksi']) ? $data['totaltransaksi'] : null, isset($data['tr']) ? $data['tr'] : null );

		return $tr;
	}
	
	protected function rowPerhitungan($perhitungan, $totaltransaksi, $tr) 
	{
		if (count($perhitungan) > 0) {
			foreach ($perhitungan as $i => $row) {
				$jenisTarif = ARTarifkapitasiM::model()->findAll();
				$i++;
				//$totaltransaksi = count($perhitungan);
			   $jumlahTarif = 0;
			   $totalTarif = 0;
			  // $row->pasien->no_rekam_medik = isset($row->pasien->no_rekam_medik) ? $row->pasien->no_rekam_medik : '';
			  // $row->no_pendaftaran = isset($row->no_pendaftaran) ? $row->no_pendaftaran : '';
			  // $row->pasien->nama_pasien = isset($row->pasien->nama_pasien) ? $row->pasien->nama_pasien : '';
			  // $tr .= $this->renderPartial($this->path_view.'_tabelPerhitungan', array('row'=>$row, 'jenisTarif'=>$jenisTarif, 'jumlahTarif'=>$jumlahTarif, 'totalTarif'=>$totalTarif, 'i'=>$i), true);
				$tr .= '<tr >';
				$tr .= '<td rowspan=6>'.$i.'</td>';
				$tr .= '<td rowspan=6>' . $row->pasien->no_rekam_medik."<br/>".$row->no_pendaftaran . '</td>';
				$tr .= '<td rowspan=6>' . $row->pasien->nama_pasien . '</td>';
				$tr .= '<td rowspan=6>' . CHtml::textField('ARPembayarankapitasidetailT['.$i.'][pembayarankapitasidetail_totalpembayaran]', number_format($jumlahTarif), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jumlahTarif integer ', 'readonly' => true)) .'</td>';
				
				$tr .= '</tr>';
				foreach ($jenisTarif as $j => $tarif) {
					$tr .= '<tr><td>' .CHtml::checkBox('ARTarifkapitasiM['.$j.'][cekList]', false, array('value'=>$tarif->tarifkapitasi_nominal, 'onClick' => 'hitungTarif();')). '</td>';
					$tr .= '<td>' .$tarif->tarifkapitasi_nama. '</td></tr>';
				}
				
				//$tr .= '<td>' . $row->pasien->alamat_pasien . '</td>';
				//$tr .= '<td>' . (isset($row->pendaftaran->penanggungJawab->nama_pj) ? $row->pendaftaran->penanggungJawab->nama_pj : "")."-".(isset($row->pendaftaran->penanggungJawab->pengantar) ? $row->pendaftaran->penanggungJawab->pengantar : "") . '</td>';
				//$tr .= '<td>' . $row->nopembayaran . '</td>';
				
				//$tr .= '</tr>';
			}
		}
		return $tr;
	}
        
		protected function savePembayaran($postPembayaran)
        {
            $modPembayaranKapitasi = new ARPembayarankapitasiT;
			$format = new MyFormatter();
            $modPembayaranKapitasi->attributes = $postPembayaran;
			$modPemabayaranKapitasi->create_time = $format->formatDateTimeForDb(date('Y-m-d H:i:s'));
			$modPemabayaranKapitasi->create_loginpemakai_id = Yii::app()->user->id;
			$modPemabayaranKapitasi->create_ruangan = Yii::app()->user->getState('ruangan_id');
            if($modPembayaranKapitasi->validate()){
                $modPembayaranKapitasi->save();
                $this->succesSave = $this->succesSave && true;
            } else {
                $this->succesSave = $this->succesSave && false;
            }
            
            return $modPembayaranKapitasi;
        }
		
		protected function saveDetailPembayaran($arrPostDetailPembayaran,$modPembayaranKapitasi)
        {
            $valid = true;
            for($i=0;$i<count($arrPostDetailPembayaran);$i++){
                $modPembayaranKapitasiDetail[$i] = new ARPembayarankapitasidetailT;
                $modPembayaranKapitasiDetail[$i]->attributes = $arrPostDetailPembayaran[$i];
                $modPembayaranKapitasiDetail[$i]->pembayarankapitasi_id = $modPembayaranKapitasi->pembayarankapitasi_id;
                $valid = $valid && $modPembayaranKapitasiDetail[$i]->validate();
            }
            if($valid){
                for($j=0;$j<count($arrPostDetailPembayaran);$j++){
                    $modPembayaranKapitasiDetail[$j]->save();
                }
            }
            
            $this->succesSave = $this->succesSave && $valid;
            
            return $modPembayaranKapitasiDetail;
        }
	
        protected function saveTandaBukti($postTandaBukti, $modPembayaranKapitasiDetail)
        {
			for($i=0;$i<count($postTandaBukti);$i++){
            $modTandaBukti[$i] = new ARTandabuktibayarT;
            $modTandaBukti[$i]->attributes = $postTandaBukti;
            $modTandaBukti[$i]->ruangan_id = Yii::app()->user->getState('ruangan_id');
            $modTandaBukti[$i]->nourutkasir = MyGenerator::noUrutKasir($modTandaBukti->ruangan_id);
            $modTandaBukti[$i]->nobuktibayar = MyGenerator::noBuktiBayar();
			$modTandaBukti[$i]->pembayarankapitasidetail_id = $modPembayaranKapitasiDetail->pembayarankapitasidetail_id;
			$modTandaBukti[$i]->jmlpembayaran = $modPembayaranKapitasiDetail->pembayarankapitasidetail_totalpembayaran;
            if($modTandaBukti[$i]->validate()){
			$modTandaBukti[$i]->save();
                $this->succesSave = $this->succesSave && true;
            } else {
                $this->succesSave = $this->succesSave && false;
            }
			}
            
            return $modTandaBukti;
        }
		
		public function actionPencarianPendaftaran()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            parse_str($_REQUEST['data'],$data_parsing);
			$form = "";
            $pesan = "";
            $format = new MyFormatter();
			
			if(isset($data_parsing['ARPendaftaranT'])){
				$tgl_awal = isset($data_parsing['ARPendaftaranT']['tgl_awal']) ? $format->formatDateTimeForDb($data_parsing['ARPendaftaranT']['tgl_awal']) : null;
				$tgl_akhir = isset($data_parsing['ARPendaftaranT']['tgl_akhir']) ? $format->formatDateTimeForDb($data_parsing['ARPendaftaranT']['tgl_akhir']) : null;
				$no_pendaftaran = isset($data_parsing['ARPendaftaranT']['no_pendaftaran']) ? $data_parsing['ARPendaftaranT']['no_pendaftaran'] : "";
				$carabayar_id = isset($data_parsing['ARPendaftaranT']['carabayar_id']) ? $data_parsing['ARPendaftaranT']['carabayar_id'] : null;
				$penjamin_id = isset($data_parsing['ARPendaftaranT']['penjamin_id']) ? $data_parsing['ARPendaftaranT']['penjamin_id'] : null;
				
				$criteria = new CDbCriteria();
				$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $tgl_awal, $tgl_akhir,true);
				if(isset($no_pendaftaran)){
					$criteria->compare('LOWER(t.no_pendaftaran)',strtolower($no_pendaftaran),true);
				}
				if(!empty($carabayar_id)){
					$criteria->addCondition('t.carabayar_id = '.$carabayar_id);
				}
				if(!empty($penjamin_id)){
					$criteria->addCondition('t.penjamin_id = '.$penjamin_id);
				}
				$criteria->join = 'JOIN pasien_m ON pasien_m.pasien_id = t.pasien_id';

				$perhitungan = ARPendaftaranT::model()->findAll($criteria);		
				/*if(count($modPendaftaran) > 0 ){
					foreach($modPendaftaran as $i=>$perhitungan){
						$modPerhitunganDetail = new ARPendaftaranT;
						$modPerhitunganDetail->no_pendaftaran = isset($perhitungan->no_pendaftaran) ? $perhitungan->no_pendaftaran : '';
						$modPerhitunganDetail->no_rekam_medik = isset($perhitungan->no_rekam_medik) ? $perhitungan->no_rekam_medik : '';
						$modPerhitunganDetail->nama_pasien = isset($perhitungan->nama_pasien) ? $perhitungan->nama_pasien : '';
						$form .= $this->renderPartial($this->path_view.'_tabelPerhitungan', array('perhitungan'=>$modPerhitunganDetail));
					}
				 * 
				 */
				if (count($perhitungan) > 0) {
					foreach ($perhitungan as $i => $row) {
						$jenisTarif = ARTarifkapitasiM::model()->findAll();
						$i++;
						//$totaltransaksi = count($perhitungan);
						$jumlahTarif = 0;
						$totalTarif = 0;
						$row->pasien->no_rekam_medik = isset($row->pasien->no_rekam_medik) ? $row->pasien->no_rekam_medik : '';
						$row->no_pendaftaran = isset($row->no_pendaftaran) ? $row->no_pendaftaran : '';
						$row->pasien->nama_pasien = isset($row->pasien->nama_pasien) ? $row->pasien->nama_pasien : '';
						$form .= $this->renderPartial($this->path_view.'_tabelPerhitungan', array('row'=>$row, 'jenisTarif'=>$jenisTarif, 'jumlahTarif'=>$jumlahTarif, 'totalTarif'=>$totalTarif, 'i'=>$i), true);
				
					}
				}
				}else{
					$pesan = "Data Pendaftaran Pasien tidak ada!";
				}
			}
			
            
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
		
	public function actionGetPenjaminPasien($encode=false,$namaModel='')
	{
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
        
/**	public $layout = '//layouts/column1';
	public $defaultAction = 'Index';
	public $path_view = 'asuransi.views.pembayaranTarifKapitasiBPJS.';

	//public $path_view_bk = 'billingKasir.views.';
	public function actionIndex() {
		$this->pageTitle = Yii::app()->name . ' - ' . 'Transaksi Pembayaran Tarif Kapitasi BPJS';
		$modPembayaranKapitasi = new ARPembayarankapitasiT;
		$modPembayaranKapitasDetail = new ARPembayarankapitasidetailT;
		$modTandabukti = new TandabuktibayarT;
		$modTandabukti->is_menggunakankartu = 0;
		$modPendaftaran = new PendaftaranT;
		$modTarifKapitasi = new TarifkapitasiM;
		$format = new MyFormatter();

		$modPendaftaran->tgl_awal = date('Y-m-d');
		$modPendaftaran->tgl_akhir = date('Y-m-d');

		$modPemabayaranKapitasi->pembayarankapitasi_tgl = date('Y-m-d H:i:s');
		$modPemabayaranKapitasi->create_time = date('Y-m-d H:i:s');
		$modPemabayaranKapitasi->create_loginpemakai_id = Yii::app()->user->id;
		$modPemabayaranKapitasi->create_ruangan = Yii::app()->user->getState('ruangan_id');
		$modTandabukti->tglbuktibayar = date('Y-m-d H:i:s');

		$tr = '';
		$modDetails = '';
		$id = isset($_GET['id']) ? $_GET['id'] : null;
		if (isset($_GET['id'])) {
			$modPembayaranKapitasi = ARPembayarankapitasiT::model()->findByPk($_GET['id']);
			$modPembayaranKapitasDetail = ARPembayarankapitasidetailT::model()->findByAttributes(array('pembayarankapitasi_id' => $_GET['id']));
		}
		
		if (isset($_POST['ARPembayarankapitasiT'])) {
			$modPembayaranKapitasi->attributes = $_POST['ARPembayarankapitasiT'];
			if (count($_POST['ARPembayarankapitasidetailT']) > 0) {
				//$pembayarankapitasidetail_id = $this->sortPilih($_POST['ARPembayarankapitasidetailT']);
				$modDetails = $this->validasiTabular($modPembayaranKapitasi, $_POST['ARPembayarankapitasidetailT']);
			}
			$modPembayaranKapitasi->pemabayarankapitasi_tgl = isset(MyFormatter::formatDateTimeForDb($_POST['ARPembayarankapitasiT']['pemabayarankapitasi_tgl'])) ? MyFormatter::formatDateTimeForDb($_POST['ARPembayarankapitasiT']['pemabayarankapitasi_tgl']) : null;
			if ($modPembayaranKapitasi->validate()) {
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$success = true;
					if ($modPembayaranKapitasi->save()) {
						$modDetails = $this->validasiTabular($modPembayaranKapitasi, $_POST['ARPembayarankapitasidetailT']);
						foreach ($modDetails as $i => $data) {
							if ($data->pembayarankapitasidetail_id > 0) {
								if ($data->save()) {
									$success = true;
								} else {
									$success = false;
								}
							}
						}
					}
					if ($success == true) {
						$transaction->commit();
						Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
						$this->redirect(array('index', 'id' => $modPembayaranKapitasi->pembayarankapitasi_id));
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('error', "Data gagal disimpan ");
					}
				} catch (Exception $ex) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan " . $ex->getMessage());
				}
			} else {
				Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail pembayaran harus diisi.');
			}
		}

		if ((isset($_GET['tgl_awal'])) && (isset($_GET['tgl_akhir'])) && (isset($_GET['carabayar_id'])) && (isset($_GET['penjamin_id']))) {
			if (Yii::app()->request->isAjaxRequest) {
				$tgl_awal = $format->formatDateTimeForDb($_GET['tgl_awal']);
				$tgl_akhir = $format->formatDateTimeForDb($_GET['tgl_akhir']);
				$carabayar_id = $_GET['carabayar_id'];
				$penjamin_id = $_GET['penjamin_id'];
				$pembayarankapitasi_id = isset($_GET['pembayarankapitasi_id']) ? $_GET['pembayarankapitasi_id'] : null;
				$tr = $this->createList($tgl_awal, $tgl_akhir, $carabayar_id, $penjamin_id, true);
				echo $tr;
				Yii::app()->end();
			}
		}

		$this->render($this->path_view . 'index', array(
			'modPembayaranKapitasi' => $modPembayaranKapitasi,
			'modPembayaranKapitasiDetail' => $modPembayaranKapitasiDetail,
			'modPendaftaran' => $modPendaftaran,
			'modTarifKapitasi' => $modTarifKapitasi,
			'modTandabukti' => $modTandabukti,
			'tr' => $tr,
			'modDetails' => $modDetails,
			'format' => $format,
		));
	}
	
	protected function createList($tgl_awal, $tgl_akhir, $carabayar_id, $penjamin_id, $status = null) {
		$criteria = new CDbCriteria();
		if (!empty($carabayar_id)) {
			$criteria->addCondition("t.carabayar_id = " . $carabayar_id);
		}
		if (!empty($penjamin_id)) {
			$criteria->addCondition("t.penjamin_id = " . $penjamin_id);
		}
		$criteria->addBetweenCondition('DATE(t.tgl_pendaftaran)', $tgl_awal, $tgl_akhir);

		$perhitungan = PendaftaranT::model()->findAll($criteria);

		$tr = $this->rowPerhitungan($perhitungan, isset($data['totaltransaksi']) ? $data['totaltransaksi'] : null, isset($data['tr']) ? $data['tr'] : null );

		return $tr;
	}

	protected function rowPerhitungan($perhitungan, $totaltransaksi, $tr, $text = null) {
		if (count($perhitungan) > 0) {
			$tarifKapitasi = TarifkapitasiM::model()->findAll();
			foreach ($perhitungan as $i => $row) {
				$i++;
				$totaltransaksi = count($perhitungan);
				$tarifBayar = 0;
				$tr .= '<tr >';
				$tr .= '<td>' . $i . '</td>';
				$tr .= '<td>' . $row->no_pendaftaran . "<br/>" . $row->pasien->no_rekam_medik . '</td>';
				$tr .= '<td>' . $row->pasien->nama_pasien . '</td>';
					foreach ($tarifKapitasi as $row){
					echo '<li>'.$row->tarifkapitasi.'</li>';
					}
				$tr .= '<td> Jenis Tarif Kapitasi</td>';
				if ($text == true) {
					$tr .= '<td>' . number_format($row->totalbiayapelayanan) . '</td>';
					$tr .= '<td>' . number_format($row->totalsisatagihan) . '</td>';
					$tr .= '<td>' . number_format($row->uangditerima) . '</td>';
					$tr .= '<td>' . number_format($row->totalbayartindakan) . '</td>';
					$tr .= '<td>' . number_format($row->totalsisatagihan) . '</td>';
				} else {
					$tr .= '<td>' . CHtml::textField('BKPengajuanklaimdetailT[' . $i . '][jmltagihan]', number_format($row->totalbiayapelayanan), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmltagihan integer ', 'readonly' => false, 'onkeyup' => 'hitungSemuaTransaksi()')) . '</td>';
					$tr .= '<td>' . CHtml::textField('BKPengajuanklaimdetailT[' . $i . '][jmlbayar]', number_format($row->totalbayartindakan), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmltagihan integer ', 'readonly' => false, 'onkeyup' => 'hitungSemuaTransaksi()')) . '</td>';
					$tr .= '<td>' . CHtml::textField('BKPengajuanklaimdetailT[' . $i . '][jmlpiutang]', (empty($row->pembklaimdetal_id) ? number_format($jumlahPiutang) : number_format($row->detailklaim->jmlpiutang)), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlpiutang integer ', 'onkeyup' => 'hitungJumlahPiutang(this);')) .
							CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][jmlpiutang2]', (empty($row->pembklaimdetal_id) ? number_format($row->totalsisatagihan) : number_format($row->detailklaim->jmlpiutang)), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlpiutang2 integer')) .
							'</td>';
//                        $tr .= '<td>' . CHtml::textField('BKPengajuanklaimdetailT['.$i.'][jmltelahbayar]', (empty($row->pembklaimdetal_id) ? (empty($row->detailklaim->telahbayar) ? "0" : number_format($row->tandabukti->jmlpembayaran)) : number_format($row->detailklaim->jmltelahbayar)), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmltelahbayar integer ', 'onkeyup' => 'hitungJumlahTelahBayar();')) . '</td>';
//                        $tr .= '<td>' . CHtml::textField('BKPengajuanklaimdetailT['.$i.'][jmlbayar]', (empty($row->pembklaimdetal_id) ? number_format($row->tandabukti->jmlpembayaran) : number_format($row->detailklaim->jmlpiutang - $row->detailklaim->jmltelahbayar) ), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmlbayar integer ', 'onkeyup' => 'hitungSisaTagihan();')) . '</td>';
					$tr .= '<td>' . CHtml::textField('BKPengajuanklaimdetailT[' . $i . '][jmlsisatagihan]', (empty($row->pembklaimdetal_id) ? (empty($row->detailklaim->jmlsisapiutang) ? "0" : number_format($row->totalbiayapelayanan - $row->tandabukti->jmlpembayaran)) : number_format($row->detailklaim->jmlpiutang - ($row->detailklaim->jmltelahbayar + ($row->detailklaim->jmlpiutang - $row->detailklaim->jmltelahbayar)))), array('style' => 'width:70px;', 'class' => 'inputFormTabel span3 jmlsisatagihan integer ', 'onkeyup' => 'hitungSemuaTransaksi();')) . '</td>';

					$tr .= '<td>' . CHtml::checkBox('BKPengajuanklaimdetailT[' . $i . '][cekList]', true, array('value' => $row->pembayaranpelayanan_id, 'class' => 'cek', 'onClick' => 'setAll();')) .
							CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][pendaftaran_id]', $row->pendaftaran_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel integer span3 jmlsisatagihan',)) .
							CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][pasien_id]', $row->pasien_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel integer span3 jmlsisatagihan',)) .
							CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][pembayaranpelayanan_id]', $row->pembayaranpelayanan_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3 ')) .
							CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][tandabuktibayar_id]', $row->tandabuktibayar_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
							CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][carabayar_id]', $row->carabayar_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
							CHtml::hiddenField('BKPengajuanklaimdetailT[' . $i . '][penjamin_id]', $row->penjamin_id, array('style' => 'width:70px;', 'class' => 'inputFormTabel  span3')) .
							'</td>';
				}
				$tr .= '</tr>';
			}
		}
		return $tr;
	}

	protected function sortPilih($data) {
		$result = array();
		foreach ($data as $i => $row) {
			if ($row['cekList'] == 1) {
				$result[] = $row['pembayaranpelayanan_id'];
			}
		}

		return $result;
	}

	protected function validasiTabular($modPengajuanKlaim, $data) {
		foreach ($data as $i => $row) {
			if ($row['cekList'] == 1) {

				$modDetails[$i] = new BKPengajuanklaimdetailT();
				$modDetails[$i]->attributes = $row;
				$modDetails[$i]->pendaftaran_id = $row['pendaftaran_id'];
				$modDetails[$i]->pasien_id = $row['pasien_id'];
				$modDetails[$i]->pengajuanklaimpiutang_id = $modPengajuanKlaim->pengajuanklaimpiutang_id;
				$modDetails[$i]->pembayaranpelayanan_id = $row['pembayaranpelayanan_id'];
				$modDetails[$i]->tandabuktibayar_id = $row['tandabuktibayar_id'];
				$modDetails[$i]->jmlpiutang = $row['jmlpiutang'] - $row['jmlbayar'];
				$modDetails[$i]->jumlahbayar = $row['jmlbayar'];
				$modDetails[$i]->jmltelahbayar = $row['jmlbayar'];
				$modDetails[$i]->jmlsisapiutang = $row['jmlsisatagihan'];
				$modDetails[$i]->validate();
			}
		}
		return $modDetails;
	}

	public function actionGetPenjaminPasien($encode = false, $namaModel = '') {
		if (Yii::app()->request->isAjaxRequest) {
			$carabayar_id = $_POST["$namaModel"]['carabayar_id'];

			if ($encode) {
				echo CJSON::encode($penjamin);
			} else {
				if (empty($carabayar_id)) {
					echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
				} else {
					$penjamin = PenjaminpasienM::model()->findAllByAttributes(array('carabayar_id' => $carabayar_id), array('order' => 'penjamin_nama ASC'));
					if (count($penjamin) > 1) {
						echo CHtml::tag('option', array('value' => ''), CHtml::encode('-- Pilih --'), true);
					}
					$penjamin = CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama');
					foreach ($penjamin as $value => $name) {
						echo CHtml::tag('option', array('value' => $value), CHtml::encode($name), true);
					}
				}
			}
		}
		Yii::app()->end();
	}

	/**
	 * method untuk print tanda bukti pengajuan Klaim Piutang
	 * @param int $pengajuanklaimpiutang_id pengajuanklaimpiutang_id
	 
	public function actionPrint($pengajuanklaimpiutang_id = null) {
		$judulKuitansi = '----- PENGAJUAN KLAIM / PIUTANG -----';
		$format = new MyFormatter();
		$modPengajuanKlaim = BKPengajuanklaimpiutangT::model()->findByPk($pengajuanklaimpiutang_id);
		$modPengajuanKlaimDetail = BKPengajuanklaimdetailT::model()->findAllByAttributes(array('pengajuanklaimpiutang_id' => $pengajuanklaimpiutang_id));

		if (!empty($modPengajuanKlaimDetail->pendaftaran_id)) {
			$modPendaftaran = PendaftaranT::model()->findByPk($modPengajuanKlaimDetail->pendaftaran_id);
			$modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modPengajuanKlaimDetail->pendaftaran->tgl_pendaftaran);
		} else {
			$modPendaftaran = new PendaftaranT;
		}

		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'print', array(
				'modPendaftaran' => $modPendaftaran,
				'judulKuitansi' => $judulKuitansi,
				'caraPrint' => $caraPrint,
				'modPengajuanKlaim' => $modPengajuanKlaim,
				'modPengajuanKlaimDetail' => $modPengajuanKlaimDetail));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'print', array(
				'modPendaftaran' => $modPendaftaran,
				'judulKuitansi' => $judulKuitansi,
				'caraPrint' => $caraPrint,
				'modPengajuanKlaim' => $modPengajuanKlaim,
				'modPengajuanKlaimDetail' => $modPengajuanKlaimDetail));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			//			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
			//            $ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');						   //Posisi L->Landscape,P->Portait
			//$mpdf = new MyPDF('',$ukuranKertasPDF); 
			//$mpdf = new MyPDF('','B5-L');
			$mpdf = new MyPDF('', '', '15', '', 15, 15, 16, 16, 9, 9, 'B5');
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			/*
			 * cara ambil margin
			 * tinggi_header * 72 / (72/25.4)
			 *  tinggi_header = inchi
			 */

			/* font-family: tahoma; 
			// $header = 0.50 * 72 / (72/25.4);
			$header = 0.3 * 72 / (72 / 25.4);
			$mpdf->AddPage($posisi, '', '', '', '', 3, 8, $header, 5, 0, 0);
			$mpdf->WriteHTML(
					$this->renderPartial(
							$this->path_view . 'print', array(
						'modPendaftaran' => $modPendaftaran,
						'judulKuitansi' => $judulKuitansi,
						'caraPrint' => $caraPrint,
						'modPengajuanKlaim' => $modPengajuanKlaim,
						'modPengajuanKlaimDetail' => $modPengajuanKlaimDetail
							), true
					)
			);
			$mpdf->Output();
		}
	}
	*/

}
