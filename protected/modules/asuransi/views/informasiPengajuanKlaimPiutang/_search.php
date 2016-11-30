<legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'action'=>Yii::app()->createUrl($this->route),
	'method'=>'get',
	'id'=>'kupengklaimpiu-t-search',
        'type'=>'horizontal',
        'focus'=>'#'.CHtml::activeId($model,'nokaskeluar'),
)); ?>
<div class="row-fluid">
<div class="span6">
	<div class="control-group ">
		<?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
		<?php echo CHtml::label('Tanggal Pengajuan','tglPengajuan', array('class'=>'control-label inline')) ?>
		<div class="controls">
			<?php   
				$this->widget('MyDateTimePicker',array(
								'model'=>$model,
								'attribute'=>'tgl_awal',
								'mode'=>'date',
								'options'=> array(
									'dateFormat'=>Params::DATE_FORMAT,
									'maxDate' => 'd',
								),
								'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
								),
				)); 
			?>
		</div>
	</div>
	<div class="control-group ">
		<?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
		<?php echo CHtml::label('Sampai Dengan','sampaiDengan', array('class'=>'control-label inline')) ?>
		<div class="controls">
			<?php   
				$this->widget('MyDateTimePicker',array(
								'model'=>$model,
								'attribute'=>'tgl_akhir',
								'mode'=>'date',
								'options'=> array(
									'dateFormat'=>Params::DATE_FORMAT,
									'minDate' => 'd',
								),
								'htmlOptions'=>array('class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
								),
				)); 
			?>
		</div>
	</div>
    
            <?php echo $form->textFieldRow($model, 'nopengajuanklaimanklaim', array('class'=>'angkahuruf-only','placeholder'=>'No. Pengajuan Klaim'))  ?>
</div>
<div class="span6">
	<div class="control-group ">
		<?php echo CHtml::label('Cara Bayar',' Cara Bayar', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
					'ajax' => array('type'=>'POST',
						'url'=> $this->createUrl('GetPenjaminPasien',array('encode'=>false,'namaModel'=>'ARInformasipengajuanklaimpiutangV')), 
						'update'=>'#ARInformasipengajuanklaimpiutangV_penjamin_id'  //selector to update
					),
			 )); ?>
		</div>
	</div>
	<div class="control-group ">
		<?php echo CHtml::label('Penjamin',' Penjamin', array('class'=>'control-label')) ?>
		<div class="controls">
			<?php echo $form->dropDownList($model,'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); ?>
		</div>
	</div>
</div>
</div>			
            

	<div class="form-actions">
                <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cari',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
                <?php
    echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/barangM/admin'), array('class' => 'btn btn-danger',
        'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
    echo "&nbsp;";
    ?>
							  	<?php
$tips = array(
    '0' => 'tanggal',
    '1' => 'bayar',
    '2' => 'detail',
    '3' => 'batal',
    '4' => 'cari',
    '5' => 'ulang2'
);
$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
?>
        </div>

<?php $this->endWidget(); ?>
