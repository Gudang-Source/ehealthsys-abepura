<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'gfpbf-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'pbf_kode',array('class'=>'span3','maxlength'=>20)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'pbf_nama',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo CHtml::hiddenfield('SAPbfM[pbf_singkatan]');?>
            <?php echo CHtml::hiddenfield('SAPbfM[pbf_alamat]');?>
            <?php echo CHtml::hiddenfield('SAPbfM[pbf_propinsi]');?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'pbf_aktif',array('checked'=>'pbf_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'pbf_id',array('class'=>'span3')); ?>

	
	
            

	<?php //echo $form->textFieldRow($model,'pbf_singkatan',array('class'=>'span3','maxlength'=>20)); ?>

	<?php //echo $form->textAreaRow($model,'pbf_alamat',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textFieldRow($model,'pbf_propinsi',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'pbf_kabupaten',array('class'=>'span3','maxlength'=>50)); ?>

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
