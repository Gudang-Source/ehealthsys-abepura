<?php
class PembayaranKlaimPiutangController extends MyAuthController
{
	public $layout='//layouts/column1';
	public $defaultAction = 'Index';
	public $path_view = 'billingKasir.views.pembayaranKlaimPiutang.';
	public $path_view_bk = 'billingKasir.views.';
        
	public function actionIndex()
	{
            $this->pageTitle = Yii::app()->name.' - '.'Transaksi Pembayaran Klaim / Piutang';
            
            $modPembayaranKlaim=new BKPembayaranklaimT;
            $modPembayaranKlaimDetail = new BKPembayarklaimdetailT;
            $modTandabukti = new TandabuktibayarT;
            $modPembayaranPelayanan = new PembayaranpelayananT;
            $modPendaftaran = new BKPendaftaranT;
            $modPasien = new BKPasienM;
            $format = new MyFormatter();
            $modPendaftaran->tgl_awal = date('Y-m-d');
            $modPendaftaran->tgl_akhir = date('Y-m-d');
            $modPengajuanKlaim = new BKPengajuanklaimpiutangT();
            $modPembayaranKlaim->tglpembayaranklaim = MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s'));
            $modPembayaranKlaim->nopembayaranklaim ="Otomatis";

            $tr ='';
            $modDetails ='';
            
            // $modTandabukti = '';
			$id = isset($_GET['id']) ? $_GET['id'] : null;
			if(isset($_GET['id'])){
				$modPembayaranKlaim = BKPembayaranklaimT::model()->findByPk($id);
			}
            
            if (isset($_POST['BKPembayaranklaimT'])) {
                // var_dump($_POST);
                $modPembayaranKlaim->attributes = $_POST['BKPembayaranklaimT'];
		$modPembayaranKlaim->nopembayaranklaim = MyGenerator::noPembayaranKlaim();
                $modPembayaranKlaim->carabayar_id = Params::CARABAYAR_ID_MEMBAYAR;
                $modPembayaranKlaim->penjamin_id= Params::PENJAMIN_ID_UMUM;
                if (count($_POST['BKPembayarklaimdetailT']) > 0) {
                    $pembayaranpelayanan_id = $this->sortPilih($_POST['BKPembayarklaimdetailT']);
                    $modDetails = $this->validasiTabular($modPembayaranKlaim, $_POST['BKPembayarklaimdetailT']);
                    $modPembayaranKlaim->carabayar_id = $_POST['BKPembayarklaimdetailT'][1]['carabayar_id'];
                    $modPembayaranKlaim->penjamin_id = $_POST['BKPembayarklaimdetailT'][1]['penjamin_id'];
                }
				$modPembayaranKlaim->tglpembayaranklaim = MyFormatter::formatDateTimeForDb($modPembayaranKlaim->tglpembayaranklaim);
                // var_dump($modPembayaranKlaim->attributes); die;
                    if ($modPembayaranKlaim->validate()) {
                        $transaction = Yii::app()->db->beginTransaction();
                        try {
                            $success = true;
                            if ($modPembayaranKlaim->save()) {
                                    $modDetails = $this->validasiTabular($modPembayaranKlaim, $_POST['BKPembayarklaimdetailT']);
                                    foreach ($modDetails as $i => $data) {
                                        if ($data->pembayaranpelayanan_id > 0) {
                                            if ($data->save()) {
                                                     PembayaranpelayananT::model()->updateByPk($data->pembayaranpelayanan_id, array('pembklaimdetal_id'=>$data->pembklaimdetal_id));
                                                
                                            } else {
                                                $success = false;
                                            }
                                        }
                                    }
                            }
							
							// var_dump($success); die;
							
                            if ($success == true) {
                                $transaction->commit();
                                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                                $this->redirect(array('index', 'id' => $modPembayaranKlaim->pembayarklaim_id));
                            } else {
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error', "Data gagal disimpan ");
                            }
                        } catch (Exception $ex) {
                            $transaction->rollback();
							// var_dump($ex); die;
                            Yii::app()->user->setFlash('error', "Data gagal disimpan ".$ex->getMessage());
                        }
                } else {
                    Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data detail barang harus diisi.');
                }
            }
                
             if ((isset($_GET['tgl_awal'])) && (isset($_GET['tgl_akhir'])) && (isset($_GET['carabayar_id'])) && (isset($_GET['penjamin_id'])) && (isset($_GET['pengajuanklaimpiutang_id']))) {
                if (Yii::app()->request->isAjaxRequest) {
                    $tgl_awal  = $format->formatDateTimeForDb($_GET['tgl_awal']);
                    $tgl_akhir = $format->formatDateTimeForDb($_GET['tgl_akhir']);
                    $pengajuanklaimpiutang_id = isset($_GET['pengajuanklaimpiutang_id']) ? $_GET['pengajuanklaimpiutang_id'] : null;
                    $carabayar_id = isset($_GET['carabayar_id']) ? $_GET['carabayar_id'] : null;
                    $penjamin_id = isset($_GET['penjamin_id']) ? $_GET['penjamin_id'] : null;
                    $pembklaimdetal_id = isset($_GET['pembklaimdetal_id']) ? $_GET['pembklaimdetal_id'] :null;
                    $tr = $this->createList($tgl_awal, $tgl_akhir, $pengajuanklaimpiutang_id, $carabayar_id, $penjamin_id, true);
                    echo $tr;
                    Yii::app()->end();
                }
            }
            
			if(isset($_GET['pengajuanklaim_id'])){
				$pengajuanklaimpiutang_id = $_GET['pengajuanklaim_id'];
				$modPengajuanKlaim = $modPengajuanKlaim->findByPk($pengajuanklaimpiutang_id);
				$modPendaftaran->carabayar_id = $modPengajuanKlaim->carabayar_id;
				$modPendaftaran->penjamin_id = $modPengajuanKlaim->penjamin_id;
				$tr = $this->createList(null, null, $_GET['pengajuanklaim_id'], null, null, true);
			}
			
            $this->render($this->path_view.'index',array(
                    'modPembayaranKlaim'=>$modPembayaranKlaim,
                    'modPembayaranKlaimDetail'=>$modPembayaranKlaimDetail,
                    'modPendaftaran'=>$modPendaftaran,
                    'modPasien'=>$modPasien,
                    'modPembayaranPelayanan'=>$modPembayaranPelayanan,
                    'modTandabukti'=>$modTandabukti,
                    'tr' => $tr,
                    'modDetails'=>$modDetails,
                    'format'=>$format,
					'modPengajuanKlaim'=>$modPengajuanKlaim,
//                    'pembayaran'=>$pembayaran,
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
                    $tr .= '<td>' . $row->pasien->nama_pasien . 
									CHtml::hiddenField('BKPembayarklaimdetailT['.$i.'][pasien_id]', $row->pasien_id, array('style'=>'width:70px;','class' => 'inputFormTabel  span3')) .
							'</td>';
                    $tr .= '<td>' . $row->pasien->alamat_pasien . '</td>';
                    $tr .= '<td>' . (isset($row->pendaftaran->penanggungJawab->nama_pj) ? $row->pendaftaran->penanggungJawab->nama_pj : "")."-".(isset($row->pendaftaran->penanggungJawab->pengantar) ? $row->pendaftaran->penanggungJawab->pengantar : "") . '</td>';
                    $tr .= '<td>' . $row->nopembayaran . '</td>';
                    if ($text == true){
                        $tr .= '<td>'.MyFormatter::formatNumberForPrint($row->totalbiayapelayanan).'</td>';
                        $tr .= '<td>'.MyFormatter::formatNumberForPrint($row->totalsisatagihan).'</td>';
                        $tr .= '<td>'.MyFormatter::formatNumberForPrint($row->uangditerima).'</td>';
                        $tr .= '<td>'.MyFormatter::formatNumberForPrint($row->totalbayartindakan).'</td>';
                        $tr .= '<td>'.MyFormatter::formatNumberForPrint($row->totalsisatagihan).'</td>';
                    }else{
                        $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT['.$i.'][jmltagihan]', MyFormatter::formatNumberForPrint($row->totalbiayapelayanan), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmltagihan integer2 ', 'readonly' => false,'onkeyup'=>'hitungSemuaTransaksi()', 'readonly'=>true)) . '</td>';
                        $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT['.$i.'][jmlpiutang]', (empty($row->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($jumlahPiutang) : MyFormatter::formatNumberForPrint($row->detailklaim->jmlpiutang)), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmlpiutang integer2 ', 'onkeyup' => 'hitungJumlahPiutang(this);', 'readonly'=>true)) . 
                                        CHtml::hiddenField('BKPembayarklaimdetailT['.$i.'][jmlpiutang2]', (empty($row->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($row->totalsisatagihan) : MyFormatter::formatNumberForPrint($row->detailklaim->jmlpiutang)), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmlpiutang2 integer2')) .
                               '</td>';
                        $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT['.$i.'][jmltelahbayar]', (empty($row->pembklaimdetal_id) ? (empty($row->detailklaim->telahbayar) ? "0" : MyFormatter::formatNumberForPrint($row->tandabukti->jmlpembayaran)) : MyFormatter::formatNumberForPrint($row->detailklaim->jmltelahbayar)), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmltelahbayar integer2 ', 'onkeyup' => 'hitungJumlahTelahBayar();', 'readonly'=>true)) . '</td>';
                        $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT['.$i.'][jmlbayar]', (empty($row->pembklaimdetal_id) ? MyFormatter::formatNumberForPrint($row->tandabukti->jmlpembayaran) : MyFormatter::formatNumberForPrint($row->detailklaim->jmlpiutang - $row->detailklaim->jmltelahbayar) ), array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmlbayar integer2 ', 'onblur' => 'hitungSisaTagihan();')) . '</td>';
                        $tr .= '<td>' . CHtml::textField('BKPembayarklaimdetailT['.$i.'][jmlsisatagihan]',(empty($row->pembklaimdetal_id) ? (empty($row->detailklaim->jmlsisapiutang) ? "0" : MyFormatter::formatNumberForPrint($row->totalbiayapelayanan - $row->tandabukti->jmlpembayaran)) : MyFormatter::formatNumberForPrint($row->detailklaim->jmlpiutang - ($row->detailklaim->jmltelahbayar + ($row->detailklaim->jmlpiutang - $row->detailklaim->jmltelahbayar)))) , array('style'=>'width:70px;','class' => 'inputFormTabel span3 jmlsisatagihan integer2 ', 'onkeyup' => 'hitungSemuaTransaksi();')). '</td>';

                        $tr .= '<td>' . CHtml::checkBox('BKPembayarklaimdetailT['.$i.'][cekList]', true, array('value'=>$row->pembayaranpelayanan_id,'class' => 'cek', 'onClick' => 'setAll();')) .
                                        CHtml::hiddenField('BKPembayarklaimdetailT['.$i.'][pendaftaran_id]', $row->pendaftaran_id, array('style'=>'width:70px;','class' => 'inputFormTabel integer2 span3 jmlsisatagihan',)).
                                        CHtml::hiddenField('BKPembayarklaimdetailT['.$i.'][pembayaranpelayanan_id]', $row->pembayaranpelayanan_id, array('style'=>'width:70px;','class' => 'inputFormTabel  span3 ')).
                                        CHtml::hiddenField('BKPembayarklaimdetailT['.$i.'][tandabuktibayar_id]', $row->tandabuktibayar_id, array('style'=>'width:70px;','class' => 'inputFormTabel  span3')).
                                        CHtml::hiddenField('BKPembayarklaimdetailT['.$i.'][carabayar_id]', $row->carabayar_id, array('style'=>'width:70px;','class' => 'inputFormTabel  span3')).
                                        CHtml::hiddenField('BKPembayarklaimdetailT['.$i.'][penjamin_id]', $row->penjamin_id, array('style'=>'width:70px;','class' => 'inputFormTabel  span3')).
                                        
                               '</td>';

                    }
                    $tr .= '</tr>';
                }
            }
            return $tr;
        }
    
        protected function createList($tgl_awal, $tgl_akhir, $pengajuanklaimpiutang_id, $carabayar_id, $penjamin_id,$status=null) {            
            $criteria = new CDbCriteria();
			
			if(!empty($pengajuanklaimpiutang_id)){
				$criteria->addCondition("pengajuanklaimdetail_t.pengajuanklaimpiutang_id = ".$pengajuanklaimpiutang_id);					
			}
//			if(!empty($carabayar_id)){
//				$criteria->addCondition("carabayar_m.carabayar_id = ".$carabayar_id);					
//			}
//			if(!empty($penjamin_id)){
//				$criteria->addCondition("penjaminpasien_m.penjamin_id = ".$penjamin_id);					
//			}
//			if(!empty($pengajuanklaimpiutang_id)){
//				$criteria->addCondition("pengajuanklaimpiutang_t.pengajuanklaimpiutang_id = ".$pengajuanklaimpiutang_id);
//			}
//            $criteria->addBetweenCondition('DATE(t.tglpembayaran)', $tgl_awal, $tgl_akhir);
//            $criteria->addCondition('pembklaimdetal_t.pembklaimdetal_id is NOT NULL');
//            if(!empty($this->pembklaimdetal_id)){
//                $criteria->addCondition('detailklaim.jmlsisapiutang > 0');
//            }
              
			$criteria->with=array('detailklaim');
            $criteria->join = 'join carabayar_m on carabayar_m.carabayar_id = t.carabayar_id
								join penjaminpasien_m on penjaminpasien_m.carabayar_id = carabayar_m.carabayar_id
								join pengajuanklaimdetail_t on t.pembayaranpelayanan_id = pengajuanklaimdetail_t.pembayaranpelayanan_id
								';
			
			
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
        
    
    protected function validasiTabular($modPembayaranKlaim, $data) {
        foreach ($data as $i => $row) {
            if($row['cekList'] == 1){
                
                $modDetails[$i] = new BKPembayarklaimdetailT();
                $modDetails[$i]->attributes = $row;                
                $modDetails[$i]->pendaftaran_id = $row['pendaftaran_id'];
//                $modDetails[$i]->pasien_id = $row['pasien_id'];
                $modDetails[$i]->pembayarklaim_id = $modPembayaranKlaim->pembayarklaim_id;
                $modDetails[$i]->pembayaranpelayanan_id = $row['pembayaranpelayanan_id'];
                $modDetails[$i]->tandabuktibayar_id = $row['tandabuktibayar_id'];
                $modDetails[$i]->jmlpiutang = $row['jmlpiutang']-$row['jmlbayar'];
                $modDetails[$i]->jumlahbayar = $row['jmlbayar'];
                $modDetails[$i]->jmltelahbayar = $row['jmlbayar'];
                $modDetails[$i]->jmlsisapiutang = $row['jmlsisatagihan'];
                $modDetails[$i]->validate();
            }
            
//            echo '<pre>';
//            echo print_r($modDetails[$i]->getErrors());
//            echo '</pre>';
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
		* method untuk print tanda bukti pembayaran Klaim Piutang
		* @param int $pembayaranklaim_id pembayaranklaim_id
		*/
	   public function actionPrint($pembayarklaim_id = null)
	   {
			$judulKuitansi = '----- PEMBAYARAN KLAIM / PIUTANG -----';
			$format = new MyFormatter();
			$modPembayaranKlaim = BKPembayaranklaimT::model()->findByPk($pembayarklaim_id);
			$modPembayaranKlaimDetail = BKPembayarklaimdetailT::model()->findAllByAttributes(array('pembayarklaim_id'=>$pembayarklaim_id));

			if(!empty($modPembayaranKlaimDetail->pendaftaran_id)){
				$modPendaftaran = PendaftaranT::model()->findByPk($modPembayaranKlaimDetail->pendaftaran_id);
				$modPendaftaran->tgl_pendaftaran = $format->formatDateTimeForDb($modPembayaranKlaimDetail->pendaftaran->tgl_pendaftaran);
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
									'modPembayaranKlaim'=>$modPembayaranKlaim,
									'modPembayaranKlaimDetail'=>$modPembayaranKlaimDetail));
			}
			else if($caraPrint=='EXCEL') {
				$this->layout='//layouts/printExcel';
				$this->render($this->path_view.'print',array( 
									'modPendaftaran'=>$modPendaftaran, 
									'judulKuitansi'=>$judulKuitansi, 
									'caraPrint'=>$caraPrint, 
									'modPembayaranKlaim'=>$modPembayaranKlaim,
									'modPembayaranKlaimDetail'=>$modPembayaranKlaimDetail));
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
							'modPembayaranKlaim'=>$modPembayaranKlaim,
							'modPembayaranKlaimDetail'=>$modPembayaranKlaimDetail
						),true
					)
				);
				$mpdf->Output();
			}                       
	   }

}
