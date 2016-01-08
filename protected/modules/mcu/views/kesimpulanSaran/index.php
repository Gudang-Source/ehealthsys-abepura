<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php
$this->widget('bootstrap.widgets.BootAlert'); ?>
<!--<legend class="rim">Kesimpulan dan Saran</legend>-->
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'hasilpemeriksaan-mcu-form',
    'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
)); ?>
<?php echo $form->errorSummary(array($ModKesimpulanMCU)); ?>

<div class="white-container">
<div class="row-fluid">
	<div class="span4">
		<fieldset class="box">
		<legend class="rim">Kesimpulan</legend>
			<div class="control-group ">
				<div class="controls">
					<div class="radio inline">
						<div class="form-inline1">
							<?php // echo $form->radioButton($ModKesimpulanMCU,'kesimpulan_radio',array(1=>'',''), array('onkeyup'=>"return $(this).focusNextInputField(event)")); ?>            
							<input type="radio" id="kesimpulan_radio" name="MCKesimpulanmcuT[kesimpulan_radio]" value="1" onclick="setTextAreaKesimpulan(this.value);">
							<?php echo $form->textArea($ModKesimpulanMCU, 'kesimpulan1_desc', array('rows'=>3, 'class'=>'span5', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
						</div>
					</div>
					<?php echo $form->error($ModKesimpulanMCU, 'kesimpulan1_status'); ?>
				</div>
			</div>
			<div class="control-group ">
				<div class="controls">
					<div class="radio inline">
						<div class="form-inline2">
							<input type="radio" id="kesimpulan_radio" name="MCKesimpulanmcuT[kesimpulan_radio]" value="2" onclick="setTextAreaKesimpulan(this.value);">
							<?php echo $form->textArea($ModKesimpulanMCU, 'kesimpulan2_desc', array('rows'=>3, 'class'=>'span5', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
						</div>
					</div>
					<?php echo $form->error($ModKesimpulanMCU, 'kesimpulan2_status'); ?>
				</div>
			</div>
			<div class="control-group ">
				<div class="controls">
					<div class="radio inline">
						<div class="form-inline3">
							<input type="radio" id="kesimpulan_radio" name="MCKesimpulanmcuT[kesimpulan_radio]" value="3" onclick="setTextAreaKesimpulan(this.value);">
							<?php echo $form->textArea($ModKesimpulanMCU, 'kesimpulan3_desc', array('rows'=>3, 'class'=>'span5', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
						</div>
					</div>
					<?php echo $form->error($ModKesimpulanMCU, 'kesimpulan3_status'); ?>
				</div>
			</div>
			<div class="control-group ">
				<div class="controls">
					<div class="form-inline4">
						<?php echo $form->checkBox($ModKesimpulanMCU, 'kesimpulan_checkbox', array('rel'=>'tooltip','title'=>'Pilih jika akan menginputkan kesimpulan perorangan','onclick'=>'checkSaran1(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
						<?php echo $form->textArea($ModKesimpulanMCU, 'kesimpulanperorangan', array('rows'=>3, 'class'=>'span5', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true,'placeholder'=>'-- Hanya diisi untuk kesimpulan perorangan --')); ?>
					</div>
					<?php echo $form->error($ModKesimpulanMCU, 'kesimpulanperorangan'); ?>
				</div>
			</div>
		</fieldset>
		<fieldset class="box">
		<legend class="rim">Keterangan</legend>
			<div class="control-group ">
				<?php echo $form->labelEx($ModKesimpulanMCU, 'Tanggal Hasil Pemeriksaan', array('class' => 'control-label')) ?>
				<div class="controls">  
					<?php
					$this->widget('MyDateTimePicker', array(
						'model' => $ModKesimpulanMCU,
						'attribute' => 'tgl_kesimpulanmcu',
						'mode' => 'date',
						'options' => array(
							'dateFormat' => Params::DATE_FORMAT,
							'maxDate' => 'd',
						),
						'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker4',
							'onkeypress' => "return $(this).focusNextInputField(event)"),
					));
					?>
				</div>
			</div>
			<?php echo $form->textAreaRow($ModKesimpulanMCU, 'keterangan_kesimpulanmcu', array('rows'=>3, 'class'=>'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			<?php echo $form->textFieldRow($ModKesimpulanMCU, 'nama_pemeriksa_kes', array('rows'=>3, 'class'=>'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
		</fieldset>
	</div>
	<div class="span4">
		<fieldset class="box">
		<legend class="rim">Saran</legend>
		<table width='100%'>
			<tr>
				<td width='100%' colspan="2">
					<div class="control-group">
						<div class="controls">
							<div class="form-inline41">
								<?php echo $form->checkBox($ModKesimpulanMCU, 'saran1_status', array('rel'=>'tooltip','title'=>'Pilih jika akan saran ini','onclick'=>'checkSaran1(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
								<?php echo $form->textField($ModKesimpulanMCU, 'saran1_desc', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event);",'style'=>'width:380px','readonly'=>true)); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width='5%'></td>
				<td width='95%'>
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline5">
								<?php echo $form->checkBox($ModKesimpulanMCU, 'saran1_1_status', array('rel'=>'tooltip','title'=>'Pilih jika akan saran ini','onclick'=>'checkSaran1(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
								<?php echo $form->textField($ModKesimpulanMCU, 'saran1_1_desc', array('class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline6">
								<?php echo $form->checkBox($ModKesimpulanMCU, 'saran1_2_status', array('rel'=>'tooltip','title'=>'Pilih jika akan saran ini','onclick'=>'checkSaran1(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
								<?php echo $form->textField($ModKesimpulanMCU, 'saran1_2_desc', array('class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td></td>
				<td>
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline7">
								<?php echo $form->checkBox($ModKesimpulanMCU, 'saran1_3_status', array('rel'=>'tooltip','title'=>'Pilih jika akan saran ini','onclick'=>'checkSaran1(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
								<?php echo $form->textField($ModKesimpulanMCU, 'saran1_3_desc', array('class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width='100%' colspan="2">
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline8">
								<?php echo $form->checkBox($ModKesimpulanMCU, 'saran2_status', array('rel'=>'tooltip','title'=>'Pilih jika akan saran ini','onclick'=>'checkSaran1(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
								<?php echo $form->textField($ModKesimpulanMCU, 'saran2_desc', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event);",'style'=>'width:380px','readonly'=>true)); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width='100%' colspan="2">
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline9">
								<?php echo $form->checkBox($ModKesimpulanMCU, 'saran3_status', array('rel'=>'tooltip','title'=>'Pilih jika akan saran ini','onclick'=>'checkSaran1(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
								<?php echo $form->textField($ModKesimpulanMCU, 'saran3_desc', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event);",'style'=>'width:380px','readonly'=>true)); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width='5%'></td>
				<td width='95%'>
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline10">
								<?php echo $form->textField($ModKesimpulanMCU, 'saran3_1_desc', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true,'style'=>'width:385px')); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width='5%'></td>
				<td width='95%'>
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline11">
								<?php echo $form->textArea($ModKesimpulanMCU, 'saran3_2_desc', array('rows'=>3, 'class'=>'', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true,'style'=>'width:385px')); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width='5%'></td>
				<td width='95%'>
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline12">
								<?php echo $form->textField($ModKesimpulanMCU, 'saran3_3_desc', array('class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true,'style'=>'width:385px')); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width='5%'></td>
				<td width='100%' colspan="2">
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline13">
								<?php echo $form->checkBox($ModKesimpulanMCU, 'saran3_3_1_status', array('rel'=>'tooltip','title'=>'Pilih jika akan saran ini','onclick'=>'checkSaran1(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
								<?php echo $form->textField($ModKesimpulanMCU, 'saran3_3_1_desc', array('class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width='5%'></td>
				<td width='100%' colspan="2">
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline14">
								<?php echo $form->checkBox($ModKesimpulanMCU, 'saran3_3_2_status', array('rel'=>'tooltip','title'=>'Pilih jika akan saran ini','onclick'=>'checkSaran1(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
								<?php echo $form->textField($ModKesimpulanMCU, 'saran3_3_2_desc', array('class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width='5%'></td>
				<td width='100%' colspan="2">
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline15">
								<?php echo $form->checkBox($ModKesimpulanMCU, 'saran3_3_3_status', array('rel'=>'tooltip','title'=>'Pilih jika akan saran ini','onclick'=>'checkSaran1(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
								<?php echo $form->textField($ModKesimpulanMCU, 'saran3_3_3_desc', array('class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width='5%'></td>
				<td width='100%' colspan="2">
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline16">
								<?php echo $form->checkBox($ModKesimpulanMCU, 'saran3_3_4_status', array('rel'=>'tooltip','title'=>'Pilih jika akan saran ini','onclick'=>'checkSaran1(this)', 'onkeyup'=>"return $(this).focusNextInputField(event)",'readonly'=>true)) ?>
								<?php echo $form->textField($ModKesimpulanMCU, 'saran3_3_4_desc', array('class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true)); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width='5%'></td>
				<td width='95%'>
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline17">
								<?php echo $form->textField($ModKesimpulanMCU, 'saran3_4_desc', array('class' => 'span5', 'onkeypress' => "return $(this).focusNextInputField(event);",'readonly'=>true,'style'=>'width:385px')); ?>
							</div>
						</div>
					</div>
				</td>
			</tr>
			<tr>
				<td width='100%' colspan="2">
					<div class="control-group ">
						<div class="controls">
							<div class="form-inline18">
								<?php echo $form->checkBox($ModKesimpulanMCU, 'saran_checkbox', array('rel'=>'tooltip','title'=>'Pilih jika akan menginputkan saran perorangan','onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkSaran1(this);')) ?>
								<?php echo $form->textArea($ModKesimpulanMCU, 'saranperorangan', array('rows'=>3, 'class'=>'span5', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>true,'placeholder'=>'-- Hanya diisi untuk saran perorangan --','style'=>'width:380px')); ?>
							</div>
							<?php echo $form->error($ModKesimpulanMCU, 'saranperorangan'); ?>
						</div>
					</div>
				</td>
			</tr>
		</table>
			
		</fieldset>
	</div>
	<div class="span4" id="tidakdisimpan">
		<fieldset class="box">
		<legend class="rim">Dokter Pribadi</legend>
			<div class="control-group ">
				<?php echo CHtml::label('Nama', 'Nama', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('dokterpribadi_nama', '', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('No. Telepon', 'No. Telepon', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('dokterpribadi_notelp', '', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</fieldset>
		<fieldset class="box">
		<legend class="rim">Yang Dihubungi Saat Darurat</legend>
			<div class="control-group ">
				<?php echo CHtml::label('Nama', 'Nama', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('dihubungidarurat_nama', '', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('Hubungan', 'Hubungan', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('dihubungidarurat_hubungan', '', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo CHtml::label('No. Telepon', 'No. Telepon', array('class' => 'control-label')) ?>
				<div class="controls">
					<?php echo CHtml::textField('dihubungidarurat_notelp', '', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				</div>
			</div>
		</fieldset>
	</div>
</div>
</div>
<div class="row-fluid">
	<div class="span12">
		<div class="form-actions">
			<?php
			if(empty($ModKesimpulanMCU->kesimpulanmcu_id)){
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan')).'&nbsp;';
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
				echo CHtml::link(Yii::t('mds', '{icon} Print Perorangan', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printMcuPerorangan();return false",'disabled'=>TRUE  ));
			}else{
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'id' => 'btn_simpan','disabled'=>true)).'&nbsp;';
				echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printMcu();return false",'disabled'=>FALSE  )).'&nbsp;';
				echo CHtml::link(Yii::t('mds', '{icon} Print Perorangan', array('{icon}'=>'<i class="icon-print icon-white"></i>')), 'javascript:void(0);', array('class'=>'btn btn-info','onclick'=>"printMcuPerorangan();return false",'disabled'=>FALSE  ));
			}
			?>
			<?php 
                $content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.transaksi',array(),true);
                $this->widget('UserTips',array('type'=>'create','content'=>$content));?>
		</div>
	</div>
</div>

<?php $this->endWidget(); ?>

<script>
/**
 * print status
 */
function printMcu(){
    window.open('<?php echo $this->createUrl('printMcu',array('kesimpulanmcu_id'=>$ModKesimpulanMCU->kesimpulanmcu_id)); ?>','printwin','left=100,top=100,width=793,height=1122');
}	
function printMcuPerorangan(){
	var tidakdisimpan = $('#tidakdisimpan').find("input,select,textarea").serialize();
    window.open('<?php echo $this->createUrl('printMcuPerorangan',array('kesimpulanmcu_id'=>$ModKesimpulanMCU->kesimpulanmcu_id)); ?>&'+tidakdisimpan,'printwin','left=100,top=100,width=793,height=1122');
}	

function setTextAreaKesimpulan(value){
	switch(value){
		case '1':
			$(".form-inline1").find('textarea').attr('readonly',false);
			$(".form-inline1").find('textarea').focus();
			$(".form-inline2").find('textarea').attr('readonly',true);
			$(".form-inline3").find('textarea').attr('readonly',true);
			break;
		case '2':
			$(".form-inline1").find('textarea').attr('readonly',true);
			$(".form-inline2").find('textarea').attr('readonly',false);
			$(".form-inline2").find('textarea').focus();
			$(".form-inline3").find('textarea').attr('readonly',true);
			break;
		case '3':
			$(".form-inline1").find('textarea').attr('readonly',true);
			$(".form-inline2").find('textarea').attr('readonly',true);
			$(".form-inline3").find('textarea').attr('readonly',false);
			$(".form-inline3").find('textarea').focus();
			break;
	}
}	

function setRadioKesimpulan(){
	var newRecord = '<?php echo !empty($ModKesimpulanMCU->kesimpulan_radio)?$ModKesimpulanMCU->kesimpulan_radio:''; ?>';
	if(newRecord == ''){
		$(".form-inline1").find('input[name$="[kesimpulan_radio]"][type="radio"]').attr('checked',true)
		setTextAreaKesimpulan('1');
	}else{
		$(".form-inline"+newRecord).find('input[name$="[kesimpulan_radio]"][type="radio"]').attr('checked',true)
		setTextAreaKesimpulan(''+newRecord+'');
	}
}



function checkSaran1(){
	var obj_kesimpulanperorangan = $("#<?php echo CHtml::activeId($ModKesimpulanMCU,"kesimpulan_checkbox");?>");
	var obj_saran1 = $("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_status");?>");
	var obj_saran2 = $("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran2_status");?>");
	var obj_saran3 = $("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_status");?>");
	var obj_saranperorangan = $("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran_checkbox");?>");
	
	
	if($(obj_kesimpulanperorangan).is(':checked')){
		$('.form-inline4').find("textarea").attr('readonly',false);
		$(".form-inline4").find('textarea').focus();
	}else{
		$('.form-inline4').find("textarea").val('');
		$('.form-inline4').find("textarea").attr('readonly',true);
	}
	
	if($(obj_saran1).is(':checked')){
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_desc");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_1_status");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_2_status");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_3_status");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_desc");?>").focus();
			if($("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_1_status");?>").is(':checked')){
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_1_desc");?>").attr('readonly',false);
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_1_desc");?>").focus();
			}else{
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_1_desc");?>").attr('readonly',true);
			}
			if($("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_2_status");?>").is(':checked')){
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_2_desc");?>").attr('readonly',false);
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_2_desc");?>").focus();
			}else{
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_2_desc");?>").attr('readonly',true);
			}
			if($("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_3_status");?>").is(':checked')){
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_3_desc");?>").attr('readonly',false);
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_3_desc");?>").focus();
			}else{
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_3_desc");?>").attr('readonly',true);
			}
	}else{
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_desc");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_1_status");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_2_status");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_3_status");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_1_status");?>").attr('checked',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_2_status");?>").attr('checked',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_3_status");?>").attr('checked',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_1_desc");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_2_desc");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran1_3_desc");?>").attr('readonly',true);
	}
	
	if($(obj_saran2).is(':checked')){
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran2_desc");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran2_desc");?>").focus();
	}else{
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran2_desc");?>").attr('readonly',true);
	}
	
	if($(obj_saran3).is(':checked')){
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_desc");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_1_desc");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_2_desc");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_desc");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_4_desc");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_1_status");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_2_status");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_3_status");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_4_status");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_desc");?>").focus();
			if($("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_1_status");?>").is(':checked')){
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_1_desc");?>").attr('readonly',false);
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_1_desc");?>").focus();
			}else{
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_1_desc");?>").attr('readonly',true);
			}
			if($("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_2_status");?>").is(':checked')){
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_2_desc");?>").attr('readonly',false);
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_2_desc");?>").focus();
			}else{
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_2_desc");?>").attr('readonly',true);
			}
			if($("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_3_status");?>").is(':checked')){
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_3_desc");?>").attr('readonly',false);
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_3_desc");?>").focus();
			}else{
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_3_desc");?>").attr('readonly',true);
			}
			if($("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_4_status");?>").is(':checked')){
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_4_desc");?>").attr('readonly',false);
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_4_desc");?>").focus();
			}else{
				$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_4_desc");?>").attr('readonly',true);
			}
	}else{
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_desc");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_1_desc");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_2_desc");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_desc");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_4_desc");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_1_status");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_2_status");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_3_status");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_4_status");?>").attr('readonly',true);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_1_status");?>").attr('checked',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_2_status");?>").attr('checked',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_3_status");?>").attr('checked',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saran3_3_4_status");?>").attr('checked',false);
	}
	
	if($(obj_saranperorangan).is(':checked')){
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saranperorangan");?>").attr('readonly',false);
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saranperorangan");?>").focus();
	}else{
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saranperorangan");?>").val('');
		$("#<?php echo CHtml::activeId($ModKesimpulanMCU,"saranperorangan");?>").attr('readonly',true);
	}
}

$(document).ready(function(){
	setRadioKesimpulan();
	checkSaran1();
});

</script>
