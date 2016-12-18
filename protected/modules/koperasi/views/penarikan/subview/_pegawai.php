<style type="text/css">
	.input-group-addon{
		cursor: pointer;
	}
</style>
<div class="row">	
	<div class="span6">
		<div class="control-group">
			<?php echo Chtml::label('No Anggota', 'nokeanggotaan', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<!--div class="input-group">
				<span class="twitter-typehead"-->
				<?php
				$this->widget('MyJuiAutoComplete',array(
                                        'attribute'=>'nokeanggotaan',
                                        'model'=>$anggota,
                                        'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getAnggotaSimpananSDByNo'),
                                        'options'=>array(
                                           'showAnim'=>'fold',
                                           'minLength' => 4,
                                           'focus'=> 'js:function( event, ui ) {
                                                $("#KeanggotaanT_nokeanggotaan").val( ui.item.value );
                                                return false;
                                            }',
                                           'select'=>'js:function( event, ui ) {
                                                loadAnggotaPegawai(ui.item.attr);
                                            }',

                                        ),
                                        'htmlOptions'=>array('placeholder'=>'No Keanggotaan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 numbersOnly'),
                                        'tombolModal'=>array('idModal'=>'dialog_anggota','idTombol'=>'tombolAnggota'),

                            ));
				?>
				<!--/span>
				<span class="input-group-addon" onclick="alert('Kick');">
					<i class="entypo-search"></i>
				</span>
				</div-->
			</div>
		</div>
		<div class="control-group">
				<?php echo $form->label($anggota, 'nama_anggota', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php //echo $form->textField($pegawai,'nama_pegawai', array('readonly'=>true, 'class'=>'form-control')); ?>
					<?php
					$this->widget('MyJuiAutoComplete',array(
		                                    'attribute'=>'nama_pegawai',
		                                    'model'=>$anggota,
		                                    'sourceUrl'=> Yii::app()->createUrl('ajaxAutoComplete/getAnggotaSimpananSDByNo', array('nama'=>1)),
		                                    'options'=>array(
		                                       'showAnim'=>'fold',
		                                       'minLength' => 3,
		                                       'focus'=> 'js:function( event, ui ) {
		                                            //$("#PegawaiM_nama_pegawai").val( ui.item.value2 );
		                                            return false;
		                                        }',
		                                       'select'=>'js:function( event, ui ) {
		                                       		$("#PegawaiM_nama_pegawai").val( ui.item.value2 );
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
			<?php echo $form->label($anggota, 'tglkeanggotaaan', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php echo $form->textField($anggota,'tglkeanggotaaan', array('readonly'=>true, 'class'=>'form-control')); ?>
				<?php echo $form->hiddenField($penarikan,'keanggotaan_id'); ?>
			</div>
		</div>
            <?php /*
		<div class="form-group">
				<?php echo $form->label($anggota, 'unit', array('class'=>'control-label col-sm-3')); ?>
				<div class="col-sm-9">
					<?php echo $form->textField($anggota, 'unit_id', array('readonly'=>true, 'class'=>'form-control')); ?>
				</div>
		</div>
             * *.
             */ ?>
		<div class="control-group">
			<?php echo $form->label($anggota, 'no_rekening', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php echo $form->textField($anggota,'no_rekening', array('readonly'=>true, 'class'=>'form-control')); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo $form->label($anggota, 'umur', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php echo $form->textField($anggota,'umur', array('readonly'=>true, 'class'=>'form-control')); ?>
			</div>
		</div>
		<!--<div class="form-group">
			<?php //echo $form->label($anggota, 'status_pegawai', array('class'=>'control-label col-sm-3')); ?>
			<div class="col-sm-9">
				<?php //echo $form->textField($anggota, 'golonganpegawai_id', array('readonly'=>true, 'class'=>'form-control')); ?>
			</div>
		</div>-->
		<div class="control-group">
				<?php echo $form->label($anggota, 'golongan', array('class'=>'control-label col-sm-3')); ?>
				<div class="controls">
					<?php echo $form->textField($anggota, 'golonganpegawai_id', array('readonly'=>true, 'class'=>'form-control')); ?>
				</div>
			</div>
	</div>

	<div class="span6">		
                <div align="center">
                    <?php 
                    $url_photopegawai = (!empty($pegawai->photopegawai) ? Params::urlPegawaiTumbsDirectory()."kecil_".$pegawai->photopegawai : Params::urlPegawaiDirectory()."no_photo.jpeg");
                    ?>
                    <img id="photo-preview" src="<?php echo $url_photopegawai?>"width="128px"/> 
                </div>
	</div>
</div>
