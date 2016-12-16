<div class="span12">		
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($kasmasuk, 'tgl_pembayaran', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
				<?php //$this->widget('bootstrap.widgets.TbDateTimePicker', array(
					//'model'=>$kasmasuk, 'attribute'=>'tglbuktibayar', 'htmlOptions'=>array('class'=>'form-control', 'readonly'=>true), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
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
				<?php echo $form->label($kasmasuk, 'nobuktimasuk', array('class'=>'control-label col-sm-4')); ?>
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
				<?php echo $form->label($kasmasuk, 'biayaadministrasi', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo CHtml::textField('persen_admin', 0, array('class'=>'span1','style'=>'width:65px;')); ?>
                                        <?php echo CHtml::label('%', 0, array('class'=>'','style'=>'padding-left:10px;')); ?>
                                        <?php echo '&nbsp;'; ?>
                                        <?php echo CHtml::label('Rp', 0, array('class'=>'','style'=>'text-align:right;padding-right:0')); ?>
                                        <?php echo $form->textField($kasmasuk, 'biayaadministrasi', array('value'=>0, 'class'=>'span2', 'readonly'=>true)); ?>
				</div>
				
			</div>
			<div class="control-group">
				<?php echo $form->label($kasmasuk, 'biaya denda', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo CHtml::textField('persen_denda', 0, array('class'=>'span1','style'=>'width:65px;')); ?>
                                        <?php echo CHtml::label('%', 0, array('class'=>'','style'=>'padding-left:10px')); ?>
                                        <?php echo '&nbsp;'; ?>
					<?php echo CHtml::label('Rp', 0, array('class'=>'','style'=>'text-align:right;padding-right:0px')); ?>
                                        <?php echo CHtml::textField('BuktikasmasukT[biayadenda]', 0, array('class'=>'span2', 'readonly'=>true)); ?>
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
				<?php echo $form->label($kasmasuk, 'no kartu', array('class'=>'control-label col-sm-4')); ?>
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
			
</div>