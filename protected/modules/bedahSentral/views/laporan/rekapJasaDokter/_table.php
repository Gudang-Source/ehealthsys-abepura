<?php
$itemCssClass = 'table table-striped table-condensed';
$rim = 'max-width:1300px;overflow-x:scroll;';
$table = 'ext.bootstrap.widgets.HeaderGroupGridView';
$data = $model->searchJasaDokter();
$template = "{summary}\n{items}\n{pager}";
$row = '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1';
$sort = true;
if (isset($caraPrint)) {
	$row = '$row+1';
    $sort = false;
    $data = $model->searchPrintJasaDokter();
    $rim = '';
    $template = "{items}";
    if ($caraPrint == "EXCEL"){
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
	
	if ($caraPrint=='PDF') {
            $table = 'ext.bootstrap.widgets.BootGridViewPDF';
        }
  
        echo "
        <style>
            .border th, .border td{
                border:1px solid #000;
            }
            .table thead:first-child{
                border-top:1px solid #000;        
            }

            thead th{
                background:none;
                color:#333;
            }

            .border {
                box-shadow:none;
                border-spacing:0px;
                padding:0px;
            }

            .table tbody tr:hover td, .table tbody tr:hover th {
                background-color: none;
            }
        </style>";
        $itemCssClass = 'table border';
}

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('laporanrekapjasadokter-grid', {
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
<div id="div_rekap">
    <div style="<?php echo $rim; ?>">
        <?php
        if (isset($caraPrint)) {
            $dataDetail = $model->searchPrintJasaDokter();
        } else {
            $dataDetail = $model->searchJasaDokter();
        }
        ?>
        <div class="block-tabel">
            <h6>Table Rekap <b>Jasa Dokter</b></h6>
            <?php
            $this->widget($table, array(
                'id' => 'laporanrekapjasadokter-grid',
                'dataProvider' => $dataDetail,
                'enableSorting' => $sort,
                'template' => $template,
                'itemsCssClass' => $itemCssClass,
                'columns' => array(
                    array(
                        'header' => 'No.',
                        'value' => $row
                    ),
                    array(
                        'header' => 'Tanggal Pendaftaran/ No Pendaftaran',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)."/ <br/>".$data->no_pendaftaran',
                    ),
                    array(
                        'header' => 'No. Rekam Medis',
                        'type' => 'raw',
                        'value' => '$data->no_rekam_medik',
                    ),
                    array(
                        'header' => 'Nama Pasien',
                        'type' => 'raw',
                        'value' => '$data->namadepan." ".$data->nama_pasien',
                    ),
                    array(
                        'header' => 'Kelas Pelayanan',
                        'type' => 'raw',
                        'value' => '$data->kelaspelayanan_nama',
                    ),
                    array(
                        'header' => 'Nama Tindakan',
                        'type' => 'raw',
                        'value' => '$data->daftartindakan_nama',
                    ),
					array(
                        'header' => 'Nama Dokter',
                        'type' => 'raw',
                        'value' => '$data->gelardepan." ".$data->nama_pegawai." ".$data->gelarbelakang_nama',
                    ),
                    array(
                        'header' => 'Tanggal Keluar',
                        'type' => 'raw',
                        'value' => '(isset($data->tgl_keluar) ?MyFormatter::formatDateTimeForUser($data->tgl_keluar) : "-")',
                    ),                   
                    array(
                        'header' => 'Jasa Pelayanan',
                        'type' => 'raw',
                        'value' => 'MyFormatter::formatNumberForPrint($data->tarif_tindakankomp)',
						'htmlOptions' => array('style' => 'text-align:right;'),
					),
					array(
						'header' => 'Instalasi/ <br/>Ruangan',
						'type' => 'raw',
						'value' => '$data->instalasi_nama."/<br/>".$data->ruangan_nama'
					),
                    
                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
            ));
            ?>
        </div>
    </div>
</div>


<div class="form-actions">
    <?php
	$url = Yii::app()->createUrl('bedahSentral/laporan/frameGrafikLaporanPendapatan&id=1');
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
	$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
	$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanRekapJasaDokter');
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