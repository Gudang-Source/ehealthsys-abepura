<?php
ini_set('memory_limit', '-1');
error_reporting(0); //UNTUK PRODUKSI
//error_reporting(E_ALL | E_STRICT); //UNTUK DEVELOPMENT
// change the following paths if necessary
$yii=dirname(__FILE__).'/yii1_10/framework/yiilite.php'; //UNTUK PRODUKSI
//$yii=dirname(__FILE__).'/yii1_10/framework/yii.php'; //UNTUK DEVELOPMENT
$config=dirname(__FILE__).'/protected/config/main.php';
// remove the following lines when in production mode
//defined('YII_DEBUG') or define('YII_DEBUG',false); //UNTUK PRODUKSI
defined('YII_DEBUG') or define('YII_DEBUG',true); //UNTUK DEVELOPMENT
// specify how many levels of call stack should be shown in each log message
defined('YII_TRACE_LEVEL') or define('YII_TRACE_LEVEL',3);
require_once($yii);
Yii::createWebApplication($config)->run();

if(isset($_GET['r']))
{
    $url = $_GET['r'];
    if(isset(Yii::app()->user->id)){
        $attributes = array(
            'statuslogin' => TRUE,
            'ruanganaktifitas' => Yii::app()->user->getState('ruangan_id'),
            'crudaktifitas' => $url,
            'waktuterakhiraktifitas' => date("Y-m-d H:i:s"),
        );
        $update = LoginpemakaiK::model()->updateByPk(Yii::app()->user->id, $attributes);
    }
}
