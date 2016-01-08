<div class="white-container">
    <legend class="rim2">Master <b>Kondisi Darurat</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakondisidarurat Ms'=>array('index'),
            'Create',
    );

    $arrMenu = array();
    $this->menu=$arrMenu;
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'sapegawai-m-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
            'focus'=>'#',
    )); ?>
    <?php // echo $form->errorSummary($model); ?>
    <?php $this->renderPartial($this->path_view.'_tabMenu',array()); ?>
    <?php $this->renderPartial($this->path_view.'_jsFunctions',array()); ?>
    <div>
    <iframe class="biru" id="frame" src="" frameborder="0" style="overflow-y:scroll"  width="100%" height="100%" onresize="javascript:resizeIframe(this);" onload="javascript:resizeIframe(this);" ></iframe>
    </div>
    <?php 
//        $content = $this->renderPartial($this->path_view.'tips/master',array(),true);
//        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
    ?> 
    <?php $this->endWidget(); ?>
</div>
