<?php

class ReevaluasiasetTController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout = '//layouts/column1';
	public $defaultAction = 'index';


	public function actionIndex()
	{
		$model = new MAReevaluasiasetT;
		$models = new MAReevaluasiasetdetailT;
		$format = new MyFormatter();
		
		if(isset($_POST['MAReevaluasiasetT']))
		{
                        $trans = Yii::app()->db->beginTransaction();
                        $ok = true;
                        
			$model->attributes = $_POST['MAReevaluasiasetT'];
			$model->create_loginpemakai_id = Yii::app()->user->id;
			$model->update_loginpemakai_id = Yii::app()->user->id;
			$model->create_time = date('Y-m-d');
			$model->update_time = date('Y-m-d');
			$model->reevaluasiaset_no = $_POST['MAReevaluasiasetT']['reevaluasiaset_no'];
			$model->pegawaimengetahui_id =$_POST['pegawai_id'];
			$model->pegawaimenyetujui_id =$_POST['pegawai_id_'];
			$model->reevaluasiaset_tgl =  $format->formatDateTimeForDb($_POST['MAReevaluasiasetT']['reevaluasiaset_tgl']);
			$model->create_ruangan = Yii::app()->user->getState('ruangan_id');
                        
                        // var_dump($model->validate(), $model->errors); die;
                        
                        if ($model->validate()) {
                            $ok = $ok && $model->save();
                        } else $ok = false;
			
                        $selisih = 0;
                        
                        // var_dump($_POST);
                        
                        if (isset($_POST['det'])) {
                            foreach ($_POST['det'] as $item) {
                                $models = new ReevaluasiasetdetailT;
                                
                                $models->barang_id = $item['barang_id'];
				$models->invtanah_id = $item['invtanah'];
				$models->invgedung_id = $item['invgedung'];
				$models->invperalatan_id = $item['invperalatan'];
				$models->invjalan_id = $item['invjalan'];
				$models->invasetlain_id = $item['invasetlain'];
				$models->reevaluasiaset_umurekonomis = $item['ue'];
				$models->reevaluasiaset_nilaibuku = $item['nb'];
				$models->reevaluasiaset_hargaperolehan = $item['hrgperolehan'];
				$models->reevaluasiaset_selisihreevaluasi = $item['selisih'];
				$models->reevaluasiaset_id = $model->reevaluasiaset_id;
                                
                                // var_dump($models->attributes);
                                
                                if($models->validate()){
					$ok = $ok && $models->save();
                                        $selisih += $models->reevaluasiaset_selisihreevaluasi;
				} else $ok = false;
                            }
                        }
                        
                        /*
			foreach ($_POST as $key=>$data){
				$models->barang_id = $_POST['barang_id'];
				$models->invtanah_id = $_POST['invtanah'];
				$models->invgedung_id = $_POST['invgedung'];
				$models->invperalatan_id = $_POST['invperalatan'];
				$models->invjalan_id = $_POST['invjalan'];
				$models->invasetlain_id = $_POST['invasetlain'];
				$models->reevaluasiaset_umurekonomis = $_POST['ue'];
				$models->reevaluasiaset_nilaibuku = $_POST['nb'];
				$models->reevaluasiaset_hargaperolehan = $_POST['hrgperolehan'];
				$models->reevaluasiaset_selisihreevaluasi = $_POST['selisih'];
				$models->reevaluasiaset_id = $model->reevaluasiaset_id;
                                
				if($models->validate()){
					$ok = $ok && $models->save();
                                        $selisih += $models->reevaluasiaset_selisihreevaluasi;
				} else $ok = false;
			}
                         * 
                         */
                        
                        $model->reevaluasiaset_totalselisih = $selisih;
                        $model->save();
                        
                        // var_dump($model->attributes, $ok); die;
                        
                        if ($ok) {
                            $trans->commit();
                            Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
                            $this->redirect(array('index','id'=>$model->reevaluasiaset_id,'sukses'=>1));
                        } else {
                            $trans->rollback();
                            Yii::app()->user->setFlash('error', '<strong>Error!</strong> Data gagal disimpan.');
                            $this->redirect(array('index'));
                        }
		}

		$this->render('index',array(
			'model'=>$model,
		));
	}


	/**
	 * Mencetak data
	 */
	public function actionPrint()
	{
		$model = new BarangV();
		$judulLaporan='Reevaluasi Aset';
		$caraPrint = $_REQUEST['caraPrint'];
		if($caraPrint=='PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($caraPrint=='EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
		}
		else if($_REQUEST['caraPrint']=='PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas'); //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas'); //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('',$ukuranKertasPDF); 
			$mpdf->useOddEven = 2;  
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet,1);  
			$mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
			$mpdf->WriteHTML($this->renderPartial('Print',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint),true));
			$mpdf->Output();
		}
	}
}
