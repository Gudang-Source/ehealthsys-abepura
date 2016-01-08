<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
     'id'=>'sajenis-kelas-m-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'jeniskelas_id',  CHtml::listData($model->JenisKelasItems, 'jeniskelas_id', 'jeniskelas_nama'),array('class'=>'span3','empty'=>'-- Pilih --')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kelaspelayanan_nama',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'kelaspelayanan_aktif',array('checked'=>'kelaspelayanan_aktif')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'kelaspelayanan_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'jeniskelas_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'kelaspelayanan_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
