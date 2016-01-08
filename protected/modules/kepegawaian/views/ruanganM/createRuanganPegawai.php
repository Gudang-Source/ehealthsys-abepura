<?php
$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Ruangan', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

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
 <?php  echo $form->labelEx($model,'pegawai_id',array('class'=>'control-label required'));  ?>
<div class="control-group">
    <div class="controls">
        
         <?php 
               $this->widget('application.extensions.emultiselect.EMultiSelect',
                             array('sortable'=>true, 'searchable'=>true)
                        );
                echo CHtml::dropDownList(
                'pegawai_id[]',
                '',
                CHtml::listData(SAPegawaiM::model()->findAll(array('order'=>'nama_pegawai')), 'pegawai_id', 'nama_pegawai'),
                array('multiple'=>'multiple','key'=>'pegawai_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                        );
          ?>
              
     </div>
</div>
 <div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                              array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle"></i>')), 
                                                              Yii::app()->createUrl($this->module->id.'/'.ruanganM.'/admin'), 
                                                              array('class'=>'btn btn-danger','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            </div>
<?php $this->endWidget(); ?>