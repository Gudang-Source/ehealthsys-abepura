
<?php

class RencanaKebBarangController extends MyAuthController
{

	public $layout = '//layouts/column1';
	public $defaultAction = 'index';
    public $path_view = 'pengadaan.views.rencanaKebBarang.';
    public $rencanakebutuhantersimpan = true;

	
    public function actionIndex($renkebbarang_id = null){
        $format = new MyFormatter();
        $modRencanaKebBarang = new ADRenkebbarangT;
        $modRencanaKebBarang->renkebbarang_tgl = date('Y-m-d H:i:s');
		$modRencanaKebBarang->renkebbarang_no ='-Otomatis-';
        $modDetails = array();
        if(!empty($rencanakebfarmasi_id)){
            $modRencanaKebBarang= ADRenkebbarangT::model()->findByPk($renkebbarang_id);
            $modRencanaKebBarang->pegmengetahui_id = !empty($modRencanaKebBarang->pegmengetahui_id) ? $modRencanaKebBarang->pegmengetahui_id : "";
            $modRencanaKebBarang->pegmenyetujui_id = !empty($modRencanaKebBarang->pegmenyetujui_id) ? $modRencanaKebBarang->pegmenyetujui_id : "";
            
            $modDetails = ADRenkebbarangdetT::model()->findAllByAttributes(array('renkebbarang_id'=>$modRencanaKebBarang->renkebbarang_id));
        }
        if(isset($_POST['ADRenkebbarangT'])){
            // var_dump($_POST); die;
            $transaction = Yii::app()->db->beginTransaction();
            try {
                    $modRencanaKebBarang->attributes=$_POST['ADRenkebbarangT'];
					
                                                $pegawai = Yii::app()->user->getState('pegawai_id');
                                                if (empty($pegawai)) $pegawai = '0';
						$modRencanaKebBarang->renkebbarang_no = MyGenerator::noPerencanaanKebutuhanBarang();
						$modRencanaKebBarang->ruangan_id = Yii::app()->user->getState('ruangan_id');
						$modRencanaKebBarang->pegawai_id = $pegawai;
						$modRencanaKebBarang->renkebbarang_tgl=$format->formatDateTimeForDb($_POST['ADRenkebbarangT']['renkebbarang_tgl']);
						$modRencanaKebBarang->ro_barang_bulan = $_POST['ADRenkebbarangT']['ro_barang_bulan'];
					
						$modRencanaKebBarang->create_time = date('Y-m-d H:i:s');
						$modRencanaKebBarang->create_loginpemekai_id = Yii::app()->user->id;
						$modRencanaKebBarang->create_ruangan = Yii::app()->user->ruangan_id;
                                                // var_dump($modRencanaKebBarang->validate());
                                                // var_dump($modRencanaKebBarang->errors);
                                                // var_dump($modRencanaKebBarang->attributes);
					if($modRencanaKebBarang->save()){
                                                $this->rencanakebutuhantersimpan = true;
						if(count($_POST['ADRenkebbarangdetT']) > 0){
						   foreach($_POST['ADRenkebbarangdetT'] AS $i => $post){
							   $modDetails[$i] = $this->simpanRencanaKebutuhan($modRencanaKebBarang,$post);
						   }
						} else {
                                                    $this->rencanakebutuhantersimpan = false;
                                                }
                    }
                    //var_dump($this->rencanakebutuhantersimpan);
                    //die;
                if($this->rencanakebutuhantersimpan){
                    $transaction->commit();
                    $modRencanaKebBarang->isNewRecord = FALSE;
                    $this->redirect(array('index','renkebbarang_id'=>$modRencanaKebBarang->renkebbarang_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Rencana Kebutuhan gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Rencana Kebutuhan gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }
        
        $this->render($this->path_view.'index',array(
            'format'=>$format,
            'modRencanaKebBarang'=>$modRencanaKebBarang,
            'modDetails'=>$modDetails,
        ));
    }

    public function simpanRencanaKebutuhan($modRencanaKebBarang ,$post){
        $format = new MyFormatter();
        // var_dump($post);
        
        $modRencanaDetailKebBarang = new ADRenkebbarangdetT;
        $modRencanaDetailKebBarang->attributes = $post;
        $modRencanaDetailKebBarang->barang_id = $post['barang_id'];
	$modRencanaDetailKebBarang->renkebbarang_id = $modRencanaKebBarang->renkebbarang_id; //fake id
        $modRencanaDetailKebBarang->satuanbarangdet =$post['satuanbarangdet'];
	$modRencanaDetailKebBarang->jmlpermintaanbarangdet=$post['jmlpermintaanbarangdet'];;
        $modRencanaDetailKebBarang->harga_barangdet = $post['harga_barang'];
        $modRencanaDetailKebBarang->stokakhir_barangdet = 0; 
        //$modRencanaDetailKebBarang->minstok_barangdet = 0; 
        //$modRencanaDetailKebBarang->makstok_barangdet = 0; 
        
        
        //$modRencanaDetailKeb->hargatotalrenc = $modRencanaDetailKeb->jmlpermintaan * $modRencanaDetailKeb->harganettorenc;
        // var_dump($modRencanaDetailKebBarang->attributes); die;
        if($modRencanaDetailKebBarang->validate()) { 
            $modRencanaDetailKebBarang->save();
        } else {
            $this->rencanakebutuhantersimpan &= false;
        }
        return $modRencanaDetailKebBarang;
    }
	
   public function actionLoadFormRencanaKebutuhan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $barang_id = $_POST['idBarang'];
            $jumlah = $_POST['jumlah'];
            
            //$format = new MyFormatter();
            $modRencanaKebBarang = new ADRenkebbarangT;
            $modRencanaDetailKebBarang = new ADRenkebbarangdetT;
            $modBarang = ADBarangM::model()->findByPk($barang_id);            
			$modRencanaDetailKebBarang->harga_barang = $modBarang->barang_harganetto;
			$modRencanaDetailKebBarang->barang_id = $modBarang->barang_id;
            $modRencanaDetailKebBarang->minstok_barangdet = 0;
            $modRencanaDetailKebBarang->makstok_barangdet = 0;
            $modRencanaDetailKebBarang->stokakhir_barangdet = 0;
            $modRencanaDetailKebBarang->jmlpermintaanbarangdet = $jumlah;			
            $modRencanaDetailKebBarang->barang_nama = $modBarang->barang_nama;						
            $modRencanaDetailKebBarang->satuanbarangdet = $modBarang->barang_satuan;
			
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'form'=>$this->renderPartial($this->path_view.'_rowBarangRencanaKebutuhan', array(
                        'modRencanaKebBarang'=>$modRencanaKebBarang,
                        'modRencanaDetailKebBarang'=>$modRencanaDetailKebBarang,
                    ), 
                true))
            );
            exit;  
        }
    }

	public function actionAutocompletePegawaiMengetahui()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = ADPegawaiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
    
    public function actionAutocompletePegawaiMenyetujui()
    {
        if(Yii::app()->request->isAjaxRequest) {
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = ADPegawaiV::model()->findAll($criteria);
            foreach($models as $i=>$model)
            {
                $attributes = $model->attributeNames();
                foreach($attributes as $j=>$attribute) {
                    $returnVal[$i]["$attribute"] = $model->$attribute;
                }
                $returnVal[$i]['label'] = $model->gelardepan." ".$model->nama_pegawai." ".$model->gelarbelakang_nama;
                $returnVal[$i]['value'] = $model->pegawai_id;
            }

            echo CJSON::encode($returnVal);
        }
        Yii::app()->end();
    }
	
	/**
	 * untuk menampilkan barang dari autocomplete
	 */
	public function actionAutoCompleteBarang()
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
	
	/**
	 * Mencetak data rencana kebutuhan barang
	 * @param $renkebbarang
	 */
	public function actionPrint($renkebbarang_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $modRencanaKebBarang = ADRenkebbarangT::model()->findByPk($renkebbarang_id);     
        $criteria = new CDbCriteria();
		$criteria->addCondition('renkebbarang_id = '.$renkebbarang_id);		
		$modRencanaKebBarangDetail = ADRenkebbarangdetT::model()->findAll($criteria);

        $judul_print = 'Rencana Kebutuhan Barang';
        
        $this->render($this->path_view.'Print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'modRencanaKebBarang'=>$modRencanaKebBarang,
			'modRencanaKebBarangDetail'=>$modRencanaKebBarangDetail,
			'caraprint'=>$caraprint
        ));
    }
    
    public function actionSetHitungRO() {
		if (Yii::app()->request->isAjaxRequest) {
			$form = '';
			$pesan = '';
			
			$ruangan_id = Params::RUANGAN_ID_GUDANG_UMUM;
			$jumlah = 0;
			$lt = 0.5;
			$t = isset($_POST['ro_barang_bulan']) ? $_POST['ro_barang_bulan'] : null;
			$tgl_sekarang = date('Y-m-d');
			$tgl_ro = date("Y-m-d", strtotime("-".$t." months"));
			$modRencanaDetailKebBarang = new ADRenkebbarangdetT;
			
			$modBarang = ADBarangM::model()->findAll();
			if(count($modBarang) > 0){
				foreach ($modBarang as $i=>$barang){
					$minimal_stok = isset($barang->barang_min) ? $barang->barang_min : 0;
					$maksimal_stok = isset($barang->barang_max) ? $barang->barang_max : 0;
					$criteria = new CDbCriteria();
					
					$criteria->select = 'barang_id,sum(inventarisasi_qty_skrg) as inventarisasi_qty_skrg';
					$criteria->addCondition('barang_id = '.$barang->barang_id);
					$criteria->addCondition('ruangan_id = '.$ruangan_id);
					$criteria->group = 'barang_id';
					$criteria->order = 'inventarisasi_qty_skrg,barang_id ASC';
					$stok_barang = ADInventarisasiruanganT::model()->find($criteria);
					
					if(count($stok_barang) > 0){
						if($stok_barang->inventarisasi_qty_skrg <= $minimal_stok){
							$criteria2 = new CDbCriteria();
					
							$criteria2->select = 'barang_id,sum(inventarisasi_qty_out) as inventarisasi_qty_out';
							$criteria2->addBetweenCondition('DATE(tgltransaksi)',$tgl_ro,$tgl_sekarang);
							$criteria2->addCondition('barang_id = '.$barang->barang_id);
							$criteria2->addCondition('ruangan_id = '.$ruangan_id);
							$criteria2->group = 'barang_id';
							$criteria->order = 'inventarisasi_qty_out,barang_id ASC';
							$jumlah_barang_keluar = ADInventarisasiruanganT::model()->find($criteria2);
							
							if(count($jumlah_barang_keluar) > 0){
								if($jumlah_barang_keluar->inventarisasi_qty_out >= $maksimal_stok){
									$selisih_stok = $maksimal_stok - $stok_barang->inventarisasi_qty_skrg;
									$jumlah = $selisih_stok;
									$modRencanaDetailKebBarang->harga_barangdet = $barang->barang_harganetto;
									$modRencanaDetailKebBarang->barang_id = $barang->barang_id;
									$modRencanaDetailKebBarang->minstok_barangdet = isset($barang->barang_min) ? $barang->barang_min : 0;
									$modRencanaDetailKebBarang->makstok_barangdet = isset($barang->barang_max) ? $barang->barang_max : 0;
									$modRencanaDetailKebBarang->stokakhir_barangdet = isset($stok_barang->inventarisasi_qty_skrg) ? $stok_barang->inventarisasi_qty_skrg : 0;
									$modRencanaDetailKebBarang->jmlpermintaanbarangdet = $jumlah;
									$modRencanaDetailKebBarang->barang_nama = $barang->barang_nama;
									$modRencanaDetailKebBarang->satuanbarangdet = $barang->barang_satuan;
								}else{
									$jumlah = $jumlah_barang_keluar->inventarisasi_qty_out;
									$modRencanaDetailKebBarang->harga_barangdet = $barang->barang_harganetto;
									$modRencanaDetailKebBarang->barang_id = $barang->barang_id;
									$modRencanaDetailKebBarang->barang_nama = $barang->barang_nama;
									$modRencanaDetailKebBarang->minstok_barangdet = isset($barang->barang_min) ? $barang->barang_min : 0;
									$modRencanaDetailKebBarang->makstok_barangdet = isset($barang->barang_max) ? $barang->barang_max : 0;
									$modRencanaDetailKebBarang->stokakhir_barangdet = isset($stok_barang->inventarisasi_qty_skrg) ? $stok_barang->inventarisasi_qty_skrg : 0;
									$modRencanaDetailKebBarang->jmlpermintaanbarangdet = $jumlah;
									$modRencanaDetailKebBarang->barang_nama = $barang->barang_nama;
									$modRencanaDetailKebBarang->satuanbarangdet = $barang->barang_satuan;
								}
							}
							$form .=$this->renderPartial('_rowBarangRencanaKebutuhan', array('modRencanaDetailKebBarang'=>$modRencanaDetailKebBarang), true);
						}
					}				
				}	
			}else{
				$pesan = 'Data Barang tidak ditemukan.';
			}
			
			echo CJSON::encode(array('form' => $form, 'pesan' => $pesan, 'lead_time' => $lt));
		}
		Yii::app()->end();
	}
	
}
