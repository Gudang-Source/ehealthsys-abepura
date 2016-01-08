<?php

class PaketpelayananMController extends MyAuthController
{
    
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/column1';
	public $defaultAction = 'admin';
	public $path_view = 'sistemAdministrator.views.paketpelayananM.';

	/**
	 * Displays a particular model.
	 * @param integer $id the ID of the model to be displayed
	 */
	public function actionView($id)
	{
		$this->render($this->path_view.'view',array(
			'model'=>$this->loadModel($id),
		));
	}

	/**
	 * Creates a new model.
	 * If creation is successful, the browser will be redirected to the 'view' page.
	 */
	public function actionCreate()
	{
		$model=new SAPaketpelayananM;
        $kelas = 0;
        $modPaket = array();

		if(isset($_POST['SAPaketpelayananM']))
		{
			$model->attributes = $_POST['SAPaketpelayananM'];
			$modPaket = $this->validasiTabular($_POST['PaketpelayananM']);
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$success = 0;
				$list = CHtml::listData(PaketpelayananM::model()->findAllByAttributes(array('tipepaket_id'=>$model->tipepaket_id)),'paketpelayanan_id','paketpelayanan_id');
				foreach ($modPaket as $i=>$row){
					if ($row->save()){
						unset($list[$row->paketpelayanan_id]);
						$success++;
					}
				}
				if (count($list) > 0){
					foreach ($list as $hasil){
						PaketpelayananM::model()->deleteByPk($hasil);
					}
				}

//				if(count($list) > 0){
//					foreach($list AS $i => $detail){
//						$model=new PaketpelayananM;
//						if(!empty($detail['paketpelayanan_id'])){ 
//							$model=PaketpelayananM::model()->findByPk($detail['paketpelayanan_id']);
//						}
//						$model->attributes=$detail;
//						if($model->save()){
//							$sukses &= true;
//						}
//					}
//				}
				
				if ((count($modPaket) > 0) && ($success == count($modPaket))) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
					$this->redirect($this->createUrl('admin'));
				}
				else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
			}
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model, 'modPaket'=>$modPaket, 'kelas'=>$kelas
		));
	}
        
	protected function validasiTabular($data){
		$x = 0;
		foreach ($data as $i=>$row){
			if (!empty($row['paketpelayanan_id'])){
				$paket[$x] = PaketpelayananM::model()->findByPk($row['paketpelayanan_id']);
			}else{
				$paket[$x] = new PaketpelayananM();
			}
			$paket[$x]->attributes = $row;
			$paket[$x]->namatindakan = $row['namatindakan'];
			$paket[$x]->subsidiasuransi = floor($row['subsidiasuransi']);
			$paket[$x]->subsidipemerintah = floor($row['subsidipemerintah']);
			$paket[$x]->subsidirumahsakit = floor($row['subsidirumahsakit']);
			$paket[$x]->tarifpaketpel = floor($row['tarifpaketpel']);
			$paket[$x]->iurbiaya = floor($row['iurbiaya']);
			$paket[$x]->validate();

			$x++;
		}
		return $paket;
	}

	/**
	 * Updates a particular model.
	 * If update is successful, the browser will be redirected to the 'view' page.
	 * @param integer $id the ID of the model to be updated
	 */
	public function actionUpdate($id)
	{
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		$model=$this->loadModel($id);
		$model->ruangan_id = '';

		$modTipePaket = TipepaketM::model()->findByPk($model->tipepaket_id);
		$model->tarifpaketpel=$modTipePaket->tarifpaket;
		$model->subsidiasuransi = $modTipePaket->paketsubsidiasuransi;
		$model->subsidirumahsakit = $modTipePaket->paketsubsidirs;
		$model->subsidipemerintah = $modTipePaket->paketsubsidipemerintah;
		$model->iurbiaya = $modTipePaket->paketiurbiaya;
		$kelas = $modTipePaket->kelaspelayanan_id;
		$dataPaketPelayanan = PaketpelayananM::model()->findAllByAttributes(array('tipepaket_id'=>$model->tipepaket_id));
		// Uncomment the following line if AJAX validation is needed
		
                 //echo $jumlahUlang;exit();
		if(isset($_POST['SAPaketpelayananM']))
		{
			$model->attributes = $_POST['SAPaketpelayananM'];
			$modPaket = $this->validasiTabular($_POST['PaketpelayananM']);
			$dataPaketPelayanan = $modPaket;
			$transaction = Yii::app()->db->beginTransaction();
			try{
				$success = 0;
//                        SAPaketpelayananM::model()->deleteAllByAttributes(array('tipepaket_id'=>$model->tipepaket_id));
				$list = CHtml::listData(PaketpelayananM::model()->findAllByAttributes(array('tipepaket_id'=>$model->tipepaket_id)),'paketpelayanan_id','paketpelayanan_id');
				foreach ($modPaket as $i=>$row){
					if ($row->save()){
						unset($list[$row->paketpelayanan_id]);
						$success++;
					}
				}

				if (count($list) > 0){
					foreach ($list as $hasil){
						PaketpelayananM::model()->deleteByPk($hasil);
					}
				}

				if ((count($modPaket) > 0) && ($success == count($modPaket))) {
					$transaction->commit();
					Yii::app()->user->setFlash('success', "Data Berhasil Disimpan ");
					$this->redirect($this->createUrl('admin'));
				}
				else{
					$transaction->rollback();
					Yii::app()->user->setFlash('error', "Data gagal disimpan ");
				}
			} catch (Exception $exc) {
				$transaction->rollback();
				Yii::app()->user->setFlash('error', "Data gagal disimpan " . MyExceptionMessage::getMessage($exc, true));
			}
		}

		$this->render($this->path_view.'create',array(
			'model'=>$model, 'modPaket'=>$dataPaketPelayanan, 'kelas'=>$kelas,
		));
	}

	/**
	 * Deletes a particular model.
	 * If deletion is successful, the browser will be redirected to the 'admin' page.
	 * @param integer $id the ID of the model to be deleted
	 */
	public function actionDelete($id)
	{
		if(Yii::app()->request->isPostRequest)
		{
			SAPaketpelayananM::model()->deleteAllByAttributes(array('tipepaket_id'=>$id));

			if(!isset($_GET['ajax']))
				$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
		}
		else
			throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
	}

	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
		$dataProvider=new CActiveDataProvider('SAPaketpelayananM');
		$this->render($this->path_view.'index',array(
			'dataProvider'=>$dataProvider,
		));
	}

	/**
	 * Manages all models.
	 */
	public function actionAdmin()
	{
		$model=new SAPaketpelayananM('search');
		$modTipePaket=new SATipePaketM('search');
		
		if(isset($_GET['SATipePaketM'])){
			$modTipePaket->attributes=$_GET['SATipePaketM'];
		}
		if(isset($_GET['SAPaketpelayananM'])){
			$modTipePaket->tipepaket_nama=$_GET['SAPaketpelayananM']['tipepaketNama'];
		}

		$this->render($this->path_view.'admin',array(
			'model'=>$model,
			'modTipePaket'=>$modTipePaket,
		));
	}

	/**
	 * Returns the data model based on the primary key given in the GET variable.
	 * If the data model is not found, an HTTP exception will be raised.
	 * @param integer the ID of the model to be loaded
	 */
	public function loadModel($id)
	{
        $dataModel = SAPaketpelayananM::model()->findByAttributes(array('tipepaket_id'=>$id), array('limit'=>1));
		
		if($dataModel===null){
			$model = new SAPaketpelayananM();
			$model->tipepaket_id = $id;
		}else{
			$model=SAPaketpelayananM::model()->findByPk($dataModel->paketpelayanan_id);
			if($model===null){
				$model = new SAPaketpelayananM();
				$model->tipepaket_id = $id;
			}
		}
		return $model;
	}

	/**
	 * Performs the AJAX validation.
	 * @param CModel the model to be validated
	 */
	protected function performAjaxValidation($model)
	{
		if(isset($_POST['ajax']) && $_POST['ajax']==='sapaketpelayanan-m-form')
		{
			echo CActiveForm::validate($model);
			Yii::app()->end();
		}
	}
        
	/**
	 *Mengubah status aktif
	 * @param type $id 
	 */
	public function actionRemoveTemporary($id)
	{
		//if(!Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
		//SAKabupatenM::model()->updateByPk($id, array('kabupaten_aktif'=>false));
		//$this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
	}
        
	public function actionPrint()
	{
		$model= new SAPaketpelayananM;
		$modTipePaket=new SATipePaketM('search');
		if(isset($_GET['SATipePaketM'])){
			$modTipePaket->attributes=$_GET['SATipePaketM'];
		}
		$judulLaporan='Data Paket Pelayanan';
		$caraPrint=$_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout='//layouts/printWindows';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout='//layouts/printExcel';
			$this->render($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}                       
	}
		
	public function actionGetPaketPelayanan()
	{
		if(Yii::app()->request->isAjaxRequest) { 
			$tr = '';
			if (isset($_POST['tipePaket'])){
				$modPaketPelayanan = PaketpelayananM::model()->findAllByAttributes(array('tipepaket_id'=>$_POST['tipePaket']));
				if (count($modPaketPelayanan) > 0){
					$data['paket'] = 'Ada';
				}
				else {
					$data['paket'] = 'Tidak';
				}
			}else{
				$idTipePaket=$_POST['idTipePaket'];
				$idDaftarTindakan = $_POST['idDaftarTindakan'];
				$idTarifTindakan = $_POST['idTarifTindakan'];

				$idRuangan = isset($_POST['idRuangan']) ? $_POST['idRuangan'] : null;
				$modTipePaket = TipepaketM::model()->findByPk($idTipePaket);
				$modDaftarTindakan = DaftartindakanM::model()->findByPk($idDaftarTindakan);
				$namaRuangan = RuanganM::model()->findByPk($idRuangan)->ruangan_nama;
				$modPaketPelayanan = new PaketpelayananM;
				$modTarifTindakan = TariftindakanM::model()->findAllByAttributes(array('daftartindakan_id'=>$idDaftarTindakan, 'komponentarif_id'=> Params::KOMPONENTARIF_ID_TOTAL));
				$TarifTindakan = TariftindakanM::model()->findByPk($idTarifTindakan);

				$totaltarif = 0;
				foreach($modTarifTindakan as $row){
					$totaltarif += $row->harga_tariftindakan;
				}
				$modPaketPelayanan->tipepaket_id  = $idTipePaket;
				$modPaketPelayanan->daftartindakan_id = $idDaftarTindakan;
				$modPaketPelayanan->ruangan_id = $idRuangan;
				$tr .="<tr>
							<td>".CHtml::TextField('noUrut', '', array('class' => 'span1 noUrut', 'readonly' => TRUE)).
									CHtml::activeHiddenField($modPaketPelayanan, '['.$idDaftarTindakan.']tipepaket_id').
									CHtml::activeHiddenField($modPaketPelayanan, '['.$idDaftarTindakan.']daftartindakan_id').
									//CHtml::activeHiddenField($modPaketPelayanan, 'ruangan_id[]', array('value'=>$idRuangan)).
						"</td>
							<td>".$modTipePaket->tipepaket_nama . "</td>
							<td>".$modDaftarTindakan->daftartindakan_nama . "</td>
							<td>".CHtml::activeDropDownList($modPaketPelayanan, '['.$idDaftarTindakan.']ruangan_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class' => 'span2 ruangan', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
							<td>".CHtml::activeTextField($modPaketPelayanan, '['.$idDaftarTindakan.']namatindakan[]', array('value' => $modDaftarTindakan->daftartindakan_nama, 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"))."</td>
							<td>".CHtml::TextField('totaltarif[]', number_format($TarifTindakan->harga_tariftindakan, 0, '.',','), array('readonly'=>false, 'class' => 'span2 currency totalTarif numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>".CHtml::activeTextField($modPaketPelayanan, '['.$row->daftartindakan_id.']tarifpaketpel', array('parent'=>'SAPaketpelayananM_tarifpaketpel', 'class' => 'span2 tarifpaket currency', 'onblur' => 'tarifPaket(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>".CHtml::activeTextField($modPaketPelayanan, '['.$row->daftartindakan_id.']subsidiasuransi', array('parent'=>'SAPaketpelayananM_subsidiasuransi', 'class' => 'span2 subisidiAsuransi currency', 'onblur' => 'tarifAsuransi(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td class='cols_hide'>".CHtml::activeTextField($modPaketPelayanan, '['.$row->daftartindakan_id.']subsidipemerintah', array('parent'=>'SAPaketpelayananM_subsidipemerintah', 'class' => 'span1 subisidiPemerintah currency', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>".CHtml::activeTextField($modPaketPelayanan, '['.$row->daftartindakan_id.']subsidirumahsakit', array('parent'=>'SAPaketpelayananM_subsidirumahsakit',  'class' => 'span2 subisidiRS currency', 'onblur' => 'tarifRs(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>".CHtml::activeTextField($modPaketPelayanan, '['.$row->daftartindakan_id.']iurbiaya', array('readonly'=>true,'parent'=>'SAPaketpelayananM_iurbiaya', 'class' => 'span2 iurBiaya currency','onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
							<td>".CHtml::link("<i class='icon-remove'></i>", '', array('href'=>'', 'onclick'=>'remove2(this);return false;'))."</td>
						</tr>
						";

				$data['tr'] = $tr;
			}
			echo json_encode($data);
			Yii::app()->end();
		}
	}
	/*
	 * load data tipe paket pada database
	 */
    public function actionGetTipePaket()
    {
        if (Yii::app()->request->isAjaxRequest) {
            $idTipePaket = $_POST['idTipePaket'];
            $modTipePaket = TipepaketM::model()->findByPk($idTipePaket);
            $data['asuransi'] = $modTipePaket->paketsubsidiasuransi;
            $data['pemerintah'] = $modTipePaket->paketsubsidipemerintah;
            $data['rs'] = $modTipePaket->paketsubsidirs;
            $data['iurbiaya'] = $modTipePaket->paketiurbiaya;
            $data['kelaspelayanan_id'] = $modTipePaket->kelaspelayanan_id;
            $data['tarifpaketpel'] = $modTipePaket->tarifpaket;
            $modPaket = PaketpelayananM::model()->findAll('tipepaket_id = '.$idTipePaket);
            
            $tr = '';
            if (count($modPaket)>0){
                foreach ($modPaket as $i=>$row){
                    $modTarifTindakan = TariftindakanM::model()->findByAttributes(array('daftartindakan_id' => $row->daftartindakan_id, 'komponentarif_id'=>  6, 'kelaspelayanan_id'=>$modTipePaket->kelaspelayanan_id));
                
                    $tr .= "<tr>
                            <td>".CHtml::TextField('noUrut', ($i+1), array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
                                CHtml::activeHiddenField($row, '['.$row->daftartindakan_id.']tipepaket_id') .
                                CHtml::activeHiddenField($row, '['.$row->daftartindakan_id.']daftartindakan_id') .
                                CHtml::activeHiddenField($row, '['.$row->daftartindakan_id.']ruangan_id') .
                                CHtml::activeHiddenField($row, '['.$row->daftartindakan_id.']paketpelayanan_id') ."</td>
                            <td>".$row->tipepaket->tipepaket_nama . "</td>
                            <td>".$row->daftartindakan->daftartindakan_nama . "</td>
                            <td>".CHtml::activeDropDownList($row, '['.$row->daftartindakan_id.']ruangan_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class' => 'span2 ruangan', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']namatindakan', array( 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::TextField('totaltarif[]', $modTarifTindakan->harga_tariftindakan, array('readonly' => true, 'class' => 'span2 totalTarif', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']tarifpaketpel', array('parent'=>'SAPaketpelayananM_tarifpaketpel', 'class' => 'span1 tarifpaket numbersOnly', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']subsidiasuransi', array('parent'=>'SAPaketpelayananM_subsidiasuransi', 'class' => 'span1 subisidiAsuransi numbersOnly', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']subsidipemerintah', array('parent'=>'SAPaketpelayananM_subsidipemerintah', 'class' => 'span1 subisidiPemerintah numbersOnly', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']subsidirumahsakit', array('parent'=>'SAPaketpelayananM_subsidirumahsakit',  'class' => 'span1 subisidiRS numbersOnly', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']iurbiaya', array('parent'=>'SAPaketpelayananM_iurbiaya', 'class' => 'span1 iurBiaya numbersOnly', 'onblur' => 'sum(this);', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>

                            <td>".CHtml::link("<i class='icon-remove'></i>", '', array('href'=>'','onclick'=>'remove2(this);return false;'))."</td>
                        </tr>";
                }
            }
            $data['tr'] = $tr;

            echo json_encode($data);
            Yii::app()->end();
        }
    }	
}
