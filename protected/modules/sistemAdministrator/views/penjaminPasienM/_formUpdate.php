
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'sapenjamin-pasien-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'carabayar_id'),
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'carabayar_id',  CHtml::listData($model->CarabayarItems, 'carabayar_id', 'carabayar_nama'),array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'SAPenjaminPasienM_penjamin_nama','')",'empty'=>'-- Pilih --')); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'penjamin_nama',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'SAPenjaminPasienM_penjamin_namalainnya','SAPenjaminPasienM_carabayar_id')", 'maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'penjamin_namalainnya',array('class'=>'span3', 'onkeypress'=>"return nextFocus(this,event,'SAPenjaminPasienM_penjamin_aktif','SAPenjaminPasienM_penjamin_nama')", 'maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'penjamin_aktif', array('onkeypress'=>"return nextFocus(this,event,'btn_simpan','SAPenjaminPasienM_penjamin_namalainnya')")); ?>
        </td>
    </tr>
</table>
 	    




	<div class="form-actions">
            <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                 Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan')); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    Yii::app()->createUrl($this->module->id.'/penjaminPasienM/admin'), 
                    array('class'=>'btn btn-danger',
                          'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Penjamin Pasien', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/Admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
            <?php
                $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            ?>
        </div>

<?php $this->endWidget(); ?>
