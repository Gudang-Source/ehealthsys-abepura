<div class="white-container">
    <legend class="rim2">Master <b>Wilayah - Kabupaten</b></legend>
    <?php 
    $this->widget('bootstrap.widgets.BootMenu', array(
        'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
        'stacked'=>false, // whether this is a stacked menu
        'items'=>array(
            array('label'=>'Propinsi',  'url'=>$this->createUrl('/rawatDarurat/propinsiM')),
            array('label'=>'Kabupaten', 'url'=>$this->createUrl('/rawatDarurat/kabupatenM'), 'active'=>true),
            array('label'=>'Kecamatan', 'url'=>$this->createUrl('/rawatDarurat/kecamatanM')),
            array('label'=>'Kelurahan', 'url'=>$this->createUrl('/rawatDarurat/kelurahanM')),
        ),
    )); ?>
    <div class="biru">
        <div class="white">
            <?php
            $this->breadcrumbs=array(
                    'Sakabupaten Ms'=>array('index'),
                    'Manage',
            );

            $arrMenu = array();
                            (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kabupaten ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;

                            // (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kabupaten', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

            $this->menu=$arrMenu;

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#SAKabupatenM_propinsi_nama').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('sakabupaten-m-grid', {
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
                <!--<h6>Tabel <B>Kabupaten</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'sakabupaten-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(
                            ////'kabupaten_id',
                            array(
                                    'header'=>'ID',
                                    'name'=>'kabupaten_id',
                                    'filter'=>false,
                                    'value'=>'$data->kabupaten_id',
                            ),		
                            //'propinsi.propinsi_nama',
                            array(
                                    'name'=>'propinsi_id',
                                    'filter'=>  CHtml::listData($model->getPropinsiItems(), 'propinsi_id', 'propinsi_nama'),
                                    'value'=>'$data->propinsi->propinsi_nama',
                            ),
                            'kabupaten_nama',
                            'kabupaten_namalainnya',
                            array(
                                'header'=>'<center>Status</center>',
                                'value'=>'($data->kabupaten_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions'=>array('style'=>'text-align:center;'),
                            ),
                            //'kabupaten_aktif',
            //                array(
            //                        'header'=>'Aktif',
            //                        'class'=>'CCheckBoxColumn',     
            //                        'selectableRows'=>0,
            //                        'id'=>'rows',
            //                        'checked'=>'$data->kabupaten_aktif',
            //                ),
                            array(
                                     'header'=>Yii::t('zii','View'),
                                                 'class'=>'bootstrap.widgets.BootButtonColumn',
                                     'template'=>'{view}',
                                     'buttons'=>array(
                                        'view' => array (
                                                      'options'=>array('title'=>'Lihat Kabupaten'),
                                                    ),
                                     ),
                            ),
                            array(
                                    'header'=>Yii::t('zii','Update'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{update}',
                                    'buttons'=>array(
                                        'update' => array
                                                            (
                                                              'visible'=>'Yii::app()->user->checkAccess("Update")',
                                                              'options'=>array('title'=>'Ubah Kabupaten'),
                                                            ),
                                     ),
                            ),
                    array(
                        'header'=>'<center>Hapus</center>',
                        'type'=>'raw',
                        'value'=>'($data->kabupaten_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->kabupaten_id)",array("id"=>"$data->kabupaten_id","rel"=>"tooltip","title"=>"Menonaktifkan Kabupaten"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->kabupaten_id)",array("id"=>"$data->kabupaten_id","rel"=>"tooltip","title"=>"Hapus Kabupaten")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->kabupaten_id)",array("id"=>"$data->kabupaten_id","rel"=>"tooltip","title"=>"Hapus Kabupaten"));',
                        'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
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
        </div>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds','{icon} Tambah Kabupaten',array('{icon}'=>'<i class="icon-plus icon-white"></i>')), 
                            Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/create'), 
                            array('class'=>'btn btn-success'));
    echo "&nbsp;";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'create','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');//
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
           function cekForm(obj)
{
    $("#sakabupaten-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
    function print(obj)
    {
    window.open("${urlPrint}/"+$('#sakabupaten-m_search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
        
    
    }
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sakabupaten-m-grid');
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
        myConfirm("Yakin Akan Menghapus Data ini ?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sakabupaten-m-grid');
                            }else{
                                myAlert('Data gagal dihapus karena data digunakan oleh Master Kecamatan.');
                            }
                },"json");
           }
       });
    }
    $(document).ready(function(){
        $('input[name="RDKabupatenM[kabupaten_nama]"]').focus();
    })
</script>