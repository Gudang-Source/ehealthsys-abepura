<div class="white-container">
    <legend class="rim2">Informasi <b>Pemakaian Ambulans</b></legend>
    <?php
        Yii::app()->clientScript->registerScript('search', "
        $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('pemakaianambulans-t-grid', {
                data: $(this).serialize()
            });
            return false;
        });
        "); 
    ?>
    <div class="block-tabel">
        <h6>Tabel <b>Pemakaian Ambulans</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'pemakaianambulans-t-grid',
            'dataProvider'=>$model->searchPemakaian(),
            //'filter'=>$modPemakaian,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                'no_rekam_medik',
                'pemakai_nama',
                'nama_pasien',
                'tempattujuan',
                'alamattujuan',
                array(
                    'header'=>'No. Mobile / Telepon',
                    'value'=>'$data->nomobile." / ".$data->notelepon',
                ),
                array(
                    'header'=>$model->getAttributeLabel('supir_id'),
                    'value'=>'$data->supir_nama',
                ),
                array(
                    'header'=>'Paramedis',
                    'value'=>'(isset($data->paramedis1_nama) ? $data->paramedis1_nama : "")." | ".(isset($data->paramedis2_nama) ? $data->paramedis2_nama : "")',
                ),
                array(
                    'header'=>'Km Awal / Km Akhir',
                    'value'=> 'number_format($data->kmawal)."/".number_format($data->kmakhir)',
                    'filter'=>false,
                ),
                array(
                    'name'=>'jumlahkm',
                    'value'=>'number_format($data->jumlahkm)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'name'=>'tarifperkm',
                    'value'=>'number_format($data->tarifperkm)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'name'=>'totaltarifambulans',
                    'value'=>'number_format($data->totaltarifambulans)',
                    'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
                ),
                array(
                    'name'=>'tglkembaliambulans',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->tglkembaliambulans)',
                ),
                array(
                    'header'=>'Lihat Detail',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-lihat\"></i>",Yii::app()->controller->createUrl("'.Yii::app()->controller->id.'/view",array("pemakaianambulans_id"=>$data->pemakaianambulans_id)),
                                           array("target"=>"iframepemakaian", "onclick"=>"$(\"#detail-pemakaian\").dialog(\"open\");",
                                                 "class"=>"btn-small"))',
                    'htmlOptions'=>array('style'=>'text-align:left;'),
                ),
                array(
                    'header'=>'Batal Pakai',
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=\"icon-form-silang\"></i>","javascript:void(0)",
                                           array("onclick"=>"batalPakai(\'$data->pemakaianambulans_id\',\'$data->pesanambulans_t\')",
                                                 "class"=>"btn-small"))',
                    'htmlOptions'=>array('style'=>'text-align:left;'),
                )
            ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?> 
    </div>
    <fieldset class="box">
        <?php $this->renderPartial('_searchPemakaian',array('model'=>$model,'format'=>$format)); ?>
    </fieldset>
<script type="text/javascript">
function batalPakai(pemakaian_id,pemesanan_id)
{
    myConfirm("Anda yakin akan membatalkan pemakaian ambulans?","Perhatian!",function(r){
        if(r){
            $.post('<?php echo $this->createUrl('batalPakai'); ?>', {pemakaian_id:pemakaian_id,pemesanan_id:pemesanan_id}, function(data){
                if(data.status == 'berhasil'){
                    $.fn.yiiGridView.update('pemakaianambulans-t-grid', {
                        data: $(this).serialize()
                    });
                    myAlert('Data berhasil dibatalkan');
                    return false;
                }else{
                    myAlert('Data gagal disimpan')
                }
            }, 'json');
        }
    });
}
</script>

<?php 
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'detail-pemakaian',
    'options'=>array(
        'title'=>'Detail Pemakaian Ambulans',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>800,
        'minHeight'=>200,
        'resizable'=>false,
    ),
)); ?>
<iframe src="" name="iframepemakaian" width="100%" height="500">
</iframe>
<?php $this->endWidget();?>