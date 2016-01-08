<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'guinvasetlain-t-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'invasetlain_kode',array('class'=>'span3','maxlength'=>50,'placeholder'=>'Ketik kode')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'invasetlain_noregister',array('class'=>'span3','maxlength'=>50,'placeholder'=>'Ketik no. register')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'invasetlain_namabrg',array('class'=>'span3','maxlength'=>100,'placeholder'=>'Ketik nama barang')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'invasetlain_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'asalaset_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'barang_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'lokasi_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'pemilikbarang_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_judulbuku',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_spesifikasibuku',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_asalkesenian',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_jumlah',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_thncetak',array('class'=>'span3','maxlength'=>5)); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_harga',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_tglguna',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_akumsusut',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_ket',array('class'=>'span3','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_penciptakesenian',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_bahankesenian',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_jenishewan_tum',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'invasetlain_ukuranhewan_tum',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php ///echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3')); ?>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
        Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
        array('class'=>'btn btn-danger',
        'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
</div>

<?php $this->endWidget(); ?>
