<div class="row">	
	<div class="span6">
		<div class="group-control">
			<?php echo $form->label($anggota, 'nokeanggotaan', array('class'=>'control-label')); ?>
			<div class="controls">
				<!--div class="input-group">
				<span class="twitter-typehead"-->
				<?php 
				/*$this->widget('MyJuiAutoComplete',array(
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
	                                        }',
	
	                                    ),
	                                    'htmlOptions'=>array('placeholder'=>'No Keanggotaan','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3 number-only'),
	                                    //'tombolModal'=>array('idModal'=>'dialog_anggota','idTombol'=>'tombolAnggota'),
                                            'tombolDialog'=>array('idDialog'=>'dialogPegawai'),
	                                
	                        ));*/
				?>
                                <?php $this->widget('MyJuiAutoComplete',array(
                                    'model'=>$anggota, 
                                    'attribute'=>'nokeanggotaan',
                                    'sourceUrl'=> $this->createUrl('/ActionAutoComplete/getAnggotaByNo/'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            //$("#KeanggotaanT_nokeanggotaan").val( ui.item.value );
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                           loadAnggotaPegawai(ui.item.attr);
                                        }',
                                    ),
                                    'htmlOptions'=>array('placeholder'=>'No Keanggotaan','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3 '),
                                    'tombolDialog'=>array('idDialog'=>'dialogAnggota',
                                    ),
                                )); ?>
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
				<?php //echo $form->textField($anggota,'nama_pegawai', array('readonly'=>true, 'class'=>'form-control')); ?>
				<?php $this->widget('MyJuiAutoComplete',array(
                                    'model'=>$anggota, 
                                    'attribute'=>'nama_pegawai',
                                    'sourceUrl'=> $this->createUrl('/ActionAutoComplete/getAnggotaByNama/'),
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 4,
                                       'focus'=> 'js:function( event, ui ) {
                                            //$("#KeanggotaanT_nokeanggotaan").val( ui.item.value );
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                           loadAnggotaPegawai(ui.item.attr);
                                        }',
                                    ),
                                    'htmlOptions'=>array('placeholder'=>'No Keanggotaan','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3 '),
                                    'tombolDialog'=>array('idDialog'=>'dialogAnggota',
                                    ),
                                )); ?>
			</div>
		</div>
            
                <div class="control-group">
			<?php echo Chtml::label("Tanggal Lahir", 'tgl_lahirpegawai', array('class'=>'control-label')); ?>
			<div class="controls">
				<?php echo $form->textField($anggota,'tgl_lahirpegawai', array('readonly'=>true, 'class'=>'form-control')); ?>			
			</div>			
		</div>
                <div class="control-group">
                    <?php echo Chtml::label("Umur", 'umur', array('class'=>'control-label col-sm-1')); ?>
                    <div class="controls">
                            <?php echo CHtml::textField('umur', '', array('readonly'=>true, 'class'=>'form-control')); ?>			
                    </div>
                </div>
		<div class="control-group">
			<?php echo Chtml::label("Tanggal Keanggotaan", 'tglkeanggotaaan', array('class'=>'control-label col-sm-3')); ?>
			<div class="controls">
				<?php echo $form->textField($anggota,'tglkeanggotaaan', array('readonly'=>true, 'class'=>'form-control')); ?>
			</div>
		</div> 
        </div>
    
        <div class="span6">
            <img src="<?php echo $anggota->photopegawai; ?>" width="150" height="200" id="photo_pegawai">
		<?php /*<div class="form-group">
			<?php echo $form->label($anggota, 'unit_kerja', array('class'=>'control-label col-sm-3')); ?>
			<div class="col-sm-9">
				<?php echo $form->textField($anggota,'unit_id', array('readonly'=>true, 'class'=>'form-control')); ?>
			</div>
		</div> */ ?>
		<?php /*
		<div class="form-group">
			<?php echo $form->label($anggota, 'jml angsuran', array('class'=>'control-label col-sm-3')); ?>
			<div class="col-sm-4">
				<?php echo CHtml::textField('jml_angsuran', $berhenti->jmltunggakan_berhenti, array('readonly'=>true, 'class'=>'form-control num')); ?>			
			</div>
		</div> */ ?>
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