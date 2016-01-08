<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sakelompokpegawai-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'kelompokpegawai_nama',array('class'=>'span3','maxlength'=>30)); ?>
            <?php echo $form->textFieldRow($model,'kelompokpegawai_namalainnya',array('class'=>'span3','maxlength'=>30)); ?>
            <?php echo $form->checkBoxRow($model,'kelompokpegawai_aktif',array('checked'=>'kelompokpegawai_aktif')); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'kelompokpegawai_fungsi',array('rows'=>6, 'cols'=>30, 'class'=>'span3')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'kelompokpegawai_id',array('class'=>'span5')); ?>

            

	

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
