<?php

class PemeliharaanAsetTMAController extends MyAuthController {
	
	public $layout='//layouts/column1';
	public $path_view = 'manajemenAset.views.PemeliharaanAsetTMA.';
	public $defaultAction = 'index';
	public $pemeliharaantersimpan = false;
    public $pemeliharaandetailtersimpan = true;
	
	 public function actionIndex($pemeliharaanaset_id = null){
    	$format = new MyFormatter();
		$modPemeliharaan = new MAPemeliharaanasetT;		
		$modPemeliharaanDetail = new MAPemeliharaanasetdetailT('search');
    	$modPemeliharaanAset = new MAPemeliharaanasetT;
    	$modPemeliharaanAset->pemeliharaanaset_tgl = date('Y-m-d H:i:s');
    	$modPemeliharaanAset->pemeliharaanaset_no = '-Otomatis-';
    	$modPenyimpananPemeliharaanDetail = array();
		$modPenyimpananPemeliharaanAset = array();
	    $asalaset = CHtml::listData(MAAsalasetM::getAsalAsetItems(),'asalaset_id','asalaset_nama');
		$kategoriaset = CHtml::listData(MABidangM::model()->getBidangItems(),'bidang_id','bidang_nama');

    	if(!empty($pemeliharaanaset_id)){
			$criteria = new CDbCriteria();
			$criteria->addCondition('t.pemeliharaanaset_id = '.$pemeliharaanaset_id);
			$criteria->select = 'pemeliharaanaset_t.*,t.*,barang_m.*,invperalatan_t.*,invgedung_t.*';
			$criteria->join = 
						'JOIN pemeliharaanaset_t ON pemeliharaanaset_t.pemeliharaanaset_id = t.pemeliharaanaset_id'
					. ' JOIN invasetlain_t ON invasetlain_t.invasetlain_id=t.invasetlain_id'
					. ' JOIN invgedung_t ON invgedung_t.invgedung_id=t.invgedung_id'
					. ' JOIN invjalan_t ON invjalan_t.invjalan_id=t.inventarisasi_id'
					. ' JOIN invperalatan_t ON invperalatan_t.invperalatan_id=t.invperalatan_id'
					. ' JOIN barang_m ON barang_m.barang_id = t.barang_id'
					;
            $modPenyimpananPemeliharaanDetail = MAPemeliharaanasetdetailT::model()->findAll($criteria);
        }

        if(isset($_POST['MAPemeliharaanasetT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
				$modPemeliharaanAset->attributes=$_POST['MAPemeliharaanasetT'];
				$modPemeliharaanAset->pemeliharaanaset_no = MyGenerator::noPemeliharaanAset();
				$modPemeliharaanAset->pemeliharaanaset_tgl=$format->formatDateTimeForDb($_POST['MAPemeliharaanasetT']['pemeliharaanaset_tgl']);
				$modPemeliharaanAset->pemeliharaanaset_ket = $_POST['MAPemeliharaanasetT']['pemeliharaanaset_ket'];
				$modPemeliharaanAset->pegmengetahui_id = $_POST['MAPemeliharaanasetT']['pegmengetahui_id'];
				$modPemeliharaanAset->pegpetugas1_id = $_POST['MAPemeliharaanasetT']['pegpetugas1_id'];
				$modPemeliharaanAset->pegpetugas2_id = $_POST['MAPemeliharaanasetT']['pegpetugas2_id'];
				$modPemeliharaanAset->create_time = date('Y-m-d H:i:s');
				$modPemeliharaanAset->create_loginpemakai_id = Yii::app()->user->id;
				$modPemeliharaanAset->create_ruangan = Yii::app()->user->ruangan_id;
				if($modPemeliharaanAset->save()){
					$this->pemeliharaantersimpan = true;					
					if (isset($_POST['MAPemeliharaanasetdetailT'])) {
						if(count($_POST['MAPemeliharaanasetdetailT']) > 0){
						   foreach($_POST['MAPemeliharaanasetdetailT'] AS $i => $detail){
							   if($detail['checklist'] == 1){
								   	$modPenyimpananPemeliharaanDetail[$i] = $this->simpanPenyimpananPemeliharaanDetail($modPemeliharaanAset,$detail);					
							   }
						   }
						}
					}
				}else{
					$this->pemeliharaantersimpan = false;
				}
                if($this->pemeliharaantersimpan && $this->pemeliharaandetailtersimpan){
                    $transaction->commit();
                    $modPemeliharaanAset->isNewRecord = FALSE;
                    $this->redirect(array('index','pemeliharaanaset_id'=>$modPemeliharaanAset->pemeliharaanaset_id,'sukses'=>1));
                }else{
                    $transaction->rollback();
                    Yii::app()->user->setFlash('error',"Data Penyimpanan Pemeliharaan Aset gagal disimpan !");
                }
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Penyimpanan Pemeliharaan Aset gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
        }

    	$this->render($this->path_view.'index',array(
            'format'=>$format,
			'modPemeliharaan'=>$modPemeliharaan,
            'modPemeliharaanDetail'=>$modPemeliharaanDetail,
            'modPemeliharaanAset'=>$modPemeliharaanAset,
            'modPenyimpananPemeliharaanDetail'=>$modPenyimpananPemeliharaanDetail,
			'modPenyimpananPemeliharaanAset'=>$modPenyimpananPemeliharaanAset,
            'asalaset'=>$asalaset,
            'kategoriaset'=>$kategoriaset,
        ));
    }
	//penyimpanan detail pemeliharaan aset
	public function simpanPenyimpananPemeliharaanDetail($modPemeliharaanAset ,$detail){
        $format = new MyFormatter();
        $modPenyimpananPemeliharaanDetail = new MAPemeliharaanasetdetailT;
        $modPenyimpananPemeliharaanDetail->attributes = $detail;
        $modPenyimpananPemeliharaanDetail->pemeliharaanaset_id = $modPemeliharaanAset->pemeliharaanaset_id;

        if($modPenyimpananPemeliharaanDetail->validate()) { 
            $modPenyimpananPemeliharaanDetail->save();		
			$this->pemeliharaandetailtersimpan &= true;
        } else {
            $this->pemeliharaandetailtersimpan &= false;
        }
        return $modPenyimpananPemeliharaanDetail;
    }
	//search data barang_v
	public function actionPencarianPenerimaan()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            parse_str($_REQUEST['data'],$data_parsing);
			$form = "";
            $pesan = "";
			$modPemeliharaandetail = '';
            $format = new MyFormatter();
			
			if(isset($data_parsing['MAPemeliharaanasetdetailT'])){
				$kategori_aset = isset($data_parsing['MAPemeliharaanasetdetailT']['kategori_aset']) ? $data_parsing['MAPemeliharaanasetdetailT']['kategori_aset'] : null;
				$asal_aset = isset($data_parsing['MAPemeliharaanasetdetailT']['asal_aset']) ? $data_parsing['MAPemeliharaanasetdetailT']['asal_aset'] : null;
				$kode_inventaris = isset($data_parsing['MAPemeliharaanasetdetailT']['kode_inventaris']) ? $data_parsing['MAPemeliharaanasetdetailT']['kode_inventaris'] : "";
				$kodeaset = isset($data_parsing['MAPemeliharaanasetdetailT']['kode_aset']) ? $data_parsing['MAPemeliharaanasetdetailT']['kode_aset'] : null;
				$namaaset = isset($data_parsing['namaBarang']) ? $data_parsing['namaBarang'] : null;
				
				$criteria = new CDbCriteria();
				$criteria->select="t.*";
				if(!empty($kategori_aset)){
					$criteria->addCondition('t.bidang_id = '.$kategori_aset);
				}
				if(!empty($kode_inventaris)){
					$criteria->addCondition('t.barang_id = '.$kode_inventaris);					
				}
				
				if(!empty($kodeaset)){
					$criteria->compare('LOWER(t.barang_kode)',strtolower($kodeaset),true);
				}
				if(!empty($namaaset)){
					$criteria->compare('LOWER(t.barang_nama)',strtolower($namaaset),true);
				}
				
				if(!empty($asal_aset)){
					$criteria->addCondition('t.asalaset_inventarisasiasetlain_id = '.$asal_aset);
					$criteria->addCondition('t.asalaset_inventarisasitanah_id = '.$asal_aset);
					$criteria->addCondition('t.asalaset_inventarisasiperalatan_id = '.$asal_aset);
					$criteria->addCondition('t.asalaset_inventarisasigedung_id = '.$asal_aset);
					$criteria->addCondition('t.asalaset_inventarisasijalan_id = '.$asal_aset);									
				}
				

				$modPemeliharaan = MABarangV::model()->findAll($criteria);
				
				if(count($modPemeliharaan) > 0 ){
					foreach($modPemeliharaan as $i=>$detail){
						$modPemeliharaandetail = new MAPemeliharaanasetdetailT;
						$modPemeliharaandetail->invgedung_id = isset($detail->invgedung_id) ? $detail->invgedung_id : '';
						$modPemeliharaandetail->invasetlain_id = isset($detail->invasetlain_id) ? $detail->invasetlain_id : '';
						$modPemeliharaandetail->inventarisasi_id = isset($detail->invjalan_id) ? $detail->invjalan_id : '';
						$modPemeliharaandetail->invperalatan_id = isset($detail->invperalatan_id) ? $detail->invperalatan_id : '';
						$modPemeliharaandetail->barang_id = isset($detail->barang_id) ? $detail->barang_id : '';
						$modPemeliharaandetail->asal_aset = isset($detail->asal_aset) ? $detail->asal_aset : '';
						$modPemeliharaandetail->kategori_aset = isset($detail->bidang_nama) ? $detail->bidang_nama : '';
						$modPemeliharaandetail->kode_aset = isset($detail->barang_kode) ? $detail->barang_kode : '';
						$modPemeliharaandetail->nama_aset = isset($detail->barang_nama) ? $detail->barang_nama : '';
						$modPemeliharaandetail->pemeliharaanaset_id = isset($detail->pemeliharaanaset_id) ? $detail->pemeliharaanaset_id : '';
						$modPemeliharaandetail->pemeliharaanasetdet_tgl = date('Y-m-d H:i:s');
						$modPemeliharaandetail->kondisiaset = isset($detail->kondisiaset) ? $detail->kondisiaset : '';
						$modPemeliharaandetail->keteranganaset = isset($detail->keteranganaset) ? $detail->keteranganaset : '';
						$modPemeliharaandetail->checklist = 1;
						$form .= $this->renderPartial($this->path_view.'_rowBarang', array('detail'=>$modPemeliharaandetail), true);
					}
				}else{
					$pesan = "Data Pemeliharaan Aset Tidak Ada!";
				}				
			}
			      
            echo CJSON::encode(array('form'=>$form, 'pesan'=>$pesan));
            Yii::app()->end(); 
        }
    }
	//print data detail pemeliharaan aset
	public function actionPrint($pemeliharaanaset_id,$caraprint = null) 
    {
        $this->layout='//layouts/printWindows';
        if (isset($_GET['frame'])){
            $this->layout='//layouts/iframe';
        }else if($caraprint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        }
        $format = new MyFormatter;    
        $modPemeliharaan = MAPemeliharaanasetT::model()->findByPk($pemeliharaanaset_id);     
        $criteria = new CDbCriteria();
		$criteria->addCondition('pemeliharaanaset_id = '.$pemeliharaanaset_id);		
		$modPemeliharaanasetDetail = MAPemeliharaanasetdetailT::model()->findAll($criteria);

        $judul_print = 'Pemeliharaan Aset';
        
        $this->render($this->path_view.'Print', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'modPemeliharaan'=>$modPemeliharaan,
			'modPemeliharaanasetDetail'=>$modPemeliharaanasetDetail,
			'caraprint'=>$caraprint
        ));
    } 	
}

