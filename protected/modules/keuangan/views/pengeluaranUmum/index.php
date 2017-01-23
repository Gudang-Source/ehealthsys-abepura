<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<div class="white-container">
    <fieldset id ="input-pengeluaran">    
		<?php
		$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
			'id' => 'akpengeluaran-umum-t-form',
			'enableAjaxValidation' => false,
			'type' => 'horizontal',
			'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)',
			), //'onsubmit'=>'return requiredCheck(this);'
			'focus' => '#',
		));
		?>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <legend class="rim2">Transaksi <b>Pengeluaran Kas / Umum</b></legend>
        <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary(array($modPengUmum, $modBuktiKeluar)); ?>
        <table width="100%">
            <tr>
                <td width="33%" align="right">
                    <div class="control-group ">
							<?php $modPengUmum->tglpengeluaran = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modPengUmum->tglpengeluaran, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
							<?php echo $form->labelEx($modPengUmum, 'tglpengeluaran', array('class' => 'control-label')) ?>
                        <div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $modPengUmum,
								'attribute' => 'tglpengeluaran',
								'mode' => 'datetime',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
									'maxDate' => 'd',
								),
								'htmlOptions' => array('class' => 'dtPicker2-5 ', 'onkeypress' => "return $(this).focusNextInputField(event)"
								),
							));
							?>

                        </div>
                    </div>
					<?php echo $form->textFieldRow($modPengUmum, 'nopengeluaran', array('class' => 'span3 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20)); ?>
<?php echo $form->dropDownListRow($modPengUmum, 'kelompoktransaksi', LookupM::getItems('kelompoktransaksi'), array('class' => 'span3 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
<?php echo $form->hiddenField($modPengUmum, 'jenispengeluaran_id', array('readonly' => true, 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </td>
                <td width="33%" align="right">
                    <div class="control-group ">
							<?php echo $form->labelEx($modPengUmum, 'jenispengeluaran_id', array('class' => 'control-label')) ?>
                        <div class="controls">
							<?php
							$this->widget('MyJuiAutoComplete', array(
								'model' => $modPengUmum,
								'attribute' => 'jenisKodeNama',
								'source' => 'js: function(request, response) {
                                                       $.ajax({
                                                           url: "' . Yii::app()->createUrl('billingKasir/ActionAutoComplete/jenisPengeluaran') . '",
                                                           dataType: "json",
                                                           data: {
                                                               term: request.term,
                                                           },
                                                           success: function (data) {
                                                                   response(data);
                                                           }
                                                       })
                                                    }',
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'focus' => 'js:function( event, ui ) {
                                                   $(this).val(ui.item.value);
                                                    return false;
                                                }',
									'select' => 'js:function( event, ui ) {
                                                    $("#KUPengeluaranumumT_jenispengeluaran_id").val(ui.item.jenispengeluaran_id);
                                                    getDataRekening(ui.item.jenispenerimaan_id);
                                                    return false;
                                                }',
								),
								'htmlOptions' => array('placeholder' => 'ketik Nama Jenis Pengeluaran', 'class' => ''),
								'tombolDialog' => array('idDialog' => 'dialogJenisPengeluaran',),
							));
							?>
                        </div>
                    </div>
						<?php //echo $form->textFieldRow($modPengUmum,'volume',array('onblur'=>'hitungTotalHarga()','class'=>'span1', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
						<?php //echo $form->dropDownListRow($modPengUmum,'satuanvol', LookupM::getItems('satuanumum'),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                    <div class="control-group ">
							<?php echo $form->labelEx($modPengUmum, 'volume', array('class' => 'control-label')) ?>
                        <div class="controls">
<?php echo $form->textField($modPengUmum, 'volume', array('onblur' => 'hitungTotalHarga()', 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
					<?php echo $form->dropDownList($modPengUmum, 'satuanvol', LookupM::getItems('satuanumum'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        </div>
                    </div>
					<?php echo $form->textFieldRow($modPengUmum, 'hargasatuan', array('onblur' => 'hitungTotalHarga()', 'class' => 'inputFormTabel integer2 ', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </td>
                <td>
					<?php echo $form->textFieldRow($modPengUmum, 'totalharga', array('readonly' => true, 'class' => 'inputFormTabel integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
					<?php echo $form->textAreaRow($modPengUmum, 'keterangankeluar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
					<?php //echo $form->textFieldRow($modPengUmum,'namapenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
					<?php //echo $form->textFieldRow($modPengUmum,'nippenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
<?php //echo $form->textFieldRow($modPengUmum,'jabatanpenandatangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100));  ?>
<?php //echo $form->dropDownListRow($modPengUmum,'penjamin_id', CHtml::listData($modPengUmum->getPenjaminItems(1), 'penjamin_id', 'penjamin_nama'), array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
                </td>
            </tr>
        </table>
        <fieldset class="box">
            <legend class="rim">
<?php echo $form->checkBox($modPengUmum, 'isurainkeluarumum', array('checked' => true, 'onchange' => 'bukaUraian(this)', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                Pilih Jika Transaksi Ada Uraiannya
            </legend>
            <div id="div_tblInputUraian">
                <table id="tblInputUraian" class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>
                                Uraian
                            </th>
                            <th>Volume</th>
                            <th>Satuan</th>
                            <th>Harga</th>
                            <th>Total</th>
                            <th>&nbsp;</th>
                        </tr>
                    </thead>
                    <tbody>
						<?php
						$removeButton = '';
						foreach ($modUraian as $i => $uraian) {
							?>
							<tr class="<?php echo ($removeButton == true ? "child" : "") ?>">
								<td>
									<?php echo $form->textField($uraian, "[$i]uraiantransaksi", array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
								</td>
								<td>
									<?php echo $form->textField($uraian, "[$i]volume", array('onkeyup' => 'hitungTotalUraian(this)', 'class' => 'inputFormTabel lebar2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
								</td>
								<td>
									<?php echo $form->dropDownList($uraian, "[$i]satuanvol", LookupM::getItems('satuanumum'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
								</td>
								<td>
									<?php echo $form->textField($uraian, "[$i]hargasatuan", array('onkeyup' => 'hitungTotalUraian(this)', 'class' => 'inputFormTabel lebar3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
								</td>
								<td>
									<?php echo $form->textField($uraian, "[$i]totalharga", array('readonly' => true, 'class' => 'inputFormTabel lebar3 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
								</td>
								<td>
									<?php
									if ($removeButton || $i > 0) {
										echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick' => 'addRowUraian(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah uraian'));
										echo "&nbsp;&nbsp;";
										echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick' => 'batalUraian(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk membatalkan uraian'));
									} else {
										echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick' => 'addRowUraian(this);return false;', 'rel' => 'tooltip', 'title' => 'Klik untuk menambah uraian'));
									}
									?>
								</td>
							</tr>
<?php } ?>
                    </tbody>
                </table>
            </div>
        </fieldset>
        <fieldset class="box">
            <legend class="rim">Data Tambahan</legend>
            <table width="100%">
                <tr>
                    <td width="40%">
                        <div>
                            <div class='control-group'>
									<?php echo CHtml::label('Rekening Debit', 'rekening debit', array('class' => 'control-label')) ?>
								<div class="controls">
									<?php
									$this->widget('MyJuiAutoComplete', array(
										'name' => 'rekDebit',
										'id' => 'rekDebit',
										'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek' => 'Kredit')),
										'options' => array(
											'showAnim' => 'fold',
											'minLength' => 2,
											'focus' => 'js:function( event, ui ){
                                    return false;
                                }',
											'select' => 'js:function( event, ui ){
                                    $(this).val(ui.item.value);
                                    var data = {
                                        rekening5_id:ui.item.rekening5_id,
                                        rekening4_id:ui.item.rekening4_id,
                                        rekening3_id:ui.item.rekening3_id,
                                        rekening2_id:ui.item.rekening2_id,
                                        rekening1_id:ui.item.rekening1_id,
                                        status:"debit"
                                    };
                                    getDataRekeningFromGrid(data);                            
                                    return false;
                                }'
										),
										'htmlOptions' => array(
											'onkeypress' => "return $(this).focusNextInputField(event)",
											'placeholder' => 'Ketikan Nama Rekening',
											'class' => 'span3',
											'style' => 'width:150px;',
										),
										'tombolDialog' => array(
											'idDialog' => 'dialogRekDebit'
										),
											)
									);
									?>
								</div>
							</div>
							<div class='control-group'>
									<?php echo CHtml::label('Rekening Kredit', 'rekening kredit', array('class' => 'control-label')) ?>
								<div class="controls">
									<?php
									$this->widget('MyJuiAutoComplete', array(
										'name' => 'rekKredit',
										'id' => 'rekKredit',
										'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi', array('id_jenis_rek' => 'Kredit')),
										'options' => array(
											'showAnim' => 'fold',
											'minLength' => 2,
											'focus' => 'js:function( event, ui ){
                                    return false;
                                }',
											'select' => 'js:function( event, ui ){
                                    $(this).val(ui.item.value);
                                    var data = {
                                        rekening5_id:ui.item.rekening5_id,
                                        rekening4_id:ui.item.rekening4_id,
                                        rekening3_id:ui.item.rekening3_id,
                                        rekening2_id:ui.item.rekening2_id,
                                        rekening1_id:ui.item.rekening1_id,
                                        status:"kredit"
                                    };
                                    getDataRekeningFromGrid(data);                            
                                    return false;
                                }'
										),
										'htmlOptions' => array(
											'onkeypress' => "return $(this).focusNextInputField(event)",
											'placeholder' => 'Ketikan Nama Rekening',
											'class' => 'span3',
											'style' => 'width:150px;',
										),
										'tombolDialog' => array(
											'idDialog' => 'dialogRekKredit'
										),
											)
									);
									?>
								</div>
							</div>
							<table id="tblInputRekening" class="table table-bordered table-condensed" widht="450">
								<thead>
									<tr>
										<th width="100">Kode Rekening</th>
										<th>Nama Rekening</th>
										<th width="100">Debit</th>
										<th width="100">Kredit</th>
										<th width="50">Batal</th>
									</tr>
								</thead>
								<tbody>
								</tbody>
							</table>
						</div>                
                    </td>
                    <td width="30%">
                        <div class="control-group ">
							<?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
								<?php echo $form->labelEx($modBuktiKeluar, 'tglkaskeluar', array('class' => 'control-label inline')) ?>
                            <div class="controls">
								<?php
								$this->widget('MyDateTimePicker', array(
									'model' => $modBuktiKeluar,
									'attribute' => 'tglkaskeluar',
									'mode' => 'datetime',
									'options' => array(
										'dateFormat' => Params::DATE_FORMAT,
										'maxDate' => 'd',
									),
									'htmlOptions' => array('class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
									),
								));
								?>

                            </div>
                        </div>
						<?php // echo $form->dropDownListRow($modBuktiKeluar,'tahun', CustomFunction::getTahun(null,null),array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>4)); ?>
						<?php $modBuktiKeluar->tglkaskeluar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBuktiKeluar->tglkaskeluar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
						<?php echo $form->textFieldRow($modBuktiKeluar, 'nokaskeluar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
						<?php echo $form->textFieldRow($modBuktiKeluar, 'biayaadministrasi', array('onkeyup' => 'hitungJmlBayar();', 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
							<?php echo $form->textFieldRow($modBuktiKeluar, 'jmlkaskeluar', array('readonly' => true, 'class' => 'inputFormTabel integer2 span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
							<?php echo $form->dropDownListRow($modBuktiKeluar, 'carabayarkeluar', LookupM::getItems('carabayarkeluar'), array('onchange' => 'formCarabayar(this.value)', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                        <div id="divCaraBayarTransfer" class="hide">
							<?php echo $form->textFieldRow($modBuktiKeluar, 'melalubank', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
<?php echo $form->textFieldRow($modBuktiKeluar, 'denganrekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
<?php echo $form->textFieldRow($modBuktiKeluar, 'atasnamarekening', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                        </div>

                    </td>
                    <td width="30%">
						<?php echo $form->textFieldRow($modBuktiKeluar, 'namapenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
<?php echo $form->textAreaRow($modBuktiKeluar, 'alamatpenerima', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
<?php echo $form->textFieldRow($modBuktiKeluar, 'untukpembayaran', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100)); ?>
                    </td>
                </tr>
            </table>
        </fieldset>      
        <div class="form-actions">
            <!--div style="float:left;margin-right:6px;"-->
				<?php
				$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
				$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
				$urlSave = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/index');

				$this->widget('bootstrap.widgets.BootButtonGroup', array(
					'type' => 'primary',
					'buttons' => array(
						array(
							'label' => 'Simpan',
							'icon' => 'icon-ok icon-white',
							'url' => "#",
							'htmlOptions' =>
							array(
								'onclick' => 'simpanPengeluaran(\'jurnal\');return false;',
							)
						),
						array(
							'label' => '',
							'items' => array(
								array(
									'label' => 'Posting',
									'icon' => 'icon-ok',
									'url' => "#",
									'itemOptions' => array(
										'onclick' => 'simpanPengeluaran(\'posting\');return false;'
									)
								),
							)
						),
						
					),
					'htmlOptions'=>array(
						'style'=>'float:left; margin-top: 2px; margin-right: 5px;'
					),
				));
				echo CHtml::hiddenField('url');
				echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), array('style' => 'display:none', 'id' => 'reseter', 'class' => 'btn btn-danger', 'type' => 'reset'));
				?>
            <!--/div-->
			<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'id'=>'btn_print', 'onclick'=>'print(\'PRINT\')', 'disabled'=>true));  ?>
			<?php // echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="icon-print icon-white"></i>')), '#', array('class'=>'btn btn-primary','id'=>'btn_print','onclick'=>"print(\"PRINT\")",'disabled'=>true)); ?>
			<?php
			echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), Yii::app()->createUrl($this->module->id . '/pengeluaranUmum/index'), array('class' => 'btn btn-danger',
				'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
			?>
			<?php
			$content = $this->renderPartial('keuangan.views/tips/transaksi', array(), true);
			//    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
			?>
        </div>

    </fieldset>
</div>
<?php $this->renderPartial($this->path_view. '_jsFunctions', array('modPengUmum' => $modPengUmum, 'form' => $form, 'modUraian' => $modUraian)); ?>
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogJenisPengeluaran',
	'options' => array(
		'title' => 'Daftar Jenis Pengeluaran',
		'autoOpen' => false,
		'modal' => true,
		'width' => 700,
		'height' => 700,
		'resizable' => false,
	),
));

$modJenisPengeluaran = new JenispengeluaranM('search');
$modJenisPengeluaran->unsetAttributes();
if (isset($_GET['JenispengeluaranM'])) {
	$modJenisPengeluaran->attributes = $_GET['JenispengeluaranM'];
}
$this->widget('ext.bootstrap.widgets.HeaderGroupGridView', array(
	'id' => 'jenispengeluaran-m-grid',
	//'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider' => $modJenisPengeluaran->searchJnsPengeluaranInRek(),
	'filter' => $modJenisPengeluaran,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'No',
			'value' => '$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
		),
		array(
			'header' => 'Jenis Pengeluaran',
			'name' => 'jenispengeluaran_nama',
			'value' => '$data->jenispengeluaran_nama',
		),
		array(
			'header' => 'Nama Lain',
			'name' => 'jenispengeluaran_namalain',
			'value' => '$data->jenispengeluaran_namalain',
		),
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"
                                        getDataRekening($data->jenispengeluaran_id);
                                        $(\"#KUPengeluaranumumT_jenispengeluaran_id\").val(\"$data->jenispengeluaran_id\");
                                        $(\"#KUPengeluaranumumT_jenisKodeNama\").val(\"$data->jenispengeluaran_nama\");
                                        $(\"#dialogJenisPengeluaran\").dialog(\"close\");    
                                        return false;
                            "))',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>
<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogRekKredit',
	'options' => array(
		'title' => 'Daftar Rekening Kredit',
		'autoOpen' => false,
		'modal' => true,
		'width' => 1000,
		'height' => 700,
		'resizable' => false,
	),
));

$modRekKredit = new KURekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
//        $account = "K"; RND-8514
$account = "";
if (isset($_GET['KURekeningakuntansiV'])) {
	$modRekKredit->attributes = $_GET['KURekeningakuntansiV'];
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();


$c2->compare('rekening1_id', $modRekKredit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekKredit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekKredit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);


//        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'rekkredit-m-grid',
	//'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider' => $modRekKredit->searchAccounts($account),
	'filter' => $modRekKredit,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
//                'mergeHeaders'=>array(
//                    array(
//                        'name'=>'<center>Kode Rekening</center>',
//                        'start'=>1, //indeks kolom 3
//                        'end'=>5, //indeks kolom 4
//                    ),
//                ),
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
						"id" => "selectRekDebit",
						"onClick" =>"
//								RND-8713
//								var data = {
//									rekening5_id:$data->rekening5_id,
//									rekening4_id:$data->rekening4_id,
//									rekening3_id:$data->rekening3_id,
//									rekening2_id:$data->rekening2_id,
//									rekening1_id:$data->rekening1_id,
//									status:\"kredit\"
//								};
//									getDataRekeningFromGrid(data);
								getDataRekeningFromGrid(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekening5_id\', \"kredit\");
							$(\"#dialogRekKredit\").dialog(\"close\");    
							return false;
				"))',
		),
		array(
                        'header' => 'Kode Akun',
                        'name' => 'kdrekening5',
                        'value' => '$data->kdrekening5',
                ),
                array(
                        'header'=>'Kelompok Akun',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
                            $rek2 = KelrekeningM::model()->findByPk($rek1->kelrekening_id);
                            return $rek2->namakelrekening;
                        },
                        'filter'=>CHtml::activeDropDownList($modRekKredit, 'kelrekening_id', CHtml::listData(
                       KelrekeningM::model()->findAll(array(
                           'condition'=>'kelrekening_aktif = true',
                           'order'=>'koderekeningkel',
                       )), 'kelrekening_id', 'namakelrekening'
                        ), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Komponen',
                        'name'=>'rekening1_id',
                        'value'=>'$data->nmrekening1',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening1_id', 
                        CHtml::listData(Rekening1M::model()->findAll(array(
                            'condition'=>'rekening1_aktif = true',
                            'order'=>'kdrekening1 asc',
                        )), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Unsur',
                        'name'=>'rekening2_id',
                        'value'=>'$data->nmrekening2',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening2_id', 
                        CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Kelompok Pos',
                        'name'=>'rekening3_id',
                        'value'=>'$data->nmrekening3',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening3_id', 
                        CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Pos',
                        'name'=>'rekening4_id',
                        'value'=>'$data->nmrekening4',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening4_id', 
                        CHtml::listData($r4, 'rekening4_id', 'nmrekening4'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Akun',
                        'name' => 'nmrekening5',
                        'value' => '$data->nmrekening5',
                ), /*
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrekeninglain5',
			'value'=>'$data->nmrekeninglain5',
		), */
		array(
			'header'=>'Saldo Normal',
			'name'=>'rekening5_nb',
			'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>
<?php
//========= Dialog buat cari data Rek Kredit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogRekDebit',
	'options' => array(
		'title' => 'Daftar Rekening Debit',
		'autoOpen' => false,
		'modal' => true,
		'width' => 1000,
		'height' => 700,
		'resizable' => false,
	),
));

$modRekKredit = new KURekeningakuntansiV('search');
$modRekKredit->unsetAttributes();
//        $account = "D"; RND-8514
$account = "";
if (isset($_GET['KURekeningakuntansiV'])) {
	$modRekKredit->attributes = $_GET['KURekeningakuntansiV'];
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();


$c2->compare('rekening1_id', $modRekKredit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekKredit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekKredit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);

//        $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'rekdedit-m-grid',
	//'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider' => $modRekKredit->searchAccounts($account),
	'filter' => $modRekKredit,
	'template' => "{summary}\n{items}\n{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
//                'mergeHeaders'=>array(
//                    array(
//                        'name'=>'<center>Kode Rekening</center>',
//                        'start'=>1, //indeks kolom 3
//                        'end'=>5, //indeks kolom 4
//                    ),
//                ),
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
					"id" => "selectRekDebit",
					"onClick" =>"
//							RND-8713
//							var data = {
//								rekening5_id:$data->rekening5_id,
//								rekening4_id:$data->rekening4_id,
//								rekening3_id:$data->rekening3_id,
//								rekening2_id:$data->rekening2_id,
//								rekening1_id:$data->rekening1_id,
//								status:\"debit\"
//							};
//							getDataRekeningFromGrid(data);
						getDataRekeningFromGrid(\'$data->rekening1_id\',\'$data->rekening2_id\',\'$data->rekening3_id\',\'$data->rekening4_id\',\'$data->rekening5_id\', \"debit\");
					$(\"#dialogRekDebit\").dialog(\"close\");    
					return false;
				"))',
		),
		array(
                        'header' => 'Kode Akun',
                        'name' => 'kdrekening5',
                        'value' => '$data->kdrekening5',
                ),
                array(
                        'header'=>'Kelompok Akun',
                        'type'=>'raw',
                        'value'=>function($data) {
                            $rek1 = Rekening1M::model()->findByPk($data->rekening1_id);
                            $rek2 = KelrekeningM::model()->findByPk($rek1->kelrekening_id);
                            return $rek2->namakelrekening;
                        },
                        'filter'=>CHtml::activeDropDownList($modRekKredit, 'kelrekening_id', CHtml::listData(
                       KelrekeningM::model()->findAll(array(
                           'condition'=>'kelrekening_aktif = true',
                           'order'=>'koderekeningkel',
                       )), 'kelrekening_id', 'namakelrekening'
                        ), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Komponen',
                        'name'=>'rekening1_id',
                        'value'=>'$data->nmrekening1',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening1_id', 
                        CHtml::listData(Rekening1M::model()->findAll(array(
                            'condition'=>'rekening1_aktif = true',
                            'order'=>'kdrekening1 asc',
                        )), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Unsur',
                        'name'=>'rekening2_id',
                        'value'=>'$data->nmrekening2',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening2_id', 
                        CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Kelompok Pos',
                        'name'=>'rekening3_id',
                        'value'=>'$data->nmrekening3',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening3_id', 
                        CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Pos',
                        'name'=>'rekening4_id',
                        'value'=>'$data->nmrekening4',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening4_id', 
                        CHtml::listData($r4, 'rekening4_id', 'nmrekening4'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header' => 'Akun',
                        'name' => 'nmrekening5',
                        'value' => '$data->nmrekening5',
                ), /*
		array(
			'header'=>'Nama Lain',
			'name'=>'nmrekeninglain5',
			'value'=>'$data->nmrekeninglain5',
		), */
		array(
			'header'=>'Saldo Normal',
			'name'=>'rekening5_nb',
			'value'=>'($data->rekening5_nb == "D") ? "Debit" : "Kredit"',
                        'filter'=>  CHtml::activeDropDownList($modRekKredit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Rek Kredit dialog =============================
?>