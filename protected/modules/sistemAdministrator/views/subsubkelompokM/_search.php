<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sasubsubkelompok-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'subkelompok_id',array('class'=>'span5')); ?>
<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'subkelompok_id',CHtml::listData(SubkelompokM::model()->findAll("subkelompok_aktif = TRUE ORDER BY subkelompok_nama ASC"), 'subkelompok_id', 'subkelompok_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
            <br>
            <?php echo $form->textFieldRow($model,'subsubkelompok_nama',array('class'=>'span5','maxlength'=>100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'subsubkelompok_kode',array('class'=>'span5','maxlength'=>50)); ?>
            <br>
            <?php echo $form->checkBoxRow($model,'subsubkelompok_aktif',array('checked'=>'subsubkelompok_aktif')); ?>
        </td>
    </tr>
    
</table>

	

	

	

	<?php //echo $form->textFieldRow($model,'subkelompok_namalainnya',array('class'=>'span5','maxlength'=>100)); ?>

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
