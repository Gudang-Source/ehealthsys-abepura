<div class="row">
	
		<?php echo $form->hiddenField($permintaan, 'keanggotaan_id'); ?>
		<?php echo CHtml::hiddenField('v_gaji', 0); ?>
		<?php echo CHtml::hiddenField('v_insentif', 0); ?>
		<?php echo CHtml::hiddenField('v_simpanan', 0); ?>

	
	<div class="span6">
		<div class="control-group">
			<?php echo $form->label($permintaan, 'tglpermohonanpinjaman', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<!--<div class="input-group">-->
				<?php
				//$this->widget('bootstrap.widgets.TbDateTimePicker', array(
				//	'model'=>$permintaan, 'attribute'=>'tglpermohonanpinjaman', 'htmlOptions'=>array('class'=>'form-control'), 'options'=>array('format'=>'dd/mm/yyyy H:i'),
			//	));
				?>
                                     <?php   
                                        $this->widget('MyDateTimePicker',array(
					'model'=>$permintaan,
					'attribute'=>'tglpermohonanpinjaman',
					'mode'=>'date',
					'options'=> array(
						'dateFormat'=>Params::DATE_FORMAT,
						'maxDate' => 'd',
					),
					'htmlOptions'=>array('class'=>'dtPicker3', 'onkeyup'=>"return $(this).focusNextInputField(event)"),
				)); ?>
				<!--<div class='input-group-addon' onclick="$('#PermohonanpinjamanT_tglpermohonanpinjaman').focus();">
        					<a>
            			<i class='entypo-calendar'></i>
        					</a>
    					</div>
					</div>-->
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($permintaan, 'no_permohonan', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->textField($permintaan, 'nopermohonan', array('readonly'=>true, 'class'=>'form-control')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($permintaan, 'jenispinjaman_permohonan', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->dropDownList($permintaan, 'jenispinjaman_permohonan', Params::jenisPinjaman(), array('empty'=>'-- Pilih --', 'readonly'=>false, 'class'=>'form-control', 'onchange'=>'cekJenisPinjaman();')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php //echo $form->label($permintaan, 'jmlpinjaman', array('class'=>'control-label col-sm-4')); ?>
			<label class="control-label col-sm-4" for="PermohonanpinjamanT_jmlpinjaman">Jml Pinjaman<span class="required">*</span></label>
			<div class="controls">
				<?php echo $form->textField($permintaan, 'jmlpinjaman', array('readonly'=>false, 'class'=>'form-control num')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php //echo $form->label($permintaan, 'untukkeperluan', array('class'=>'control-label col-sm-4')); ?>
			<label class="control-label col-sm-4" for="PermohonanpinjamanT_untukkeperluan">Untuk Keperluan<span class="required">*</span></label>
			<div class="controls">
				<?php echo $form->textArea($permintaan,'untukkeperluan',array('rows'=>6, 'cols'=>50, 'class'=>'form-control',)); ?>
			</div>
		</div>
		<div class="control-group">
			<?php //echo $form->label($permintaan, 'jangkawaktu_pinj_bln', array('class'=>'control-label col-sm-4')); ?>
			<label class="control-label col-sm-4" for="PermohonanpinjamanT_jangkawaktu_pinj_bln">Jangka Waktu<span class="required">*</span></label>
			<div class="controls">
				<?php echo $form->textField($permintaan, 'jangkawaktu_pinj_bln', array('readonly'=>false, 'class'=>'span2')); ?>
                                <?php echo CHtml::label('Bulan', '', array('class'=>'')); ?>
			</div>
			
		</div>
		<div class="control-group">
			<?php echo $form->label($permintaan, 'jasapinjaman_bln', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->hiddenField($permintaan, 'jasapinjaman_bln', array('id'=>'persen_jasa', 'readonly'=>false, 'class'=>'form-control num-des')); ?>
				<?php echo $form->textField($permintaan, 'jasapinjaman_bln', array('readonly'=>false, 'class'=>'span2')); ?>
                                <?php echo CHtml::label('%', '', array('class'=>'')); ?>
			</div>
			
		</div>
	</div>
	<div class="pspan6">
		<div class="control-group">
			<?php //echo $form->label($permintaan, 'sumber_potongan', array('class'=>'control-label col-sm-4')); ?>
			<label class="control-label" for="PermohonanpinjamanT_sumber_potongan">Sumber Potongan<span class="required">*</span></label>
			<div class="controls">
                            <table>
				<?php
					$sumber = PotongansumberM::model()->findAll(array('condition'=>'potongansumber_aktif = true', 'order'=>'potongansumber_id asc'));
					foreach ($sumber as $item) : ?>
					<tr>
                                            <td>
					<?php echo CHtml::checkBox('potongansumber_id['.$item->potongansumber_id.']', !empty($potongan[$item->potongansumber_id])?true:false, array('value'=>$item->potongansumber_id, 'class'=>'potongan', 'uncheckValue'=>null, 'onchange'=>'cekPotonganInput(this)')); ?>
                                            <label>
					<?php echo $item->namapotongan; ?>
                                            </label>
                                            </td>
                                        <tr>
                                        
					
					
				<?php endforeach;
				?>
                            </table>
				<?php /* echo $form->dropDownList($permintaan, 'potongansumber_id',
					CHtml::listData(PotongansumberM::model()->findAll(array('condition'=>'potongansumber_aktif = true', 'order'=>'potongansumber_id asc')), 'potongansumber_id', 'namapotongan'),
					array('empty'=>'-- Pilih --', 'readonly'=>false, 'class'=>'form-control')); */ ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($permintaan, 'jmlgaji', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->textField($permintaan, 'jmlgaji', array('readonly'=>false, 'class'=>'form-control num')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($permintaan, 'jmlinsentif', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->textField($permintaan, 'jmlinsentif', array('readonly'=>false, 'class'=>'form-control num')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($permintaan, 'jmlsimpanan', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->textField($permintaan, 'jmlsimpanan', array('readonly'=>false, 'class'=>'form-control num')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($permintaan, 'jmlpenghasilanlain', array('class'=>'control-label col-sm-4')); ?>
			<div class="controls">
				<?php echo $form->textField($permintaan, 'jmlpenghasilanlain', array('readonly'=>false, 'class'=>'form-control num')); ?>
			</div>
		</div>
	</div>
</div>
