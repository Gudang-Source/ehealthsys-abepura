<div class="white-container">
    <legend class="rim2">Pengaturan <b>Kelas Pelayanan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sakelas Pelayanan Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kelas Pelayanan  ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelas Pelayanan ', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Kelas Pelayanan ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Ruangan ', 'icon'=>'file', 'url'=>array('createRuangan'))) :  '' ;

    $this->menu=$arrMenu;


    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#SAKelasPelayananM_jeniskelas_id').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sakelas-pelayanan-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <div class="block-tabel">
        <h6>Tabel <b>Kelas Pelayanan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sakelas-pelayanan-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    ////'kelaspelayanan_id',
                    array(
                            'header'=>'ID',
                            'value'=>'$data->kelaspelayanan_id',
                    ),
                    array(
                            'name'=>'jeniskelas_id',
                            'filter'=>  CHtml::listData($model->JenisKelasItems, 'jeniskelas_id', 'jeniskelas_nama'),
                            'value'=>'$data->jeniskelas->jeniskelas_nama',
                    ),
                    'kelaspelayanan_nama',
                    'kelaspelayanan_namalainnya',
                    array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->kelaspelayanan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
    //                 array(
    //                        'header'=>'Aktif',
    //                        'class'=>'CCheckBoxColumn',     
    //                        'selectableRows'=>0,
    //                        'id'=>'rows',
    //                        'checked'=>'$data->kelaspelayanan_aktif',
    //                ),
                    array(
                         'header'=>'Ruangan ',
                         'type'=>'raw',
                         'value'=>'$this->grid->getOwner()->renderPartial(\'_ruangan\',array(\'kelaspelayanan_id\'=>$data->kelaspelayanan_id),true)',
                     ), 
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view'=>array(
                                    'options'=>array('rel'=>'tooltip','title'=>'Lihat Kelas Pelayanan'),
                                ),
                            ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                            'update' => array(
                                            'options'=>array('rel'=>'tooltip','title'=>'Ubah Kelas Pelayanan'),
                                            'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                             ),
                                            ),
                    ),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>'($data->kelaspelayanan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->kelaspelayanan_id)",array("id"=>"$data->kelaspelayanan_id","rel"=>"tooltip","title"=>"Menonaktifkan Kelas Pelayanan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->kelaspelayanan_id)",array("id"=>"$data->kelaspelayanan_id","rel"=>"tooltip","title"=>"Hapus Kelas Pelayanan")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->kelaspelayanan_id)",array("id"=>"$data->kelaspelayanan_id","rel"=>"tooltip","title"=>"Hapus Kelas Pelayanan"));',
                        'htmlOptions'=>array('style'=>'text-align:left; width:80px'),
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
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Kelas Pelayanan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp" :  '' ;
    echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp" :  '' ;
    echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp" :  '' ;
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');//
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);
 

$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#sajenis-kelas-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(obj)
{
    window.open("${urlPrint}/"+$('#sajenis-kelas-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');


}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                            $.fn.yiiGridView.update('sakelas-pelayanan-m-grid');
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
        myConfirm("Yakin Akan Menghapus Data ini ?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                            $.fn.yiiGridView.update('sakelas-pelayanan-m-grid');
                        }else{
                            myAlert(data.konfirmasi);
                        }
                },"json");
           }
		});
    }
</script>
