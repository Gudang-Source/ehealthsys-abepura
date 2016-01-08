<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'rujukandari-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php
                echo $form->dropDownListRow($model, 'asalrujukan_id', CHtml::listData(AsalrujukanM::model()->findAll(), 'asalrujukan_id', 'asalrujukan_nama'),array('empty'=>'-- Pilih --',
                'onkeypress'=>"return $(this).focusNextInputField(event)")); 
            ?>
            <?php echo $form->textFieldRow($model,'namaperujuk',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'spesialis',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'alamatlengkap',array('rows'=>5, 'cols'=>30, 'class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'notelp',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'rujukandari_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'asalrujukan_id',array('class'=>'span3')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
