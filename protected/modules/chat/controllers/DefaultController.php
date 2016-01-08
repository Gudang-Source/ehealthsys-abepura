<?php

class DefaultController extends Controller
{
        /**
        * @return array action filters
        * sebagai pengaanti SBaseController / RND-4490
        */
        public function filters()
        {
            return array(
                'accessControl', // perform access control for CRUD operations
            );
        }

        /**
        * Specifies the access control rules.
        * This method is used by the 'accessControl' filter.
        * @return array access control rules
        * sebagai pengaanti SBaseController / RND-4490
        */
        public function accessRules()
        {
        return array(
                array('allow', // allow authenticated user to perform 'create' and 'update' actions
                    'actions'=>array($this->action->id),
                    'users'=>array('@'),
                ),
                array('deny',  // deny all users
                    'users'=>array('*'),
                ),
            );
        }
        
        
	public function actionIndex()
	{
            $this->layout = 'column1';
            
            $_SESSION['username'] = str_replace(' ', '', Yii::app()->user->name); // Must be already set
            if ($_GET['action'] == "chatheartbeat") { $this->chatHeartbeat(); } 
            if ($_GET['action'] == "sendchat") { $this->sendChat(); } 
            if ($_GET['action'] == "closechat") { $this->closeChat(); } 
            if ($_GET['action'] == "startchatsession") { $this->startChatSession(); } 

            if (!isset($_SESSION['chatHistory'])) {
                    $_SESSION['chatHistory'] = array();	
            }

            if (!isset($_SESSION['openChatBoxes'])) {
                    $_SESSION['openChatBoxes'] = array();	
            }
            
            $criteria = new CDbCriteria;
            $criteria->order = 'statuslogin, nama_pemakai DESC';
            $userOnline = LoginpemakaiK::model()->findAll($criteria);
		
            $this->render('index',array('modUserOnline'=>$userOnline));
	}
        
        public function chatHeartbeat() {
                $_SESSION['username'] = str_replace(' ', '', Yii::app()->user->name);
                $sql = "SELECT * FROM chat WHERE (chat_to = '".$_SESSION['username']."' AND chat_recd = 0) ORDER BY chat_sent ASC";
                $query = Yii::app()->db->createCommand($sql)->query();
                $items = array();
                $i = 0;
                if(count($query) > 0){
                    foreach ($query as $chat) {
                        $_SESSION['openChatBoxes'][$chat['chat_from']] = $chat['chat_sent'];
                        if (!isset($_SESSION['openChatBoxes'][$chat['chat_from']]) && isset($_SESSION['chatHistory'][$chat['chat_from']])) {
                                $items[] = $_SESSION['chatHistory'][$chat['chat_from']];
                        }

                        $chat['chat_message'] = $this->sanitize($chat['chat_message']);

                        $items[$i]["s"] = "0";
                        $items[$i]["f"] = $chat['chat_from'];
                        $items[$i]["m"] = $chat['chat_message'];
                        $i++;

                        if (!isset($_SESSION['chatHistory'][$chat['chat_from']])) {
                                $_SESSION['chatHistory'][$chat['chat_from']] = '';
                        }

                        $_SESSION['chatHistory'][$chat['chat_from']] .= '
                               {
                                    "s": "0",
                                    "f": "'.$chat['chat_from'].'",
                                    "m": "'.$chat['chat_message'].'"
                                },';

                        unset($_SESSION['tsChatBoxes'][$chat['chat_from']]);

                    }
                    $sql = "UPDATE chat SET chat_recd = 1 WHERE chat_to = '".$_SESSION['username']."' AND chat_recd = 0";
                    $query = Yii::app()->db->createCommand($sql)->execute();
                }
                if (!empty($_SESSION['openChatBoxes'])) {
                    foreach ($_SESSION['openChatBoxes'] as $chatbox => $time) {
                        if (!isset($_SESSION['tsChatBoxes'][$chatbox])) {
                                $now = time()-strtotime($time);
                                $time = date('g:iA M dS', strtotime($time));

                                $message = "Sent at $time";
                                if ($now > 180) {
                                        $items[$i]["s"] = "2";
                                        $items[$i]["f"] = $chatbox;
                                        $items[$i]["m"] = $message;
                                        $i++;

                                        if (!isset($_SESSION['chatHistory'][$chatbox])) {
                                                $_SESSION['chatHistory'][$chatbox] = '';
                                        }

                                        $_SESSION['chatHistory'][$chatbox] .= <<<EOD
		{
"s": "2",
"f": "$chatbox",
"m": "{$message}"
},
EOD;
                                        $_SESSION['tsChatBoxes'][$chatbox] = 1;
                                }
                        }
                    }
                }

                /*if ($items != '') {
                        $items = substr($items, 0, -1);
                }*/
                $var['items'] = $items;
                echo CJSON::encode($var);
                Yii::app()->end();
        }

        public function chatBoxSession($chatbox) {

                $items = '';

                if (isset($_SESSION['chatHistory'][$chatbox])) {
                        $items = $_SESSION['chatHistory'][$chatbox];
                }

                return $items;
        }

        public function startChatSession() {
                $items = '';
                if (!empty($_SESSION['openChatBoxes'])) {
                        foreach ($_SESSION['openChatBoxes'] as $chatbox => $void) {
                                $items .= $this->chatBoxSession($chatbox);
                        }
                }

                
                if ($items != '') {
                        $items = substr($items, 0, -1);
                }

                $data = '{';
                $data .= '"username":"'.$_SESSION['username'].'",';
                $data .= '"items":['.$items.']';
                $data .= '}';
                echo $data;
                //echo CJSON::encode($var);
                exit(0);
        }

        public function sendChat() {
                $from = $_SESSION['username'];
                $to = $_POST['to'];
                $message = $_POST['message'];

                $_SESSION['openChatBoxes'][$_POST['to']] = date('Y-m-d H:i:s', time());

                $messagesan = $this->sanitize($message);

                if (!isset($_SESSION['chatHistory'][$_POST['to']])) {
                        $_SESSION['chatHistory'][$_POST['to']] = '';
                }

                $_SESSION['chatHistory'][$_POST['to']] .= <<<EOD
					   {
			"s": "1",
			"f": "{$to}",
			"m": "{$messagesan}"
	   },
EOD;

                unset($_SESSION['tsChatBoxes'][$_POST['to']]);

                $sql = "INSERT INTO chat (chat_from,chat_to,chat_message,chat_sent) values ('".$from."', '".$to."','".$message."','".date('Y-m-d H:i:s')."')";
                $query = Yii::app()->db->createCommand($sql)->query();
                echo "1";
                exit(0);
        }

        public function closeChat() {

                unset($_SESSION['openChatBoxes'][$_POST['chatbox']]);

                echo "1";
                exit(0);
        }

        public function sanitize($text) {
                $text = htmlspecialchars($text, ENT_QUOTES);
                $text = str_replace("\n\r","\n",$text);
                $text = str_replace("\r\n","\n",$text);
                $text = str_replace("\n","<br>",$text);
                return $text;
        }
}