<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'satugaspengguna-k-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model,'peranpengguna_id',  CHtml::listData(PeranpenggunaK::model()->findAll(array('order'=>'peranpengguna_id'),'peranpengguna_aktif = true'), 'peranpengguna_id', 'peranpenggunanama'),array('empty'=>'','class'=>'span3')); ?>
            <?php echo $form->dropDownListRow($model,'modul_id',  CHtml::listData(ModulK::model()->findAll(array('order'=>'modul_kategori DESC, modul_urutan ASC'),'modul_aktif = true'), 'modul_id', 'modul_nama'),array('empty'=>'','class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'tugas_nama',array('class'=>'span3','maxlength'=>200)); ?>
            <?php echo $form->textFieldRow($model,'tugas_namalainnya',array('class'=>'span3','maxlength'=>200)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'controller_nama',array('class'=>'span3','maxlength'=>100)); ?>
            <?php echo $form->textFieldRow($model,'action_nama',array('class'=>'span3','maxlength'=>100)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->textAreaRow($model,'keterangan_tugas',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>
            <div>
                <?php echo $form->checkBoxRow($model,'tugaspengguna_aktif'); ?>
            </div>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'tugaspengguna_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'peranpengguna_id',array('class'=>'span3')); ?>

            
            
            
            

	<?php //echo $form->textFieldRow($model,'modul_id',array('class'=>'span3')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
