<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>
<fieldset class="box" id="form-dataresep">
    <legend class="rim">Data Resep</legend>
    <?php echo CHtml::hiddenField('deposit',$modDeposit,array()); ?>
	<div class="span6">
		<div class="control-group ">
			<?php $modReseptur->tglreseptur = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modReseptur->tglreseptur, 'yyyy-MM-dd hh:mm:ss','medium',null)); ?>
			<?php echo $form->labelEx($modReseptur,'tglreseptur', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php   
						$this->widget('MyDateTimePicker',array(
										'model'=>$modReseptur,
										'attribute'=>'tglreseptur',
										'mode'=>'datetime',
										'options'=> array(
											'dateFormat'=>Params::DATE_FORMAT,
											'maxDate' => 'd',
											'yearRange'=> "-60:+0",
										),
										'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"
										),
				)); ?>
				<?php echo $form->error($modReseptur, 'tglreseptur'); ?>
			</div>
		</div>
		<div class="control-group ">
			<?php echo $form->labelEx($modReseptur,'noresep', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php echo $form->textField($modReseptur,'noresep', array('onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:150px;','readonly'=>true));
				?>
				<?php //echo $form->textFieldRow($modReseptur,'noresep', array('onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
		<div class="control-group">
			<?php echo CHtml::label('Jenis Resep','Jenis Resep', array('class'=>'control-label')) ?>
			<div class="controls">
				<?php
				echo CHtml::dropDownList('jenisresep','',
					array(0=>'Non Racikan',1=>'Racikan'),
					array('key'=>'jenisresep', 'class'=>'span3','onchange'=>'formjenisresep(this.value); setDropDownRke();')
				);
				?><br>
			</div>
		</div>
	</div>
	<div class="span6">
		<?php echo $form->dropDownListRow($modReseptur,'pegawai_id',CHtml::listData($modReseptur->getDokterItems(), 'pegawai_id', 'NamaLengkap'),array('onkeypress'=>"return $(this).focusNextInputField(event)"));?>
		<?php echo $form->dropDownListRow($modReseptur,'ruangan_id',CHtml::listData($modReseptur->ApotekRawatJalan, 'ruangan_id', 'ruangan_nama'),array('onkeypress'=>"return $(this).focusNextInputField(event)",'onchange'=>'setOaByRuangTujuan()'));?>
		<div class="control-group ">
			<label class="control-label" for="iter">Iter</label>
			<div class="controls">
				<?php echo CHtml::textField('iter', '0', array('readonly'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1  numbers-only')) ?>
			</div>
		</div>
	</div>
</fieldset>
<div class="row-fluid" id='formjenisresep'>
	<div class="span6">
		<fieldset class="box" id="form-nonracikan">
			 <legend class="rim">Data Obat (Non Racikan) <?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'terapiobat_reset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk me-refresh form obat non racik')); ?></legend>
                <?php echo CHtml::hiddenField('therapiobat_id', '', array('readonly'=>true)) ?>
                <div class="control-group ">
                    <?php echo CHtml::label('Kelas Therapi','therapiobat_id', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <div class="input-append" style='display:inline'>
								<?php 
									$this->widget('MyJuiAutoComplete', array(
													'name'=>'therapiobat_nama',
													'source'=>'js: function(request, response) {
																   $.ajax({
																	   url: "'.$this->createUrl('AutoCompleteTherapiObat').'",
																	   dataType: "json",
																	   data: {
																		   term: request.term,
																		   therapiobat_id: $("#therapiobat_id").val(),
																	   },
																	   success: function (data) {
																			   response(data);
																	   }
																   })
																}',
													 'options'=>array(
														   'showAnim'=>'fold',
														   'minLength' => 2,
														   'focus'=> 'js:function( event, ui ) {
																$(this).val( ui.item.label);
																return false;
															}',
														   'select'=>'js:function( event, ui ) {
																$("#therapiobat_id").val(ui.item.therapiobat_id); 
																$("#therapiobat_nama").val(ui.item.therapiobat_nama); 
																setOAJoinTerapi();
																return false;
															}',
													),
													'tombolDialog'=>array('idDialog'=>'dialogTerapiObat'),
												)); 
								?>
						</div>      
                    </div>
                </div>
				<div class="control-group ">
                    <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                    <?php echo CHtml::hiddenField('obatalkes_kode'); ?>
                    <?php echo CHtml::hiddenField('ruanganapotek_id'); ?>
					<?php echo CHtml::hiddenField('therapiobat_id2', '', array('readonly'=>true)) ?>
                    <label class="control-label" for="namaObat">Nama Obat</label>
                    <div class="controls">
                        <?php 
                            $this->widget('MyJuiAutoComplete', array(
                                            'name'=>'namaObatNonRacik',
                                            'source'=>'js: function(request, response) {
                                                           $.ajax({
                                                               url: "'.$this->createUrl('AutocompleteObatReseptur').'",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                                   ruangantujuan_id: $("#RIResepturT_ruangan_id").val(),
                                                               },
                                                               success: function (data) {
                                                                       response(data);
                                                               }
                                                           })
                                                        }',
                                             'options'=>array(
                                                   'showAnim'=>'fold',
                                                   'minLength' => 2,
                                                   'select'=>'js:function( event, ui ) {
                                                       $(this).val( ui.item.label);
                                                       $("#form-nonracikan #obatalkes_id").val(ui.item.obatalkes_id);
                                                       $("#obatalkes_kode").val(ui.item.obatalkes_kode);
													   setThreapiobat_id(ui.item.obatalkes_id);
													   $("#form-nonracikan #signa").val(ui.item.signa);
                                                        return false;
                                                    }',
                                            ),
                                            'tombolDialog'=>array('idDialog'=>'dialogObat','idTombol'=>'tombolDialogOa'),
                                            'htmlOptions'=>array("rel"=>"tooltip","title"=>"Pencarian Data Obat/Alkes",'onkeypress'=>"return $(this).focusNextInputField(event)"),
                                        )); 
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <label class="control-label">Signa</label>
                    <div class="controls">
                        <?php echo CHtml::dropDownList('signa', '', LookupM::getItems('signa_oa'),array('class'=>'inputFormTabel span3','style'=>'width:100px;','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
                    </div>
                </div>
				<div class="control-group">
					<label class="control-label">Etiket</label>
					<div class="controls">
						<?php echo CHtml::dropDownList('etiketnonracikan', '', LookupM::getItems('etiket'),array('style'=>'width:150px;')); ?>
					</div>
				</div>
                <div class="control-group ">
                    <label class="control-label" for="qty">Jumlah</label>
                    <div class="controls">
                        <?php echo CHtml::textField('qtyNonRacik', '1', array('readonly'=>false,'onblur'=>'$("#qty").val(this.value);','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1 numbers-only')) ?>
                    </div>
                </div>
                <div class="control-group ">
                    <label class="control-label" for=""></label>
                    <div class="controls">
                        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                                array('onclick'=>'tambahObatNonRacik(this);return false;',
                                      'class'=>'btn btn-primary',
                                      'onkeypress'=>"tambahObatNonRacik(this);return false;",
                                      'rel'=>"tooltip",
                                      'title'=>"Klik untuk menambahkan ke tabel resep",)); ?>
                    </div>
                </div>
		</fieldset>
		<fieldset class="box" id="form-racikan" >
				<legend class="rim">Data Obat (Racikan)</legend>
				<div id="formanak">
					<div class="control-group " >
						<?php echo CHtml::hiddenField('obatalkes_id'); ?>
						<label class="control-label" for="racikanKe">R ke</label>
						<div class="controls">
							<?php echo CHtml::dropDownList('racikanKe', '', CustomFunction::getDaftarAngka(),array('disabled'=>false,'class'=>'inputFormTabel span1','onkeypress'=>"return $(this).focusNextInputField(event)")) ?>
							<?php echo CHtml::htmlButton('<i class="icon-plus"></i> Racikan Baru',
								array('onclick'=>'racikanBaru(this);return false;',
									  'class'=>'btn-mini btn-default',
									  'id'=>'tombolracikanbaru',
									  'onkeypress'=>"racikanBaru(this);return false;",
										'disabled'=>true,
									  'rel'=>"tooltip",
									  'title'=>"Klik untuk input racikan baru",)); ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Signa</label>
						<div class="controls">
							<?php echo CHtml::dropDownList('signaracikan', '', LookupM::getItems('signa_oa'),array('class'=>'inputFormTabel span1','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
						</div>
					</div>
					<div class="control-group">
						<label class="control-label">Etiket</label>
						<div class="controls">
							<?php echo CHtml::dropDownList('etiketracikan', '', LookupM::getItems('etiket'),array('style'=>'width:150px;')); ?>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label" for="jmlKemasan">Jumlah Permintaan</label>
						<div class="controls">
							<?php echo CHtml::textField('jmlKemasanObat', '', array('disabled'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1  numbers-only','onblur'=>'hitungJumlahObat()')) ?>
							<?php echo CHtml::dropDownList('satuansediaan', '', LookupM::getItems(Params::LOOKUPTYPE_SEDIAANOBATRACIKAN),array('class'=>'inputFormTabel span1','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
						</div>
					</div>
				</div>
				<fieldset class="well">
					<div class="control-group ">
						<label class="control-label" for="namaObatRacik">Nama Obat</label>
						<div class="controls">
							<?php 
								$this->widget('MyJuiAutoComplete', array(
												'name'=>'namaObatRacik',
												'source'=>'js: function(request, response) {
															   $.ajax({
																   url: "'.$this->createUrl('AutocompleteObatReseptur').'",
																   dataType: "json",
																   data: {
																	   term: request.term,
																	   ruangantujuan_id: $("#RIResepturT_ruangan_id").val(),
																   },
																   success: function (data) {
																		   response(data);
																   }
															   })
															}',
												 'options'=>array(
													   'showAnim'=>'fold',
													   'minLength' => 2,
													   'select'=>'js:function( event, ui ) {
															$(this).val( ui.item.label);
															$("#form-racikan #obatalkes_id").val(ui.item.obatalkes_id);
															$("#obatalkes_kode").val(ui.item.obatalkes_kode);
															$("#form-racikan #kekuatanObat").val(ui.item.kekuatan);
															hitungJumlahObat();
															return false;
														}',
												),
												'htmlOptions'=>array("rel"=>"tooltip","title"=>"Pencarian Data Obat/Alkes",'disabled'=>false, 'onkeypress'=>"return $(this).focusNextInputField(event)"),
												'tombolDialog'=>array('idDialog'=>'dialogObatRacikan','idTombol'=>'tombolDialogOaRacikan'),
											)); 
							?>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label" for="permintaan">Permintaan Dosis</label>
						<div class="controls">
							<?php echo CHtml::textField('permintaan', '', array('disabled'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1 float2','onblur'=>'hitungJumlahObat()', 'style'=>'text-align:right')) ?>
							<?php echo CHtml::dropDownList('', '', LookupM::getItems('satuankekuatan'),array('class'=>'inputFormTabel span1','onkeypress'=>"return $(this).focusNextInputField(event)")); ?>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label" for="kekuatanObat">Kekuatan</label>
						<div class="controls">
							<?php echo CHtml::textField('kekuatanObat', '', array('disabled'=>false,'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'inputFormTabel span1  numbers-only','readonly'=>true,"rel"=>"tooltip","title"=>"Kekuatan diambil dari data obat yang dipilih",)) ?>
							<span id="satuanKekuatanObat"></span>
						</div>
					</div>
					<div class="control-group ">
						<label class="control-label" for="qty">Jumlah Obat</label>
						<div class="controls">
							<?php echo CHtml::textField('qtyRacik', '', array('readonly'=>false,'onkeyup'=>'$("#qty").val($(this).val());','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'float',"rel"=>"tooltip","title"=>"Jumlah Obat = Permintaan Dosis X Jumlah Permintaan / Kekuatan",'style'=>'width:50px;')) ?>
						</div>
					</div>
				</fieldset>
				
				<div class="control-group ">
					<label class="control-label" for=""></label>
					<div class="controls">
						<?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
								array('onclick'=>'tambahObatRacik(this);return false;',
									  'class'=>'btn btn-primary',
									  'id'=>'tomboltambahracikan',
									  'onkeypress'=>"tambahObatRacik(this);return false;",
									  'rel'=>"tooltip",
									  'title'=>"Klik untuk menambahkan ke tabel resep",
									  'disabled'=>true,)); ?>
					</div>
				</div>
				
                
                <!--<div style='border:1px solid #cccccc; border-radius:2px;padding:10px; width: 42%;float:right;margin-top:-70px;'>-->
                <!--<font style='font-size:9pt'>Keterangan : </font><br>-->
                <!--<font style='font-size:8pt'>Jumlah = Permintaan*Jumlah Kemasan/Kekuatan</font>-->
		</fieldset>
	</div>
</div>



<?php
//========= Dialog buat cari data Alat Kesehatan (RACIKAN)  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogTerapiObat',
    'options'=>array(
        'title'=>'Therapi Obat',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>480,
        'height'=>320,
        'resizable'=>false,
    ),
));

$modTherapiobat = new RITherapiobatM('search');
$modTherapiobat->unsetAttributes();
if(isset($_GET['RITherapiobatM'])){
//    $modTherapiobat->attributes = $_GET['RITherapiobatM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'therapiobat-grid',
	'dataProvider'=>$modTherapiobat->searchDialog(),
	'filter'=>$modTherapiobat,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectObat",
                                    "onClick" => "
												$(\"#therapiobat_id\").val(\"$data->therapiobat_id\"); 
												$(\"#therapiobat_nama\").val(\"$data->therapiobat_nama\"); 
                                                $(\'#dialogTerapiObat\').dialog(\'close\');
												setOAJoinTerapi();
											return false;"))',
                ),
				'therapiobat_nama',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>


<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogObat',
    'options'=>array(
        'title'=>'Daftar Obat Alkes',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'minHeight'=>400,
        'resizable'=>false,
    ),
));

$modObatDialog = new RIObatalkesM('searchObatFarmasiRuangan');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['RIObatalkesM'])){
	$modObatDialog->attributes = $_GET['RIObatalkesM'];
//	if(isset($_GET['RIObatalkesM']['therapiobat_id'])){
		$modObatDialog->therapiobat_id = isset($_GET['RIObatalkesM']['therapiobat_id']) ? $_GET['RIObatalkesM']['therapiobat_id'] : null;
//	}
//	if(isset($_GET['RIObatalkesM']['ruangan_id'])){
		$modObatDialog->ruangan_id = isset($_GET['RIObatalkesM']['ruangan_id']) ? $_GET['RIObatalkesM']['ruangan_id'] : null;
//	}
}
    
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatAlkesDialog-m-grid',
//    'dataProvider'=>$modObatDialog->searchObatFarmasi(),
    'dataProvider'=>$modObatDialog->searchObatFarmasiRuangan(),
    'filter'=>$modObatDialog,
    'template'=>"{items}\n{pager}",
//    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            $(\"#form-nonracikan #obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#obatalkes_kode\").val(\"$data->obatalkes_kode\");
                            $(\"#form-nonracikan #namaObatNonRacik\").val(\"$data->obatalkes_nama\");
							setThreapiobat_id(\"$data->obatalkes_id\");
							$(\"#form-nonracikan #signa\").val(\"$data->signa\");
							$(\"#dialogObat\").dialog(\"close\");
                            return false;
                ",
               ))',
			'filter'=>CHtml::activeHiddenField($modObatDialog, 'therapiobat_id'),//RND-7948
        ),

        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'header'=>'Tanggal Kadaluarsa',
            'name'=>'tglkadaluarsa',
            'filter'=>'',
        ),        
        array(
            'name'=>'satuankecil.satuankecil_nama',
            'header'=>'Satuan Kecil',
        ),
        array(
            'name'=>'satuanbesar.satuanbesar_nama',
            'header'=>'Satuan Besar',
        ),
		// dicomment karena RND-5732
//        array(
//            'header'=>'HJA Resep',
//            'type'=>'raw',
//            'value'=>'number_format($data->hjaresep, 0, ",", ".")',
//            'filter'=>'',
//            'htmlOptions'=>array('style'=>'text-align:right;'),
//        ),
//        array(
//            'header'=>'HJA Non Resep',
//            'value'=>'number_format($data->hjanonresep, 0, ",", ".")',
//            'filter'=>'',
//            'htmlOptions'=>array('style'=>'text-align:right;'),
//        ),
		array(
				'name'=>'hargajual',
				'value'=>'number_format($data->hargajual)',
			),
        array(
            'header'=>'Stok',
            'type'=>'raw',
            'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id,"'.$modObatDialog->ruangan_id.'")',
        ),

        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogObatRacikan',
    'options'=>array(
        'title'=>'Daftar Obat Alkes Racikan',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'minHeight'=>400,
        'resizable'=>false,
    ),
));

$modObatDialogRacikan = new RIObatalkesM('searchObatFarmasi');
$modObatDialogRacikan->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['RIObatalkesM'])){
	$modObatDialogRacikan->attributes = $_GET['RIObatalkesM'];
	if(isset($_GET['RIObatalkesM']['ruangan_id'])){
		$modObatDialogRacikan->ruangan_id = $_GET['RIObatalkesM']['ruangan_id'];
	}
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatAlkesDialogRacikan-m-grid',
    'dataProvider'=>$modObatDialogRacikan->searchObatFarmasi(),
    'filter'=>$modObatDialogRacikan,
    'template'=>"{items}\n{pager}",
//    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                           
                            $(\"#form-racikan #obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#obatalkes_kode\").val(\"$data->obatalkes_kode\");
                            $(\"#form-racikan #namaObatRacik\").val(\"$data->obatalkes_nama\");
                            $(\"#form-racikan #kekuatanObat\").val(\"$data->kekuatan\");
							hitungJumlahObat();
                            $(\"#dialogObatRacikan\").dialog(\"close\");
                            return false;
                ",
               ))',
        ),

            'obatalkes_kode',
            'obatalkes_nama',
            array(
                'header'=>'Tanggal Kadaluarsa',
                'name'=>'tglkadaluarsa',
                'filter'=>'',
            ),        
            array(
                'name'=>'satuankecil.satuankecil_nama',
                'header'=>'Satuan Kecil',
            ),
            array(
                'name'=>'satuanbesar.satuanbesar_nama',
                'header'=>'Satuan Besar',
            ),
		// dicomment karena RND-5732
//            array(
//                'header'=>'HJA Resep',
//                'type'=>'raw',
//                'value'=>'number_format($data->hjaresep, 0, ",", ".")',
//                'filter'=>'',
//                'htmlOptions'=>array('style'=>'text-align:right;'),
//            ),
//            array(
//                'header'=>'HJA Non Resep',
//                'value'=>'number_format($data->hjanonresep, 0, ",", ".")',
//                'filter'=>'',
//                'htmlOptions'=>array('style'=>'text-align:right;'),
//            ),
			array(
				'name'=>'hargajual',
				'value'=>'number_format($data->hargajual)',
			),
            array(
                'header'=>'Stok',
                'type'=>'raw',
				'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id,"'.$modObatDialogRacikan->ruangan_id.'")',
			),

        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>

<script type="text/javascript">
function cekObat(){
	var deposit = $('#deposit').val();
	var totalHargaReseptur = unformatNumber($('#totalHargaReseptur').val());
	// requiredCheck
	var no_resep = $('#RIResepturT_noresep').val();
	var jumlah_obat = $('#table-obatalkespasien tbody tr').length;
	if (no_resep == ""){
     myAlert('Isi No. Resep !');  
     return false;
	}else if(jumlah_obat<= 0){
     myAlert('Anda Belum memilih Obat Yang Akan Diminta');  
     return false;
	} /* else if (deposit == ""){
		myConfirm("Pasien Belum Melakukan Deposit!","Perhatian!",function(r) {
		   if(r){	
			   // notifikasi
			   var totalHargaReseptur =  $('#totalHargaReseptur').val();
			   var params = [];
			   params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:19, judulnotifikasi:'Deposit Tidak Mencukupi', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik; echo "-"; echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp. <?php echo isset($modDeposit)? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp. ' + totalHargaReseptur + '. Silahkan hubungi kasir'};
			   insert_notifikasi(params);
			   disableOnSubmit('#btn_submit');
			   setTimeout(function(){
			   $('#rjreseptur-t-form').submit();
			   }, 2000);
		   }
	   });
	}else if (deposit < totalHargaReseptur){
			 myConfirm("Uang deposit tidak mencukupi, Silahkan hubungi kasir!","Perhatian!",function(r) {
				if(r){	
					// notifikasi
					var totalHargaReseptur =  $('#totalHargaReseptur').val();
					var params = [];
					params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:19, judulnotifikasi:'Deposit Tidak Mencukupi', isinotifikasi:'<?php echo $modPasien->nama_pasien ?> / <?php echo $modPasien->no_rekam_medik; echo "-"; echo $modPendaftaran->no_pendaftaran; ?> diruangan <?php echo $modPendaftaran->ruangan->ruangan_nama ?> tidak mencukupi. Total  Deposit = Rp. <?php echo isset($modDeposit)? MyFormatter::formatUang($modDeposit) : 0; ?>. Total Tagihan = Rp. ' + totalHargaReseptur + '. Silahkan hubungi kasir'};
					insert_notifikasi(params);
					disableOnSubmit('#btn_submit');
					setTimeout(function(){
					$('#rjreseptur-t-form').submit();
					}, 2000);
				}
			});
	} */ else{
		$('#rjreseptur-t-form').submit();
	}
   return false;
}
function hitungQtyRacikan()
{
    var permintaan = $('#permintaan').val();
    var jmlKemasan = $('#jmlKemasanObat').val();
    var kekuatan = $('#kekuatanObat').val();
    var qty = permintaan * jmlKemasan / kekuatan;
    
    if (jQuery.isNumeric(permintaan)){
        $('#jmlPermintaan').val(permintaan);
    }
    if (jQuery.isNumeric(kekuatan)){
        $('#kekuatan').val(kekuatan);
    }
    if (jQuery.isNumeric(jmlKemasan)){
        $('#jmlKemasan').val(jmlKemasan);
    }
    if (jQuery.isNumeric(qty)){
        $('#qty').val(qty);
    }
    if (jQuery.isNumeric(qty)){
        $('#qtyRacik').val(qty);
    }
}
    
function tambahObatNonRacik(obj)
{
    var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('fieldset').find('#qtyNonRacik').val();
    var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatNonRacik = $('#namaObatNonRacik').val();
    var ruangan_id = $('#<?php echo CHtml::activeId($modReseptur,"ruangan_id") ?>').val();
	var isRacikan = 0;
	var therapiobat_id = $(obj).parents('.row-fluid').find('#therapiobat_id2').val();
    if(rke==undefined){rke=1;}else{rke++;}
    if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah,ruangan_id:ruangan_id,isRacikan:isRacikan,therapiobat_id:therapiobat_id},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+namaObatNonRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
				
				var therapiobatyangsama = $("#table-obatalkespasien input[name$='[therapiobat_id]'][value='"+therapiobat_id+"']");
				if(therapiobatyangsama.val()){ //jika ada therapi obat sudah ada
					myAlert('Obat ini memiliki kelas therapi yang sama dengan pilihan obat sebelumnya');
				}
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm("Apakah anda akan input ulang obat ini?","Perhatian!",
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
				if(tambahkandetail){
					$('#table-obatalkespasien > tbody').append(data.form);
					$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
						{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
					);
					addDataKeGridObat(obj,'nonracik',rke);
					renameInputRowObatAlkes($("#table-obatalkespasien"));                    
					hitungTotal();
					hitungtotalHargaReseptur();
				}
                        }else{
                            tambahkandetail = false;
                        }
                    }); 
                }else{
				
			if(tambahkandetail){
				$('#table-obatalkespasien > tbody').append(data.form);
				$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
				);
				addDataKeGridObat(obj,'nonracik',rke);
				renameInputRowObatAlkes($("#table-obatalkespasien"));                    
				hitungTotal();
				hitungtotalHargaReseptur();
			}
		}
		$(obj).parents('fieldset').find('#obatalkes_id').val('');
		$('#namaObatNonRacik').val('');
		$('#qtyNonRacik').val(1);
		formatNumberSemua();
		renameInputRowObatAlkes($("#table-obatalkespasien")); 
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silahkan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatNonRacik").focus();   
}

function tambahObatRacik(obj)
{
    var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    var obatalkes_kode = $('#obatalkes_kode').val();
    var jumlah = $(obj).parents('fieldset').find('#qtyRacik').val();
	var ruangan_id = $('#<?php echo CHtml::activeId($modReseptur,"ruangan_id") ?>').val();
    var rke = $(obj).parents('fieldset').find('#racikanKe').val();
    var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    var namaObatRacik = $('#namaObatRacik').val();
    var indexrke = 0;
    var jmlrke = 0;
    var marginrke = 0;
    var statusmargin = 0;
	var isRacikan = 1;
    
    if(obatalkes_id != '')
    {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah,ruangan_id:ruangan_id,isRacikan:isRacikan},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    var params = [];
                    params = {instalasi_id:<?php echo Yii::app()->user->getState("instalasi_id"); ?>, modul_id:<?php echo Params::MODUL_ID_GUDANGFARMASI; ?>, judulnotifikasi:'Stok Obat Alkes Habis', isinotifikasi:obatalkes_kode+' '+namaObatRacik+'  di <?php echo Yii::app()->user->getState("ruangan_nama"); ?> telah habis'}; // 16 
                    insert_notifikasi(params);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm("Apakah anda akan input ulang obat ini?","Perhatian!",
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
						if(tambahkandetail){
							if (indexrke==0) {
									$('#table-obatalkespasien > tbody').append(data.form);
							}else{
								$('#table-obatalkespasien > tbody > tr:nth-child('+(indexrke+marginrke)+')').after(data.form);
								$("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("#isi-r").hide();
							}
							$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
								{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
							);
							addDataKeGridObat(obj,'racik',rke);
							renameInputRowObatAlkes($("#table-obatalkespasien"));                    
							hitungTotal();
							hitungtotalHargaReseptur();
						}
                        }else{
                            tambahkandetail = false;
                        }
                    }); 
                }else{
					$('#table-obatalkespasien > tbody > tr').each(function(){
						if($(this).find('input[name*="[rke]"]').val()==rke){
							if (marginrke==0) {
								if(statusmargin==0){
									marginrke=jmlrke;
									statusmargin = 1;
								}
							};
							indexrke++;
						}
						jmlrke++;
					});

					if(tambahkandetail){
						if (indexrke==0) {
								$('#table-obatalkespasien > tbody').append(data.form);
						}else{
							$('#table-obatalkespasien > tbody > tr:nth-child('+(indexrke+marginrke)+')').after(data.form);
							$("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").parents('tr').find("#isi-r").hide();
						}
						$("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
							{"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
						);
						addDataKeGridObat(obj,'racik',rke);
						renameInputRowObatAlkes($("#table-obatalkespasien"));                    
						hitungTotal();
						hitungtotalHargaReseptur();
					}
				}
                
                $(obj).parents('fieldset').find('#obatalkes_id').val('');
                $('#namaObatRacik').val('');
                $('#qtyNonRacik').val(1);
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }else{
        myAlert("Silahkan pilih obat / alkes terlebih dahulu!");
    }
    $("#namaObatRacik").focus();   
    setTombolRacikanBaru();
}

function hitungSubTotal(obj)
{
    var qty = unformatNumber($(obj).parents('tr').find('input[name="qty[]"]').val());
    var harga = unformatNumber($(obj).parents('tr').find('input[name="hargajual[]"]').val());
    subTotal = qty * harga;
    
    $(obj).parents('tr').find('input[name="subTotal[]"]').val(formatInteger(subTotal));
    hitungTotalHargaReseptur();
}

//function hitungTotalHargaReseptur()
//{
//    totalHarga = 0;
//    $('#tblDaftarResep').find('input[name="subTotal[]"]').each(function(){
//        totalHarga = totalHarga + unformatNumber(this.value);
//    });
//    $('#totalHargaReseptur').val(formatInteger(totalHarga));
//}

function removeObat(obj)
{
    myConfirm("Apakah anda akan menghapus obat?","Perhatian!",function(r) {
        if(r){
            $(obj).parent().parent().remove();
            hitungTotalHargaReseptur();
        }
    });
    
}

function adaRmax(Rke)
{
    var ada = false;
    $('#tblDaftarResep').find('input[name="Rke[]"]').each(function(){
       if(Rke == this.value)
           ada = true;
    });
    
    return ada;
}

function enableRacikan()
{
    $('#formRacikan input[type="text"]').removeAttr('disabled');
    $('#formRacikan input[type="text"]').removeAttr('readonly');
    $('#formRacikan select').removeAttr('disabled');
    $('#formRacikan button').removeAttr('disabled');
    $('#formNonRacikan input[type="text"]').attr('disabled','disabled');
    $('#formNonRacikan select').attr('disabled','disabled');
    $('#formNonRacikan button').attr('disabled','disabled');
    $('#formNonRacikan input[type="radio"]').removeAttr('checked');
    $('#racikanKe').focus();
}

function enableNonRacikan()
{
    $('#formNonRacikan input[type="text"]').removeAttr('disabled');
    $('#formNonRacikan select').removeAttr('disabled');
    $('#formNonRacikan button').removeAttr('disabled');
    $('#formRacikan input[type="text"]').attr('disabled','disabled');
    $('#formRacikan select').attr('disabled','disabled');
    $('#formRacikan button').attr('disabled','disabled');
    $('#formRacikan input[type="radio"]').removeAttr('checked');
}

function clearRacikan()
{
    $('#formRacikan input[type="text"]').val('');
    $('#satuanKekuatanObat').html('');
    $('#racikanKe').focus();
}

function clearNonRacikan()
{
    $('#formNonRacikan input[type="text"]').val('');
    $('#satuanKekuatanObat').html('');
    $('#racikanKe').focus();
}

function clearInputan()
{
    $('#idObat').val('');
    $('#hargaSatuan').val('');
    $('#hargaNetto').val('');
    $('#hargaJual').val('');
    $('#kekuatan').val('');
    $('#satuanKekuatan').val('');
    $('#jmlPermintaan').val('');
    $('#jmlKemasan').val('');
    $('#qty').val('');
    $('#signa').val('');
    $('#namaObat').val('');
    $('#idSumberDana').val('');
    $('#namaSumberDana').val('');
    $('#idSatuanKecil').val('');
    clearRacikan(); clearNonRacikan();
	$('#therapiobat_id2').val('');
}

function terapiobat_reset(){
	$("#formNonRacikan").addClass("animation-loading");
	var ruangantujuan_id = $('#RIResepturT_ruangan_id').val();
		$('#therapiobat_id').val('');
		$('#therapiobat_nama').val('');
		$('#RIObatAlkesM_therapiobat_id').val('');
//		if(therapiobat_id != ''){
			$.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
				data: {
					"RIObatalkesM[ruangan_id]":ruangantujuan_id,
				}
			});
//		}
		
		clearInputan();
	setTimeout(function(){
		$("#formNonRacikan").removeClass("animation-loading");
	},500);
}

// function untuk men set dialog oa agar berelasi dengan therapiobatmap_m
function setOAJoinTerapi(){
	var therapiobat_id = $('#therapiobat_id').val();
	var ruangantujuan_id = $('#RIResepturT_ruangan_id').val();
	$("#namaObatNonRacik").addClass("animation-loading-1");
		<?php $modObatDialog->therapiobat_id = true; ?>
		$.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
			data: {
				"RIObatalkesM[ruangan_id]":ruangantujuan_id,
				"RIObatalkesM[therapiobat_id]":therapiobat_id,
			}
		});
	setTimeout(function(){
		$("#namaObatNonRacik").removeClass("animation-loading-1");
	},500);
}

function setOaByRuangTujuan(){
	$("#formNonRacikan").addClass("animation-loading");
	clearInputan();
	setTimeout(function(){
		$("#formNonRacikan").removeClass("animation-loading");
	},500);
}

$('#tombolDialogOa').click(function(){
	var therapiobat_id = $('#therapiobat_id').val();
	var ruangantujuan_id = $('#RIResepturT_ruangan_id').val();
	$.fn.yiiGridView.update('obatAlkesDialog-m-grid', {
		data: {
			"RIObatalkesM[ruangan_id]":ruangantujuan_id,
			"RIObatalkesM[therapiobat_id]":therapiobat_id,
		}
	});
});

function setThreapiobat_id(obatalkes_id){
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('setTherapiobatid'); ?>',
		data: {obatalkes_id : obatalkes_id},//
		dataType: "json",
		success:function(data){
			if(data){
				$("#therapiobat_id2").val(data);
			}
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function formjenisresep(jenisresep){
	$("#formjenisresep").addClass("animation-loading");
	setTimeout(function(){
		if(jenisresep==1){
			$("#form-nonracikan").hide();
			$("#form-racikan").show();
		}else{
			$("#form-nonracikan").show();
			$("#form-racikan").hide();
		}
		$("#formjenisresep").removeClass("animation-loading");
	},500);
}

function hitungJumlahObat(){
        unformatNumberSemua();
	$("#qtyRacik").addClass("animation-loading-1");
	var jmlkemasanobat = $('#jmlKemasanObat').val();
	var permintaan = $('#permintaan').val();
	var kekuatanobat = $('#kekuatanObat').val();
	setTimeout(function(){
		if((jmlkemasanobat != '')&&(permintaan != '')&&(kekuatanobat != '')){
			var jmlobat = permintaan*jmlkemasanobat/kekuatanobat;
			$("#tomboltambahracikan").attr("disabled",false);
		}else{
			var jmlobat = 0;
			$("#tomboltambahracikan").attr("disabled",true);
		}
		$("#qtyRacik").val(jmlobat);
		$("#qtyRacik").removeClass("animation-loading-1");
	},500);
       
}

function setTombolRacikanBaru(){
	$("#formanak").addClass("animation-loading-1");
	setTimeout(function(){
		$("#tombolracikanbaru").attr('disabled',false);
		$("#racikanKe").attr('disabled',true);
		$("#signaracikan").attr('disabled',true);
		$("#etiketracikan").attr('disabled',true);
		$("#jmlKemasanObat").attr('disabled',true);
		$("#satuansediaan").attr('disabled',true);
		$("#permintaan").val('');
		$("#kekuatanObat").val('');
		hitungJumlahObat();
		$("#formanak").removeClass("animation-loading-1");
	},500);
}

function racikanBaru(){
	$("#formanak").addClass("animation-loading-1");
	setTimeout(function(){
		$("#tombolracikanbaru").attr('disabled',true);
		$("#racikanKe").attr('disabled',false);
		$("#signaracikan").attr('disabled',false);
		$("#etiketracikan").attr('disabled',false);
		$("#jmlKemasanObat").attr('disabled',false);
		$("#satuansediaan").attr('disabled',false);
		$("#jmlKemasanObat").val('');
		$("#permintaan").val('');
		$("#kekuatanObat").val('');
		hitungJumlahObat();
		setDropDownRke();
		$("#formanak").removeClass("animation-loading-1");
	},500);
}

function setDropDownRke(){
	var rmax = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('SetDropdownRke'); ?>',
		data: {rmax : rmax++},//
		dataType: "json",
		success:function(data){
			$('#racikanKe').html(data);
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function addDataKeGridObat(obj,tipe,rke){
    if(tipe=='racik'){
        var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
        var signa = $(obj).parents('fieldset').find('#signaracikan').val();
		var iterRacik = $('#iter').val();
        var permintaan = $(obj).parents('fieldset').find('#permintaan').val();
        var kemasan = $(obj).parents('fieldset').find('#jmlKemasanObat').val();
        var kekuatan = $(obj).parents('fieldset').find('#kekuatanObat').val();
        var etiket = $(obj).parents('fieldset').find('#etiketracikan').val();
        var satuansediaan = $(obj).parents('fieldset').find('#satuansediaan').val();
        var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_reseptur]"]');
        input_signa.val(signa);
        var input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaan_oa]"]');
        input_permintaan.val(permintaan);
        var input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][jmlkemasan_oa]"]');
        input_kemasan.val(kemasan);
        var input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][kekuatan_oa]"]');
        input_kekuatan.val(kekuatan);
		var input_iter = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][iter]"]');
        input_iter.val(iterRacik);
		var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        input_etiket.val(etiket);
		var input_satuansediaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][satuansediaan]"]');
        input_satuansediaan.val(satuansediaan);

        var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);
    }else{
        var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
        var signa = $(obj).parents('fieldset').find('#signa').val();
		var iterNonRacik = $('#iter').val();
		var etiket = $(obj).parents('fieldset').find('#etiketnonracikan').val();
		
        var input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_reseptur]"]');
        input_signa.val(signa);
		var input_iter = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][iter]"]');
        input_iter.val(iterNonRacik);
        var input_etiket = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][etiket]"]');
        input_etiket.val(etiket);
		
        var input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);

    }
}

function renameInputRowObatAlkes(obj_table){
    var row = 0;
    $(obj_table).find("tbody > tr").each(function(){
        $(this).find("#no_urut").val(row+1);
        $(this).find('span').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
            }
        });
        $(this).find('input,select,textarea').each(function(){ //element <input>
            var old_name = $(this).attr("name").replace(/]/g,"");
            var old_name_arr = old_name.split("[");
            if(old_name_arr.length == 3){
                $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
            }
        });
        row++;
    });
    
}

function hitungTotal(){
    unformatNumberSemua();
    obj_totalharganetto =  $('#<?php echo CHtml::activeId($modReseptur,"totharganetto") ?>');
    obj_totalhargajual =  $('#<?php echo CHtml::activeId($modReseptur,"totalhargajual") ?>');
    totalharganetto = 0;
    totalhargajual = 0;
    $('#table-obatalkespasien > tbody > tr').each(function(){
        totalharganetto += parseFloat( $(this).find('input[name*="[harganetto_oa]"]').val() * $(this).find('input[name*="[qty_oa]"]').val() );
        totalhargajual += parseFloat($(this).find('input[name*="[hargajual_oa]"]').val());
    });
    
    
    obj_totalharganetto.val(totalharganetto);
    obj_totalhargajual.val(totalhargajual);
    
    formatNumberSemua();
}

function hitungtotalHargaReseptur(){
unformatNumberSemua();
	$("#totalHargaReseptur").addClass("animation-loading-1");
	var total = 0;
	$("#table-obatalkespasien > tbody > tr").each(function(){
		total =+ parseInt($(this).find('input[name$="[hargajual_reseptur]"]').val());
	});
	setTimeout(function(){
		$('#totalHargaReseptur').val(total);
		$("#totalHargaReseptur").removeClass("animation-loading-1");
		formatNumberSemua();
	},300);

}

function batalObatAlkesPasienDetail(obj){
    myConfirm("Apakah anda akan membatalkan penjualan obat alkes ini?","Perhatian!",
    function(r){
        if(r){
            var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[obatalkes_id]"][value="'+obatalkes_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });
            hitungTotal();
			hitungtotalHargaReseptur();
        }
    }); 
}

$(document).ready(function(){
	formjenisresep(0); // load awal form non racikan yang dimunculkan
});

</script>

