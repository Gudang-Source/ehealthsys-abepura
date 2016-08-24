<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<br>
<fieldset class="box">
    <legend class="rim">Data Faktur</legend>
    
      <?php if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash("success", "Pembayaran berhasil disimpan.");
                }
                ?>
              
         
	<div class="row-fluid">
		<div class='span4'>
			<div class='control-group'>
				<?php echo CHtml::activeLabel($modTerimaPersediaan, 'tglterima',array('class'=>'control-label')); ?>
				<div class='controls'>
					<?php echo CHtml::textField('FAPendaftaranT[tglterima]', $modTerimaPersediaan->tglterima, array('readonly'=>true)); ?>
				</div>
			</div>
			<div class='control-group'>
				<?php echo CHtml::activeLabel($modTerimaPersediaan, 'tglfaktur',array('class'=>'control-label')); ?>
				<div class='controls'>
					<?php echo CHtml::textField('FAPendaftaranT[tglfaktur]', $modTerimaPersediaan->tglfaktur, array('readonly'=>true)); ?>
				</div>
			</div>
			<div class='control-group'>
				<?php echo CHtml::activeLabel($modTerimaPersediaan, 'totalharga',array('class'=>'control-label')); ?>
				<div class='controls'>
					<?php echo CHtml::textField('FAPendaftaranT[totalharga]', number_format($modTerimaPersediaan->totalharga,0,"","."), array('readonly'=>true)); ?>
				</div>
			</div>
		</div>
		<div class='span4'>
			<div class='control-group'>
				<?php echo CHtml::activeLabel($modTerimaPersediaan, 'nofaktur',array('class'=>'control-label')); ?>
				<div class='controls'>
					<?php echo CHtml::textField('FAPasienM[nofaktur]', $modTerimaPersediaan->nofaktur, array('readonly'=>true)); ?>
				</div>
			</div>
			<div class='control-group'>
				<?php echo CHtml::activeLabel($modTerimaPersediaan, 'supplier_id',array('class'=>'control-label')); ?>
				<div class='controls'>
					<?php echo CHtml::textField('FAPendaftaranT[supplier_id]', $modTerimaPersediaan->pembelianbarang->supplier->supplier_nama, array('readonly'=>true)); ?>
				</div>
			</div>
		</div>
		<div class='span4'>
			<div class='control-group'>
				<?php echo CHtml::activeLabel($modTerimaPersediaan, 'keterangan_persediaan',array('class'=>'control-label')); ?>
				<div class='controls'>
					<?php echo CHtml::textArea('FAPasienM[keterangan_persediaan]', $modTerimaPersediaan->keterangan_persediaan, array('readonly'=>true)); ?>
				</div>
			</div>
			<div class='control-group'>
				<?php echo CHtml::label('No. Penerimaan','',array('class'=>'control-label')); ?>
				<div class='controls'>
					<?php echo CHtml::textField('', $modTerimaPersediaan->pembelianbarang->nopembelian, array('readonly'=>true)); ?>
				</div>
			</div>
		</div>
	</div>
</fieldset> 
