<?php

class InformasiStockOpnameObatAlkesController extends MyAuthController
{
        public $defaultAction ='index';
        public $path_view ='gudangFarmasi.views.informasiStockOpnameObatAlkes.';
        
        public function actionIndex()
        {
            $model=new GFInformasistokopnameV;
            $format = new MyFormatter();
            $model->tgl_awal  = date('Y-m-d');
            $model->tgl_akhir = date('Y-m-d');
            
            if(isset($_GET['GFInformasistokopnameV'])){
                $model->attributes=$_GET['GFInformasistokopnameV'];
                $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasistokopnameV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasistokopnameV']['tgl_akhir']);
            }
            $this->render($this->path_view.'index',array('format'=>$format,'model'=>$model));
	}
	/**
	 * menampilkan link untuk print detail stock opname
	 * @return type
	 */
	public function getUrlPrint(){
		return $this->createUrl("stockOpnameObatAlkes/print");
	}
}