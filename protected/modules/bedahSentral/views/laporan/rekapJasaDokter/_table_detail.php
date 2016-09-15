<?php
$rim = '';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchDetailJasaDokter();
$template = "{summary}\n{items}\n{pager}";
$sort = true;
if (isset($caraPrint)) {
    $sort = false;
    $data = $model->searchPrintDetailJasaDokter();
    $rim = '';
    $template = "{items}";
    if ($caraPrint == "EXCEL")
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('laporandetailjasadokter-grid', {
            data: $(this).serialize()
    });
    return false;
});
");

?>
<?php
$format = new MyFormatter();
$this->renderPartial('rekapJasaDokter/_search', array(
    'model' => $model, 'format' => $format
));
?>
<div id="div_detail">
    <div style="<?php echo $rim; ?>">
        <?php
        if (isset($caraPrint)) {
            $dataDetail = $model->searchPrintDetailJasaDokter();
        } else {
            $dataDetail = $model->searchDetailJasaDokter();
        }
    ?>
        <div class="block-tabel">
            <h6>Table Rekap <b>Detail Jasa Dokter</b></h6>
            <?php
                $this->widget($table, array(
                    'id' => 'laporandetailjasadokter-grid',
                    'dataProvider' => $dataDetail,
                    'enableSorting' => $sort,
                    'template' => $template,
                    'itemsCssClass' => 'table table-striped table-condensed',
                    'mergeHeaders' => array(
						/*
                        array(
                            'name' => '<center>Dokter</center>',
                            'start' => 7, //indeks kolom 3
                            'end' => 9, //indeks kolom 4
                        ), */
                        array(
                            'name' => '<center>Bedah</center>',
                            'start' => 11, //indeks kolom 3
                            'end' => 13, //indeks kolom 4
                        ),
                    ),
                    'columns' => array(
                        array(
                            'header' => 'No',
                            'value' => '$row+1'
                        ),
                        array(
                            'header' => 'Tanggal Transaksi',
                            'type' => 'raw',
                            'value' => 'date("d/m/Y",strtotime($data->tgl_pendaftaran))',
                        ),
                        array(
                            'header' => 'No. Rekam Medik',
                            'type' => 'raw',
                            'value' => '$data->no_rekam_medik',
                        ),
                        array(
                            'header' => 'Nama Lengkap',
                            'type' => 'raw',
                            'value' => '$data->nama_pasien',
                        ),
                        array(
                            'header' => 'Unit Pelayanan',
                            'type' => 'raw',
                            'value' => '$data->instalasi_nama',
                        ),
                        array(
                            'header' => 'Nama Ruangan',
                            'type' => 'raw',
                            'value' => '$data->ruangan_nama',
                        ),
                        array(
                            'header' => 'Jumlah',
                            'type' => 'raw',
                            'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_qty",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ), /*
                        array(
                            'header' => 'Gelar Depan',
                            'type' => 'raw',
                            'value' => '',
                        ), */
                        array(
                            'header' => 'Dokter',
                            'type' => 'raw',
                            'value' => '(empty($data->gelardepan) ? "-" : "$data->gelardepan" ).(empty($data->nama_pegawai) ? "-" : "$data->nama_pegawai" ).", ".(empty($data->gelarbelakang_nama) ? "" : ", $data->gelarbelakang_nama" )',
                        ), /*
                        array(
                            'header' => 'Gelar Belakang',
                            'type' => 'raw',
                            'value' => '(empty($data->gelarbelakang_nama) ? "" : "$data->gelarbelakang_nama" )',
                        ), */
                        array(
                            'header' => 'Visite',
                            'type' => 'raw',
                            'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifVisit",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Konsul',
                            'type' => 'raw',
                            'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifKonsul",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Tindakan',
                            'type' => 'raw',
                            'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifTindakan",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Jasa Operator',
                            'type' => 'raw',
                            'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifOperator",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Sewa Alat',
                            'type' => 'raw',
                            'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifSewaAlat",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Alat Bahan',
                            'type' => 'raw',
                            'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifAlatBahan",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                        array(
                            'header' => 'Total',
                            'type' => 'raw',
                            'value' => '$this->grid->owner->renderPartial("bedahSentral.views.laporan/jasaDokter/_tarifTotal",array("pendaftaran_id"=>"$data->pendaftaran_id","ruangan_id"=>"$data->ruangan_id","tgl_pendaftaran"=>"$data->tgl_pendaftaran"),true)',
                            'htmlOptions' => array('style' => 'text-align:right;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
            ?>
        </div>
    </div>
</div>
<div class="block-tabel">
        <?php //$this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
<div class="form-actions">
    <?php
	$url = Yii::app()->createUrl('bedahSentral/laporan/frameGrafikLaporanPendapatan&id=1');
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
	$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
	$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanDetailRekapJasaDokter');
	$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url, 'tips'=>'10besarpenyakit','grafik'=>'none'));
	?>
</div>
 
<?php
$filterruangan = in_array(Yii::app()->user->getState('instalasi_id'), array(Params::INSTALASI_ID_IBS))?1:'';
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint+"&filterruangan=${filterruangan}","",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?> 
<?php
Yii::app()->clientScript->registerScript('test', '
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj){
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    $.fn.yiiGridView.update("tableLaporan", {
            data: $(this).serialize()
    });
    $("#Grafik").attr("src","' . $url . '"+$(".search-form form").serialize());
    return false;
}
', CClientScript::POS_HEAD);
?>