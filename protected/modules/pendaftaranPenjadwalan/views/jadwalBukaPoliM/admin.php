<div class="white-container">
    <legend class="rim2">Pengaturan Jadwal <b>Buka Poli</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Ppjadwal Buka Poli Ms'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            $('#PPJadwalBukaPoliM_ruangan_id').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('ppjadwal-buka-poli-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php 

    echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="search-form cari-lanjut2" style="display:none">
    <?php $this->renderPartial('_search',array(
            'model'=>$model,
    )); ?>
    </div><!-- search-form -->
    <!--<legend class="rim">Tabel Jadwal Buka Poli</legend>-->
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'ppjadwal-buka-poli-m-grid',
            'dataProvider'=>$model->searchMasterPP(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    ////'jadwalbukapoli_id',
                    array(
                            'name'=>'jadwalbukapoli_id',
                            'value'=>'$data->jadwalbukapoli_id',
                            'filter'=>false,
                    ),
                    array(
                            'name'=>'ruangan_id',
                            'value'=>'$data->ruangan->ruangan_nama',
                            'filter'=>CHtml::listData($model->getRuanganItems(), 'ruangan_id', 'ruangan_nama'),
                    ),
                    'hari',
                    'jmabuka',
            array(
                    'name'=>'jammulai',
                    'value'=>'$data->jammulai',
                    'filter'=>false,
            ),
            array(
                    'name'=>'jamtutup',
                    'value'=>'$data->jamtutup',
                    'filter'=>false,
            ),
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view' => array(
                                    'options'=>array('rel'=>'tooltip','title'=>'Lihat Jadwal Buka Poli')
                                ),
                             ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                'update' => array(
                                    'options'=>array('rel'=>'tooltip','title'=>'Ubah Jadwal Buka Poli')
                                ),
                             ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Delete'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>' {delete}',
                            'buttons'=>array(
    //                                        'remove' => array (
    //                                                'label'=>"<i class='icon-remove'></i>",
    //                                                'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
    //                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->jadwalbukapoli_id"))',
    //                                                'visible'=>'($data->kabupaten_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
    //                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
    //                                        ),
                                            'delete'=> array(
                                                'options'=>array('rel'=>'tooltip','title'=>'Hapus Jadwal Buka Poli')
                                            ),
                            )
                    ),
            ),
           'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
    )); ?>
    <?php
    /*
    <table>
        <tr>
            <td width="12%"><?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
                <div class="search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                    'model'=>$model,
                )); ?>
                </div><!-- search-form --></td>
            <td width="16%"><?php echo CHtml::link(Yii::t('mds', '{icon} Tambah Jadwal Buka Poli', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/pendaftaranPenjadwalan/jadwalBukaPoliM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?></td>
            <td width="8%"><?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
            'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
            'buttons'=>array(
                array('label'=>'Print', 'icon'=>'icon-print icon-white', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
                array('label'=>'', 'items'=>array(
                    array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
                    array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
                    array('label'=>'Grafik','icon'=>'icon-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'GRAFIK\')')),
                )),       
            ),
    //        'htmlOptions'=>array('class'=>'btn')
            ));?>
            </td>
            <td><?php $content = $this->renderPartial('../tips/master',array(),true);
                $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
                $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller); ?>   </td>
        </tr>
    </table>
    */?>

    <?php 
            echo CHtml::link(Yii::t('mds', '{icon} Tambah Jadwal Buka Poli', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/pendaftaranPenjadwalan/jadwalBukaPoliM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
            echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master2',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        
$js = <<< JSCRIPT
           function cekForm(obj)
{
    $("#ppjadwal-buka-poli-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ppjadwal-buka-poli-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
</div>