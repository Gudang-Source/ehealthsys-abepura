<?php
class InfoFormInventarisasiController extends MyAuthController{
	
	public $path_view = 'gudangUmum.views.infoFormInventarisasi.';
	
	public function actionIndex(){
		$format = new MyFormatter();
		$model = new GUInfoformulirinvbarangV('searchInformasi');
		
		$model->unsetAttributes();  // clear any default values
        $model->tgl_awal = date('Y-m-d');
        $model->tgl_akhir = date('Y-m-d');
		
		if(isset($_GET['GUInfoformulirinvbarangV'])){
			$model->attributes=$_GET['GUInfoformulirinvbarangV'];
            $model->tgl_awal = $format->formatDateTimeForDb($_GET['GUInfoformulirinvbarangV']['tgl_awal']);
            $model->tgl_akhir = $format->formatDateTimeForDb($_GET['GUInfoformulirinvbarangV']['tgl_akhir']);
		}
		
		$this->render($this->path_view.'index',array(
			'model'=>$model,
			'format'=>$format
		));
	}
	
	/**
	* menampilkan url untuk print karena nama controller tiap modul yg extend berbeda
	* @return type
	*/
	public function getUrlPrint(){
		return $this->createUrl("FormInventarisasiBarang/Print");
	}
	/**
	 * menampilkan url untuk action stock opname karena nama controller tiap modul yg extend berbeda
	 * @return type
	 */
	public function getUrlInventarisasi(){
		return $this->createUrl("InventarisasiBarang/Index");
	}
}