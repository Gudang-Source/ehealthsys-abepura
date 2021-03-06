<fieldset class="box">
    <legend class="rim">Pengaturan Asal Barang</legend>
<!--<div class="white-container">
    <legend class="rim2">Pengaturan <b>Asal Barang</b></legend>
    <div class="biru">
        <div class="white">-->
            <?php
            // $this->breadcrumbs=array(
            // 	'GfAsal Barang Ms'=>array('index'),
            // 	'Manage',
            // );

            $arrMenu = array();
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Asal Barang ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
            //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Asal Barang', 'icon'=>'list', 'url'=>array('index'))) ;
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Asal Barang', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

            $this->menu=$arrMenu;

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#GFSumberDanaM_sumberdana_nama').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('gfsumber-dana-m-grid', {
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
                <!--<h6>Tabel <b>Asal Barang</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'gfsumber-dana-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                            ////'sumberdana_id',
                            array(
                                    'name'=>'sumberdana_id',
                                    'value'=>'$data->sumberdana_id',
                                    'filter'=>false,
                            ),
                            array(
                                    'name'=>'sumberdana_nama',
                                    'value'=>'$data->sumberdana_nama',
                                    'filter'=>  CHtml::activeTextField($model,'sumberdana_nama'),
                            ),            
                            'sumberdana_namalainnya',
                             array(
                                'header'=>'<center>Status</center>',
                                'value'=>'($data->sumberdana_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions'=>array('style'=>'text-align:center;'),
                            ),
            //                array(
            //                        'name'=>'sumberdana_aktif',
            //                        'class'=>'CCheckBoxColumn',     
            //                        'selectableRows'=>0,
            //                        'id'=>'rows',
            //                        'checked'=>'$data->sumberdana_aktif',
            //                ), 
                            array(
                                    'header'=>Yii::t('zii','View'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array(
                                        'view'=>array(
                                            'options'=>array('rel'=>'tooltip','title'=>'Lihat Sumber Dana'),
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
                                                      'options'=>array('rel'=>'tooltip','title'=>'Ubah Sumber Dana'),
                                                    ),
                                     ),
                            ),
                            array(
                                'header'=>'Hapus',
                                'type'=>'raw',
                                'value'=>'($data->sumberdana_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->sumberdana_id)",array("id"=>"$data->sumberdana_id","rel"=>"tooltip","title"=>"Menonaktifkan Sumber Dana"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->sumberdana_id)",array("id"=>"$data->sumberdana_id","rel"=>"tooltip","title"=>"Hapus Sumber Dana")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->sumberdana_id)",array("id"=>"$data->sumberdana_id","rel"=>"tooltip","title"=>"Hapus Sumber Dana"));',
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
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Asal Barang', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));         
    $urlPrint=  $this->createUrl('print');
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#gfsumber-dana-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gfsumber-dana-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('gfsumber-dana-m-grid');
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
                                $.fn.yiiGridView.update('gfsumber-dana-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
            }
        }); 
    }
    $('.filters #GFSumberDanaM_sumberdana_nama').focus();
</script>
</fieldset>