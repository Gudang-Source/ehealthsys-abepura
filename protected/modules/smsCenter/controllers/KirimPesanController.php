<?php
class KirimPesanController extends MyAuthController
{
	/**
	 * @var string the default layout for the views. Defaults to '//layouts/column2', meaning
	 * using two-column layout. See 'protected/views/layouts/column2.php'.
	 */
	public $layout='//layouts/main';
    public $defaultAction = 'index';
	/**
	 * Lists all models.
	 */
	public function actionIndex()
	{
            $this->render('index');
	}


	public function actionPasien()
	{
		$this->layout='//layouts/iframeNeon';
        $model = new Outbox;
        $model->CreatorID = Yii::app()->user->name;
        
        $modPasien = new PasienM;
        if(isset($_GET['PasienM'])) {
            $modPasien->unsetAttributes();
            $modPasien->attributes = $_GET['PasienM'];
        }
        
        if(isset($_POST['Outbox'])) {
            $no_tujuan = $_POST['noPenerima'];
            $pesan = str_split(isset($_POST['Outbox']['TextDecoded'])?$_POST['Outbox']['TextDecoded']:'', 153);
            $jumlah_part = count($pesan);
            $id = null;
            $udh = '';
            $hex_number = '';
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($no_tujuan as $i => $nomor) {
                    $hex_number = $this->getRandomHex();
                    foreach ($pesan as $j => $psn) {
                        $udh = $hex_number.str_pad($jumlah_part, 2, "0", STR_PAD_LEFT).str_pad($j+1, 2, "0", STR_PAD_LEFT);
                        if($j==0){
                            if(count($pesan)<=1){
                                $udh = '';
                            }
                            $model = new Outbox;
                            $model->attributes = $_POST['Outbox'];
                            $model->DestinationNumber = $nomor;
                            $model->UDH = $udh;
                            $model->TextDecoded = $psn;
                            $model->MultiPart = ($jumlah_part>1)?'true':'false';

                            if($model->save()){
                                $id = $model->ID;
                            }
                        }else{
                            
                            $modMultiPart = new OutboxMultipart;
                            $modMultiPart->UDH = $udh;
                            $modMultiPart->TextDecoded = $psn;
                            $modMultiPart->ID = $id;
                            $modMultiPart->SequencePosition = $j+1;
                            $modMultiPart->save();
                        }

      
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Pesan berhasil dikirim.');
                $transaction->commit();

            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Pesan gagal dikirim. ".MyExceptionMessage::getMessage($e,true));
            }
        }
	
        $this->render('kirimpasien',array('model'=>$model,
                                    'modPasien'=>$modPasien));
	}

	public function actionPegawai()
	{
            
            if (isset($_POST['is_ajax'])) {
                if (isset($_POST['param'])) {
                    call_user_func(array($this, $_POST['f']), $_POST['param']);
                } else {
                    call_user_func(array($this, $_POST['f']));
                }
                Yii::app()->end();
            }
            
		$this->layout='//layouts/iframeNeon';
        $model = new Outbox;
        $model->CreatorID = Yii::app()->user->name;
        
        $modPegawai = new PegawaiM;
        if(isset($_GET['PegawaiM'])) {
            $modPegawai->unsetAttributes();
            $modPegawai->attributes = $_GET['PegawaiM'];
            $modPegawai->ruangan_id = $_GET['PegawaiM']['ruangan_id'];
        }
        
        if(isset($_POST['Outbox'])) {
            $no_tujuan = $_POST['noPenerima'];
            $pesan = str_split(isset($_POST['Outbox']['TextDecoded'])?$_POST['Outbox']['TextDecoded']:'', 153);
            $jumlah_part = count($pesan);
            $id = null;
            $udh = '';
            $hex_number = '';
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($no_tujuan as $i => $nomor) {
                    $hex_number = $this->getRandomHex();
                    foreach ($pesan as $j => $psn) {
                        $udh = $hex_number.str_pad($jumlah_part, 2, "0", STR_PAD_LEFT).str_pad($j+1, 2, "0", STR_PAD_LEFT);
                        if(count($pesan)<=1){
                            $udh = '';
                        }
                        if($j==0){
                            $model = new Outbox;
                            $model->attributes = $_POST['Outbox'];
                            $model->DestinationNumber = $nomor;
                            $model->UDH = $udh;
                            $model->TextDecoded = $psn;
                            $model->MultiPart = ($jumlah_part>1)?'true':'false';

                            if($model->save()){
                                $id = $model->ID;
                            }
                        }else{
                            
                            $modMultiPart = new OutboxMultipart;
                            $modMultiPart->UDH = $udh;
                            $modMultiPart->TextDecoded = $psn;
                            $modMultiPart->ID = $id;
                            $modMultiPart->SequencePosition = $j+1;
                            $modMultiPart->save();
                        }

      
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Pesan berhasil dikirim.');
                $transaction->commit();

            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Pesan gagal dikirim. ".MyExceptionMessage::getMessage($e,true));
            }

        }
	
        $this->render('kirimpegawai',array('model'=>$model,
                                    'modPegawai'=>$modPegawai));
	}

        protected function kumpulDataPegawai($param) {
            $ser = $param['serial'];
            $pegawai = new PegawaiM;
            
            $pegawai->ruangan_id = $ser[1]['value'];
            $pegawai->nomorindukpegawai = $ser[2]['value'];
            $pegawai->nama_pegawai = $ser[3]['value'];
            $pegawai->nomobile_pegawai = $ser[4]['value'];
            
            $provider = $pegawai->searchNoMobile();
            $provider->pagination = false;
            
            $res = array();
            
            foreach ($provider->data as $item) {
                array_push($res, array(
                    'mobile' => (string)$item->nomobile_pegawai,
                    'nama' => $item->nama_pegawai,
                ));
            }
            
            echo CJSON::encode($res);
        }
        
	public function actionUmum()
	{
		$this->layout='//layouts/iframeNeon';
        $model = new Outbox;
        $modMultiPart = new OutboxMultipart;
        $model->CreatorID = Yii::app()->user->name;
        
        $modPasien = new PasienM;
        if(isset($_GET['PasienM'])) {
            $modPasien->unsetAttributes();
            $modPasien->attributes = $_GET['PasienM'];
        }
        
        if(isset($_POST['Outbox'])) {
            $no_tujuan = explode(',', isset($_POST['Outbox']['DestinationNumber'])?$_POST['Outbox']['DestinationNumber']:'');
            $pesan = str_split(isset($_POST['Outbox']['TextDecoded'])?$_POST['Outbox']['TextDecoded']:'', 153);
            $jumlah_part = count($pesan);
            $id = null;
            $udh = '';
            $hex_number = '';
            $transaction = Yii::app()->db->beginTransaction();
            try {
                foreach ($no_tujuan as $i => $nomor) {
                    $hex_number = $this->getRandomHex();
                    foreach ($pesan as $j => $psn) {
                        $udh = $hex_number.str_pad($jumlah_part, 2, "0", STR_PAD_LEFT).str_pad($j+1, 2, "0", STR_PAD_LEFT);
                        if(count($pesan)<=1){
                            $udh = '';
                        }
                        if($j==0){
                            $model = new Outbox;
                            $model->attributes = $_POST['Outbox'];
                            $model->DestinationNumber = $nomor;
                            $model->UDH = $udh;
                            $model->TextDecoded = $psn;
                            $model->MultiPart = ($jumlah_part>1)?'true':'false';

                            if($model->save()){
                                $id = $model->ID;
                            }
                        }else{
                            
                            $modMultiPart = new OutboxMultipart;
                            $modMultiPart->UDH = $udh;
                            $modMultiPart->TextDecoded = $psn;
                            $modMultiPart->ID = $id;
                            $modMultiPart->SequencePosition = $j+1;
                            $modMultiPart->save();
                        }

      
                    }
                }
                Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Pesan berhasil dikirim.');
                $transaction->commit();

            } catch (Exception $e) {
                $transaction->rollback();
                Yii::app()->user->setFlash('error',"Pesan gagal dikirim. ".MyExceptionMessage::getMessage($e,true));
            }
        }
	
        $this->render('kirimumum',array('model'=>$model));
	}


    public function getRandomHex() {
        $possibilities = array(1, 2, 3, 4, 5, 6, 7, 8, 9, "A", "B", "C", "D", "E", "F" );
        shuffle($possibilities);
        $hex = "";
        for($i=1;$i<=8;$i++){
            $hex .= $possibilities[rand(0,14)];
        }
        return $hex;
    }

}
