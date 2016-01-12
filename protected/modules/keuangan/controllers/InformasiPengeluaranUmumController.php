<?php

class InformasiPengeluaranUmumController extends MyAuthController
{
	public $path_view = 'keuangan.views.informasiPengeluaranUmum.';
	public function actionIndex()
	{
            $modPengeluaran = new KUPengeluaranumumT();
            $format = new MyFormatter();
            $modPengeluaran->tgl_awal=date('d M Y 00:00:00');
            $modPengeluaran->tgl_akhir=date('d M Y H:i:s');
		
            if(isset($_GET['KUPengeluaranumumT'])){
                $modPengeluaran->attributes=$_GET['KUPengeluaranumumT'];
                $modPengeluaran->tgl_awal = $format->formatDateTimeForDb($_GET['KUPengeluaranumumT']['tgl_awal']);
                $modPengeluaran->tgl_akhir = $format->formatDateTimeForDb($_GET['KUPengeluaranumumT']['tgl_akhir']);
            }
            
            $this->render($this->path_view. 'index', array('modPengeluaran'=>$modPengeluaran));
	}
        
	public function actionReturPengeluaranUmum()
	{
//            $this->render('index', array('modPengeluaran'=>$modPengeluaran));
	}   
	
	public function actionDetailPengeluaranUmum($pengeluaranumum_id)
	{
		if(isset($_GET['caraPrint'])){
			$this->layout='//layouts/printWindows';
		}else{
			$this->layout = '//layouts/iframe';
		}
		$modPengeluaran = KUPengeluaranumumT::model()->findByPk($pengeluaranumum_id);
		if(!count($modPengeluaran)>0){
			echo "<h4>Data pengeluran umum tidak ditemukan!!</h4>";exit;
		}
		$modUraianKeluarUmum = UraiankeluarumumT::model()->findAllByAttributes(array('pengeluaranumum_id'=>$pengeluaranumum_id));
		$this->render($this->path_view. 'detailPengeluaran',array(
					'modUraianKeluarUmum'=>$modUraianKeluarUmum,
					'modPengeluaran'=>$modPengeluaran,
				));
	}        

}