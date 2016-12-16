<div class="panel-body col-sm-12">
		<?php foreach ($simpanan->jenissimpanan_id as $idx): ?>
		<?php 
			$jenis = JenissimpananM::model()->findByPk($idx);
			$nos = SimpananT::model()->generateNoSimpanan($jenis->jenissimpanan_singkatan);
			$isPokok = true;
		?>
		<div class="form-group">
			<?php echo CHtml::label(CHtml::checkbox('cek_simpanan['.$idx.']', null, array('class'=>'checkee', 'uncheckValue'=>null)).' No Simpan', null, array('class'=>'control-label col-sm-2')); ?>
			<div class="col-sm-4">
				<?php echo $form->hiddenField($simpanan,'nosimpanan['.$idx.']'); ?>
				<?php echo $form->textField($simpanan,'nosimpanan['.$idx.']', array('disabled'=>$isPokok?true:false, 'value'=> $nos, 'empty'=>'-- Pilih --', 'class'=>'form-control','maxlength'=>50, 'placeholder'=>'Ketikan '.$simpanan->getAttributeLabel('jumlahsimpanan'),)); ?>
			</div>
			<?php echo $form->label($simpanan, 'Simpanan '.$jenis->jenissimpanan, array('class'=>'control-label col-sm-2')); ?>
			<div class="col-sm-4">
				<?php echo $form->hiddenField($simpanan,'jumlahsimpanan['.$idx.']'); ?>
				<?php echo $form->textField($simpanan,'jumlahsimpanan['.$idx.']', array('kumis'=>$idx, 'disabled'=>$isPokok?true:false, 'empty'=>'-- Pilih --', 'data-validate'=>'number', 'class'=>'form-control num jumlahsimpanan','maxlength'=>50, 'placeholder'=>'Ketikan '.$simpanan->getAttributeLabel('jumlahsimpanan'),)); ?>
			</div>
		</div>
		<hr />
		<?php endforeach; ?>
</div>