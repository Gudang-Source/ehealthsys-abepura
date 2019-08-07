<div class="panel panel-body panel-primary">
	<div class="panel-heading panel-heading2">
		<div class="panel-title">Data Anggota</div>  
	</div>
	<div class="panel-body col-sm-12">
		<div class="panel-body col-sm-9">
			<div class="form-group">
				<?php echo $form->label($anggota, 'nokeanggotaan', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<!--div class="input-group">
					<span class="twitter-typehead"-->
					<?php echo $form->textField($anggota, 'nokeanggotaan', array('class'=>'form-control', 'readonly'=>true));
					/*
					$this->widget('MyJuiAutoComplete',array(
		                                    'attribute'=>'nokeanggotaan',
		                                    'model'=>$anggota,
		                                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getAnggotaByNo'),
		                                    'options'=>array(
		                                       'showAnim'=>'fold',
		                                       'minLength' => 4,
		                                       'focus'=> 'js:function( event, ui ) {
		                                            //$("#KeanggotaanT_nokeanggotaan").val( ui.item.value );
		                                            return false;
		                                        }', 
		                                       'select'=>'js:function( event, ui ) {
		                                            loadAnggotaPegawai(ui.item.attr);
		                                            return false;
		                                        }',
		
		                                    ),
		                                    'htmlOptions'=>array('placeholder'=>'No Keanggotaan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
		                                    'tombolModal'=>array('idModal'=>'dialog_anggota','idTombol'=>'tombolAnggota'),
		                                
		                        )); */
					?>
					<!--/span>
					<span class="input-group-addon" onclick="alert('Kick');">
						<i class="entypo-search"></i>
					</span>
					</div-->
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($anggota, 'nama_anggota', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($anggota, 'nama_pegawai', array('class'=>'form-control', 'readonly'=>true)); ?>
					<?php 
					?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($anggota, 'unit_kerja', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($anggota,'unit_id', array('readonly'=>true, 'class'=>'form-control')); ?>
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($anggota, 'tgl_lahirpegawai', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-4">
					<?php echo $form->textField($anggota,'tgl_lahirpegawai', array('readonly'=>true, 'class'=>'form-control')); ?>			
				</div>
				<?php echo $form->label($anggota, 'umur', array('class'=>'control-label col-sm-2')); ?>
				<div class="col-sm-3">
					<?php echo $form->textField($anggota,'umur', array('readonly'=>true, 'class'=>'form-control')); ?>			
				</div>
			</div>
			<div class="form-group">
				<?php echo $form->label($anggota, 'golongan', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($anggota, 'golonganpegawai_id', array('readonly'=>true, 'class'=>'form-control')); ?>			
				</div>
			</div>
		</div>
		
		<div class="panel-body col-sm-3">
			<img src="<?php echo $anggota->photopegawai; ?>" width="150" height="200" id="photo_pegawai">
		</div>
	</div>
</div>