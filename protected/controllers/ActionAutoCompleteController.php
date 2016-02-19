<?php
/**
 * RND-7811 : INI SUDAH TIDAK DIGUNAKAN LAGI, FUNCTION PINDAHKAN KE CONTROLLER MASING2
 */
class ActionAutoCompleteController extends Controller
{
        public function actionTindakan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'daftartindakan_nama';
                $criteria->limit = 10;
                $models = TariftindakanperdatotalV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->daftartindakan_nama;
                    $returnVal[$i]['value'] = $model->daftartindakan_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
       
        public function actionTindakanPeriksaLab()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
//                $criteria->compare('LOWER(kategoritindakan_nama)', strtolower($_GET['kategoritindakan_nama']), true);
                $criteria->addCondition('pemeriksaanlab_id IS NULL');
                $criteria->order = 'daftartindakan_nama';
                $criteria->limit = 10;
                $models = PemeriksaanlabtindV::model()->findAll($criteria);
                $returnVal = array();
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->daftartindakan_nama.' - '.$model->kelompoktindakan_nama;
                    $returnVal[$i]['value'] = $model->daftartindakan_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionSearchPeriksaLabIsNotNull()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->select = array('pemeriksaanlab_id','pemeriksaanlab_nama','kelompoktindakan_nama');
                $criteria->distinct = true;
                $criteria->compare('LOWER(pemeriksaanlab_nama)', strtolower($_GET['term']), true);
                $criteria->addCondition('pemeriksaanlab_id IS NOT NULL');
                $criteria->order = 'pemeriksaanlab_nama';
                $criteria->limit = 10;
                $models = PemeriksaanlabtindV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->pemeriksaanlab_nama.' - '.$model->kelompoktindakan_nama;
                    $returnVal[$i]['value'] = $model->pemeriksaanlab_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        public function actionAgama()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(agama_nama)', strtolower($_GET['term']), true);
                $models = AgamaM::model()->findAll($criteria);
                foreach($models as $model)
                {
                   $returnVal[] = array(    
                      'label'=>$model->agama_nama,
                      'value'=>$model->agama_nama,
                      'agama_id'=>$model->agama_id,
                      'agama_namalainnya'=>$model->agama_namalainnya,
                   );
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionPropinsi()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(propinsi_nama)', strtolower($_GET['term']), true);
                $models = PropinsiM::model()->findAll($criteria);
                foreach($models as $model)
                {
                   $returnVal[] = array(    
                      'label'=>$model->propinsi_nama,
                      'value'=>$model->propinsi_nama,
                      'propinsi_id'=>$model->propinsi_id,
                      'propinsi_namalainnya'=>$model->propinsi_namalainnya,
                   );
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        /**
         * actionObatAlkes digunakan di:
         * - Transaksi Mutasi Obat Alkes (inventori)
         */
        public function actionObatAlkes()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'obatalkes_nama';
                $criteria->addCondition('obatalkes_farmasi is true');
                $criteria->addCondition('obatalkes_aktif is true');
                $criteria->limit=5;
                $models = ObatalkesM::model()->findAll($criteria);
                $idRuangan = Yii::app()->user->getState('ruangan_id');
                foreach($models as $i=>$model)
                {
                    $stokObat = StokobatalkesT::getJumlahStok($model->obatalkes_id, $idRuangan);
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->obatalkes_kode.' - '.$model->obatalkes_nama.' Jumlah Stok '.$stokObat;;
                    $returnVal[$i]['value'] = $model->obatalkes_kode.' - '.$model->obatalkes_nama;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        /**
         * digunakan di : transaksi pemesanan obat alkes
         */
        public function actionObatAlkesPemesanan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'obatalkes_nama';
                $criteria->addCondition('obatalkes_farmasi is true');
                $criteria->addCondition('obatalkes_aktif is true');
                $criteria->limit=5;
                $models = ObatalkesM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $stokObat = StokobatalkesT::getJumlahStok($model->obatalkes_id, $_GET['idRuangan']);
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->obatalkes_kode.' - '.$model->obatalkes_nama.' Jumlah Stok '.$stokObat;
                    $returnVal[$i]['value'] = $model->obatalkes_kode.' - '.$model->obatalkes_nama;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        /**
         * action autocomplite ObatAlkesPenawaran 
         * digunakan di
         * GF permintaan penawaran INDEX
         */
        public function actionObatAlkesPenawaran()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->with = array('obatalkes');
                if(!empty($_GET['idSupplier'])){
                    $idSupplier = $_GET['idSupplier'];
                    $criteria->compare('supplier_id',$idSupplier);
                }
                $criteria->compare('LOWER(obatalkes.obatalkes_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'obatalkes.obatalkes_nama';
                $criteria->addCondition('obatalkes.obatalkes_farmasi is true');
                $criteria->addCondition('obatalkes.obatalkes_aktif is true');
                $criteria->limit=5;
                $models = ObatsupplierM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->obatalkes->obatalkes_kode.' - '.$model->obatalkes->obatalkes_nama;
                    $returnVal[$i]['value'] = $model->obatalkes->obatalkes_nama;
                    $returnVal[$i]['sumberdana_nama'] = $model->obatalkes->sumberdana->sumberdana_nama;
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        /**
         * action autocomplite ObatAlkesSupplier 
         * digunakan di
         * GF permintaan pembelian INDEX
         */
        public function actionObatAlkesSupplier()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->with = array('obatalkes');
                $idSupplier = ((!empty($_GET['idSupplier'])) ? $_GET['idSupplier'] : 0);
                $criteria->compare('supplier_id',$idSupplier);
                $criteria->compare('LOWER(obatalkes.obatalkes_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'obatalkes.obatalkes_nama';
                $criteria->addCondition('obatalkes.obatalkes_farmasi is true');
                $criteria->limit=5;
                $models = ObatsupplierM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->obatalkes->obatalkes_kode.' - '.$model->obatalkes->obatalkes_nama;
                    $returnVal[$i]['value'] = $model->obatalkes->obatalkes_nama;
                    $returnVal[$i]['sumberdana_nama'] = $model->obatalkes->sumberdana->sumberdana_nama;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        //-- SistemAdministrator -- 
        //Get Daftar Obat dengan Sumber Dana Paket BMHP
        public function actionObatAlkesWithSumberDana()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->with = array('sumberdana');
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'obatalkes_nama';
                $criteria->limit=5;
                $models = ObatalkesM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->obatalkes_nama.' - '.$model->sumberdana->sumberdana_nama;
                    $returnVal[$i]['value'] = $model->obatalkes_nama;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        
        public function actionNoPermintaanPembelian()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nopermintaan)', strtolower($_GET['term']), true);
                $criteria->order = 'nopermintaan';
                $criteria->limit=10;
                $models = PermintaanpembelianT::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nopermintaan;
                    $returnVal[$i]['value'] = $model->nopermintaan;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}public function actionNoPenerimaanBarang()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(noterima)', strtolower($_GET['term']), true);
                $criteria->order = 'noterima';
                $criteria->limit=10;
                $models = PenerimaanbarangT::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->noterima;
                    $returnVal[$i]['value'] = $model->noterima;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionNoSuratPenawaran()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nosuratpenawaran)', strtolower($_GET['term']), true);
                $criteria->order = 'nosuratpenawaran';
                $criteria->limit=10;
                $models = PermintaanpenawaranT::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nosuratpenawaran;
                    $returnVal[$i]['value'] = $model->nosuratpenawaran;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionNoPerencanaan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(noperencnaan)', strtolower($_GET['term']), true);
                $criteria->order = 'noperencnaan';
                $criteria->limit=10;
                $models = RencanakebfarmasiT::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->noperencnaan;
                    $returnVal[$i]['value'] = $model->noperencnaan;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionPasienRawatInap()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                $criteria->compare('ruangan_id',Yii::app()->user->getState('ruangan_id'));
                
                $criteria->order = 'no_rekam_medik';
                $criteria->limit=10;
                $models = PasienrawatinapV::model()->findAll($criteria);
                $returnVal = array();
                if (count($models) > 0){
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        $diagnosa = PasienmorbiditasT::model()->with('diagnosa')->findByAttributes(array('ruangan_id'=> Yii::app()->user->getState('ruangan_id'),'pasien_id'=>$model->pasien_id, 'kelompokdiagnosa_id'=> Params::KELOMPOKDIAGNOSA_UTAMA));
                        if (count($diagnosa) <= 0 ){
                            $diagnosa = PasienmorbiditasT::model()->with('diagnosa')->findByAttributes(array('ruangan_id'=> Yii::app()->user->getState('ruangan_id'),'pasien_id'=>$model->pasien_id));
                        }
                        $anamnesa = AnamnesaT::model()->findAllByAttributes(array('pasien_id'=>$model->pasien_id), array('order'=>'tglanamnesis DESC', 'limit'=>1));
                        $keluhanutama = null;
                        $keluhantambahan = null;
                        $riwayatpenyakitterdahulu = null;
                        $riwayatpenyakitkeluarga = null;
                        if (count($anamnesa) > 0){
                            foreach($anamnesa as $anamnesa){
                                $keluhanutama = $anamnesa->keluhanutama;
                                $keluhantambahan = $anamnesa->keluhantambahan;
                                $riwayatpenyakitterdahulu = $anamnesa->riwayatpenyakitterdahulu;
                                $riwayatpenyakitkeluarga = $anamnesa->riwayatpenyakitkeluarga;
                            }
                        }
                        $periksaFisik = PemeriksaanfisikT::model()->with('pegawai')->findAllByAttributes(array('pasien_id'=>$model->pasien_id), array('order'=>'tglperiksafisik DESC', 'limit'=>1));
                        if (count($periksaFisik) > 0) {
                            foreach($periksaFisik as $periksaFisik){
                                $tekanandarah = $periksaFisik->tekanandarah;
                                $detaknadi = $periksaFisik->detaknadi;
                                $suhutubuh = $periksaFisik->suhutubuh;
                                $beratbadan = $periksaFisik->beratbadan_kg;
                                $tinggibadan = $periksaFisik->tinggibadan_cm;
                                $pernapasan = $periksaFisik->pernapasan;
                                $pegawai = $periksaFisik->pegawai->nama_pegawai;
                                $kelainanpadabagtubuh = $periksaFisik->kelainanpadabagtubuh;
                                $meanarteripressure = $periksaFisik->meanarteripressure;
                                $gcs_eye = $periksaFisik->gcs_eye;
                                $gcs_motorik = $periksaFisik->gcs_motorik;
                                $gcs_verbal = $periksaFisik->gcs_verbal;
                            }
                        }
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien.' - '.$model->jeniskelamin;
                        $returnVal[$i]['value'] = $model->no_rekam_medik;
                        $returnVal[$i]["diagnosa"] = ((isset($diagnosa->diagnosa)) ? $diagnosa->diagnosa->diagnosa_nama : null);
                        $returnVal[$i]["diagnosa_id"] = ((isset($diagnosa->diagnosa_id)) ? $diagnosa->diagnosa_id : null);
                        $returnVal[$i]["keluhanutama"] = $keluhanutama;
                        $returnVal[$i]["keluhantambahan"] = $keluhantambahan;
                        $returnVal[$i]["riwayatpenyakitterdahulu"] = $riwayatpenyakitterdahulu;
                        $returnVal[$i]["riwayatpenyakitkeluarga"] = $riwayatpenyakitkeluarga;
                        $returnVal[$i]["tekanandarah"] = $tekanandarah;
                        $returnVal[$i]["pegawai"] = $pegawai;
                        $returnVal[$i]["detaknadi"] = $detaknadi;
                        $returnVal[$i]["suhutubuh"] = $suhutubuh;
                        $returnVal[$i]["tinggibadan"] = $tinggibadan;
                        $returnVal[$i]["beratbadan"] = $beratbadan;
                        $returnVal[$i]["pernapasan"] = $pernapasan;
                        $returnVal[$i]["kelainanpadabagtubuh"] = $kelainanpadabagtubuh;
                        $returnVal[$i]["meanarteripressure"] = $meanarteripressure;
                        $returnVal[$i]["gcs"] = $gcs_eye+$gcs_motorik+$gcs_verbal;
                        $returnVal[$i]["usia"] = substr($model->umur, 0, 2);
                    }
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionPasienRawatInapBerdasarkanRuangan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'no_rekam_medik';
                $criteria->limit=10;
                $models = PasienrawatinapV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    $diagnosa = PasienmorbiditasT::model()->with('diagnosa')->findByAttributes(array('ruangan_id'=> Yii::app()->user->getState('ruangan_id'),'pasien_id'=>$model->pasien_id, 'kelompokdiagnosa_id'=> Params::KELOMPOKDIAGNOSA_UTAMA));
                    if (count($diagnosa) <= 0 ){
                        $diagnosa = PasienmorbiditasT::model()->with('diagnosa')->findByAttributes(array('ruangan_id'=> Yii::app()->user->getState('ruangan_id'),'pasien_id'=>$model->pasien_id));
                    }
                    $anamnesa = AnamnesaT::model()->findAllByAttributes(array('pasien_id'=>$model->pasien_id), array('order'=>'tglanamnesis DESC', 'limit'=>1));
                    foreach($anamnesa as $anamnesa){
                        $keluhanutama = $anamnesa->keluhanutama;
                        $keluhantambahan = $anamnesa->keluhantambahan;
                        $riwayatpenyakitterdahulu = $anamnesa->riwayatpenyakitterdahulu;
                        $riwayatpenyakitkeluarga = $anamnesa->riwayatpenyakitkeluarga;
                    }
                    $periksaFisik = PemeriksaanfisikT::model()->with('pegawai')->findAllByAttributes(array('pasien_id'=>$model->pasien_id), array('order'=>'tglperiksafisik DESC', 'limit'=>1));
                    foreach($periksaFisik as $periksaFisik){
                        $tekanandarah = $periksaFisik->tekanandarah;
                        $detaknadi = $periksaFisik->detaknadi;
                        $suhutubuh = $periksaFisik->suhutubuh;
                        $beratbadan = $periksaFisik->beratbadan_kg;
                        $tinggibadan = $periksaFisik->tinggibadan_cm;
                        $pernapasan = $periksaFisik->pernapasan;
                        $pegawai = $periksaFisik->pegawai->nama_pegawai;
                        $kelainanpadabagtubuh = $periksaFisik->kelainanpadabagtubuh;
                        $meanarteripressure = $periksaFisik->meanarteripressure;
                        $gcs_eye = $periksaFisik->gcs_eye;
                        $gcs_motorik = $periksaFisik->gcs_motorik;
                        $gcs_verbal = $periksaFisik->gcs_verbal;
                    }
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien.' - '.$model->jeniskelamin;
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                    $returnVal[$i]["diagnosa"] = $diagnosa->diagnosa->diagnosa_nama;
                    $returnVal[$i]["diagnosa_id"] = $diagnosa->diagnosa_id;
                    $returnVal[$i]["keluhanutama"] = $keluhanutama;
                    $returnVal[$i]["keluhantambahan"] = $keluhantambahan;
                    $returnVal[$i]["riwayatpenyakitterdahulu"] = $riwayatpenyakitterdahulu;
                    $returnVal[$i]["riwayatpenyakitkeluarga"] = $riwayatpenyakitkeluarga;
                    $returnVal[$i]["tekanandarah"] = $tekanandarah;
                    $returnVal[$i]["pegawai"] = $pegawai;
                    $returnVal[$i]["detaknadi"] = $detaknadi;
                    $returnVal[$i]["suhutubuh"] = $suhutubuh;
                    $returnVal[$i]["tinggibadan"] = $tinggibadan;
                    $returnVal[$i]["beratbadan"] = $beratbadan;
                    $returnVal[$i]["pernapasan"] = $pernapasan;
                    $returnVal[$i]["kelainanpadabagtubuh"] = $kelainanpadabagtubuh;
                    $returnVal[$i]["meanarteripressure"] = $meanarteripressure;
                    $returnVal[$i]["gcs"] = $gcs_eye+$gcs_motorik+$gcs_verbal;
                    $returnVal[$i]["usia"] = substr($model->umur, 0, 2);    
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
	
        public function actionPasienNonAktif()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                $criteria->order = 'no_rekam_medik';
                $models = PasiennonaktifV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien;
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionNoRmPasienRawatDarurat(){
            if(Yii::app()->request->isAjaxRequest) {
                    $criteria = new CDbCriteria();
                    $criteria->with = array('pasien','instalasi','ruangan');
                    $criteria->compare('LOWER(pasien.no_rekam_medik)', strtolower($_GET['term']), true);
                    $criteria->addCondition("pasienbatalperiksa_id is null and pendaftaran_id is not null and pasienpulang_id is null");
                    $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                    $criteria->addNotInCondition("statusperiksa", array("SUDAH PULANG"));
                    $criteria->addInCondition('ispasienluar',array(false));
                    $criteria->order = 'tgl_pendaftaran DESC';
                    $criteria->limit = 5;
                    $models = PendaftaranT::model()->findAll($criteria);
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->pasien->no_rekam_medik.' - '.$model->ruangan->ruangan_nama.' - '.$model->tgl_pendaftaran; //.' - '.$model->statusperiksa
                        $returnVal[$i]['value'] = $model->pasien->no_rekam_medik;
                        $returnVal[$i]['jeniskelamin'] = $model->pasien->jeniskelamin;
                        $returnVal[$i]['namapasien'] = $model->pasien->nama_pasien;
                        $returnVal[$i]['namabin'] = $model->pasien->nama_bin;
                        $returnVal[$i]['jeniskasuspenyakit'] = $model->jeniskasuspenyakit->jeniskasuspenyakit_nama;
                        $returnVal[$i]['namainstalasi'] = $model->instalasi->instalasi_nama;
                        $returnVal[$i]['namaruangan'] = $model->ruangan->ruangan_nama;
                        $returnVal[$i]['carabayar_nama'] = $model->carabayar->carabayar_nama;
                        $returnVal[$i]['penjamin_nama'] = $model->penjamin->penjamin_nama;
                        //cari tanggungan penjamin
                        $criteria = new CDbCriteria();
                        $criteria->compare('penjamin_id',$model->penjamin_id);
                        $criteria->compare('kelaspelayanan_id',$model->kelaspelayanan_id);
                        $criteria->compare('carabayar_id',$model->carabayar_id);
                        $tanggungan = TanggunganpenjaminM::model()->find($criteria);
                        $returnVal[$i]['subsidirumahsakitoa'] = $tanggungan->subsidirumahsakitoa;
                        $returnVal[$i]['subsidipemerintahoa'] = $tanggungan->subsidipemerintahoa;
                        $returnVal[$i]['subsidiasuransioa'] = $tanggungan->subsidiasuransioa;
                        $returnVal[$i]['iurbiayaoa'] = $tanggungan->iurbiayaoa;
                        $returnVal[$i]['makstanggpel'] = $tanggungan->makstanggpel;
                        //lama rawat
                        $returnVal[$i]['lama_rawat'] = $model->LamaRawat;
                        //cari dokter ruangan
                        $pasienAdmisi = PasienadmisiT::model()->findByAttributes(array('pendaftaran_id'=>$model->pendaftaran_id));
                        if(!empty($pasienAdmisi->pasienadmisi_id)){
                            $returnVal[$i]['pegawai_id'] = $pasienAdmisi->pegawai_id;
                            $returnVal[$i]['pegawai_nama'] = PegawaiM::model()->findByPk($pasienAdmisi->pegawai_id)->NamaLengkap;
                        }else{
                            $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
                            $returnVal[$i]['pegawai_nama'] = $model->pegawai->NamaLengkap;
                        }
                            
                    }
                    echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        public function actionNamaPasienRawatDarurat()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->with = array('pasien','instalasi','ruangan');
                $criteria->compare('LOWER(pasien.nama_pasien)', strtolower($_GET['term']), true);
                $criteria->addCondition('pasienbatalperiksa_id is null and pendaftaran_id is not null and pasienpulang_id is null');
                $criteria->addCondition('t.ruangan_id = '.Yii::app()->user->getState('ruangan_id'));
                $criteria->addNotInCondition("statusperiksa", array("SUDAH PULANG"));
                $criteria->addInCondition('ispasienluar',array(false));
                $criteria->order = 'tgl_pendaftaran DESC';
                $criteria->limit = 5;
                $models = PendaftaranT::model()->findAll($criteria);
                
                foreach($models as $i=>$model)
                {
                    $format = new MyFormatter();
                    $date1 = $format->formatDateTimeForDb($model->tgl_pendaftaran);
                    $date2 = date('Y-m-d H:i:s');
                    $diff = abs(strtotime($date2) - strtotime($date1));
                    $hours   = floor(($diff)/3600); 
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                        
                    }
                    $returnVal[$i]['label'] = $model->pasien->nama_pasien.' - '.$model->pasien->no_rekam_medik.' - '.$model->ruangan->ruangan_nama.' - '.$model->tgl_pendaftaran;
                    $returnVal[$i]['value'] = $model->pasien->nama_pasien;
                    $returnVal[$i]['no_rekam_medik'] = $model->pasien->no_rekam_medik;
                    $returnVal[$i]['jeniskelamin'] = $model->pasien->jeniskelamin;
                    $returnVal[$i]['namapasien'] = $model->pasien->nama_pasien;
                    $returnVal[$i]['namabin'] = $model->pasien->nama_bin;
                    $returnVal[$i]['jeniskasuspenyakit'] = $model->jeniskasuspenyakit->jeniskasuspenyakit_nama;
                    $returnVal[$i]['namainstalasi'] = $model->instalasi->instalasi_nama;
                    $returnVal[$i]['namaruangan'] = $model->ruangan->ruangan_nama;
                    $returnVal[$i]['carabayar_nama'] = $model->carabayar->carabayar_nama;
                    $returnVal[$i]['penjamin_nama'] = $model->penjamin->penjamin_nama;
                    //cari tanggungan penjamin
                    $criteria = new CDbCriteria();  
                    $criteria->compare('penjamin_id',$model->penjamin_id);
                    $criteria->compare('kelaspelayanan_id',$model->kelaspelayanan_id);
                    $criteria->compare('carabayar_id',$model->carabayar_id);
                    $tanggungan = TanggunganpenjaminM::model()->find($criteria);
                    $returnVal[$i]['subsidirumahsakitoa'] = $tanggungan->subsidirumahsakitoa;
                    $returnVal[$i]['subsidipemerintahoa'] = $tanggungan->subsidipemerintahoa;
                    $returnVal[$i]['subsidiasuransioa'] = $tanggungan->subsidiasuransioa;
                    $returnVal[$i]['makstanggpel'] = $tanggungan->makstanggpel;
                    //lama rawat
                        $returnVal[$i]['lama_rawat'] = $model->LamaRawat;
                    if(!empty($pasienAdmisi->pasienadmisi_id)){
                        $returnVal[$i]['pegawai_id'] = $pasienAdmisi->pegawai_id;
                        $returnVal[$i]['pegawai_nama'] = $pasienAdmisi->pegawai->NamaLengkap;
                    }else{
                        $returnVal[$i]['pegawai_id'] = $model->pegawai_id;
                        $returnVal[$i]['pegawai_nama'] = $model->pegawai->NamaLengkap;
                    }
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        /**
         * action Pasien Lama Lab digunakan untuk pendaftaran pasien luar
         */
        public function actionPasienLamaLab()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                $criteria->order = 'no_rekam_medik';
                //Khusus No RM Lab dan Rad
                $criteria->addCondition('create_ruangan IN (56,52)'); //disesuaikan dengan kebutuhan RS
                $models = PasienM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien;
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        /**
         * action Pasien Lama Apotek digunakan untuk pendaftaran pasien apotek
         */
        public function actionPasienLamaApotek()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                $criteria->addCondition('ispasienluar = TRUE');
                $criteria->order = 'no_rekam_medik';
                $models = PasienM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien;
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionNoPendaftaranPasien()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_pendaftaran)', strtolower($_GET['term']), true);
                $criteria->order = 'date(tgl_pendaftaran) DESC';
                $models = PendaftaranT::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_pendaftaran;
                    $returnVal[$i]['value'] = $model->no_pendaftaran;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionTipePaketTindakan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(tipepaket_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'tipepaket_nama';
                $models = TipepaketM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->tipepaket_nama;
                    $returnVal[$i]['value'] = $model->tipepaket_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        

        public function actionDaftarTindakanBilling()
        {
            if(Yii::app()->request->isAjaxRequest)
            {
                if (!isset($_GET['term'])){
                    $_GET['term'] = null;
                }
                $ruangan_id = $_GET['ruangan_id'];
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
                
                if(Yii::app()->user->getState('tindakankelas'))
                {
                    $criteria->compare('kelaspelayanan_id', $_GET['idKelasPelayanan']);
                }
                
                if (isset($_GET['idDaftarTindakan']))
                {
                    $criteria->compare('daftartindakan_id', $_GET['idDaftarTindakan']);
                }
                $criteria->order = 'daftartindakan_nama';
                
                if($_GET['idTipePaket'] == Params::TIPEPAKET_ID_LUARPAKET)
                {
                    $criteria->compare('ruangan_id', $ruangan_id);
                    $criteria->compare('tipepaket_id', $_GET['idTipePaket']);
                    $models = PaketpelayananV::model()->findAll($criteria);
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->daftartindakan_nama;
                        $returnVal[$i]['value'] = $model->daftartindakan_id;
                    }
                    
                }else if($_GET['idTipePaket'] == Params::TIPEPAKET_ID_NONPAKET)
                {
                    
                    if(Yii::app()->user->getState('tindakanruangan'))
                    {
                        $criteria->compare('ruangan_id', $ruangan_id);
                        $models = TariftindakanperdaruanganV::model()->findAll($criteria);
                    }else{
                        $models = TariftindakanperdaV::model()->findAll($criteria);
                    }
                    
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->daftartindakan_nama;
                        $returnVal[$i]['value'] = $model->daftartindakan_id;
                    }
                    
                }else{
                    
                    $criteria->compare('ruangan_id', $ruangan_id);
                    $models = PaketpelayananV::model()->findAll($criteria);
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->daftartindakan_nama;
                        $returnVal[$i]['value'] = $model->daftartindakan_id;
                    }
                    
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }        
        
        public function actionDaftarTindakan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                if (!isset($_GET['term'])){
                    $_GET['term'] = null;
                }
                $kelaspelayanan_id = (isset($_GET['kelaspelayanan_id']) ? $_GET['kelaspelayanan_id'] : null);
                $tipepaket_id = (isset($_GET['tipepaket_id']) ? $_GET['tipepaket_id'] : null);
                if($_GET['tipepaket_id'] == Params::TIPEPAKET_ID_LUARPAKET)
                {
//                    $sql = "SELECT * FROM paketpelayanan_m
//                            JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = paketpelayanan_m.daftartindakan_id
//                            JOIN kategoritindakan_m ON kategoritindakan_m.kategoritindakan_id = daftartindakan_m.kategoritindakan_id
//                            WHERE tipepaket_id = ".Params::TIPEPAKET_ID_LUARPAKET."
//                            AND LOWER(daftartindakan_m.daftartindakan_nama) LIKE '".strtolower($_GET['term'])."%'";
//                            AND tariftindakan_m.kelaspelayanan_id = 22 
//                            AND ruangan_id = 1";
//                    $datas = Yii::app()->db->createCommand($sql)->queryAll();
                    $criteria = new CDbCriteria();
                    $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
//                    $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['daftartindakanNama']), true);
                    if(Yii::app()->user->getState('tindakanruangan'))
                        $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                    if(Yii::app()->user->getState('tindakankelas'))
                        $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
                    $criteria->compare('tipepaket_id', Params::TIPEPAKET_ID_LUARPAKET);
                    if (isset($_GET['daftartindakan_id'])){
                        $criteria->compare('daftartindakan_id', $_GET['daftartindakan_id']);
                    }
                     $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
                    $criteria->order = 'daftartindakan_nama';
                    $models = PaketpelayananV::model()->findAll($criteria);
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->daftartindakan_nama;
                        $returnVal[$i]['value'] = $model->daftartindakan_id;
                    }

                    echo CJSON::encode($returnVal);
                } else if($_GET['tipepaket_id'] == Params::TIPEPAKET_ID_NONPAKET) {
                    $criteria = new CDbCriteria();
                    $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
                    $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
                    $criteria->order = 'daftartindakan_nama';
                    
                    if (isset($_GET['daftartindakan_id'])){
                        $criteria->compare('daftartindakan_id', $_GET['daftartindakan_id']);
                    }
                    
//                    print_r(Yii::app()->user->getState('tindakankelas'));
                    if(Yii::app()->user->getState('tindakankelas'))
                    {
                        $criteria->compare('kelaspelayanan_id', $kelaspelayanan_id);
                    }
                    
//                    print_r(Yii::app()->user->getState('ruangan_id'));
                    if(Yii::app()->user->getState('tindakanruangan'))
                    {
                        $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                        $models = TariftindakanperdaruanganV::model()->findAll($criteria);
                    } else {
                        $models = TariftindakanperdaV::model()->findAll($criteria);
                    }
                    $returnVal = array();
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->daftartindakan_nama;
                        $returnVal[$i]['value'] = $model->daftartindakan_id;
                    }

                    echo CJSON::encode($returnVal);
                } else {
                    $criteria = new CDbCriteria();
                    $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
                    if (isset($_GET['daftartindakan_id'])){
                        $criteria->compare('daftartindakan_id', $_GET['daftartindakan_id']);
                    }
                    
                    if(Yii::app()->user->getState('tindakanruangan'))
                        $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                    
                    if(Yii::app()->user->getState('tindakankelas'))
                        $criteria->compare('kelaspelayanan_id', $_GET['kelaspelayanan_id']);
                    
                    $criteria->compare('tipepaket_id', $_GET['tipepaket_id']);
                     $criteria->compare('kelaspelayanan_id', $_GET['kelaspelayanan_id']);
                    $criteria->order = 'daftartindakan_nama';
                    $models = PaketpelayananV::model()->find($criteria);
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->daftartindakan_nama;
                        $returnVal[$i]['value'] = $model->daftartindakan_id;
                    }

                    echo CJSON::encode($returnVal);
                }
            }
            Yii::app()->end();
	}
        
        public function actionPemakaianBahan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
                //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'obatalkes_nama';
                $criteria->addCondition('obatalkes_farmasi is true');
                $criteria->limit = 5;
                $models = ObatalkesM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->obatalkes_nama;
                    $returnVal[$i]['value'] = $model->obatalkes_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionPemakaianAlatMedis()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(alatmedis_nama)', strtolower($_GET['term']), true);
                $criteria->compare('instalasi_id', Yii::app()->user->getState('instalasi_id'));
                $criteria->order = 'alatmedis_nama';
                $models = AlatmedisM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->alatmedis_nama;
                    $returnVal[$i]['value'] = $model->alatmedis_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionPaketBMHP()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->with = array('obatalkes','daftartindakan','kelompokumur');
                $criteria->compare('LOWER(obatalkes.obatalkes_nama)', strtolower($_GET['term']), true);
                //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'obatalkes.obatalkes_nama';
                $criteria->limit = 5;
                $models = PaketbmhpM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->obatalkes->obatalkes_nama.' - '.$model->daftartindakan->daftartindakan_nama.' ('.$model->kelompokumur->kelompokumur_nama.')';
                    $returnVal[$i]['value'] = $model->obatalkes->obatalkes_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        
        
        public function actionListDokter()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                if (isset($_GET['term'])){
                    $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                }
                //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'nama_pegawai';
                if (isset($_GET['idPegawai'])){
                    $criteria->compare('pegawai_id', $_GET['idPegawai']);
                }
                $criteria->addCondition('kelompokpegawai_id = 1');
                $criteria->select = 'gelardepan, nama_pegawai, gelarbelakang_nama';
                $criteria->group = 'gelardepan, nama_pegawai, gelarbelakang_nama';
                $models = DokterV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
                    $returnVal[$i]['value'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionListKaryawan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                if (isset($_GET['term'])){
                    $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                }
                //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'nama_pegawai';
                if (isset($_GET['idPegawai'])){
                    $criteria->compare('pegawai_id', $_GET['idPegawai']);
                }
                $criteria->addCondition('kelompokpegawai_id NOT IN (1)');
                $models = PegawaiM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nama_pegawai;
                    $returnVal[$i]['value'] = $model->nama_pegawai;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}        
        
        public function actionGetDokterJenisKelamin()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'nama_pegawai';
                $criteria->limit=10;
                $models = DokterV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->pegawai_id.'-'.$model->namaLengkap;
                    $returnVal[$i]['value'] = $model->namaLengkap;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        
        public function actionDaftarDokter()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'nama_pegawai';
                $criteria->limit=10;
                $models = DokterV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nama_pegawai;
                    $returnVal[$i]['value'] = $model->pegawai_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionGetDaftarTindakanVisite()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
                $criteria->compare('daftartindakan_visite', TRUE);
                $criteria->order = 'daftartindakan_nama';
                $criteria->limit=10;
                $models = DaftartindakanM::model()->findAll($criteria);
				$returnVal = array();
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->daftartindakan_id.'-'.$model->daftartindakan_nama;
                    $returnVal[$i]['value'] = $model->daftartindakan_nama;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionGetBidan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'nama_pegawai';
                $models = PegawaiM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nama_pegawai;
                    $returnVal[$i]['value'] = $model->pegawai_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionGetSuster()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'nama_pegawai';
                $models = PegawaiM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nama_pegawai;
                    $returnVal[$i]['value'] = $model->pegawai_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionGetPerawat()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'nama_pegawai';
                $models = DokterpegawaiV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai.", ".$model->gelarbelakang_nama;
                    $returnVal[$i]['value'] = $model->pegawai_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        /**
         * method to get obat reseptur
         * used in :
         * 1. farmasiApotik/penjualanResep/jualResep
         * 2. farmasiApotek/PenjualanResepLuar/JualResep
         * 3. farmasiApotek/PenjualanBebas/JualBebas
         * 4. gudangFarmasi/permintaanPenawaran
         * 5. laboratorium/pemakaianBahan
         * 6. radiologi/pemakaianBahanRad
         * 7. rawatInap/unitDosisTRI
         */
        public function actionObatReseptur()
	{
            if(Yii::app()->request->isAjaxRequest)
            {
//                $idSupplier = ((!empty($_GET['idSupplier'])) ? $_GET['idSupplier'] : 0);
                
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
                $criteria->compare('sumberdana_id', $_GET['idSumberDana']);
                $criteria->addCondition('obatalkes_farmasi = TRUE');
                $criteria->addCondition('obatalkes_aktif = true');
                $criteria->order = 'obatalkes_nama';
                $criteria->limit = 5;
                $models = ObatalkesM::model()->with('sumberdana','satuankecil')->findAll($criteria);
                $persenjual = $this->persenJualRuangan();
                $format = new MyFormatter();
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                    $returnVal[$i]['label'] = $model->obatalkes_kode." - ".$model->obatalkes_nama." - Jumlah Stok ".$qtyStok;
                    $returnVal[$i]['value'] = $model->obatalkes_nama;
                    $returnVal[$i]['sumberdana_nama'] = $model->sumberdana->sumberdana_nama;
                    $returnVal[$i]['qtyStok'] = $qtyStok;
                    $returnVal[$i]['hargajual'] = floor(($persenjual + 100 ) / 100 * $model->hargajual);
                    $returnVal[$i]['satuankecil'] = $model->satuankecil->satuankecil_nama;
                    $returnVal[$i]['idsatuankecil'] = $model->satuankecil_id;
                    $returnVal[$i]['diskonJual'] = empty($model->diskonJual) ? 0 : $model->diskonJual;
                    $returnVal[$i]['kadaluarsa'] = ((strtotime($format->formatDateTimeForDb($model->tglkadaluarsa)) - strtotime(date('Y-m-d'))) > 0) ? 0 : 1 ;
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionGetStokObat()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $idObatalkes = $_POST['idObatalkes'];
                $returnVal['stok'] = StokobatalkesT::getJumlahStok(
                    $idObatalkes, Yii::app()->user->getState('ruangan_id')
                );
                
                echo CJSON::encode($returnVal);
                Yii::app()->end();
            }
        }
        
        protected function getStokObat($idObatalkes)
        {
            if(Yii::app()->request->isAjaxRequest){
//            $command = Yii::app()->db->createCommand();
//            $command->select('SUM(qtystok_current) AS stok');
//            $command->where('obatalkes_id=:idobat ruangan_id=:idruangan',
//                            array(':idobat'=>$idObatalkes,
//                                  ':idruangan'=>Yii::app()->user->ruangan_id));
//            $stok = $command->queryScalar();
            $idRuangan = Yii::app()->user->ruangan_id;
            $command = Yii::app()->db->CreateCommand(
                    "SELECT SUM(qtystok_current) AS stok
                    FROM stokobatalkes_t
                    WHERE obatalkes_id=$idObatalkes AND ruangan_id=$idRuangan"
            )->queryAll();
            $stok = $command[0]['stok'];
            
                echo CJSON::encode($stok);
                Yii::app()->end();
            }
        }

        protected function persenJualRuangan()
        {
            switch(Yii::app()->user->getState('instalasi_id')){
                case Params::INSTALASI_ID_RI : $persen = Yii::app()->user->getState('ri_persjual');
                                                break;
                case Params::INSTALASI_ID_RJ : $persen = Yii::app()->user->getState('rj_persjual');
                                                break;
                case Params::INSTALASI_ID_RD : $persen = Yii::app()->user->getState('rd_persjual');
                                                break;
                default : $persen = 0; break;
            }
            
            return $persen;
        }
        
        public function actionSumberDana()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(sumberdana_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'sumberdana_nama';
                $models = SumberdanaM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->sumberdana_nama;
                    $returnVal[$i]['value'] = $model->sumberdana_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        //-- Inventori -- 
        //Get No Pemesanan Obat dan Alat Kesehatan
        public function actionNoPemesananObatAlkes()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nopemesanan)', strtolower($_GET['term']), true);
                $criteria->condition = "mutasioaruangan_id is null and ruangan_id =".Yii::app()->user->getState('ruangan_id');
                $criteria->order = 'nopemesanan';
                $criteria->limit=10;
                $models = PesanobatalkesT::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nopemesanan;
                    $returnVal[$i]['value'] = $model->nopemesanan;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        //-- Inventori -- 
        //Get No Mutasi Obat dan Alat Kesehatan
        public function actionNoMutasiObatAlkes()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nomutasioa)', strtolower($_GET['term']), true);
                $criteria->order = 'nomutasioa';
                $criteria->limit=10;
                $criteria->condition = 'pesanobatalkes_id is null and terimamutasi_id is null';
                $models = MutasioaruanganT::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nomutasioa;
                    $returnVal[$i]['value'] = $model->nomutasioa;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        //-- SistemAdministrator -- 
        //Get Daftar Tindakan untuk paket Pelayanan
        public function actionGetDaftarTindakan(){
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'daftartindakan_nama';
                $criteria->limit=10;
                $sql = "select distinct t.harga_tariftindakan as harga, t.daftartindakan_id as daftartindakan_id, t.tariftindakan_id as tariftindakan_id, k.kelaspelayanan_nama as kelaspelayanan_nama, daftartindakan_m.daftartindakan_nama as daftartindakan_nama, t.daftartindakan_id as daftartindakan, t.komponentarif_id as komponentarif, t.kelaspelayanan_id as kelaspelayanan from tariftindakan_m as t
                            JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = t.daftartindakan_id
                            JOIN kelaspelayanan_m as k ON k.kelaspelayanan_id = t.kelaspelayanan_id
                    where t.kelaspelayanan_id = ".$_GET['idKelasPelayanan']." and komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL." and LOWER(daftartindakan_nama) like '".strtolower($_GET['term'])."%' order by kelaspelayanan_nama";
                $datas = Yii::app()->db->createCommand($sql)->queryAll();
                    foreach($datas as $i=>$data)
                    {
                        foreach($data as $attribute=>$value) {
                         
                            $returnVal[$i]['label'] = $data['daftartindakan_nama'].' - '.$data['kelaspelayanan_nama'].' - '.$data['harga'] ;
                            $returnVal[$i]['value'] = $data['daftartindakan_nama'].' - '.$data['kelaspelayanan_nama'].' - '.$data['harga'];
                            $returnVal[$i]["$attribute"] = $value;
                        }
                    }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }

        public function actionGetDaftarTindakanForRM(){
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(daftartindakan_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'daftartindakan_nama';
                $criteria->limit=10;
                $sql = "select distinct t.harga_tariftindakan as harga, t.daftartindakan_id as daftartindakan_id, t.tariftindakan_id as tariftindakan_id, k.kelaspelayanan_nama as kelaspelayanan_nama, daftartindakan_m.daftartindakan_nama as daftartindakan_nama, t.daftartindakan_id as daftartindakan, t.komponentarif_id as komponentarif, t.kelaspelayanan_id as kelaspelayanan from tariftindakan_m as t
                            JOIN daftartindakan_m ON daftartindakan_m.daftartindakan_id = t.daftartindakan_id
                            JOIN kelaspelayanan_m as k ON k.kelaspelayanan_id = t.kelaspelayanan_id
                    where komponentarif_id = ".Params::KOMPONENTARIF_ID_TOTAL." and LOWER(daftartindakan_nama) like '".strtolower($_GET['term'])."%' order by kelaspelayanan_nama";
                $datas = Yii::app()->db->createCommand($sql)->queryAll();
                    foreach($datas as $i=>$data)
                    {
                        foreach($data as $attribute=>$value) {
                         
                            $returnVal[$i]['label'] = $data['daftartindakan_nama'].' - '.$data['kelaspelayanan_nama'].' - '.$data['harga'] ;
                            $returnVal[$i]['value'] = $data['daftartindakan_nama'].' - '.$data['kelaspelayanan_nama'].' - '.$data['harga'];
                            $returnVal[$i]["$attribute"] = $value;
                        }
                    }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        public function actionPasienRawatJalan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $pasien_id = $_POST['pasien_id'];
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                if(!empty($pasien_id)){
                    $criteria->compare('pasien_id',$pasien_id);
                }
                $criteria->order = 'no_rekam_medik';
                $criteria->limit=10;
                $models = InfokunjunganrjV::model()->findAll($criteria);
                
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    $diagnosa = PasienmorbiditasT::model()->with('diagnosa')->findByAttributes(array('ruangan_id'=> Yii::app()->user->getState('ruangan_id'),'pasien_id'=>$model->pasien_id, 'kelompokdiagnosa_id'=> Params::KELOMPOKDIAGNOSA_UTAMA));
                    if (count($diagnosa) <= 0 ){
                        $diagnosa = PasienmorbiditasT::model()->with('diagnosa')->findByAttributes(array('ruangan_id'=> Yii::app()->user->getState('ruangan_id'),'pasien_id'=>$model->pasien_id));
                    }
                    $anamnesa = AnamnesaT::model()->findAllByAttributes(array('pasien_id'=>$model->pasien_id), array('order'=>'tglanamnesis DESC', 'limit'=>1));
                    foreach($anamnesa as $anamnesa){
                        $keluhanutama = $anamnesa->keluhanutama;
                        $keluhantambahan = $anamnesa->keluhantambahan;
                        $riwayatpenyakitterdahulu = $anamnesa->riwayatpenyakitterdahulu;
                        $riwayatpenyakitkeluarga = $anamnesa->riwayatpenyakitkeluarga;
                    }
                    $periksaFisik = PemeriksaanfisikT::model()->with('pegawai')->findAllByAttributes(array('pasien_id'=>$model->pasien_id), array('order'=>'tglperiksafisik DESC', 'limit'=>1));
                    foreach($periksaFisik as $periksaFisik){
                        $tekanandarah = $periksaFisik->tekanandarah;
                        $detaknadi = $periksaFisik->detaknadi;
                        $suhutubuh = $periksaFisik->suhutubuh;
                        $beratbadan = $periksaFisik->beratbadan_kg;
                        $tinggibadan = $periksaFisik->tinggibadan_cm;
                        $pernapasan = $periksaFisik->pernapasan;
                        $pegawai = $periksaFisik->pegawai->nama_pegawai;
                        $kelainanpadabagtubuh = $periksaFisik->kelainanpadabagtubuh;
                    }
                                        
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien.' - '.$model->jeniskelamin;
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                    $returnVal[$i]["diagnosa"] = $diagnosa->diagnosa->diagnosa_nama;
                    $returnVal[$i]["diagnosa_id"] = $diagnosa->diagnosa_id;
                    $returnVal[$i]["keluhanutama"] = $keluhanutama;
                    $returnVal[$i]["keluhantambahan"] = $keluhantambahan;
                    $returnVal[$i]["riwayatpenyakitterdahulu"] = $riwayatpenyakitterdahulu;
                    $returnVal[$i]["riwayatpenyakitkeluarga"] = $riwayatpenyakitkeluarga;
                    $returnVal[$i]["tekanandarah"] = $tekanandarah;
                    $returnVal[$i]["pegawai"] = $pegawai;
                    $returnVal[$i]["detaknadi"] = $detaknadi;
                    $returnVal[$i]["suhutubuh"] = $suhutubuh;
                    $returnVal[$i]["tinggibadan"] = $tinggibadan;
                    $returnVal[$i]["beratbadan"] = $beratbadan;
                    $returnVal[$i]["pernapasan"] = $pernapasan;
                    $returnVal[$i]["kelainanpadabagtubuh"] = $kelainanpadabagtubuh;
                    $returnVal[$i]["pegawai"] = $pegawai;
                    $returnVal[$i]["tgl_pendaftaran"] = $model->tgl_pendaftaran;
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionPasienRJ()
        {
            if(Yii::app()->request->isAjaxRequest) { 
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                $criteria->order = 'no_rekam_medik';
                $criteria->limit=10;
                $models = InfokunjunganrjV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->no_pendaftaran;
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        public function actionPasien()
        {
            if(Yii::app()->request->isAjaxRequest) { 
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                $criteria->order = 'no_rekam_medik';
                $criteria->limit=10;
                $models = InfopasienrirdambulansV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->no_pendaftaran;
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        

        public function actionPasienInformasi()
        {
            if(Yii::app()->request->isAjaxRequest) { 
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pasien)', strtolower($_GET['term']), true);
                $criteria->order = 'nama_pasien';
                $criteria->limit=10;
                $models = PasienM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nama_pasien;
                    $returnVal[$i]['value'] = $model->nama_pasien;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }

        public function actionPasienJenazah()
        {
            if(Yii::app()->request->isAjaxRequest) { 
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                $criteria->order = 'no_rekam_medik';
                $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->limit=10;
                $models = PasienmasukpenunjangV::model()->findAll($criteria);

                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->no_pendaftaran;
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        

        public function actionRekamMedikInformasi()
        {
            if(Yii::app()->request->isAjaxRequest) { 
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                $criteria->order = 'no_rekam_medik';
                $criteria->limit=10;
                $models = PasienM::model()->findAll($criteria);
                
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_rekam_medik;
                    $returnVal[$i]['value'] = $model->no_rekam_medik;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }

        public function actionNoPendaftaran()
        {
            if(Yii::app()->request->isAjaxRequest) { 
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_pendaftaran)', strtolower($_GET['term']), true);
                $criteria->order = 'no_pendaftaran';
                $criteria->limit=10;
                $models = InfopasienrirdambulansV::model()->findAll($criteria);

                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_pendaftaran.' - '.$model->no_rekam_medik;
                    $returnVal[$i]['value'] = $model->no_pendaftaran;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        public function actionNoPendaftaranJenazah()
        {
            if(Yii::app()->request->isAjaxRequest) { 
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(no_pendaftaran)', strtolower($_GET['term']), true);
                $criteria->order = 'no_pendaftaran';
                $criteria->limit=10;
                $criteria->compare('ruangan_id',  Yii::app()->user->getState('ruangan_id'));
                $models = PasienmasukpenunjangV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->no_pendaftaran.' - '.$model->no_rekam_medik;
                    $returnVal[$i]['value'] = $model->no_pendaftaran;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        public function actionGetDiagnosaKeperawatan(){
            if(Yii::app()->request->isAjaxRequest) {    
                if ($_GET['idDiagnosa'] != ''){
                    $idDiagnosa = $_GET['idDiagnosa'];
                    $criteria = new CDbCriteria();
                    $criteria->compare('LOWER(diagnosa_keperawatan)', strtolower($_GET['term']), true);
//                    if ($idDiagnosa > 0){
//                        $criteria->compare('diagnosa_id', $idDiagnosa);
//                    }
                    $criteria->order = 'diagnosa_keperawatan';
                    $criteria->limit=10;

                    $models = DiagnosakeperawatanM::model()->findAll($criteria);
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->diagnosa_keperawatan;
                        $returnVal[$i]['value'] = $model->diagnosa_keperawatan;
                    }

                    echo CJSON::encode($returnVal);
                }
            }
            Yii::app()->end();
        }

        public function actionDiagnosaKeperawatan(){
            if(Yii::app()->request->isAjaxRequest) {
                    $criteria = new CDbCriteria();
                    $criteria->compare('LOWER(diagnosa_keperawatan)', strtolower($_GET['term']), true);
//                    if ($idDiagnosa > 0){
//                        $criteria->compare('diagnosa_id', $idDiagnosa);
//                    }
                    $criteria->order = 'diagnosa_keperawatan';
                    $criteria->limit=10;

                    $models = DiagnosakeperawatanM::model()->findAll($criteria);
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->diagnosa_keperawatan;
                        $returnVal[$i]['value'] = $model->diagnosakeperawatan_id;
                    }

                    echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        
        //-- Gizi -- 
        //Get List Bahan Makanan untuk Pengajuan Bahan Makanan
        public function actionBahanMakanan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(namabahanmakanan)', strtolower($_GET['term']), true);
                $criteria->order = 'bahanmakanan_id';
                $models = BahanmakananM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->jenisbahanmakanan.' - '.$model->namabahanmakanan.' - '.$model->jmlpersediaan;
                    $returnVal[$i]['value'] = $model->bahanmakanan_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        //-- Gizi -- 
        //Get List Bahan Diet untuk Pemesanan Menu Diet
        public function actionBahanDiet()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(bahandiet_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'bahandiet_id';
                $models = BahandietM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->bahandiet_nama;
                    $returnVal[$i]['value'] = $model->bahandiet_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        //-- Gizi -- 
        //Get List Pasien untuk Pemesanan Menu Diet
        public function actionPasienUntukMenuDiet()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $idRuangan = $_GET['idRuangan'];
                if (!empty($idRuangan)){
                    $criteria = new CDbCriteria();
    //                $criteria->with =array('pasien', 'ruangan');
                    $criteria->compare('LOWER(no_rekam_medik)', strtolower($_GET['term']), true);
                    if (!empty($idRuangan)){
                        $criteria->compare('ruangan_id',$idRuangan);
                    }
                    $criteria->order = 'nama_pasien';
                    $models = InfokunjunganriV::model()->findAll($criteria);
                    foreach($models as $i=>$model)
                    {
                        $attributes = $model->attributeNames();
                        foreach($attributes as $j=>$attribute) {
                            $returnVal[$i]["$attribute"] = $model->$attribute;
                        }
                        $returnVal[$i]['label'] = $model->no_rekam_medik.' - '.$model->nama_pasien.' - '.$model->ruangan_nama;
                        $returnVal[$i]['value'] = $model->pasien_id;
                    }

                    echo CJSON::encode($returnVal);
                }
            }
            Yii::app()->end();
	}
    
        public function actionPegawaiUntukMenuDiet()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $idRuangan = $_GET['idRuangan'];
                
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                if (!empty($idRuangan)){
                    $criteria->compare('ruangan_id',$idRuangan);
                }
                $criteria->order = 'nama_pegawai';
                $models = PegawairuanganV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nama_pegawai.' - '.$model->ruangan_nama;
                    $returnVal[$i]['value'] = $model->pegawai_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        //-- Sistem Administrator -- 
        //Get Instalasi untuk lokasi aset
        public function actionGetInstalasi()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(instalasi_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'instalasi_nama';
                $models = InstalasiM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->instalasi_nama;
                    $returnVal[$i]['value'] = $model->instalasi_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        //-- Sistem Administrator -- 
        //Get Ruangan untuk lokasi aset
        public function actionGetRuangan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(ruangan_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'ruangan_nama';
                $models = RuanganM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->ruangan_nama;
                    $returnVal[$i]['value'] = $model->ruangan_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        public function actionGetBidang()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(bidang_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'bidang_nama';
                $models = BidangM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->bidang_nama;
                    $returnVal[$i]['value'] = $model->bidang_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        public function actionGetGolongan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(golongan_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'golongan_nama';
                $models = GolonganM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->golongan_nama;
                    $returnVal[$i]['value'] = $model->golongan_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        public function actionGetKelompok()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(kelompok_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'kelompok_nama';
                $models = KelompokM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->kelompok_nama;
                    $returnVal[$i]['value'] = $model->kelompok_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        public function actionGetSubKelompok()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(subkelompok_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'subkelompok_nama';
                $models = SubkelompokM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->subkelompok_nama;
                    $returnVal[$i]['value'] = $model->subkelompok_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        public function actionGetBarang()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(barang_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'barang_nama';
                $models = BarangM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->barang_nama;
                    $returnVal[$i]['value'] = $model->barang_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        public function actionGetPemilikBarang()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(pemilikbarang_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'pemilikbarang_nama';
                $models = PemilikbarangM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->pemilikbarang_nama;
                    $returnVal[$i]['value'] = $model->pemilikbarang_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        public function actionGetAsalAset()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(asalaset_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'asalaset_nama';
                $models = AsalasetM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->asalaset_nama;
                    $returnVal[$i]['value'] = $model->asalaset_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        public function actionGetLokasiAset()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(lokasiaset_namalokasi)', strtolower($_GET['term']), true);
                $criteria->order = 'lokasiaset_namalokasi';
                $models = LokasiasetM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->lokasiaset_namalokasi;
                    $returnVal[$i]['value'] = $model->lokasi_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionBarang()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(t.barang_nama)', strtolower($_GET['term']), true);
                $criteria->order = 't.barang_id';
                $models = BarangM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->barang_nama;
                    $returnVal[$i]['value'] = $model->barang_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        

        public function actionTherapiObat()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(therapiobat_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'therapiobat_nama';
                $criteria->limit = 5;
                $models = TherapiobatM::model()->findAll($criteria);

                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->therapiobat_nama;
                    $returnVal[$i]['value'] = $model->therapiobat_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();

        }
        
        public function actionGetPegawai()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                $criteria->order = 'nama_pegawai';
                $models = PegawaiM::model()->findAll($criteria);

                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nama_pegawai;
                    $returnVal[$i]['value'] = $model->pegawai_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();

        }
        
        public function actionJenisObatAlkes()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(jenisobatalkes_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'jenisobatalkes_nama';
                $criteria->limit = 5;
                $models = JenisobatalkesM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->jenisobatalkes_nama;
                    $returnVal[$i]['value'] = $model->jenisobatalkes_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        
        
        public function actionJenisKasusPenyakit()
        {
                    if(Yii::app()->request->isAjaxRequest) {
                        $criteria = new CDbCriteria();
                        $criteria->compare('LOWER(jeniskasuspenyakit_nama)', strtolower($_GET['term']), true);
                        $criteria->order = 'jeniskasuspenyakit_nama';
                        $criteria->limit=10;
                        $models = JeniskasuspenyakitM::model()->findAll($criteria);
                        foreach($models as $i=>$model)
                        {
                            $attributes = $model->attributeNames();
                            foreach($attributes as $j=>$attribute) {
                                $returnVal[$i]["$attribute"] = $model->$attribute;
                            }
                            $returnVal[$i]['label'] = $model->jeniskasuspenyakit_nama;
                            $returnVal[$i]['value'] = $model->jeniskasuspenyakit_id;
                        }

                        echo CJSON::encode($returnVal);
                    }
                    Yii::app()->end();
        }
        
        public function actionKelaspelayanan()
        {
                    if(Yii::app()->request->isAjaxRequest) {
                        $criteria = new CDbCriteria();
                        $criteria->compare('LOWER(kelaspelayanan_nama)', strtolower($_GET['term']), true);
                        $criteria->order = 'kelaspelayanan_nama';
                        $criteria->limit=10;
                        $models = KelaspelayananM::model()->findAll($criteria);
                        foreach($models as $i=>$model)
                        {
                            $attributes = $model->attributeNames();
                            foreach($attributes as $j=>$attribute) {
                                $returnVal[$i]["$attribute"] = $model->$attribute;
                            }
                            $returnVal[$i]['label'] = $model->kelaspelayanan_nama;
                            $returnVal[$i]['value'] = $model->kelaspelayanan_id;
                        }

                        echo CJSON::encode($returnVal);
                    }
                    Yii::app()->end();
        }
        
        
        
        public function actionDiagnosa()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(diagnosa_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'diagnosa_nama';
                $criteria->limit=10;
                $models = DiagnosaM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->diagnosa_kode. '-' .$model->diagnosa_nama;
                    $returnVal[$i]['value'] = $model->diagnosa_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionPegawairiwayat()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
                $criteria->order = 'nama_pegawai';
                $models = PegawaiM::model()->findAll($criteria);

                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->nomorindukpegawai.' - '.$model->nama_pegawai.' - '.$model->jeniskelamin;
                    $returnVal[$i]['nama_pegawai'] = $model->nama_pegawai;
                    $returnVal[$i]['value'] = $model->pegawai_id;
                    $returnVal[$i]['jabatan_nama'] = (isset($model->jabatan->jabatan_nama) ? $model->jabatan->jabatan_nama : '-');
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();

        }
        
        public function actionSupplier()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(supplier_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'supplier_nama';
                $criteria->limit=10;
                $models = SupplierM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->supplier_kode.' - '.$model->supplier_nama;
                    $returnVal[$i]['value'] = $model->supplier_nama;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        

        public function actionGetStockBarangRetail()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(stock_name)', strtolower($_GET['term']), true);
                $criteria->order = 'stock_name';
                $criteria->limit=10;
                $models = ProdukposV::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->stock_code.' - '.$model->stock_name;
                    $returnVal[$i]['value'] = $model->stock_name;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();

	}

        public function actionProductItems()
        {
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
                $criteria->addCondition('obatalkes_farmasi=FALSE');
                $criteria->order = 'obatalkes_nama';
                $criteria->limit = 5;
                $models = ObatalkesM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->obatalkes_nama;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        public function actionPemeriksaanlab()
        {
            if (Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria;
                $criteria->compare('LOWER(pemeriksaanlab_nama)',strtolower($_GET['term']), true);
                $criteria->order = 'pemeriksaanlab_nama';
                $models = PemeriksaanlabM::model()->findAll($criteria);
                foreach ($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach ($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->pemeriksaanlab_nama;
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        public function actionNilairujukan()
        {
            if (Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria;
                $criteria->compare('LOWER(namapemeriksaandet)',strtolower($_GET['term']), true);
                $criteria->order = 'namapemeriksaandet';
                $models = NilairujukanM::model()->findAll($criteria);
                foreach ($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach ($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->namapemeriksaandet;
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        public function actionDaftarMenuDiet()
        {
            if (Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria;
                $criteria->compare('LOWER(menudiet_nama)',strtolower($_GET['term']), true);
                $criteria->order = 'menudiet_nama';
                $models = MenuDietM::model()->findAll($criteria);
                foreach ($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach ($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->menudiet_nama;
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        public function actionGetListTable(){
            if (Yii::app()->request->isAjaxRequest){
                $term = null;
                if (isset($_GET['term']))
                    $term = "%$_GET[term]%";
                $sql = "select table_name from information_schema.tables where table_type = 'BASE TABLE' and table_schema = 'public' and table_name ilike :ruangan";
                $listTable = Yii::app()->db->createCommand($sql)->query(array(':ruangan'=>$term));
                $hasil = array();
                foreach ($listTable as $value) {
                    $hasil[] = $value['table_name'];
                }
                echo json_encode($hasil);
                Yii::app()->end();
            }
        }
        
        public function actionGetValuePrimaryKey(){
            if (Yii::app()->request->isAjaxRequest){
                if (isset($_GET['table']))
                    $tableName = $_GET['table'];
                if (isset($_GET['table']))
                    $primaryKey = $_GET['primaryKey'];
                if (isset($_GET['term']))
                    $term = "%$_GET[term]%";

                $hasil = explode('_', $tableName);
                $possible = array();
                if (count($hasil) > 1){
                    $possible[] = $hasil[0].'_nama';
                    $possible[] = 'nama_'.$hasil[0];
                }
                
                $table = Yii::app()->db->schema->getTable($tableName);
                $kolom = $table->columnNames;
                
                $hasil = array();
                if (in_array($possible[0], $kolom)){
                    $sql = "select {$possible[0]}, {$primaryKey} from {$table->name} where {$possible[0]} ilike :term";
                    $possible = $possible[0];
                }else if(in_array($possible[1], $kolom)) {
                    $sql = "select {$possible[1]} {$primaryKey} from {$table->name} where {$possible[1]} ilike :term";
                    $possible = $possible[1];
                }
                
                if (isset($sql))
                    $query = Yii::app()->db->createCommand($sql)->queryAll(true, array(':term'=>$term));
                
                if (count($query) > 0){
                    foreach ($query as $x=>$value) {
                        $hasil[$x]['label'] = $value[$possible];
                        $hasil[$x]['value'] = $value[$possible];
                        $hasil[$x]['id'] = $value[$primaryKey];
                    }
                }
                
                echo json_encode($hasil);
            }
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
        /**
         * digunakan pada:
         * - Pendaftaran Pasien Luar Lab Rad
         */
        public function actionRujukanDari()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $asalRujukanId = ((!empty($_GET['asalRujukanId'])) ? $_GET['asalRujukanId'] : 0);
                $criteria->compare('asalrujukan_id',$asalRujukanId);
                $criteria->compare('LOWER(namaperujuk)', strtolower($_GET['term']), true);
                $criteria->order = 'namaperujuk';
                $criteria->limit=10;
                $models = RujukandariM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->namaperujuk.' - '.$model->spesialis;
                    $returnVal[$i]['value'] = $model->namaperujuk;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        /* Digunakan di Modul Akuntansi
         * 
         */
        public function actionRekeningAkuntansi()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
//                $criteria->compare('LOWER(nmrincianobyek)', strtolower($_GET['term']), true);
                $term = strtolower(trim($_GET['term']));
                
                $condition = "LOWER(nmrincianobyek) LIKE '%". $term ."%' OR LOWER(nmobyek) LIKE '%". $term ."%' OR LOWER(nmjenis) LIKE '%". $term ."%'";
                if(isset($_GET['id_jenis_rek']))
                {
                    $condition = "(LOWER(nmrincianobyek) LIKE '%". $term ."%' OR LOWER(nmobyek) LIKE '%". $term ."%' OR LOWER(nmjenis) LIKE '%". $term ."%') AND (rincianobyek_nb = 'D' OR obyek_nb = 'D' OR jenis_nb = 'D')";
                    if($_GET['id_jenis_rek'] == 'Kredit')
                    {
                        $condition = "(LOWER(nmrincianobyek) LIKE '%". $term ."%' OR LOWER(nmobyek) LIKE '%". $term ."%' OR LOWER(nmjenis) LIKE '%". $term ."%') AND (rincianobyek_nb = 'K' OR obyek_nb = 'K' OR jenis_nb = 'K')";
                    }
                }
                
                $criteria->addCondition($condition);
                $criteria->order = 'nmrincianobyek';
                $models = RekeningakuntansiV::model()->findAll($criteria);
                $returnVal = array();
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute){
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    if(isset($model->rincianobyek_id)){
                        $kode_rekening = $model->kdstruktur . "-" . $model->kdkelompok . "-" . $model->kdjenis . "-" . $model->kdobyek . "-" . $model->kdrincianobyek;
                        $nama_rekening = $model->nmrincianobyek;
                    }else{
                        if(isset($model->obyek_id)){
                            $kode_rekening = $model->kdstruktur . "-" . $model->kdkelompok . "-" . $model->kdjenis . "-" . $model->kdobyek;
                            $nama_rekening = $model->nmobyek;
                        }else{
                            $kode_rekening = $model->kdstruktur . "-" . $model->kdkelompok . "-" . $model->kdjenis;
                            $nama_rekening = $model->nmjenis;
                        }
                    }
                    $returnVal[$i]['label'] = $kode_rekening . '-' . $nama_rekening;
                    $returnVal[$i]['value'] = $nama_rekening;
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionRekeningKodeAkuntansi()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                
                $term = strtolower($_GET['term']);
                $condition = "LOWER(kdrincianobyek) LIKE '%". $term ."%' OR LOWER(kdobyek) LIKE '%". $term ."%' OR LOWER(kdjenis) LIKE '%". $term ."%'";
                $criteria->addCondition($condition);
                $criteria->order = 'kdrincianobyek';
                $models = RekeningakuntansiV::model()->findAll($criteria);
                $returnVal = array();
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute){
                        if(isset($model->rincianobyek_id))
                        {
                            $kode_rekening = $model->kdstruktur . "-" . $model->kdkelompok . "-" . $model->kdjenis . "-" . $model->kdobyek . "-" . $model->kdrincianobyek;
                            $nama_rekening = $model->kdrincianobyek;
                        }else{
                            if(isset($model->obyek_id))
                            {
                                $kode_rekening = $model->kdstruktur . "-" . $model->kdkelompok . "-" . $model->kdjenis . "-" . $model->kdobyek;
                                $nama_rekening = $model->kdobyek;
                            }else{
                                $kode_rekening = $model->kdstruktur . "-" . $model->kdkelompok . "-" . $model->kdjenis;
                                $nama_rekening = $model->kdjenis;
                            }
                        }
                        $returnVal[$i]['label'] = $kode_rekening;
                        $returnVal[$i]['value'] = $nama_rekening;
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}

    //Menampilkan daftar rekening debet
    public function actionRekeningAkuntansiDebit()
    {
        $account = 'D';
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(rincianobyek_nb)',strtolower($account),true);
            $criteria->compare('LOWER(nmrincianobyek)', strtolower($_GET['term']), true);
            $criteria->order = 'nmrincianobyek';
            $models = RekeningakuntansiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->kdstruktur."-".$model->kdkelompok."-".$model->kdjenis."-".$model->kdobyek."-".$model->kdrincianobyek."-".$model->nmrincianobyek;
                $returnVal[$i]['value'] = $model->nmrincianobyek;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

    //Menampilkan daftar rekening Kredit
    public function actionRekeningAkuntansiKredit()
    {
        $account = 'K';
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(rincianobyek_nb)',strtolower($account),true);
            $criteria->compare('LOWER(nmrincianobyek)', strtolower($_GET['term']), true);
            $criteria->order = 'nmrincianobyek';
            $models = RekeningakuntansiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->kdstruktur."-".$model->kdkelompok."-".$model->kdjenis."-".$model->kdobyek."-".$model->kdrincianobyek."-".$model->nmrincianobyek;
                $returnVal[$i]['value'] = $model->nmrincianobyek;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }

        
        public function actionJenisPenerimaan()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(jenispenerimaan_nama)', strtolower($_GET['term']), true);
                $criteria->addCondition("jenispenerimaan_id not in(select jenispenerimaan_id from jnspenerimaanrek_m)");
                $criteria->order = 'jenispenerimaan_nama';
                $models = JenispenerimaanM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->jenispenerimaan_kode."-".$model->jenispenerimaan_nama;
                    $returnVal[$i]['value'] = $model->jenispenerimaan_nama;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionJenisPengeluaran()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(jenispengeluaran_nama)', strtolower($_GET['term']), true);
                $criteria->addCondition("jenispengeluaran_id not in(select jenispengeluaran_id from jnspengeluaranrek_m)");
                $criteria->order = 'jenispengeluaran_nama';
                $models = JenispengeluaranM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->jenispengeluaran_kode."-".$model->jenispengeluaran_nama;
                    $returnVal[$i]['value'] = $model->jenispengeluaran_nama;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionBank()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(namabank)', strtolower($_GET['term']), true);
                $criteria->addCondition("bank_id not in(select bank_id from bankrek_m)");
                $criteria->order = 'namabank';
                $models = BankM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->namabank;
                    $returnVal[$i]['value'] = $model->namabank;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionKomponenTarif()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $idKomponen = $_POST['idKomponen'];
                $namaKomponen = $_POST['namaKomponen'];
                if(isset($_POST['idKomponen']) && isset($_POST['namaKomponen'])){
                    $criteria = new CDbCriteria();
                    $criteria->compare('LOWER(komponentarif_nama)', strtolower($namaKomponen), true);
                    $criteria->compare('komponentarif_id',$idKomponen);
                    $criteria->order = 'komponentarif_nama';
    //                $criteria->limit = 10;
                    $models = KomponentarifM::model()->findAll($criteria);
                }else{
                    $criteria = new CDbCriteria();
                    $criteria->compare('LOWER(komponentarif_nama)', strtolower($_GET['term']), true);
                    $criteria->order = 'komponentarif_nama';
    //                $criteria->limit = 10;
                    $models = KomponentarifM::model()->findAll($criteria);
                }
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(komponentarif_nama)', strtolower($_GET['term']), true);
                $criteria->order = 'komponentarif_nama';
//                $criteria->limit = 10;
                $models = KomponentarifM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->komponentarif_nama;
                    $returnVal[$i]['value'] = $model->komponentarif_nama;
                    $returnVal[$i]['id'] = $model->komponentarif_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        /*
         * End
         */
        
         public function actionGetPemeriksaanRad()
	{
            if(Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria();
                if (isset($_GET['term'])){
                    $criteria->compare('LOWER(pemeriksaanrad_jenis)', strtolower($_GET['term']), true);
                }
                //$criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->order = 'pemeriksaanrad_jenis';
                if (isset($_GET['idPemeriksaan'])){
                    $criteria->compare('pemeriksaanrad_id', $_GET['idPemeriksaan']);
                }
                $models = PemeriksaanradM::model()->findAll($criteria);
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->pemeriksaanrad_jenis." ".$model->pemeriksaanrad_nama;
                    $returnVal[$i]['value'] = $model->pemeriksaanrad_id;
                }

                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        
        public function actionJenisPemeriksaanlab()
        {
            if (Yii::app()->request->isAjaxRequest) {
                $criteria = new CDbCriteria;
                $criteria->compare('LOWER(jenispemeriksaanlab_nama)',strtolower($_GET['term']), true);
                $criteria->order = 'jenispemeriksaanlab_nama';
                $models = JenispemeriksaanlabM::model()->findAll($criteria);
                foreach ($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach ($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $returnVal[$i]['label'] = $model->jenispemeriksaanlab_nama;
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
        }
        
        public function actionObatUnitDosis()
	{
            if(Yii::app()->request->isAjaxRequest)
            {
                $criteria = new CDbCriteria();
                $criteria->compare('LOWER(obatalkes_nama)', strtolower($_GET['term']), true);
                $criteria->compare('obatalkes_id', $_GET['idObat']);
                $criteria->addCondition('obatalkes_farmasi = TRUE');
                $criteria->addCondition('obatalkes_aktif = true');
                $criteria->order = 'obatalkes_nama';
                $criteria->limit = 5;
                $models = ObatalkesM::model()->with('sumberdana')->findAll($criteria);
                $persenjual = $this->persenJualRuangan();
                $format = new MyFormatter();
                foreach($models as $i=>$model)
                {
                    $attributes = $model->attributeNames();
                    foreach($attributes as $j=>$attribute) {
                        $returnVal[$i]["$attribute"] = $model->$attribute;
                    }
                    $qtyStok = StokobatalkesT::getJumlahStok($model->obatalkes_id, Yii::app()->user->getState('ruangan_id'));
                    $returnVal[$i]['label'] = $model->obatalkes_kode." - ".$model->obatalkes_nama." - Jumlah Stok ".$qtyStok;
                    $returnVal[$i]['value'] = $model->obatalkes_nama;
                    $returnVal[$i]['obatalkes_nama'] = $model->obatalkes_kode." - ".$model->obatalkes_nama;
                    $returnVal[$i]['satuankecil_id'] = $model->satuankecil_id;
                    $returnVal[$i]['sumberdana_id'] = $model->sumberdana_id;                        
                    $returnVal[$i]['harganetto'] = $model->harganetto;                        
                    $returnVal[$i]['hargajual'] = $model->hargajual;                        
                    $returnVal[$i]['sumberdana_id'] = $model->sumberdana_id;                        
                    $returnVal[$i]['qtyStok'] = $qtyStok;
                }
                echo CJSON::encode($returnVal);
            }
            Yii::app()->end();
	}
        /*
         * end obatUnitDosis
         */
        
}