<!--<fieldset class="box">
    <legend class="rim">Pengaturan Jenis Obat Alkes</legend>-->
    <?php
    $this->breadcrumbs=array(
            'Gfjenis Obat Alkes Ms'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#GFJenisObatAlkesM_jenisobatalkes_nama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gfjenis-obat-alkes-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); 
    ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form" style="display:none">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel Jenis <b>Obat Alkes</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'gfjenis-obat-alkes-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    ////'jenisobatalkes_id',
                    array(
                        'name'=>'jenisobatalkes_id',
                        'value'=>'$data->jenisobatalkes_id',
                        'filter'=>false,
                    ),
                    array(
                        'name'=>'jenisobatalkes_nama',
                        'value'=>'$data->jenisobatalkes_nama',
                        'filter'=>  CHtml::activeTextField($model,'jenisobatalkes_nama'),
                    ),            
                    'jenisobatalkes_namalain',
                    // array(
                    //     'header'=>'Jenis Farmasi',
                    //     'name'=>'jenisobatalkes_farmasi',
                    //     'class'=>'CCheckBoxColumn',     
                    //     'selectableRows'=>0,
                    //     'id'=>'rows',
                    //     'checked'=>'$data->jenisobatalkes_farmasi',
                    // ), 
                     array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->jenisobatalkes_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
    //                 array(
    //                        'header'=>'Aktif',
    //                        'name'=>'jenisobatalkes_aktif',
    //                        'class'=>'CCheckBoxColumn',     
    //                        'selectableRows'=>0,
    //                        'id'=>'rows',
    //                        'checked'=>'$data->jenisobatalkes_aktif',
    //                ), 
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view'=>array(
                                    'options'=>array('rel'=>'tooltip','title'=>'Lihat Jenis Obat'),
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
                                              'options'=>array('rel'=>'tooltip','title'=>'Ubah Jenis Obat'),
                                            ),
                             ),
                    ),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>'($data->jenisobatalkes_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->jenisobatalkes_id)",array("id"=>"$data->jenisobatalkes_id","rel"=>"tooltip","title"=>"Menonaktifkan Jenis Obat"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jenisobatalkes_id)",array("id"=>"$data->jenisobatalkes_id","rel"=>"tooltip","title"=>"Hapus Jenis Obat")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jenisobatalkes_id)",array("id"=>"$data->jenisobatalkes_id","rel"=>"tooltip","title"=>"Hapus Jenis Obat"));',
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
    <?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Jenis Obat', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));         
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#gfjenis-obat-alkes-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gfjenis-obat-alkes-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
<!--</fieldset>-->
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',
        function(r){
            if(r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('gfjenis-obat-alkes-m-grid');
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
                                $.fn.yiiGridView.update('gfjenis-obat-alkes-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
            }
        }); 
    }
    $('.filters #GFJenisObatAlkesM_jenisobatalkes_nama').focus();
</script>