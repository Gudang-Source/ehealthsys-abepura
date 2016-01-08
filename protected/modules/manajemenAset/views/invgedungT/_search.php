<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'guinvgedung-t-search',
        'type'=>'horizontal',
)); ?>
<table>
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'invgedung_kode',array('class'=>'span2','maxlength'=>50,'placeholder'=>'Ketik kode gedung')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'invgedung_noregister',array('class'=>'span3','maxlength'=>50,'placeholder'=>'Ketik no. gedung')); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'invgedung_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'pemilikbarang_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'barang_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'lokasi_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'asalaset_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invgedung_namabrg',array('class'=>'span3','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'invgedung_kontruksi',array('class'=>'span3','maxlength'=>20)); ?>

	<?php // echo $form->textFieldRow($model,'invgedung_luaslantai',array('class'=>'span3')); ?>

	<?php // echo $form->textAreaRow($model,'invgedung_alamat',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textFieldRow($model,'invgedung_tgldokumen',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invgedung_tglguna',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invgedung_nodokumen',array('class'=>'span3','maxlength'=>20)); ?>

	<?php // echo $form->textFieldRow($model,'invgedung_harga',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invgedung_akumsusut',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invgedung_ket',array('class'=>'span3','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3')); ?>

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
