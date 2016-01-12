<?php
class PengajuanKlaimPiutangController extends MyAuthController
{
	public $layout='//layouts/column1';
	public $defaultAction = 'Index';
	public $path_view = 'billingKasir.views.pengajuanKlaimPiutang.';
	public $path_view_bk = 'billingKasir.views.';
       
	public function actionIndex()
	{
		$this->pageTitle = Yii::app()->name.' - '.'Transaksi Pengajuan Klaim / Piutang';

		$modPengajuanKlaim=new BKPengajuanklaimpiutangT;
		$modPengajuanKlaimDetail = new BKPengajuanklaimdetailT;
		$modTandabukti = new TandabuktibayarT;
		$modPembayaranPelayanan = new PembayaranpelayananT;
		$modPendaftaran = new BKPendaftaranT;
		$modPasien = new BKPasienM;
		$format = new MyFormatter();

		$modPendaftaran->tgl_awal = date('Y-m-d');
		$modPendaftaran->tgl_akhir = date('Y-m-d');

		$modPengajuanKlaim->tglpengajuanklaimanklaim = date('Y-m-d H:i:s');
		$modPengajuanKlaim->tgljatuhtempo = date('Y-m-d H:i:s');
		$modPengajuanKlaim->nopengajuanklaimanklaim = MyGenerator::noPengajuanKlaim();

		$tr ='';
		$modDetails ='';
		
		if(isset($_GET['id'])){
			$modPengajuanKlaim = BKPengajuanklaimpiutangT::model()->findByPk($_GET['id']);
			$modPengajuanKlaimDetail = BKPengajuanklaimdetailT::model()->findByAttributes(array('pengajuanklaimpiutang_id'=>$_GET['id']));
	}
    
		if (isset($_POST['BKPengajuanklaimpiutangT'])) {
			$modPengajuanKlaim->attributes = $_POST['BKPengajuanklaimpiutangT'];
			$modPengajuanKlaim->carabayar_id = isset($_POST['BKPengajuanklaimdetailT'][1]['carabayar_id'])?$_POST['BKPengajuanklaimdetailT'][1]['carabayar_id']:null;
			$modPengajuanKlaim->penjamin_id= isset($_POST['BKPengajuanklaimdetailT'][1]['penjamin_id'])?$_POST['BKPengajuanklaimdetailT'][1]['penjamin_id']:null;
			if (count($_POST['BKPengajuanklaimpiutangT']) > 0) {
				$pembayaranpelayanan_id = $this->sortPilih($_POST['BKPengajuanklaimdetailT']);
				$modDetails = $this->validasiTabular($modPengajuanKlaim, $_POST['BKPengajuanklaimdetailT']);

			}
			$modPengajuanKlaim->tglpengajuanklaimanklaim = isset($_POST['BKPengajuanklaimpiutangT']['tglpengajuanklaimanklaim'])?  MyFormatter::formatDateTimeForDb($_POST['BKPengajuanklaimpiutangT']['tglpengajuanklaimanklaim']):null;
			if ($modPengajuanKlaim->validate()) {
				$transaction = Yii::app()->db->beginTransaction();
				try {
					$success = true;
					if ($modPengajuanKlaim->save()) {
						$modDetails = $this->validasiTabular($modPengajuanKlaim, $_POST['BKPengajuanklaimdetailT']);
						foreach ($modDetails as $i => $data) {
							if ($data->pembayaranpelayanan_id > 0) {
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
						$this->redirect(array('index', 'id' => $modPengajuanKlaim->pengajuanklaimpiutang_id));
					} else {
						$transaction->rollback();
						Yii::app()->user->setFlash('error', "Data gagal disimpan ");
					}
				} catch (Exception $ex) {
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ".$ex->getMessage());
				}
			} else {
				Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail pengajuan harus diisi.');
			}
		}

		 if ((isset($_GET['tgl_awal'])) && (isset($_GET['tgl_akhir'])) && (isset($_GET['carabayar_id'])) && (isset($_GET['penjamin_id']))) {
			if (Yii::app()->request->isAjaxRequest) {
				$tgl_awal  = $format->formatDateTimeForDb($_GET['tgl_awal']);
				$tgl_akhir = $format->formatDateTimeForDb($_GET['tgl_akhir']);
				$carabayar_id = $_GET['carabayar_id'];
				$penjamin_id = $_GET['penjamin_id'];
				$pengajuanklaimpiutang_id = isset($_GET['pengajuanklaimpiutang_id']) ? $_GET['pengajuanklaimpiutang_id'] :null;
				$tr = $this->createList($tgl_awal, $tgl_akhir, $carabayar_id, $penjamin_id, true);
				echo $tr;
				Yii::app()->end();
			}
		}

		$this->render($this->path_view.'index',array(
			'modPengajuanKlaim'=>$modPengajuanKlaim,
			'modPengajuanKlaimDetail'=>$modPengajuanKlaimDetail,
			'modPendaftaran'=>$modPendaftaran,
			'modPasien'=>$modPasien,
			'modPembayaranPelayanan'=>$modPembayaranPelayanan,
			'modTandabukti'=>$modTandabukti,
			'tr' => $tr,
			'modDetails'=>$modDetails,
			'format'=>$format,
		));
	}
    
	protected function rowPengeluaran($pengeluaran, $totaltransaksi, $tr, $text=null) {
		if (count($pengeluaran) > 0) {
			foreach ($pengeluaran as $i => $row) {
			   $i++;
			   $totaltransaksi = count($pengeluaran);
			   $jumlahPiutang = 0;
			   $biayapelayanan = 0;
				   if($row->carabayar->issubsidiasuransi == true || $row->carabayar->issubsidipemerintah == true || $row->carabayar->issubsidirs == true){
					   $jumlahPiutang += $row->totalsubsidiasuransi + $row->totalsubsidipemerintah + $row->totalsubsidirs;
				   }else if($row->carabayar->issubsidiasuransi == true){
					   $jumlahPiutang += $row->totalsubsidiasuransi;
				   }else if($row->carabayar->issubsidipemerintah == true){
					   $jumlahPiutang += $row->totalsubsidipemerintah ;
				   }else if($row->carabayar->issubsidirs == true){
					   $jumlahPiutang += $row->totalsubsidirs;
				   }
				$biayapelayanan += $row->totalbiayapelayanan;
				$tr .= '<tr >';
				$tr .= '<td>'.$i.'</td>';
				$tr .= '<td>' . $row->pasien->no_rekam_medik."<br/>".$row->pendaftaran->no_pendaftaran . '</td>';
				$tr .= '<td>' . $row->pasien->nama_pasien . '</td>';
				$tr .= '<td>' . $row->pasien->alamat_pasien . '</td>';
				$tr .= '<td>' . (isset($row->pendaftaran->penanggungJawab->nama_pj) ? $row->pendaftaran->penanggungJawab->nama_pj : "")."-".(isset($row->pendaftaran->penanggungJawab->pengantar) ? $row->pendaftaran->penanggungJawab->pengantar : "") . '</td>';
				$tr .= '<td>' . $row->nopembayaran . '</td>';
				if ($text == true){
					$tr .= '<td>'.number_format($row->totalbiayapelayanan).'</td>';
					$tr .= '<td>'.number_format($row->totalsisatagihan).'</td>';
					$tr .= '<td>'.number_format($row->uangditerima).'</td>';
					$tr .= '<td>'.number_format($row->totalbayartindakan).'</td>';
					$tr .= '<td>'.number_format($row->totalsisatagihan).'</td>';
				}else{
					$tr .= '<td>' . CHtml::textField('BKPengajuanklaimdetailT['.$i.'][jmltagihan]', number_format($row->totalbiayapelayanan), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmltagihan integer ', 'readonly' => false,'onkeyup'=>'hitungSemuaTransaksi()')) . '</td>';
					$tr .= '<td>' . CHtml::textField('BKPengajuanklaimdetailT['.$i.'][jmlbayar]', number_format($row->totalbayartindakan), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmltagihan integer ', 'readonly' => false,'onkeyup'=>'hitungSemuaTransaksi()')) . '</td>';
					$tr .= '<td>' . CHtml::textField('BKPengajuanklaimdetailT['.$i.'][jmlpiutang]', (empty($row->pembklaimdetal_id) ? number_format($jumlahPiutang) : number_format($row->detailklaim->jmlpiutang)), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmlpiutang integer ', 'onkeyup' => 'hitungJumlahPiutang(this);')) . 
									CHtml::hiddenField('BKPengajuanklaimdetailT['.$i.'][jmlpiutang2]', (empty($row->pembklaimdetal_id) ? number_format($row->totalsisatagihan) : number_format($row->detailklaim->jmlpiutang)), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmlpiutang2 integer')) .
						   '</td>';
//                        $tr .= '<td>' . CHtml::textField('BKPengajuanklaimdetailT['.$i.'][jmltelahbayar]', (empty($row->pembklaimdetal_id) ? (empty($row->detailklaim->telahbayar) ? "0" : number_format($row->tandabukti->jmlpembayaran)) : number_format($row->detailklaim->jmltelahbayar)), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmltelahbayar integer ', 'onkeyup' => 'hitungJumlahTelahBayar();')) . '</td>';
//                        $tr .= '<td>' . CHtml::textField('BKPengajuanklaimdetailT['.$i.'][jmlbayar]', (empty($row->pembklaimdetal_id) ? number_format($row->tandabukti->jmlpembayaran) : number_format($row->detailklaim->jmlpiutang - $row->detailklaim->jmltelahbayar) ), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmlbayar integer ', 'onkeyup' => 'hitungSisaTagihan();')) . '</td>';
					$tr .= '<td>' . CHtml::textField('BKPengajuanklaimdetailT['.$i.'][jmlsisatagihan]',(empty($row->pembklaimdetal_id) ? (empty($row->detailklaim->jmlsisapiutang) ? "0" : number_format($row->totalbiayapelayanan - $row->tandabukti->jmlpembayaran)) : number_format($row->detailklaim->jmlpiutang - ($row->detailklaim->jmltelahbayar + ($row->detailklaim->jmlpiutang - $row->detailklaim->jmltelahbayar)))) , array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmlsisatagihan integer ', 'onkeyup' => 'hitungSemuaTransaksi();')). '</td>';

					$tr .= '<td>' . CHtml::checkBox('BKPengajuanklaimdetailT['.$i.'][cekList]', true, array('value'=>$row->pembayaranpelayanan_id,'class' => 'cek', 'onClick' => 'setAll();')) .
									CHtml::hiddenField('BKPengajuanklaimdetailT['.$i.'][pendaftaran_id]', $row->pendaftaran_id, array('style'=>'width:70px;','class' => 'inputFormTabel integer span3 jmlsisatagihan',)).
									CHtml::hiddenField('BKPengajuanklaimdetailT['.$i.'][pasien_id]', $row->pasien_id, array('style'=>'width:70px;','class' => 'inputFormTabel integer span3 jmlsisatagihan',)).
									CHtml::hiddenField('BKPengajuanklaimdetailT['.$i.'][pembayaranpelayanan_id]', $row->pembayaranpelayanan_id, array('style'=>'width:70px;','class' => 'inputFormTabel  span3 ')).
									CHtml::hiddenField('BKPengajuanklaimdetailT['.$i.'][tandabuktibayar_id]', $row->tandabuktibayar_id, array('style'=>'width:70px;','class' => 'inputFormTabel  span3')).
									CHtml::hiddenField('BKPengajuanklaimdetailT['.$i.'][carabayar_id]', $row->carabayar_id, array('style'=>'width:70px;','class' => 'inputFormTabel  span3')).
									CHtml::hiddenField('BKPengajuanklaimdetailT['.$i.'][penjamin_id]', $row->penjamin_id, array('style'=>'width:70px;','class' => 'inputFormTabel  span3')).

						   '</td>';

				}
				$tr .= '</tr>';
			}
		}
		return $tr;
	}
    
	protected function createList($tgl_awal, $tgl_akhir, $carabayar_id, $penjamin_id,$status=null) {            
		$criteria = new CDbCriteria();
		if(!empty($carabayar_id)){
			$criteria->addCondition("t.carabayar_id = ".$carabayar_id);					
		}
		if(!empty($penjamin_id)){
			$criteria->addCondition("t.penjamin_id = ".$penjamin_id);					
		}
		$criteria->addBetweenCondition('DATE(t.tglpembayaran)', $tgl_awal, $tgl_akhir);

		if(!empty($this->pembklaimdetal_id)){
			$criteria->addCondition('detailklaim.jmlsisapiutang > 0');
		}

		$criteria->with=array('detailklaim');
		$criteria->join = 'LEFT JOIN pembklaimdetal_t ON pembklaimdetal_t.pembklaimdetal_id = t.pembklaimdetal_id';
		$pengeluaran = PembayaranpelayananT::model()->findAll($criteria);

		$tr = $this->rowPengeluaran($pengeluaran, isset($data['totaltransaksi']) ? $data['totaltransaksi'] : null, isset($data['tr']) ? $data['tr'] : null );

		return $tr;
	}
        
	protected function sortPilih($data){
		$result = array();
		foreach ($data as $i=>$row){
			if ($row['cekList'] == 1){
				$result[] = $row['pembayaranpelayanan_id'];
			}
		}

		return $result;
	}        
    
    protected function validasiTabular($modPengajuanKlaim, $data) {
        foreach ($data as $i => $row) {
            if($row['cekList'] == 1){
                
                $modDetails[$i] = new BKPengajuanklaimdetailT();
                $modDetails[$i]->attributes = $row;                
                $modDetails[$i]->pendaftaran_id = $row['pendaftaran_id'];
                $modDetails[$i]->pasien_id = $row['pasien_id'];
                $modDetails[$i]->pengajuanklaimpiutang_id = $modPengajuanKlaim->pengajuanklaimpiutang_id;
                $modDetails[$i]->pembayaranpelayanan_id = $row['pembayaranpelayanan_id'];
                $modDetails[$i]->tandabuktibayar_id = $row['tandabuktibayar_id'];
                $modDetails[$i]->jmlpiutang = $row['jmlpiutang']-$row['jmlbayar'];
                $modDetails[$i]->jumlahbayar = $row['jmlbayar'];
                $modDetails[$i]->jmltelahbayar = $row['jmlbayar'];
                $modDetails[$i]->jmlsisapiutang = $row['jmlsisatagihan'];
                $modDetails[$i]->validate();
            }
        }
        return $modDetails;
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
	
	/**
		* method untuk print tanda bukti pengajuan Klaim Piutang
		* @param int $pengajuanklaimpiutang_id pengajuanklaimpiutang_id
		*/
	   public function actionPrint($pengajuanklaimpiutang_id = null)
	   {
			$judulKuitansi = '----- PENGAJUAN KLAIM / PIUTANG -----';
			$format = new MyFormatter();
			$modPengajuanKlaim = BKPengajuanklaimpiutangT::model()->findByPk($pengajuanklaimpiutang_id);
			$modPengajuanKlaimDetail = BKPengajuanklaimdetailT::model()->findAllByAttributes(array('pengajuanklaimpiutang_id'=>$pengajuanklaimpiutang_id));

			if(!empty($modPengajuanKlaimDetail->pendaftaran_id)){
				$modPendaftaran = PendaftaranT::model()->findByPk($modPengajuanKlaimDetail->pendaftaran_id);
				$modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modPengajuanKlaimDetail->pendaftaran->tgl_pendaftaran);
			}else{
				$modPendaftaran = new PendaftaranT;
			}
			
			$caraPrint=$_REQUEST['caraPrint'];
			if($caraPrint=='PRINT') {
				$this->layout='//layouts/printWindows';
				$this->render($this->path_view.'print', array( 
									'modPendaftaran'=>$modPendaftaran, 
									'judulKuitansi'=>$judulKuitansi, 
									'caraPrint'=>$caraPrint, 
									'modPengajuanKlaim'=>$modPengajuanKlaim,
									'modPengajuanKlaimDetail'=>$modPengajuanKlaimDetail));
			}
			else if($caraPrint=='EXCEL') {
				$this->layout='//layouts/printExcel';
				$this->render($this->path_view.'print',array( 
									'modPendaftaran'=>$modPendaftaran, 
									'judulKuitansi'=>$judulKuitansi, 
									'caraPrint'=>$caraPrint, 
									'modPengajuanKlaim'=>$modPengajuanKlaim,
									'modPengajuanKlaimDetail'=>$modPengajuanKlaimDetail));
			}
			else if($_REQUEST['caraPrint']=='PDF') {
	//			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
	//            $ukuranKertasPDF = 'KW';                  //Ukuran Kertas Pdf
				$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
				//$mpdf = new MyPDF('',$ukuranKertasPDF); 
				//$mpdf = new MyPDF('','B5-L');
				$mpdf = new MyPDF('','','15', '', 15, 15, 16, 16, 9, 9, 'B5');                
				$mpdf->useOddEven = 2;  
				$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
				$mpdf->WriteHTML($stylesheet,1); 
				/*
				 * cara ambil margin
				 * tinggi_header * 72 / (72/25.4)
				 *  tinggi_header = inchi
				 */

				/*font-family: tahoma;*/
				// $header = 0.50 * 72 / (72/25.4);
				$header = 0.3 * 72 / (72/25.4);
				$mpdf->AddPage($posisi,'','','','',3,8,$header,5,0,0);
				$mpdf->WriteHTML(
					$this->renderPartial(
						$this->path_view.'print',
						array(
							'modPendaftaran'=>$modPendaftaran, 
							'judulKuitansi'=>$judulKuitansi, 
							'caraPrint'=>$caraPrint, 
							'modPengajuanKlaim'=>$modPengajuanKlaim,
							'modPengajuanKlaimDetail'=>$modPengajuanKlaimDetail
						),true
					)
				);
				$mpdf->Output();
			}                       
	   }

}
