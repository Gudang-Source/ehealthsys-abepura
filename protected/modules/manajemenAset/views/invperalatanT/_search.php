<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'guinvperalatan-t-search',
        'type'=>'horizontal',
)); ?>
<table width="100%">
    <tr>
        <td>
            <?php echo $form->textFieldRow($model,'invperalatan_kode',array('class'=>'span3','maxlength'=>50, 'placeholder'=>'Ketik Kode')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'invperalatan_noregister',array('class'=>'span3','maxlength'=>50, 'placeholder'=>'Ketik No. Register')); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model,'invperalatan_namabrg',array('class'=>'span3','maxlength'=>100, 'placeholder'=>'Ketik Nama Barang')); ?>
        </td>
    </tr>
    <tr>
        <td colspan="3">
            <?php echo $form->checkBoxRow($model,'invperalatan_ijinoperasional'); ?>
        </td>
    </tr>
</table>
	<?php //echo $form->textFieldRow($model,'invperalatan_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'lokasi_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'barang_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'asalaset_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'pemilikbarang_id',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_merk',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_ukuran',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_bahan',array('class'=>'span3','maxlength'=>100)); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_thnpembelian',array('class'=>'span3','maxlength'=>5)); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_tglguna',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_nopabrik',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_norangka',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_nomesin',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_nopolisi',array('class'=>'span3','maxlength'=>50)); ?>

	<?php // echo $form->textFieldRow($model,'invperalatan_nobpkb',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_harga',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_akumsusut',array('class'=>'span3')); ?>

	<?php //echo $form->textAreaRow($model,'invperalatan_ket',array('rows'=>6, 'cols'=>50, 'class'=>'span8')); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_kapasitasrata',array('class'=>'span3','maxlength'=>10)); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_serftkkalibrasi',array('class'=>'span3','maxlength'=>20)); ?>

	<?php // echo $form->textFieldRow($model,'invperalatan_umurekonomis',array('class'=>'span3')); ?>

	<?php //echo $form->textFieldRow($model,'invperalatan_keadaan',array('class'=>'span3','maxlength'=>50)); ?>

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
    <?php  
            $content = $this->renderPartial('gudangUmum.views.mutasibrgT.tips.informasi',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>  
</div>

<?php $this->endWidget(); ?>


           
