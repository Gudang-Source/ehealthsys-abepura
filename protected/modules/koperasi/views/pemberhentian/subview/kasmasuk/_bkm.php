<div class="panel panel-primary col-sm-12">
	<div class="panel-heading panel-heading2">
		<div class="panel-title">Bukti Kas Masuk</div>
	</div>
	<div class="panel-body col-sm-12">
		<div class="panel-body col-sm-6">
			<div class="form-group">
				<?php echo $form->label($kasmasuk, 'tgl_pembayaran', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
				<?php $this->widget('bootstrap.widgets.TbDateTimePicker', array(
					'model'=>$kasmasuk, 'attribute'=>'tglbuktibayar', 'htmlOptions'=>array('class'=>'form-control', 'readonly'=>true), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
				)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($kasmasuk, 'nobuktimasuk', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($kasmasuk, 'nobuktimasuk', array('class'=>'form-control', 'readonly'=>true)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($kasmasuk, 'jmlpembayaran', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($kasmasuk, 'jmlpembayaran', array('class'=>'form-control num', 'readonly'=>true)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($kasmasuk, 'biayaadministrasi', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($kasmasuk, 'biayaadministrasi', array('class'=>'bkm form-control num', 'readonly'=>false)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($kasmasuk, 'biayamaterai', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($kasmasuk, 'biayamaterai', array('class'=>'bkm form-control num', 'readonly'=>false)); ?>
				</div>
			</div>
			<?php /*
			<div class="form-group">
				<?php echo $form->label($kasmasuk, 'biaya denda', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-2">
					<?php echo CHtml::textField('persen_denda', 0, array('class'=>'form-control num','style'=>'width:65px;')); ?>
				</div>
					<?php echo CHtml::label('%', 0, array('class'=>'control-label col-sm-1','style'=>'padding-left:10px')); ?>
					<?php echo CHtml::label('Rp', 0, array('class'=>'control-label col-sm-1','style'=>'text-align:right;padding-right:0px')); ?>
				<div class="col-sm-4">

					<?php echo CHtml::textField('BuktikasmasukT[biayadenda]', 0, array('class'=>'form-control num', 'readonly'=>true)); ?>
				</div>
			</div>*/ ?>
			<hr />
			<div class="form-group">
				<?php echo $form->label($kasmasuk, 'uangditerima', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($kasmasuk, 'uangditerima', array('class'=>'bayar form-control num')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($kasmasuk, 'uangkembalian', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($kasmasuk, 'uangkembalian', array('class'=>'form-control num', 'readonly'=>true)); ?>
				</div>
			</div>
		</div>
		<div class="panel-body col-sm-6">
			<div class="form-group">
				<?php echo $form->label($kasmasuk, 'keterangan_pembayaran', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textArea($kasmasuk, 'keterangan_pembayaran', array('class'=>'form-control', 'rows'=>6)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($kasmasuk, 'cara pembayaran', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->dropDownList($kasmasuk, 'carapembayaran', Params::caraBayarPinjaman(), array('class'=>'form-control')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($kasmasuk, 'no kartu', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($kasmasuk, 'nokartu', array('class'=>'form-control')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($kasmasuk, 'nama bank', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($kasmasuk, 'bankkartu', array('class'=>'form-control')); ?>
				</div>
			</div>
		</div>

	</div>
</div>
