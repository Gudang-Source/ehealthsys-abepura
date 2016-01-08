<div class="white-container">
	<fieldset id ="input-penjualanaset"> 
		<?php
		$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
			'id' => 'akpenjualanaset-t-form',
			'enableAjaxValidation' => false,
			'type' => 'horizontal',
			'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)',
				'onsubmit' => 'return requiredCheck(this);'),
			'focus' => '#',
		));
		?>
			<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<legend class="rim2">Transaksi <b>Penjualan Aset Tanah</b></legend>
		<div class="control-group">
				<?php echo $form->labelEx($modAset, 'Tanggal penjualan <span class="required">*</span>', array('class' => 'control-label required')); ?>  
			<div class="controls">
				<?php
				$this->widget('MyDateTimePicker', array(
					'model' => $modAset,
					'attribute' => '[0]tglpenghapusan',
					'mode' => 'date',
					'options' => array(
						'dateFormat' => 'MM yy',
						'changeYear' => true,
						'changeMonth' => true,
						'changeDate' => false,
						'showSecond' => false,
						'showDate' => false,
						'showMonth' => false,
					// 'timeFormat' => 'hh:mm:ss',
					),
					'htmlOptions' => array('readonly' => true,
						'onkeypress' => "return $(this).focusNextInputField(event)",
						'class' => 'dtPicker3',
						'onChange' => 'ambilDataPenghapusan()',
					),
				));
				?> 
			</div>
		</div>
		<div id="div_tblInputUraian" class="block-tabel">
			<h6>Tabel <b>Aset Tanah</b></h6>
			<table id="tblInputUraian" class="table table-bordered table-condensed">
				<thead>
					<tr>
						<th rowspan="2">Pilih<br><?php echo CHtml::checkBox('checkAllAset', true, array('onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked')) ?>
						</th>
						<th>Kode Inventaris</th>
						<th>No. Register</th>
						<th>Nama Tanah / Barang</th>
						<th>Alamat</th>
						<th>Harga</th>
						<th>Harga Jual Aktiva</th>
						<th>&nbsp;</th>
					</tr>
				</thead>
				<tbody>
<?php $this->renderPartial($this->path_view . '_rowUraian', array('form' => $form, 'modAset' => $modAset)); ?>
				</tbody>
			</table>
		</div>
		<div class="form-actions">
			<?php $disableSave = (isset($_GET['sukses'])) ? 'disabled' : ''; ?>
			<?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'cekSimpanTanah()', 'onkeypress' => 'cekSimpanTanah()', 'disabled' => $disableSave)); ?>

			<?php
			echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl("/" . $this->route), array('class' => 'btn btn-danger',
				'onclick' => 'return refreshForm(this);'));
			?>
			<?php
			$content = $this->renderPartial($this->path_view . 'tips.tipsPenjualanAset', array(), true);
			$this->widget('UserTips', array('content' => $content));
			?>
		</div>
	</fieldset>
</div>
<?php $this->endWidget(); ?>

<?php $this->renderPartial($this->path_view . "_jsFunctions"); ?>
