<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sabidang-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'golongan_id',CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'bidang_kode',array('class'=>'span3 angkadot-only','maxlength'=>5)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'bidang_nama',array('class'=>'span3 custom-only','maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'bidang_namalainnya',array('class'=>'span3 custom-only','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'bidang_aktif',array('checked'=>'bidang_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'bidang_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'bidang_namalainnya',array('class'=>'span5','maxlength'=>100)); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
