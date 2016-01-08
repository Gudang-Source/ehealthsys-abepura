<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kuinvoicetagihan-t-search',
        'type'=>'horizontal',
        //'focus'=>'#'.CHtml::activeId($model,'nokaskeluar'),
)); ?>
<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::label('Tanggal Invoice','tgl_awal', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
				$model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal);
						$this->widget('MyDateTimePicker',array(
										'model'=>$model,
										'attribute'=>'tgl_awal',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
				)); 
						$model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal);
					?> 
			</div>
		</div>
		<div class="control-group ">
		<label for="namaPasien" class="control-label">
		   Sampai dengan
		</label>
			<div class="controls">
				<?php    
					$model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir);
					$this->widget('MyDateTimePicker',array(
										'model'=>$model,
										'attribute'=>'tgl_akhir',
										'mode'=>'date',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3','onclick'=>"return $(this).focusNextInputField(event)"),
					)); 
					$model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir);
					?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'invoicetagihan_no',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'invoicetagihan_no',array('class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'rekanan_tagihan',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'rekanan_tagihan',array('class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
	</div>
	<div class="span4">
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'disetujui_nama',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'disetujui_nama',array('class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo CHtml::activeLabel($model,'verifikator_nama',array('class'=>'control-label')); ?>
			<div class="controls">
			   <?php echo $form->textField($model,'verifikator_nama',array('class'=>'span3', 'maxlength'=>20,'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
	</div>	
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), $this->createUrl('InformasiPembayaranGaji/Index'), array('class'=>'btn btn-danger')); ?>
    <?php
        $content = $this->renderPartial('../tips/informasi_penggajianKaryawan',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
