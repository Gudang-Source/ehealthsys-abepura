<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakarcis-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'daftartindakan_id',
                           CHtml::listData($model->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'),
                           array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                           'empty'=>'-- Pilih --')); ?>
            <?php echo $form->dropDownListRow($model,'ruangan_id',
                           CHtml::listData($model->RuanganItems, 'ruangan_id', 'ruangan_nama'),
                           array('class'=>'inputRequire', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                           'empty'=>'-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'karcis_nama',array('class'=>'span5','maxlength'=>100)); ?>
	<?php echo $form->textFieldRow($model,'karcis_namalainnya',array('class'=>'span5','maxlength'=>100)); ?>
        </td>
        <td style="padding-left:50px;">
            <?php echo $form->checkBoxRow($model,'karcis_aktif', array('checked'=>'$data->karcis_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'karcis_id',array('class'=>'span5')); ?>
	<?php //echo $form->textFieldRow($model,'daftartindakan_nama',array('class'=>'span5')); ?>
	<?php //echo $form->textFieldRow($model,'ruangan_nama',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
