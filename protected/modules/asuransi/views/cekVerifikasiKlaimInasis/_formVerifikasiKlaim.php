<div class="row-fluid">
	<div class="span4">
		<div class="control-group ">
			<label class="control-label">
				<?php
					echo CHtml::radioButton('radio_tglmasuk', false, array(
						'value'=>'radio_tglmasuk',
						'onclick'=>'setTanggal(this);',
						'id'=>'radio_tglmasuk',
						'uncheckValue'=>null
					))." Tanggal Masuk"; 
				?>
			</label>
			<div class="controls">
				<?php   
					$this->widget('MyDateTimePicker',array(
						'model'=>$modVerifikasiInasis,
						'attribute'=>'verifikasiinasis_tglmasuk',
						'mode'=>'date',
						'options'=> array(
//							'maxDate' => 'd',
						),
							'htmlOptions'=>array('class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
						),
					)); 
				?>
			</div>
		</div>
		<div class="control-group ">
			<label class="control-label">
				<?php
					echo CHtml::radioButton('radio_tglkeluar', false, array(
						'value'=>'radio_tglkeluar',
						'onclick'=>'setTanggal(this);',
						'id'=>'radio_tglkeluar',
						'uncheckValue'=>null
					))." Tanggal Keluar"; 
				?>
			</label>
			<div class="controls">
				<?php   
					$this->widget('MyDateTimePicker',array(
						'model'=>$modVerifikasiInasis,
						'attribute'=>'verifikasiinasis_tglkeluar',
						'mode'=>'date',
						'options'=> array(
//							'maxDate' => 'd',
						),
							'htmlOptions'=>array('class'=>'dtPicker2 datemask', 'onkeyup'=>"return $(this).focusNextInputField(event)"
						),
					)); 
				?>
			</div>
		</div>
	</div>
	<div class="span4">
		<?php echo $form->dropDownListRow($modVerifikasiInasis,'verifikasiinasis_jnspelayanan',  LookupM::getItems('jenispelayanan'),array('empty'=>'--Pilih--','class'=>'span3')); ?>
		<?php echo $form->dropDownListRow($modVerifikasiInasis,'verifikasiinasis_kelaspelayanan',  LookupM::getItems('kelasrawatbpjs'),array('empty'=>'--Pilih--','class'=>'span3')); ?>
	</div>
	<div class="span4">
		<?php echo $form->dropDownListRow($modVerifikasiInasis,'verifikasiinasis_status',  LookupM::getItems('statusverifikasiinacbg'),array('empty'=>'--Pilih--','class'=>'span3')); ?>
	</div>		
</div>
<div class="form-actions">
	<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cek Verifikasi',array('{icon}'=>'<i class="icon-search icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'cekVerifikasi(this);', 'onkeypress'=>'cekVerifikasi(this);','rel'=>'tooltip','title'=>'Klik untuk mengecek data yang terverifikasi BPJS')); ?>
</div>