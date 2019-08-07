<div class="row">
		
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($permintaan, 'nomor_anggota', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php
					$this->widget('MyJuiAutoComplete',array(
		                                    'attribute'=>'nokeanggotaan',
		                                    'model'=>$permintaan,
		                                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPemohonPinjamanApprove'),
		                                    'options'=>array(
		                                       'showAnim'=>'fold',
		                                       'minLength' => 3,
		                                       'focus'=> 'js:function( event, ui ) {
		                                            $("#InformasipermohonanpinjamanV_nokeanggotaan").val( ui.item.value );
		                                            return false;
		                                        }',
		                                       'select'=>'js:function( event, ui ) {
		                                       		loadAnggotaPegawai(ui.item.attr);
		                                            return false;
		                                        }',

		                                    ),
		                                    'htmlOptions'=>array('placeholder'=>'No Keanggotaan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
		                                    'tombolModal'=>array('idModal'=>'dialog_pemohon','idTombol'=>'tombolAnggota'),

		                        ));
					?>
				</div>
			</div>
			<div>
				<div class="control-group">
					<?php echo $form->label($permintaan, 'nama_anggota', array('class'=>'control-label col-sm-4')); ?>
					<div class="controls">
						<?php // echo $form->textField($permintaan,'nama_pegawai', array('readonly'=>true, 'class'=>'form-control')); ?>
						<?php
						$this->widget('MyJuiAutoComplete',array(
		                                    'attribute'=>'nama_pegawai',
		                                    'model'=>$permintaan,
		                                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPemohonPinjamanApprove', array('nama'=>1)),
		                                    'options'=>array(
		                                       'showAnim'=>'fold',
		                                       'minLength' => 3,
		                                       'focus'=> 'js:function( event, ui ) {
		                                            $("#InformasipermohonanpinjamanV_nama_pegawai").val( ui.item.value2 );
		                                            return false;
		                                        }',
		                                       'select'=>'js:function( event, ui ) {
		                                       		loadAnggotaPegawai(ui.item.attr);
		                                            return false;
		                                        }',

		                                    ),
		                                    'htmlOptions'=>array('placeholder'=>'Nama Anggota','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
		                                    'tombolModal'=>array('idModal'=>'dialog_pemohon','idTombol'=>'tombolAnggota'),

		                        ));
					?>
					</div>
				</div>
			</div>
		<?php /*	
                    <div>
				<div class="form-group">
					<?php echo $form->label($permintaan, 'Unit Kerja', array('class'=>'control-label col-sm-4')); ?>
					<div class="col-sm-8">
						<?php echo $form->textField($permintaan,'namaunit', array('readonly'=>true, 'class'=>'form-control')); ?>
					</div>
				</div>
			</div>*/ ?>
			<div>
				<div class="control-group">
					<?php echo $form->label($permintaan, 'golongan', array('class'=>'control-label col-sm-4')); ?>
					<div class="controls">
						<?php echo $form->textField($permintaan,'golonganpegawai_nama', array('readonly'=>true, 'class'=>'form-control')); ?>
					</div>
				</div>
			</div>
			<div>
				<div class="control-group">
					<?php echo $form->label($permintaan, 'tgl_lahir / umur', array('class'=>'control-label col-sm-4')); ?>
					<div class="controls">
						<?php echo $form->textField($permintaan,'tgl_lahirpegawai', array('readonly'=>true, 'class'=>'form-control')); ?>
						<?php echo $form->hiddenField($poasuransi, 'umuranggota_thn', array('id'=>'umur')); ?>
					</div>
				</div>
			</div>
			<div>
				<div class="control-group">
					<?php echo $form->label($permintaan, 'status permohonan', array('class'=>'control-label col-sm-4')); ?>
					<div class="controls">
						<?php echo $form->textField($permintaan,'status_disetujui', array('readonly'=>true, 'class'=>'form-control')); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($permintaan, 'nopermohonan', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($permintaan,'nopermohonan', array('readonly'=>true, 'class'=>'form-control')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($permintaan, 'jmlpinjaman', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($permintaan,'jmlpinjaman', array('readonly'=>true, 'class'=>'form-control', 'style'=>'text-align:right')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($permintaan, 'jenispinjaman_permohonan', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($permintaan,'jenispinjaman_permohonan', array('readonly'=>true, 'class'=>'form-control')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($permintaan, 'batasplafon', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($permintaan,'batasplafon', array('readonly'=>true, 'class'=>'form-control', 'style'=>'text-align:right')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($permintaan, 'Tunggakan Pinjaman Uang', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($permintaan,'jmltunggakanuangpinj', array('readonly'=>true, 'class'=>'form-control', 'style'=>'text-align:right')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($permintaan, 'Tunggakan Pinjaman Barang', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($permintaan,'jmltunggakanbrgpinj', array('readonly'=>true, 'class'=>'form-control', 'style'=>'text-align:right')); ?>
				</div>
			</div>
                        <div class="control-group">
				<?php echo $form->label($permintaan, 'disetujui oleh', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($permintaan,'appr_disetujuioleh_id', array('readonly'=>true, 'class'=>'form-control')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($permintaan, 'untukkeperluan', array('class'=>'control-label col-sm-4')); ?>
				<div class="controls">
					<?php echo $form->textField($permintaan,'untukkeperluan', array('readonly'=>true, 'class'=>'form-control')); ?>
				</div>
			</div>
		</div>
	
</div>
