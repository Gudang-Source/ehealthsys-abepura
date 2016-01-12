<?php

class InformasiFormulirStockOpnameObatAlkesController extends MyAuthController
{
        public $defaultAction ='index';
		public $path_view ='gudangFarmasi.views.informasiFormulirStockOpnameObatAlkes.';
        
        public function actionIndex()
        {
            $model=new GFInformasiformuliropnameV;
            $format = new MyFormatter();
            $model->tgl_awal  = date('Y-m-d');
            $model->tgl_akhir = date('Y-m-d');
            
            if(isset($_GET['GFInformasiformuliropnameV'])){
                $model->attributes=$_GET['GFInformasiformuliropnameV'];
                $model->tgl_awal  = $format->formatDateTimeForDb($_GET['GFInformasiformuliropnameV']['tgl_awal']);
                $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GFInformasiformuliropnameV']['tgl_akhir']);
            }
            $this->render($this->path_view.'index',array('format'=>$format,'model'=>$model));
		}
		
		/**
		 * menampilkan url untuk print karena nama controller tiap modul yg extend berbeda
		 * @return type
		 */
		public function getUrlPrint(){
			return $this->createUrl("formulirStockOpnameObatAlkes/Print");
		}
		/**
		 * menampilkan url untuk action stock opname karena nama controller tiap modul yg extend berbeda
		 * @return type
		 */
		public function getUrlStokOpname(){
			return $this->createUrl("StockOpnameObatAlkes/Index");
		}
        
}