<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sarencana-keperawatan-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model,'diagnosakeperawatan_id',array('class'=>'span3')); ?>
            <?php echo $form->dropDownListRow($model,'diagnosakeperawatan_id',CHtml::listData($model->DiagnosaKeperawatanItems, 'diagnosakeperawatan_id', 'diagnosakeperawatan_kode'), array('empty'=>'--Pilih--')); ?>
            <?php echo $form->textAreaRow($model,'rencana_intervensi',array('rows'=>3, 'cols'=>30, 'class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'rencana_kode',array('class'=>'span3','maxlength'=>20)); ?>
            <?php echo $form->textAreaRow($model,'rencana_rasionalisasi',array('rows'=>3, 'cols'=>30, 'class'=>'span3')); ?>
        </td>
    </tr>
    <?php /*
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'iskolaborasiintervensi', array('checked'=>'$data->iskolaborasiintervensi')); ?>
        </td>
    </tr>
     * 
     */ ?>
</table>
	<?php //echo $form->textFieldRow($model,'rencanakeperawatan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textAreaRow($model,'rencana_intervensi',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textAreaRow($model,'rencana_rasionalisasi',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
