<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'sajenis-kegiatan-m-search',
        'type'=>'horizontal',
)); ?>
        <table>
            <tr>
                <td>
                    <?php echo $form->textFieldRow($model,'jeniskegiatan_kode',array('class'=>'span3 custom-only','maxlength'=>25)); ?>
                    <?php echo $form->textFieldRow($model,'jeniskegiatan_ruangan',array('class'=>'span3 custom-only','maxlength'=>25)); ?>
                </td>
                <td>
                    <?php echo $form->textFieldRow($model,'jeniskegiatan_nama',array('class'=>'span3 custom-only','maxlength'=>100)); ?>
                </td>
            </tr>
            <tr>
                <td colspan="2">
                    <?php echo $form->checkBoxRow($model,'jeniskegiatan_aktif',Array('checked'=>'$data->jeniskegiatan_aktif')); ?>
                </td>
            </tr>
        </table>
	<?php //echo $form->textFieldRow($model,'komponenunit_id',array('class'=>'span5')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
