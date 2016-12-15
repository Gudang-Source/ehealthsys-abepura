<div class="row">		
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($penarikan, 'jenis_simpanan', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('jenis_simpanan', null,
						CHtml::listData(JenissimpananM::model()->findAllByAttributes(array('jenissimpanan_id'=>array(3,4))), 'jenissimpanan_id', 'jenissimpanan'), 
						array('empty'=>'-- Pilih --','class'=>'form-control', 'onchange'=>'loadSimpanan()')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($penarikan, 'no_simpanan', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php echo CHtml::dropDownList('no_simpanan', null, array(), array('class'=>'form-control', 'empty'=>'-- Pilih --', 'onchange'=>'loadSimpananPilihan()')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($penarikan, 'tgl_simpanan', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php echo CHtml::textField('tgl_simpanan', null, array('class'=>'form-control', 'readonly'=>true)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($penarikan, 'lamasimpanan_bln', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php echo $form->textField($penarikan, 'lamasimpanan_bln', array('class'=>'span2', 'readonly'=>true)); ?>
                                        <?php echo $form->label($penarikan, 'bulan', array('class'=>'')); ?>
				</div>
				
			</div>
			<div class="control-group">
				<?php echo $form->label($penarikan, 'jml_pokok_pengambilan', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php echo $form->textField($penarikan, 'jml_pokok_pengambilan', array('class'=>'span3', 'readonly'=>true)); ?>
                                        <?php echo $form->label($penarikan, 'Rp', array('class'=>'')); ?>
				</div>
				
			</div>
			<div class="control-group">
				<?php echo $form->label($penarikan, 'jml_jasa_pengambilan', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php echo CHtml::textField('persen', null, array('class'=>'span1', 'readonly'=>true)); ?>
                                        <?php echo $form->label($penarikan, '%', array('class'=>'')); ?>
                                        <?php echo $form->textField($penarikan, 'jml_jasa_pengambilan', array('class'=>'span2', 'readonly'=>true)); ?>
                                        <?php echo $form->label($penarikan, '/Bln', array('class'=>'')); ?>
				</div>				
			</div>
			<div class="control-group">
				<?php echo $form->label($penarikan, 'jml_penarikan', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php echo $form->textField($penarikan, 'jml_pengambilan', array('class'=>'span3', 'readonly'=>true)); ?>
                                        <?php echo $form->label($penarikan, 'Rp', array('class'=>'')); ?>
				</div>				
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($penarikan, 'keterangan_penarikan', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textArea($penarikan, 'keterangan_pengambilan', array('class'=>'form-control', 'rows'=>4)); ?>
				</div>
			</div>
		</div>
	
</div>