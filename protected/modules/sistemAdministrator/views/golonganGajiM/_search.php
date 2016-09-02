<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'golongan-gaji-m-search',
    'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model, 'golonganpegawai_id',CHtml::listData(SAGolonganPegawaiM::model()->findAll('golonganpegawai_aktif = true ORDER BY golonganpegawai_nama'), 'golonganpegawai_id', 'golonganpegawai_nama'), array('empty'=>'-- Pilih --')) ?>            
            <?php echo $form->textFieldRow($model,'jenisgolongan',array('class'=>'span3 custom-only','maxlength'=>50)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'masakerja',array('class'=>'span3 numbers-only','maxlength'=>15, 'style'=>'text-align:right;')); ?>            
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'jmlgaji',array('class'=>'span3 numbers-only','maxlength'=>20, 'style'=>'text-align:right;')); ?>            
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'golongangaji_aktif',array('checked'=>'golongangaji_aktif')); ?>
        </td>
    </tr>
</table>
	

	

	

	

	<div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
