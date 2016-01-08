<div class="white-container">
    <legend class="rim2">Pengaturan <b>Cara Bayar</b></legend>
    <?php
    $this->breadcrumbs=array(
            'SacaraBayar Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Cara Bayar ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Cara Bayar', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Cara Bayar', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;


    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sacara-bayar-m-grid', {
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
        <h6>Tabel <b>Cara Bayar</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sacara-bayar-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    ////'carabayar_id',
                    array(
                            'name'=>'carabayar_id',
                            'value'=>'$data->carabayar_id',
                            'filter'=>false,
                    ),		
                    array(
                            'name'=>'carabayar_nama',
                            'value'=>'$data->carabayar_nama',
                            'filter'=>CHtml::activeTextField($model, 'carabayar_nama'),
                    ),		
                    'carabayar_namalainnya',
                    'metode_pembayaran',
                    //'carabayar_aktif',
                    array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->carabayar_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
    //                array(
    //                        'header'=>'Aktif',
    //                        'class'=>'CCheckBoxColumn',     
    //                        'selectableRows'=>0,
    //                        'id'=>'rows',
    //                        'checked'=>'$data->carabayar_aktif',
    //                ),
                    array(
                        'header'=>Yii::t('zii','View'),
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                            'view'=>array(
                                'options'=>array('rel'=>'tooltip','title'=>'Lihat Cara Bayar'),
                            ),
                        ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                            'update' => array(
                                            'options'=>array('rel'=>'tooltip','title'=>'Ubah Cara Bayar'),
                                            'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                             ),
                                            ),
                    ),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>'($data->carabayar_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->carabayar_id)",array("id"=>"$data->carabayar_id","rel"=>"tooltip","title"=>"Menonaktifkan Cara Bayar"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->carabayar_id)",array("id"=>"$data->carabayar_id","rel"=>"tooltip","title"=>"Hapus Cara Bayar")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->carabayar_id)",array("id"=>"$data->carabayar_id","rel"=>"tooltip","title"=>"Hapus Cara Bayar"));',
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
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Cara Bayar', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/sistemAdministrator/CaraBayarM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp" :  '' ;
    echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp" :  '' ;
    echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp" :  '' ;
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');//
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
        
         function cekForm(obj)
{
    $("#sajenis-carabayar-m-search     :input[name='"+ obj.name +"']").val(obj.value);
}
    function print(obj)
    {
    window.open("${urlPrint}/"+$('#sajenis-carabayar-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
        
    
    }
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    Yii::app()->clientScript->registerScript('alert',$js,CClientScript::POS_BEGIN);
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
                                $.fn.yiiGridView.update('sacara-bayar-m-grid');
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
                                $.fn.yiiGridView.update('sacara-bayar-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
	   });
    }
    $('.filters #SACaraBayarM_carabayar_nama').focus();
</script>