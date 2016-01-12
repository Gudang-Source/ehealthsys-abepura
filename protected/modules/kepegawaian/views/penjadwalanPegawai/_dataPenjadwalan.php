<div class="row-fluid">
	<div class="span4">
		<div class="control-group">
			<?php echo $form->labelEx($model,'periodebuatjadwal',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php   
					$model->periodebuatjadwal = (!empty($model->periodebuatjadwal) ? date("d/m/Y",strtotime($model->periodebuatjadwal)) : null);
					$this->widget('MyDateTimePicker',array(
											'model'=>$model,
											'attribute'=>'periodebuatjadwal',
											'mode'=>'date',
											'options'=> array(
												'showOn' => false,
//												'minDate' => 'd',
												'yearRange'=> "-150:+0",
											),
											'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
											),
				)); ?>
				<?php echo $form->error($model, 'periodebuatjadwal'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($model,'sampaidengan',array('class'=>'control-label')); ?>
			<div class="controls">
				<?php   
					$model->sampaidengan = (!empty($model->sampaidengan) ? date("d/m/Y",strtotime($model->sampaidengan)) : null);
					$this->widget('MyDateTimePicker',array(
											'model'=>$model,
											'attribute'=>'sampaidengan',
											'mode'=>'date',
											'options'=> array(
												'showOn' => false,
//												'minDate' => 'd',
												'yearRange'=> "-150:+0",
											),
											'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
											),
				)); ?>
				<?php echo $form->error($model, 'sampaidengan'); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Kelompok Pegawai','', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'kelompokpegawai_id',  CHtml::listData($model->KelompokpegawaiItems, 'kelompokpegawai_id', 'kelompokpegawai_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
			</div>
		</div>  
	</div>
	<div class="span8">
		<div class="control-group">
			<?php echo CHtml::label('Instalasi','', array('class'=>'control-label required')) ?>
			<div class="controls">
				<?php 
					echo $form->dropDownList($model,'instalasi_id', $instalasiAsal, 
					array('class'=>'span3','empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)",
							'onchange'=>'getRuanganForCheckBox(this);'));
				?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Ruangan','', array('class'=>'control-label')) ?>			
			<div class="controls" class="box" id="ruangan">
				&nbsp;<?php  echo CHtml::checkBox('check_all','true',array('onclick'=>'checkSemua(this);'));?> Pilih Semua
				<table style="width:500px;" id="tabel-ruangan">					
					<tbody>
						
					</tbody>
				</table>
			</div>
		</div>
	</div>
</div>
<div class="form-actions">
	<?php  echo CHtml::htmlButton(Yii::t('mds','{icon} Tambah',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'getPenjadwalan();', 'onkeypress'=>'getPenjadwalan();')); ?>	
</div>