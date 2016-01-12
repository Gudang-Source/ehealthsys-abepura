<?php
class MyAuthController extends Controller
{
	protected function beforeAction($action)
    {
		if(!isset(Yii::app()->user->id)){
			if(Yii::app()->request->isAjaxRequest){
				die('403, Anda tidak diperkenankan mengakses halaman ini! Silahkan hubungi administrator!');
			}else{
				$this->redirect(array('/site/login'));
			}
		}
		if($this->checkAccess()){
			return true;
		}else{
			if(Yii::app()->request->isAjaxRequest){
				$data['pesan'] = "Anda tidak diperkenankan melakukan aksi ini! Silahkan hubungi administrator (Kode: 403)!";
				$data['sukses'] = 0;
				echo json_encode($data);
				Yii::app()->end();
			}else{
				throw new CHttpException(403, 'Anda tidak diperkenankan mengakses halaman ini! Silahkan hubungi administrator!');
			}
			return false;
		}
	}
	/**
	 * untuk mengecek hak akses
	 * @param type array(action, controller, module)
	 * @return boolean
	 * @throws CHttpException
	 */
	public function checkAccess($params = array()){
		$loginpemakai_id = Yii::app()->user->id;
		$action = $this->action->id;
		$controller = $this->id;
		$module = $this->module->id;
		
		if(isset($params['loginpemakai_id'])){
			$loginpemakai_id = $params['loginpemakai_id'];
		}
		if(isset($params['action'])){
			$action = $params['action'];
		}
		if(isset($params['controller'])){
			$controller = $params['controller'];
		}
		if(isset($params['module'])){
			$module = $params['module'];
		}
		$sql = "SELECT aksespengguna_k.aksespengguna_id 
				FROM aksespengguna_k
				JOIN tugaspengguna_k ON tugaspengguna_k.peranpengguna_id = aksespengguna_k.peranpengguna_id
				JOIN peranpengguna_k ON peranpengguna_k.peranpengguna_id = aksespengguna_k.peranpengguna_id
				JOIN modul_k ON modul_k.modul_id = aksespengguna_k.modul_id
				WHERE tugaspengguna_k.tugaspengguna_aktif = TRUE 
					AND peranpengguna_k.peranpengguna_aktif = TRUE
					AND aksespengguna_k.loginpemakai_id = ".$loginpemakai_id."
					AND LOWER(modul_k.url_modul) = '".strtolower($module)."'
					AND LOWER(tugaspengguna_k.controller_nama) = '".strtolower($controller)."'
					AND LOWER(tugaspengguna_k.action_nama) = '".strtolower($action)."'";
		$loadData = Yii::app()->db->createCommand($sql)->queryRow();
		if($loadData){
			return true;
		}else{
//			return false; // << AKTIF KAN UNTUK TES HAK AKSES
			if(Yii::app()->user->id == Params::LOGINPEMAKAI_ID_ADMIN){ //admin
				//REGISTER MODE RND-4608
				$sql = "SELECT modul_id
						FROM modul_k
						WHERE LOWER(url_modul) = '".strtolower($this->module->id)."'
						";
				$modul = Yii::app()->db->createCommand($sql)->queryRow();
				$modul_id = isset($modul['modul_id']) ? $modul['modul_id'] : Yii::app()->session['modul_id'];
				
				$sql = "SELECT aksespengguna_id
						FROM aksespengguna_k
						WHERE peranpengguna_id = ".Params::PERANPENGGUNA_ID_ADMIN."
							AND modul_id = ".$modul_id."
							AND loginpemakai_id = ".Yii::app()->user->id."
						";
				$cekData = Yii::app()->db->createCommand($sql)->queryRow();
				if(!$cekData){ //JIKA BELUM ADA DI DATABASE
					$sql_insert = "INSERT INTO aksespengguna_k (peranpengguna_id,modul_id,loginpemakai_id, create_time, create_loginpemakai_id) "
							. "VALUES (".Params::PERANPENGGUNA_ID_ADMIN.", 
							".$modul_id.",
							".Yii::app()->user->id.",
							'".date("Y-m-d H:i:s")."',
							".Yii::app()->user->id.")";
					$insert = Yii::app()->db->createCommand($sql_insert)->query();
				}
				$sql = "SELECT tugaspengguna_id
						FROM tugaspengguna_k
						WHERE peranpengguna_id = ".Params::PERANPENGGUNA_ID_ADMIN."
							AND LOWER(controller_nama) = '".strtolower($this->id)."'
							AND LOWER(action_nama) = '".strtolower($this->action->id)."'
							AND modul_id = ".$modul_id."
						";
				$cekData = Yii::app()->db->createCommand($sql)->queryRow();
				if(!$cekData){ //JIKA BELUM ADA DI DATABASE
					$sql_insert = "INSERT INTO tugaspengguna_k (peranpengguna_id,tugas_nama,controller_nama, action_nama, modul_id) "
							. "VALUES (".Params::PERANPENGGUNA_ID_ADMIN.", 
							'Otomatis',
							'".$this->id."',
							'".$this->action->id."',
							".$modul_id.")";
					$insert = Yii::app()->db->createCommand($sql_insert)->query();
				}
				return true;
			}else{
				return false;
			}
		}
	}
}

