
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sakelas-pelayanan-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#',
)); ?>

	<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

	    <?php echo $form->errorSummary($model); ?>
            <?php echo $form->dropDownListRow($model,'jeniskelas_id',  CHtml::listData($model->JenisKelasItems, 'jeniskelas_id', 'jeniskelas_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->textFieldRow($model,'kelaspelayanan_nama',array('class'=>'span3', 'onkeyup'=>"namaLain(this)", 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
            <?php echo $form->textFieldRow($model,'kelaspelayanan_namalainnya',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'kelaspelayanan_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
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
                CHtml::listData(SARuanganM::model()->findAll(array('order'=>'ruangan_nama')), 'ruangan_id', 'ruangan_nama'),
                array('multiple'=>'multiple','key'=>'ruangan_id', 'class'=>'multiselect','style'=>'width:500px;height:150px')
                        );
          ?>
              
     </div>  
</div>   
        <div class="form-actions">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/kelasPelayananM/admin'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
		<?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelas Pelayanan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp";
$content = $this->renderPartial('../tips/tipsaddedit',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
