<?php
ini_set('memory_limit', '32M');
class MChatController extends MyMobileAuthController
{
	public $layout = "//layouts/iframe";
	
	public function actionIndex()
    {
        $this->render('/default/index');
    }
    /**
     * insert history chat
     * MA-126
     * @param $_GET['chat_from'] 
     * @param $_GET['chat_to'] 
     * @param $_GET['chat_message'] text
     * @return json
     */
    public function actionChat(){
        header("content-type:application/json");
        $data = array();
        $data['sukses'] = 0;
        $data['pesan'] = 'Error 404 : Request tidak valid. Cek parameter';
        if(isset($_GET['chat_from']) && isset($_GET['chat_to']) && isset($_GET['chat_message'])){
            $transaction = Yii::app()->db->beginTransaction();
            try{
                $model = new MOChat();
                $model->chat_from = $_GET['chat_from'];
                $model->chat_to = $_GET['chat_to'];
                $model->chat_sent = date("Y-m-d H:i:s");
                $model->chat_message = str_replace('"','',str_replace("'","",$_GET['chat_message']));
                
                if($model->save()){
                    $transaction->commit();
                    $data['sukses'] = 1;
                    $data['pesan'] = 'Pesan terkirim!';
                }else{
                    $transaction->rollback();
                    $data['sukses'] = 0;
                    $data['pesan'] = 'Pesan gagal terkirim!<br>'.CHtml::errorSummary($model);
                }
            }catch (Exception $exc) {
                $transaction->rollback();
                $data['sukses'] = 0;
                $data['pesan'] = 'Pesan gagal terkirim!'.MyExceptionMessage::getMessage($exc,true);
            }
            
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
    
    /**
     * menampilkan history chat (keluar dan masuk)
     * MA-183
     * @param $_GET['chat_from'] wajib
     * @param $_GET['chat_to'] wajib
     * @param $_GET['offset']
     * @return json
     */
    public function actionGetChatHistory(){
        header("content-type:application/json");
        $data = array();
        if(isset($_GET['chat_from']) && isset($_GET['chat_to'])){
            $sql = "SELECT * 
                    FROM chat
                    WHERE (TRIM(chat_from) = '".trim($_GET['chat_from'])."' AND TRIM(chat_to) = '".$_GET['chat_to']."') 
                        OR (TRIM(chat_to) = '".trim($_GET['chat_from'])."' AND TRIM(chat_from) = '".$_GET['chat_to']."')
                    ORDER BY chat_id DESC
					".(isset($_GET['offset']) ? "OFFSET ".$_GET['offset'] : "")."
                    LIMIT 10";
            $loadDatas = Yii::app()->db->createCommand($sql)->queryAll();
            if(count($loadDatas) > 0){
				foreach($loadDatas AS $i => $val){
					$data[$i] = $val;
					$data[$i]['user_1'] = $val['chat_from'];
					$data[$i]['user_2'] = $val['chat_to'];
				}
            }
        }
        $encode = CJSON::encode($data);
        echo "jsonCallback(".$encode.")";
        Yii::app()->end();
    }
}