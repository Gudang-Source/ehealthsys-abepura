<?php
Yii::import('laboratorium.models.*');
Yii::import('laboratorium.controllers.RinciantagihanpasienpenunjangVController');
class RinciantagihanpasienpenunjangBSVController extends RinciantagihanpasienpenunjangVController{
   public function actionIndex()
    {
        $model=new BSPasienMasukPenunjangV('searchRincian');
        $format = new MyFormatter();
        $model->tgl_awal = date("Y-m-d");
        $model->tgl_akhir = date("Y-m-d");
        $model->unsetAttributes();  // clear any default values

        if(isset($_GET['BSPasienMasukPenunjangV'])){
            $model->attributes=$_GET['BSPasienMasukPenunjangV'];
            $format = new MyFormatter();
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['BSPasienMasukPenunjangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['BSPasienMasukPenunjangV']['tgl_akhir']);
            $model->statusBayar = $_GET['BSPasienMasukPenunjangV']['statusBayar'];

        }

        $this->render('laboratorium.views.rinciantagihanpasienpenunjangV.index',array(
                'model'=>$model,'format'=>$format
        ));
    }
}

?>
