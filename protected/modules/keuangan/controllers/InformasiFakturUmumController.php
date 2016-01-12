<?php
class InformasiFakturUmumController extends MyAuthController
{
	public function actionIndex()
	{
        $modFaktur = new KUInformasifakturumumV('search');
        $format = new MyFormatter();
        $modFaktur->tgl_awal=date('Y-m-d');
        $modFaktur->tgl_akhir=date('Y-m-d');
        
        if(isset($_GET['KUInformasifakturumumV'])){
            $modFaktur->attributes=$_GET['KUInformasifakturumumV'];
            $modFaktur->tgl_awal = $format->formatDateTimeForDB($_GET['KUInformasifakturumumV']['tgl_awal']);
            $modFaktur->tgl_akhir = $format->formatDateTimeForDB($_GET['KUInformasifakturumumV']['tgl_akhir']);
            
            if($_GET['berdasarkanJatuhTempo']>0){
                $modFaktur->tgl_awalJatuhTempo = $format->formatDateTimeForDB($_GET['KUInformasifakturumumV']['tgl_awalJatuhTempo']);
                $modFaktur->tgl_akhirJatuhTempo = $format->formatDateTimeForDB($_GET['KUInformasifakturumumV']['tgl_akhirJatuhTempo']);
            } else {
                $modFaktur->tgl_awalJatuhTempo = null;
                $modFaktur->tgl_akhirJatuhTempo = null;
            }

        }
        
        $this->render('index', array('modFaktur'=>$modFaktur));
	}
	
	public function actionDetailsFaktur($pembelianbarang_id)
	{
		
		if(isset($_GET['caraPrint']) && ($_GET['caraPrint'] =="PRINT")){
			$this->layout='//layouts/printWindows';
		}else{
			$this->layout='//layouts/iframe';
		}
		$modFakturPembelian = KUInformasifakturumumV::model()->findByAttributes(array('pembelianbarang_id'=>$pembelianbarang_id));

		$this->render('detailsFaktur',array('modFakturPembelian'=>$modFakturPembelian));

	}

}