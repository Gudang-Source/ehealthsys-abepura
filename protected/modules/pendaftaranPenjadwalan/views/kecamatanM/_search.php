<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppkecamatan-m-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'kecamatan_nama'),
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model,'kecamatan_id',array('class'=>'span5')); ?>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'kabupaten_id',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'kabupaten_id',  CHtml::listData($model->KabupatenItems, 'kabupaten_id', 'kabupaten_nama'),array('class'=>'span3', 'style'=>'width:160px', 'onkeyup'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'kecamatan_nama',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'kecamatan_nama',array('class'=>'span3','maxlength'=>50)); ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'kecamatan_namalainnya',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'kecamatan_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'kecamatan_aktif', array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
            
            
            
	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
