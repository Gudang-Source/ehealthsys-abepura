<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'diagnosakep-m-search',
	'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Kode Diagnosa', 'diagnosakep_kode',array('class'=>'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textField($model,'diagnosakep_kode',array('class'=>'span3','maxlength'=>100)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Diagnosa Keperawatan', 'diagnosakep_nama',array('class'=>'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textField($model,'diagnosakep_nama',array('class'=>'span3','maxlength'=>100)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <div class="control-group">
                <?php echo CHtml::label('Deskripsi', 'diagnosakep_deskripsi',array('class'=>'control-label')); ?>
                <div class="controls">
                        <?php echo $form->textField($model,'diagnosakep_deskripsi',array('class'=>'span3','maxlength'=>100)); ?>
                </div>
            </div>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $form->checkBoxRow($model,'diagnosakep_aktif', array('onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
</div>

<?php $this->endWidget(); ?>
