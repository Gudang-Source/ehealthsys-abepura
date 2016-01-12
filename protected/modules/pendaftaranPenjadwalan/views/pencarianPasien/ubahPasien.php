<div class="white-container">
    <legend class="rim2">Ubah <b>Pasien</b></legend>
    <?php
    $arrMenu = array();
//                    array_push($arrMenu,array('label'=>Yii::t('mds','Update Patient Data'), 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    $this->menu=$arrMenu;
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'ubahpasien-form',
            'enableAjaxValidation'=>false,
                    'type'=>'horizontal',
                    'focus'=>'#PPPasienM_jenisidentitas',
                    'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)',"onsubmit"=>"return requiredCheck(this);"),
    )); 
    $this->widget('bootstrap.widgets.BootAlert');

    ?>
    <?php echo $this->renderPartial($this->path_view.'_formUbahPasien', array('format'=>$format,'model'=>$model,'form'=>$form, 'modPendaftaran'=>$modPendaftaran,'modPegawai'=>$modPegawai)); ?>

    <div class="form-actions">
                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                       Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                                        array('class'=>'btn btn-primary', 'type'=>'submit','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                                                Yii::app()->createUrl($this->module->id.'/pencarianPasien/cariPasien'), 
                                                                array('class'=>'btn btn-danger',
                                                                      'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    </div>
    <?php $this->endWidget();?>
</div>