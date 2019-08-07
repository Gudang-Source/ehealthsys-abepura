<div class="row">
	
		<?php echo $form->hiddenField($pinjaman,'keanggotaan_id'); ?>
		<?php echo $form->hiddenField($pinjaman,'permohonanpinjaman_id'); ?>
		
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($pinjaman, 'tgl pencairan', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<!--<div class="input-group">-->
					<?php
					//$this->widget('bootstrap.widgets.TbDatePicker', array(
					//	'model'=>$pinjaman, 'attribute'=>'tglpinjaman', 'htmlOptions'=>array('class'=>'form-control dateEdit'), 'options'=>array('format'=>'dd/mm/yyyy'),
					//));
					?>
                                <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$pinjaman,
					'attribute'=>'tglpinjaman',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
					<!--<div class='input-group-addon' onclick="$('#PinjamanT_tglpinjaman').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>-->
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($pinjaman, ' surat peminjaman', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($pinjaman,'no_pinjaman', array('readonly'=>false, 'class'=>'form-control', 'disabled'=>true)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($pinjaman, 'jumlah pinjaman', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($pinjaman,'jml_pinjaman', array('readonly'=>false, 'class'=>'span3', 'onblur'=>'hitungBKK();')); ?>
                                        <?php echo $form->label($pinjaman, 'Rupiah ', array('class'=>'')); ?>                                        
				</div>
				
			</div>
			<div class="control-group">
				<?php echo $form->label($pinjaman, 'Jasa Pinjam (/bln)', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($pinjaman,'persen_jasa_pinjaman', array('readonly'=>false, 'class'=>'span1', 'maxlength'=>3, 'onblur'=>'hitungBKK()')); ?>
                                        <?php echo $form->label($pinjaman, '% / Rp ', array('class'=>'')); ?>
                                        <?php echo CHtml::textField('rupiah_jasa', 0, array('readonly'=>true, 'class'=>'span2')); ?>
				</div>
								
			</div>
			<div class="control-group">
				<?php echo $form->label($pinjaman, 'jangka_waktu', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($pinjaman,'jangka_waktu_bln', array('readonly'=>false, 'class'=>'span2', 'onblur'=>'hitungBKK();')); ?>
                                        <?php echo $form->label($pinjaman, 'Bulan', array('class'=>'')); ?>
				</div>				
			</div>
			<div class="control-group">
				<?php echo $form->label($pinjaman, 'jatuh_tempo', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<!--<div class="input-group">-->
					<?php
					//$this->widget('bootstrap.widgets.TbDatePicker', array(
					//	'model'=>$pinjaman, 'attribute'=>'jatuh_tempo', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy'),
					//));
					?>
                                        <?php   
                                                $this->widget('MyDateTimePicker',array(
                                                'model'=>$pinjaman,
                                                'attribute'=>'jatuh_tempo',
                                                'mode'=>'date',
                                                'options'=> array(
                                                        'dateFormat'=>Params::DATE_FORMAT,
                                                        'maxDate' => 'd',
                                                ),
                                                'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
                                        )); ?>
                                        
                                       <!-- <div class='input-group-addon' onclick="$('#PinjamanT_jatuh_tempo').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
    					</div>-->
				</div>
			</div>
                    <div class="control-group" style="padding:20px;">  

                            <hr/>
                                    <div class="panel-title">Sumber Potongan</div>  
                                    <hr/>
                        </div>
                        
			<?php 
			$sumber = PotongansumberM::model()->findAll(array('condition'=>'potongansumber_aktif = true', 'order'=>'potongansumber_id asc'));
                        
                        
			foreach ($sumber as $item) : ?>
			
			<div class="control-group">
				<label class="col-sm-4 control-label">
                                    <?php echo $item->namapotongan; ?>
					<?php echo CHtml::checkbox('potongan['.$item->potongansumber_id.'][check]', false, array("uncheckValue"=>null, 'class'=>'checkPotongan', 'onchange'=>'checkDisableInput()'))." "; ?>
				
				</label>
				<div class="controls">
					<?php echo CHtml::textField('potongan['.$item->potongansumber_id.'][text]', 0, array('class'=>'form-control num potongan', 'disabled'=>true)); ?>
                                        <label class="">Rupiah</label>
				</div>
				
			</div>
			
			<?php endforeach; ?>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($pinjaman, 'jaminan_berupa', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($pinjaman, 'jaminan_berupa', 
						array('readonly'=>false, 'class'=>'form-control')); ?>			
				</div>
			</div>
			<div class="control-group" hidden>
				<?php echo $form->label($pinjaman, 'untuk_keperluan', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textArea($pinjaman,'untuk_keperluan',array('rows'=>6, 'cols'=>50, 'class'=>'form-control',)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($pinjaman, 'cara_bayar', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->dropDownList($pinjaman,'cara_bayar', Params::caraBayarPinjaman(), array('readonly'=>false, 'class'=>'form-control')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($pinjaman, 'Angsuran sebanyak', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($pinjaman,'jml_kali_angsur', array('readonly'=>false, 'class'=>'span2', 'maxlength'=>3)); ?>
                                        <?php echo $form->label($pinjaman, 'kali', array('class'=>'')); ?>
                                        <?php echo CHtml::button('Hitung Angsuran', array('onclick'=>'loadCicilan();', 'class'=>'btn btn-blue', 'id'=>'btn-hitung')); ?>
				</div>
				
				
			</div>
		</div>	
</div>