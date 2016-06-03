<?php
class InformasiEvaluasiAskepController extends MyAuthController {
	public $path_view = 'asuhanKeperawatan.views.informasiEvaluasiAskep.';
	
	public function actionIndex()
	{
		$format = new MyFormatter();
		$model = new ASInfoevaluasiaskepV('search');
		$model->tgl_awal=date("Y-m-d");
		$model->tgl_akhir=date("Y-m-d");
//		$model->instalasi_id = Params::INSTALASI_ID_RI;
		
		if(isset($_GET['ASInfoevaluasiaskepV']))
		{
			$model->attributes=$_GET['ASInfoevaluasiaskepV'];
			$model->tgl_awal = $format->formatDateTimeForDb($_GET['ASInfoevaluasiaskepV']['tgl_awal']);
			$model->tgl_akhir = $format->formatDateTimeForDb($_GET['ASInfoevaluasiaskepV']['tgl_akhir']);
			$model->ruangan_id = $_GET['ASInfoevaluasiaskepV']['ruangan_id'];
		}
		
		$this->render($this->path_view.'index',array(
			'format'=>$format,
			'model'=>$model
		));
	}
	
	public function actionDetail($evaluasiaskep_id = null){
		$this->layout = "//layouts/iframe";
		
		$model = ASInfoevaluasiaskepV::model()->findByAttributes(array('evaluasiaskep_id'=>$evaluasiaskep_id));
		$model->attributes = $model;
		$modImpl = ASInfoimplementasiaskepV::model()->findByAttributes(array('implementasiaskep_id'=>$model->implementasiaskep_id));
		$modPasien = ASInfopasienmasukkamarV::model()->findByAttributes(array('no_pendaftaran' => $modImpl->no_pendaftaran));
		$detail = new ASEvaluasiaskepdetT;
		$criteria = new CDbCriteria();
		$criteria->addCondition('evaluasiaskep_id ='.$evaluasiaskep_id);
		$modDetail = new CActiveDataProvider($detail, array(
			'criteria' => $criteria,
		));
		
        $this->render($this->path_view.'_detail', array(
			'model' => $model,
			'modImpl' => $modImpl,
			'modPasien' => $modPasien, 
			'modDetail' => $modDetail
        ));
	}
	
	public function actionPrintDetail() {
		$model = ASEvaluasiaskepT::model()->findByPk($_REQUEST['evaluasiaskep_id']);
		$model->attributes = $model;
		$modImplementasi = ASInfoimplementasiaskepV::model()->findByAttributes(array('implementasiaskep_id' => $model->implementasiaskep_id));
		$modPasien = ASInfopasienmasukkamarV::model()->findByAttributes(array('no_pendaftaran' => $modImplementasi->no_pendaftaran));

		$modDetail = new ASEvaluasiaskepdetT;
		$judulLaporan = 'Evaluasi Asuhan Keperawatan';
		$caraPrint = $_REQUEST['caraPrint'];
		if ($caraPrint == 'PRINT') {
			$this->layout = '//layouts/printWindows';
			$this->render($this->path_view . 'PrintDetail', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($caraPrint == 'EXCEL') {
			$this->layout = '//layouts/printExcel';
			$this->render($this->path_view . 'PrintDetail', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint));
		} else if ($_REQUEST['caraPrint'] == 'PDF') {
			$ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');   //Ukuran Kertas Pdf
			$posisi = Yii::app()->user->getState('posisi_kertas');   //Posisi L->Landscape,P->Portait
			$mpdf = new MyPDF('', $ukuranKertasPDF);
			$mpdf->useOddEven = 2;
			$stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
			$mpdf->WriteHTML($stylesheet, 1);
			$mpdf->AddPage($posisi, '', '', '', '', 15, 15, 15, 15, 15, 15);
			$mpdf->WriteHTML($this->renderPartial($this->path_view . 'PrintDetail', array('model' => $model, 'modPasien' => $modPasien, 'modDetail' => $modDetail, 'judulLaporan' => $judulLaporan, 'caraPrint' => $caraPrint), true));
			$mpdf->Output();
		}
	}
	
	/**
     * Mengatur dropdown ruangan
     * @param type $encode jika = true maka return array jika false maka set Dropdown 
     * @param type $model_nama
     * @param type $attr
     */
    public function actionSetDropdownRuangan($encode=false,$model_nama='',$attr='')
    {
        if(Yii::app()->request->isAjaxRequest) {
            $instalasi_id = null;
            if($model_nama !=='' && $attr == ''){
                $instalasi_id = $_POST["$model_nama"]['instalasi_id'];
            }
             else if ($model_nama == '' && $attr !== '') {
                $instalasi_id = $_POST["$attr"];
            }
             else if ($model_nama !== '' && $attr !== '') {
                $instalasi_id = $_POST["$model_nama"]["$attr"];
            }
            $models = null;
            $models = CHtml::listData(ASRuanganM::getRuanganByInstalasi($instalasi_id),'ruangan_id','ruangan_nama');

            if($encode){
                echo CJSON::encode($models);
            } else {
                echo CHtml::tag('option', array('value'=>''),CHtml::encode('-- Pilih --'),true);
                if(count($models) > 0){
                    foreach($models as $value=>$name){
                        echo CHtml::tag('option', array('value'=>$value),CHtml::encode($name),true);
                    }
                }
            }
        }
        Yii::app()->end();
    }
	
	
}