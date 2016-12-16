

		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($kaskeluar, 'tgl_bkk', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php 
						//$this->widget('bootstrap.widgets.TbDateTimePicker', array(
						///	'model'=>$kaskeluar, 'attribute'=>'tgl_bkk', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
						//));
					?>
                                         <?php   
                                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$kaskeluar,
                                                'attribute'=>'tgl_bkk',
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
				<?php echo $form->label($kaskeluar, 'no_bkk', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kaskeluar, 'no_bkk', array('class'=>'form-control', 'readonly'=>'true')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($kaskeluar, 'jmlkaskeluar', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kaskeluar, 'jmlkaskeluar', array('class'=>'form-control num', 'readonly'=>true)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($kaskeluar, 'cara_kas_keluar', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($kaskeluar, 'cara_kas_keluar', Params::caraPembayaran(), array('class'=>'form-control')); ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($kaskeluar, 'namapenerima', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kaskeluar, 'namapenerima', array('class'=>'form-control')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($kaskeluar, 'alamatpenerima', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($kaskeluar, 'alamatpenerima', array('class'=>'form-control')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($kaskeluar, 'untuk_pengeluaran', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textArea($kaskeluar, 'untuk_pengeluaran', array('class'=>'form-control', 'rows'=>4)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($kaskeluar, 'keterangan_bkk', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textArea($kaskeluar, 'keterangan_bkk', array('class'=>'form-control', 'rows'=>4)); ?>
				</div>
			</div>
		</div>
	