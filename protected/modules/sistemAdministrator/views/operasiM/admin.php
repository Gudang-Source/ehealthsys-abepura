<div class="white-container">
    <legend class="rim2">Pengaturan <b>Operasi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Bsoperasi Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Operasi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Operasi', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Operasi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#daftartindakan_nama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('bsoperasi-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    
    if (isset($_GET['sukses'])):
        Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
    endif;
    
    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Operasi</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'bsoperasi-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(//
                    array(
                        'header'=>'ID Operasi',
                        'name'=>'operasi_id',
                        'value'=>'$data->operasi_id',
                        'filter'=>false,
                    ),                    
                    array(
                        'header'=>'Kegiatan Operasi',
                        'name'=>'kegiatanoperasi_id',
                        'value'=>'$data->kegiatanoperasi->kegiatanoperasi_nama',
                        'filter' => CHtml::activeDropDownList($model,'kegiatanoperasi_id',  CHtml::listData(SAKegiatanOperasiM::model()->getAllItems(), 'kegiatanoperasi_id', 'kegiatanoperasi_nama'),array('empty'=>'- Pilih -','class'=>'span2', 'style'=>'width:160px'))
                    ),
                    array(
                        'header'=>'Daftar Tindakan',
                        'name'=>'daftartindakan_nama',
                        'value'=>'$data->daftartindakan->daftartindakan_nama',                        
                        //'filter'=> CHtml::activeTextField($model, 'daftartindakan_nama')
                        'filter' => $this->widget('MyJuiAutoComplete', array(
                                        'model' => $model,
                                        'attribute'=>'daftartindakan_nama',
            //                                            'value'=>$model->daftartindakan->daftartindakan_nama,                                                             
                                        'tombolDialog'=>array('idDialog'=>'dialogTindakan'),
                            ),true),
                    ),
                    array(
                        'header'=>'Kode Operasi',
                        'name'=>'operasi_kode',
                        'value'=>'$data->operasi_kode',
                    ),
                    array(
                        'header'=>'Nama  Operasi',
                        'name'=>'operasi_nama',
                        'value'=>'$data->operasi_nama',
                    ),
                    array(
                        'header'=>'Nama Lain',
                        'name'=>'operasi_namalainnya',
                        'value'=>'$data->operasi_namalainnya',
                    ),
                     array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->operasi_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
                    array(
                        'header'=>Yii::t('zii','View'),
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                                'view' => array(
                                              'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Operasi' ),
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
                                          'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah Operasi' ),
                                        ),
                         ),
                    ),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>'($data->operasi_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->operasi_id)",array("id"=>"$data->operasi_id","rel"=>"tooltip","title"=>"Menonaktifkan operasi"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->operasi_id)",array("id"=>"$data->operasi_id","rel"=>"tooltip","title"=>"Hapus operasi")):CHtml::link("<i class=\'icon-form-check\'></i> ","javascript:addTemporary($data->operasi_id, 1)",array("id"=>"$data->operasi_id","rel"=>"tooltip","title"=>"Mengaktifkan operasi"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->operasi_id)",array("id"=>"$data->operasi_id","rel"=>"tooltip","title"=>"Hapus operasi"));',
                        'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                    ),
            ),
            'afterAjaxUpdate'=> 'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
            
        )); 
        ?>
    <!--</div>-->
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Operasi', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), 
            array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),
            array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 

    $content = $this->renderPartial($this->path_view.'tips.tipsAdmin',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));	 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#bsoperasi-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('bsoperasi-m-grid');
                            }else{
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                },"json");
           }
        });
    }
    
    function addTemporary(id, add){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Yakin akan mengaktifkan data ini untuk sementara?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id, add:add},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('bsoperasi-m-grid');
                            }else{
                                myAlert('Data Gagal di Aktifkan')
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
                                $.fn.yiiGridView.update('bsoperasi-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
        });
    }
$(document).ready(function(){
        $("input[name='SAOperasiM[operasi_kode]']").focus();
    });
</script>