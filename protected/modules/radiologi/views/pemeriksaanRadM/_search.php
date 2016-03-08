<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sapemeriksaan-rad-m-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'daftartindakan_id',CHtml::listData(DaftartindakanM::model()->findAll("daftartindakan_aktif = TRUE ORDER BY daftartindakan_nama ASC"), 'daftartindakan_id','daftartindakan_nama'),array('class'=>'span3','empty'=>'--Pilih--')); ?>
            <?php echo $form->textFieldRow($model,'pemeriksaanrad_namalainnya',array('class'=>'span3','maxlength'=>20)); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'jenispemeriksaanrad_id',CHtml::listData(JenispemeriksaanradM::model()->findAll("jenispemeriksaanrad_aktif = TRUE ORDER BY jenispemeriksaanrad_nama"), 'jenispemeriksaanrad_id','jenispemeriksaanrad_nama'),array('class'=>'span3','empty'=>'--Pilih--')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'pemeriksaanrad_nama',array('class'=>'span3','maxlength'=>20)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'pemeriksaanrad_aktif',array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'pemeriksaanrad_id',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'pemeriksaanrad_jenis',array('class'=>'span3','maxlength'=>100)); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
</div>

<?php $this->endWidget(); ?>
