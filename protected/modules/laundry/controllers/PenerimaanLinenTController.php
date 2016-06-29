<?php
class PenerimaanLinenTController extends MyAuthController {
	public $layout='//layouts/column1';
	public $penerimaanLinen = false;
	public $penerimaanLinenDet = true;
	
	public $path_view = 'laundry.views.penerimaanLinenT.';
	
	public function actionIndex($id = null){
		$format = new MyFormatter;
                $model = new LAPenerimaanlinenT;
		$modPengajuanDetail = array();
                //load header
		$modPengajuan = LAPengperawatanlinenT::model()->findByPk($id);
                if (!empty($modPengajuan)) {
                    $modRuangan = RuanganM::model()->findByAttributes(array('ruangan_id'=>$modPengajuan->ruangan_id),'ruangan_aktif = true');
                    $model->pengperawatanlinen_no = $modPengajuan->pengperawatanlinen_no;
                    $model->pengperawatanlinen_id = $modPengajuan->pengperawatanlinen_id;
                    $model->instalasi_nama = $modRuangan->instalasi->instalasi_nama;
                    $model->ruangan_nama = $modRuangan->ruangan_nama;
                    $model->ruangan_id = $modRuangan->ruangan_id;
                    $model->keterangan_penerimaanlinen = $modPengajuan->keterangan_pengperawatanlinen;
                    $modPengajuanDetail = LAPengperawatanlinendetT::model()->findAllByAttributes(array('pengperawatanlinen_id'=>$modPengajuan->pengperawatanlinen_id));
                }
                
                $p = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                if (!empty($p)) {
                    $model->pegmenerima_id = $p->pegawai_id;
                    $model->pegawaimenerima_nama = $p->nama_pegawai;
                }
                
		$model->nopenerimaanlinen = MyGenerator::noPenerimaanLinen();
		
		// load detail
		
		
                
                
		$modDetails = array();
		if (isset($_POST['LAPenerimaanlinenT'])){
            $transaction = Yii::app()->db->beginTransaction();
            try {
				$modPenerimaan = new LAPenerimaanlinenT;
				$modPenerimaan->attributes = $_POST['LAPenerimaanlinenT'];
				$modPenerimaan->ruangan_id = Yii::app()->user->ruangan_id;
				$modPenerimaan->tglpenerimaanlinen = $format->formatDateTimeForDb($_POST['LAPenerimaanlinenT']['tglpenerimaanlinen']);
				$modPenerimaan->create_time = date("Y-m-d H:i:s");
				$modPenerimaan->create_loginpemakai_id = Yii::app()->user->id;
				$modPenerimaan->create_ruangan = Yii::app()->user->ruangan_id;
				if (empty($modPenerimaan->pengperawatanlinen_id)) $modPenerimaan->pengperawatanlinen_id = $id;
						if($modPenerimaan->save()){
							$this->penerimaanLinen = true;
								if(count($_POST['LAPengperawatanlinendetT']) > 0){
								   foreach($_POST['LAPengperawatanlinendetT'] AS $i => $postPengajuanDet){
									    $modDetail = new LAPenerimaanlinendetailT;
										$modDetail->attributes = $postPengajuanDet;
										$modDetail->linen_id = $postPengajuanDet['linen_id'];
										$modDetail->jenisperawatanlinen = $postPengajuanDet['jenisperawatan'];
										$modDetail->keterangan_penerimaanlinen = $postPengajuanDet['keterangan_pengperawatan'];
										$modDetail->penerimaanlinen_id = $modPenerimaan->penerimaanlinen_id;
										$modDetail->save();
										if($modDetail->save()) {
											$this->penerimaanLinenDet &= true;
										} else {
											$this->penerimaanLinenDet &= false;
										}
								   }
								}
						}
					if($this->penerimaanLinen && $this->penerimaanLinenDet){
						$transaction->commit();
						$this->redirect(array('index','id'=>$id,'penerimaanlinen_id'=>$modPenerimaan->penerimaanlinen_id,'sukses'=>1));
					}else{
						$transaction->rollback();
						Yii::app()->user->setFlash('error',"Data Penerimaan Linen gagal disimpan !");
					}
            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Data Penerimaan Linen gagal disimpan ! ".MyExceptionMessage::getMessage($e,true));
            }
				
		}
		
		$this->render($this->path_view.'index',array(
			'model'=>$model, 'format'=>$format, 'modPengajuanDetail'=>$modPengajuanDetail
		));
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
	
	public function actionAutocompletePegawaiMerima()
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
        
        /*
	 * untuk mencari pengajuan perawatan linen
	 */
	public function actionAutocompletePengLinen()
	{
		if(Yii::app()->request->isAjaxRequest) {
			$criteria = new CDbCriteria();
			$criteria->compare('LOWER(t.pengperawatanlinen_no)', strtolower($_GET['term']), true);
			$criteria->join = 'left join penerimaanlinen_t p on p.pengperawatanlinen_id = t.pengperawatanlinen_id';
                        $criteria->order = 't.tglpengperawatanlinen';
                        $criteria->addCondition('p.pengperawatanlinen_id is null');
			$models = LAPengperawatanlinenT::model()->findAll($criteria);
			foreach($models as $i=>$model)
			{
				$attributes = $model->attributeNames();
				foreach($attributes as $j=>$attribute) {
					$returnVal[$i]["$attribute"] = $model->$attribute;
				}
				$returnVal[$i]['label'] = $model->pengperawatanlinen_no." - ".MyFormatter::formatDateTimeForUser($model->tglpengperawatanlinen);
				$returnVal[$i]['value'] = $model->pengperawatanlinen_id;
			}

			echo CJSON::encode($returnVal);
		}
		Yii::app()->end();
	}
        
        public function actionLoadFormPengLinen()
	{
		if(Yii::app()->request->isAjaxRequest) {
                    $id = $_POST['id'];
                    $modPengajuan = LAPengperawatanlinenT::model()->findByPk($id);
                    if (!empty($modPengajuan)) {
                        $res = array('main'=>null, 'det'=>'');
                        $modRuangan = RuanganM::model()->findByAttributes(array('ruangan_id'=>$modPengajuan->ruangan_id),'ruangan_aktif = true');
                        $res['pengperawatanlinen_no'] = $modPengajuan->pengperawatanlinen_no;
                        $res['pengperawatanlinen_id'] = $modPengajuan->pengperawatanlinen_id;
                        $res['instalasi_nama'] = $modRuangan->instalasi->instalasi_nama;
                        $res['ruangan_nama'] = $modRuangan->ruangan_nama;
                        $res['ruangan_id'] = $modRuangan->ruangan_id;
                        $res['keterangan_penerimaanlinen'] = $modPengajuan->keterangan_pengperawatanlinen;
                        $modPengajuanDetail = LAPengperawatanlinendetT::model()->findAllByAttributes(array('pengperawatanlinen_id'=>$modPengajuan->pengperawatanlinen_id));
                        
                        foreach ($modPengajuanDetail as $i=>$detail) {
                            $res['det'] .= $this->renderPartial('_rowLinen', array('detail'=>$detail, 'i'=>$i), true);
                        }
                        echo CJSON::encode($res);
                    }
		}
		Yii::app()->end();
	} 
	
	
	/**
     * untuk print data pengajuan perawatan
     */
    public function actionPrint($penerimaanlinen_id,$caraPrint = null) 
    {
        $format = new MyFormatter;    
        $modPenerimaanLinen = LAPenerimaanlinenT::model()->findByPk($penerimaanlinen_id);     
        $modPenerimaanLinenDetail = LAPenerimaanlinendetailT::model()->findAllByAttributes(array('penerimaanlinen_id'=>$penerimaanlinen_id));

        $judul_print = 'Penerimaan Linen';
		$deskripsi = $format->formatDateTimeForUser($modPenerimaanLinen->tglpenerimaanlinen);
        $caraPrint = isset($_REQUEST['caraPrint']) ? $_REQUEST['caraPrint'] : null;
        if($caraPrint=='PRINT') {
            $this->layout='//layouts/printWindows';
        	$this->render('Print',array('format'=>$format,'judul_print'=>$judul_print,'deskripsi'=>$deskripsi,'modPenerimaanLinen'=>$modPenerimaanLinen, 'modPenerimaanLinenDetail'=>$modPenerimaanLinenDetail, 'caraPrint'=>$caraPrint));
		}
        else if($caraPrint=='EXCEL') {
            $this->layout='//layouts/printExcel';
        	$this->render('Print',array('format'=>$format,'judul_print'=>$judul_print,'deskripsi'=>$deskripsi,'modPenerimaanLinen'=>$modPenerimaanLinen, 'modPenerimaanLinenDetail'=>$modPenerimaanLinenDetail, 'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('Print',array('format'=>$format,'judul_print'=>$judul_print,'deskripsi'=>$deskripsi,'modPenerimaanLinen'=>$modPenerimaanLinen, 'modPenerimaanLinenDetail'=>$modPenerimaanLinenDetail, 'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
    } 
	
    /**
    * menampilkan rencana anggaran pengeluaran detail
    * @return row table 
    */
    public function actionLoadFormLine()
    {
        if(Yii::app()->request->isAjaxRequest) { 
            $noregisterlinen = $_POST['noregisterlinen'];
            $linen_id = $_POST['linen_id'];
            $jenisperawatan = $_POST['jenisperawatan'];
            $keterangan_pengperawatan = $_POST['keterangan_pengperawatan'];
						
            $format = new MyFormatter();
			$modLinen = LALinenM::model()->findByPk($linen_id);
            $modDetail = new LAPenerimaanlinendetailT;
            $modDetail->linen_id = $modLinen->linen_id;;
            $modDetail->jenisperawatanlinen = $jenisperawatan;
            $modDetail->keterangan_penerimaanlinen = $keterangan_pengperawatan;
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
	
        
}