<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Jurnal Penerimaan Kas',
    );
    Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');
    ?>
    <?php if (Yii::app()->controller->id == "jurnalPenjualan") { ?>
    <legend class="rim2">Transaksi <b>Posting Jurnal Penjualan</b></legend>
    <?php }else if (Yii::app()->controller->id == "jurnalPelayanan"){ ?>
    <legend class="rim2">Transaksi <b>Posting Jurnal Pelayanan</b></legend>
    <?php }else if (Yii::app()->controller->id == "jurnalPengeluaranKas"){ ?>
    <legend class="rim2">Transaksi <b>Posting Jurnal Pengeluaran Kas</b></legend>
    <?php }else if (Yii::app()->controller->id == "jurnalPenerimaanKas"){ ?>
    <legend class="rim2">Transaksi <b>Posting Jurnal Penerimaan Kas</b></legend>
    <?php }else if (Yii::app()->controller->id == "jurnalPembelian"){ ?>
    <legend class="rim2">Transaksi <b>Posting Jurnal Pembelian</b></legend>
    <?php } else { ?>
	<legend class="rim2">Transaksi <b>Posting Jurnal Umum</b></legend>
	<?php } ?>
    <?php
        echo $this->renderPartial($path_view . '__formSearch', array('model'=>$model));
    ?>

    <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
            array(
                'id'=>'form-grid-jurnal-rek',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array(
                    'onKeyPress'=>'return disableKeyPress(event)'
                ),
                'focus'=>'#',
            )
        );
        echo $this->renderPartial($path_view . '__gridJurnalRekening', array('model'=>$model));
    ?>
    <div class="form-actions">
        <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Posting Jurnal',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
        <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                        $this->createUrl('index'), 
                        array('class'=>'btn btn-danger',
                              'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    </div>

<script type="text/javascript">
    var frmInputRekening = new String(<?php echo CJSON::encode($this->renderPartial($path_view . '__formInputRekening',array('model'=>$model, 'form'=>$form), true));?>);    
    
    function getDataRekening()
    {
        setTimeout(
            function(){
                $('#btn_submit').click();
            }, 1000
        );
    }
    getDataRekening();
    
    $('#form-search-jurnal-rek').submit(function()
    {
		$('#frmGridJurnalRek').addClass("animation-loading");
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getDaftarRekening');?>", {data:$('#form-search-jurnal-rek').serialize()},
            function(data){
                $('#frmGridJurnalRek').find("tbody").empty();
                for(var i=0;i<data.length;i++)
                {
                    $('#frmGridJurnalRek').find("tbody").append(frmInputRekening.replace());
                    $('#daftar-jural-rek-grid').find("textarea[name$='[x][urianjurnal]']").val(data[i].catatan);
                    $('#daftar-jural-rek-grid').find('textarea[name$="[x][urianjurnal]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_urianjurnal');
                    $('#daftar-jural-rek-grid').find('textarea[name$="[x][urianjurnal]"]').attr('name', 'AKJurnalrekeningT['+ i +'][urianjurnal]');
                    /*
                    $('#daftar-jural-rek-grid').find("td[name$='[x][saldodebit]']").text(data[i].saldodebit);
                    $('#daftar-jural-rek-grid').find('td[name$="[x][saldodebit]"]').attr('name', 'AKJurnalrekeningT['+ i +'][saldodebit]');
                    
                    $('#daftar-jural-rek-grid').find("td[name$='[x][saldokredit]']").text(data[i].saldokredit);
                    $('#daftar-jural-rek-grid').find('td[name$="[x][saldokredit]"]').attr('name', 'AKJurnalrekeningT['+ i +'][saldokredit]');
                    */
                   
                    $('#daftar-jural-rek-grid').find("input[name$='[x][saldodebit]']").val(data[i].saldodebit);
                    $('#daftar-jural-rek-grid').find('input[name$="[x][saldodebit]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_saldodebit]');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][saldodebit]"]').attr('name', 'AKJurnalrekeningT['+ i +'][saldodebit]');
                    
                    $('#daftar-jural-rek-grid').find("input[name$='[x][saldokredit]']").val(data[i].saldokredit);
                    $('#daftar-jural-rek-grid').find('input[name$="[x][saldokredit]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_saldokredit]');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][saldokredit]"]').attr('name', 'AKJurnalrekeningT['+ i +'][saldokredit]');
                    
                    $('#daftar-jural-rek-grid').find("td[name$='[x][tglbuktijurnal]']").text(data[i].tglbuktijurnal);
                    $('#daftar-jural-rek-grid').find('td[name$="[x][tglbuktijurnal]"]').attr('name', 'AKJurnalrekeningT['+ i +'][tglbuktijurnal]');
                    
                    $('#daftar-jural-rek-grid').find("span[name$='[x][nobuktijurnal]']").text(data[i].nobuktijurnal);
                    $('#daftar-jural-rek-grid').find('span[name$="[x][nobuktijurnal]"]').attr('name', 'AKJurnalrekeningT['+ i +'][nobuktijurnal]');
                    
                    $('#daftar-jural-rek-grid').find("td[name$='[x][kodejurnal]']").text(data[i].kodejurnal);
                    $('#daftar-jural-rek-grid').find('td[name$="[x][kodejurnal]"]').attr('name', 'AKJurnalrekeningT['+ i +'][kodejurnal]');
                    
                    $('#daftar-jural-rek-grid').find("td[name$='[x][urianjurnal]']").text(data[i].urianjurnal);
                    $('#daftar-jural-rek-grid').find('td[name$="[x][urianjurnal]"]').attr('name', 'AKJurnalrekeningT['+ i +'][urianjurnal]');

                    $('#daftar-jural-rek-grid').find("td[name$='[x][kode_rekening]']").text(data[i].kode_rekening);
                    $('#daftar-jural-rek-grid').find('td[name$="[x][kode_rekening]"]').attr('name', 'AKJurnalrekeningT['+ i +'][kode_rekening]');
                    
                    /*
                    $('#daftar-jural-rek-grid').find("td[name$='[x][saldo_normal]']").text(data[i].saldo_normal);
                    $('#daftar-jural-rek-grid').find('td[name$="[x][saldo_normal]"]').attr('name', 'AKJurnalrekeningT['+ i +'][saldo_normal]');
                    */

                    $('#daftar-jural-rek-grid').find("input[name$='[x][jurnalrekening_id]']").val(data[i].jurnalrekening_id);
                    $('#daftar-jural-rek-grid').find('input[name$="[x][jurnalrekening_id]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_jurnalrekening_id]');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][jurnalrekening_id]"]').attr('name', 'AKJurnalrekeningT['+ i +'][jurnalrekening_id]');
                    
                    var nm_rekening_temp = data[i].nama_rekening;
                    var jns_rekening = "Debit";
                    if(data[i].saldodebit == 0)
                    {
                        nm_rekening_temp = "        " + data[i].nama_rekening;
                        var jns_rekening = "Kredit";
                    }                    
                    
                    $('#daftar-jural-rek-grid').find("input[name$='[x][rekening_nama]']").val(nm_rekening_temp);
                    $('#daftar-jural-rek-grid').find('input[name$="[x][rekening_nama]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_rekening_nama');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][rekening_nama]"]').attr('name', 'AKJurnalrekeningT['+ i +'][rekening_nama]');
                    
                    $('#daftar-jural-rek-grid').find("input[name$='[x][jurnaldetail_id]']").val(data[i].jurnaldetail_id);
                    $('#daftar-jural-rek-grid').find('input[name$="[x][jurnaldetail_id]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_jurnaldetail_id');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][jurnaldetail_id]"]').attr('name', 'AKJurnalrekeningT['+ i +'][jurnaldetail_id]');
                    
                    $('#daftar-jural-rek-grid').find("input[name$='[x][rekening1_id]']").val(data[i].rekening1_id);
                    $('#daftar-jural-rek-grid').find('input[name$="[x][rekening1_id]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_rekening1_id');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][rekening1_id]"]').attr('name', 'AKJurnalrekeningT['+ i +'][rekening1_id]');
                    
                    $('#daftar-jural-rek-grid').find("input[name$='[x][rekening2_id]']").val(data[i].rekening2_id);
                    $('#daftar-jural-rek-grid').find('input[name$="[x][rekening2_id]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_rekening2_id');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][rekening2_id]"]').attr('name', 'AKJurnalrekeningT['+ i +'][rekening2_id]');                    

                    $('#daftar-jural-rek-grid').find("input[name$='[x][rekening3_id]']").val(data[i].rekening3_id);
                    $('#daftar-jural-rek-grid').find('input[name$="[x][rekening3_id]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_rekening3_id');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][rekening3_id]"]').attr('name', 'AKJurnalrekeningT['+ i +'][rekening3_id]');                    

                    $('#daftar-jural-rek-grid').find("input[name$='[x][rekening4_id]']").val(data[i].rekening4_id);
                    $('#daftar-jural-rek-grid').find('input[name$="[x][rekening4_id]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_rekening4_id');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][rekening4_id]"]').attr('name', 'AKJurnalrekeningT['+ i +'][rekening4_id]');                    

                    $('#daftar-jural-rek-grid').find("input[name$='[x][rekening5_id]']").val(data[i].rekening5_id);
                    $('#daftar-jural-rek-grid').find('input[name$="[x][rekening5_id]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_rekening5_id');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][rekening5_id]"]').attr('name', 'AKJurnalrekeningT['+ i +'][rekening5_id]');
                    
//                    $('#daftar-jural-rek-grid').find('input[name$="[x][is_checked]"]').val(data[i].jurnalrekening_id);
                    $('#daftar-jural-rek-grid').find('input[name$="[x][is_checked]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_is_checked');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][is_checked]"]').attr('name', 'AKJurnalrekeningT['+ i +'][is_checked]');
                    
                    jQuery('#AKJurnalrekeningT_'+ i +'_rekening_nama').autocomplete(
                        {
                            'showAnim':'fold',
                            'minLength':2,
                            'focus':function( event, ui ){return false;},
                            'select':function( event, ui ){
                                $(this).val(ui.item.value);
                                $(this).parents("tr").find('input[name$="[rekening1_id]"]').val(ui.item.struktur_id);
                                $(this).parents("tr").find('input[name$="[rekening2_id]"]').val(ui.item.kelompok_id);
                                $(this).parents("tr").find('input[name$="[rekening3_id]"]').val(ui.item.jenis_id);
                                $(this).parents("tr").find('input[name$="[rekening4_id]"]').val(ui.item.obyek_id);
                                $(this).parents("tr").find('input[name$="[rekening5_id]"]').val(ui.item.rincianobyek_id);
                                $(this).parents("tr").find('td[name$="[kode_rekening]"]').val(ui.item.label);
                                return false;
                            },
                            'source':'/ehospitaljk/index.php?r=ActionAutoComplete/rekeningAkuntansi&id_jenis_rek=' + jns_rekening
                        }
                    );
                }
				$('#frmGridJurnalRek').removeClass("animation-loading");
            }, "json"
        );
        return false;
    });
    
    $('#btn_resset').click(function()
    {
        getDataRekening();
    });
    
    $('#form-grid-jurnal-rek').submit(
        function(){
            $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/simpanJurnalPosting');?>", {data:$(this).serialize()},
                function(data){
                    if(data.status == 'ok')
                    {
                        $('#frmGridJurnalRek').find("tbody").empty();
                        $('#btn_submit').click();
                        myAlert("simpan data berhasil");
                    }else{
                        myAlert("data gagal di simpan");
                    }
                },
                'json'
            );
            return false;
        }
    );
        
    $('#btn_reset_grid').click(
        function()
        {
            window.location.reload();
        }
    ); 
    
    
    function checkAll()
    {
        if ($("#checkAllObat").is(":checked"))
        {
            $('#daftar-jural-rek-grid input[name*="is_checked"]').each(
                function(){
                    $(this).attr('checked',true);
                }
            );
        } else {
            $('#daftar-jural-rek-grid input[name*="is_checked"]').each(
                function(){
                    $(this).removeAttr('checked');
                }
            );
        }
    }
    
    function checkRekening(obj)
    {
        var jurnalrekening_id = $(obj).parents("tr").find("input[name$='[jurnalrekening_id]']").val();        
        if($(obj).is(":checked"))
        {
            $('#daftar-jural-rek-grid').find('input[name$="[jurnalrekening_id]"][value="'+ jurnalrekening_id +'"]').each(
                function(){
                    $(this).parents("tr").find("input[name$='[is_checked]']").attr('checked',true);
                }
            );
        }else{
            $('#daftar-jural-rek-grid').find('input[name$="[jurnalrekening_id]"][value="'+ jurnalrekening_id +'"]').each(
                function(){
                    $(this).parents("tr").find("input[name$='[is_checked]']").attr('checked',false);
                }
            );            
        }

    }    
    
    
</script>



<?php
    $this->endWidget();
?>