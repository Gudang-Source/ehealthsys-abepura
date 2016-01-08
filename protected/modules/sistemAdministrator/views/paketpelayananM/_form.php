<style>
    .cols_hide{
        display:none;
    }
</style>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sapaketpelayanan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
));
?>
<?php
$this->widget('application.extensions.moneymask.MMask',array(
    'element'=>'.currency',
    'currency'=>'PHP',
    'config'=>array(
	'symbol'=>'Rp. ',
	'defaultZero'=>true,
	'allowZero'=>true,
	'precision'=>0,
    )
));
?>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>
<?php if (isset($modPaket)) { ?>
<?php echo $form->errorSummary($modPaket); ?>
<?php } ?>
<div class='row-fluid'>
    <div class='span6'>
        <?php echo $form->dropDownListRow($model, 'tipepaket_id', CHtml::listData(TipepaketM::model()->findAll('tipepaket_aktif=true'), 'tipepaket_id', 'tipepaket_nama'), array('empty' => '-- Pilih --', 'class' => 'span3 isRequired', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange'=>'setValue(this);', 'class' => 'idTipePaket')); ?>
        
        <?php //echo $form->dropDownListRow($model,'daftartindakan_id', CHtml::listData(DaftartindakanM::model()->findAll(), 'daftartindakan_id','daftartindakan_nama'),array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData(RuanganM::model()->findAll("ruangan_aktif = TRUE order by ruangan_nama ASC"), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --','class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <div class="control-group ">
            <?php echo $form->label($model, 'daftartindakan_id', array('class' => 'control-label')); ?>
            <?php echo CHtml::hiddenField('idDaftarTindakan', ''); ?>
            <?php echo CHtml::hiddenField('idTarifTindakan', ''); ?>
            <?php echo CHtml::hiddenField('idKelasPelayanan', ''); ?>
            <div class="controls">
                
                    <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'daftartindakan_id',
                        'sourceUrl' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/getDaftarTindakan').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           idKelasPelayanan: $("#idKelasPelayanan").val(),
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
                                                              $("#idDaftarTindakan").val(ui.item.daftartindakan_id);
                                                              $("#idTarifTindakan").val(ui.item.tariftindakan_id);
                                                              $(this).val(ui.item.label);
                                                              submitPaketPelayanan();
                                                              return false;
                                                    }',
                        ),
                        'htmlOptions' => array('value' => '', 'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3 ',
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogDaftarTindakan'),
                    ));
                    ?>
            </div>

        </div>
        <!-- <div class="control-group ">
            <div class="controls">
                                <?php
                    echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick' => 'submitPaketPelayanan();return false;',
                        'class' => 'btn btn-primary',
                        'onkeypress' => "submitPaketPelayanan();return $(this).focusNextInputField(event)",
                        'rel' => "tooltip",
                        'id' => 'tambahDaftarTindakan',
                        'title' => "Klik Untuk Menambahkan Daftar Tindakan",));
                    ?>
                </div>
        </div> -->


        
    </div>
    <div class='span6'>
        <?php //echo $form->textFieldRow($model,'namatindakan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>100)); ?>
        <?php echo $form->textFieldRow($model,'tarifpaketpel',array('onblur'=>'sumTarifPaket(this);','class'=>'span3 currency', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'readonly'=>false, 'maxlength'=>100)); ?>
        <?php echo $form->textFieldRow($model, 'subsidiasuransi', array('onblur'=>'sumSubAsuransi(this);','class' => 'span3 currency', 'readonly'=>false, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php //echo $form->textFieldRow($model, 'subsidipemerintah', array('class' => 'span3 currency', 'readonly'=>true, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'subsidirumahsakit', array('onblur'=>'sumSubRS(this);','class' => 'span3 currency', 'readonly'=>false, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'iurbiaya', array('class' => 'span3 currency', 'readonly'=>false, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    </div>
</div>
<br/>
<table id="tablePaketPelayanan" class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>No.Urut</th>
            <th>Tipe Paket</th>
            <th>Daftar Tindakan</th>
            <th>Ruangan</th>
            <th>Nama Tindakan</th>
            <th>Total Tarif</th>
            <th>Tarif Paket Pelayanan</th>
            <th>Subsidi Asuransi</th>
            <th class="cols_hide">Subsidi Pemerintah</th>
            <th>Subsidi Rumah Sakit</th>
            <th>Harga Iur Biaya</th>
            <th>Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($modPaket)>0){
                foreach ($modPaket as $i=>$row){
                    $modTipePaket = TipepaketM::model()->findByPk($row->tipepaket_id);
                    $modTarifTindakan = TariftindakanM::model()->findByAttributes(array('daftartindakan_id' => $row->daftartindakan_id, 'komponentarif_id'=>  6, 'kelaspelayanan_id'=>$modTipePaket->kelaspelayanan_id));
                    // echo '<pre>';print_r($modTipePaket->kelaspelayanan_id);exit();
                    echo "<tr>
                            <td>".CHtml::TextField('noUrut', ($i+1), array('class' => 'span1 noUrut', 'readonly' => TRUE)) .
                                CHtml::activeHiddenField($row, '['.$row->daftartindakan_id.']tipepaket_id') .
                                CHtml::activeHiddenField($row, '['.$row->daftartindakan_id.']daftartindakan_id') .
                                CHtml::activeHiddenField($row, '['.$row->daftartindakan_id.']ruangan_id') .
                                CHtml::activeHiddenField($row, '['.$row->daftartindakan_id.']paketpelayanan_id') ."</td>
                            <td>".$row->tipepaket->tipepaket_nama . "</td>
                            <td>".$row->daftartindakan->daftartindakan_nama . "</td>
                            <td>".CHtml::activeDropDownList($row, '['.$row->daftartindakan_id.']ruangan_id', CHtml::listData(RuanganM::model()->findAll(), 'ruangan_id', 'ruangan_nama'), array('empty'=>'-- Pilih --', 'class' => 'span2 ruangan ', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']namatindakan', array( 'class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::TextField('totaltarif[]', isset($modTarifTindakan->harga_tariftindakan)?$modTarifTindakan->harga_tariftindakan:0, array('readonly' => false, 'class' => 'span2 totalTarif currency', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']tarifpaketpel', array('onblur' => 'tarifPaket(this);','parent'=>'SAPaketpelayananM_tarifpaketpel', 'class' => 'span2 tarifpaket currency', 'onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']subsidiasuransi', array('onblur' => 'tarifAsuransi(this);','parent'=>'SAPaketpelayananM_subsidiasuransi', 'class' => 'span2 subisidiAsuransi currency','onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td class='cols_hide'>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']subsidipemerintah', array('parent'=>'SAPaketpelayananM_subsidipemerintah', 'class' => 'span2 subisidiPemerintah currency','onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']subsidirumahsakit', array('onblur' => 'tarifRs(this);','parent'=>'SAPaketpelayananM_subsidirumahsakit',  'class' => 'span2 subisidiRS currency','onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::activeTextField($row, '['.$row->daftartindakan_id.']iurbiaya', array('readonly'=>true,'parent'=>'SAPaketpelayananM_iurbiaya', 'class' => 'span2 iurBiaya currency','onkeypress' => "return $(this).focusNextInputField(event)")) . "</td>
                            <td>".CHtml::link("<i class='icon-remove'></i>", '', array('href'=>'','onclick'=>'remove2(this);return false;'))."</td>
                        </tr>";
                }
            }
        ?>
    </tbody>
</table>
<br/>
<div class="form-actions">
    <?php
		echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
			Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button','onclick'=>'cekValiditas()'));
    ?>
    <?php
		echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), '', array('class' => 'btn btn-danger',
			'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'))."&nbsp";
		 echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Paket Pelayanan', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));
    ?>
	<?php
		$content = $this->renderPartial($this->path_view.'tips.tips',array(),true);
		$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	?>
</div>

<?php $this->endWidget(); ?>

<?php 
$notif = Yii::t('mds','Do You want to cancel?');
$idRuangan = CHtml::activeId($model, 'ruangan_id');
$subsidiAsuransi = CHtml::activeId($model, 'subsidiasuransi');
$subsidiPemerintah = CHtml::activeId($model, 'subsidipemerintah');
$subsidiRS = CHtml::activeId($model, 'subsidirumahsakit');
$iurBiaya = CHtml::activeId($model, 'iurbiaya');
$tarifpaket = CHtml::activeId($model, 'tarifpaketpel');
$idTipePaket = CHtml::activeId($model, 'tipepaket_id');
$urlGetPaketPelayanan = $this->createUrl('getPaketPelayanan');
$urlGetTipePaket = $this->createUrl('getTipePaket');
$urlHalamanIni = $this->route;
Yii::app()->clientScript->registerScript('angka', "

", CClientScript::POS_HEAD); ?>

<?php

$jsPelayanan = <<< JS

function cekValiditas(){
		
		
	if(requiredCheck($("form"))){
        var jumlah_tr = $('#tablePaketPelayanan tbody tr').length;
        if(jumlah_tr <= 0){
                myAlert('Isikan data terlebih dahulu.');
            return false;
        }else{
			unformatNumberForm();
            $('#sapaketpelayanan-m-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
    }
    return false;
};
		
function setValue(obj){
    id = $(obj).val();
    $('#tablePaketPelayanan tbody tr').remove();
    $.post("${urlGetTipePaket}", {idTipePaket:id},
        function(data){

            asuransi = data.asuransi;
            pemerintah = data.pemerintah;
            rs = data.rs;
            iurbiaya = data.iurbiaya;
            tarifpaketpel = data.tarifpaketpel;

           $('#${subsidiAsuransi}').val(formatInteger(asuransi));
           $('#${subsidiPemerintah}').val(formatInteger(pemerintah));
           $('#${subsidiRS}').val(formatInteger(rs));
           $('#${iurBiaya}').val(formatInteger(iurbiaya));
           $('#${tarifpaket}').val(formatInteger(tarifpaketpel));
           $('#idKelasPelayanan').val(data.kelaspelayanan_id);
           
           $('#tablePaketPelayanan tbody').append(data.tr);
           $(".numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
           $.get('index.php?r=${urlHalamanIni}', {idKelasPelayanan:data.kelaspelayanan_id}, function(datas){
                $.fn.yiiGridView.update('satarif-tindakan-m-grid', {
                    url: document.URL+'&SATarifTindakanM%5Bkelaspelayanan_id%5D='+data.kelaspelayanan_id,
                }); 
            });
           
    }, "json");
}
           
function setDialogTindakan(){
   kelas =  $('#idKelasPelayanan').val();
   $.get('${urlHalamanIni}', {idKelasPelayanan:kelas}, function(datas){
        $.fn.yiiGridView.update('satarif-tindakan-m-grid', {
            url: document.URL+'&SATarifTindakanM%5Bkelaspelayanan_id%5D='+kelas,
        }); 
    });
}

function submitPaketPelayanan()
{
    idDaftarTindakan = $('#idDaftarTindakan').val();
    idTarifTindakan = $('#idTarifTindakan').val();
    idTipePaket = $('#${idTipePaket}').val();
    idRuangan = $('#${idRuangan}').val();
    
    if(idDaftarTindakan==''){
        myAlert('Silahkan Pilih Daftar Tindakan Terlebih Dahulu');
    } else if(idTipePaket==''){
        myAlert('Silahkan Pilih Tipe Paket Terlebih Dahulu');
    }else{
        $.post("${urlGetPaketPelayanan}", {idTarifTindakan:idTarifTindakan, idDaftarTindakan: idDaftarTindakan, idTipePaket:idTipePaket , idRuangan : idRuangan},
        function(data){
            $('#tablePaketPelayanan').append(data.tr);
            $("#tablePaketPelayanan tr:last").find(".numbersOnly").maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null});
            $("#tablePaketPelayanan tr:last").find(".currency").maskMoney({"defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0,"symbol":null});
            setUrutan();
            hitungSemua();
            clear();
        }, "json");
    }   
}
            
function clear(){
    $('#${idRuangan}').val('');
    $('#idDaftarTindakan').val('');
    $('#idTarifTindakan').val('');
    $('#SAPaketpelayananM_daftartindakan_id').val('');
}
    
function sum(obj){
    var attr = $(obj).attr('parent');
    // myAlert($('#'+attr).val());

    var classAttr = $(obj).attr('class');
    var valueAwal = $(obj).val();
    var sumObj = parseInt(0);
       
    $(obj).parents('table').find('input[class="'+classAttr+'"]').each(function(){
        var value = parseFloat($(this).val());
        sumObj = sumObj+value;
    });

    // myAlert(sumObj);
    // return false;
    
    if ($('#'+attr).val() < sumObj){
        if ($(obj).parents('table').find('#'+attr).length == 1){
            $(obj).val($('#'+attr).val());
        }else{
            $(obj).val(($('#'+attr).val())-(sumObj-valueAwal));
        }
        myAlert('jumlah Total Tidak Boleh Melebihi '+$('#'+attr).val());
        $(obj).val(0);
    }
    penguranganAuto();
}

function penguranganAuto(){
    var harga_satuan, total = parseInt(0);
    $('#tablePaketPelayanan').find('input').each(function(){
        if($(this).attr('parent') && $(this).attr('parent') != 'SAPaketpelayananM_iurbiaya')
        {
            if($(this).attr('parent') != 'SAPaketpelayananM_tarifpaketpel')
            {
                harga = (isNaN(parseInt(unformatNumber($(this).val()))) ? 0 : parseInt(unformatNumber($(this).val())));
                total += harga;    
            }else{
                harga_satuan = parseInt(unformatNumber($(this).val()));
            }

        }
    });
    
    $('#tablePaketPelayanan').find('input').each(function(){
        if($(this).attr('parent') && $(this).attr('parent') == 'SAPaketpelayananM_iurbiaya')
        {
            $(this).val(formatInteger(harga_satuan - total));
        }
    });
    
}
    
function hitungSemua(){
    var banyak = $('.noUrut').length;
    var subsidiAsuransi = unformatNumber($('#${subsidiAsuransi}').val());
    var tarifpaket = unformatNumber($('#${tarifpaket}').val());
    var subsidiPemerintah = unformatNumber($('#${subsidiPemerintah}').val());
    var subsidiRS = unformatNumber($('#${subsidiRS}').val());
    var iurBiaya = unformatNumber($('#${iurBiaya}').val());
    var sumTarifTotal = parseInt(0);

    $('.subisidiAsuransi').each(function(){
        var tarifTotal = parseFloat($(this).parents('tr').find('.totalTarif').val());
        sumTarifTotal = sumTarifTotal+tarifTotal;
        
        $(this).parents('table').find('.tarifpaket').each(function(){
            var tarifTotal = parseFloat($(this).parents('tr').find('.totalTarif').val());
            var tarifpaketpel = Math.floor((tarifTotal/sumTarifTotal)*tarifpaket);
            $(this).val(formatInteger(tarifpaketpel));
        });
        
        $(this).parents('table').find('.subisidiAsuransi').each(function(){
            var tarifTotal = parseFloat($(this).parents('tr').find('.totalTarif').val());
            var subsidiAsu = Math.floor((tarifTotal/sumTarifTotal)*subsidiAsuransi);
            $(this).val(formatInteger(subsidiAsu));
        });

        $(this).parents('table').find('.subisidiPemerintah').each(function(){
            var tarifTotal = parseFloat($(this).parents('tr').find('.totalTarif').val());
            var subsidiPemer = Math.floor((tarifTotal/sumTarifTotal)*subsidiPemerintah);
            $(this).val(formatInteger(subsidiPemer));
        });

        $(this).parents('table').find('.subisidiRS').each(function(){
            var tarifTotal = parseFloat($(this).parents('tr').find('.totalTarif').val());
            var subsidirumahsakit = Math.floor((tarifTotal/sumTarifTotal)*subsidiRS);
            $(this).val(formatInteger(subsidirumahsakit));
        });

        $(this).parents('table').find('.iurBiaya').each(function(){
            var tarifTotal = parseFloat($(this).parents('tr').find('.totalTarif').val());
            var iuranBiaya = Math.floor((tarifTotal/sumTarifTotal)*iurBiaya);
            $(this).val(formatInteger(iuranBiaya));
        });
    });
    hitungAll();
}

function remove(obj){
	myConfirm("${notif}",'Perhatian!',function(r){
		if(!r) {
			return false;
		}else{
			$(obj).parents('tr').remove();
			hitungSemua();
			setUrutan();
			return false;
		}
	});
}

function setUrutan(){
    noUrut = 1;
    $('.noUrut').each(function() {
        $(this).val(noUrut);
        noUrut++;
    });
}

function cekValidasi(){
          banyaknyaTindakan = $('.noUrut').length;
          
          if ($('.isRequired').val()==''){
              alert ('Harap Isi Semua Data Yang Bertanda *');
                return false;
          }else if(banyaknyaTindakan<1){
             myAlert('Anda Belum memilih Daftar Tindakan');   
             return false;
          }else if(jumlahCek<1){
             myAlert('Anda Belum Memilih Daftar Tindakan');   
             return false;
          }else{
             return true;
          }
    }
JS;
Yii::app()->clientScript->registerScript('js Paket Pelayanan', $jsPelayanan, CClientScript::POS_HEAD);
?>

<?php
//========= Dialog buat cari data obatAlkes =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(// the dialog
        'id' => 'dialogDaftarTindakan',
        'options' => array(
            'title' => 'Pencarian Daftar Tindakan',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 600,
            'resizable' => false,
        ),
    )
);

$modTarifTindakan = new SATarifTindakanM('search');
$modTarifTindakan->unsetAttributes();
if (isset($_GET['SATarifTindakanM'])) {
    $modTarifTindakan->attributes = $_GET['SATarifTindakanM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id'=>'satarif-tindakan-m-grid',
    'dataProvider' => $modTarifTindakan->searchDaftarTindakan(),
    'filter' => $modTarifTindakan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-check\"></i>","",array("class"=>"btn-small", 
                                            "id" => "selectDaftarTindakan",
                                            "href"=>"",
                                            "onClick" => "$(\"#idDaftarTindakan\").val(\"$data->daftartindakan_id\");
                                                          $(\"#idTarifTindakan\").val(\"$data->tariftindakan_id\");
                                                          $(\"#'.CHtml::activeId($model, 'daftartindakan_id') . '\").val(\"".$data->daftartindakan->daftartindakan_nama." - ".$data->kelaspelayanan->kelaspelayanan_nama." - ".$data->harga_tariftindakan."\");
                                                              submitPaketPelayanan();
                                                          $(\"#dialogDaftarTindakan\").dialog(\"close\"); 
                                                          return false;
                                                "))',
        ),
        array(
            'name'=>'daftartindakan_nama',
            'value'=>'$data->daftartindakan->daftartindakan_nama',
            'type'=>'raw',
        ),
        array(
            'filter'=>CHtml::listData($modTarifTindakan->KelasPelayanan, 'kelaspelayanan_id', 'kelaspelayanan_nama'),
            'name'=>'kelaspelayanan_id',
            'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
        ),
        array(
            'filter'=>false,
            'name'=>'harga_tariftindakan',
            'value'=>'number_format($data->harga_tariftindakan,0,".",",")',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
        $("#SATarifTindakanM_kelaspelayanan_id").val($("#idKelasPelayanan").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end obatAlkes dialog =============================
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

<script>
    //Format dan unformat number pada form
    function formatNumberForm(){
        $("form").find(".currency").each(function(){
            $(this).val(formatNumber($(this).val()));
        });
    }
    formatNumberForm();
    function unformatNumberForm(){
        $("form").find(".currency").each(function(){
            $(this).val(unformatNumber($(this).val()));
        });
    }

    function remove2(obj){
		myConfirm("<?php echo $notif; ?>",'Perhatian!',function(r){
			if(!r) {
				return false;
			}else{
				$(obj).parents('tr').remove();
				hitungSemua();
				setUrutan();
				return false;
			}
		});
    }
    
    // Penghitungan Tarif Paket, Subsidi Asuransi, Subsidi RS 
    
    function sumTarifPaket(obj){
        var tarifPaket = unformatNumber($(obj).val());
        var jmlRow = $('#tablePaketPelayanan tbody tr').length;
        if(jmlRow > 0){
            totTarif = Math.round(tarifPaket / jmlRow);
        }else{
            totTarif = tarifPaket;
        }
        
        $('#tablePaketPelayanan tbody tr').each(function(){
            $(this).parent().find('.tarifpaket').val(formatNumber(totTarif));
        });
        sumIur();
    }
    
    function sumSubAsuransi(obj){
        var tarifAsuransi = unformatNumber($(obj).val());
        var jmlRow = $('#tablePaketPelayanan tbody tr').length;
        if(jmlRow > 0){
            totTarif = Math.round(tarifAsuransi / jmlRow);
        }else{
            totTarif = tarifAsuransi;
        }
        
        $('#tablePaketPelayanan tbody tr').each(function(){
            $(this).parent().find('.subisidiAsuransi').val(formatNumber(totTarif));
        });
        sumIur();
    }
    
    function sumSubRS(obj){
        var tarifRs = unformatNumber($(obj).val());
        var jmlRow = $('#tablePaketPelayanan tbody tr').length;
        if(jmlRow > 0){
            totTarif = Math.round(tarifRs / jmlRow);
        }else{
            totTarif = tarifRs;
        }
        
        $('#tablePaketPelayanan tbody tr').each(function(){
            $(this).parent().find('.subisidiRS').val(formatNumber(totTarif));
        });
        sumIur();
    }
    
    function sumIur(){
        var tarifPaket = unformatNumber($('#SAPaketpelayananM_tarifpaketpel').val());
        var tarifAsuransi = unformatNumber($('#SAPaketpelayananM_subsidiasuransi').val());
        var tarifRs = unformatNumber($('#SAPaketpelayananM_subsidirumahsakit').val());
        
        totalIur = Math.round(tarifPaket - (tarifAsuransi + tarifRs));
        totalIur2 = 0;
        $('#tablePaketPelayanan tbody tr').each(function(){
            var tPaket = unformatNumber($(this).parent().find('.tarifpaket').val());
            var tAsuransi = unformatNumber($(this).parent().find('.subisidiAsuransi').val());
            var tRs = unformatNumber($(this).parent().find('.subisidiRS').val());
        total = Math.round(tPaket - (tAsuransi + tRs));
        totalIur2 = total;

        $(this).parent().find('.iurBiaya').val(formatNumber(totalIur2));
        });
        
        $('#SAPaketpelayananM_iurbiaya').val(formatNumber(totalIur));
    }   
    
    function tarifPaket(obj){
        var tarifPaket = unformatNumber($('#SAPaketpelayananM_tarifpaketpel').val());
        var tarifAsuransi = unformatNumber($('#SAPaketpelayananM_subsidiasuransi').val());
        var tarifRs = unformatNumber($('#SAPaketpelayananM_subsidirumahsakit').val());
        
        totalIur = Math.round(tarifPaket - (tarifAsuransi + tarifRs));
        totalIur2 = 0;
            var tPaket = unformatNumber($(obj).parent().parent().find('.tarifpaket').val());
            var tAsuransi = unformatNumber($(obj).parent().parent().find('.subisidiAsuransi').val());
            var tRs = unformatNumber($(obj).parent().parent().find('.subisidiRS').val());
            
            total = Math.round(tPaket - (tAsuransi + tRs));
            totalIur2 = total;
            
        $(obj).parent().parent().find('.iurBiaya').val(formatNumber(totalIur2));
        hitungAll();
    }
    
    function tarifAsuransi(obj){
        var tarifPaket = unformatNumber($('#SAPaketpelayananM_tarifpaketpel').val());
        var tarifAsuransi = unformatNumber($('#SAPaketpelayananM_subsidiasuransi').val());
        var tarifRs = unformatNumber($('#SAPaketpelayananM_subsidirumahsakit').val());
        
        totalIur = Math.round(tarifPaket - (tarifAsuransi + tarifRs));
        totalIur2 = 0;
            var tPaket = unformatNumber($(obj).parent().parent().find('.tarifpaket').val());
            var tAsuransi = unformatNumber($(obj).parent().parent().find('.subisidiAsuransi').val());
            var tRs = unformatNumber($(obj).parent().parent().find('.subisidiRS').val());
        total = Math.round(tPaket - (tAsuransi + tRs));
        totalIur2 = total;
            
        $(obj).parent().parent().find('.iurBiaya').val(formatNumber(totalIur2));
        hitungAll();
    }
    
    function tarifRs(obj){
        var tarifPaket = unformatNumber($('#SAPaketpelayananM_tarifpaketpel').val());
        var tarifAsuransi = unformatNumber($('#SAPaketpelayananM_subsidiasuransi').val());
        var tarifRs = unformatNumber($('#SAPaketpelayananM_subsidirumahsakit').val());
        
        totalIur = Math.round(tarifPaket - (tarifAsuransi + tarifRs));
        totalIur2 = 0;
            var tPaket = unformatNumber($(obj).parent().parent().find('.tarifpaket').val());
            var tAsuransi = unformatNumber($(obj).parent().parent().find('.subisidiAsuransi').val());
            var tRs = unformatNumber($(obj).parent().parent().find('.subisidiRS').val());
        total = Math.round(tPaket - (tAsuransi + tRs));
        totalIur2 = total;
            
        $(obj).parent().parent().find('.iurBiaya').val(formatNumber(totalIur2));
        hitungAll();
    }
    
    function hitungAll(){
        var totalPaket = 0;
        var totalAsuransi = 0;
        var totalRs = 0;
        var totalIur = 0;
        $('#tablePaketPelayanan tbody tr').each(function(){
            var tPaket = unformatNumber($(this).find("input[name$='[tarifpaketpel]']").val());
            var tAsuransi = unformatNumber($(this).find("input[name$='[subsidiasuransi]']").val());
            var tRs = unformatNumber($(this).find("input[name$='[subsidirumahsakit]']").val());
            var tIur = unformatNumber($(this).find("input[name$='[iurbiaya]']").val());
            
            totalPaket += tPaket;
            totalAsuransi += tAsuransi;
            totalRs += tRs;
            totalIur += tIur;
//            myAlert(totalPaket);
        });
        $('#SAPaketpelayananM_tarifpaketpel').val(formatNumber(totalPaket));
        $('#SAPaketpelayananM_subsidiasuransi').val(formatNumber(totalAsuransi));
        $('#SAPaketpelayananM_subsidirumahsakit').val(formatNumber(totalRs));
        $('#SAPaketpelayananM_iurbiaya').val(formatNumber(totalIur));
    }    
    hitungAll();
    // END issue EHS-1182
</script>
