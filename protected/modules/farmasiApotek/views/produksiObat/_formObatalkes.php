<table width="100%">
    <tr>
        <td width="70%">
            <fieldset class="box" id="obatAlkes">
                <legend class="rim">Data Obat</legend>
                <div class="row-fluid">
                    <div class="span6">
                        <?php
                        echo $form->textFieldRow($modObatalkesM, 'obatalkes_kode', array('class' => 'span2',
                            'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                        ));
                        ?>

                        <?php
                        echo $form->textFieldRow($modObatalkesM, 'obatalkes_nama', array('class' => 'span3',
                            'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 200,
                            'onkeyup' => 'generateKode(this)'));
                        ?>
                        <?php /*
                          <?php
                          echo $form->dropDownListRow($modObatalkesM,'obatalkes_kadarobat',LookupM::getItems('obatalkes_kadarobat'),
                          array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                          'empty'=>'-- Pilih --','style'=>'width:100px;')); ?>

                          <?php echo CHtml::label('Kekuatan', 'kekuatan', array('class'=>'control-label')); ?>
                          <div class="controls">
                          <?php echo $form->textField($modObatalkesM,'kekuatan',array('class'=>'span2 numbersOnly',
                          'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                          <?php echo $form->dropDownList($modObatalkesM,'satuankekuatan',  LookupM::getItems('satuankekuatan'),
                          array('class'=>'span2', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                          'empty'=>'-- Pilih --','style'=>'width:70px;')); ?>
                          </div>
                         */ ?>	    
                        <div class="control-group">
                                <div class="control-label">
                                        <?php echo CHtml::label("Asal Barang<font color='red'> *</font>", 'sumberdana_id', array('class' => 'control-label')); ?>
                                </div>
                                <div class="controls">
                                        <?php
                                        echo $form->dropDownList($modObatalkesM, 'sumberdana_id', CHtml::listData($modObatalkesM->SumberDanaItems, 'sumberdana_id', 'sumberdana_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                                'empty' => '-- Pilih --', 'style' => 'width:100px;'));
                                        ?>
                                </div><br/>
                        </div>
                        <div class="control-group">
                                <div class="control-label">
                                        <?php echo CHtml::label('Jenis Obat Alkes', 'jenisobatalkes_id'); ?>
                                        <?php echo $form->hiddenField($modObatalkesM, 'jenisobatalkes_id'); ?>
                                </div>
                                <div class="controls">
                                        <?php
                                        $this->widget('MyJuiAutoComplete', array(
                                                'name' => 'jenisobatalkes',
                                                'source' => 'js: function(request, response) {
                                                                          $.ajax({
                                                                                  url: "' . $this->createUrl('AutoCompleteJenisObat') . '",
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
                                                        'focus' => 'js:function( event, ui )
                                                                                          {
                                                                                           $(this).val(ui.item.label);
                                                                                           return false;
                                                                                           }',
                                                        'select' => 'js:function( event, ui ) {
                                                                                          $(\'#FAObatalkesM_jenisobatalkes_id\').val(ui.item.jenisobatalkes_id);
                                                                                          $(\'#jenisobatalkes\').val(ui.item.jenisobatalkes_nama);
                                                                                           return false;
                                                                                   }',
                                                ),
                                                'htmlOptions' => array(
                                                        'readonly' => false,
                                                        'placeholder' => 'Jenis Obat Alkes',
                                                        'size' => 13,
                                                        'class' => 'span2',
                                                        'onkeypress' => "return $(this).focusNextInputField(event);",
                                                ),
                                                'tombolDialog' => array('idDialog' => 'dialogjenisobatalkes'),
                                        ));
                                        ?>
                                </div>
                        </div>
                    </div>
                    <div class="span6">
                        <?php
                        echo $form->dropDownListRow($modObatalkesM, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'empty' => '-- Pilih --', 'style' => 'width:150px;'));
                        ?>

                        <?php
                        echo $form->dropDownListRow($modObatalkesM, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'empty' => '-- Pilih --', 'style' => 'width:100px;'));
                        ?>
                        <div class="control-group">
                                <?php echo CHtml::label('Jenis Kelompok <span class="required">*</span>','',array('class'=>'control-label required')); ?>
                                <div class="controls">
                                        <?php 
                                                echo $form->dropDownList($modObatalkesM,'jnskelompok',
                                                LookupM::getItems('jnskelompok'),
                                                array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",
                                                'empty'=>'-- Pilih --','style'=>'width:100px;')); 
                                        ?>
                                </div>
                        </div>
                    </div>
                </div>
            </fieldset>

            <fieldset class="box" id="fieldsetStok">
                <legend class="rim">Stok</legend>
                <div class="row-fluid">
                    <div class="span6">
                        <div class="control-group" style="margin-left:-30px;">
                            <?php echo $form->labelEx($modObatalkesM, 'satuanbesar_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php
                            echo $form->dropDownList($modObatalkesM, 'satuanbesar_id', CHtml::listData($modObatalkesM->SatuanBesarItems, 'satuanbesar_id', 'satuanbesar_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'empty' => '-- Pilih --', 'style' => 'width:130px;'));
                            ?>
                            </div>
                        </div> 

                        <div class="control-group" style="margin-left:-30px;">
                            <?php echo $form->labelEx($modObatalkesM, 'satuankecil_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php
                            echo $form->dropDownList($modObatalkesM, 'satuankecil_id', CHtml::listData($modObatalkesM->SatuanKecilItems, 'satuankecil_id', 'satuankecil_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                'empty' => '-- Pilih --',));
                            ?>
                            </div>
                        </div> 

                        <div class="control-group" style="margin-left:-30px;">
                            <?php echo $form->labelEx($modObatalkesM, 'minimalstok', array('class' => 'control-label')); ?>
                            <div class="controls">
                            <?php echo $form->textField($modObatalkesM, 'minimalstok', array('class' => 'span1 integer',
                                'onkeypress' => "return $(this).focusNextInputField(event);"));
                            ?>
                            </div>
                        </div>
                    </div>
                    <div class="span6">
                        <div class="control-group" style="margin-left:-30px;">
                            <label class="control-label">Stok Sekarang <font color="red">*</font></label>
                            <?php //echo chtml::label('Stok Sekarang','stoksekarang', array('class'=>'control-label'));
                            //echo $form->labelEx($modObatalkesM,'stoksekarang',array('class'=>'control-label'));
                            ?>
                            <div class="controls">
                                <?php echo $form->textField($modObatalkesM, 'stoksekarang', array('class' => 'span1 integer',
                                    'onkeypress' => "return $(this).focusNextInputField(event);"));
                                ?>
                            </div>
                        </div>            

                        <div class="control-group" style="margin-left:-30px;">
                                <?php echo $form->labelEx($modObatalkesM, 'kemasanbesar', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textField($modObatalkesM, 'kemasanbesar', array('class' => 'span1 integer',
                                    'onkeypress' => "return $(this).focusNextInputField(event);"));
                                ?>
                            </div>
                        </div> 

                        <div class="control-group" style="margin-left:-30px;">
                            <?php echo $form->labelEx($modObatalkesM, 'lokasigudang_id', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                echo $form->dropDownList($modObatalkesM, 'lokasigudang_id', CHtml::listData($modObatalkesM->lokasiGudangItems, 'lokasigudang_id', 'lokasigudang_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'empty' => '-- Pilih --', 'style' => 'width:130px;'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
            </fieldset>
        </td>
        <td>
            <fieldset class="box" id="fieldsetHargaNetto">
                <legend class="rim">HPP</legend>
                <div>
                    <div class="control-group" style="margin-left:-30px;">
<?php echo $form->labelEx($modObatalkesM, 'harganetto', array('class' => 'control-label')); ?>
                        <div class="controls">
<?php echo $form->textField($modObatalkesM, 'harganetto', array('class' => 'span2 integer',
    'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();'));
?>
                        </div>
                    </div> 

                    <div class="control-group" style="margin-left:-30px;">
<?php echo $form->labelEx($modObatalkesM, 'discount', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textField($modObatalkesM, 'discount', array('class' => 'span1 float',
                            'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();'));
                        ?> %
                        </div>
                    </div> 

                    <div class="control-group" style="margin-left:-30px;">
<?php echo $form->labelEx($modObatalkesM, 'ppn_persen', array('class' => 'control-label')); ?>
                        <div class="controls">
<?php echo $form->textField($modObatalkesM, 'ppn_persen', array('class' => 'span1 float',
    'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();'));
?> %
                        </div>
                    </div>  

                    <div class="control-group" style="margin-left:-30px;">
                        <?php echo Chtml::label('HPP', 'hpp', array('class' => 'control-label')); ?>
                        <div class="controls">
                        <?php echo $form->textField($modObatalkesM, 'hpp', array('class' => 'span1 integer', 'onkeyup' => 'hitungSemua();',
                            'onkeypress' => "return $(this).focusNextInputField(event);"));
                        ?> 
                        </div>
                    </div>
                    <div class="control-group">
                        <div class="control">
                            <font size="1px">HPP = (HARGA NETTO - (HARGA NETTO * DISCOUNT) + ((HARGA NETTO - (HARGA NETTO * DISCOUNT) * PPN))</font>
                        </div>
                    </div>
                </div>
            </fieldset>
            <fieldset class="box" id="fieldsetHargaJualApotek">
                <legend class="rim">Harga Jual Apotek</legend>
                <div>
                    <table width="100%">
        <!--                <tr>
                            <td>
                                <div class="control-group" style="margin-left:-30px;">
<?php // echo $form->labelEx($modObatalkesM,'marginnonresep',array('class'=>'control-label')); ?>
                                    <div class="controls">
<?php // echo $form->textField($modObatalkesM,'marginnonresep',array('class'=>'span1 float', 'onkeyup'=>'hitungSemua();',
//                                                'onkeypress'=>"return $(this).focusNextInputField(event);")); 
?> %
                                    </div>
                                </div> 
                            </td>
                            <td></td>
                        </tr>-->
        <!--                <tr>
                            <td>
                                <div class="control-group" style="margin-left:-30px;">
<?php // echo $form->labelEx($modObatalkesM,'hjanonresep',array('class'=>'control-label')); ?>
                                    <div class="controls">
                                    <?php // echo CHtml::textField('hjanonresep',0,array('class'=>'span2 integer','value'=>0,'readonly'=>true,
//                                                'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:80px;')); //,'onkeyup'=>'marginNonResep();'
                                    ?> Rupiah
                                    </div>
                                </div> 
                            </td>
                            <td>
                                <div class="control-group" style="margin-left:-50px;">
                                <?php // echo $form->labelEx($modObatalkesM,'hjanonresep',array('class'=>'control-label')); ?>
                                    <div class="controls">
                                <?php // echo $form->textField($modObatalkesM,'hjanonresep',array('class'=>'span2 integer', 
//                                                'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:80px;')); //,'onkeyup'=>'marginNonResep();'
                                ?> Rupiah 
                                    </div>
                                </div> 
                            </td>
                        </tr> -->
                        <tr>
                            <td>
                                <div class="control-group" style="margin-left:-30px;">
                        <?php echo $form->labelEx($modObatalkesM, 'marginresep', array('class' => 'control-label')); ?>
                                    <div class="controls">
                        <?php echo $form->textField($modObatalkesM, 'marginresep', array('class' => 'span1 float',
                            'onkeypress' => "return $(this).focusNextInputField(event);", 'onkeyup' => 'hitungSemua();'));
                        ?> %
                                    </div>
                                </div>
<?php echo $form->hiddenField($modObatalkesM, 'jasadokter', array('class' => 'span1 integer',
    'onkeypress' => "return $(this).focusNextInputField(event);"));
?>

                            </td>
                        </tr>
        <!--                <tr>
                            <td>
                                <div class="control-group" style="margin-left:-30px;">
<?php // echo CHtml::label('Resep Dokter','jasadokter',array('class'=>'control-label')); ?>
                                    <div class="controls">
                                    <?php // echo CHtml::hiddenField('persenjasadokter_kons');  ?>
                                    <?php
                                    // echo CHtml::dropDownList('persenjasadokter','persenjasadokter', 
//                                         CHtml::listData(JasaresepM::model()->findAll(), 'persenjasa', 'persenjasa') ,
//                                            array('empty'=>'-- Pilih --',
//                                                'onkeypress'=>"return $(this).focusNextInputField(event)",'style'=>'width:70px;','onchange'=>'jasaDokter(this);', 'readonly'=>true)); 
                                    ?> %
                                    </div>
                                </div> 
                            </td>
                            <td></td>
                        </tr>-->
                        <tr>
                            <td>
                                <div class="control-group" style="margin-left:-30px;">
                        <?php echo $form->labelEx($modObatalkesM, 'hjaresep', array('class' => 'control-label')); ?>
                                    <div class="controls">
<?php echo CHtml::textField('hjaresep', 0, array('class' => 'span2 integer', 'value' => 0, 'readonly' => true,
    'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:80px;'));
?> Rupiah
                                    </div>
                                </div>
                                <div class="control-group" style="margin-left:-30px;">
<?php echo $form->labelEx($modObatalkesM, 'hjaresep', array('class' => 'control-label')); ?>
                                    <div class="controls">
<?php echo $form->textField($modObatalkesM, 'hjaresep', array('class' => 'span2 integer',
    'onkeypress' => "return $(this).focusNextInputField(event);", 'style' => 'width:80px;'));
?> Rupiah
                                    </div>
                                </div> 
                            </td>
                        </tr>
        <!--                <tr>
                            <td>
                                <div class="control-group" style="margin-left:-30px;">
<?php // echo $form->labelEx($modObatalkesM,'hargajual',array('class'=>'control-label'));?>
                                    <div class="controls">
<?php // echo $form->textField($modObatalkesM,'hargajual',array('class'=>'span2 integer', 
//                                                'onkeypress'=>"return $(this).focusNextInputField(event);",'style'=>'width:80px;')); 
?> Rupiah
                                    </div>
                                </div> 
                            </td>
                        </tr>-->



                    </table>
                </div>
            </fieldset>
        </td>
    </tr>
</table>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogjenisobatalkes',
    'options' => array(
        'title' => 'Pencarian Jenis Obat Alkes',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 'auto',
        'resizable' => false,
    ),
));

$modTherapiobat = new JenisobatalkesM('searchDialog');
$modTherapiobat->unsetAttributes();
if (isset($_GET['JenisobatalkesM'])) {
    $modTherapiobat->attributes = $_GET['JenisobatalkesM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jenisobatalkes-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modTherapiobat->searchDialog(),
    'filter' => $modTherapiobat,
    'template' => "{items}\n{pager}",
//        'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectjenisobatalkes",
                                                    "onClick" => "\$(\"#FAObatalkesM_jenisobatalkes_id\").val($data->jenisobatalkes_id);
                                                                \$(\"#jenisobatalkes\").val(\"$data->jenisobatalkes_nama\");
                                                                \$(\"#dialogjenisobatalkes\").dialog(\"close\");
                                                                return false;
                                                                "
                                             )
                             )',
        ),
        'jenisobatalkes_nama',
        'jenisobatalkes_namalain',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<script>
    function hitungSemua() {
        var harganetto = unformatNumber($('#<?php echo CHtml::activeId($modObatalkesM, 'harganetto') ?>').val());
        var discount = unformatNumber($('#<?php echo CHtml::activeId($modObatalkesM, 'discount') ?>').val()) / 100.0;
        var ppn = unformatNumber($('#<?php echo CHtml::activeId($modObatalkesM, 'ppn_persen') ?>').val()) / 100.0;
        var marginresep = unformatNumber($('#<?php echo CHtml::activeId($modObatalkesM, 'marginresep') ?>').val()) / 100.0;
        var marginnonresep = unformatNumber($('#<?php echo CHtml::activeId($modObatalkesM, 'marginnonresep') ?>').val()) / 100.0;
        var persenjasadokter = parseFloat($('#persenjasadokter').val());

        var hpp = (harganetto - (harganetto * discount)) + ((harganetto - (harganetto * discount)) * ppn);
        $('#<?php echo CHtml::activeId($modObatalkesM, 'hpp') ?>').val(formatInteger(hpp));

        var hjanonresep = (harganetto + (harganetto * ppn)) + ((harganetto + (harganetto * ppn)) * marginnonresep);
        $('#<?php echo CHtml::activeId($modObatalkesM, 'hjanonresep') ?>').val(formatInteger(hjanonresep));
        $('#hjanonresep').val(formatInteger(hjanonresep));

        if (persenjasadokter == '') {
            persenjasadokter = 0;
        }
        $.post('<?php echo Yii::app()->createUrl('gudangFarmasi/ObatAlkesM/getPersenDokter'); ?>', {hargaNetto: harganetto}, function (data) {
            $('#persenjasadokter').val(data.jasaResep);
            $('#persenjasadokter_kons').val(data.jasaResep);
        }, 'json');
        var hjaresep = hjanonresep + (hjanonresep * marginresep);
        var jasadokter = hjaresep * (persenjasadokter / 100)
        //JASA DOKTER DIBEBANKAN KE KONSUMEN ATAU DI TANGGUNG APOTEK?? >> hjaresep = hjaresep + jasadokter;
        $('#<?php echo CHtml::activeId($modObatalkesM, 'jasadokter') ?>').val(parseFloat(jasadokter));
        $('#<?php echo CHtml::activeId($modObatalkesM, 'hjaresep') ?>').val(formatInteger(hjaresep));
        $('#hjaresep').val(formatInteger(hjaresep));
        $('#<?php echo CHtml::activeId($modObatalkesM, 'hargajual') ?>').val(formatInteger(hjaresep));

    }
    function jasaDokter(obj) {
        myAlert("Jasa resep dokter tidak bisa diubah !");
        $(obj).val($('#persenjasadokter_kons').val());
    }
</script>