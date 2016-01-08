<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sadaftar-tindakan-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'komponenunit_id',  CHtml::listData($model->KomponenUnitItems, 'komponenunit_id', 'komponenunit_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->dropDownListRow($model,'kelompoktindakan_id',  CHtml::listData($model->KelompokTindakanItems, 'kelompoktindakan_id', 'kelompoktindakan_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'kategoritindakan_id',  CHtml::listData($model->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'),array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <?php echo $form->textFieldRow($model,'daftartindakan_nama',array('class'=>'span3','maxlength'=>200)); ?>
        </td>
        <td style="padding-left:50px;">
            <?php echo $form->checkBoxRow($model,'daftartindakan_aktif', array('checked'=>'$data=>daftartindakan_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'daftartindakan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'komponenunit_nama',array('class'=>'span3')); ?>
	
	<?php //echo $form->textFieldRow($model,'kelompoktindakan_nama',array('class'=>'span3')); ?>
	
	<?php //echo $form->textFieldRow($model,'kategoritindakan_nama',array('class'=>'span3')); ?>
	
	<?php //echo $form->textFieldRow($model,'daftartindakan_kode',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'tindakanmedis_nama',array('class'=>'span5','maxlength'=>200)); ?>

	<?php //echo $form->textFieldRow($model,'daftartindakan_namalainnya',array('class'=>'span5','maxlength'=>200)); ?>

	<?php //echo $form->textFieldRow($model,'daftartindakan_katakunci',array('class'=>'span5','maxlength'=>30)); ?>

	<?php //echo $form->checkBoxRow($model,'daftartindakan_karcis'); ?>

	<?php //echo $form->checkBoxRow($model,'daftartindakan_visite'); ?>

	<?php //echo $form->checkBoxRow($model,'daftartindakan_konsul'); ?>

	<?php //echo $form->checkBoxRow($model,'daftartindakan_akomodasi'); ?>

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
