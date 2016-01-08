<?php
class RinciantagihanpasienpenunjangPJVController extends MyAuthController{
    /**
        * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
        * using two-column layout. See 'protected/views/layouts/column2.php'.
    */
	public $layout='//layouts/column1';
        public $defaultAction = 'admin';

	public function actionIndex()
	{
            
            $model=new PJPasienmasukpenunjangV('searchRincian');
            $format = new MyFormatter();
            $model->tgl_awal = date("Y-m-d");
            $model->tgl_akhir = date("Y-m-d");
            $model->unsetAttributes();  // clear any default values

            if(isset($_GET['PJPasienmasukpenunjangV'])){
                $model->attributes=$_GET['PJPasienmasukpenunjangV'];
                $format = new MyFormatter();
                $model->tgl_awal = $format->formatDateTimeForDb($_GET['PJPasienmasukpenunjangV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['PJPasienmasukpenunjangV']['tgl_akhir']);
                $model->statusBayar = $_GET['PJPasienmasukpenunjangV']['statusBayar'];

            }

            $this->render('index',array(
                    'model'=>$model,'format'=>$format
            ));
	}
        
        public function actionRincian($id){
            $model = new PJRinciantagihanpasienpenunjangV('search');
            $this->layout = '//layouts/iframe';
            $data['judulLaporan'] = 'Rincian Tagihan Pasien';
            $modPendaftaran = PJPendaftaranT::model()->findByPk($id);
            $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$id));
            if(empty($modPenunjang)){
                $criteria = new CDbCriteria;
                $criteria->with = array('pasienadmisi');
                $criteria->compare('pasienadmisi.pendaftaran_id', $id);
                $criteria->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $criteria->addCondition('pembayaranpelayanan_id is null and tindakansudahbayar_id is null');
                $modPenunjang = PasienmasukpenunjangT::model()->find($criteria);
            }
            $modRincian = PJRinciantagihanpasienpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $id,'ruangan_id'=>Yii::app()->user->getState('ruangan_id')), array('order'=>'ruangan_id'));
            
            $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
            $this->render('rincian', array('modPenunjang'=>$modPenunjang,'modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data));
        }

	
        public function actionPrint()
        {
            $id = $_REQUEST['id'];
            $modPendaftaran = PJPendaftaranT::model()->findByPk($id);
            $modRincian = PJRinciantagihanpasienpenunjangV::model()->findAllByAttributes(array('pendaftaran_id' => $id, 'ruangan_id' => Yii::app()->user->getState('ruangan_id')), array('order'=>'ruangan_id'));
            $modPenunjang = PasienmasukpenunjangT::model()->findByAttributes(array('pendaftaran_id'=>$id));
            $data['nama_pegawai'] = LoginpemakaiK::model()->findByPK(Yii::app()->user->id)->pegawai->nama_pegawai;
            $data['judulLaporan']='Data Rincian Tagihan Pasien';
            $caraPrint=$_REQUEST['caraPrint'];
            if($caraPrint=='PRINT') {
                $this->layout='//layouts/printWindows';
                $this->render('rincian', array('modPenunjang'=>$modPenunjang,'modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint));
                //$this->render('rincian',array('model'=>$model,'judulLaporan'=>$judulLaporan,'caraPrint'=>$caraPrint));
            }
            else if($caraPrint=='EXCEL') {
                $this->layout='//layouts/printExcel';
                $this->render('rincian',array('modPenunjang'=>$modPenunjang,'modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint));
            }
            else if($_REQUEST['caraPrint']=='PDF') {
                $ukuranKertasPDF = Yii::app()->user->getState('ukuran_kertas');                  //Ukuran Kertas Pdf
                $posisi = Yii::app()->user->getState('posisi_kertas');                           //Posisi L->Landscape,P->Portait
                $mpdf = new MyPDF('',$ukuranKertasPDF); 
                $mpdf->useOddEven = 2;  
                $stylesheet = file_get_contents(Yii::getPathOfAlias('webroot.css') . '/bootstrap.css');
                $mpdf->WriteHTML($stylesheet,1);  
                $style = '<style>.control-label{float:left; text-align: right; width:140px;font-size:12px; color:black;padding-right:10px;  }</style>';
                $mpdf->WriteHTML($style, 1);  
                $mpdf->AddPage($posisi,'','','','',15,15,15,15,15,15);
                $mpdf->WriteHTML($this->renderPartial('rincian',array('modPenunjang'=>$modPenunjang,'modPendaftaran'=>$modPendaftaran, 'modRincian'=>$modRincian, 'data'=>$data, 'caraPrint'=>$caraPrint),true));
                $mpdf->Output();
            }                       
        }
}

?>
