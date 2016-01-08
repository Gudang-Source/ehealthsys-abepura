<?php
class PesertaBpjsController extends MyAuthController{
	
	protected $path_view = 'asuransi.views.pesertaBpjs.';
	
	public function actionIndex()
	{
	
		$this->render($this->path_view.'index',array(
			
		));
	}
	
	/**
	* set bpjs Interface
	*/
	public function actionBpjsInterface()
	{
		if(Yii::app()->getRequest()->getIsAjaxRequest()) {
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
					print_r( $bpjs->search_kartu($query) );
					break;
				case '2':
					$query = $_GET['query'];
					print_r( $bpjs->search_nik($query) );
					break;
				case '3':
					$nokartu = $_GET['nokartu'];
					print_r( $bpjs->riwayat_terakhir($nokartu) );
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
	public function actionPrintPesertaBpjs($nokartu=null,$nonik=null)
	{
		$this->layout='//layouts/printWindows';
		$format = new MyFormatter;
		
		$judul_print = 'DATA PESERTA BPJS';
		$this->render($this->path_view.'printPesertaBpjs', array(
			'format'=>$format,
			'judul_print'=>$judul_print,
		));
	} 
}