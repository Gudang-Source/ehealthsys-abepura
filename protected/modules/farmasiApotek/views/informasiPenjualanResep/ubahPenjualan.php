<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Gfmutasioaruangan Ts'=>array('index'),
            'Create',
    );
    ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js'); ?>
    <?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>

    <?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'penjualanresep-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'focus'=>'#FAPendaftaranT_instalasi_id',
            'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
    ));?>

    <legend class="rim2">Penjualan <b>Resep dan Bebas</b></legend>
    <?php
    if(isset($_GET['sukses'])){
        if($_GET['sukses'] == 1){
            Yii::app()->user->setFlash("success","Data berhasil disimpan!");
        }
    }
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

    <fieldset id="form-antrian">
        <div class="control-group">
            <?php echo CHtml::label('No. Antrian','noantrian',array('class'=>'control-label'));?>
            <div class="controls">
                <?php echo $form->hiddenField($modPenjualan,'antrianfarmasi_id',array('class'=>'antrianfarmasiId'));?>
                <?php echo CHtml::textField('racikan_singkatan',((empty($modAntrian->racikan_id) ? "" : $modAntrian->racikan->racikan_singkatan)),array('readonly'=>true,'class'=>'span1','style'=>'text-align:right;float: left;', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
                <div class="span3" style="float: left;">
                <?php
                    $this->widget('MyJuiAutoComplete',array(
                                'model'=>$modAntrian,
                                'attribute'=>'noantrian',
                                'tombolDialog'=>array('idDialog'=>'dialog-pilihantrian'),
                                'htmlOptions'=>array('value'=>$modAntrian->noantrian,
                                    'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2','style'=>'float:left;',
                                    'onblur'=>'if($(this).val() === "") {$('.CHtml::activeId($modPenjualan, 'antrianfarmasi_id').').val(""); $("#racikan_singkatan").val("");}',
                                    'placeholder'=>'Klik icon =>'
                                    )
                            ));
                ?>
                </div>
            </div>
        </div>
    </fieldset>

    <fieldset id="form-infodokter">
        <!--<legend class="rim"><span class='judul'>Data Pasien </span><span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="icon-refresh icon-white"></i>',array('class'=>'btn btn-danger btn-mini','onclick'=>'setInfoDokterReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan')); ?></span></legend>-->
        <div class="row-fluid">
            <div class = "span12">
                <?php echo $form->hiddenField($modPenjualan,'is_pasien', array('readonly'=>true,'class'=>'span3','onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
                <?php $this->Widget('ext.bootstrap.widgets.BootAccordion',array(
                        'id'=>'form-pasien',
                        'content'=>array(
                            'content-pasien'=>array(
                                'header'=>CHtml::htmlButton("<i class='icon-minus icon-white'></i>",array('class'=>'btn btn-primary btn-mini','onclick'=>'','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengisi data pasien')).'<b> Data Pasien</b>',
                                'isi'=>$this->renderPartial($this->path_view.'_formDataPasien',array(
                                        'form'=>$form,
                                        'modPenjualan'=>$modPenjualan,
                                        'modPasien'=>$modPasien,
                                        ),true),
                                'active'=>$modPenjualan->is_pasien,
                            ),   
                        ),
                )); ?>
            </div>
        </div>
    </fieldset>

    <fieldset class="box" id="form-dataresep">
        <legend class="rim">Data Resep</legend>
        <?php $this->renderPartial($this->path_view.'_formDataResep', array('form'=>$form,'modPenjualan'=>$modPenjualan,'modReseptur'=>$modReseptur)); ?>
    </fieldset>
    <?php $this->renderPartial($this->path_view.'_formInputObat', array('form'=>$form,'racikan'=>$racikan, 'racikanDetail'=>$racikanDetail,'nonRacikan'=>$nonRacikan)); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Obat Alkes</b></h6>
        <table class="items table table-striped table-bordered table-condensed" id="table-obatalkespasien">
            <thead>
                <tr>
                    <!--<th>Resep</th>-->
                    <th>R ke</th>
                    <th>Kode / Nama Obat</th>
                    <th>Sumber Dana</th>
                    <th>Satuan Kecil</th>
                    <th>Jumlah</th>
                    <th>Stok</th>
                    <th>Harga</th>
                    <!--<th>Discount (%)</th>-->
                    <th>Sub Total</th>
                    <th>Signa</th>
                    <th>Etiket</th>
                    <th>Batal</th>
                </tr>
            </thead>
            <tbody>
                <?php
                if(count($obatAlkes) > 0){
                    foreach($obatAlkes AS $key=> $modObatAlkesPasien){
    //                  PERHITUNGAN MASIH SALAH >>  $modObatAlkesPasien->jmlstok = StokobatalkesT::getJumlahStok($modObatAlkesPasien->obatalkes_id);
                        $modObatAlkesPasien->jmlstok = StokobatalkesT::getJumlahStokOaTersimpan($modObatAlkesPasien->obatalkespasien_id);
                        echo $this->renderPartial($this->path_view.'_rowDetail',array('modObatAlkesPasien'=>$modObatAlkesPasien,
                        ));
                    }
                }
                ?>
        </tbody>
        </table>
    </div>
    <div class="row-fluid">
        <div class="span4"></div>
        <div class="span4">
            <?php echo $form->hiddenField($modPenjualan, 'totharganetto',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'totaltarifservice',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'biayaadministrasi',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'biayakonseling',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'pembulatanharga',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'jasadokterresep',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'discount',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'subsidiasuransi',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'subsidipemerintah',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'subsidirs',array('class'=>'integer', 'readonly'=>'true')); ?>
            <?php echo $form->hiddenField($modPenjualan, 'iurbiaya',array('class'=>'integer', 'readonly'=>'true')); ?>
        </div>
        <div class="span4"><?php echo $form->textFieldRow($modPenjualan, 'totalhargajual',array('class'=>'integer', 'readonly'=>'true')); ?></div>
    </div>
        <div class="form-actions">
                <?php 
    //                $disableSave = false;
    //                $disableSave = (!empty($_GET['idPenjualan'])) ? true : ($sukses > 0) ? true : false;; 
                ?>
                <?php // $disablePrint = ($disableSave) ? false : true; ?>
                <?php 
                    echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'cekObat();', 'onkeypress'=>'cekObat();')); //formSubmit(this,event)        
                    //  jika tanpa cek obat
                    /**echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),
                            array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)', 'disabled'=>$disableSave));
                     * 
                     */
                     ?>
                <?php if(!isset($_GET['frame'])){
                    echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl($this->id.'/index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini ?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
                } ?>								
                <?php
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue','type'=>'button','onclick'=>'print(\'PRINT\')'));                 
                ?>
                <?php
    //                $content = $this->renderPartial('tips/tipsPenjualanResepUmum',array(),true);
    //                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                ?>
        </div>
    <?php $this->endWidget(); ?>
</div>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialog-pilihantrian',
    'options'=>array(
        'title'=>'Daftar Antrian',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'minHeight'=>400,
        'resizable'=>false,
    ),
));
?>
<div class="dialog-content">
    <?php 
        $modKarcisTerakhir = new FAAntrianFarmasiT('search');
        $modKarcisTerakhir->unsetAttributes();
        if(isset($_GET['FAAntrianFarmasiT'])){
            $modKarcisTerakhir->attributes = $_GET['FAAntrianFarmasiT'];
        }
        $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'anantrianfarmasi-t-grid',
            'dataProvider'=>$modKarcisTerakhir->searchDialogKarcis(),
            'filter'=>$modKarcisTerakhir,
            'template'=>"{summary}\n{pager}\n{items}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Karcis","class"=>"btn_small",
                        "id"=>"pilihkarcis",
                        "onClick"=>"$(\"#'.CHtml::activeId($modPenjualan,'antrianfarmasi_id').'\").val(\"$data->antrianfarmasi_id\");
                                    $(\"#'.CHtml::activeId($modAntrian,'noantrian').'\").val(\"$data->noantrian\");
                                    $(\"#racikan_singkatan\").val(\"$data->RacikanSingkatan\");
                                    $(\"#dialog-pilihantrian\").dialog(\"close\");
                                    return false;"
                        ))'
                ),

                array(
                    'name'=>'tglambilantrian',
                    'type'=>'raw',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglambilantrian)',
                    'filter'=>false,
                ),
                array(
                    'name'=>'racikan_id',
                    'type'=>'raw',
                    'value'=>'$data->racikan->racikan_nama." (".$data->racikan->racikan_singkatan.")"',
                    'filter'=>$modKarcisTerakhir->getListRacikans(),
                ),
                'noantrian',
                array(
                    'name'=>'panggilantrian',
                    'filter'=> array(1=>'Sudah',0=>'Belum'),
                    'type'=>'raw',
                    'value'=>'($data->panggilantrian) ? "Sudah" : "Belum"',
                ),
                array(
                    'name'=>'antrianlewat',
                    'filter'=> array(1=>'Ya',0=>'Tidak'),
                    'type'=>'raw',
                    'value'=>'($data->antrianlewat) ? "Ya" : "Tidak"',
                ),
                array(
                    'header'=>'Print Karcis',
                    'filter'=> false,
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-print\"></i>","javascript:void(0);",
                            array(
                                  "onclick"=>"printKarcisFarmasi($data->antrianfarmasi_id,\"PRINT\")",
                                  "rel"=>"tooltip",
                                  "title"=>"Klik untuk Membatalkan Pembayaran",
                            ))',
                            'htmlOptions'=>array(
                                'style'=>'text-align: center;'
                            )
                ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>
</div>
<?php $this->endWidget(); ?>
<?php // $this->renderPartial($this->path_view.'_jsFunctions', array('modPenjualan'=>$modPenjualan,'modReseptur'=>$modReseptur)); ?>
<?php // $this->renderPartial($this->path_view_umum.'_jsFunctions', array('modPenjualan'=>$modPenjualan,'modReseptur'=>$modReseptur,'modPasien'=>$modPasien)); ?>
<script type="text/javascript">
/**
 * membatalkan penambahan obat alkes pasien berdasarkan obatalkes_id
 * @param {type} caraPrint
 * @returns {undefined} */
function batalObatAlkesPasienDetail(obj){
    myConfirm('Apakah anda akan membatalkan penjualan obat alkes ini?','Perhatian!',
    function(r){
        if(r){
            var obatalkes_id = $(obj).parents('tr').find('input[name$="[obatalkes_id]"]').val();
            $(obj).parents('tbody').find('input[name$="[obatalkes_id]"][value="'+obatalkes_id+'"]').each(function(){
                $(this).parents('tr').detach();
            });
            hitungTotal();
        }
    }); 
}

/**
* untuk print penjualan dokter
 */
function print(caraPrint)
{
    var penjualanresep_id = '<?php echo isset($modPenjualan->penjualanresep_id) ? $modPenjualan->penjualanresep_id : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penjualanresep_id='+penjualanresep_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

function cekObat(){
    if(requiredCheck($("form"))){
        var jmlObat = $('#table-obatalkespasien tbody tr').length;
        var is_pasien = $("#<?php // echo CHtml::activeId($modPenjualan, "is_pasien"); ?>").val();
        var pasien_id = $("#<?php // echo CHtml::activeId($modPasien, "pasien_id"); ?>").val();
        if(pasien_id == '' && is_pasien == 1){
                myAlert('Pilih data Pasien Apotek terlebih dahulu.');
                return false;
        }
        if(jmlObat <= 0){
                myAlert('Isikan obat alkes rencana kebutuhan terlebih dahulu.');
            return false;
        }else{
            $('#penjualanresep-form').submit();
        }
        
        $(".animation-loading").removeClass("animation-loading");
        $("form").find('.float').each(function(){
            $(this).val(formatFloat($(this).val()));
        });
        $("form").find('.integer').each(function(){
            $(this).val(formatInteger($(this).val()));
        });
    }
    return false;
    
}

function tambahObatNonRacik(obj)
{
    var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    var jumlah = $(obj).parents('fieldset').find('#qtyNonRacik').val();
    var rke = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();
    if(rke==undefined){rke=1;}else{rke++;}
    if(obatalkes_id != '')
    {
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm('Apakah anda akan input ulang obat ini?','Perhatian!',
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
                        }else{
                            tambahkandetail = false;
                        }
                    }); 
                }
                if(tambahkandetail){
                    $('#table-obatalkespasien > tbody').append(data.form);
                    $("#table-obatalkespasien").find('input[name*="[ii]"][class*="integer"]').maskMoney(
                        {"symbol":"","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
                    );
                    addDataKeGridObat(obj,'nonracik',rke);
                    renameInputRowObatAlkes($("#table-obatalkespasien"));                    
                    hitungTotal();
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
        myAlert("Silahkan pilih obat terlebih dahulu!");
    }
    $("#namaObatNonRacik").focus();   
}

function tambahObatRacik(obj)
{
    var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
    var jumlah = $(obj).parents('fieldset').find('#qtyRacik').val();
    var rke = $(obj).parents('fieldset').find('#racikanKe').val();
    var rkelast = $("#table-obatalkespasien tbody tr:last-child td").find('input[name*="[rke]"]').val();

    var indexrke = 0;
    var jmlrke = 0;
    var marginrke = 0;
    var statusmargin = 0;
    
    if(obatalkes_id != '')
    {
        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('setFormObatAlkesPasien'); ?>',
            data: {obatalkes_id:obatalkes_id,jumlah:jumlah},//
            dataType: "json",
            success:function(data){
                if(data.pesan !== ""){
                    myAlert(data.pesan);
                    return false;
                }
                var tambahkandetail = true;
                var obatalkesyangsama = $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']");
                if(obatalkesyangsama.val()){ //jika ada obat sudah ada di table
                    myConfirm('Apakah anda akan input ulang obat ini?','Perhatian!',
                    function(r){
                        if(r){
                            $("#table-obatalkespasien input[name$='[obatalkes_id]'][value='"+obatalkes_id+"']").each(function(){
                                $(this).parents('tr').detach();
                            });
                        }else{
                            tambahkandetail = false;
                        }
                    }); 

                }
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
}

function addDataKeGridObat(obj,tipe,rke){
    if(tipe=='racik'){
        var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
        var signa = $(obj).parents('fieldset').find('#signa_racik').val();
        var permintaan = $(obj).parents('fieldset').find('#permintaan').val();
        var kemasan = $(obj).parents('fieldset').find('#jmlKemasanObat').val();
        var kekuatan = $(obj).parents('fieldset').find('#kekuatanObat').val();
        input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        input_signa.val(signa);
        input_permintaan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][permintaan_oa]"]');
        input_permintaan.val(permintaan);
        input_kemasan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][jmlkemasan_oa]"]');
        input_kemasan.val(kemasan);
        input_kekuatan = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][kekuatan_oa]"]');
        input_kekuatan.val(kekuatan);

        input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);
    }else{
        var obatalkes_id = $(obj).parents('fieldset').find('#obatalkes_id').val();
        var signa = $(obj).parents('fieldset').find('#signa').val();
        input_signa = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][signa_oa]"]');
        input_signa.val(signa);
        
        input_rke = $("#table-obatalkespasien").find('input[name*="[ii]"][value*="'+obatalkes_id+'"]').parents('tr').find('input[name*="[ii][rke]"]');
        input_rke.val(rke);

    }
}

/**
* rename input grid
*/ 
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

/**
 * set form info pasien
 * @returns {undefined}
 */
function setInfoPasien(pendaftaran_id, no_pendaftaran, no_rekam_medik, pasienadmisi_id){
    $("#form-infopasien > div").addClass("animation-loading");
    var instalasi_id = $("#instalasi_id").val();
    $.ajax({
        type:'POST',
        url:'<?php echo $this->createUrl('GetDataInfoPasien'); ?>',
        data: {instalasi_id:instalasi_id, pendaftaran_id:pendaftaran_id, no_pendaftaran:no_pendaftaran, no_rekam_medik:no_rekam_medik, pasienadmisi_id:pasienadmisi_id},
        dataType: "json",
        success:function(data){
            $("#cari_pendaftaran_id").val(data.pendaftaran_id);
            $("#pendaftaran_id").val(data.pendaftaran_id);
            $("#pasien_id").val(data.pasien_id);
            $("#pasienadmisi_id").val(data.pasienadmisi_id);
            $("#jeniskasuspenyakit_id").val(data.jeniskasuspenyakit_id);
            $("#carabayar_id").val(data.carabayar_id);
            $("#penjamin_id").val(data.penjamin_id);
            $("#penanggungjawab_id").val(data.penanggungjawab_id);
            $("#kelaspelayanan_id").val(data.kelaspelayanan_id);
            $("#ruangan_id").val(data.ruangan_id);
            $("#no_pendaftaran").val(data.no_pendaftaran);
            $("#tgl_pendaftaran").val(data.tgl_pendaftaran);
            $("#ruangan_nama").val(data.ruangan_nama);
            $("#jeniskasuspenyakit_nama").val(data.jeniskasuspenyakit_nama);
            $("#carabayar_nama").val(data.carabayar_nama);
            $("#penjamin_nama").val(data.penjamin_nama);
            $("#no_rekam_medik").val(data.no_rekam_medik);
            $("#namadepan").val(data.namadepan);
            $("#nama_pasien").val(data.nama_pasien);
            $("#nama_bin").val(data.nama_bin);
            $("#tanggal_lahir").val(data.tanggal_lahir);
            $("#umur").val(data.umur);
            $("#jeniskelamin").val(data.jeniskelamin);
            $("#nama_pj").val(data.nama_pj);
            $("#pengantar").val(data.pengantar);
            $("#kelaspelayanan_nama").val(data.kelaspelayanan_nama);
            $("#alamat_pasien").val(data.alamat_pasien);
            if(data.photopasien === null || data.photopasien === ""){ //set photo
                $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
            }else{
                $('#photo-preview').attr('src','<?php echo Params::urlPasienTumbsDirectory()."kecil_"?>'+data.photopasien);
            }
            
            $("#form-infopasien > legend > .judul").html('Data Pasien '+data.no_pendaftaran);
            $("#form-infopasien > legend > .tombol").attr('style','display:true;');
            $("#form-infopasien > .box").addClass("well").removeClass("box");
            
            $("#form-infopasien > div").removeClass("animation-loading");
            $("#nama_pasien").focus();
        },
        error: function (jqXHR, textStatus, errorThrown) { 
            myAlert("Data kunjungan tidak ditemukan !"); 
            console.log(errorThrown);
            setInfoPasienReset();
            $("#form-infopasien > div").removeClass("animation-loading");
            $("#instalasi_id").focus();
        }
    });
}
/**
 * reset form info pasien
 * @returns {undefined}
 */
function setInfoPasienReset(){
    $("#cari_pendaftaran_id").val("");
    $("#pendaftaran_id").val("");
    $("#pasien_id").val("");
    $("#pasienadmisi_id").val("");
    $("#jeniskasuspenyakit_id").val("");
    $("#carabayar_id").val("");
    $("#penjamin_id").val("");
    $("#penanggungjawab_id").val("");
    $("#kelaspelayanan_id").val("");
    $("#ruangan_id").val("");
    $("#no_pendaftaran").val("");
    $("#tgl_pendaftaran").val("");
    $("#ruangan_nama").val("");
    $("#jeniskasuspenyakit_nama").val("");
    $("#carabayar_nama").val("");
    $("#penjamin_nama").val("");
    $("#no_rekam_medik").val("");
    $("#namadepan").val("");
    $("#nama_pasien").val("");
    $("#nama_bin").val("");
    $("#tanggal_lahir").val("");
    $("#umur").val("");
    $("#jeniskelamin").val("");
    $("#nama_pj").val("");
    $("#pengantar").val("");
    $("#kelaspelayanan_nama").val("");
    $("#alamat_pasien").val("");
    $('#photo-preview').attr('src','<?php echo Params::urlPhotoPasienDirectory()."no_photo.jpeg"?>');
    $("#form-infopasien > legend > .judul").html('Data Pasien');
    $("#form-infopasien > legend > .tombol").attr('style','display:none;');
    $("#form-infopasien > .well").addClass("box").removeClass("well");
}
/**
 * refresh dialog kunjungan
 * @returns {undefined}
 */
function refreshDialogInfoPasien(){
    var instalasi_id = $("#instalasi_id").val();
    var instalasi_nama = $("#instalasi_id option:selected").text();
    $.fn.yiiGridView.update('datakunjungan-grid', {
        data: {
            "FAPasienM[idInstalasi]":instalasi_id,
            // "FAPasienM[instalasi_nama]":instalasi_nama,
        }
    });
}

function hitungSubTotal(obj){
    unformatNumberSemua();
    harga = parseInt($(obj).parents('tr').find('input[name$="[hargasatuan_oa]"]').val());
    qty = parseInt($(obj).parents('tr').find('input[name$="[qty_oa]"]').val());
    diskon = parseInt($(obj).parents('tr').find('input[name$="[discount]"]').val());
    
    totaliurbiaya = ((harga*qty) - ((harga*qty) * (diskon/100)));
    iurbiaya = $(obj).parents('tr').find('input[name$="[iurbiaya]"]');
        
    subtotal = $(obj).parents('tr').find('input[name$="[hargajual_oa]"]');
    totalsubtotal = ((harga*qty) - ((harga*qty) * (diskon/100)));
    if(totaliurbiaya <=0 ){
        totaliurbiaya = 0;
    }
    
    if(totalsubtotal <= 0){
        totalsubtotal = 0;
    }
    
    subtotal.val(totalsubtotal);
    iurbiaya.val(totaliurbiaya);
    
    hitungTotal();
    formatNumberSemua();
}

function hitungTotal(){
    unformatNumberSemua();
    obj_totalharganetto =  $('#<?php echo CHtml::activeId($modPenjualan,"totharganetto") ?>');
    obj_totalhargajual =  $('#<?php echo CHtml::activeId($modPenjualan,"totalhargajual") ?>');
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

/**
 * menghapus obat alkes pasien yang sudah tersimpan di ObatalkespasienT
 * berdasarkan obatalkespasien_id
 */ 
function hapusObatAlkesPasienDetail(obatalkespasien_id)
{
    myConfirm('Apakah anda akan menghapus obat ini?','Perhatian!',
    function(r){
        if(r){
                $.ajax({
                type:'POST',
                url:'<?php echo $this->createUrl('hapusObatAlkesPasien'); ?>',
                data: {obatalkespasien_id:obatalkespasien_id},
                dataType: "json",
                success:function(data){
                    if(data.sukses){
                        var delete_row = $("#table-obatalkespasien").find('input[name$="[obatalkespasien_id]"][value="'+obatalkespasien_id+'"]').parents('tr');
                        delete_row.detach();
                        renameInputRowObatAlkes($("#table-obatalkespasien"));
                    }
                    myAlert(data.pesan);
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
            renameInputRowObatAlkes($("#table-obatalkespasien"));
        }
    }); 
}


/**
 * class integer di unformat 
 * @returns {undefined}
 */
function unformatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(parseInt(unformatNumber($(this).val())));
    });
}
/**
 * class integer di format kembali
 * @returns {undefined}
 */
function formatNumberSemua(){
    $(".integer").each(function(){
        $(this).val(formatInteger($(this).val()));
    });
}

$(document).ready(function(){
    hitungTotal();
});
</script>