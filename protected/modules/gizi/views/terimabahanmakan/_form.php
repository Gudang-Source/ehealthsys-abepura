<div class="white-container">
    <legend class="rim2">Transaksi Penerimaan <b>Bahan Makanan</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
    <?php
    $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'gzterimabahanmakan-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        'focus' => '#',
            ));
    ?>
    <?php if(!empty($_GET['id'])){ ?>
    <div class="alert alert-block alert-success">
        <a class="close" data-dismiss="alert"> x</a>
        Data Berhasil Disimpan
    </div>
    <?php } ?>
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>
    <?php if (count($modPengajuan) > 0) { ?>

        
    <table width="100%">
        <tr>
            <td>
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modPengajuan, 'nopengajuan', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeTextField($modPengajuan, 'nopengajuan', array('readonly'=>true))
                        ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modPengajuan, 'tglpengajuanbahan', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeTextField($modPengajuan, 'tglpengajuanbahan', array('readonly'=>true))
                        ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group ">
                    <?php echo CHtml::activeLabel($modPengajuan, 'idpegawai_mengajukan', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeTextField($modPengajuan, 'idpegawai_mengajukan', array('readonly'=>true, 'value'=>  PegawaiM::model()->findByPK($modPengajuan->idpegawai_mengajukan)->nama_pegawai))
                        ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <hr />
    <?php } ?>
    <table width="100%">
        <tr>
            <td>
                <?php //echo $form->textFieldRow($model,'pengajuanbahanmkn_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
                <?php //echo $form->textFieldRow($model,'ruangan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'supplier_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model, 'supplier_id', CHtml::listData($model->Supplier, 'supplier_id', 'supplier_nama'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'sumberdanabhn',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
                <?php echo $form->dropDownListRow($model, 'sumberdanabhn', LookupM::getItems('sumberdanabahan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php echo $form->textFieldRow($model, 'nopenerimaanbahan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php //echo $form->textFieldRow($model,'tglterimabahan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglterimabahan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglterimabahan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tglterimabahan'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'nosuratjalan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
                <?php //echo $form->textFieldRow($model,'tglsurjalan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglsurjalan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglsurjalan',
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tglsurjalan'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'nofaktur', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
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
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'tglfaktur'); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'tglfaktur',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);"));  ?>
                <?php //echo $form->textFieldRow($model,'totalharganetto',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'totaldiscount', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo Chtml::textField('discountpersen', '', array('class' => 'span1 integer', 'onkeyup' => 'hitungTotalDiscount();', 'onfocus' => 'hitungTotalDiscount();','maxlength' => 3)); ?> % = 
                        <?php echo $form->textField($model, 'totaldiscount', array('readonly' => true, 'class' => 'span2 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->error($model, 'totaldiscount'); ?>
                    </div>
                </div>
                <?php echo $form->textFieldRow($model, 'biayapengiriman', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model, 'biayatransportasi', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model, 'biayapajak', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textAreaRow($model, 'keterangan_terima_bahan', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200)); ?>
            </td>
        </tr>
    </table>
    <div class="block-tabel">
        <h6>Tabel Penerimaan <b>Bahan Makanan</b></h6>
        <!--<legend class="rim">Detail Bahan Makanan</legend>-->
        <?php if (count($modDetailPengajuan) < 1) { ?>
            <div class="control-group ">
                <label class="control-label" for="namaObat">Nama Bahan Makanan <font color="red"> * </font></label>
                <div class="controls">
                    <?php echo CHtml::hiddenField('idBahan'); ?>
                    <!--                <div class="input-append" style='display:inline'>-->
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'name' => 'namaBahan',
                        'source' => 'js: function(request, response) {
                                                           $.ajax({
                                                               url: "' . Yii::app()->createUrl('ActionAutoComplete/BahanMakanan') . '",
                                                               dataType: "json",
                                                               data: {
                                                                   term: request.term,
                                                                   idSumberDana: $("#idSumberDana").val(),
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
                                                        $("#idBahan").val(ui.item.bahanmakanan_id); 
                                                        $("#qty").val(1); 
                                                        $("#satuanbahan").val(ui.item.satuanbahan);
                                                        return false;
                                                    }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                        ),
                        'tombolDialog' => array('idDialog' => 'dialogBahanMakanan'),
                    ));
                    ?>
                </div>
            </div>
            <div class="control-group ">
                <label class="control-label" for="namaObat">Jumlah</label>
                <div class="controls">
                    <?php echo CHtml::textField('qty', '', array('class' => 'span1 integer', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
                    <?php echo CHtml::dropDownList('satuanbahan', '', LookupM::getItems('satuanbahanmakanan'), array('empty' => '-- Pilih --', 'class' => 'span1')); ?>
                    <?php echo CHtml::textField('ukuran', '', array('class' => 'span2', 'placeholder' => 'Ukuran')); ?>
                    <?php echo CHtml::textField('merk', '', array('class' => 'span2', 'placeholder' => 'Merk')); ?>
                    <?php
                    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'inputBahanMakanan();return false;',
                        'class' => 'btn btn-primary integer',
                        'onkeypress' => "inputBahanMakanan();return $(this).focusNextInputField(event)",
                        'rel' => "tooltip",
                        'title' => "Klik untuk menambahkan Bahan Makanan",));
                    ?>
                </div>
            </div>
        <?php } ?>
        <table class="table table-striped table-condensed" id="tableBahanMakanan">
            <thead>
                <tr>
                    <th><input type="checkbox" id="checkListUtama" name="checkListUtama" value="1" checked="checked" onclick="checkAll('cekList',this);hitungSemua();"></th>
                    <th>No.Urut</th>
                    <th>Golongan</th>
                    <th>Jenis</th>
                    <th>Kelompok</th>
                    <th>Nama</th>
                    <th>Jumlah Persediaan</th>
                    <th>Satuan</th>
                    <th>Harga Netto</th>
                    <!--<th>Harga Jual</th>-->
                    <th>Diskon</th>
                    <th>Tanggal Kadaluarsa</th>
                    <th>Jumlah</th>
                    <th>Sub Total</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count($modDetailPengajuan) > 0) {
                    foreach ($modDetailPengajuan as $i => $baris) {
                        $modDetail = new TerimabahandetailT();
                        $modDetail['satuanbahan'] = $baris->satuanbahan;
                        $subNetto = $baris->qty_pengajuan * $baris->harganettobhn;
                        echo '<tr>
                                <td>'
                        . CHtml::checkBox('checkList[' . $i . ']', true, array('class' => 'cekList', 'onclick' => 'hitungSemua()'))
                        . CHtml::activeHiddenField($modDetail, 'golbahanmakanan_id[]', array('value' => $baris->golbahanmakanan_id))
                        . CHtml::activeHiddenField($modDetail, 'bahanmakanan_id[]', array('value' => $baris->bahanmakanan_id))
                        . CHtml::activeHiddenField($modDetail, 'harganettobhn[]', array('value' => $baris->harganettobhn))
                        . CHtml::activeHiddenField($modDetail, 'jmlkemasan[]', array('value' => $baris->jmlkemasan))
                        . CHtml::activeHiddenField($modDetail, 'hargajualbhn[]', array('value' => $baris->bahanmakanan->hargajualbahan))
                        . CHtml::activeHiddenField($modDetail, 'ukuran_bahanterima[]', array('value' => $baris->ukuranbahan))
                        . CHtml::activeHiddenField($modDetail, 'pengajuanbahandetail_id[]', array('value' => $baris->pengajuanbahandetail_id))
                        . CHtml::activeHiddenField($modDetail, 'merk_bahanterima[]', array('value' => $baris->merkbahan))
                        . '</td>
                                <td>' . CHtml::textField('noUrut[]', $i + 1, array('class' => 'noUrut span1', 'readonly' => true)) . '</td>
                                <td>' . $baris->golbahanmakanan->golbahanmakanan_nama . '</td>
                                <td>' . $baris->bahanmakanan->jenisbahanmakanan . '</td>
                                <td>' . $baris->bahanmakanan->kelbahanmakanan . '</td>
                                <td>' . $baris->bahanmakanan->namabahanmakanan . '</td>
                                <td>' . MyFormatter::formatNumberForUser($baris->bahanmakanan->jmlpersediaan) . '</td>
                                <td>' . CHtml::activeDropDownList($modDetail, 'satuanbahan[]', LookupM::getItems('satuanbahanmakanan'), array('options' => array('' . $baris->satuanbahan . '' => array('selected' => 'selected')), 'class' => 'span1 satuanbahan')) . '</td>
                                <td>' . $baris->harganettobhn . '</td>
                                <td>' . $baris->bahanmakanan->hargajualbahan . '</td>
                                <td>' . CHtml::activeTextField($modDetail, 'discount[]', array('value' => $baris->bahanmakanan->discount, 'class' => 'discount span1 integer', 'onkeyup' => 'hitungTotalDiscount();')) . '</td>
                                <td>' . $baris->bahanmakanan->tglkadaluarsabahan . '</td>

                                <td>' . CHtml::activeTextField($modDetail, 'qty_terima[]', array('value' => $baris->qty_pengajuan, 'class' => 'span1 integer qty', 'onkeyup' => 'hitung(this);')) . '</td>
                                <td>' . CHtml::TextField('subNetto[]', $subNetto, array('value' => $subNetto, 'class' => 'subNetto span2', 'readonly' => true)) . '</td>
                                <td>' . CHtml::link("<span class='icon-form-silang'>&nbsp;</span>",'',array('href'=>'','onclick'=>'hapus(this);return false;','style'=>'text-decoration:none;', 'class'=>'cancel')).'</td>
                                </tr>';
                    }
                }
                ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan='12'><div class='pull-right'>Total Harga Netto</div></td>
                    <td><?php echo $form->textField($model, 'totalharganetto', array('readonly' => true, 'class' => 'span2 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?></td>
                    <td></td>
                </tr>
            </tfoot>
        </table>
    </div>
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
	 <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),array('class'=>'btn btn-danger', 'type'=>'reset')); ?>
	<?php 
        $content = $this->renderPartial('../tips/transaksi',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>	
    </div>

    <?php $this->endWidget(); ?>
</div>
    <?php
    $totalHarga = CHtml::activeId($model, 'totalharganetto');
    $urlBahan = $this->createUrl('getBahanMakananDariPenerimaan');
    $js = <<<JS
    function inputBahanMakanan(){
		unformatNumberSemua();
        var id = $('#idBahan').val();
        var qty= $('#qty').val();
        var ukuran = $('#ukuran').val();
        var merk = $('#merk').val();
        var satuanbahan = $('#satuanbahan').val();
        if (jQuery.isNumeric(id)){
            $.post('$urlBahan',{id:id, qty:qty,ukuran:ukuran,merk:merk, satuanbahan:satuanbahan},function(data){
                $('#tableBahanMakanan tbody').append(data);		
		renameInputRowBahanMakanan('tableBahanMakanan');
                hitungSemua();
                hitungTotalDiscount();	    	
                $("#tableBahanMakanan tbody tr:last .integer").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
                $("#tableBahanMakanan tbody tr:last .satuanbahan").val(satuanbahan);		
				formatNumberSemua();
            },'json');
        }
        else{
            myAlert('Isi Data dengan Benar');
        }
    }
    
    function hitungSemua(){
		unformatNumberSemua();
        value = 0;
        $('.noUrut').each(function(){
            $(this).parents('tr').find('#checkList').attr('name','checkList['+(noUrut-1)+']');
//            $(this).val(noUrut);
//            noUrut++;
            if ($(this).parents('tr').find('#checkList').is(':checked')){
                val = parseFloat($(this).parents('tr').find('.subNetto').val());
                value += val;
            }
        });
        hitungTotalDiscount();
        $('#${totalHarga}').val(value);
		formatNumberSemua();
    }
	   	
    function hitung(obj){
		unformatNumberSemua();
        var netto = $(obj).parents('tr').find('input[name$="[harganettobahan]"]').val()
        var jml = $(obj).parents('tr').find('input[name$="[qty_terima]"]').val()
		$(obj).parents('tr').find('.subNetto').val(netto*jml);
		hitungSemua();
        hitungTotalDiscount();
		formatNumberSemua();
    }
    
    function hapus(obj) {
        $(obj).parents('tr').remove();
        hitungSemua();
    }
    
    function hitungTotal(obj){
		unformatNumberSemua();
        var netto = $('#TerimabahandetailT_harganettobhn').val();
        var jml = $(obj).val();
        $(obj).parents('tr').find('.subNetto').val(netto*jml);
        hitungSemua();
        hitungTotalDiscount();
		formatNumberSemua();
    }
    
    function hitungTotalDiscount(){
		unformatNumberSemua();
        var discountPersen = $('#discountpersen').val();
        var totaldiscount = 0;
            if (jQuery.isNumeric(discountPersen)){
                $('.discount').each(function(){
                    if ($(this).parents('tr').find('.cekList').is(':checked')){
                        var subnetto = $(this).parents('tr').find('.subNetto').val();
                        discount = subnetto*discountPersen/100;
                        $(this).val(discount);
                        totaldiscount+=discount;
                    }
                });
            }
            else{
                $('.discount').each(function(){
                    var discount = parseFloat($(this).val());
                    if ($(this).parents('tr').find('#checkList').is(':checked')){
                        totaldiscount+=discount;
                    }
                });      
            }
		formatNumberSemua();
        $('#GZTerimabahanmakan_totaldiscount').val(totaldiscount);
    }
    
JS;
    Yii::app()->clientScript->registerScript('fungsi', $js, CClientScript::POS_HEAD);
    ?>

    <?php
//========= Dialog buat cari Bahan Makanan =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogBahanMakanan',
        'options' => array(
            'title' => 'Bahan Makanan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 750,
            'height' => 600,
            'resizable' => false,
        ),
    ));

    $modBahanMakanan = new GZBahanMakananM('search');
    $modBahanMakanan->unsetAttributes();
    if (isset($_GET['GZBahanMakananM'])) {
        $modBahanMakanan->attributes = $_GET['GZBahanMakananM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'gzbahanmakanan-m-grid',
        'dataProvider' => $modBahanMakanan->search(),
        'filter' => $modBahanMakanan,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "$(\'#idBahan\').val($data->bahanmakanan_id);
                                    $(\'#namaBahan\').val(\'$data->jenisbahanmakanan - $data->namabahanmakanan - $data->jmlpersediaan\');
                                    $(\'#satuanbahan\').val(\'$data->satuanbahan\');
                                    $(\'#qty\').val(1);
                                    $(\'#dialogBahanMakanan\').dialog(\'close\');return false;"))',
            ),
            ////'bahanmakanan_id',
//        array(
//                        'name'=>'bahanmakanan_id',
//                        'value'=>'$data->bahanmakanan_id',
//                        'filter'=>false,
//                ),
            array(
                'name' => 'golbahanmakanan_id',
                'filter' => CHtml::listData(GolbahanmakananM::model()->findAll('golbahanmakanan_aktif = true'), 'golbahanmakanan_id', 'golbahanmakanan_nama'),
                'value' => '$data->golbahanmakanan->golbahanmakanan_nama',
            ),
//        'golbahanmakanan.golbahanmakanan_nama',
//        'sumberdanabhn',
            'jenisbahanmakanan',
            'kelbahanmakanan',
            'namabahanmakanan',
            'jmlpersediaan',
            'satuanbahan',
            'harganettobahan',
            'hargajualbahan',
            'discount',
            'tglkadaluarsabahan',
//        'jmlminimal',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    ));


    $this->endWidget();
    ?>
    <?php
    $this->widget('application.extensions.moneymask.MMask', array(
        'element' => '.numbersOnly',
        'config' => array(
            'defaultZero' => true,
            'allowZero' => true,
            'decimal' => ',',
            'thousands' => '',
            'precision' => 0,
        )
    ));
    ?>

    <?php Yii::app()->clientScript->registerScript('submit', '
    $("form").submit(function(){
        supplier = $("#'.CHtml::activeId($model, 'supplier_id').'").val();
        jumlah = 0;
        if (!jQuery.isNumeric(supplier)){
            myAlert("'.CHtml::encode($model->getAttributeLabel('supplier_id')).' harus diisi !");
            return false;
        }
        $(".cekList").each(function(){
            if ($(this).is(":checked")){
                jumlah++;
            }
        });
        
        if (jumlah < 1){
            myAlert("Pilih Nama Bahan Makanan yang akan diajukan !");
            return false;
        }
    });
', CClientScript::POS_READY); ?>
    
<script type="text/javascript">
    function renameInputRowBahanMakanan(obj_table){
    var row = 0;
    $('#'+obj_table).find("tbody > tr").each(function(){
	$(this).find("#noUrut").val(row+1);
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
</script>