<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


<div class="white-container">
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
	<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting.js'); ?>
	<?php
	$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
		'id' => 'gffakturpembelian-m-form',
		'enableAjaxValidation' => false,
		'type' => 'horizontal',
		'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return cekInputan();'),
		'focus' => '#',
	));
	$this->widget('bootstrap.widgets.BootAlert');
	?>
	<?php
	$disabled = (!empty($model->terimapersediaan_id)) ? true : '';
	$dialog = (!empty($model->terimapersediaan_id)) ? array() : array('idDialog' => 'dialogPenerimaanBarang');
	?>
	<?php
	if (!empty($_GET['id'])) {
		?>
		<div class="alert alert-block alert-success">
			<a class="close" data-dismiss="alert">×</a>
			Data berhasil disimpan
		</div>
	<?php } ?>
    <legend class="rim2">Transaksi Faktur <b>Pembelian Umum</b></legend>
<?php //if ($modFakturPembelian->isNewRecord) {  ?>
    <fieldset class="box">
		<legend class="rim">Berdasarkan Penerimaan Items</legend>
        <table width="100%">
            <tr>
                <td>

					<?php //echo $form->textFieldRow($modPenerimaanItems,'tglterima', array('class'=>'span3', 'disabled'=>$disabled, 'readonly'=>true)) ?>
					<?php
					//echo $form->dropDownListRow($modFakturPembelian,'supplier_id',
					//  CHtml::listData($modFakturPembelian->SupplierItems, 'supplier_id', 'supplier_nama'),
					//    array('disabled'=>$disabled,'class'=>'span3 isRequired', 'onkeypress'=>"return $(this).focusNextInputField(event)",
					//  'empty'=>'-- Pilih --',)); 
					?>

                </td>
            </tr>
        </table>  
						<?php //}  ?>
        <table width="100%">
            <tr>
                <td>
                    <div class="control-group ">
							<?php echo $form->labelEx($model, 'nopenerimaan', array('class' => 'control-label')); ?>
						<div class="controls">
							<?php echo CHtml::hiddenField('terimapersediaan_id', '', array('readonly' => TRUE)); ?>
							<?php // echo $form->hiddenField($model,'supplier_id',array('readonly'=>TRUE)); ?>
							<?php
							$this->widget('MyJuiAutoComplete', array(
								'model' => $model,
								'attribute' => 'nopenerimaan',
								'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/noTerima'),
								'options' => array(
									'showAnim' => 'fold',
									'minLength' => 2,
									'select' => 'js:function( event, ui ) {
                                                      $("#' . CHtml::activeId($model, 'nopenerimaan') . '").val(ui.item.nopenerimaan);   
                                                      $("#' . CHtml::activeId($model, 'peg_penerima_id') . '").val(ui.item.peg_penerima_id); 
                                                      $("#' . CHtml::activeId($model, 'peg_mengetahui_id') . '").val(ui.item.peg_mengetahui_id); 
                                                      $("#' . CHtml::activeId($model, 'tglterima') . '").val(ui.item.tglterima);   
                                                      $("#' . CHtml::activeId($model, 'sumberdana_id') . '").val(ui.item.sumberdana_id);   
                                                      $("#' . CHtml::activeId($model, 'tglsuratjalan') . '").val(ui.item.tglsuratjalan);   
                                                      $("#' . CHtml::activeId($model, 'terimapersediaan_id') . '").val(ui.item.terimapersediaan_id);   
                                                      $("#' . CHtml::activeId($model, 'keterangan_persediaan') . '").val(ui.item.keterangan_persediaan);   
                                                      $("#' . CHtml::activeId($model, 'nosuratjalan') . '").val(ui.item.nosuratjalan);   
                                                      $("#' . CHtml::activeId($model, 'peg_penerima_nama') . '").val(ui.item.penerima.nama_pegawai);   
                                                      $("#' . CHtml::activeId($model, 'peg_mengetahui_nama') . '").val(ui.item.pegawaiMengetahui);   
                                                      submitPermintaanPembelian();
                                            }',
								),
								'htmlOptions' => array(
									'disabled' => $disabled,
									'onkeypress' => "$(this).focusNextInputField(event)", 'class' => 'span2', 'readonly' => FALSE),
								'tombolDialog' => $dialog,
							));
							?>

						</div>
                    </div>    
							<?php echo $form->dropDownListRow($model, 'sumberdana_id', CHtml::listData(SumberdanaM::model()->findAll('sumberdana_aktif = true'), 'sumberdana_id', 'sumberdana_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <div class="control-group ">
							<?php echo $form->labelEx($model, 'tglterima', array('class' => 'control-label')) ?>
                        <div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tglterima',
								'mode' => 'datetime',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
									'maxDate' => 'd',
								),
								'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
							));
							?>
						<?php echo $form->error($model, 'tglterima'); ?>
                        </div>
                    </div>
                    <div class="control-group ">
							<?php echo $form->labelEx($model, 'tglsuratjalan', array('class' => 'control-label')) ?>
                        <div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tglsuratjalan',
								'mode' => 'datetime',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
									'maxDate' => 'd',
								),
								'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
							));
							?>
					<?php echo $form->error($model, 'tglsuratjalan'); ?>
                        </div>
                    </div>   
                </td>
                <td>
						<?php echo $form->textFieldRow($model, 'nosuratjalan', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                    <div class="control-group">
						<?php
						//                 echo $form->dropDownListRow($model,'supplier_id',
						//                 CHtml::listData(SupplierM::model()->SupplierItems, 'supplier_id', 'supplier_nama'),
						//                 array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
						//                 'empty'=>'-- Pilih --')); 
						?>

						<?php
						echo $form->dropDownListRow($model, 'supplier_id', CHtml::listData(SupplierM::model()->SupplierItems, 'supplier_id', 'supplier_nama'), array('empty' => '-- Pilih --', //'class'=>'reqPasien',
							//                                        'ajax'=>array('type'=>'POST',
							//                                                                'url'=>  CController::createUrl('dynamicSupplier'),
							//                                                                'update'=>'#AMPesanambulansT_ruangan_id',
							//                                                    ),
							'onChange' => 'submitSupplier(this.value)',
							'onkeypress' => "return $(this).focusNextInputField(event)",
							'class' => 'span2')
						);
						?>
                    </div>
                    <div class="control-group ">
							<?php echo $form->labelEx($model, 'peg_penerima_id', array('class' => 'control-label')); ?>
                        <div class="controls">
							<?php echo $form->hiddenField($model, 'peg_penerima_id'); ?>
                            <!--                <div class="input-append" style='display:inline'>-->
							<?php
							$this->widget('MyJuiAutoComplete', array(
								'model' => $model,
								'attribute' => 'peg_penerima_nama',
								'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
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
                                                                                $(this).val( ui.item.label);
                                                                                return false;
                                                                            }',
									'select' => 'js:function( event, ui ) {
                                                                                $("#' . Chtml::activeId($model, 'peg_penerima_id') . '").val(pegawai_id); 
                                                                                return false;
                                                                            }',
								),
								'htmlOptions' => array(
									'class' => 'namaPegawai',
									'readonly' => true,
									'onkeypress' => "return $(this).focusNextInputField(event)",
								),
								'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction' => 'openDialog("' . Chtml::activeId($model, 'peg_penerima_id') . '");'),
							));
							?>
<?php echo $form->error($model, 'peg_penerima_id'); ?>
                        </div>
                    </div>
                </td>
                <td>
                    <div class="control-group ">
							<?php echo $form->labelEx($model, 'peg_mengetahui_id', array('class' => 'control-label')); ?>
                        <div class="controls">
							<?php echo $form->hiddenField($model, 'peg_mengetahui_id'); ?>
                            <!--                <div class="input-append" style='display:inline'>-->
							<?php
							$this->widget('MyJuiAutoComplete', array(
								'model' => $model,
								'attribute' => 'peg_mengetahui_nama',
								'source' => 'js: function(request, response) {
                                                   $.ajax({
                                                       url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
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
                                                                                $(this).val( ui.item.label);
                                                                                return false;
                                                                            }',
									'select' => 'js:function( event, ui ) {
                                                                                $("#' . Chtml::activeId($model, 'peg_mengetahui_id') . '").val(pegawai_id); 
                                                                                return false;
                                                                            }',
								),
								'htmlOptions' => array(
									'class' => 'namaPegawai',
									'readonly' => true,
									'onkeypress' => "return $(this).focusNextInputField(event)",
								),
								'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction' => 'openDialog("' . Chtml::activeId($model, 'peg_mengetahui_id') . '");'),
							));
							?>
					<?php echo $form->error($model, 'peg_mengetahui_id'); ?>
                        </div>
                    </div>
<?php echo $form->textAreaRow($model, 'keterangan_persediaan', array('rows' => 4, 'cols' => 50, 'class' => 'span4', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                </td>
            </tr>
        </table>
    </fieldset>
    <table width="100%">
        <tr>
            <td>
                <fieldset class='box rqd'>
                    <legend class="rim">Data Faktur</legend>
							<?php echo $form->textFieldRow($model, 'nofaktur', array('class' => 'span3 isRequiredFaktur isRequired')) ?>
                    <div class="control-group ">
							<?php echo $form->labelEx($model, 'tglfaktur', array('class' => 'control-label')) ?>
                        <div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tglfaktur',
								'mode' => 'datetime',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
								),
								'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 isRequired', 'onkeypress' => "return $(this).focusNextInputField(event)"
								),
							));
							?>
                        </div>
                    </div>
                    <div class="control-group ">
							<?php echo $form->labelEx($model, 'tgljatuhtempo', array('class' => 'control-label')) ?>
                        <div class="controls">
							<?php
							$this->widget('MyDateTimePicker', array(
								'model' => $model,
								'attribute' => 'tgljatuhtempo',
								'mode' => 'datetime',
								'options' => array(
									'dateFormat' => Params::DATE_FORMAT,
								),
								'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)"
								),
							));
							?>
                        </div>
                    </div>
					<?php //echo $form->textFieldRow($model,'biayamaterai', array('class'=>'span3 integer2')) ?>
<?php //echo $form->textAreaRow($model,'keteranganfaktur', array('class'=>'span3'))  ?>
<?php
//echo $form->dropDownListRow($model,'syaratbayar_id',
//                                CHtml::listData($model->SyaratBayarItems, 'syaratbayar_id', 'syaratbayar_nama'),
//                                array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
//                                'empty'=>'-- Pilih --',)); 
?>
                </fieldset>
            </td>
            <td>
                <fieldset class="box row-fluid">
                    <legend class="rim">Informasi Harga</legend>
					<div class="span6">
								<?php echo $form->textFieldRow($model, 'totalharga', array('class' => 'span2 isRequired integer2 totalharga', 'readonly' => TRUE)) ?>
						<div class="control-group ">
							<label class='control-label'>
<?php echo CHtml::checkbox('termasukPPN', false, array('onclick' => 'persenPPN(this)', 'style' => 'width : 10px', 'class' => 'integer2')) ?>
								Ppn (Total)
							</label>
							<div class="controls">
<?php echo $form->textField($model, 'pajakppn', array('class' => 'span2 integer2 isRequired', 'readonly' => TRUE)) ?>
							</div>
						</div>
						<div class="control-group ">
							<label class='control-label'>
<?php echo CHtml::checkBox('termasukPPH', false, array('onclick' => 'persenPPH(this)', 'style' => 'width : 10px', 'class' => 'integer2', 'readonly' => TRUE)) ?>
								Pph (Total)
							</label>
							<div class="controls">
								<?php echo $form->textField($model, 'pajakpph', array('class' => 'span2 integer2 isRequired', 'readonly' => TRUE)) ?>
							</div>
						</div>
					</div>
					<div class="span6">
						<div class="control-group ">
							<label class='control-label'>
<?php echo CHtml::checkbox('diskonSemuaRp', false, array('onclick' => 'diskonFakturRp(this)', 'style' => 'width : 10px', 'class' => 'integer2')) ?>
								Diskon Rp / Faktur
							</label>
							<div class="controls">
<?php echo $form->textField($model, 'discount', array('onkeyup' => 'gantiDiskonFakturRp(this);', 'class' => 'span2 isRequired integer2', 'readonly' => TRUE)) ?>
							</div>
						</div>
						<div class="control-group ">
							<label class='control-label'>
						<?php echo CHtml::checkbox('biayaAdmin', false, array('onclick' => 'biayaAdministrasi()', 'style' => 'width : 10px', 'class' => 'integer2')) ?>
								Biaya Administrasi
							</label>
							<div class="controls">
<?php echo $form->textField($model, 'biayaadministrasi', array('onkeyup' => 'gantiDiskonFakturPersen(this);', 'class' => 'span2 isRequired  integer2', 'readonly' => TRUE)) ?>
							</div>
						</div>
<?php //echo $form->textFieldRow($model,'totalhargabruto', array('class'=>'span2 isRequired currency','readonly'=>TRUE))  ?>
<?php echo CHtml::hiddenField('cadangan') ?>
					</div>
                </fieldset>
            </td>
        </tr>
       <!--  <tr>
            <td>
                <fieldset>
                    <legend class="rim">Notifikasi</legend> 

                    Notifikasi -->
<?php // echo $form->textField($model,'notifikasi', array('maxlength'=>'2','class'=>'numberOnly','style'=>'width:20px;',))  ?> 
		<!--                 hari dari tanggal jatuh tempo
	
					</fieldset>
				</td>
			</tr>     -->
    </table>       
    <table id="tableFaktur" class="table table-bordered table-condensed">
        <thead>
			<tr>
				<!--<th>No.Urut</th>-->
				<th>Golongan</th>
				<th>Bidang</th>
				<th>Kelompok</th>
				<th>Sub Kelompok</th>
				<th>Sub Sub Kelompok</th>
				<th>Kode barang /<br/>Nama Barang</th>
				<th>Jumlah Terima</th>
				<th>Satuan</th>
				<th>Jumlah Dalam <br />Kemasan </th>
				<th>Harga Satuan</th>
				<th>Harga Beli</th>
				<!--th>Sub Total</th-->
				<th>Kondisi</th>
			<?php if (!isset($modFakturDetail)) { ?>
					<th>Batal</th>     
			<?php } ?>
			</tr>
        </thead>
        <tbody>
			<?php
			//          if (isset($modFakturDetail)) {
			//             if (count($modFakturDetail) > 0){
			//                 $tr = '';
			//                 $no = 1;
			//                 foreach ($modFakturDetail as $key => $value) {
			//                     $subTotal = (($value->harganettofaktur+$value->hargappnfaktur + $value->hargapphfaktur)*$value->jmlterima) - $value->jmldiscount;
			//                     $subTotalCadangan += (($value->harganettofaktur+$value->hargappnfaktur + $value->hargapphfaktur)*$value->jmlterima);
			//                     $hitungSubTotalCadangan +=(($value->harganettofaktur+$value->hargappnfaktur + $value->hargapphfaktur)*$value->jmlterima) - $value->jmldiscount;
			//                     $tampilDetail = ObatalkesM::model()->findByPk($value->obatalkes_id);
			//                     $tr .="<tr>
			//                         <td>".CHtml::TextField('noUrut',$no++,array('class'=>'span1 noUrut','readonly'=>TRUE)).
			//                               CHtml::activeHiddenField($value,'['.$key.']satuankecil_id').
			//                               CHtml::activeHiddenField($value,'['.$key.']obatalkes_id', array('class'=>'obatAlkes')). 
			//                               CHtml::activeHiddenField($value,'['.$key.']penerimaandetail_id'). 
			//                               CHtml::activeHiddenField($value,'['.$key.']satuanbesar_id').
			//                               CHtml::activeHiddenField($value,'['.$key.']sumberdana_id'). 
			//                               CHtml::activeHiddenField($value,'['.$key.']tglkadaluarsa').
			//                               CHtml::activeHiddenField($value,'['.$key.']jmlkemasan').   
			//                               CHtml::activeHiddenField($value,'['.$key.']persendiscount', array('class'=>'diskoncadangan')).   
			//                        "</td>
			//                         <td>".$tampilDetail->sumberdana->sumberdana_nama."</td>
			//                         <td>".$tampilDetail->obatalkes_kategori."/<br/>".$tampilDetail->obatalkes_nama."</td>
			//                         <td>".CHtml::activeTextField($value,'['.$key.']jmlpermintaan',array('class'=>'span1 permintaan'))."</td>
			//                         <td>".CHtml::activeTextField($value,'['.$key.']jmlterima',array('readonly'=>TRUE,'class'=>'span1 terima integer2','onkeyup'=>'hitungJumlahDariDiterima(this);'))."</td>
			//                         <td>".CHtml::activeTextField($value,'['.$key.']persendiscount',array('maxlength'=>3,'class'=>'span1 persenDiskon integer2','onkeyup'=>'hitungJumlahDariPersentaseDiskon(this);'))
			//                              .CHtml::hiddenField('diskonLama','',array('maxlength'=>3,'class'=>'span1 integer2'))
			//                             ."</td>
			//                         <td>".CHtml::activeTextField($value,'['.$key.']jmldiscount',array('class'=>'span2 currency jmlDiskon','readonly'=>true))."</td>
			//                         <td>".CHtml::activeTextField($value,'['.$key.']harganettofaktur',array('readonly'=>FALSE,'class'=>'span2 netto currency', 'onkeyup'=>'ubahNetto(this);'))."</td>
			//                         <td>".CHtml::activeTextField($value,'['.$key.']hargappnfaktur',array('readonly'=>FALSE,'class'=>'span2 ppn currency'))."</td>
			//                         <td>".CHtml::activeTextField($value,'['.$key.']hargapphfaktur',array('readonly'=>FALSE,'class'=>'span2 pph currency'))."</td>
			//                         <td>".CHtml::textField('subTotal',$subTotal,array('readonly'=>true,'class'=>'span2 subTotal currency'))."</td>
			//                     </tr>
			//                     ";
			//                 }
			//                 echo $tr;
			//                 echo CHtml::hiddenField('subTotalCadangan', $subTotalCadangan);
			//                 echo CHtml::hiddenField('hitungSubTotalCadangan', $hitungSubTotalCadangan);
			//             }
			// //            ,'onkeyup'=>'hitungJumlahDariDiskon(this);'
			//         }
			?>
        </tbody>
		<?php
		echo "<tfoot>
            <tr>
                 <td colspan='10'>Total</td>
                 <td>" .
		CHtml::textField('tothargabruto', '', array('style' => 'text-align:right;', 'readonly' => TRUE, 'class' => 'totalhargabruto span2 currency')) .
		/*
		"</td>
             </tr>
            <tr>
                 <td colspan='10'>Uang Muka</td>
                 <td>" . */
		//                      CHtml::textField('uangmuka',$jmlUang, array( 'style'=>'text-align:right','readonly'=>TRUE,'class'=>'uangmuka span2 currency')).
		// CHtml::textField('uangmuka', '', array('style' => 'text-align:right', 'readonly' => TRUE, 'class' => 'uangmuka span2 currency')) .
		"</td>
             </tr>
            <tr hidden>
                 <td colspan='10'>Sisa Bayar</td>
                 <td>" .
		CHtml::textField('sisabayar', '', array('style' => 'text-align:right', 'readonly' => TRUE, 'class' => 'sisabayar span2 currency')) .
		"</td>
             </tr>
             </tfoot>
        ";
		?>
    <!-- <tfoot>
            <tr>
                <th colspan="5">Total</th>
                <th><?php //echo $form->textField($modFakturPembelian,'persendiscount', array('class'=>'span1 isRequired integer2','maxlength'=>2,'onkeyup'=>'hitungJumlahHargaDiskon(this);')) ?></th>
                <th><?php //echo $form->textField($modFakturPembelian,'jmldiscount', array('class'=>'span1 isRequired','readonly'=>TRUE))  ?></th>
                <th><?php //echo $form->textField($modFakturPembelian,'totharganetto', array('class'=>'span1 isRequired','readonly'=>TRUE)) ?></th>
                <th><?php //echo $form->textField($modFakturPembelian,'totalpajakppn', array('class'=>'span1 isRequired','readonly'=>TRUE))  ?></th>
                <th><?php //echo $form->textField($modFakturPembelian,'totalpajakpph', array('class'=>'span1 isRequired','readonly'=>TRUE))  ?></th>     
                <th><?php //echo CHtml::textField('totalSubTotal',$modFakturPembelian->totalhargabruto, array('class'=>'span1 isRequired','readonly'=>TRUE))  ?></th>
	<?php //if (!isset($modFakturDetail)) { ?>
                <th></th>
	<?php //} ?>
            </tr>
        </tfoot> -->
    </table>
	<?php
	// FORM REKENING
	//    $this->renderPartial('keuangan.views.fakturPembelianGU.rekening._formRekening',
	//        array(
	//            'form'=>$form,
	//            'modRekenings'=>$modRekenings,
	//        )
	//    );
	?>
    <div class="form-actions">
		<?php
		if (!empty($model->nofaktur)) {
			$urlPrint = Yii::app()->createAbsoluteUrl('gudangFarmasi/penerimaanItems/printFaktur', array('idFaktur' => $modFakturPembelian->fakturpembelian_id));
			$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
			Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
		} else {
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'cekValidasi()'));
			echo CHtml::htmlButton(Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_simpan', 'style' => 'display:none;'));
		}
		?>
	<?php
	echo "&nbsp;" . CHtml::htmlButton(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-danger', 'type' => 'button'));
	?>
<?php
$content = $this->renderPartial('keuangan.views.tips.transaksi', array(), true);
$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
?>
    </div>            
<?php $this->endWidget(); ?>
</div>
<?php
//========= Dialog buat Permintaan Kebutuhan obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogPenerimaanBarang',
	'options' => array(
		'title' => 'Pencarian Terima Persediaan',
		'autoOpen' => false,
		'modal' => true,
		'width' => 900,
		'height' => 600,
		'resizable' => false,
	),
));

$format = new MyFormatter();
$modTerimaPers = new KUTerimapersediaanT;
if (isset($_GET['KUTerimapersediaanT'])) {
	$modTerimaPers->attributes = $_GET['KUTerimapersediaanT'];
	$modTerimaPers->peg_penerima_id = $_GET['KUTerimapersediaanT']['peg_penerima_id'];
	// $modTerimaPers->tglterima = $format->formatDateTimeForDb($_GET['KUTerimapersediaanT']['tglterima']);
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'permintaan-m-grid',
	'dataProvider' => $modTerimaPers->searchGU(),
	'filter' => $modTerimaPers,
	'template' => "{summary}\n{items}{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                    "id" => "selectPasien",
                                    "onClick" => "$(\"#' . CHtml::activeId($model, 'nopenerimaan') . '\").val(\"$data->nopenerimaan\");
                                                  $(\"#' . CHtml::activeId($model, 'terimapersediaan_id') . '\").val(\"$data->terimapersediaan_id\");
                                                  $(\"#' . CHtml::activeId($model, 'peg_penerima_id') . '\").val(\"$data->peg_penerima_id\");
                                                  $(\"#' . CHtml::activeId($model, 'peg_mengetahui_id') . '\").val(\"$data->peg_mengetahui_id\");
                                                  $(\"#' . CHtml::activeId($model, 'tglterima') . '\").val(\"$data->tglterima\"); 
                                                  $(\"#' . CHtml::activeId($model, 'sumberdana_id') . '\").val(\"$data->sumberdana_id\"); 
                                                  $(\"#' . CHtml::activeId($model, 'tglsuratjalan') . '\").val(\"$data->tglsuratjalan\");    
                                                  $(\"#' . CHtml::activeId($model, 'terimapersediaan_id') . '\").val(\"$data->terimapersediaan_id\");    
                                                  $(\"#' . CHtml::activeId($model, 'keterangan_persediaan') . '\").val(\"$data->keterangan_persediaan\");  
                                                  $(\"#' . CHtml::activeId($model, 'nosuratjalan') . '\").val(\"$data->nosuratjalan\");
                                                  $(\"#' . CHtml::activeId($model, 'peg_penerima_nama') . '\").val(\"$data->pegawaiPenerima\");
                                                  $(\"#' . CHtml::activeId($model, 'peg_mengetahui_nama') . '\").val(\"$data->pegawaiMengetahui\");  
                                                  $(\"#' . CHtml::activeId($model, 'totalharga') . '\").val(\"$data->totalharga\");    
                                                  $(\"#' . CHtml::activeId($model, 'discount') . '\").val(\"$data->discount\");  
                                                  $(\"#' . CHtml::activeId($model, 'biayaadministrasi') . '\").val(\"$data->biayaadministrasi\");  
                                                  $(\"#' . CHtml::activeId($model, 'pajakpph') . '\").val(\"$data->pajakpph\");
                                                  $(\"#' . CHtml::activeId($model, 'pajakppn') . '\").val(\"$data->pajakppn\");    
                                                  $(\"#' . CHtml::activeId($model, 'nofaktur') . '\").val(\"$data->nofaktur\");  
                                                  $(\"#' . CHtml::activeId($model, 'tglfaktur') . '\").val(\"$data->tglfaktur\");
                                                  $(\"#' . CHtml::activeId($model, 'supplier_id') . '\").val(\"$data->SupplierId\");
                                                  $(\"#' . CHtml::activeId($model, 'pembelianbarang_id') . '\").val(\"$data->pembelianbarang_id\");
												  $(\"#' . CHtml::activeId($model, 'supplier_id') . '\").val(\"$data->supplier_id\");
                                                  $(\"#' . CHtml::activeId($model, 'tgljatuhtempo') . '\").val(\"$data->tgljatuhtempo\");
												  $(\"#' . CHtml::activeId($model, 'peg_penerima_nama') . '\").val(\"".$data->penerima->nama_pegawai."\"); 
                                                  $(\"#' . CHtml::activeId($model, 'peg_mengetahui_nama') . '\").val(\"".(empty($data->mengetahui)?"":$data->mengetahui->nama_pegawai)."\");
												  $(\"#terimapersediaan_id\").val(\"$data->terimapersediaan_id\");    
                                                  
                                                  submitPermintaanPembelian();
                                                  $(\"#dialogPenerimaanBarang\").dialog(\"close\");    
                                        "))',
		),
		'nopenerimaan',
		array(
			'name' => 'tglterima',
                        'filter'=> false,
		),
		array(
			'header' => 'Nama Pegawai Penerima',
			'type' => 'raw',
			'name' => 'peg_penerima_id',
			'value' => '$data->penerima->nama_pegawai',
		)
	),
	'afterAjaxUpdate' => 'function(id, data){
            $("#testing").datepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional["id"], {"dateFormat":"dd M yy","timeText":"Waktu","hourText":"Jam","minuteText":"Menit","secondText":"Detik","showSecond":true,"timeOnlyTitle":"Pilih Waktu","timeFormat":"hh:mm:ss","changeYear":true,"changeMonth":true,"showAnim":"fold","yearRange":"-80y:+20y"}));
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();

//========= end Permintaan dialog =============================
?>

<?php
//========= Dialog buat untuk pegawai penerima =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
	'id' => 'dialogPegawai',
	'options' => array(
		'title' => 'Daftar Pegawai',
		'autoOpen' => false,
		'modal' => true,
		'width' => 750,
		'height' => 600,
		'resizable' => false,
	),
));

$modPegawai = new KUPegawaiM('search');
$modPegawai->unsetAttributes();


if (isset($_GET['KUPegawaiM']))
	$modPegawai->attributes = $_GET['KUPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
	'id' => 'pegawai-m-grid1',
	'dataProvider' => $modPegawai->searchDialog(),
	'filter' => $modPegawai,
	'template' => "{summary}\n{items}{pager}",
	'itemsCssClass' => 'table table-striped table-bordered table-condensed',
	'columns' => array(
		//'pegawai_id',
		'nomorindukpegawai',
		'namaLengkap',
		'alamat_pegawai',
		'agama',
		array(
			'name' => 'jeniskelamin',
			'filter' => LookupM::getItems('jeniskelamin'),
			'value' => '$data->jeniskelamin',
		),
		array(
			'header' => 'Pilih',
			'type' => 'raw',
			'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    var parent = $(\"#dialogPegawai\").attr(\"parentclick\");
                                    $(\"#\"+parent+\"\").val($data->pegawai_id);
                                    $(\"#\"+parent+\"\").parents(\".controls\").find(\".namaPegawai\").val(\"$data->nama_pegawai\");
                                    $(\"#dialogPegawai\").dialog(\"close\");   
                                    return false;"))',
		),
	),
	'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Permintaan dialog =============================
?>





<?php
$urlGetPenerimaanBarang = $this->createUrl('FakturPembelianGU/getPenerimaanPersediaan');
$idSupplier = CHtml::activeId($model, 'supplier_id');
$konfigFarmasi = KonfigfarmasiK::model()->find();
$persenPPN = $konfigFarmasi->persenppn;
$persenPPH = $konfigFarmasi->persenpph;
$idPersenDiskon = CHtml::activeId($modFakturPembelian, 'persendiscount');
$idTotalHargaNetto = CHtml::activeId($modFakturPembelian, 'totharganetto');
$idTotalPajakPPN = CHtml::activeId($modFakturPembelian, 'totalpajakppn');
$idTotalPajakPPH = CHtml::activeId($modFakturPembelian, 'totalpajakpph');
$idJumlahDiskon = CHtml::activeId($modFakturPembelian, 'jmldiscount');
$idSyaratBayar = CHtml::activeId($modFakturPembelian, 'syaratbayar_id');
$idTotalHargaBruto = CHtml::activeId($modFakturPembelian, 'totalhargabruto');
$jscript = <<< JS

function hitungJumlahHargaDiskon(obj)
{
    besarDiskon =obj.value;
   
    $('.persenDiskon').each(function() {
          $(this).val(besarDiskon);
        });
    hitungSemua();
}

function cekValidasi()
{   
  
  hargaTotalNetto = unformatNumber($('#GFFakturPembelianT_totharganetto').val());
  
 if ($('.isRequired').val()==''){
    alert ('Harap Isi Semua Data Yang Bertanda *');
  }
  /*else if(hargaTotalNetto<1){
     alert('Anda Belum memilih Obat Yang Akan Diminta');   
  }*/else{
     $('#btn_simpan').click();
  }
}



function submitSupplier(supplier_id,sisabayar){
        var sisabayar = $('#sisabayar').val();
        getDataRekeningFaktur(supplier_id,sisabayar);
    }

function submitPermintaanPembelianDariInformasi(idPenerimaan,noPenerimaan,tglPenerimaan)
{
    idPenerimaanBarang = idPenerimaan;
        if(idPenerimaanBarang==''){
            alert('Silahkan Pilih penerimaan Terlebih Dahulu');
        }else{
            $.post("${urlGetPenerimaanBarang}", { idPenerimaanBarang: idPenerimaanBarang },
            function(data){
                $('#tableFaktur > tbody').append(data.tr);
			
			console.log(data.tr);
                $('#idPenerimaanBarang').val(idPenerimaan);
               
                $('#${idSupplier}').val(data.supplier_id);
                $('#GFPenerimaanBarangT_noterima').val(noPenerimaan);
                $('#buttonpenerimaanBarang').attr('disabled','TRUE');
                $('#GFPenerimaanBarangT_tglterima').val(tglPenerimaan);
                $('#GFPenerimaanBarangT_noterima').attr('readonly','TRUE');
                $('#GFPenerimaanBarangT_tglterima').attr('readonly','TRUE');
                $('#GFFakturPembelianT_supplier_id').attr('readonly','TRUE');
                hitungSemua();
                
                if(data.isPPN=='1'){ //Jika termasuk PPN
                 $('#termasukPPN').attr('checked','checked');
                }
                
                if(data.isPPH=='1'){ //Jika termasuk PPH
                 $('#termasukPPH').attr('checked','checked');
                }
                
               var idObat = $("#tableFaktur tbody").parents().find('input[name$="[obatalkes_id]"]').val();
               var qty = $("#tableFaktur tbody").parents().find('input[name$="[jmlkemasan]"]').val();
                
               var supplier_id = $('#GFFakturPembelianT_supplier_id').val();                
               var hargaSatuan = unformatNumber($("#tableFaktur tbody").parents().find('input[name$="[harganettofaktur]"]').val());                               
               var total = unformatNumber($('#GFFakturPembelianT_totalhargabruto').val());
//               var total = unformatNumber($('#tableFaktur tbody').parents().find('.subTotal').val());
               var diskon = unformatNumber($('#tableFaktur tbody').parents().find('input[name$="[persendiscount]"]').val());
//                   saldo = (total - (total * (diskon/100)));
                   saldo = total;
                   if(saldo < 0){
                        saldo = total;
                   }
                
                hapusJurnal(idObat);
                getDataRekeningFaktur(supplier_id,saldo);
                setTimeout(function(){//karna form rekening butuh waktu ketika ajax request nya
                    updateRekeningFaktur(supplier_id, formatDesimal(saldo));
                },500);
                
            }, "json");
        }   
}  


function persenPPN(obj)
{
    if(obj.checked==true){ //Jika tidak termasuk PPN
          jumlahPPN = parseFloat(unformatNumber($('#KUTerimapersediaanT_totalharga').val())) * (parseFloat(${persenPPN})/100);
          $('#termasukPPN').val(jumlahPPN);
          $('#KUTerimapersediaanT_pajakppn').val(formatNumber(jumlahPPN));
          $('#termasukPPH').removeAttr('readonly');
    }else{//Jika Termasuk PPN
        $('#termasukPPH').removeAttr('checked'); 
        $('#KUTerimapersediaanT_pajakppn').val(0);
        $('#termasukPPH').attr('readonly','TRUE');
        $('#KUTerimapersediaanT_pajakpph').val(0);     
        $('#totalPPH').val(0);
        $('#termasukPPH').val(0);  
        $('#termasukPPN').val(0);     
    }
   hitungSemua();

}
               
function persenPPH(obj)
{
    if(obj.checked==true){ 
          jumlahPPH= parseFloat($('#KUTerimapersediaanT_totalharga').val()) * (parseFloat(${persenPPH})/100);
          $('#termasukPPH').val(jumlahPPH);
          $('#KUTerimapersediaanT_pajakpph').val(jumlahPPH);
    }else{
          $('#termasukPPH').val(0);  
          $('#KUTerimapersediaanT_pajakpph').val(0);          
    }

   hitungSemua();
}



function remove(obj) {
    $(obj).parents('tr').remove();
    var idbarang = $("#tableFaktur tbody").parents().find('input[name$="[barang_id]"]').val();
    removeRekeningObat(idbarang);
    hitungSemua();
}
            
function hapusJurnal(idObat) {
    removeRekeningObat(idObat);
    hitungSemua();
}

function openDialog(obj){
        $('#dialogPegawai').attr('parentClick',obj);
        $('#dialogPegawai').dialog('open');   
    }
JS;
Yii::app()->clientScript->registerScript('faktur', $jscript, CClientScript::POS_HEAD);
?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
	'element' => '.integer',
	'config' => array(
		'defaultZero' => true,
		'allowZero' => true,
		'allowDecimal' => true,
		'decimal' => '.',
		'thousands' => '',
		'precision' => 0,
	)
));
?>
<script type="text/javascript">
	
	function submitPermintaanPembelian()
	{
		var idTerimaPers = $('#terimapersediaan_id').val();
		if (idTerimaPers == '') {
			alert('Silahkan Pilih penerimaan Terlebih Dahulu');
		} else {
			$("#tableFaktur tbody tr").remove();
			$.post('<?php echo $this->createUrl('FakturPembelianGU/getPenerimaanPersediaan'); ?>', {idTerimaPers: idTerimaPers},
			function (data) {
				$('#tableFaktur').append(data.tab);

				$("#tableFaktur tbody tr .integer2").maskMoney({"defaultZero": true, "allowZero": true, "decimal": ",", "thousands": ".", "precision": 0, "symbol": null});
//                $('#${idSupplier}').val(data.supplier_id);
//                $('#uangmuka').val(formatUang(data.uangMuka));
				$('#uangmuka').val(data.uangMuka);
				// $("#KUTerimapersediaanT_supplier_id").val(data.persdiaan.supplier_id);
//                $("#${idSupplier}").attr("disabled","disabled");
				hitungSemua();

				if (data.isPPN == '1') { //Jika termasuk PPN
					$('#termasukPPN').attr('checked', 'checked');
				}

				if (data.isPPH == '1') { //Jika termasuk PPH
					$('#termasukPPH').attr('checked', 'checked');
				}
				var idObat = $("#tableFaktur tbody").parents().find('input[name$="[obatalkes_id]"]').val();
				var qty = $("#tableFaktur tbody").parents().find('input[name$="[jmlkemasan]"]').val();

				var supplier_id = $('#KUTerimapersediaanT_supplier_id').val();
//                var supplier_id = 19;
//                alert(supplier_id);
				var hargaSatuan = unformatNumber($("#tableFaktur tbody").parents().find('input[name$="[harganettofaktur]"]').val());
				var diskon = unformatNumber($('#tableFaktur tbody').parents().find('input[name$="[persendiscount]"]').val());
				var total = unformatNumber($('#GFFakturPembelianT_totalhargabruto').val());
//               var total = unformatNumber($('#tableFaktur tbody').parents().find('input[name$="[harganettofaktur]"]').val());

//                   saldo = (total - (total * (diskon/100)));
				saldo = total;
				if (saldo < 0) {
					saldo = total;
				}
				var sisabayar = $('#sisabayar').val();
//                   getDataRekeningFaktur(supplier_id,sisabayar);
				setTimeout(function () {//karna form rekening butuh waktu ketika ajax request nya
//                        updateRekeningFaktur(supplier_id, formatDesimal(sisabayar))
				}, 1500);
			}, "json");
		}
	}

	function ubahNetto(obj) {
		hitungSemua();
	}
	function hitungUlang() {
		netto = 0;
		jmlTerima = 0;
		jmlDiskon = 0;
		ppn = 0;
		pph = 0;
		sumSubtotal = 0;
		diskonRp = 0;
		$('.terima').each(function () {
			jmlTerima = parseFloat($(this).parents("tr").find('.terima').val());
			persenDiskon = unformatNumber($(this).parents("tr").find('.persenDiskon').val());
			jmlDiskon = unformatNumber($(this).parents("tr").find('.jmlDiskon').val());
			netto = unformatNumber($(this).parents("tr").find('.netto').val());
			ppn = unformatNumber($(this).parents("tr").find('.ppn').val());
			pph = unformatNumber($(this).parents("tr").find('.pph').val());

			//mencari total harga bruto
			totalHargaBruto = jmlTerima * netto;
			//mencari total harga bruto sudah di kurangi dengan diskon
			totalHargaDikurangiDiskon = totalHargaBruto - (totalHargaBruto * (persenDiskon / 100));
			totalHarga = totalHargaDikurangiDiskon + ppn + pph;
			diskonRp = totalHargaBruto * persenDiskon / 100;

			parseFloat($(this).parents("tr").find('.subTotal').val(totalHarga));
			parseFloat($(this).parents("tr").find('.jmlDiskon').val(diskonRp));
			sumSubtotal += totalHarga;

		});

		//untuk memasukkan harga netto ke faktur pembelian
		$('#GFFakturPembelianT_totalhargabruto').val(sumSubtotal);
	}
	function diskonFakturRp() {
		if ($('#diskonSemuaRp').is(':checked')) {
			$('#KUTerimapersediaanT_discount').removeAttr('readonly', 'false');
			$('#diskonSemua').attr('disabled', 'TRUE');
		} else {
			$('#KUTerimapersediaanT_discount').attr('readonly', 'TRUE');
			$('#diskonSemua').removeAttr('disabled');
			$('#KUTerimapersediaanT_discount').val(0);
		}
	}

	function biayaAdministrasi() {
		if ($('#biayaAdmin').is(':checked')) {
			$('#KUTerimapersediaanT_biayaadministrasi').removeAttr('readonly', 'false');
			$('#KUTerimapersediaanT_biayaadministrasi').val(0);
		} else {
			$('#KUTerimapersediaanT_biayaadministrasi').attr('readonly', 'TRUE');
			$('#KUTerimapersediaanT_biayaadministrasi').val(0);
		}
	}

	function gantiDiskon(obj) {
		dis = $(obj).val();
		hitungSemua();
	}

	function gantiDiskonRp(obj) {
		disRp = $(obj).val();
		tot = $('#GFFakturPembelianT_totalhargabruto').val();
		dis = parseFloat((disRp / tot) * 100);

		$('#GFFakturPembelianT_persendiscount').val(dis);
		$('.persenDiskon').val(dis);
		hitungSemua();
	}

	function gantiDiskonFakturRp(obj) {
		if ($('#diskonSemuaRp').is(':checked')) {
			var hargaBruto = unformatNumber($('#tothargabruto').val());
			var CadanganHarga = unformatNumber($('#hargaBruto').val());
			var hargaBrutoC = unformatNumber($('#cadangan').val());
			var diskonRp = unformatNumber(obj.value);

//         totHargaBruto  = (hargaBruto - diskonRp);
			totHargaBruto = (hargaBrutoC - diskonRp);
			diskonPersen = ((((hargaBrutoC - totHargaBruto) / hargaBruto) * 100));

			$('#GFFakturPembelianT_totalhargabruto').val(totHargaBruto);
			$('#GFFakturPembelianT_persendiscount').val(diskonPersen.toFixed(2));

		} else {
			var diskonRp = unformatNumber($('#GFFakturPembelianT_jmldiscount').val());
			$('#GFFakturPembelianT_jmldiscount').val(diskonRp);
		}
		hitungSemua();
	}

	function gantiDiskonFakturPersen(obj) {
		if ($('#diskonSemua').is(':checked')) {
			var hargaBruto = unformatNumber($('#tothargabruto').val());
			var diskonPersen = unformatNumber(obj.value);
			totHargaBruto = Math.round(hargaBruto - (hargaBruto * (diskonPersen / 100)));
			diskonRp = Math.round(hargaBruto * (diskonPersen / 100));

			$('#GFFakturPembelianT_totalhargabruto').val(totHargaBruto);
			$('#GFFakturPembelianT_jmldiscount').val(diskonRp);
		} else {
			var diskonPersen = unformatNumber($('#GFFakturPembelianT_persendiscount').val());
			$('#GFFakturPembelianT_persendiscount').val(diskonPersen);
		}
		hitungSemua();
	}

	function hitungJumlahDariPersentaseDiskon(obj)
	{
		subtotals = 0;
		netto = 0;
		diskons = 0;
		persenDiskon = unformatNumber(obj.value);
		jumlahDiterima = unformatNumber($(obj).parents("tr").find('.terima').val());
		hargaProdukNetto = unformatNumber($(obj).parents("tr").find('.netto').val());
		jumlahDiskonProduk = (hargaProdukNetto * (persenDiskon / 100)) * jumlahDiterima;
		subtotal = (hargaProdukNetto * jumlahDiterima) - jumlahDiskonProduk;
		var diskonLama = unformatNumber($(obj).parents("tr").find('.diskonLama').val());

		if (persenDiskon > 100) {
			alert('Maaf Diskon yang dimasukan tidak boleh lebih dari 100 %');
			$(obj).parents("tr").find('.persenDiskon').val(diskonLama);
			hitungSemua();
			setRekening();
			return true;
		} else {
			$(obj).parents("tr").find('.jmlDiskon').val(formatUang(jumlahDiskonProduk));
			$(obj).parents("tr").find('.subTotal').val(subtotal);

			$('.subTotal').each(function () {
				subtotals += unformatNumber($(this).parents("tr").find('.subTotal').val());
				netto += unformatNumber($(this).parents("tr").find('.netto').val());
				diskons += unformatNumber($(this).parents("tr").find('.jmlDiskon').val());
			});
			hitungSemua();
		}
		resetDiskonFaktur();
		hitungSemua();
	}

	function hitungJumlahDariDiskon(obj)
	{
		subtotals = 0;
		netto = 0;
		diskons = 0;
		jumlahDiterima = $(obj).parents("tr").find('.terima').val();
		jumlahDiskon = obj.value;
		hargaProdukNetto = $(obj).parents("tr").find('.netto').val();
		jumlahHarga = jumlahDiterima * hargaProdukNetto;
		if (jumlahDiskon == '' || jumlahDiskon == 0) {
			$(obj).parents("tr").find('.persenDiskon').val(0);
			$(obj).parents("tr").find('.jmlDiskon').val(0);
			$(obj).parents("tr").find('.jmlDiskon').select();
		} else {
			cekval = /^[0-9,]+$/.test(jumlahDiskon);
			if (cekval) {
				if (jumlahDiskon > jumlahHarga) {
					alert('Jumlah Diskon Tidak Boleh Melebihi Jumlah Diterima * Harga Netto');
					return false;
				} else {
					persenDiskon = ((jumlahDiskon * 100) / hargaProdukNetto) / jumlahDiterima;
					subtotal = (hargaProdukNetto - jumlahDiskon) * jumlahDiterima;
					$(obj).parents("tr").find('.persenDiskon').val(persenDiskon);
					$(obj).parents("tr").find('.subTotal').val(subtotal);
				}
			} else {
				alert('Input harga diskon tidak valid');
				$(obj).parents("tr").find('.jmlDiskon').focus();
				$(obj).parents("tr").find('.jmlDiskon').select();
			}
		}
		$('.subTotal').each(function () {
			subtotals += parseFloat($(this).parents("tr").find('.subTotal').val());
			netto += parseFloat($(this).parents("tr").find('.netto').val());
			diskons += parseFloat($(this).parents("tr").find('.jmlDiskon').val());
		});

		resetDiskonFaktur();
		hitungSemua();
	}
	function resetDiskonFaktur() {
		//mereset diskon faktur karena total brutonya berubah sehingga harus ada penghitungan ulang diskon untuk total harga bruto / hpp
		$('#GFFakturPembelianT_jmldiscount').val(0);
		$('#GFFakturPembelianT_persendiscount').val(0);
	}
	function cekInputan() {
		$('.integer2').each(function () {
			this.value = unformatNumber(this.value)
		});
		$('.currency').each(function () {
			this.value = unformatNumber(this.value)
		});
		return true;
	}
	function setRekening() {
		var supplier_id = $('#GFFakturPembelianT_supplier_id').val();
		var total = unformatNumber($('#GFFakturPembelianT_totalhargabruto').val());
		var diskon = unformatNumber($('#tableFaktur tbody').parents().find('input[name$="[persendiscount]"]').val());
		saldo = total;
		totalSaldo += saldo;
		if (saldo < 0) {
			saldo = total;
		}
		setTimeout(function () {//karna form rekening butuh waktu ketika ajax request nya
			updateRekeningFaktur(supplier_id, formatDesimal(saldo));
		}, 500);
	}

	function setFormat() {
		$('.terima').each(function () {

			nettoPerProduk = unformatNumber($(this).parents("tr").find('.netto').val());
			PPNPreProduk = unformatNumber($(this).parents("tr").find('.ppn').val());
			PPHPreProduk = unformatNumber($(this).parents("tr").find('.pph').val());
			jmlDiskon = unformatNumber($(this).parents("tr").find('.jmlDiskon').val());

			$(this).parents("tr").find('.ppn').val(formatUang(PPNPreProduk));
			$(this).parents("tr").find('.pph').val(formatUang(PPHPreProduk));
			$(this).parents("tr").find('.netto').val(formatUang(nettoPerProduk));
			$(this).parents("tr").find('.jmlDiskon').val(formatUang(jmlDiskon));
		});
	}
	hitungSemua();

	function setTotalHarga() {
		var discountPersen = $('#discountpersen').val();
		var totalHarga = 0;
		$('.cancel').each(function () {
			qty = $(this).parents('tr').find('.qty').val();
			satuan = $(this).parents('tr').find('.satuan').val();
			totalHarga += parseFloat(qty * satuan);
		});
//	$('#${totalharga}').val(totalHarga);

		$('#tothargabruto').val(totalHarga);
		if (jQuery.isNumeric(discountPersen)) {
//		$('#${discount}').val(totalHarga*discountPersen/100);
		}
	}

	function batal(obj) {
		myConfirm("<?php echo Yii::t('mds', 'Do You want to cancel?'); ?>", 'Perhatian!', function (r) {
			if (!r) {
				return false;
			} else {
				$(obj).parents('tr').remove();
				setTotalHarga();
				rename();
			}
		});
	}

	function rename() {
		noUrut = 1;
		$('.cancel').each(function () {
			$(this).parents('tr').find('[name*="TerimapersdetailT"]').each(function () {
				var nama = $(this).attr('name');
				data = nama.split('TerimapersdetailT[]');
				if (typeof data[1] === "undefined") {
				} else {
					$(this).attr('name', 'TerimapersdetailT[' + (noUrut - 1) + ']' + data[1]);
				}
			});
			noUrut++;
		});
	}


	function hitungSemua()
	{
		var totalHarga=0;
		var subTotalHarga=0;
		var sisabayar=0;
		var uangmuka=0;
		var hargasatuan=0;
		var jml=0;

		$('.beli').each(function(){
			var hargaBeli = parseFloat(unformatNumber($(this).parents("tr").find('.beli').val())); 
			var qty = parseFloat(unformatNumber($(this).parents("tr").find('.qty').val())); 
			var subTotalHarga = (hargaBeli*qty);
			var jml = parseFloat(unformatNumber($(this).parents("tr").find('.jml').val())); 
			console.log(hargaBeli, qty, subTotalHarga);
			var hargasatuan = hargaBeli/jml;
			if (jQuery.isNumeric(subTotalHarga)){
			  $(this).parents("tr").find('.subTotal').val(subTotalHarga);
			}
			if (jQuery.isNumeric(hargasatuan)){
			  $(this).parents("tr").find('.hargasatuan').val(hargasatuan);
			}
			totalHarga+=subTotalHarga;
		});

		var pajakppn  = parseFloat(unformatNumber($('#KUTerimapersediaanT_pajakppn').val()));
		var pajakpph  = parseFloat(unformatNumber($('#KUTerimapersediaanT_pajakpph').val()));
		var diskon    = parseFloat(unformatNumber($('#KUTerimapersediaanT_discount').val()));
		var biayaadministrasi = parseFloat(unformatNumber($('#KUTerimapersediaanT_biayaadministrasi').val()));

		if ($.isNumeric(totalHarga)){
			totalHarga = totalHarga + pajakppn + pajakpph - diskon + biayaadministrasi;
			$('.totalharga, .totalhargabruto').val(formatNumber(totalHarga));
		}

		sisabayar=totalHarga-uangmuka;
		if ($.isNumeric(sisabayar)){
			$('.sisabayar').val(formatNumber(sisabayar));
		}

		$('#RekeningsupplierV_0_saldodebit').val(formatNumber(sisabayar));
		$('#RekeningsupplierV_1_saldokredit').val(formatNumber(sisabayar));

		// $('.currency').maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null,'allowDecimal':true});                        
		noUrut = 1;
		 $('.noUrut').each(function() {
			  $(this).val(noUrut);
			  noUrut = noUrut + 1;
		 });
	}

	$(document).ready(function () {
		$(".rqd div label").append("<span class='required'> *</span>");
		$(".rqd div:last-child label span.required").remove();
	});

</script>