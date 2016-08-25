<div class="white-container">
    <legend class="rim2">Ubah <b>Tindakan Ruangan</b></legend>
    <?php
    $arrMenu = array();
    array_push($arrMenu, array('label' => Yii::t('mds', 'update') . ' Tindakan Ruangan ', 'header' => true, 'itemOptions' => array('class' => 'heading-master')));
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Ruangan', 'icon'=>'list', 'url'=>array('index'))) ;
    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Tindakan Ruangan', 'icon' => 'folder-open', 'url' => array('Admin'))) : '';

    //$this->menu=$arrMenu;
    $this->widget('bootstrap.widgets.BootAlert');


    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'tindakanruangan-m-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'instalasi_id'),
    ));
    ?>
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <?php echo $form->errorSummary($model); ?>
    <div class="control-group">
        <?php echo CHtml::label("Daftar Tindakan", "daftartindakan_nama", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php    
                echo $form->hiddenField($model,'daftartindakan_id',array("readonly"=>TRUE));
                echo CHtml::textField('daftartindakan_nama', $model->daftartindakan_nama, array('readonly' => true, 'class' => 'span5'));
           
            ?>
        </div>
    </div>
    <?php  echo $form->labelEx($model,'Ruangan',array('class'=>'control-label required'));  ?>
                    <div class="control-group">
                       <div class="controls">

                            <?php 
                                     $arrRuangan = array();
                                      foreach($modRuangan as $Ruangan)
                                        {
                                           $arrRuangan[] = $Ruangan['ruangan_id'];
                                        }

                                  $this->widget('application.extensions.emultiselect.EMultiSelect',
                                                array('sortable'=>true, 'searchable'=>true)
                                           );
                                   echo CHtml::dropDownList(
                                   'ruangan_id[]',
                                   $arrRuangan,
                                   CHtml::listData(SARuanganM::model()->findAll(array('order'=>'ruangan_nama', 'condition'=>'ruangan_aktif = true')), 'ruangan_id', 'ruangan_nama'),
                                   array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:250px')
                                           );
                             ?>
                       </div>
                    </div>
<div class="form-actions">
    <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
               <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        '', 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Tindakan Ruangan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
        $tips = array(
            '0' => 'simpan',
            '1' => 'ulang',            
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
</div>
</div>                      
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view . "_jsFunctions", array('model' => $model)); ?>
