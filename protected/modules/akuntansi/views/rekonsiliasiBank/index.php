<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<div class="white-container">
	<?php
		if(isset($_GET['sukses'])){
			Yii::app()->user->setFlash('success',"Data Rekonsiliasi Bank berhasil disimpan");
		}
		$this->widget('bootstrap.widgets.BootAlert');
	?>
	<legend class="rim2">Transaksi <b>Rekonsiliasi Bank</b></legend>
	<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
			'id'=>'akrekonsiliasibank-t-form',
			'enableAjaxValidation'=>false,
			'type'=>'horizontal',
			'htmlOptions'=>array(
				'onKeyPress'=>'return disableKeyPress(event)',
				'onsubmit'=>'return requiredCheck(this);',
			),
			'focus'=>'#',
	));?>
	<fieldset class="box" id="form-rekonsiliasi">
		<?php echo $this->renderPartial($this->path_view.'_form',array('form'=>$form,'model'=>$model,'modRekonDetail'=>$modRekonDetail)); ?>
	</fieldset>
	
	<fieldset class="box" id="tabel-rekonsiliasi">
		<legend class="rim">Rekonsiliasi Bank</legend>
		<?php echo $this->renderPartial($this->path_view.'_formJenisRekon',array('form'=>$form,'model'=>$model,'modRekonDetail'=>$modRekonDetail)); ?>
		<div class="block-tabel" id="frmGridRekonsiliasi">
			<h6>Tabel <b>Rekonsiliasi Bank</b></h6>
			<table class="table table-bordered table-condensed table-striped" id="tabel-detailrekonsiliasi">
				<thead>
					<tr>
						<th rowspan="2">Uraian Jurnal</th>
						<th rowspan="2">Kode Rekening</th>
						<th rowspan="2">Nama Rekening</th>
						<th colspan="2" style="text-align:center;">Saldo</th>
						<th rowspan="2">Keterangan</th>
						<th rowspan="2">Batal</th>
					</tr>
					<tr>
						<th style="text-align:center;">Debit</th>
						<th style="text-align:center;">Kredit</th>
					</tr>
				</thead>
				<tbody>
					<?php
						if(count($modRekonDetail) > 0){
							foreach($modRekonDetail AS $i=> $modDetail){
								$modDetail->uraiantransaksi = isset($modDetail->jenisrekonsiliasibank_id) ? $modDetail->jenisrekonsiliasibank->jenisrekonsiliasibank_nama : "";
								$modDetail->nama_rekening = $modDetail->getNamaRekening();
								$modDetail->kode_rekening = $modDetail->getKodeRekening();
								$status = '';
								if($modDetail->saldodebit != ''){
									$status = 'debit';
								}else{
									$status = 'kredit';
								}
								echo $this->renderPartial($this->path_view.'_rowDetailRekening',array('modRekonDetail'=> $modDetail,'status'=>$status));
							}
						}
					?>
				</tbody>
			</table>
		</div>		
	</fieldset>
	<div class="form-actions">
		<?php 
			$sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
			$disableSave = false;
			$disableSave = (!empty($_GET['rekonsiliasibank_id'])) ? true : ($sukses > 0) ? true : false;; 
		?>
		<?php $disablePrint = ($disableSave) ? false : true; ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'verifikasi();', 'onkeypress'=>'verifikasi();','disabled'=>$disableSave,)); ?>
		<?php 
			echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
				$this->createUrl($this->id.'/index'), 
				array('class'=>'btn btn-danger',
					  'onclick'=>'return refreshForm(this);'));
		?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>$disablePrint,'type'=>'button','onclick'=>'print(\'PRINT\')')); ?>
		<?php	$content = $this->renderPartial('tips/tipsTransaksiRekonsiliasi',array(),true);
				$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>
    </div>
</div>
<?php echo $this->renderPartial($this->path_view.'_jsFunctions',array('model'=>$model,'modRekonDetail'=>$modRekonDetail,'modJurnal'=>$modJurnal,'modJurnalDetail'=>$modJurnalDetail)); ?>
<?php $this->endWidget(); ?>