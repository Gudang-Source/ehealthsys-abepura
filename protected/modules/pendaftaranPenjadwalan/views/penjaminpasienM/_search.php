<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'pppenjaminpasien-m-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'carabayar_id'),
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php //echo $form->textFieldRow($model,'penjamin_id',array('class'=>'span5')); ?>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'carabayar_id',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->dropDownList($model, 'carabayar_id',CHtml::listData($model->CarabayarItems, 'carabayar_id', 'carabayar_nama'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
                </div>
            </div>
        </td>
        <td>
            <div class="control-group">
                <?php echo CHtml::activeLabel($model,'penjamin_nama',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php echo $form->textField($model,'penjamin_nama',array('class'=>'span3','maxlength'=>50)); ?>
                </div>
            </div>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'penjamin_namalainnya',array('class'=>'span3','maxlength'=>50)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'penjamin_aktif',array('checked'=>'checked')); ?>
        </td>
    </tr>
</table>
            
            	
	

	

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
