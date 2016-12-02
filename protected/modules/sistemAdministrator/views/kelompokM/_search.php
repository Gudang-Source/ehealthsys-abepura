<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakelompok-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'golongan_id',CHtml::listData($model->getGolonganItems(), 'golongan_id', 'golongan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </td>        
        <td>
            <?php echo $form->textFieldRow($model,'kelompok_kode',array('class'=>'span3 angkadot-only','maxlength'=>8)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kelompok_nama',array('class'=>'span3 custom-only','maxlength'=>100)); ?>
        </td>
         <td>
            <?php echo $form->textFieldRow($model,'kelompok_namalainnya',array('class'=>'span3 custom-only','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'bidang_id',CHtml::listData($model->getBidangItems(), 'bidang_id', 'bidang_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </td>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'kelompok_aktif',array('checked'=>'kelompok_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'kelompok_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'kelompok_namalainnya',array('class'=>'span5','maxlength'=>100)); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
