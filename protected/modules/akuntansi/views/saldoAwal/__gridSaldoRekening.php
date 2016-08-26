<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<!--<div class='block-tabel'>-->
    <!--<h6>Daftar <b>Saldo Rekening</b></h6>-->
    <div style="max-width:100%;">
        <?php
            $this->widget('ext.bootstrap.widgets.BootGridView',
                array(
                    'id'=>'grid-saldo-rekening',
                    'dataProvider'=>$model->searchByFilter(),
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                        array(
                          'header'=>'No.',
                          'type'=>'raw',
                          'value'=>'$row+1',
                          'htmlOptions'=>array('style'=>'width:20px')
                        ),
                        array(
                           'header'=>'Kode Rekening',
                           'type'=>'raw',
                           'value'=>'$data->getKodeRekening()',
                           'htmlOptions'=>array('style'=>'text-align: center; width:50px;')
                        ),
                        /** RND-8419
						array(
                           'name'=>'kdstruktur',
                           'type'=>'raw',
                           'value'=>'$data->kdstruktur',
                           'htmlOptions'=>array('style'=>'text-align: center; width:50px;')
                        ),
                        array(
                           'name'=>'kdkelompok',
                           'type'=>'raw',
                           'value'=>'$data->kdkelompok',
                           'htmlOptions'=>array('style'=>'text-align: center; width:50px')
                        ),
                        array(
                           'name'=>'kdjenis',
                           'type'=>'raw',
                           'value'=>'($data->kdjenis == null ? "-" : $data->kdjenis)',
                           'htmlOptions'=>array('style'=>'text-align: center; width:50px')
                        ),
                        array(
                           'name'=>'kdobyek',
                           'type'=>'raw',
                           'value'=>'($data->kdobyek == null ? "-" : $data->kdobyek)',
                           'htmlOptions'=>array('style'=>'text-align: center; width:50px')
                        ),
                        array(
                           'name'=>'kdrincianobyek',
                           'type'=>'raw',
                            'value'=>'($data->kdrincianobyek == null ? "-" : $data->kdrincianobyek)',
                           'htmlOptions'=>array('style'=>'text-align: center; width:80px')
                        ),
						 
						*/
                        array(
                           'header'=>'Nama Rekening',
                           'type'=>'raw',
//                           'value'=>'(isset($data->nmrincianobyek) ? $data->nmrincianobyek : (isset($data->nmobyek) ? $data->nmobyek : (isset($data->nmjenis) ? $data->nmjenis : (isset($data->nmkelompok) ? $data->nmkelompok : (isset($data->nmstruktur) ? $data->nmstruktur : "-")))))',
                           'value'=>'$data->getNamaRekening()',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),  
						                    
                        /*
                        array(
                           'name'=>'nmstruktur',
                           'type'=>'raw',
                           'value'=>'isset($data->nmstruktur) ? $data->nmstruktur : "-"',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),
                        array(
                           'name'=>'nmkelompok',
                           'type'=>'raw',
                           'value'=>'isset($data->nmkelompok) ? $data->nmkelompok : "-"',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),
                        array(
                           'name'=>'nmjenis',
                           'type'=>'raw',
                           'value'=>'isset($data->nmjenis) ? $data->nmjenis : "-"',
                           'htmlOptions'=>array('style'=>'width:80px')
                        ),
                        array(
                           'name'=>'nmobyek',
                           'type'=>'raw',
                           'value'=>'isset($data->nmobyek) ? $data->nmobyek : "-"',
                        ),
                        array(
                           'name'=>'nmrincianobyek',
                           'type'=>'raw',
                           'value'=>'isset($data->nmrincianobyek) ? $data->nmrincianobyek : "-"',
                        ),
                        array(
                           'name'=>'rincianobyek_nb',
                           'type'=>'raw',
                            'value'=>'($data->rincianobyek_nb == null ? "-" : ($data->rincianobyek_nb == "D" ? "Debit" : "Kredit"))',
                        ),
                        array(
                           'name'=>'kelompokrek',
                           'type'=>'raw',
                            'value'=>'($data->kelompokrek == null ? "-" : $data->kelompokrek)',
                        ),
                         * 
                         */
                        'matauang',
                        array(
                            'header' => 'Jumlah Anggaran',
                            'value' => 'number_format($data->jmlanggaran,0,"",".")',
                            'htmlOptions' => array('style'=>'text-align:right;')
                        ),                        
                        array(
                            'header' => 'Jumlah Saldo Awal (Debit)',
                            'value' => 'number_format($data->jmlsaldoawald,0,"",".")',
                            'htmlOptions' => array('style'=>'text-align:right;')
                        ),
                        array(
                            'header' => 'Jumlah Saldo Awal (Kredit)',
                            'value' => 'number_format($data->jmlsaldoawalk,0,"",".")',
                            'htmlOptions' => array('style'=>'text-align:right;')
                        ),
                         array(
                            'header' => 'Jumlah Mutasi (Debit)',
                            'value' => 'number_format($data->jmlmutasid,0,"",".")',
                             'htmlOptions' => array('style'=>'text-align:right;')
                        ),
                         array(
                            'header' => 'Jumlah Mutasi (Kredit)',
                            'value' => 'number_format($data->jmlmutasik,0,"",".")',
                             'htmlOptions' => array('style'=>'text-align:right;')
                        ),
                        array(
                            'header' => 'Jumlah Saldo Akhir (Debit)',
                            'value' => 'number_format($data->jmlsaldoakhird,0,"",".")',
                            'htmlOptions' => array('style'=>'text-align:right;')
                        ),
                        array(
                            'header' => 'Jumlah Saldo Akhir (Kredit)',
                            'value' => 'number_format($data->jmlsaldoakhirk,0,"",".")',
                            'htmlOptions' => array('style'=>'text-align:right;')
                        ),
						array(
                           'name'=>'Periode Rekening',
                           'type'=>'raw',
                            'value'=>'$data->getNamaRekPeriod($data->rekperiod_id)',
                        ),
						'periodeposting_nama',
                        array(
                           'header'=>'&nbsp;',
                           'type'=>'raw',
                           'value'=>'CHtml::Link("<i class=\'icon-form-ubah\'></i>", Yii::app()->controller->createUrl("SaldoAwal/editSaldoRekening",array("id"=>$data->saldoawal_id)),array("value"=>$data->saldoawal_id, "onclick"=>"editSaldoJenisRek(this);return false;","rel"=>"tooltip", "title"=>"Klik Untuk Edit<br>Saldo Rekening",))',
                        )
                    ),
                    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )
            );
        ?>
    </div>
<!--</div>-->
<?php 
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
?>
<?php
        $content = $this->renderPartial('../tips/master4',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        
        
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#penjaminpasien-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', 
    array(
        'id' => 'dialogEditSaldoRekening',
        'options' => array(
            'title' => 'Edit Saldo Rekening',
            'autoOpen' => false,
            'modal' => true,
            'width' => 550,
            'height' => 300,
            'resizable' => false,
            'close'=>'js:function(){$.fn.yiiGridView.update(\'grid-saldo-rekening\', {});}'
        ),
    )
);
?>
<div id="pop_up_content"></div>
<?php
    $this->endWidget();
?>

<script type="text/javascript">
    
</script>