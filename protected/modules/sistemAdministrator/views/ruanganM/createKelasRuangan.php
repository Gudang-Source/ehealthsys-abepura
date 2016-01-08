<?php
$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
                // (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Ruangan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;
$this->widget('bootstrap.widgets.BootAlert'); 

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'loginpemakai-k-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
)); ?>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<div class="control-group">
  <div class="controls">
   <?php echo $form->labelEx($model,'ruangan_id',array('class'=>'control-label required')); ?>
   <?php echo $form->dropDownList($model, 'ruangan_id', CHtml::listData($model->RuanganItems, 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih Ruangan--','class'=>'span3'));?>
  </div>
</div>    
 <?php  echo $form->labelEx($model,'kelaspelayanan_id',array('class'=>'control-label required'));  ?>
<div class="control-group">
    <div class="controls">
        
         <?php 
               $this->widget('application.extensions.emultiselect.EMultiSelect',
                             array('sortable'=>true, 'searchable'=>true)
                        );
                echo CHtml::dropDownList(
                'kelaspelayanan_id[]',
                '',
                CHtml::listData(SAKelasPelayananM::model()->findAll(array('order'=>'kelaspelayanan_nama')), 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                array('multiple'=>'multiple','key'=>'kelaspelayanan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                        );
          ?>
              
     </div>
</div>
 <div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                              array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton')); ?>
                         <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        '', 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'))."&nbsp";
                              echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Ruangan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
                                                              ?>
            </div>
<?php $this->endWidget(); ?>