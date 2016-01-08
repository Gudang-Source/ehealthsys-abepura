<div class="white-container">
<legend class="rim2">Data <b>Rumah Sakit</b></legend>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'saprofil-rumah-sakit-m-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'focus'=>'#SAProfilRumahSakitM_tahunprofilrs',
        'htmlOptions'=>array('enctype'=>'multipart/form-data','onKeyPress'=>'return disableKeyPress(event)'),
)); ?>

	<?php echo $form->errorSummary($model); ?>
<?php
    $nama_kapital = ((Yii::app()->user->getState('nama_huruf_capital') == true) ? "all-caps":"");
    $alamat_kapital = ((Yii::app()->user->getState('alamat_huruf_capital') == true) ? "all-caps":"");
?>


<div class="row-fluid">
	<div class = "span4">
		<fieldset class="box">
			<legend class="rim">Identitas Rumah Sakit</legend>
			<div class="control-group">
				<?php echo CHtml::label('Tahun Profil','Tahun Profil',array('class'=>'control-label'));?>
				<div class="controls">
					<?php echo $form->textField($model,'tahunprofilrs',array('class'=>'span1 numbers-only',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>30)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Tahun','Tahun',array('class'=>'control-label'));?>
				<div class="controls">
					<?php echo $form->textField($model,'tahun_diresmikan',array('class'=>'span1 numbers-only',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>30)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Kode Rumah Sakit <span class="required">*</span>','Kode Rumah Sakit', array('class'=>'control-label required')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'nokode_rumahsakit',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>10)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Tanggal Registrasi','Tanggal Registrasi',array('class'=>'control-label'));?>
				<div class="controls">  
				   <?php $this->widget('MyDateTimePicker',array(
										 'model'=>$model,
										 'attribute'=>'tglregistrasi',
										 'mode'=>'date',
										 'options'=> array(
											 'dateFormat'=>Params::DATE_FORMAT,
										 ),
										 'htmlOptions'=>array('readonly'=>true,
															   'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span3','style'=>'width:152px'),
				 )); ?> 
				 </div>
			</div>
			<?php echo $form->textFieldRow($model,'npwp',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>25)); ?>
			<div class="control-group">
				<?php echo CHtml::label('Nama Rumah Sakit <span class="required">*</span>','Kode Rumah Sakit', array('class'=>'control-label required')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'nama_rumahsakit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>100)); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Kode / Jenis Rumah Sakit <span class="required">*</span>','Kode / Jenis Rumah Sakit', array('class'=>'control-label required')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'kodejenisrs_profilrs',array('style'=>'float:left; width:30px', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>10,'readonly'=>true)); ?>
				</div>
				<?php echo $form->dropDownList($model,'jenisrs_profilrs', LookupM::getItems('jenisrs_profilrs'),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:150px','onchange'=>'setKodeJenisRs(this.value);')); ?>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Kode / Nama Penyelenggara','Kode / Nama Penyelenggara', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'kodestatuskepemilikanrs',array('style'=>'float:left; width:30px', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>10,'readonly'=>true)); ?>
				</div>
				<?php echo $form->dropDownList($model,'namakepemilikanrs', LookupM::getItems('namakepemilikanrs'),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:150px','onchange'=>'setKodePemilikRs(this.value); setDropdownKelasRS(this.value);')); ?>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Kelas Rumah Sakit','Kelas Rumah Sakit', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->dropDownList($model,'kelas_rumahsakit', SALookupM::getItemsKelasRS($model->namakepemilikanrs),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
					<?php // echo $form->dropDownList($model,'kelas_rumahsakit', CHtml::listData(SALookupM::getItemsKelasRS($model->namakepemilikanrs), 'lookup_name', 'lookup_name') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Nama Dirtektur Rumah Sakit','Nama Dirtektur Rumah Sakit', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php 
						$this->widget('MyJuiAutoComplete', array(
										'model'=>$model,
										'attribute'=>'namadirektur_rumahsakit',
										'source'=>'js: function(request, response) {
													   $.ajax({
														   url: "'.$this->createUrl('AutocompleteNamaDirektur').'",
														   dataType: "json",
														   data: {
															   nama_pegawai: request.term,
															   tanggal_lahir: $("#'.CHtml::activeId($model,'tanggal_lahir').'").val(),
														   },
														   success: function (data) {
																   response(data);
														   }
													   })
													}',
										 'options'=>array(
											   'minLength' => 2,
												'focus'=> 'js:function( event, ui ) {
													 $(this).val( "");
													 return false;
												 }',
											   'select'=>'js:function( event, ui ) {
													$("#'.CHtml::activeId($model,'namadirektur_rumahsakit').'").val(ui.item.nama_pegawai);
													return false;
												}',
										),
										'tombolDialog' => array('idDialog' => 'dialogPegawai'),
										'htmlOptions'=>array('placeholder'=>'Nama Direktur RS','rel'=>'tooltip','title'=>'Ketik Nama untuk masukan data / mencari pasien','onkeyup'=>"return $(this).focusNextInputField(event)",'class'=>'span3 '),
									)); 
					?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class = "span4">
		<fieldset class="box">
			<legend class="rim">Alamat / Lokasi Rumah Sakit</legend>
			<div class="control-group">
				<?php echo CHtml::label('Alamat dan Kode Pos','Kode Rumah Sakit', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'alamatlokasi_rumahsakit',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Negara','Negara', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'negara',array('class'=>'span3 '.$nama_kapital, 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model, 'propinsi_id', array('class'=>'control-label')); ?>
				<div class="controls">
				   <?php echo $form->dropDownList($model,'propinsi_id', CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'), 
							   array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3',
									   'ajax'=>array('type'=>'POST',
												   'url'=>$this->createUrl('SetDropdownKabupaten',array('encode'=>false,'model_nama'=>get_class($model))),
												   'update'=>"#".CHtml::activeId($model, 'kabupaten_id'),
									   ),
									   'onchange'=>"setClearDropdownKelurahan();setClearDropdownKecamatan();",));?>
				   <?php echo $form->error($model, 'propinsi_id'); ?>
			   </div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model, 'kabupaten_id', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php
					echo $form->dropDownList($model, 'kabupaten_id', CHtml::listData($model->getKabupatenItems($model->propinsi_id), 'kabupaten_id', 'kabupaten_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",'class'=>'span3',
						'ajax' => array('type' => 'POST',
							'url' => $this->createUrl('SetDropdownKecamatan', array('encode' => false, 'model_nama' => get_class($model))),
							'update' => '#'.CHtml::activeId($model, 'kecamatan_id')),
						'onchange' => "setClearDropdownKelurahan();"));
					?>
					<?php echo $form->error($model, 'kabupaten_id'); ?>
				</div>
			</div>
			<div class="control-group ">
				<?php echo $form->labelEx($model, 'Kecamatan <span class=required>*</span> ', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php
					echo $form->dropDownList($model, 'kecamatan_id', CHtml::listData($model->getKecamatanItems($model->kabupaten_id), 'kecamatan_id', 'kecamatan_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",'class'=>'span3',
						'ajax' => array('type' => 'POST',
							'url' => $this->createUrl('SetDropdownKelurahan', array('encode' => false, 'model_nama' => get_class($model))),
						   'update'=>"#".CHtml::activeId($model, 'kelurahan_id'))));
					?>    
					<?php echo $form->error($model, 'kecamatan_id'); ?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($model, 'Kelurahan <span class=required>*</span> ', array('class'=>'control-label')); ?>
				<div class="controls">
					<?php
					echo $form->dropDownList($model, 'kelurahan_id', CHtml::listData($model->getKelurahanItems($model->kecamatan_id), 'kelurahan_id', 'kelurahan_nama'), array('onkeypress' => "return $(this).focusNextInputField(event)",'class'=>'span3',
						'empty' => '-- Pilih --',));
					?>
					<?php echo $form->error($model, 'kelurahan_id'); ?></td>
				</div>
			</div>
			<?php echo $form->textFieldRow($model,'no_telp_profilrs',array('class'=>'span3 ', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>15)); ?>
			<?php echo $form->textFieldRow($model,'no_faksimili',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>15)); ?>
			<?php echo $form->textFieldRow($model,'email',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
			<?php echo $form->textFieldRow($model,'website',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>50)); ?>
			<div class="control-group">
				<?php echo CHtml::label('No. Telpon Humas','No. Telpon Humas', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'notelphumas',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>15)); ?>
				</div>
			</div>
		</fieldset>
	</div>
	<div class = "span4">
		<fieldset class="box">
			<legend class="rim">Logo Rumah Sakit</legend>
			<?php echo $form->labelEx($model,'logo_rumahsakit', array('class'=>'control-label','onkeypress'=>"return nextFocus(this,event,'SAProfilRumahSakitM_tgl_suratizin','SAProfilRumahSakitM_visi')")) ?>
			<?php if(!empty($model->logo_rumahsakit)){ ?>
			<img src="<?php echo Params::urlProfilRSDirectory().$model->logo_rumahsakit ?> " style="width: 20%;padding:10px;display: block;">						
			<?php }else{
				echo "<span style='padding:10px 25px;'> Logo Rumah Sakit belum di-set</span>";
			} ?>    
			<div class="controls">  
			  <?php echo Chtml::activeFileField($model,'logo_rumahsakit',array('maxlength'=>254,'hint'=>'Isi Jika Akan Menambahkan Logo')); ?>
			</div>
		</fieldset>
		<fieldset class="box">
			<legend class="rim">Luar Rumah</legend>
			<?php echo $form->textFieldRow($model,'luastanah',array('class'=>'span3 ', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			<?php echo $form->textFieldRow($model,'luasbangunan',array('class'=>'span3 ', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</fieldset>
		<fieldset class="box">
			<legend class="rim">Setting BPJS</legend>
			<?php echo $form->textFieldRow($model,'ppkpelayanan',array('class'=>'span3 ', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</fieldset>
	</div>
</div>

<div class="row-fluid">
	<div class = "span4">
		<fieldset class="box">
			<legend class="rim">Surat Ijin / Penetapan</legend>
			<?php echo $form->textFieldRow($model,'nomor_suratizin',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>20)); ?>
			<div class="control-group">
				<?php echo $form->labelEx($model,'tgl_suratizin', array('class'=>'control-label')) ?>
				<div class="controls">  
				   <?php $this->widget('MyDateTimePicker',array(
										 'model'=>$model,
										 'attribute'=>'tgl_suratizin',
										 'mode'=>'date',
										 'options'=> array(
											 'dateFormat'=>Params::DATE_FORMAT,
										 ),
										 'htmlOptions'=>array('readonly'=>true,
															   'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:152px'),
				 )); ?> 
				 </div>
			</div>
			<?php echo $form->textFieldRow($model,'oleh_suratizin',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>30)); ?>
			<div class="control-group">
				<?php echo CHtml::label('Sifat Surat Izin','Sifat Surat Izin',array('class'=>'control-label'));?>
				<div class="controls">
					<?php echo $form->textField($model,'sifat_suratizin',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
				</div>
			</div>
			<?php echo $form->textFieldRow($model,'masaberlakutahun_suratizin',array('class'=>'span3 numbers-only',  'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</fieldset>
	</div>
	<div class = "span4">
		<fieldset class="box">
			<legend class="rim">Status Penyelenggara</legend>
			<div class="control-group">
				<?php echo CHtml::label('Kode / Status Penyelenggara Swasta','Kode / Status Penyelenggara Swasta', array('class'=>'control-label')) ?>
				<div class="controls">
					<?php echo $form->textField($model,'khususuntukswasta',array('style'=>'float:left; width:30px', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>10,'readonly'=>true)); ?>
				</div>
				<?php echo $form->dropDownList($model,'statusrsswasta', LookupM::getItems('statusrsswasta'),  
                        array('empty'=>'-- Pilih --', 'onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span1','style'=>'float:left; width:150px','onchange'=>'setKodeStatusSwasta(this.value);')); ?>
			</div>
		</fieldset>
		<fieldset class="box">
			<legend class="rim">Akreditasi Rumah Sakit</legend>
			<div class="control-group">
				<?php echo CHtml::label('Pentahapan Akreditasi','Pentahapan Akreditasi',array('class'=>'control-label'));?>
				<div class="controls">
				  <?php echo CHtml::dropDownList('SAProfilRumahSakitM[pentahapanakreditasrs]',$model->pentahapanakreditasrs,LookupM::getItems('pentahapanakreditasrs'),array('empty'=>'--Pilih--','class'=>'span3'));?>
				</div> 
			</div>
			<div class="control-group">
				<?php echo CHtml::label('Status Akreditasi','Status Akreditasi',array('class'=>'control-label'));?>
				<div class="controls">
				  <?php echo CHtml::dropDownList('SAProfilRumahSakitM[statusakreditasrs]',$model->statusakreditasrs,LookupM::getItems('statusakreditasrs'),array('empty'=>'--Pilih--','class'=>'span3'));?>
				</div>
			</div>
			<div class="control-group">
				<?php echo $form->labelEx($model,'tglakreditasi', array('class'=>'control-label')) ?>
				<div class="controls">  
				   <?php $this->widget('MyDateTimePicker',array(
										 'model'=>$model,
										 'attribute'=>'tglakreditasi',
										 'mode'=>'date',
										 'options'=> array(
											 'dateFormat'=>Params::DATE_FORMAT,
										 ),
										 'htmlOptions'=>array('readonly'=>true,
															   'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:160px'),
				 )); ?> 
				 </div>
			</div>
		</fieldset>
	</div>
	<div class = "span4">
		<fieldset class="box">
			<legend class="rim">Motto</legend>
				<?php echo $form->textAreaRow($model,'motto',array('rows'=>6, 'cols'=>50, 'class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
		</fieldset>
	</div>
</div>

<div class="row-fluid">
	<div class = "span12">
		<fieldset class="box">
			<legend class="rim">Visi dan Misi</legend>
			<table width="100%">
				<tr>
					<td width="33%">
						<?php echo $form->textAreaRow($model,'visi',array('rows'=>6, 'cols'=>50, 'class'=>'span4',  'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
					</td>
					<td width="67%">
						<table id="tbl-misi"  class="table table-striped table-bordered table-condensed">
							<tbody>
							<?php if(count($modMisiRS)>0) //Jika Misi Sudah Diisi
								{
									$i=1;
									foreach ($modMisiRS AS $data) : ?> 
										<tr>
											<td>
												<?php echo CHtml::label('Misi', 'Misi',array('class'=>'control-label')); ?>
												 <div class="controls">
													 <?php // echo CHtml::textField('SAMisirsM['.$i.'][misi]',$data['misi'],array('class'=>'span6',  'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
													 <?php echo CHtml::textArea('SAMisirsM['.$i.'][misi]',$data['misi'],array('rows'=>2, 'class'=>'span9',  'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
												 </div>        
											</td>
											<td>
												 <?php echo CHtml::button( '+', array('class'=>'btn btn-primary','onclick'=>'addRow(this);$(this).nextFocus()','id'=>'row1-plus')); ?>
												 <?php if ($i != 1) echo CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;')); ?>
											</td>
										</tr>
									<?php
									$i++;
									endforeach;
								}
							 else //Jika Misi Belum Diisi
								{
								 ?>
								 <tr>
									<td>
										   <?php echo CHtml::label('Misi', 'Misi',array('class'=>'control-label')); ?>
											<div class="controls">
												<?php // echo CHtml::textField('SAMisirsM[1][misi]','',array('class'=>'span3',  'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
												<?php echo CHtml::textArea('SAMisirsM[1][misi]','',array('rows'=>2, 'class'=>'span9',  'onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
											</div>        
									</td>
									<td>
										 <?php echo CHtml::button( '+', array('class'=>'btn btn-primary','onkeypress'=>"addRow(this);return $(this).focusNextInputField(event);",'onclick'=>'addRow(this);$(this).nextFocus()','id'=>'row1-plus')); ?>


									</td>
								</tr>
							<?php
								}?>
							</tbody>
						</table>
					</td>
				</tr>
			</table>
		</fieldset>
	</div>
</div>

<div class="row-fluid">
	<div class = "span12">
		<fieldset class="box">
			<legend class="rim">Gambar Rumah Sakit</legend>
				<!--fitur pengelolaan gambar2 rumah sakit akan dilakukan riset lebih lanjut. hal ini mengenai widget gallery yang digunakan. kegiatan riset dilakukan di RND-8040-->
		</fieldset>
	</div>
</div>



 
        <?php // $this->renderPartial('_profilpict', array('model'=>$modProfilPict, 'form'=>$form)); ?>
        <div class="form-actions" align="left">
		                <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                                                                     Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                                                array('class'=>'btn btn-primary', 'type'=>'submit','id'=>'btn_simpan','onKeypress'=>'return formSubmit(this,event)')); ?>
                <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
						$this->createUrl('update'), 
						array('class'=>'btn btn-danger',
							  'onclick'=>'return refreshForm(this);')); ?>
                            <?php
                            $content = $this->renderPartial('../tips/tipsaddedit',array(),true);
                            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                            ?>
                            </div>

<?php $this->endWidget(); ?>

</div>

<?php 
//========= Dialog buat cari data pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPegawai',
    'options'=>array(
        'title'=>'Pencarian Data Pegawai',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>980,
        'height'=>480,
        'resizable'=>false,
    ),
));
$modDialogPegawai = new PegawaiV('search');
$modDialogPegawai->unsetAttributes();
if(isset($_GET['PegawaiV'])) {
    $modDialogPegawai->attributes = $_GET['PegawaiV'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'datakunjungan-grid',
        'dataProvider'=>$modDialogPegawai->search(),
        'filter'=>$modDialogPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                    "id" => "selectPegawai",
                    "onClick" => "
						$(\"#'.CHtml::activeId($model,'namadirektur_rumahsakit').'\").val(\"$data->nama_pegawai\");
                        $(\"#dialogPegawai\").dialog(\"close\");
                    "))',
            ),
            'gelardepan',
            'nomorindukpegawai',
            'nama_pegawai',
            'jeniskelamin',            
            'alamat_pegawai',            
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>
        
<?php
$buttonMinus = CHtml::link('<i class="icon-minus-sign icon-white"></i>', '#', array('class'=>'btn btn-danger','onclick'=>'delRow(this); return false;'));
$confimMessage = Yii::t('mds','Do You want to remove?');
$js = <<< JSCRIPT

function addRow(obj)
{
    var tableId = $(obj).parents('table').attr('id');
    var objName = $(obj).attr('name');
    var tr = $('#'+tableId+' tbody tr:first').html();
    $('#'+tableId+' tbody tr:last').after('<tr>'+tr+'</tr>');
    $('#'+tableId+' tbody tr:last td:last').append('$buttonMinus');
    $('#'+tableId+' tbody tr:last').find('input[name$="[profilpicture_id]"]').remove();

    if (tableId == 'tbl-misi'){
        renameInput(tableId, 'SAMisirsM','misi', 'Tambah');
    }else if (tableId == 'tbl_profilpicture'){
        renameInput(tableId, 'SAProfilpictureM','profilpicture_nama', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_desc', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_path', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_id', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','display_antrian', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','temp_gambar', 'Tambah');
    }
}
		
function addRowGambar(obj)
{
    var tableId = $(obj).parents('table').attr('id');
    var objName = $(obj).attr('name');
    var tr = $('#'+tableId+' tbody tr:first').html();
    $('#'+tableId+' tbody tr:last').after('<tr>'+tr+'</tr>');
    $('#'+tableId+' tbody tr:last td:last').append('$buttonMinus');
    $('#'+tableId+' tbody tr:last').find('input[name$="[profilpicture_id]"]').remove();

    if (tableId == 'tbl-misi'){
        renameInput(tableId, 'SAMisirsM','misi', 'Tambah');
    }else if (tableId == 'tbl_profilpicture'){
        renameInput(tableId, 'SAProfilpictureM','profilpicture_nama', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_desc', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_path', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','profilpicture_id', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','display_antrian', 'Tambah');
        renameInput(tableId, 'SAProfilpictureM','temp_gambar', 'Tambah');
    }
}

function renameInput(table, modelName,attributeName,proses)
{
    var trLength = $('#'+table+' tbody tr').length;
    var proses = proses;
    var i = 1;
    $('#'+table+' tbody tr').each(function(){
        if(i==trLength && proses=='Tambah')
            {
                $(this).find('textarea[name$="['+attributeName+']"], input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
                $(this).find('textarea[name$="['+attributeName+']"], input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName);
                $(this).find('textarea[name$="['+attributeName+']"], input[name$="['+attributeName+']"]').not(':hidden').attr('value','');
                $(this).find('textarea').html('');
                $(this).find('checkbox').attr('checked','');
                
            }
        else
            {
                $(this).find('textarea[name$="['+attributeName+']"], input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
                $(this).find('textarea[name$="['+attributeName+']"], input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName);
            }
        i++;
    });
}

function delRow(obj)
{
    var tableId = $(obj).parents('table').attr('id');
    if(!confirm("$confimMessage")) return false;
    else {
        $(obj).parent().parent().remove();
        if (tableId == 'tbl-misi'){
            renameInput(tableId, 'SAMisirsM','misi', 'hapus');
        }else if (tableId == 'tbl_profilpicture'){
            renameInput(tableId, 'SAProfilpictureM','profilpicture_nama', 'hapus');
            renameInput(tableId, 'SAProfilpictureM','profilpicture_desc', 'hapus');
            renameInput(tableId, 'SAProfilpictureM','profilpicture_path', 'hapus');
            renameInput(tableId, 'SAProfilpictureM','display_antrian', 'hapus');
        }
    }
}
JSCRIPT;
Yii::app()->clientScript->registerScript('multiple input',$js, CClientScript::POS_HEAD);
?>
<script type="text/javascript">
/** bersihkan dropdown kelurahan */
function setClearDropdownKelurahan()
{
    $("#<?php echo CHtml::activeId($model,"kelurahan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

/** bersihkan dropdown kecamatan */
function setClearDropdownKecamatan()
{
    $("#<?php echo CHtml::activeId($model,"kecamatan_id");?>").find('option').remove().end().append('<option value="">-- Pilih --</option>').val('');
}

function setKodeJenisRs(jenisrs)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetKodeJenisRs'); ?>',
       data: {jenisrs : jenisrs},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($model,"kodejenisrs_profilrs");?>").val(data);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
function setKodePemilikRs(pemilikrs)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetKodePemilikRs'); ?>',
       data: {pemilikrs : pemilikrs},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($model,"kodestatuskepemilikanrs");?>").val(data);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
function setKodeStatusSwasta(statusswasta)
{
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetKodeStatusSwasta'); ?>',
       data: {statusswasta : statusswasta},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($model,"khususuntukswasta");?>").val(data);
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
function setDropdownKelasRS(pemilik)
{
	$("#SAProfilRumahSakitM_kelas_rumahsakit").addClass("animation-loading-1");
    $.ajax({
       type:'POST',
       url:'<?php echo $this->createUrl('SetDropdownKelasRS'); ?>',
       data: {pemilik : pemilik},//
       dataType: "json",
       success:function(data){
           $("#<?php echo CHtml::activeId($model,"kelas_rumahsakit");?>").html(data.listKelas);
		   $("#SAProfilRumahSakitM_kelas_rumahsakit").removeClass("animation-loading-1");
       },
        error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
    });
}
</script>
		