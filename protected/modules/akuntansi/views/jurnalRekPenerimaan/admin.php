<fieldset class = "box">
    <legend class="rim">Pengaturan Jurnal Rekening Penerimaan</legend>
<!--<div class='white-container'>
    <legend class='rim2'>Pengaturan Jurnal <b>Rekening Penerimaan</b></legend>-->
    <?php
    $this->breadcrumbs=array(
            'Jenispenerimaan Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jurnal Rek Penerimaan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jurnal Rek Penerimaan ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#AKJnsPenerimaanRekM_jenispenerimaan_kode').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('jenispenerimaan-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); 
	//$this->renderPartial('_tabMenuPenerimaan',array());
	?>
    <!--<div class="biru">
        <div class="white">-->
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut3 search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
            <!--<div class="block-tabel">-->
                <!--<h6>Tabel Jurnal <b>Rekening Penerimaan</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
                    'id'=>'jenispenerimaan-m-grid',
                    'dataProvider'=>$model->searchJenisPenerimaan(),
                    'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                            array(
                                    'header'=>'No',
                                    'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                            ),
                            array(
                                    'header'=>'Kode',
                                    'name'=>'jenispenerimaan_kode',
                                    'value'=>'$data->jenispenerimaan_kode',
                            ),
                            array(
                                    'header'=>'Jenis Penerimaan',
                                    'name'=>'jenispenerimaan_nama',
                                    'value'=>'$data->jenispenerimaan_nama',
                            ), /*
                            array(
                                    'header'=>'Nama Lain',
                                    'name'=>'jenispenerimaan_namalain',
                                    'value'=>'$data->jenispenerimaan_namalain',
                            ), */
                            array(
                                    'header'=>'Rekening Debit',
                                    //'name'=>'rekeningdebit_id',
                                    'type'=>'raw',
                                    'value'=>function($data)
                                    {
                                        $r = JnspenerimaanrekM::model()->findAllByAttributes(array(
                                            'jenispenerimaan_id' => $data->jenispenerimaan_id,
                                            'debitkredit'=>'D'
                                        ));
                                        $str = "<ul>";
                                        
                                        if (count($r) == 0) return "-";
                                        foreach ($r as $item) {
                                            $r5 = Rekening5M::model()->findByPk($item->rekening5_id);
                                            $str .= "<li>".$r5->nmrekening5."</li>";
                                        }
                                        
                                        $str .= "</ul>";
                                        return $str;
                                    }
                                    //'value'=>'$this->grid->owner->renderPartial("_rekPenerimaanD",array("saldonormal"=>"D","jenispenerimaan_id"=>$data->jenispenerimaan_id),true)',
                            ),
                            array(
                                    'header'=>'Rekening Kredit',
                                    //'name'=>'rekeningkredit_id',
                                    'type'=>'raw',
                                    'value'=>function($data)
                                    {
                                        $r = JnspenerimaanrekM::model()->findAllByAttributes(array(
                                            'jenispenerimaan_id' => $data->jenispenerimaan_id,
                                            'debitkredit'=>'K'
                                        ));
                                        $str = "<ul>";
                                        
                                        if (count($r) == 0) return "-";
                                        foreach ($r as $item) {
                                            $r5 = Rekening5M::model()->findByPk($item->rekening5_id);
                                            $str .= "<li>".$r5->nmrekening5."</li>";
                                        }
                                        
                                        $str .= "</ul>";
                                        return $str;
                                    }
                                    //'value'=>'$this->grid->owner->renderPartial("_rekPenerimaanK",array("saldonormal"=>"K","jenispenerimaan_id"=>$data->jenispenerimaan_id),true)',
                            ),
                            array(
                                    'header'=>'Status',
                                    'value'=>'($data->jenispenerimaan_aktif = 1 ) ? "Aktif" : "Tidak Aktif" ',
                            ),
                            array(
                                    'header'=>Yii::t('zii','View'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array(
                                            'view' => array (
                                                            'label'=>"<i class='icon-view'></i>",
                                                            'options'=>array('title'=>Yii::t('mds','View')),
                                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->jenispenerimaan_id"))',                                               
                                            ),
                                    ),
                            ),
                            array(
                                    'header'=>Yii::t('zii','Update'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{update}',
                                    'buttons'=>array(
                                            'view' => array (
                                                            'label'=>"<i class='icon-update'></i>",
                                                            'options'=>array('title'=>Yii::t('mds','Update')),
                                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>"$data->jenispenerimaan_id"))',                                               
                                            ),
                                    ),
                            ),
                            array(
                                    'header'=>Yii::t('zii','Delete'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{delete}',
                                    'buttons'=>array(
                                            'delete' => array (
                                                    'label'=>"<i class='icon-delete'></i>",
                                                    'options'=>array('title'=>Yii::t('mds','Delete')),
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->jenispenerimaan_id"))',               
                                            ),
                                    )
                            ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){
                            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                            $("table").find("input[type=text]").each(function(){
                                cekForm(this);
                            });
                            $("table").find("select").each(function(){
                                cekForm(this);
                            });
                        }',
                )); ?>
            <!--</div>-->
        <!--</div>
    </div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Jurnal Rekening Penerimaan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('akuntansi.views.tips.master2',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#jenispenerimaan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#jenispenerimaan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>
</div>
<?php 
// Dialog buat lihat penjualan resep =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogUbahRekeningDebitKredit',
    'options'=>array(
        'title'=>'Ubah Data Rekening',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>800,
        'minHeight'=>400,
        'resizable'=>false,
        'close'=>'js:function(){$.fn.yiiGridView.update(\'jenispenerimaan-m-grid\', {})}'
    ),
));
?>
<iframe src="" name="iframeEditRekeningDebitKredit" width="100%" height="300" >
</iframe>
<?php $this->endWidget(); ?>
