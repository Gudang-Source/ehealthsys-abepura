<div class="white-container">
    <legend class="rim2">Informasi <b>Realisasi Lembur</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Rencana Lembur'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
            (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>'Informasi Realisasi Lembur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('realisasi-lembur-t-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="block-tabel">
        <h6>Tabel <b>Realisasi Lembur</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'realisasi-lembur-t-grid',
            'dataProvider'=>$modRealisasiLembur->searchInformasiRealisasiLembur(),
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    array(
                            'name'=>'no',
                            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
                            'header'=>'No.',
                            'filter'=>false,
                    ),		
                    array(
                            'name'=>'tglrealisasi',
                            'value'=>'date("d M Y H:i:s",strtotime($data->tglrealisasi))',
                    ),
                    array(
                            'name'=>'norealisasi',
                            'value'=>'$data->norealisasi',
                    ),

                    array(
                            'name'=>'mengetahui_nama',
                            'header'=>'Mengetahui',
                            'value'=>'$data->getPegawaiAttributes($data->mengetahui_id,\'nama_pegawai\')',
                            'filter'=>false,
                    ),
                    array(
                            'name'=>'menyetujui_nama',
                            'header'=>'Menyetujui',
                            'value'=>'$data->getPegawaiAttributes($data->menyetujui_id,\'nama_pegawai\')',
                            //'value'=>'$data->menyetujui_id',
                            'filter'=>false,
                    ),
                    array(
                            'name'=>'pemberitugas_nama',
                            'header'=>'Pemberi Tugas',
                            'value'=>'$data->getPegawaiAttributes($data->pemberitugas_id,\'nama_pegawai\')',
                            'filter'=>false,
                    ),
                    array(
                            'header'=>'Rincian',
                            'type'=>'raw',
                            'value'=>'CHtml::link("<i class=\'icon-form-detail\'></i>",Yii::app()->controller->createUrl(Yii::app()->controller->id."/lihatdetail",
                            array("norealisasi"=>$data->norealisasi)),
                            array("title"=>"Klik Untuk Lihat Rincian","target"=>"iframeLihatDetail", "onclick"=>"$(\'#dialogLihatDetail\').dialog(\'open\')"))', //'CHtml::link("<i class=\'icon-search\'></i>",Yii::app()->controller->createUrl(Yii::app()->controller->id."/update",array("id"=>$data->pegawai_id)),array("title"=>"Klik Untuk Pindah Kamar","target"=>"iframeLihatDetail", "onclick"=>"$(\"#dialogLihatDetail\").dialog(\"open\");", "rel"=>"tooltip"))',
                            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                     ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    </div>
<?php 
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#realisasi-lembur-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>

<?php
//============================ Dialog Lihat Detail =============================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogLihatDetail',
    'options'=>array(
        'title'=>'Lihat Rincian Realisasi Lembur',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'resizable'=>false,
    ),
));
echo '<iframe src="" name="iframeLihatDetail" width="100%" height="400"></iframe>';
$this->endWidget();

//==============================================================================
?>
    <fieldset class="box">
        <legend class="rim"><i class="icon-white icon-search"></i> Pencarian</legend>
    <div class="search-form" style="display:true">
        <?php $this->renderPartial('_search',array(
                'modRealisasiLembur'=>$modRealisasiLembur,
        )); ?>
    </div>
    </fieldset>
</div>