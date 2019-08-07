
<div class="row">		
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($kaskeluar, 'cara_kas_keluar', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($kaskeluar, 'cara_kas_keluar', Params::caraPembayaran(), array('class'=>'form-control')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($kaskeluar, 'keterangan', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textArea($kaskeluar,'keterangan_bkk',array('rows'=>6, 'cols'=>50, 'class'=>'form-control',)); ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<?php /*
			<div class="form-group">
				<?php echo $form->label($pinjaman, 'jml_pinjaman', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo CHtml::textField('jumlah_pinjaman', empty($pinjaman->jml_pinjaman)?'0':$pinjaman->jml_pinjaman, array('readonly'=>true, 'class'=>'form-control num', 'onblur'=>'hitungBKK()')); ?>
				</div>
			</div>*/ ?>
			<div class="control-group">
				<?php echo $form->label($kaskeluar, 'biaya administrasi<span class="required">*</span>', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kaskeluar,'biayaadministrasi', array('readonly'=>false, 'class'=>'form-control num', 'onblur'=>'hitungBKK()')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($kaskeluar, 'biaya materai<span class="required">*</span>', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kaskeluar,'biayaamaterai', array('readonly'=>false, 'class'=>'form-control num', 'onblur'=>'hitungBKK()')); ?>
				</div>
			</div>
			<?php /*
			<div class="form-group">
				<?php echo $form->label($kaskeluar, 'biaya_asuransi<span class="required">*</span>', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-3">
					<?php //$permil = empty($kaskeluar)?0:($kaskeluar->biayaasuransi*1000/$pinjaman->jml_pinjaman); ?>
					<?php echo $form->textField($poasuransi, 'premi_asuransi_persen', array('id'=>'premiasuransi', 'readonly'=>true, 'class'=>'form-control', 'style'=>'text-align: right;')); ?>
				</div>
				<?php echo $form->label($kaskeluar, '&#8240 / Rp', array('class'=>'control-label col-sm-2')); ?>
				<div class="col-sm-3">
					<?php echo $form->textField($poasuransi, 'jml_biayaasuransi', array('id'=>'biaya_asuransi', 'readonly'=>true, 'class'=>'form-control num')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($pinjaman, 'biaya_provisi_('.number_format($konfig->persenbiayaprovisasi, 2, ',', '.').' %)', array('class'=>'control-label col-sm-4')); ?>
				<?php echo CHtml::hiddenField('persen_provisi', $konfig->persenbiayaprovisasi); ?>
				<div class="col-sm-8">
					<?php //echo CHtml::textField('biaya_provisi', null, array('readonly'=>true, 'class'=>'form-control num', 'onblur'=>'hitungBKK()')); ?>
					<?php echo $form->textField($pinjaman,'biaya_administrasi', array('id'=>'biaya_provisi','readonly'=>true, 'class'=>'form-control num', 'onblur'=>'hitungBKK()')); ?>
				</div>
			</div> */ ?>
			<div class="control-group">
				<?php echo $form->labelEx($kaskeluar, 'Jml kas keluar', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kaskeluar,'jmlkaskeluar', array('readonly'=>true, 'empty'=>'-- Pilih --', 'class'=>'form-control num bkm')); ?>
				</div>
			</div>
		</div>

</div>