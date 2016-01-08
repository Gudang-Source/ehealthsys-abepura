<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saperda-tarif-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'perdanama_sk',array('class'=>'span3','maxlength'=>200)); ?>
            <?php echo $form->textFieldRow($model,'noperda',array('class'=>'span3','maxlength'=>20)); ?>
            <?php echo $form->textFieldRow($model,'tglperda',array('class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textAreaRow($model,'perdatentang',array('rows'=>6, 'cols'=>30, 'class'=>'span4')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'ditetapkanoleh',array('class'=>'span3','maxlength'=>30)); ?>
            <?php echo $form->textFieldRow($model,'tempatditetapkan',array('class'=>'span3','maxlength'=>30)); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'perda_aktif', array('checked'=>'$data->perda_aktif')); ?>
            </div>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'perdatarif_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
