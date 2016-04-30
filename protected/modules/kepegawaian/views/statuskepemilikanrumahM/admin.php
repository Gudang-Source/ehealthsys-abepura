<!--<div class="white-container">
    <legend class="rim2">Pengaturan Status <b>Kepemilikan Rumah</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Pengaturan Status Kepemilikan Rumah</legend>
    <?php
    $this->breadcrumbs=array(
            'Statuskepemilikanrumah Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Status Kepemilikan Rumah ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Status Kepemilikan Rumah', 'icon'=>'list', 'url'=>array('index'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Status Kepemilikan Rumah', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

       $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
       $module = Yii::app()->controller->module->id;
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#KPStatuskepemilikanrumahM_statuskepemilikanrumah_nama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('statuskepemilikanrumah-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    $this->widget('bootstrap.widgets.BootAlert');
 //   $this->renderPartial('_tabMenu',array());
    ?>
    <!--<div class="biru">
        <div class="white">-->
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut3 search-form" style="display:none">
                <?php  $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
            <!--<div class="block-tabel">-->
                <!--<h6>Tabel Status <b>Kepemilikan Rumah</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'statuskepemilikanrumah-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                            'itemsCssClass'=>'table table-bordered table-striped table-condensed',
                    'columns'=>array(
                            'statuskepemilikanrumah_id',
                            'statuskepemilikanrumah_nama',
                            'statuskepemilikanrumah_namalain',
                            array(
                                'header'=>'<center>Status</center>',
                                'value'=>'($data->statuskepemilikanrumah_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions'=>array('style'=>'text-align:center;'),
                            ),
            //                array(
            //                    'header'=>'Aktif',
            //                    'class'=>'CCheckBoxColumn',
            //                    'checked'=>'$data->statuskepemilikanrumah_aktif',
            //                ),
                            array(
                                                            'header'=>Yii::t('zii','View'),
                                    'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                                                            'template'=>'{view}',
                            ),
                            array(
                                                            'header'=>Yii::t('zii','Update'),
                                    'class'=>'ext.bootstrap.widgets.BootButtonColumn',
                                                            'template'=>'{update}',
                            ),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>'($data->statuskepemilikanrumah_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->statuskepemilikanrumah_id)",array("id"=>"$data->statuskepemilikanrumah_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->statuskepemilikanrumah_id)",array("id"=>"$data->statuskepemilikanrumah_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->statuskepemilikanrumah_id)",array("id"=>"$data->statuskepemilikanrumah_id","rel"=>"tooltip","title"=>"Hapus"));',
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
<!--            </div>-->
       <!-- </div>
    </div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Status Kepemilikan Rumah', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
   // echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp" :  '' ;
   // echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp" :  '' ;
   // echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp" :  '' ;
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp";
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#search-t-statuskepemilikanrumah :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#search-t-statuskepemilikanrumah').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('statuskepemilikanrumah-m-grid');
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
                                $.fn.yiiGridView.update('statuskepemilikanrumah-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
            }
        }); 
    }
</script>
</fieldset>