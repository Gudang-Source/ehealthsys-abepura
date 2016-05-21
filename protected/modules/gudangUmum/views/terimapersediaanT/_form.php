<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


<div class="white-container">
	<?php
		if(isset($_GET['sukses']) && ($_GET['sukses'] == 1)){
			Yii::app()->user->setFlash("success","Tansaksi Penerimaan Persediaan Barang berhasil disimpan!");
		}
	?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <legend class="rim2">Penerimaan <b>Barang</b></legend>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'guterimapersediaan-t-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
        'focus'=>'#',
    )); ?>
    <p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

    <?php echo $form->errorSummary($model); ?>

    <?php if (isset($modBeli)) {
        $this->renderPartial('_dataBeli', array('modBeli'=>$modBeli));
    }?>
    <hr />
    <table width="100%">
        <tr>
            <td>
                <?php //echo $form->textFieldRow($model,'pembelianbarang_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->dropDownListRow($model,'sumberdana_id', CHtml::listData(SumberdanaM::model()->findAll('sumberdana_aktif = true ORDER BY sumberdana_nama'), 'sumberdana_id', 'sumberdana_nama'), array('empty'=>'-- Pilih --', 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'returpenerimaan_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'tglterima',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglterima', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $model->tglterima = MyFormatter::formatDateTimeForUser($model->tglterima);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglterima',
                            'mode' => 'date',
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
                <?php echo $form->textFieldRow($model,'nopenerimaan',array('readonly'=>true,'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>20,'readonly'=>true)); ?>
                <?php //echo $form->textFieldRow($model,'tglsuratjalan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglsuratjalan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $model->tglsuratjalan = MyFormatter::formatDateTimeForUser($model->tglsuratjalan);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglsuratjalan',
                            'mode' => 'date',
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
                <?php echo $form->textFieldRow($model,'nosuratjalan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>'Ketikan No. Surat Jalan')); ?>
                <?php //echo $form->textFieldRow($model,'tglfaktur',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'tglfaktur', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        $model->tglfaktur = MyFormatter::formatDateTimeForUser($model->tglfaktur);
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglfaktur',
                            'mode' => 'date',
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
                <?php echo $form->textFieldRow($model,'nofaktur',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50,'placeholder'=>'Ketikan No. Faktur')); ?>
            </td>
            <td>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'peg_penerima_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'peg_penerima_id'); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model'=>$model,
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
                                                                            $("#'.Chtml::activeId($model, 'peg_penerima_id') . '").val(pegawai_id); 
                                                                            return false;
                                                                        }',
                            ),
                            'htmlOptions' => array(
                                'class'=>'namaPegawai',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                            'placeholder'=>'Ketikan Nama Pegawai penerimaan'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction'=>'openDialog("'.Chtml::activeId($model, 'peg_penerima_id').'");'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'peg_penerima_id'); ?>
                    </div>
                </div>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'peg_mengetahui_id', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo $form->hiddenField($model, 'peg_mengetahui_id'); ?>
                        <!--                <div class="input-append" style='display:inline'>-->
                        <?php
                        $this->widget('MyJuiAutoComplete', array(
                            'model'=>$model,
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
                                                                            $("#'.Chtml::activeId($model, 'peg_mengetahui_id') . '").val(pegawai_id); 
                                                                            return false;
                                                                        }',
                            ),
                            'htmlOptions' => array(
                                'class'=>'namaPegawai',
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                                            'placeholder'=>'Ketikan Nama Pegawai mengetahui'
                            ),
                            'tombolDialog' => array('idDialog' => 'dialogPegawai', 'jsFunction'=>'openDialog("'.Chtml::activeId($model, 'peg_mengetahui_id').'");'),
                        ));
                        ?>
                        <?php echo $form->error($model, 'peg_mengetahui_id'); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'peg_penerima_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'peg_mengetahui_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php //echo $form->textFieldRow($model,'ruanganpenerima_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="control-group ">
                   <?php echo $form->labelEx($model, 'ruanganpenerima_id', array('class'=>'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo $form->dropDownList($model, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama'), 'instalasi_id', 'instalasi_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50,
                            'ajax' => array('type' => 'POST',
                                'url' => $this->createUrl('SetDropdownRuangan',array('encode'=>false,'model_nama'=>get_class($model))),
                                'update' => '#' . CHtml::activeId($model, 'ruanganpenerima_id') . ''),));
                        ?>
                        <?php echo $form->dropDownList($model, 'ruanganpenerima_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id'=>$model->instalasi_id,'ruangan_aktif'=>true)), 'ruangan_id', 'ruangan_nama'), array('empty' => '-- Pilih --', 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'onchange'=>'clearAll()')); ?>
                        <?php echo $form->error($model, 'ruanganpenerima_id'); ?>
                    </div>
                </div>
                <?php echo $form->textAreaRow($model,'keterangan_persediaan',array('rows'=>6, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'totalharga',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>true, 'style'=>'text-align: right;')); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model, 'discount', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php echo Chtml::textField('discountpersen', '0', array('class' => 'span1 integer2', 'onblur'=>'setTotalHarga();', 'style'=>'text-align: right;')); ?> % = 
                        <?php echo $form->textField($model, 'discount', array('readonly' => true, 'class' => 'span2 integer2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'style'=>'text-align: right;')); ?>
                        <?php echo $form->error($model, 'discount'); ?>
                    </div>
                </div>
                <?php //echo $form->textFieldRow($model,'discount',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                <?php echo $form->textFieldRow($model,'biayaadministrasi',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;')); ?>
                <?php echo $form->textFieldRow($model,'pajakpph',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;')); ?>
                <?php echo $form->textFieldRow($model,'pajakppn',array('class'=>'span3 integer2', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'style'=>'text-align: right;')); ?>
                <?php echo $form->textFieldRow($model,'nofakturpajak',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100,'placeholder'=>'Ketikan No. Faktur Pajak')); ?>
                <div class="control-group ">
                    <?php echo $form->labelEx($model,'tgljatuhtempo', array('class'=>'control-label')) ?>
                    <div class="controls">
                            <?php   
                            $model->tgljatuhtempo = (!empty($model->tgljatuhtempo) ? date("d/m/Y",strtotime($model->tgljatuhtempo)) : null);
                            $this->widget('MyDateTimePicker',array(
                                                                            'model'=>$model,
                                                                            'attribute'=>'tgljatuhtempo',
                                                                            'mode'=>'date',
                                                                            'options'=> array(
    //                                            'dateFormat'=>Params::DATE_FORMAT,
                                                                                    'showOn' => false,
                                                                                    //'maxDate' => 'd',
                                                                                    'yearRange'=> "-150:+0",
                                                                            ),
                                                                            'htmlOptions'=>array('placeholder'=>'00/00/0000','class'=>'dtPicker2 datemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                                                                            ),
                            )); ?>
                            <?php echo $form->error($model, 'tgljatuhtempo'); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>
    <?php //echo $form->textFieldRow($model,'create_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'update_time',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'create_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'update_loginpemakai_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'create_ruangan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
    <div class="block-tabel">
        <h6>Detail <b>Barang</b></h6>
        <?php if (isset($modDetails)){
            echo $form->errorSummary($modDetails);
        } ?>
        <?php 
        if (empty($modBeli->pembelianbarang_id)){    
            $this->renderPartial('_formDetailBarang', array('model'=>$model, 'form'=>$form)); 
        }?>
        <?php $this->renderPartial('_tableDetailBarang', array('model'=>$model, 'form'=>$form, 'modDetails'=>$modDetails, 'modDetailBeli'=>$modDetailBeli, 'modBeli'=>$modBeli)); ?>
    </div>
    <div class="form-actions">
        <?php echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds','{icon} Create',array('{icon}'=>'<i class="icon-ok icon-white"></i>')) : 
                Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                            $this->createUrl($this->module->id.'/Index'), 
                            array('class'=>'btn btn-danger',
                                'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r) {if(r) window.location = "'.$this->createUrl('Index').'";} ); return false;'));  ?>
        <?php
        $content = $this->renderPartial('../tips/transaksi_penerimaan_persediaan',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
<?php $this->endWidget(); ?>
</div>

<?php
//========= Dialog buat cari Bahan Diet =========================
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

$modPegawai = new GUPegawaiM('search');
$modPegawai->unsetAttributes();
//$modPegawai->ruangan_id = 0;
if (isset($_GET['GUPegawaiM']))
    $modPegawai->attributes = $_GET['GUPegawaiM'];

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pegawai-m-grid',
    'dataProvider'=>$modPegawai->searchDialog(),
    'filter'=>$modPegawai,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "
                                    var parent = $(\"#dialogPegawai\").attr(\"parentclick\");
                                    $(\"#\"+parent+\"\").val($data->pegawai_id);
                                    $(\"#\"+parent+\"\").parents(\".controls\").find(\".namaPegawai\").val(\"$data->nama_pegawai\");
                                    $(\'#dialogPegawai\').dialog(\'close\');
                                    return false;"))',
        ),
        ////'pegawai_id',
        
            'nama_pegawai',
            'nomorindukpegawai',
                'alamat_pegawai',
        'agama',
            array(
                'name'=>'jeniskelamin',
                'filter'=> CHtml::dropDownList('GUPegawaiM[jeniskelamin]',$modPegawai->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'--Pilih--')),
                'value'=>'$data->jeniskelamin',
                ),        
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
?>

<?php 
$urlAjax = $this->createUrl('getPenerimaanPersediaanBarang');
$notif = Yii::t('mds','Do You want to cancel?');
$totalharga = CHtml::activeId($model, 'totalharga');
$discount = CHtml::activeId($model, 'discount');
$js = <<< JS
    function inputBarang(){
        idBarang = $('#idBarang').val();
        jumlah = $('#jumlah').val();
        satuan = $('#satuan').val();
        if (!jQuery.isNumeric(idBarang)){
            myAlert('Isi Barang yang akan dipesan');
            return false;
        }
        else if (!jQuery.isNumeric(jumlah)){
            myAlert('Isi jumlah barang yang akan dipesan');
            return false;
        }
        else{
            if (cekList(idBarang) == true){
                $.post('${urlAjax}', {idBarang:idBarang, jumlah:jumlah, satuan:satuan}, function(data){
                    $('#tableDetailBarang tbody').append(data);
                    rename();
                    $("#tableDetailBarang tbody tr:last .integer2").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0,"symbol":null});
                    clear();
                    setTotalHarga();
                }, 'json');
            }
        }
        
    }
            
    function cekList(id){
        x = true;
        $('.barang').each(function(){
            if ($(this).val() == id){
                myAlert('Barang telah ada d List');
                clear();
                x = false;
            }
        });
        return x;
    }
    
    function clear(){
        $('#formDetailBarang').find('input, select').each(function(){
            $(this).val('');
        });
        $('#jumlah').val(1);
    }
    
    function batal(obj){
        myConfirm("${notif}",'Perhatian!',function(r){
            if(!r) {
                return false;
            }else{
                $(obj).parents('tr').remove();
                setTotalHarga();
                rename();
            }
        });
    }
    function rename(){
        noUrut = 1;
        $('.cancel').each(function(){
            $(this).parents('tr').find('[name*="TerimapersdetailT"]').each(function(){
                var nama = $(this).attr('name');
                data = nama.split('TerimapersdetailT[]');
                if (typeof data[1] === "undefined"){}else{
                    $(this).attr('name','TerimapersdetailT['+(noUrut-1)+']'+data[1]);
                }
            });
            noUrut++;
        });        
    }
    
    
    function openDialog(obj){
        $('#dialogPegawai').attr('parentClick',obj);
        $('#dialogPegawai').dialog('open');   
    }
    
    function setTotalHarga(){
        unformatNumberSemua();
        var discountPersen = $('#discountpersen').val();
        var totalHarga = 0;
        $('.cancel').each(function(){
            qty = $(this).parents('tr').find('.qty').val();
            satuan =  $(this).parents('tr').find('.satuan').val();
            $(this).parents('tr').find('.beli').val(qty*satuan);
            totalHarga += parseFloat(qty*satuan);
        });
        $('#${totalharga}').val(totalHarga);
        if(jQuery.isNumeric(discountPersen)){
            $('#${discount}').val(totalHarga*discountPersen/100);
        }
            formatNumberSemua();
    }

JS;
Yii::app()->clientScript->registerScript('onhead',$js,  CClientScript::POS_END);
?>

<?php 
Yii::app()->clientScript->registerScript('onready','
    setTotalHarga();
    $("form").submit(function(){
        qty = false;
        idPenerima = $("#'.CHtml::activeId($model, 'peg_penerima_id').'").val();
        sumberdana = $("#'.CHtml::activeId($model, 'sumberdana_id').'").val();
        ruangPenerima = $("#'.CHtml::activeId($model, 'ruanganpenerima_id').'").val();
       
        $(".qty").each(function(){
            if ($(this).val() > 0){
                qty = true
            }
        });
        
        if(!jQuery.isNumeric(sumberdana)){
            myAlert("'.CHtml::encode($model->getAttributeLabel('sumberdana_id')).' harus diisi");
            return false;
        }
        else if (!jQuery.isNumeric(idPenerima)){
            myAlert("'.CHtml::encode($model->getAttributeLabel('peg_penerima_id')).' harus diisi");
            return false;
        }
        else if (!jQuery.isNumeric(ruangPenerima)){
            myAlert("'.CHtml::encode($model->getAttributeLabel('ruanganpenerima_id')).' harus diisi");
            return false;
        }

        if ($(".cancel").length < 1){
            myAlert("Detail Barang Harus Diisi");
            return false;
        }
        else if (qty == false){
            myAlert("'.CHtml::encode($model->getAttributeLabel('jml_beli')).' harus memiliki value yang lebih dari 0");
            return false;
        }
    });
',CClientScript::POS_READY);?>