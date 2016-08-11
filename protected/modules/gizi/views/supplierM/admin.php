<div class="white-container">
    <legend class="rim2">Pengaturan <b>Supplier</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Gzsupplier Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Supplier ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Supplier', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Supplier', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#GZSupplierM_supplier_kode').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gzsupplier-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Supplier</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'gzsupplier-m-grid',
            'dataProvider'=>$model->searchTabel(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    ////'supplier_id',
                    array(
                            'name'=>'supplier_id',
                            'value'=>'$data->supplier_id',
                            'filter'=>false,
                    ),
                    'supplier_kode',
                    'supplier_nama',
                    'supplier_alamat',
                    'supplier_cp',
                     array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->supplier_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
    //                 array(
    //                        'header'=>'Aktif',
    //                        'name'=>'supplier_aktif',
    //                        'class'=>'CCheckBoxColumn',     
    //                        'selectableRows'=>0,
    //                        'id'=>'rows',
    //                        'checked'=>'$data->supplier_aktif',
    //                ),
                   //  array(
                    //     'name'=>'obatalkes_nama',
                    //     'type'=>'raw',
                    //     'value'=>'$this->grid->getOwner()->renderPartial(\'_obatSupplier\',array(\'supplier_id\'=>$data->supplier_id),true)',
                  //  ),

                    /*
                    'supplier_namalain',
                    'supplier_kabupaten',
                    'supplier_fax',
                    'supplier_kodepos',
                    'supplier_npwp',
                    'supplier_website',
                    'supplier_email',

                    */
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view' => array(
                                              'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat supplier' ),
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
                                              'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah supplier' ),
                                            ),
                             ),
                    ),
                array(
                    'header'=>'Hapus',
                    'type'=>'raw',
                    'value'=>'($data->supplier_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->supplier_id)",array("id"=>"$data->supplier_id","rel"=>"tooltip","title"=>"Menonaktifkan supplier"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->supplier_id)",array("id"=>"$data->supplier_id","rel"=>"tooltip","title"=>"Hapus supplier")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->supplier_id)",array("id"=>"$data->supplier_id","rel"=>"tooltip","title"=>"Hapus supplier"));',
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
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Supplier', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('supplierM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#gfsupplier-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
        
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gfsupplier-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';

        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',
        function(r){
            if(r){
               $.post(url, {id: id},
                    function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('gzsupplier-m-grid');
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
                                $.fn.yiiGridView.update('gzsupplier-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
            }
        }); 
    }
$(document).ready(function(){
$("input[name='GZSupplierM[supplier_kode]']").focus();
})
</script>