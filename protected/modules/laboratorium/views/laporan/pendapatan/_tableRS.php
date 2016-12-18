<?php 

    $table = 'ext.bootstrap.widgets.HeaderGroupGridViewNonRp';
    $sort = true;
    if (isset($caraPrint)){
        $data = $model->searchPrintLaporan();
        $template = "{items}";
        $sort = false;
        if ($caraPrint == "EXCEL")
            $table = 'ext.bootstrap.widgets.BootExcelGridView';
    } else{
        $data = $model->searchTableLaporan();
         $template = "{summary}\n{items}\n{pager}";
    }
?>
<?php 
    $this->renderPartial('pendapatan/_search',array(
    'model'=>$model,
    )); 
?>
<div id="div_rs">
    <?php if(isset($caraPrint)){ 
        
    }else{ ?>
    <div class="block-tabel">
        <h6>Tabel Pendapatan Ruangan <b>Laboratorium - Dari RS</b></h6>
        <?php } ?>
        <?php $this->widget($table,array(
            'id'=>'tablePendapatanRS',
            'dataProvider'=>$data,
                    'template'=>$template,
                    'enableSorting'=>$sort,
                    'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                        'header' => 'No',
                        'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                        'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                    ),
                    array(
                        'header'=>'No Pendaftaran',
                        'type'=>'raw',
                        'value'=>'$data->no_pendaftaran',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    ),
                    array(
                        'header'=>'Nama Pasien',
                        'type'=>'raw',
                        'value'=>'$data->namadepan." ".$data->nama_pasien',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                    ),
                    array(
                        'header'=>'Kedatangan',
                        'type'=>'raw',
                        //'value'=>'(empty($data->rujukan_id) ? "Rumah Sakit" : $data->asalrujukan_nama)',
                        'value' => function($data){
                            if (empty($data->rujukan_id)){
                                return 'Rumah Sakit';
                            }else{
                                $r = RujukanT::model()->findByPk($data->rujukan_id);
                                
                                if (count($r)>0){
                                    return $r->nama_perujuk;
                                }
                            }
                        },
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                        'footerHtmlOptions'=>array('colspan'=>4,'style'=>'text-align:right;font-style:italic;'),
                        'footer'=>'Jumlah Total',
                    ),
                    array(
                        'header'=>'Pend. Seharusnya',
                        'type'=>'raw',
                        'name'=>'pend_seharusnya',
                        'value'=>'number_format($data->pend_seharusnya,0,",",".")',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footer'=>'sum(pend_seharusnya)',
                    ),
                    array(
                        'header'=>'Pend. Sebenarnya',
                        'type'=>'raw',
                        'name'=>'pend_sebenarnya',
                        'value'=>'number_format($data->pend_sebenarnya,0,",",".")',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footer'=>'sum(pend_sebenarnya)',
                    ),
                    array(
                        'header'=>'Sisa',
                        'type'=>'raw',
                        'name'=>'sisa',
                        'value'=>'number_format($data->sisa,0,",",".")',
                        'headerHtmlOptions'=>array('style'=>'text-align:center'),
                        'htmlOptions'=>array('style'=>'text-align:right;'),
                        'footerHtmlOptions'=>array('style'=>'text-align:right;'),
                        'footer'=>'sum(sisa)',
                    ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
</div>

<div class="block-tabel">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
<?php 
$url = Yii::app()->createUrl('laboratorium/laporan/frameGrafikLaporanPendapatan&id=1');
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanPendapatanRS');
//$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url));
?>
<div class="form-actions">
   <?php
	echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";     
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp";     
        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'))."&nbsp&nbsp";     
	
     $tips = array(
        '0' => 'tanggal',
        '1' => 'cari',
        '2' => 'ulang2',
        '3' => 'masterPRINT',
        '4' => 'masterEXCEL',
        '5' => 'masterPDF',
        '6' => 'grafik'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips' => $tips),true); 
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  ?>
</div>
<?php 
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#laporan-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$jsx,CClientScript::POS_HEAD);                        
?> 
<?php 
Yii::app()->clientScript->registerScript('test','
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
    $("#Grafik").attr("src","'.$url.'"+$(".search-form form").serialize());
    return false;
}
', CClientScript::POS_HEAD);

?>