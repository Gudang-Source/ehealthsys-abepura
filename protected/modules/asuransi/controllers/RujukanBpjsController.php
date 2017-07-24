<?php
class RujukanBpjsController extends MyAuthController{
	protected $path_view = 'asuransi.views.rujukanBpjs.';
	protected $path_view_peserta = 'asuransi.views.pesertaBpjs.';
	
	public function actionIndex(){
		
		$this->render($this->path_view.'index',array(
			
		));
	}
	
	/**
	* set bpjs Interface
	*/
	public function actionBpjsInterface()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
			$format = new MyFormatter();
			$start = 1;
			$limit = 1;
			if(empty( $_GET['param'] ) OR $_GET['param'] === ''){
				die('param can\'not empty value');
			}else{
				$param = $_GET['param'];
			}

 //                if(empty( $_GET['server'] ) OR $_GET['server'] === ''){
 //                    
 //                }else{
 //                    $server = 'http://'.$_GET['server'];
 //                }

			$bpjs = new Bpjs();

			switch ($param) {
				case '1':
					$query = $_GET['query'];
					print_r( $bpjs->search_rujukan_no_rujukan($query) );
					break;
				case '2':
					$query = $_GET['query'];
					print_r( $bpjs->search_rujukan_no_bpjs($query) );
					break;
				case '3':
					$query = $_GET['query'];
					$query = $format->formatDateTimeForDb($query);
					print_r( $bpjs->list_rujukan_tanggal($query,$start, $limit) );
					break;
				case '4':
					$query = $_GET['query'];
					print_r( $bpjs->search_rujukan_rs_no_rujukan($query) );
					break;
				case '5':
					$query = $_GET['query'];
					print_r( $bpjs->search_rujukan_rs_no_bpjs($query) );
					break;
				case '6':
					$query = $_GET['query'];
					$query = $format->formatDateTimeForDb($query);
					print_r( $bpjs->list_rujukan_rs_tanggal($query,$start,$limit) );
					break;
				case '99':
					$bpjs->identity_magic();
					break;
				case '100':
					print_r( $bpjs->help() );
					break;
				default:
					die('error number, please check your parameter option');
					break;
			}
			Yii::app()->end();
		}
	}
	
	/**
	* @param type $sep_id
	*/
	public function actionPrintRujukanBpjs($norujukan = null,$nokartu = null,$tglrujukan = null)
	{
		$this->layout='//layouts/printWindows';
		$format = new MyFormatter;
		$bpjs = new Bpjs();
		
		$judul_print = 'DATA PESERTA BPJS';
		
		$res = CJSON::decode($bpjs->search_kartu($nokartu));
		// var_dump($res); die;
		
		$this->render($this->path_view.'printRujukanBpjs', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'norujukan'=>$norujukan,
			'nokartu'=>$nokartu,
			'res'=>$res,
		));
	} 
	
	/**
	* @param type $sep_id
	*/
	public function actionPrintRujukanBpjsFktl($norujukan = null,$nokartu = null,$tglrujukan = null)
	{
		$this->layout='//layouts/printWindows';
		$format = new MyFormatter;
		$bpjs = new Bpjs();
		
		if (!empty($norujukan)) {
			$res = CJSON::decode($bpjs->search_rujukan_rs_no_rujukan($norujukan));
		} else {
			$res = CJSON::decode($bpjs->search_rujukan_rs_no_bpjs($nokartu));
		}
		
		$judul_print = 'DATA RUJUKAN PESERTA BPJS FKTL';
		$this->render($this->path_view.'printFKTL', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'norujukan'=>$norujukan,
			'nokartu'=>$nokartu,
			'res'=>$res,
		));
	} 
	
	/**
	* @param type $sep_id
	*/
	public function actionPrintRujukanBpjsFktp($norujukan = null,$nokartu = null,$tglrujukan = null)
	{
		$this->layout='//layouts/printWindows';
		$format = new MyFormatter;
		$bpjs = new Bpjs();
		
		$judul_print = 'DATA RUJUKAN PESERTA BPJS FKTP';
		
		if (!empty($norujukan)) {
			$res = CJSON::decode($bpjs->search_rujukan_no_rujukan($norujukan));
		} else {
			$res = CJSON::decode($bpjs->search_rujukan_no_bpjs($nokartu));
		}
		
		var_dump($res); die;
		
		$this->render($this->path_view.'printFKTP', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
			'norujukan'=>$norujukan,
			'nokartu'=>$nokartu,
			'res'=>$res,
		));
	} 
}