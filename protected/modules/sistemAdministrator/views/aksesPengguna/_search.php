<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'saaksespengguna-k-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <div class="control-group">
                    <?php echo CHtml::label('Nama Pemakai','nama_pemakai',array('class'=>'control-label')); ?>
                    <div class="controls">
                            <?php echo $form->textField($model,'nama_pemakai',array('class'=>'span3')); ?>
                    </div>
            </div>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'peranpengguna_id',  CHtml::listData(PeranpenggunaK::model()->findAll(array('order'=>'peranpenggunanama ASC'),'peranpengguna_aktif = true'), 'peranpengguna_id', 'peranpenggunanama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
        </td>
        <td>
            <?php echo $form->dropDownListRow($model,'modul_id',  CHtml::listData(ModulK::model()->findAll(array('order'=>'modul_nama ASC'),'modul_aktif = true'), 'modul_id', 'modul_nama'),array('empty'=>'-- Pilih --','class'=>'span3')); ?>
        </td>
    </tr>
</table>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
