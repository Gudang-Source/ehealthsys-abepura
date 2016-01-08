<?php
$this->breadcrumbs=array(
	'Sajenis Kasus Penyakit Ms'=>array('index'),
	'Create',
);

$arrMenu = array();
                array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kasus Penyakit Ruangan', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Kasus Penyakit', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Kasus Penyakit', 'icon'=>'folder-open', 'url'=>array('Admin'))) :  '' ;

$this->menu=$arrMenu;
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
   <?php echo $form->labelEx($model,'Jenis Kasus Penyakit',array('class'=>'control-label required')); ?>
   <?php echo $form->dropDownList($model, 'jeniskasuspenyakit_id', CHtml::listData($model->JenisKasusPenyakitItems, 'jeniskasuspenyakit_id', 'jeniskasuspenyakit_nama'),array('empty'=>'-- Pilih Jenis Kasus Penyakit--','class'=>'span3'));?>
  </div>
</div>    
 <?php  echo $form->labelEx($model,'ruangan_id',array('class'=>'control-label required'));  ?>
<div class="control-group">
    <div class="controls">
        
         <?php 
               $this->widget('application.extensions.emultiselect.EMultiSelect',
                             array('sortable'=>true, 'searchable'=>true)
                        );
                echo CHtml::dropDownList(
                'ruangan_id[]',
                '',
                CHtml::listData(SARuanganM::model()->findAll(array('order'=>'ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
                array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                        );
          ?>
              
     </div>
</div>
 <div class="form-actions">
                        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                             Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                              array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'submitButton')); ?>
                        <?php echo CHtml::link(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle"></i>')), 
                                                              $this->createUrl('admin'), 
                                                              array('class'=>'btn btn-danger','onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            </div>
<?php $this->endWidget(); ?>