<?php
$this->breadcrumbs=array(
	'Mcu',
);
if(isset($_GET['sukses'])){
	Yii::app()->user->setFlash('success',"Data Resiko Penyakit Jantung Koroner berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'id'=>'jantungkoroner-mcu-form',
    'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)',
							'onsubmit'=>'return requiredCheck(this);'),
)); ?>

<div class="formInputTab">
<?php echo $form->errorSummary($modJantungKoroner); ?>
<legend class="rim">Resiko Penyakit Jantung Koroner</legend>
<fieldset class="box white-container" id="form-pasien">
	<legend class="rim">Data Pasien</legend>
	<?php
		$this->renderPartial($this->path_view.'_dataPasien',array('modPendaftaran'=>$modPendaftaran,'modPasien'=>$modPasien,'modPegawai'=>$modPegawai,'form'=>$form,'modJantungKoroner'=>$modJantungKoroner));
	?>
</fieldset>
<fieldset class="box white-container">
<legend class="rim">Review</legend>
	<div class="row-fluid">
		<div class="span6">
			<fieldset class="box">
				A. Review faktor-faktor yang tertera pada nomor 1 dan 2.
				<ol type="1">
					<li><?php echo $form->checkBox($modJantungKoroner,'isriwayat_chd_a', array('rel'=>'tooltip', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkJumlahFaktorA();')) ?>
						Riwayat CHD (Coronary Heart Disease)
						<ol style="list-style-type: lower-latin;margin-left: 30px;">
							<li>Mycordinal Infraction (Heart Attack)</li>
							<li>Angina stabil atau tidak stabil</li>
							<li>Koroner setelah ada tindakan (operasi bypass atau angioplasty)</li>
							<li>Bukti isnemia miolard klinis yang signifikan</li>
						</ol>
					</li>
					<li><?php echo $form->checkBox($modJantungKoroner,'isresiko_chd_a', array('rel'=>'tooltip', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkJumlahFaktorA();')) ?>
						Resiko CHD (Coronary Heart Disease)
						<ol style="list-style-type: lower-latin;margin-left: 30px;">
							<li>Gangguan Arteri Perifer</li>
							<li>Abdominal Aortic Aneursym</li>
							<li>Arteri Carotid Disease</li>
							<li>Diabetes</li>
						</ol>
					</li>
				</ol>
			</fieldset>
			
			<fieldset class="box">
				Gangguan Metabolisme (min. 3 pilihan yang sesuai) <?php echo CHtml::checkBox('ubah_metabolisme', false,array('rel'=>'tooltip','title'=>'Pilih jika akan saran ini','onclick'=>'checkFaktorMetabolisme()', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
							Ubah
				<div id="gangguan_metabolisme">
					<div class="control-group">
						<div class="controls">	
							<div class="form-inline41">
								<?php echo $form->checkBox($modJantungKoroner,'metabolisme_abdominal',array('rel'=>'tooltip', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkJumlahFaktorMetabolisme();')) ?>
								Abdominal Obesitas (Pria >102cm, wanita >88cm)
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<div class="form-inline41">
								<?php echo $form->checkBox($modJantungKoroner,'metabolisme_triglycerida', array('rel'=>'tooltip', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkJumlahFaktorMetabolisme()')) ?>
								Triglyceride >=150 mg/dl
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<div class="form-inline41">
								<?php echo $form->checkBox($modJantungKoroner,'metabolisme_hdl', array('rel'=>'tooltip', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkJumlahFaktorMetabolisme()')) ?>
								HDL Kolesterol rendah (< 40 mm/dl)
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<div class="form-inline41">
								<?php echo $form->checkBox($modJantungKoroner,'metabolisme_td', array('rel'=>'tooltip', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkJumlahFaktorMetabolisme()')) ?>
								Tekanan Darah >= 130/ >= 85 mmHg
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<div class="form-inline41">
								<?php echo $form->checkBox($modJantungKoroner,'metabolisme_glucose', array('rel'=>'tooltip', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkJumlahFaktorMetabolisme()')) ?>
								Fasting Glucose >= 110 mg/dl
							</div>
						</div>
					</div>
				</div>
			</fieldset>
		</div>
		<div class="span6">
			<fieldset class="box">
				B. Pilih (jika ada) beberapa banyak faktor yang sesuai ? <?php echo CHtml::checkBox('ubah_b', false,array('rel'=>'tooltip','title'=>'Pilih jika akan saran ini','onclick'=>'checkFaktorB()', 'onkeyup'=>"return $(this).focusNextInputField(event)")) ?>
							Ubah
				<div id="review_b">
					<div class="control-group">
						<div class="controls">
							<div class="form-inline41">
								<?php echo $form->checkBox($modJantungKoroner,'faktor_perokok_b', array('rel'=>'tooltip', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkJumlahFaktorB();')) ?>
								Perokok
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<div class="form-inline41">
								<?php echo $form->checkBox($modJantungKoroner,'faktor_hipertensi_b', array('rel'=>'tooltip', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkJumlahFaktorB();')) ?>
								Hipertensi (Tekanan Darah >= 140/90 mmHg)
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<div class="form-inline41">
								<?php echo $form->checkBox($modJantungKoroner,'faktor_hdlrendah_b', array('rel'=>'tooltip', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkJumlahFaktorB();')) ?>
								HDL Kolesterol rendah (< 40 mm/dl)
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<div class="form-inline41">
								<?php echo $form->checkBox($modJantungKoroner,'faktor_riwayat_b', array('rel'=>'tooltip', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkJumlahFaktorB();')) ?>
								Riwayat keluarga kelainan jantung
							</div>
						</div>
					</div>
					<div class="control-group">
						<div class="controls">
							<div class="form-inline41">
								<?php echo $form->checkBox($modJantungKoroner,'faktor_umur_b', array('rel'=>'tooltip', 'onkeyup'=>"return $(this).focusNextInputField(event)",'onclick'=>'checkJumlahFaktorB();')) ?>
								Umur (pria >= 45 tahun, wanita >= 55 tahun)
							</div>
						</div>
					</div>
				</div>
			</fieldset>
			<div class="control-group">
				<?php echo CHtml::label('Hasil Review','',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textArea($modJantungKoroner, 'hasil_review_ab', array('rows'=>5, 'class'=>'span5', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>false)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Hasil Gangguan Metabolisme','',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textArea($modJantungKoroner, 'gangguan_metabolisme', array('rows'=>5, 'class'=>'span5', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>false)); ?>
				</div>
			</div>
		</div>
	</div>
	<div class="row-fluid">
		<div class="span6">
			<?php echo CHtml::hiddenField('hdlpoints_point','0',array()); ?>
			<?php echo CHtml::hiddenField('umur_points','0',array()); ?>
			<?php echo CHtml::hiddenField('cholesterolpoints_point','0',array()); ?>
			<?php echo CHtml::hiddenField('smokerpoints_point','0',array()); ?>
			<?php echo CHtml::hiddenField('total_point','0',array()); ?>
			<?php echo CHtml::hiddenField('pointtotalrisk','0',array()); ?>
			<?php echo CHtml::hiddenField('yearrisk_persen','0',array()); ?>
			<?php
                echo CHtml::htmlButton('Hitung Resiko', array('onclick' => 'hitungResiko();return false;',
                    'class' => 'btn btn-primary',
                    'onkeypress' => "hitungResiko();return false;",
                    'rel' => "tooltip",
                    'title' => "Klik untuk menghitung resiko",));
			?>
			<div class="control-group">
				<?php echo CHtml::label('Hasil : Total Poin','',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modJantungKoroner, 'hasil_totalpoint', array('class'=>'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>false)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Resiko dalam 10 tahun','',array('class'=>'control-label')); ?>
				<div class="controls">
					<?php echo $form->textField($modJantungKoroner, 'hasil_resiko_persen', array('class'=>'span3', 'placeholder'=>'hasil dalam %','onkeypress' => "return $(this).focusNextInputField(event);", 'readonly'=>false)); ?> %
				</div>
			</div>
		</div>
		<div class="span6">
			
		</div>
	</div>
	</fieldset>
</div>

<div class="form-actions">
	<?php 
		$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
		$disableSave = false;
		$disableSave = (!empty($_GET['id'])) ? true : ($sukses > 0) ? true : false;; 
	?>
	<?php $disablePrint = ($disableSave) ? false : true; ?>
	<?php 
//		echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekInput();', 'onkeypress'=>'cekInputan();','disabled'=>$disableSave)); //formSubmit(this,event)        
		//  jika tanpa cek inputan
		echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
				array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
		
	?>
	<?php if(!isset($_GET['frame'])){
		echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
			$this->createUrl($this->id.'/index&pendaftaran_id='.$_GET['pendaftaran_id']), 
			array('class'=>'btn btn-danger',
				  'onclick'=>'return refreshForm(this);'));
	} ?>
	<?php
			echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
	?>
	<?php 
		$content = $this->renderPartial($this->path_view.'tips/tipsJantungKoroner',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
	?> 
</div>
<?php $this->endWidget(); ?>
<?php $this->renderPartial($this->path_view.'_jsFunctions', array('modPendaftaran'=>$modPendaftaran,'modJantungKoroner'=>$modJantungKoroner,'modPasien'=>$modPasien)); ?>

	
<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'diagramTelingaKanan',
    'options' => array(
        'title' => 'Diagram Telinga Kanan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameTelingaKanan' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'diagramTelingaKiri',
    'options' => array(
        'title' => 'Diagram Telinga Kiri',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<iframe name='frameTelingaKiri' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>