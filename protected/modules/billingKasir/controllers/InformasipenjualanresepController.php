<?php

class InformasipenjualanresepController extends MyAuthController
{
        protected $pathViewPrint = 'farmasiApotek.views.penjualanResep.PrintBebasLuar';
        
        public function actionInformasijualresep(){
            $this->layout = '//layouts/column1';
            $model = new BKPenjualanresepT();
            $model->tgl_awal = date('d M Y');
            $model->tgl_akhir = date('d M Y');
            
            if (isset($_GET['BKPenjualanresepT'])){
                $format = new MyFormatter();
                $model->attributes = $_GET['BKPenjualanresepT'];
                $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
                $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
            }
            
            $this->render('informasijualresep',array('model'=>$model));
        }
        
        public function actionDetailResep($id){
            $this->layout = '//layouts/iframe';
            $modPenjualan = BKPenjualanresepT::model()->find('penjualanresep_id = ' . $id . '');
           $obatAlkes = BKObatalkesPasienT::model()->findAll('penjualanresep_id = ' . $modPenjualan->penjualanresep_id . ' ');
           $daftar = BKPendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$obatAlkes[0]->pendaftaran_id));
           $pasien = BKPasienM::model()->findByAttributes(array('pasien_id'=>$obatAlkes[0]->pasien_id));
           
            $judulLaporan='Laporan Penerimaan Kas';
                $this->render('PrintBebasLuar',array('modPenjualan'=>$modPenjualan, 'daftar'=>$daftar,'pasien'=>$pasien,'obatAlkes'=>$obatAlkes, 'judulLaporan'=>$judulLaporan));

        }
        /**
        * actionFakturPembayaranApotek digunakan untuk print faktur kasir apotek bebas / resep luar / pegawai / dokter / unit
        * @param type $penjualanresep_id
        * @param type $tandabuktibayar_id
        */
        public function actionFakturPembayaranApotek($penjualanresep_id, $tandabuktibayar_id = null, $caraPrint=null){
            $this->layout = '//layouts/iframe';
            $modPenjualan = PenjualanresepT::model()->findByPk($penjualanresep_id);
            $daftar = PendaftaranT::model()->findByAttributes(array('pendaftaran_id'=>$modPenjualan->pendaftaran_id));
            $obatAlkes = ObatalkespasienT::model()->findAllByAttributes(array('penjualanresep_id'=>$penjualanresep_id));
            $pasien = PasienM::model()->findByPk($modPenjualan->pasien_id);
            $modPegawaiDokter = new PegawaikaryawanV();
            $modInstalasi = new InstalasiM();
            if(!empty($modPenjualan->pasienpegawai_id))
                $modPegawaiDokter = PegawaikaryawanV::model()->findByAttributes(array('pegawai_id'=>$modPenjualan->pasienpegawai_id));
            if(!empty($modPenjualan->pasieninstalasiunit_id))
                $modInstalasi = InstalasiM::model()->findByAttributes(array('instalasi_id'=>$modPenjualan->pasieninstalasiunit_id));
            $criteria = new CDbCriteria;
			if(!empty($tandabuktibayar_id)){
				$criteria->addCondition("t.tandabuktibayar_id = ".$tandabuktibayar_id);					
			}
            $tandabukti = TandabuktibayarT::model()->with('pembayaran')->find($criteria);
            $judulLaporan='Sale Invoice';
    //        $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                 $this->layout='//layouts/printWindows';
            }
            $this->render('fakturPembayaranApotek',array('modPenjualan'=>$modPenjualan, 'daftar'=>$daftar,'pasien'=>$pasien,'modPegawaiDokter'=>$modPegawaiDokter,'modInstalasi'=>$modInstalasi,'obatAlkes'=>$obatAlkes, 'tandabukti'=>$tandabukti,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
         }
        /**
         * actionBuktiKasMasukFarmasi cetak BKM (Bukti Kas Masuk) Farmasi
         * @param type $penjualanresep_id
         * @param type $tandabuktibayar_id
         */
        public function actionBuktiKasMasukFarmasi($penjualanresep_id,$tandabuktibayar_id, $caraPrint = null) {
            if (!empty($tandabuktibayar_id) && !empty($penjualanresep_id)) {
                $this->layout='//layouts/iframe';
                $format = new MyFormatter();
                if($caraPrint == "PRINT"){
                    $this->layout='//layouts/printWindows';
                }
                $criteria = new CDbCriteria;
				if(!empty($tandabuktibayar_id)){
					$criteria->addCondition("t.tandabuktibayar_id = ".$tandabuktibayar_id);					
				}
                $modPenjualan = PenjualanresepT::model()->findByPk($penjualanresep_id);
                $model = TandabuktibayarT::model()->with('pembayaran')->find($criteria);
                $modObatalkes = ObatalkespasienT::model()->findAllByAttributes(array('penjualanresep_id'=>$penjualanresep_id));
                $rincianTagihan = BKInformasipenjualanaresepV::model()->findAllByAttributes
                        (array('pasien_id'=>$model->pembayaran->pasien_id,
                        'penjualanresep_id'=>$penjualanresep_id));
                $modPegawai = PegawaikaryawanV::model()->findByAttributes(array('pegawai_id'=>$modPenjualan->pasienpegawai_id));
                $modInstalasi = InstalasiM::model()->findByAttributes(array('instalasi_id'=>$modPenjualan->pasieninstalasiunit_id));
                $judulLaporan = 'Tanda Bukti Pembayaran Apotek';
                $this->render('buktiKasMasukFarmasi', array(
                    'model' => $model,
                    'judulLaporan'=> $judulLaporan,
                    'rincianTagihan'=>$rincianTagihan,
                    'modObatalkes'=>$modObatalkes,
                    'modPenjualan'=>$modPenjualan,
                    'modPegawai'=>$modPegawai,
                    'modInstalasi'=>$modInstalasi,
                    'format'=>$format,
                ));
            }
        }
        
}