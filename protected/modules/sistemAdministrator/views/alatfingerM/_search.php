<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'alatfinger-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'namaalat',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'ipfinger',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'keyfinger',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'lokasifinger',array('rows'=>2, 'cols'=>50, 'class'=>'span5')); ?>
            <?php echo $form->textAreaRow($model,'keterangan',array('rows'=>2, 'cols'=>50, 'class'=>'span5')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'alat_aktif', array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'alatfinger_id',array('class'=>'span5')); ?>

	
            
            

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
