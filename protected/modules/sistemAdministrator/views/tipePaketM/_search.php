<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'satipe-paket-m-search',
        'type'=>'horizontal',
)); ?>

	<?php //echo $form->textFieldRow($model,'tipepaket_id',array('class'=>'span5')); ?>

	<?php echo $form->dropDownListRow($model,'kelaspelayanan_id', CHtml::listData(SAPendaftaranT::model()->getKelasPelayananItems(), 'kelaspelayanan_id', 'kelaspelayanan_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>

	<?php //echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData(PendaftaranT::model()->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
//                                                'ajax' => array('type'=>'POST',
//                                                    'url'=> Yii::app()->createUrl('ActionDynamic/GetPenjaminPasien',array('encode'=>false,'namaModel'=>'SATipePaketM')), 
//                                                    'update'=>'#'.CHtml::activeId($model,'penjamin_id').'' //selector to update
//                                                ),
//                                            ));
        ?>

        <?php //echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData(PendaftaranT::model()->getPenjaminItems($model->carabayar_id), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>

	<?php echo $form->textFieldRow($model,'tipepaket_nama',array('class'=>'span3','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'tipepaket_singkatan',array('class'=>'span5','maxlength'=>20)); ?>

	<?php //echo $form->textFieldRow($model,'tipepaket_namalainnya',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'tglkesepakatantarif',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'nokesepakatantarif',array('class'=>'span5','maxlength'=>50)); ?>

	<?php //echo $form->textFieldRow($model,'tarifpaket',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'paketsubsidiasuransi',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'paketsubsidipemerintah',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'paketsubsidirs',array('class'=>'span5')); ?>

	<?php //echo $form->textFieldRow($model,'paketiurbiaya',array('class'=>'span5')); ?>

	<?php echo $form->checkBoxRow($model,'tipepaket_aktif', array('checked'=>'$data->tipepaket_aktif')); ?>

	<div class="form-actions">
		                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
	</div>

<?php $this->endWidget(); ?>
