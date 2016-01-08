<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'ppkelurahan-m-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'kecamatan_id'),
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model,'kelurahan_id',array('class'=>'span5')); ?>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'kecamatan_id',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'kecamatan_id',  CHtml::listData($model->KecamatanItems, 'kecamatan_id', 'kecamatan_nama'),array('class'=>'span3', 'style'=>'width:160px', 'onkeyup'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'kelurahan_namalainnya',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'kelurahan_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'kelurahan_nama',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'kelurahan_nama',array('class'=>'span3','maxlength'=>50)); ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'kode_pos',array('class'=>'span3','maxlength'=>15)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model,'kelurahan_aktif',array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
            
            
            
	

	

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
