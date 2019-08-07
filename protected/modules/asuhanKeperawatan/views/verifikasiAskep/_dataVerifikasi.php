<?php // echo $form->dropDownListRow($modTandabukti, 'dengankartu', LookupM::getItems('dengankartu'), array('required' => true,'onchange' => 'enableInputKartu()', 'empty' => '-- Pilih --', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 50));        ?>
<div class="white-container">
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::activeLabelEx($model, 'verifikasiaskep_tgl', array('class' => 'control-label inline')) ?>
				<div class="controls">
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $model,
						'attribute' => 'verifikasiaskep_tgl',
						'mode' => 'datetime',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions' => array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)"
						),
					));
					?>

				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::activeLabelEx($model, 'petugasverifikasi_nama', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					$modul = ModulK::model()->findByAttributes(
							array('modul_key' => $this->module->id)
					);
					$modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
					$this->widget('MyJuiAutoComplete', array(
						'name' => 'ASVerifikasiaskepT[petugasverifikasi_nama]',
						'value' => isset($model->petugasverifikasi_nama) ? $model->petugasverifikasi_nama : "",
						'sourceUrl' => $this->createUrl('Pegawairiwayat'),
						'options' => array(
							'showAnim' => 'fold',
							'minLength' => 4,
							'focus' => 'js:function( event, ui ) {
                                                    $("#ASVerifikasiaskepT_petugasverifikasi_nama").val( ui.item.nama_pegawai );
                                                    return false;
                                                }',
							'select' => 'js:function( event, ui ) {
                                                    $("#ASVerifikasiaskepT_petugasverifikasi_nama").val( ui.item.value );
                                                    return false;
                                                }',
						),
						'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
						'tombolDialog' => array('idDialog' => 'dialogPegawaiVerifikasi', 'idTombol' => 'tombolPasienDialog'),
					));
					?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
			<?php echo CHtml::label('Ruangan', 'ruangan_id', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->dropDownList($model,'ruangan_id',CHtml::listData(ASRuanganM::getRuangan(),'ruangan_id','ruangan_nama'),array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);",'empty'=>'--Pilih--')); ?>           
			</div>
		</div>	
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
				<?php // echo CHtml::activeHiddenField($model, 'anamesa_id',array('readonly'=>true, 'class'=>'span1')); ?>
				<?php // echo CHtml::activeHiddenField($model, 'pemeriksaanfisik_id',array('readonly'=>true, 'class'=>'span1')); ?>
				<?php echo CHtml::activeLabel($model, 'verifikasiaskep_no', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextField($model, 'verifikasiaskep_no', array('readonly' => true, 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::activeLabelEx($model, 'mengetahui_nama', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php
					$modul = ModulK::model()->findByAttributes(
							array('modul_key' => $this->module->id)
					);
					$modul_id = (isset($modul['modul_id']) ? $modul['modul_id'] : '' );
					$this->widget('MyJuiAutoComplete', array(
						'name' => 'ASVerifikasiaskepT[mengetahui_nama]',
						'value' => isset($model->mengetahui_nama) ? $model->mengetahui_nama : "",
						'sourceUrl' => $this->createUrl('Pegawairiwayat'),
						'options' => array(
							'showAnim' => 'fold',
							'minLength' => 4,
							'focus' => 'js:function( event, ui ) {
                                                    $("#ASVerifikasiaskepT_mengetahui_nama").val( ui.item.nama_pegawai );
                                                    return false;
                                                }',
							'select' => 'js:function( event, ui ) {
                                                    $("#ASVerifikasiaskepT_mengetahui_nama").val( ui.item.value );
                                                    return false;
                                                }',
						),
						'htmlOptions' => array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span2 '),
						'tombolDialog' => array('idDialog' => 'dialogPegawaiMengetahui', 'idTombol' => 'tombolPasienDialog'),
					));
					?>
				</div>
			</div>
		</div>
		<div class="span4">
			<div class="control-group">
				<?php echo CHtml::activeLabel($model, 'verifikasiaskep_ket', array('class' => 'control-label')); ?>
				<div class="controls">
					<?php echo CHtml::activeTextArea($model, 'verifikasiaskep_ket', array('class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span4">
			<div class="control-group">
			<?php echo CHtml::activelabelEx($model, 'verifikasiaskep_status', array('class' => 'control-label')) ?>
			<div class="controls">
				<?php echo CHtml::activeDropDownList($model, 'verifikasiaskep_status', array('Telah Di Verifikasi' => 'Telah Di Verifikasi',
					'Belum Di Verifikasi' => 'Belum Di Verifikasi',), array('empty' => '--Pilih--')); ?>
			</div>
		</div>
		</div>
	</div>
</div>
