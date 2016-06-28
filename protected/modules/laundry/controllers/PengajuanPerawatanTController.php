<?php

class PengajuanPerawatanTController extends MyAuthController {
	public $layout='//layouts/column1';
	public $path_view = 'laundry.views.pengajuanPerawatanT.';
	public $pengPeratawan = false;
	public $pengPeratawanDet = true;
	
	public function actionIndex(){
		$format = new MyFormatter;
		$model = new LAPengperawatanlinenT;
		$model->pengperawatanlinen_no = MyGenerator::noPengPerawatanLinen();
		$modDetails = array();
		$modDetail = new LAPengperawatanlinendetT;
		if (isset($_POST['LAPengperawatanlinenT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
				$model->attributes = $_POST['LAPengperawatanlinenT'];
				$model->ruangan_id = Yii::app()->user->ruangan_id;
				$model->tglpengperawatanlinen = $format->formatDateTimeForDb($_POST['LAPengperawatanlinenT']['tglpengperawatanlinen']);
				$model->create_time = date("Y-m-d H:i:s");
				$model->create_loginpemakai_id = Yii::app()->user->id;
				$model->create_ruangan = Yii::app()->user->ruangan_id;
						if($model->save()){
							$this->pengPeratawan = true;
								if(count($_POST['LAPengperawatanlinendetT']) > 0){
								   foreach($_POST['LAPengperawatanlinendetT'] AS $i => $postPengPerLinenDet){
									   $modDetails[$i] = $this->simpanPengPerawatanLinenDet($model,$postPengPerLinenDet);
								   }
								}
						}
					if($this->pengPeratawan && $this->pengPeratawanDet){
						$transaction->commit();
						$this->redirect(array('index','pengperawatanlinen_id'=>$model->pengperawatanlinen_id,'sukses'=>1));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data Pengajuan Perawatan Linen gagal disimpan !");
					}
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Pengajuan Perawatan Linen gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
				
		}
		
		$this->render($this->path_view.'index',array(
			'model'=>$model, 'format'=>$format
		));
	}
	
     /**
     * simpan LAPengperawatanlinendetT
     * @param type $model
     * @param type $post
     * @return LAPengperawatanlinendetT
     */
    public function simpanPengPerawatanLinenDet($model ,$post){
        $format = new MyFormatter();
        $modDetail = new LAPengperawatanlinendetT;
        $modDetail->attributes = $post;
		$modDetail->pengperawatanlinen_id = $model->pengperawatanlinen_id;
        if($modDetail->save()) {
			$this->pengPeratawanDet &= true;
        } else {
            $this->pengPeratawanDet &= false;
        }
        return $modDetail;
    }
	
	
	public function actionAutocompletePegawaiMengetahui()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = LAPegawaiV::model()->findAll($criteria);
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
	
	public function actionAutocompletePegawaiMengajukan()
    {
        if(Yii::app()->request->isAjaxRequest) {
			$returnVal = array();
            $criteria = new CDbCriteria();
            $criteria->compare('LOWER(nama_pegawai)', strtolower($_GET['term']), true);
            $criteria->order = 'nama_pegawai';
            $criteria->limit = 5;
            $models = LAPegawaiV::model()->findAll($criteria);
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
	
	/*
	 * untuk mencari linen melalui autocomplete
	 */
	public function actionAutocompleteLinen()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(t.namalinen)', strtolower($_GET['term']), true);
			$criteria->order = 't.linen_id';
			$models = LALinenM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->namalinen;
				$returnVal[$i]['value'] = $model->linen_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
	/*
	 * untuk mencari register linen melalui autocomplete
	 */
	public function actionAutocompleteRegisterLinen()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(t.noregisterlinen)', strtolower($_GET['term']), true);
			$criteria->order = 't.linen_id';
			$models = LALinenM::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->noregisterlinen;
				$returnVal[$i]['value'] = $model->linen_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
	
    /**
    * menampilkan rencana anggaran pengeluaran detail
    * @return row table 
    */
    public function actionLoadFormLine()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            //$noregisterlinen = $_POST['noregisterlinen'];
            $linen_id = $_POST['linen_id'];
            $jenisperawatan = $_POST['jenisperawatan'];
            $keterangan_pengperawatan = $_POST['keterangan_pengperawatan'];
						
            $format = new MyFormatter();
			$modLinen = LALinenM::model()->findByPk($linen_id);
            $modDetail = new LAPengperawatanlinendetT;
            $modDetail->linen_id = $modLinen->linen_id;;
            $modDetail->jenisperawatan = $jenisperawatan;
            $modDetail->keterangan_pengperawatan = $keterangan_pengperawatan;
            echo CJSON::encode(array(
                'status'=>'create_form', 
                'form'=>$this->renderPartial($this->path_view.'_rowLinen', array(
                        'format'=>$format,
						'modLinen'=>$modLinen,
                        'modDetail'=>$modDetail,
                    ), 
                true))
            );
            exit;  
        }
    }
	
	/**
     * untuk print data pengajuan perawatan
     */
    public function actionPrint($pengperawatanlinen_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPengPerawataninen = LAPengperawatanlinenT::model()->findByPk($pengperawatanlinen_id);     
        $modPengPerawataninenDetail = LAPengperawatanlinendetT::model()->findAllByAttributes(array('pengperawatanlinen_id'=>$pengperawatanlinen_id));

        $judul_print = 'Pengajuan Perawatan Linen';
		$deskripsi = $format->formatDateTimeForUser($modPengPerawataninen->tglpengperawatanlinen);
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        	$this->render($this->path_view.'Print',array('format'=>$format,'judul_print'=>$judul_print,'deskripsi'=>$deskripsi,'modPengPerawataninen'=>$modPengPerawataninen, 'modPengPerawataninenDetail'=>$modPengPerawataninenDetail, 'caraPrint'=>$caraPrint));
		}
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        	$this->render($this->path_view.'Print',array('format'=>$format,'judul_print'=>$judul_print,'deskripsi'=>$deskripsi,'modPengPerawataninen'=>$modPengPerawataninen, 'modPengPerawataninenDetail'=>$modPengPerawataninenDetail, 'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view.'Print',array('format'=>$format,'judul_print'=>$judul_print,'deskripsi'=>$deskripsi,'modPengPerawataninen'=>$modPengPerawataninen, 'modPengPerawataninenDetail'=>$modPengPerawataninenDetail, 'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    } 
        
}
