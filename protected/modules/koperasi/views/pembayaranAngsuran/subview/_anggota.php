	
	
		<div class="span6">
			<div class="control-group">
				<?php echo $form->label($anggota, 'no_keanggotaan', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php
					echo $form->hiddenField($anggota, 'keanggotaan_id');
					$this->widget('MyJuiAutoComplete',array(
		                                    'attribute'=>'nokeanggotaan',
		                                    'model'=>$anggota,
		                                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPeminjamAnggota'),
		                                    'options'=>array(
		                                       'showAnim'=>'fold',
		                                       'minLength' => 2,
		                                       'focus'=> 'js:function( event, ui ) {
		                                            $("#KeanggotaanV_nokeanggotaan").val( ui.item.value_1 );
		                                            $("#PinjamanT_no_pinjaman").val( ui.item.value_2 );
		                                            return false;
		                                        }',
		                                       'select'=>'js:function( event, ui ) {
		                                            loadAnggotaPegawai(ui.item.attr);
		                                            return false;
		                                        }',

		                                    ),
		                                    'htmlOptions'=>array('placeholder'=>'No Keanggotaan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
		                                    'tombolModal'=>array('idModal'=>'dialog_anggota','idTombol'=>'tombolAnggota'),

		                        ));
					?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($anggota, 'nama_anggota', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php //echo $form->textField($anggota, 'nama_pegawai', array('readonly'=>true, 'class'=>'form-control')); ?>
					<?php
					$this->widget('MyJuiAutoComplete',array(
		                                    'attribute'=>'nama_pegawai',
		                                    'model'=>$anggota,
		                                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getPeminjamAnggota', array('nama'=>1)),
		                                    'options'=>array(
		                                       'showAnim'=>'fold',
		                                       'minLength' => 2,
		                                       'focus'=> 'js:function( event, ui ) {
		                                            $("#KeanggotaanV_nokeanggotaan").val( ui.item.value_1 );
		                                            $("#KeanggotaanV_nama_pegawai").val( ui.item.value_3 );
		                                            $("#PinjamanT_no_pinjaman").val( ui.item.value_2 );
		                                            return false;
		                                        }',
		                                       'select'=>'js:function( event, ui ) {
		                                            loadAnggotaPegawai(ui.item.attr);
		                                            return false;
		                                        }',

		                                    ),
		                                    'htmlOptions'=>array('placeholder'=>'Nama Anggota','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
		                                    'tombolModal'=>array('idModal'=>'dialog_anggota','idTombol'=>'tombolAnggota'),

		                        ));
					?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->label($pinjaman, 'no_pinjaman', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php echo $form->textField($pinjaman, 'no_pinjaman', array('readonly'=>true, 'class'=>'form-control')); ?>
				</div>
			</div>
                    <?php /*
			<div class="form-group">
				<?php echo $form->label($anggota, 'namaunit', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($anggota, 'namaunit', array('readonly'=>true, 'class'=>'form-control')); ?>
				</div>
			</div>
                     * /* 
                     */ ?>
			<div class="control-group">
				<?php echo $form->label($anggota, 'golongan', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php echo CHtml::textField('status_pegawai', '', array('class'=>'form-control', 'readonly'=>true)); ?>
				</div>
			</div>
		</div>
		<div class="span6">
			<?php
			//if (!empty($anggota->photopegawai)) $photo = Params::urlPegawaiGambar().$anggota->photopegawai;
			//else $photo = '';
			?>
			<!--<img src="<?php //echo $photo; ?>" width="150" height="200" id="photo_pegawai">-->
                    <div align="center">
                        <?php 
                        $url_photopegawai = (!empty($pegawai->photopegawai) ? Params::urlPegawaiTumbsDirectory()."kecil_".$pegawai->photopegawai : Params::urlPegawaiDirectory()."no_photo.jpeg");
                        ?>
                        <img id="photo-preview" src="<?php echo $url_photopegawai?>"width="128px"/> 
                    </div>
		</div>


