<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>

<?php
$this->widget('application.extensions.moneymask.MMask',array(
	'element'=>'.currency',
	'currency'=>'PHP',
	'config'=>array(
		'symbol'=>'Rp. ',
//        'showSymbol'=>true,
//        'symbolStay'=>true,
		'defaultZero'=>true,
		'allowZero'=>true,
		'precision'=>0,
	)
));

$this->widget('application.extensions.moneymask.MMask',array(
	'element'=>'.number',
	'config'=>array(
		'defaultZero'=>true,
		'allowZero'=>true,
		'precision'=>2,
	)
));

?>
<?php // Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gfobat-alkes-m-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#'.CHtml::activeId($model,'obatalkes_kode'),
)); ?>

<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<table width='100%'>
    <tr>
        <td width='40%'>
            <?php echo $form->hiddenField($model,'obatalkes_id'); ?>
            <?php echo $form->textFieldRow($model,'obatalkes_kode',array('placeholder'=>'Kode Obat Alkes','class'=>'span2', 
                                                    'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'disabled'=>true
                                                    )); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model,'obatalkes_nama', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php echo $form->textField($model,'obatalkes_nama',array('placeholder'=>'Nama Obat Alkes','class'=>'span3 all-caps',
                                                'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200,
                                                'onkeyup'=>'generateKode(this); AutoTextNamaOA();')); ?>
                </div>
            </div>
            <div class="control-group ">
                <?php echo CHtml::label('Nama Lain Obat Alkes <span class="required">*</span>','obatalkes_nama', array('class'=>'control-label required')) ?>
                <div class="controls">
                        <?php echo $form->textField($model,'obatalkes_namalain',array('placeholder'=>'Nama Lain Obat Alkes','class'=>'span3 all-caps',
                                                'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>200,
                                                'readonly'=>true
                                                )); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model,'obatalkes_kadarobat',LookupM::getItems('obatalkes_kadarobat'),
                                                    array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --','style'=>'width:100px;')); ?>

            <?php echo CHtml::label('Kekuatan', 'kekuatan', array('class'=>'control-label')); ?>
            <div class="control-group ">
                <div class="controls">
                        <?php echo $form->textField($model,'kekuatan',array('placeholder'=>'Kekuatan Obat Alkes','class'=>'span2 numbers-only', 
                                                        'onkeypress'=>"return $(this).focusNextInputField(event);",'onkeyup'=>'AutoTextNamaOA();')); ?>
                        <?php echo $form->dropDownList($model,'satuankekuatan',  LookupM::getItems('satuankekuatan'),
                                                        array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                        'empty'=>'-- Pilih --','style'=>'width:70px;',
                                                                'onchange'=>'AutoTextNamaOA();',
                                                                )); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model,'signa_obatalkes',
                                                    LookupM::getItems('signa_oa'),
                                                    array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --','style'=>'width:100px;')); ?>
            <?php echo $form->dropDownListRow($model,'sumberdana_id',
                                                    CHtml::listData($model->SumberDanaItems, 'sumberdana_id', 'sumberdana_nama'),
                                                    array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --','style'=>'width:100px;')); ?>
			<div class="control-group ">
				<?php echo CHtml::label('Jenis Kelompok <span class="required">*</span>', 'Jenis Kelompok', array('class'=>'control-label required')); ?>
                <div class="controls">
					<?php echo $form->dropDownList($model,'jnskelompok',
							LookupM::getItems('jnskelompok'),
							array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
							'empty'=>'-- Pilih --','style'=>'width:100px;')); ?>
				</div>
			</div>
            
			
            <div class="control-group ">
                <?php echo CHtml::label('Jenis Obat Alkes','jenisobatalkes_id', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php echo $form->hiddenField($model,'jenisobatalkes_id'); ?>
                        <?php $this->widget('MyJuiAutoComplete', array(
                                                        'name'=>'jenisobatalkes', 
                                                        'source'=>'js: function(request, response) {
                                                                $.ajax({
                                                                        url: "'.$this->createUrl('AutocompleteJenisObatAlkes').'",
                                                                        dataType: "json",
                                                                        data: {
                                                                                term: request.term,
                                                                        },
                                                                        success: function (data) {
                                                                                        response(data);
                                                                        }
                                                                })
                                                        }',
                                                        'options'=>array(
                                                                'showAnim'=>'fold',
                                                                'minLength' => 2,
                                                                'focus'=> 'js:function( event, ui ){
                                                                                                $(this).val(ui.item.label);
                                                                                                return false;
                                                                                        }',
                                                           'select'=>'js:function( event, ui ) {
                                                                        $(\'#SAObatAlkesM_jenisobatalkes_id\').val(ui.item.jenisobatalkes_id);
                                                                        $(\'#jenisobatalkes\').val(ui.item.jenisobatalkes_nama);
                                                                        return false;
                                                                }',
                                                        ),
                                                        'htmlOptions'=>array(
                                                                'readonly'=>false,
                                                                'placeholder'=>'Jenis Obat Alkes',
                                                                'size'=>13,
                                                                'class'=>'span2',
                                                                'onkeypress'=>"return $(this).focusNextInputField(event);",
                                                        ),
                                                        'tombolDialog'=>array('idDialog'=>'dialogjenisobatalkes'),
                                        )); ?>
                </div>
            </div>
            <?php echo $form->dropDownListRow($model,'obatalkes_golongan',  LookupM::getItemsUrutan('obatalkes_golongan'),
                                                    array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --','style'=>'width:150px;')); ?>
            <?php echo $form->dropDownListRow($model,'obatalkes_kategori',LookupM::getItems('obatalkes_kategori'),
                                                    array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --','style'=>'width:100px;')); ?>
            <?php echo $form->dropDownListRow($model,'formularium',  LookupM::getItems('formularium'),
                                                    array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --','style'=>'width:140px;')); ?>
            <?php echo $form->dropDownListRow($model,'generik_id',
                                                    CHtml::listData($model->generikItems, 'generik_id', 'generik_nama'),
                                                    array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --','style'=>'width:140px;')); ?>
<!--            <div class='control-group'>
                <?php // echo $form->labelEx($model,'tglkadaluarsa', array('class'=>'control-label')) ?>
                <div class="controls">
                        <?php // $minDate = (Yii::app()->user->getState('tglpemakai')) ? '' : 'd'; ?>
                        <?php // $this->widget('MyDateTimePicker',array(
//                                                        'model'=>$model,
//                                                        'attribute'=>'tglkadaluarsa',
//                                                        'mode'=>'date',
//                                                        'options'=> array(
//                                                                'dateFormat'=>Params::DATE_FORMAT,
//                                                                'minDate'=>$minDate,
//                                                        ),
//                                                        'htmlOptions'=>array('readonly'=>true,'class'=>'dtPicker3', 'onkeypress'=>"return $(this).focusNextInputField(event)"),
//                        )); ?>
                </div>
            </div>-->
            <?php // echo $form->textFieldRow($model,'noregister',array('placeholder'=>'No. Register Obat Alkes','class'=>'span3', 
//                                                    'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
            <?php // echo $form->textFieldRow($model,'nobatch',array('placeholder'=>'No. Batch Obat Alkes','class'=>'span3', 
//                                                    'onkeypress'=>"return $(this).focusNextInputField(event);"));?>
            <?php echo $form->dropDownListRow($model,'pabrik_id',
                                                    CHtml::listData($model->PabrikItems, 'pabrik_id', 'pabrik_nama'),
                                                    array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --')); ?>
            <?php echo $form->dropDownListRow($model,'discountinue',array('1'=>'Ya','0'=>'Tidak'),
                                                    array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --',)); ?>     
                                                    
            <?php echo $form->dropDownListRow($model,'ven',  LookupM::getItems('ven'),
                                                    array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --','style'=>'width:70px;')); ?>
            <?php echo $form->dropDownListRow($model,'atc_id',
                                                    CHtml::listData($model->AtcItems, 'atc_id', 'atc_nama'),
                                                    array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                    'empty'=>'-- Pilih --')); ?>
			<div class="control-group ">
				<?php echo $form->labelEx($model, 'obatalkes_aktif', array('class' => 'control-label')) ?>
				<div class="controls">
					<div class="radio inline">
						<div class="form-inline">
							<?php echo $form->checkBox($model,'obatalkes_aktif', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
						</div>
					</div>
					<?php echo $form->error($model, 'obatalkes_aktif'); ?>
				</div>
			</div>
        </td>
        <td>
            <fieldset class='box' id="fieldsetStok">
                <legend class="rim">Stok</legend>
                <div class="toggle">
					<div class="row-fluid">
						<div class="span6">
							<div class="control-group">
								<?php echo $form->labelEx($model,'minimalstok',array('class'=>'control-label'));?>
								<div class="controls">
										<?php echo $form->textField($model,'minimalstok',array('class'=>'span1 integer2', 
												'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
								</div>
							</div> 
							<div class="control-group">
								<?php echo $form->labelEx($model,'lokasigudang_id',array('class'=>'control-label'));?>
								<div class="controls">
										<?php echo $form->dropDownList($model,'lokasigudang_id',
												CHtml::listData($model->lokasiGudangItems, 'lokasigudang_id', 'lokasigudang_nama'),
												array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
												'empty'=>'-- Pilih --','style'=>'width:130px;')); ?>
								</div>
							</div> 
						</div> 
						<div class="span6">
							<?php echo $form->textFieldRow($model,'maksimalstok',array('class'=>'span2 integer2', 
												'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
						</div>
                    </div> 
                </div>
            </fieldset>
            <fieldset class='box' id="fieldsetHargaNetto">
                <legend class="rim">HPP</legend>
                <div class="toggle">
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group">
                                <?php echo CHtml::label('Harga Beli', 'hargabeli', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo CHtml::textField('hargabeli', '', array('class' => 'control-label integer2 hargabeli', 'onkeyup' => 'hitung_harganetto()')); ?>
                                    <?php echo CHtml::hiddenField('hargabelilama', ''); ?>
                                </div>
                            </div>

                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'satuanbesar_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList($model, 'satuanbesar_id', CHtml::listData($model->SatuanBesarItems, 'satuanbesar_id', 'satuanbesar_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                        'empty' => '-- Pilih --', 'style' => 'width:130px;'));
                                    ?>
                                </div>
                            </div> 

                            <div class="control-group" >
                                <?php echo CHtml::label('Isi Netto', 'kemasanbesar', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'kemasanbesar', array('class' => 'span1 integer2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_hargabeli()', 'onblur'=>'validasiKemasanBesar()',));
                                    ?>
                                </div>
                            </div> 

                            <div class="control-group" >
                                <?php echo $form->labelEx($model, 'satuankecil_id', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php
                                    echo $form->dropDownList($model, 'satuankecil_id', CHtml::listData($model->SatuanKecilItems, 'satuankecil_id', 'satuankecil_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'AutoTextNamaOA();',
                                        'empty' => '-- Pilih --', 'style' => 'width:130px;'));
                                    ?>
                                </div>
                            </div> 
                        </div>
                        <div class="span6">
                            <div class="control-group" >
                                <?php echo $form->labelEx($model, 'harganetto', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'harganetto', array('class' => 'span2 integer2 harganetto',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_hargabeli();'));
                                    ?>
                                    <?php echo CHtml::hiddenField('harganettolama', $model->harganetto); ?>
                                </div>
                            </div> 

                            <div class="control-group" >
                                <?php echo $form->labelEx($model, 'discount', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'discount', array('class' => 'span1 float2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungHpp();'));
                                    ?> %
                                </div>
                            </div> 

                            <div class="control-group" >
                                <?php echo $form->labelEx($model, 'ppn_persen', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'ppn_persen', array('class' => 'span1 float2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungHpp();'));
                                    ?> %
                                </div>
                            </div>  
                            <div class="control-group" >
                                <?php echo Chtml::label('HPP', 'hpp', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'hpp', array('class' => 'span1 integer2', 'onkeyup' => 'marginResep();',
                                        'onkeypress' => "return $(this).focusNextInputField(event);"));
                                    ?> <font size="1px">(Harga Netto - (Discount + Ppn))</font>
                                </div>
                            </div>  
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class='box' id="fieldsetHargaJualApotek">
                <legend class="rim">Harga Jual Apotek</legend>
                <div class="toggle">
                    <div class="row-fluid">
                        <div class="span6">
                            <div class="control-group" >
                                <?php echo $form->labelEx($model, 'margin', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'margin', array('class' => 'span1 float2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_hargajual()'));
                                    ?> %
                                </div>
                            </div> 
                            <div class="control-group" >
                                    <?php echo $form->labelEx($model, 'hargajual', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'hargajual', array('class' => 'span2 integer2 hargajual',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_margin()'));
                                    ?> <font size="1px">Rupiah</font>
                                    <?php echo CHtml::hiddenField('hargajuallama', $model->hargajual); ?>
                                </div>
                            </div> 
                            <div class="control-group" >
                                <?php echo $form->labelEx($model, 'marginnonresep', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'marginnonresep', array('class' => 'span1 float2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_hjanonresep()'));
                                    ?> %
                                </div>
                            </div> 
                            <div class="control-group" >
                                <?php echo $form->labelEx($model, 'hjanonresep', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'hjanonresep', array('class' => 'span2 integer2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_margin_hjanonresep()'));
                                    ?> <font size="1px">Rupiah</font>
                                </div>
                            </div> 
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'marginresep', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'marginresep', array('class' => 'span1 float2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_hjaresep()'));
                                    ?> %
                                </div>
                            </div> 
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'jasadokter', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'jasadokter', array('class' => 'span2 integer2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_hjaresep()'));
                                    ?> <font size="1px">Rupiah</font>
                                </div>
                            </div> 
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'hjaresep', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'hjaresep', array('class' => 'span2 integer2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitung_margin_hjaresep()'));
                                    ?> <font size="1px">Rupiah</font>
                                </div>
                            </div> 
                        </div>
                        <div class="span6">
                            <div class="control-group" >
                                <?php echo $form->labelEx($model, 'hargamaksimum', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'hargamaksimum', array('class' => 'span2 integer2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                                    ?> <font size="1px">Rupiah</font>
                                </div>
                            </div> 
                            <div class="control-group">
                                    <?php echo $form->labelEx($model, 'hargaminimum', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'hargaminimum', array('class' => 'span2 integer2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                                    ?> <font size="1px">Rupiah</font>
                                </div>
                            </div> 
                            <div class="control-group">
                                <?php echo $form->labelEx($model, 'hargaaverage', array('class' => 'control-label')); ?>
                                <div class="controls">
                                    <?php echo $form->textField($model, 'hargaaverage', array('class' => 'span2 integer2',
                                        'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true));
                                    ?> <font size="1px">Rupiah</font>
                                </div>
                            </div> 
                        </div>
                    </div>
                </div>
            </fieldset>
        </td>
    </tr>
</table>
<table class='table-condensed' width='100%'>
    <tr>
        <td>
            <div class="control-group">
                <?php echo Chtml::label('Therapi Obat', 'Therapi Obat', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    if ($model->isNewRecord) {
                        $this->widget('application.extensions.emultiselect.EMultiSelect', array('sortable' => true, 'searchable' => true)
                        );
                        echo CHtml::dropDownList(
                                'therapiobat_id[]', '', CHtml::listData(SATherapiobatM::model()->findAll('therapiobat_aktif=TRUE ORDER BY therapiobat_nama'), 'therapiobat_id', 'therapiobat_nama'), array('multiple' => 'multiple', 'key' => 'therapiobat_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                        );
                    } else {
                        $arrTherapiObat = array();
                        foreach ($modTherapiObat as $dataTherapiObat) {
                            $arrTherapiObat[] = $dataTherapiObat['therapiobat_id'];
                        }
                        $this->widget('application.extensions.emultiselect.EMultiSelect', array('sortable' => true, 'searchable' => true)
                        );
                        echo CHtml::dropDownList(
                                'therapiobat_id[]', $arrTherapiObat, CHtml::listData(SATherapiobatM::model()->findAll('therapiobat_aktif=TRUE ORDER BY therapiobat_nama'), 'therapiobat_id', 'therapiobat_nama'), array('multiple' => 'multiple', 'key' => 'therapiobat_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                        );
                    }
                    ?>
                </div>
            </div>      
        </td>
        <td>
            <div class="control-group">
                <?php echo Chtml::label('Supplier', 'Supplier', array('class' => 'control-label')); ?>
                <div class="controls">
                    <?php
                    if ($model->isNewRecord) {
                        $this->widget('application.extensions.emultiselect.EMultiSelect', array('sortable' => true, 'searchable' => true)
                        );
                        echo CHtml::dropDownList(
                                'supplier_id[]', '', CHtml::listData(SASupplierM::model()->findAll('supplier_aktif=TRUE ORDER BY supplier_nama'), 'supplier_id', 'supplier_nama'), array('multiple' => 'multiple', 'key' => 'supplier_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                        );
                    } else {
                        $arrSuplier = array();
                        foreach ($modObatSupplier as $dataObatSupplier) {
                            $arrSuplier[] = $dataObatSupplier['supplier_id'];
                        }
                        $this->widget('application.extensions.emultiselect.EMultiSelect', array('sortable' => true, 'searchable' => true)
                        );
                        echo CHtml::dropDownList(
                                'supplier_id[]', $arrSuplier, CHtml::listData(SASupplierM::model()->findAll('supplier_aktif=TRUE ORDER BY supplier_nama'), 'supplier_id', 'supplier_nama'), array('multiple' => 'multiple', 'key' => 'supplier_id', 'class' => 'multiselect', 'style' => 'width:500px;height:150px')
                        );
                    }
                    ?>
                </div>
            </div>      
        </td> 
    </tr>
</table>
<?php echo CHtml::hiddenField('alasanperubahan_hidden',''); ?>
<?php echo CHtml::hiddenField('disetujuioleh_hidden',''); ?>
<?php echo $this->renderPartial($this->path_view.'_ObatAlkesDetail', array('model'=>$model,'modObatAlkesDetail'=>$modObatAlkesDetail, 'form'=>$form)); ?>
<div class="form-actions">
    <?php 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'setVerifikasi();', 'onkeypress'=>'setVerifikasi();'));
    ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                                    $this->createUrl('admin'), 
                                    array('class'=>'btn btn-danger',
                                     'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));  ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Obat Alkes', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?>
    <?php
            $content = $this->renderPartial($this->path_view.'tips.tipsCreateUpdate',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    ?>
</div>

<?php $this->endWidget(); ?>
		
<!-- =============================== beginWidget Jenis Obat Alkes ============================= -->        
<?php
   $this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
	'id'=>'dialogjenisobatalkes',
	'options'=>array(
		'title'=>'Pencarian Jenis Obat Alkes',
		'autoOpen'=>false,
		'modal'=>true,
		'width'=>900,
		'height'=>400,
		'resizable'=>false,
		),
	));
   
$modJenisObat = new JenisobatalkesM('search');
$modJenisObat->unsetAttributes();
if(isset($_GET['JenisobatalkesM'])) {
	$modJenisObat->attributes = $_GET['JenisobatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'jenisobatalkes-grid',
	'dataProvider'=>$modJenisObat->search(),
	'filter'=>$modJenisObat,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		array(
			'header'=>'Pilih',
			'type'=>'raw',
			'value'=>'CHtml::Link("<i class=\"icon-check\"></i>","#",
				array(
					"class"=>"btn-small",
					"id" => "selectjenisobatalkes",
					"onClick" => "\$(\"#SAObatalkesM_jenisobatalkes_id\").val($data->jenisobatalkes_id);
								  \$(\"#jenisobatalkes\").val(\"$data->jenisobatalkes_nama\");
								  \$(\"#dialogjenisobatalkes\").dialog(\"close\");"
				 )
			 )',
		),
		'jenisobatalkes_nama',
		'jenisobatalkes_namalain',
	),
		'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>
 <?php
$urlgetKodeObatAlkes=$this->createUrl('GetKodeObatAlkes');
$kodeObat = CHtml::activeId($model,'obatalkes_kode');
					   
$js = <<< JS
function generateKode(obj)
{
//   Generate kode obat di nonaktifkan (Input Manual)
//   namaObat =obj.value;
//   if(namaObat!=''){//Jika nama Obat Tidak Kosong  
//       $.post("${urlgetKodeObatAlkes}",{namaObat: namaObat},
//            function(data){
//                $('#${kodeObat}').val(data.kodeObatBaru);      
//        },"json");
//   }else{//Jika Nama Obat Kosong
//                $('#${kodeObat}').val('');      
//   } 
}

JS;
Yii::app()->clientScript->registerScript('sfdasdasda',$js,CClientScript::POS_HEAD);

?>
<script type="text/javascript">
<?php $urlGetResepDokter =  $this->createUrl('getPersenDokter'); ?>


function parseUnformat(v)
{
    return parseFloat(unformatNumber(v));
}

function hitungHpp()
{
	var harganetto = parseUnformat($('#<?php echo CHtml::activeId($model,"harganetto"); ?>').val());
	var discount = parseUnformat($('#<?php echo CHtml::activeId($model,"discount"); ?>').val());
	var ppn = parseUnformat($('#<?php echo CHtml::activeId($model,"ppn_persen"); ?>').val());
	
	jumlahDiskon = (harganetto - (harganetto * (discount/100)))
	jumlahPpn = (jumlahDiskon * (ppn / 100));
	hpp = jumlahDiskon + jumlahPpn;
	
	$('#<?php echo CHtml::activeId($model,"hpp"); ?>').val(formatNumber(hpp));
        hitung_hargajual();
        hitung_hjanonresep();
        hitung_hjaresep();
}

function cekInput()
{
	$('.integer2').each(function(){this.value = unformatNumber(this.value)});
	$('.number').each(function(){this.value = unformatNumber(this.value)});
	return true;
}

function hitung_hargabeli(){
	var harganetto  = parseUnformat($('#<?php echo CHtml::activeId($model,"harganetto"); ?>').val());
	var isinetto = parseUnformat($('#<?php echo CHtml::activeId($model,"kemasanbesar"); ?>').val());
	total_hargabeli = harganetto * isinetto;
	$('#hargabeli').val(formatNumber(total_hargabeli));
	hitungHpp();
}

function hitung_harganetto(){
	var hargabeli = parseUnformat($('#hargabeli').val());
	var isinetto  = parseUnformat($('#<?php echo CHtml::activeId($model,"kemasanbesar"); ?>').val());
	total_harganetto = hargabeli / isinetto;
	$('#<?php echo CHtml::activeId($model,"harganetto"); ?>').val(formatNumber(total_harganetto));
	hitungHpp();
}

function hitung_margin(){
	hargajual = parseUnformat($('#<?php echo CHtml::activeId($model,"hargajual"); ?>').val());
	hpp = parseUnformat($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
	margin = ((hargajual - hpp)/hpp)*100;
	$('#<?php echo CHtml::activeId($model,"margin"); ?>').val(formatFloat(margin));
}

function hitung_hargajual(){
	margin = parseUnformat($('#<?php echo CHtml::activeId($model,"margin"); ?>').val());
	hpp = parseUnformat($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
	hargajual = hpp + ((hpp/100)*margin);
	$('#<?php echo CHtml::activeId($model,"hargajual"); ?>').val(formatNumber(hargajual));
}

function hitung_margin_hjanonresep(){
	hjanonresep = parseUnformat($('#<?php echo CHtml::activeId($model,"hjanonresep"); ?>').val());
	hpp = parseUnformat($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
	marginnonresep = ((hjanonresep - hpp)/hpp)*100;
	$('#<?php echo CHtml::activeId($model,"marginnonresep"); ?>').val(formatFloat(marginnonresep));
}

function hitung_hjanonresep(){
	marginnonresep = parseUnformat($('#<?php echo CHtml::activeId($model,"marginnonresep"); ?>').val());
	hpp = parseUnformat($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
	hjanonresep = hpp + ((hpp/100)*marginnonresep);
	$('#<?php echo CHtml::activeId($model,"hjanonresep"); ?>').val(formatNumber(hjanonresep));
}

function hitung_margin_hjaresep(){
	hjaresep = parseUnformat($('#<?php echo CHtml::activeId($model,"hjaresep"); ?>').val());
	jasadokter = parseUnformat($('#<?php echo CHtml::activeId($model,"jasadokter"); ?>').val());
	hpp = parseUnformat($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
	marginresep = (((hjaresep - hpp - jasadokter)/hpp)*100);
	$('#<?php echo CHtml::activeId($model,"marginresep"); ?>').val(formatFloat(marginresep));
}

function hitung_hjaresep(){
	marginresep = parseUnformat($('#<?php echo CHtml::activeId($model,"marginresep"); ?>').val());
	jasadokter = parseUnformat($('#<?php echo CHtml::activeId($model,"jasadokter"); ?>').val());
	hpp = parseUnformat($('#<?php echo CHtml::activeId($model,"hpp"); ?>').val());
	hjaresep = hpp + ((hpp/100)*marginresep) + jasadokter;
	$('#<?php echo CHtml::activeId($model,"hjaresep"); ?>').val(formatNumber(hjaresep));
}
/**
* tombol batal pada dialogbox
* @param {type} dialog_id
* @returns {undefined} 
*/
function batalDialog(dialog_id){
   if(confirm("Apakah anda yakin akan membatalkan ini ?")) 
       $('#'+dialog_id).dialog("close");
}

/**
 * menampilkan form verifikasi
 * @returns {undefined}
 */
function setVerifikasi(){
	<?php if(isset($_GET['id'])){?>
	hargabeli = unformatNumber($('.hargabeli').val());
	hargabelilama = unformatNumber($('#hargabelilama').val()); 
	harganetto = unformatNumber($('.harganetto').val());
	harganettolama = unformatNumber($('#harganettolama').val());
	hargajual = unformatNumber($('.hargajual').val());
	hargajuallama =  unformatNumber($('#hargajuallama').val());

    if(requiredCheck($("form"))){
    	if(hargabeli!=hargabelilama||harganetto!=harganettolama||hargajual!=hargajuallama){
    		$('#dialog-verifikasi').dialog("open");
	        $.ajax({
	           type:'POST',
	           url:'<?php echo $this->createUrl('verifikasi'); ?>',
	           data: $("form").serialize(),
	           dataType: "json",
	           success:function(data){
	                $('#dialog-verifikasi > .dialog-content').html(data.content);
	           },
	            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown); }
	        });
	        //untuk verifikasi hilangkan srbac loading
	        $(".animation-loading").removeClass("animation-loading");
	        $("form").find('.float2').each(function(){
	            $(this).val(formatFloat($(this).val()));
	        });
	        $("form").find('.integer2').each(function(){
	            $(this).val(formatInteger($(this).val()));
	        });
    	}else{
    		$("#gfobat-alkes-m-form").submit();
    	}
    }
    <?php }else{ ?>
    	$("#gfobat-alkes-m-form").submit();
    <?php } ?>
    return false;
}

function AutoTextNamaOA()
{
	var nama = $('#<?php echo CHtml::activeId($model,"obatalkes_nama"); ?>').val();
	var kekuatan = $('#<?php echo CHtml::activeId($model,"kekuatan"); ?>').val();
	var satuan = $('#<?php echo CHtml::activeId($model,"satuankekuatan"); ?>').val();
	var satuankecil = $('#<?php echo CHtml::activeId($model,"satuankecil_id"); ?> option:selected').html();
	
	if(nama == ''){
		var nama = '';
	}
	if(kekuatan == ''){
		var kekuatan = '';
	}
	if(satuan == ''){
		var satuan = '';
	}
	if((satuankecil == '') || (satuankecil == '-- Pilih --')){
		var satuankecil = '';
	}
	document.getElementById('SAObatalkesM_obatalkes_namalain').value = (nama+' '+kekuatan+' '+satuan+' '+satuankecil).toUpperCase();
}

function validasiKemasanBesar() {
	var isinetto  = parseUnformat($('#<?php echo CHtml::activeId($model,"kemasanbesar"); ?>').val());
	if (isinetto <= 0) {
		myAlert("Isi netto harus lebih dari 0");
		$('#<?php echo CHtml::activeId($model,"kemasanbesar"); ?>').val(1).keyup();
	}
}

$(document).ready(function(){
	hitung_hargabeli();
	$('#hargabelilama').val(unformatNumber($('.hargabeli').val())); 
	<?php if((isset($_GET['id'])) && empty($model->obatalkes_namalain)){ ?>
		var namalain = '<?php echo $model->obatalkes_nama; ?>';
		$('#<?php echo CHtml::activeId($model,"obatalkes_namalain"); ?>').val(namalain);
	<?php } ?>
});

</script>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialog-verifikasi',
    'options'=>array(
        'title'=>'Verifikasi Perubahan Obat',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>960,
        'minHeight'=>480,
        'resizable'=>false,
    ),
));

echo '<div class="dialog-content"></div>';
?>
<div class="row-fluid">
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Lanjutkan',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'disableOnSubmit(this); $("#gfobat-alkes-m-form").submit();')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Cancel',array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'button', 'onclick'=>'batalDialog("dialog-verifikasi");')); ?>
    </div>
</div>
<?php $this->endWidget(); ?>
