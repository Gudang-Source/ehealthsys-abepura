
	
        <div class="span6">
			<div class="control-group">
				<?php echo $form->label($kasmasuk, 'tgl_pembayaran', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
				<?php //$this->widget('bootstrap.widgets.TbDateTimePicker', array(
				//	'model'=>$kasmasuk, 'attribute'=>'tglbuktibayar', 'htmlOptions'=>array('class'=>'form-control', 'readonly'=>true), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
				//)); ?>
                                    
                                    <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$kasmasuk,
					'attribute'=>'tglbuktibayar',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($kasmasuk, 'no_BKM', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kasmasuk, 'nobuktimasuk', array('class'=>'form-control', 'readonly'=>true)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($kasmasuk, 'jmlpembayaran', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kasmasuk, 'jmlpembayaran', array('class'=>'form-control num', 'readonly'=>true)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php //echo $form->label($kasmasuk, 'biayaadministrasi', array('class'=>'control-label col-sm-4')); ?>
				<label class="control-label col-sm-4" for="PermohonanpinjamanT_biayaadministrasi">Biaya Administrasi<span class="required">*</span></label>
				<div class="controls">
					<?php echo $form->textField($kasmasuk, 'biayaadministrasi', array('class'=>'form-control num', 'readonly'=>false)); ?>
				</div>
			</div>
			<hr />
			<div class="control-group">
				<?php echo $form->label($kasmasuk, 'uangditerima', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kasmasuk, 'uangditerima', array('class'=>'form-control num')); ?>
				</div>			
			</div>
			<div class="control-group">
				<?php echo $form->label($kasmasuk, 'uangkembalian', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kasmasuk, 'uangkembalian', array('class'=>'form-control num', 'readonly'=>true)); ?>
				</div>			
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($kasmasuk, 'keterangan_pembayaran', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textArea($kasmasuk, 'keterangan_pembayaran', array('class'=>'form-control', 'rows'=>6)); ?>
				</div>			
			</div>
			<div class="control-group">
				<?php echo $form->label($kasmasuk, 'cara pembayaran', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($kasmasuk, 'carapembayaran', Params::caraBayarPinjaman(), array('class'=>'form-control')); ?>
				</div>			
			</div>
			<div class="control-group">
				<?php echo $form->label($kasmasuk, 'no rekening', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kasmasuk, 'nokartu', array('class'=>'form-control')); ?>
				</div>			
			</div>
			<div class="control-group">
				<?php echo $form->label($kasmasuk, 'nama bank', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kasmasuk, 'bankkartu', array('class'=>'form-control')); ?>
				</div>			
			</div>
		</div>
	