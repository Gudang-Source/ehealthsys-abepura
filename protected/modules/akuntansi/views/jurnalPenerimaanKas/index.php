<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form2.js', CClientScript::POS_END); ?>


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

	
	
	
<?php
//========= Dialog buat cari data Rek Debit =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogRek',
    'options'=>array(
        'title'=>'Daftar Rekening',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>1000,
        'height'=>700,
        'resizable'=>false,
    ),
));


$modRekDebit = new RekeningakuntansiV('searchAccounts');
$modRekDebit->unsetAttributes();
// $modRekDebit->rekening5_nb = $account;
$modRekDebit->rekening5_aktif = true;
if(isset($_GET['RekeningakuntansiV'])) {
    $modRekDebit->attributes = $_GET['RekeningakuntansiV'];
	// $modRekDebit->rekening5_nb = $account;
}

$c2 = new CDbCriteria();
$c3 = new CDbCriteria();
$c4 = new CDbCriteria();


$c2->compare('rekening1_id', $modRekDebit->rekening1_id);
$c2->addCondition('rekening2_aktif = true');
$c2->order = 'kdrekening2';

$r2 = Rekening2M::model()->findAll($c2);

$c3->compare('rekening2_id', $modRekDebit->rekening2_id);
$c3->addCondition('rekening3_aktif = true');
$c3->order = 'kdrekening3';

$r3 = Rekening3M::model()->findAll($c3);

$c4->compare('rekening3_id', $modRekDebit->rekening3_id);
$c4->addCondition('rekening4_aktif = true');
$c4->order = 'kdrekening4';

$r4 = Rekening4M::model()->findAll($c4);

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
	'id'=>'rekdebit-m-grid',
        //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
	'dataProvider'=>$modRekDebit->searchAccounts(),
	'filter'=>$modRekDebit,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectRekDebit",
                                    "onClick" =>"            
												pilihDialogRekening(".CJSON::encode($data->attributes).");
                                                $(\"#dialogRek\").dialog(\"close\");    
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
                        'filter'=>CHtml::activeDropDownList($modRekDebit, 'kelrekening_id', CHtml::listData(
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
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening1_id', 
                        CHtml::listData(Rekening1M::model()->findAll(array(
                            'condition'=>'rekening1_aktif = true',
                            'order'=>'kdrekening1 asc',
                        )), 'rekening1_id', 'nmrekening1'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Unsur',
                        'name'=>'rekening2_id',
                        'value'=>'$data->nmrekening2',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening2_id', 
                        CHtml::listData($r2, 'rekening2_id', 'nmrekening2'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Kelompok Pos',
                        'name'=>'rekening3_id',
                        'value'=>'$data->nmrekening3',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening3_id', 
                        CHtml::listData($r3, 'rekening3_id', 'nmrekening3'), array('empty'=>'-- Pilih --')),
                ),
                array(
                        'header'=>'Pos',
                        'name'=>'rekening4_id',
                        'value'=>'$data->nmrekening4',
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening4_id', 
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
                        'filter'=>  CHtml::activeDropDownList($modRekDebit, 'rekening5_nb', array('D'=>'Debit', 'K'=>'Kredit'), array('empty'=>"-- Pilih --")),
                ),
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end Rek Debit dialog =============================
?>
	
	
	
	
	
<script type="text/javascript">
    var frmInputRekening = new String(<?php echo CJSON::encode($this->renderPartial($path_view . '__formInputRekening',array('model'=>$model, 'form'=>$form), true));?>);    
    
	var cur_id;
	
	function ubahRekening(obj) {
		cur_id = $(obj).parents("tr").index();
		$("#dialogRek").dialog("open");
	}
	
    function getDataRekening()
    {
        setTimeout(
            function(){
                $('#btn_submit').click();
            }, 1000
        );
    }
	
	function pilihDialogRekening(data) {
		var obj = $("#daftar-jural-rek-grid > tbody > tr").eq(cur_id);
		console.log(obj);
		$(obj).find(".rek1").val(data.rekening1_id);
		$(obj).find(".rek2").val(data.rekening2_id);
		$(obj).find(".rek3").val(data.rekening3_id);
		$(obj).find(".rek4").val(data.rekening4_id);
		$(obj).find(".rek5").val(data.rekening5_id);
		
		$(obj).find(".nama5").val(data.nmrekening5);
		$(obj).find(".kode5").html(data.kdrekening5);
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
                   
                    $('#daftar-jural-rek-grid').find("input[name$='[x][saldodebit]']").val(formatNumber(data[i].saldodebit));
                    $('#daftar-jural-rek-grid').find('input[name$="[x][saldodebit]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_saldodebit]');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][saldodebit]"]').attr('name', 'AKJurnalrekeningT['+ i +'][saldodebit]');
                    
                    $('#daftar-jural-rek-grid').find("input[name$='[x][saldokredit]']").val(formatNumber(data[i].saldokredit));
                    $('#daftar-jural-rek-grid').find('input[name$="[x][saldokredit]"]').attr('id', 'AKJurnalrekeningT_'+ i +'_saldokredit]');
                    $('#daftar-jural-rek-grid').find('input[name$="[x][saldokredit]"]').attr('name', 'AKJurnalrekeningT['+ i +'][saldokredit]');
                    
                    $('#daftar-jural-rek-grid').find("td[name$='[x][tglbuktijurnal]']").text(data[i].tglbuktijurnalform);
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
                        nm_rekening_temp = data[i].nama_rekening;
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
				
				$(".integer2").maskMoney(
					{"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":0}
				);
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
	
	
	$(".alphanum").keyup(function() {
		$(this).val($(this).val().replace(/[^a-zA-Z0-9]/gi, ''));
	});
    
    
</script>



<?php
    $this->endWidget();
?>