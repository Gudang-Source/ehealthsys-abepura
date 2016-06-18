<?php

class InformasiRencKebBarangController extends MyAuthController
{
        public $defaultAction ='index';
        public $path_view = 'pengadaan.views.informasiRencKebBarang.';
        
        public function actionIndex()
        {
            $model=new ADInformasirenkebbarangV;
            $format = new MyFormatter();
            $model->tgl_awal =date('Y-m-d');
            $model->tgl_akhir =date('Y-m-d');
            
            
            if(isset($_GET['ADInformasirenkebbarangV'])){
                $model->attributes=$_GET['ADInformasirenkebbarangV'];
                $model->tgl_awal  = $format->formatDateTimeForDb($_GET['ADInformasirenkebbarangV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['ADInformasirenkebbarangV']['tgl_akhir']);
            }
            $this->render($this->path_view.'index',array('format'=>$format,'model'=>$model));
        }
        
        // Aksi untuk membatalkan rencana kebutuhan Barang
        public function actionDelete()
        {
                //if(!Yii::app()->user->checkAccess(Params::DEFAULT_DELETE)){throw new CHttpException(401,Yii::t('mds','You are prohibited to access this page. Contact Super Administrator'));}
                if(Yii::app()->request->isPostRequest)
                {
                    $id = $_POST['id'];
                    $transaction = Yii::app()->db->beginTransaction();
                         try {
                                $detail=ADRenkebbarangdetT::model()->deleteAll('renkebbarang_id=:renkebbarang_id', array(':renkebbarang_id'=>$id));
                                $model=  ADRenkebbarangT::model()->deleteAll('renkebbarang_id=:renkebbarang_id', array(':renkebbarang_id'=>$id));
                                $transaction->commit();
                                if (Yii::app()->request->isAjaxRequest)
                                {
                                    echo CJSON::encode(array(
                                        'status'=>'proses_form', 
                                        'div'=>"<div class='flash-success'>Data berhasil dihapus.</div>",
                                        ));
                                    exit;               
                                }
                                if(!isset($_GET['ajax']))
                                $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('index'));
                            } 
                        catch (Exception $e)
                            {
                                $transaction->rollback();
                                Yii::app()->user->setFlash('error', '<strong>Gagal!</strong> Data gagal dihapus.');
                            }   
                    
                }
                else
                        throw new CHttpException(400,'Invalid request. Please do not repeat this request again.');
        }
		

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
	
	public function actionRincian($renkebbarang_id)
	{
		$this->layout='//layouts/iframe';
		$format = new MyFormatter();
		$model = ADInformasirenkebbarangV::model()->findByAttributes(array('renkebbarang_id'=>$renkebbarang_id));
                $modHead = ADRenkebbarangT::model()->findByPk($renkebbarang_id);		
                $modDetails = ADRenkebbarangdetT::model()->findAllByAttributes(array('renkebbarang_id'=>$renkebbarang_id));
                $judulLaporan = 'Rencana Kebutuhan Barang Umum';
                        $deskripsi = 'Tanggal '.MyFormatter::formatDateTimeId($model->renkebbarang_tgl);
                $this->render($this->path_view.'_rincian', array(
                                        'format'=>$format,
                                        'model'=>$model,
                                        'judulLaporan'=>$judulLaporan,
                                        'deskripsi'=>$deskripsi,
                                        'modHead'=>$modHead,
                                        'modDetails'=>$modDetails
                        ));
		
	}
        
}