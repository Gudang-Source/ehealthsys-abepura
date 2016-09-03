<?php
Yii::import('rawatInap.controllers.PemakaianBahanRIController');
Yii::import('rawatInap.models.*');
class PemakaianBahanTPSController extends PemakaianBahanRIController
{

      public $layout='//layouts/iframe';     
      
      public function init() {
          $layout = isset($_GET['frame'])?$_GET['frame']:null;
          
          if ($layout == null){
              $this->layout='//layouts/column1';     
          }else{
              $this->layout='//layouts/iframe';     
          }
      }

}