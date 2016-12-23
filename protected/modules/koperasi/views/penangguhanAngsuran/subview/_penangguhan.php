<style>
.num {
	text-align: right;
}
</style>
<div class="panel panel-body panel-primary">
	<div class="panel-heading panel-heading2">
		<div class="panel-title">Penangguhan Angsuran</div>  
		<?php echo $form->hiddenField($penangguhan, 'keanggotaan_id', array('value'=>$anggota->keanggotaan_id)); ?>
		<?php echo $form->hiddenField($penangguhan, 'pegawai_id', array('value'=>$anggota->pegawai_id)); ?>
		<?php echo $form->hiddenField($penangguhan, 'pengajuanpembayaran_id', array('value'=>$id)); ?>
		<?php echo $form->hiddenField($penangguhan, 'pinjaman_id', array('value'=>$pinjaman->pinjaman_id)); ?>
		<?php echo $form->hiddenField($penangguhan, 'pembayaranangsuran_id', array('value'=>$pembayaranan->pembayaranangsuran_id)); ?>
		<?php echo $form->hiddenField($penangguhan, 'jmlangsuran_id', array('value'=>$angsuran->jmlangsuran_id)); ?>
	</div>
	<div class="panel-body col-sm-12">
		<div class="panel-body col-sm-6">
			<div class="form-group">
				<?php echo $form->label($penangguhan, 'tglpermpenangguhan', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<div class="input-group">
						<?php
						$this->widget('bootstrap.widgets.TbDatePicker', array(
							'model'=>$penangguhan, 'attribute'=>'tglpermpenangguhan', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
						));
						?>
						<div class='input-group-addon'><a><i class='entypo-calendar'></i></a></div>
	    			</div>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($pinjaman, 'tgl pinjaman', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($pinjaman, 'tglpinjaman', array('class'=>'form-control', 'readonly'=>true)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($penangguhan, 'jnspenangguhan', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<div class="radio">
						<label style>
							<?php echo $form->radioButton($penangguhan, 'jnspenangguhan', array('class'=>'check', 'uncheckValue'=>null, 'value'=>'IURAN WAJIB')); ?> Iuran Wajib
						</label>
					</div>
					<div class="radio">
						<label style>
							<?php echo $form->radioButton($penangguhan, 'jnspenangguhan', array('class'=>'check', 'uncheckValue'=>null, 'value'=>'CICILAN POKOK')); ?> Cicilan Pokok
						</label>
					</div>
					<div class="radio">
						<label style>
							<?php echo $form->radioButton($penangguhan, 'jnspenangguhan', array('class'=>'check', 'uncheckValue'=>null, 'value'=>'JASA PINJAMAN')); ?> Jasa Pinjaman
						</label>
					</div>
				</div>
			</div>
		</div>
		<div class="panel-body col-sm-6">
			<div class="form-group">
				<?php echo $form->label($penangguhan, 'jumlahpinjaman', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($penangguhan, 'jumlahpinjaman', array('class'=>'form-control num', 'readonly'=>true)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($penangguhan, 'kesanggupanbayar', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($penangguhan, 'kesanggupanbayar', array('class'=>'form-control num', 'onblur'=>'hitungSisa()')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($penangguhan, 'sisapinjaman', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textField($penangguhan, 'sisapinjaman', array('class'=>'form-control num', 'readonly'=>true)); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($penangguhan, 'ketpenangguhan', array('class'=>'control-label col-sm-4')); ?>
				<div class="col-sm-8">
					<?php echo $form->textArea($penangguhan, 'ketpenangguhan', array('class'=>'form-control', 'rows'=>6)); ?>
				</div>			
			</div>
		</div>
	</div>
</div>