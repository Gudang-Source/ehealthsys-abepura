<div class="white-container">
    <legend class="rim2">Pengaturan <b>Tarif Ambulans</b></legend>
    <?php //$this->renderPartial('_tabMenu',array()); ?>
    <!--<div class="biru">
        <div class="white">-->
            <?php
            $daftartindakan_nama = CHtml::activeId($model,'daftartindakan_nama');
            $this->breadcrumbs=array(
                    'Satarifambulans Ms'=>array('index'),
                    'Manage',
            );
            $arrMenu = array();
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tarif Ambulans ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
            //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tarif Ambulans', 'icon'=>'list', 'url'=>array('index'))) ;
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tarif Ambulans', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

            $this->menu=$arrMenu;

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                    $('#${daftartindakan_nama}').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('tarif-ambulans-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");

            $this->widget('bootstrap.widgets.BootAlert'); ?>

            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut3 search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
            <!--<div class="block-tabel">-->
                <!--<h6>Tabel <b>Tarif Ambulans</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'tarif-ambulans-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'template'=>"{summary}\n{items}\n{pager}",
                    'columns'=>array(
                        array(
                            'header'=>'ID',
                            'value'=>'$data->tarifambulans_id',
                        ),
                        array(
                            'name'=>'daftartindakan_id',
                            'filter'=> CHtml::dropDownList('TarifAmbulansM[daftartindakan_id]',$model->daftartindakan_id,CHtml::listData($model->getDaftartindakanItems(),'daftartindakan_id','daftartindakan_nama'),array('empty'=>'--Pilih--')),
                            'value'=>'(isset($data->daftartindakan->daftartindakan_nama) ? $data->daftartindakan->daftartindakan_nama : "")',
                        ),
                        'tarifambulans_kode',
                        //'kepropinsi_nama',                        
                        array(
                            'header' => 'Ke Propinsi',
                            'name' => 'kepropinsi_nama',
                            'filter' => CHtml::dropDownList('TarifAmbulansM[kepropinsi_nama]',$model->kepropinsi_nama,CHtml::listData(PropinsiM::model()->findAll("propinsi_aktif = TRUE ORDER BY propinsi_nama ASC"),'propinsi_nama','propinsi_nama'),array('empty'=>'--Pilih--')),
                        ),
                        //'kekabupaten_nama',                         
                        array(
                            'header' => 'Ke Kabupaten',
                            'name' => 'kekabupaten_nama',
                            'filter' => CHtml::dropDownList('TarifAmbulansM[kekabupaten_nama]',$model->kekabupaten_nama,CHtml::listData(KabupatenM::model()->findAll("kabupaten_aktif = TRUE ORDER BY kabupaten_nama ASC"),'kabupaten_nama','kabupaten_nama'),array('empty'=>'--Pilih--')),
                        ),
                        //'kekecamatan_nama',
                        array(
                            'header' => 'Ke Kecamatan',
                            'name' => 'kekecamatan_nama',
                            'filter' => CHtml::dropDownList('TarifAmbulansM[kekecamatan_nama]',$model->kekecamatan_nama,CHtml::listData(KecamatanM::model()->findAll("kecamatan_aktif = TRUE ORDER BY kecamatan_nama ASC"),'kecamatan_nama','kecamatan_nama'),array('empty'=>'--Pilih--')),
                        ),
                        //'kekelurahan_nama',
                        array(
                            'header' => 'Ke Kelurahan',
                            'name' => 'kekelurahan_nama',
                            'filter' => CHtml::dropDownList('TarifAmbulansM[kekelurahan_nama]',$model->kekelurahan_nama,CHtml::listData(KelurahanM::model()->findAll("kelurahan_aktif = TRUE ORDER BY kelurahan_nama ASC"),'kelurahan_nama','kelurahan_nama'),array('empty'=>'--Pilih--')),
                        ),
                        'tarifambulans',
                        array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(                            
                                        'view'=>array(
                                            'options'=>array('rel'=>'tooltip','title'=>'Lihat Tarif Ambulans'),
                                        ),
                                    ),
                        ),
                        array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(                            
                                        'update'=>array(
                                            'options'=>array('rel'=>'tooltip','title'=>'Ubah Tarif Ambulans'),
                                        ),
                                    )
                        ),
                        array(
                            'header'=>'Hapus',
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{delete}',
                            'buttons'=>array(                            
                                        'delete'=>array(
                                            'options'=>array('rel'=>'tooltip','title'=>'Hapus Tarif Ambulans'),
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
            <!--</div>-->
        <!--</div>
    </div>-->
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai        

    echo CHtml::link(Yii::t('mds', '{icon} Tambah Tarif Ambulans', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl($controller.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')')).""; 
    echo "&nbsp;";
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')')).""; 
    echo "&nbsp;";
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')')).""; 
    echo "&nbsp;";
    $content = $this->renderPartial('../tips/master2',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
        
         function cekForm(obj)
{
    $("#tarifambulance-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
        
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#tarifambulance-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script>
    $('.filters').find("select[name$='daftartindakan_id']").focus();
</script>