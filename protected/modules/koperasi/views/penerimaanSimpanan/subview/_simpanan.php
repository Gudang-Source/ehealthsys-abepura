
	<?php echo $form->hiddenField($simpanan, 'keanggotaan_id'); ?>
	
	<?php 
	//if (is_array($simpanan->jenissimpanan_id)) echo $this->renderPartial('subview/viewsimpanan/_simpananPokokWajib', array('simpanan'=>$simpanan, 'form'=>$form)); 
	//else if ($simpanan->jenissimpanan_id == Params::ID_SIMPANAN_SUKARELA || $simpanan->jenissimpanan_id == Params::ID_SIMPANAN_JASA_SUKARELA) echo $this->renderPartial('subview/viewsimpanan/_simpananSukarela', array('simpanan'=>$simpanan, 'form'=>$form)); 
	//else if ($simpanan->jenissimpanan_id == Params::ID_SIMPANAN_DEPOSITO) echo $this->renderPartial('subview/viewsimpanan/_simpananDeposito', array('simpanan'=>$simpanan, 'form'=>$form)); 
        
       // echo $this->renderPartial('subview/viewsimpanan/_simpananPokokWajib', array('simpanan'=>$simpanan, 'form'=>$form)); 
	//echo $this->renderPartial('subview/viewsimpanan/_simpananSukarela', array('simpanan'=>$simpanan, 'form'=>$form)); 
	//echo $this->renderPartial('subview/viewsimpanan/_simpananDeposito', array('simpanan'=>$simpanan, 'form'=>$form)); 
        echo $this->renderPartial('subview/viewsimpanan/_jenisSimpanan', array('simpanan'=>$simpanan, 'form'=>$form)); 
	?>

        

        <hr />
	<div class="span4">
		
		<div class="control-group">
			<?php echo $form->labelEx($simpanan, 'tglsimpanan', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
			<!--<div class="input-group">-->
			<?php 
				//$this->widget('bootstrap.widgets.TbDateTimePicker', array(
				//	'model'=>$simpanan, 'attribute'=>'tglsimpanan', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
				//));
			?>
                            
                        <?php   
                                $this->widget('MyDateTimePicker',array(
                                'model'=>$simpanan,
                                'attribute'=>'tglsimpanan',
                                'mode'=>'date',
                                'options'=> array(
                                        'dateFormat'=>Params::DATE_FORMAT,
                                        'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
                        )); ?>
			<!--<div class='input-group-addon' onclick="$('#SimpananT_tglsimpanan').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>-->
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($simpanan, 'keterangansimpanan', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->textArea($simpanan,'keterangansimpanan',array('rows'=>6, 'cols'=>50, 'class'=>'form-control', 'placeholder'=>'Ketikan '.$simpanan->getAttributeLabel('keterangansimpanan'),)); ?>
			</div>
		</div>
	</div>
	<div class="span8">
		<div class="control-group">
			<?php echo $form->labelEx($kasmasuk, 'jmlpembayaran', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->textField($kasmasuk,'jmlpembayaran', array('readonly'=>true, 'empty'=>'-- Pilih --', 'class'=>'form-control num bkm')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php //echo $form->labelEx($kasmasuk, 'biayaadministrasi', array('class'=>'control-label col-sm-4')); ?>
			<label class="control-label col-sm-4" for="PermohonanpinjamanT_biayaadministrasi">Biaya Administrasi<span class="required">*</span></label>
			<div class="controls">
				<?php echo $form->textField($kasmasuk,'biayaadministrasi', array('empty'=>'-- Pilih --', 'class'=>'form-control num bkm')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($kasmasuk, 'biayamaterai', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->textField($kasmasuk,'biayamaterai', array('empty'=>'-- Pilih --', 'class'=>'form-control num bkm')); ?>
			</div>
		</div>
		<hr />
		<div class="control-group">
			<?php echo $form->labelEx($kasmasuk, 'uangditerima', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->textField($kasmasuk,'uangditerima', array('empty'=>'-- Pilih --', 'class'=>'form-control num bkm')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->labelEx($kasmasuk, 'uangkembalian', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->textField($kasmasuk,'uangkembalian', array('empty'=>'-- Pilih --', 'class'=>'form-control num bkm')); ?>
			</div>
		</div>
	</div>
</div>