<!--<div class="white-container">
    <legend class="rim2">Pengaturan <b>Lokasi Gudang</b></legend>
    <div class="biru">
        <div class="white">-->
            <?php
            $this->breadcrumbs=array(
                    'Gflokasi Gudang Ms'=>array('index'),
                    'Manage',
            );

            $arrMenu = array();
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Lokasi Gudang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
            //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Lokasi Gudang', 'icon'=>'list', 'url'=>array('index'))) ;
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Lokasi Gudang', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

            $this->menu=$arrMenu;

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#GFLokasiGudangM_lokasigudang_nama').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('gflokasi-gudang-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");

            $this->widget('bootstrap.widgets.BootAlert'); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut search-form" style="display:none">
                <?php $this->renderPartial($this->path_view.'_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
            <!--<div class="block-tabel">-->
                <!--<h6>Tabel <b>Lokasi Gudang</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'gflokasi-gudang-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                            ////'lokasigudang_id',
                            array(
                                    'name'=>'lokasigudang_id',
                                    'value'=>'$data->lokasigudang_id',
                                    'filter'=>false,
                            ),
                            array(
                                    'name'=>'lokasigudang_nama',
                                    'value'=>'$data->lokasigudang_nama',
                                    'filter'=>  CHtml::activeTextField($model,'lokasigudang_nama'),
                            ),
                            'lokasigudang_namalain',
                            array(
                                'header'=>'Lokasi Gudang',
                                'name'=>'lokasigudang_farmasi',
                                'value'=>'($data->lokasigudang_farmasi == 1 ) ? "Ya" : "Tidak"',
                                'htmlOptions'=>array('style'=>'text-align:center;'),
            //                    'class'=>'CCheckBoxColumn',     
            //                    'selectableRows'=>0,
            //                    'id'=>'rows',
            //                    'checked'=>'$data->lokasigudang_farmasi',
                            ), 
                             array(
                                'header'=>'<center>Status</center>',
                                'value'=>'($data->lokasigudang_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions'=>array('style'=>'text-align:center;'),
                            ),
            //                 array(
            //                        'header'=>'Aktif',
            //                        'name'=>'lokasigudang_aktif',
            //                        'class'=>'CCheckBoxColumn',     
            //                        'selectableRows'=>0,
            //                        'id'=>'rows',
            //                        'checked'=>'$data->lokasigudang_aktif',
            //                ), 
                            array(
                                    'header'=>Yii::t('zii','View'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array(
                                        'view'=>array(
                                            'options'=>array('rel'=>'tooltip','title'=>'Lihat Lokasi Gudang'),
                                        ),
                                    ),
                            ),
                            array(
                                    'header'=>Yii::t('zii','Update'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{update}',
                                    'buttons'=>array(
                                        'update' => array (
                                                      'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                                      'options'=>array('rel'=>'tooltip','title'=>'Ubah Lokasi Gudang'),
                                                    ),
                                     ),
                            ),
                            array(
                                'header'=>'Hapus',
                                'type'=>'raw',
                                'value'=>'($data->lokasigudang_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->lokasigudang_id)",array("id"=>"$data->lokasigudang_id","rel"=>"tooltip","title"=>"Menonaktifkan Lokasi Gudang"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->lokasigudang_id)",array("id"=>"$data->lokasigudang_id","rel"=>"tooltip","title"=>"Hapus Lokasi Gudang")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->lokasigudang_id)",array("id"=>"$data->lokasigudang_id","rel"=>"tooltip","title"=>"Hapus Lokasi Gudang"));',
                                'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                            ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){
                        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                        $("table").find("input[type=text]").each(function(){
                            cekForm(this);
                        })
                    }',
                )); ?>
            <!--</div>-->
<!--        </div>
    </div>-->
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Lokasi Gudang', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial($this->path_view.'tips/tipsCreateUpdate',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));         
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#gflokasi-gudang-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gflokasi-gudang-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
<!--</div>-->
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',
        function(r){
            if(r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('gflokasi-gudang-m-grid');
                            }else{
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                },"json");
            }
        }); 

    }
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?','Perhatian!',
        function(r){
            if(r){
                $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('gflokasi-gudang-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
            }
        }); 
    }
    $('.filters #GFLokasiGudangM_lokasigudang_nama').focus();
</script>