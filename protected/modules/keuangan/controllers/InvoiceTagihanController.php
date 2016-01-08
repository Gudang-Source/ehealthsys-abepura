<?php
class InvoiceTagihanController extends MyAuthController{
	public $succesSave = false;
	public $pesan = "succes";
	public $invoicesimpan = false;
	public $invoicedetailsimpan = true;
	public $invoicedisposisisimpan = true;
	
	public function actionIndex($invoicetagihan_id = null){
		$modInvoiceTagihan = new KUInvoicetagihanT;
		$modInvoiceTagihan->total_tagihan = 0;
//		$modInvoiceTagihan->invoicetagihan_tgl = date('Y-m-d H:i:s');
//		$modInvoiceTagihan->tgl_verfikasi_tagihan = date('Y-m-d H:i:s');
		$modInvoiceTagDetail[0] = new KUInvoicetagdetailT;
		$modInvoiceTagDetail[0]->total_tagdetail = 0;
		$modInvoiceDisposisi[0] = new KUInvoicedisposisiT;
		$modInvoiceDisposisi[0]->total_disposisi = 0;
		
		if(!empty($invoicetagihan_id)){
			$modInvoiceTagihan = KUInvoicetagihanT::model()->findByPk($invoicetagihan_id);
			//$modInvoiceTagDetail = KUInvoicetagdetailT::model()->findByAttributes(array('invoicetagihan_id'=>$invoicetagihan_id));
			//$modInvoiceDisposisi = KUInvoicedisposisiT::model()->findByAttributes(array('invoicetagihan_id'=>$invoicetagihan_id));
		}
		
		if(isset($_POST['KUInvoicetagihanT'])){
			$transaction = Yii::app()->db->beginTransaction();
			try {
				$modInvoiceTagihan = $this->saveInvoiceTagihan($_POST['KUInvoicetagihanT']);
				if($this->invoicesimpan){
					if(isset($_POST['KUInvoicetagdetailT'])){
						$modInvoiceTagDetail = $this->saveInvoiceTagDetail($_POST['KUInvoicetagdetailT'], $modInvoiceTagihan);
					}
					if(isset($_POST['KUInvoicedisposisiT'])){
						$modInvoiceDisposisi = $this->saveInvoiceDisposisi($_POST['KUInvoicedisposisiT'], $modInvoiceTagihan);
					}
//				}
//				if($this->succesSave){
					$transaction->commit();
					Yii::app()->user->setFlash('success',"Data berhasil disimpan");
					$sukses = 1;
					$this->redirect(array('index','invoicetagihan_id'=>$modInvoiceTagihan->invoicetagihan_id, 'sukses'=>$sukses));
					$modInvoiceTagihan->isNewRecord = false;
				} else {
					$transaction->rollback();
					Yii::app()->user->setFlash('error',"Data gagal disimpan ");
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error',"Data gagal disimpan ".MyExceptionMessage::getMessage($exc,true));
			}
		}
		$this->render('index',array(
			'modInvoiceTagihan'=>$modInvoiceTagihan,
			'modInvoiceTagDetail'=>$modInvoiceTagDetail,
			'modInvoiceDisposisi'=>$modInvoiceDisposisi
				));
		
	}
	
	protected function saveInvoiceTagihan($postInvoiceTagihan){
		$modInvoiceTagihan = new KUInvoicetagihanT;
		$format = new MyFormatter();
		$modInvoiceTagihan->attributes = $postInvoiceTagihan;
		$modInvoiceTagihan->tgl_verfikasi_tagihan = $format->formatDateTimeForDb($postInvoiceTagihan['tgl_verfikasi_tagihan']);
		$modInvoiceTagihan->ruangan_id = Yii::app()->user->getState('ruangan_id');
		$modInvoiceTagihan->create_time = date('Y-m-d H:i:s');
		$modInvoiceTagihan->create_loginpemekai_id = Yii::app()->user->id;
		$modInvoiceTagihan->create_ruangan = Yii::app()->user->getState('ruangan_id');
			if($modInvoiceTagihan->save()){
				$this->invoicesimpan = true;
			} else {
				$this->invoicesimpan = false;
				$this->pesan = $modInvoiceTagihan->getErrors();
			}
		return $modInvoiceTagihan;
	}
	
	protected function saveInvoiceTagDetail($arrPostInvoiceTagDetail, $modInvoiceTagihan){
		$format =new MyFormatter();
		$modInvoiceTagDetail = array();
		for($i=0;$i<count($arrPostInvoiceTagDetail);$i++){
			if(strlen($arrPostInvoiceTagDetail[$i]['uraian_tagdetail']) > 0)
			{
				$modInvoiceTagDetail[$i] = new KUInvoicetagdetailT;
				$modInvoiceTagDetail[$i]->attributes = $arrPostInvoiceTagDetail[$i];
				$modInvoiceTagDetail[$i]->total_tagdetail = $format->formatNumberForDb($arrPostInvoiceTagDetail[$i]['total_tagdetail']);
				$modInvoiceTagDetail[$i]->invoicetagihan_id = $modInvoiceTagihan->invoicetagihan_id;
				if($modInvoiceTagDetail[$i]->save())
				{
					$this->invoicedetailsimpan = true;
				}else{
					$this->invoicedetailsimpan = false;
					$this->pesan = $modInvoiceTagDetail[$i]->getErrors();
				}
			}
		}
		return $modInvoiceTagDetail;
	}
	
	protected function saveInvoiceDisposisi($arrPostInvoiceDisposisi, $modInvoiceTagihan){
		$format = new MyFormatter();
		$modInvoiceDisposisi = array();
		for($i=0;$i<count($arrPostInvoiceDisposisi);$i++){
			if(strlen($arrPostInvoiceDisposisi[$i]['uraian_disoposisi']) > 0)
			{
				$modInvoiceDisposisi[$i] = new KUInvoicedisposisiT;
				$modInvoiceDisposisi[$i]->attributes = $arrPostInvoiceDisposisi[$i];
				$modInvoiceDisposisi[$i]->total_disposisi = $format->formatNumberForDb($arrPostInvoiceDisposisi[$i]['total_disposisi']);
				$modInvoiceDisposisi[$i]->invoicetagihan_id = $modInvoiceTagihan->invoicetagihan_id;
				if($modInvoiceDisposisi[$i]->save())
				{
					$this->invoicedisposisisimpan = true;
				}else{
					$this->invoicedisposisisimpan = false;
					$this->pesan = $modInvoiceTagDetail[$i]->getErrors();
				}
			}
		}
		return $modInvoiceDisposisi;
	}
	
	public function actionAutocompleteVerifikator()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$format = new MyFormatter;
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(t.nama_pegawai)', strtolower($_GET['term']), true);
			$criteria->order = 't.pegawai_id';
			$criteria->limit = 5;
			$models = PegawaiV::model()->findAll($criteria);

			if(count($models) > 0){
				foreach($models as $i=>$model)
				{
					$attributes = $model->attributeNames();
					foreach($attributes as $j=>$attribute) {
						$returnVal[$i]["$attribute"] = $model->$attribute;
					}
					$returnVal[$i]['label'] = $model->namalengkap;
					$returnVal[$i]['namalengkap'] = $model->namalengkap;
					$returnVal[$i]['pegawai_id'] = $model->pegawai_id;
				}
			}
			else{
				$returnVal =null;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
	public function actionPrint($invoicetagihan_id,$caraPrint = null) 
	{
		$format = new MyFormatter;    
		$modInvoiceTagihan = KUInvoicetagihanT::model()->findByPk($invoicetagihan_id);
		
		//pencarian detail invoice
//		$criteria2 = new CDbCriteria();
//		$criteria2->select = "t.*, obatalkes_m.obatalkes_id, obatalkes_m.obatalkes_nama, supplier_m.supplier_id,"
//				. "supplier_m.supplier_nama, obatsupplier_m.obatsupplier_id, obatsupplier_m.obatalkes_id, obatsupplier_m.supplier_id,"
//				. "satuankecil_m.satuankecil_id, satuankecil_m.satuankecil_nama";
//
//		$criteria2->join = 'LEFT JOIN obatalkes_m ON t.obatalkes_id=obatalkes_m.obatalkes_id
//							LEFT JOIN satuankecil_m ON t.satuankecil_id=satuankecil_m.satuankecil_id
//							LEFT JOIN obatsupplier_m ON t.obatalkes_id=obatsupplier_m.obatalkes_id
//							LEFT JOIN supplier_m ON obatsupplier_m.supplier_id=supplier_m.supplier_id';
//		if(!empty($storeed_id)){
//			$criteria2->addCondition('t.storeed_id =' .$storeed_id);
//		}
		$modInvoiceTagDetail = KUInvoicetagdetailT::model()->findAllByAttributes(array('invoicetagihan_id'=>$invoicetagihan_id));
		$modInvoiceDisposisi = KUInvoicedisposisiT::model()->findAllByAttributes(array('invoicetagihan_id'=>$invoicetagihan_id));
		$judul_print = 'Invoice Tagihan';
		$caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
		if (isset($_GET['frame'])){
			$this->layout='//layouts/iframe';
		}
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
		}
		$this->render('Print', array(
				'format'=>$format,
				'judul_print'=>$judul_print,
				'modInvoiceTagihan'=>$modInvoiceTagihan,
				'modInvoiceTagDetail'=>$modInvoiceTagDetail,
				'modInvoiceDisposisi'=>$modInvoiceDisposisi,
				'caraPrint'=>$caraPrint
		));
	} 
}
?>

