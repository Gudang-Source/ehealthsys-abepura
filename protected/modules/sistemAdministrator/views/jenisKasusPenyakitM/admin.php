<div class="white-container">
    <legend class="rim2">Pengaturan Jenis <b>Kasus Penyakit</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sajenis Kasus Penyakit Ms'=>array('index'),
            'Manage',
    );
    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Jenis Kasus Penyakit Ruangan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Jenis Kasus Penyakit', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Jenis Kasus Penyakit Ruangan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;


    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sajenis-kasus-penyakit-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    
    if (isset($_GET['sukses'])):
        Yii::app()->user->setFlash('success', "Data Ruangan Dan Jenis Kasus Penyakit Berhasil Disimpan");
    endif;
    
    $this->widget('bootstrap.widgets.BootAlert');  ?>     
  
    <?php echo CHtml::link(Yii::t('mds','{icon} Pencarian Lanjut',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel Jenis <b>Kasus Penyakit</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sajenis-kasus-penyakit-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-bordered table-striped table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'ID',
                            'value'=>'$data->jeniskasuspenyakit_id',
                    ),		
                    'jeniskasuspenyakit_nama',
                    'jeniskasuspenyakit_namalainnya',
                    //'jeniskasuspenyakit_aktif',
                    array(
                         'header'=>'Ruangan',
                         'type'=>'raw',
                         'value'=>'$this->grid->getOwner()->renderPartial(\''.$this->path_view.'_ruangan\',array(\'jeniskasuspenyakit_id\'=>$data->jeniskasuspenyakit_id),true)',
                     ), 

                     array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->jeniskasuspenyakit_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
    //                array(
    //                        'header'=>'Aktif',
    //                        'class'=>'CCheckBoxColumn',     
    //                        'selectableRows'=>0,
    //                        'id'=>'rows',
    //                        'checked'=>'$data->jeniskasuspenyakit_aktif',
    //                ),
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
//                            'buttons'=>array(
//                            'update' => array(
//                                            'visible'=>'Yii::app()->user->checkAccess("Update")',
//                                             ),
//                                            ),
                    ),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>'($data->jeniskasuspenyakit_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->jeniskasuspenyakit_id)",array("id"=>"$data->jeniskasuspenyakit_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jeniskasuspenyakit_id)",array("id"=>"$data->jeniskasuspenyakit_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jeniskasuspenyakit_id)",array("id"=>"$data->jeniskasuspenyakit_id","rel"=>"tooltip","title"=>"Hapus"));',
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
    <?php         
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Jenis Kasus Penyakit', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
        //echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp" :  '' ;
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp";
        //echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp" :  '' ;
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp";
        //echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp" :  '' ;        
        // echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp" :  '' ;
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";
        $content = $this->renderPartial($this->path_view.'tips.tipsAdmin',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');//
        $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sajeniskasus-penyakit-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
    function print(obj)
    {
    window.open("${urlPrint}/"+$('#sajeniskasus-penyakit-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('sajenis-kasus-penyakit-m-grid');
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
							$.fn.yiiGridView.update('sajenis-kasus-penyakit-m-grid');
						}else if(data.status == 'warning'){
							myAlert('Data tidak dapat dihapus karena beberapa data ini sudah dipakai di transaksi lain oleh pasien')
						}else{
							myAlert('Data Gagal di Hapus')
						}
                },"json");
           }
        });
    }
</script>