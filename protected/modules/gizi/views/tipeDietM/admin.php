<!--<div class="white-container">
    <legend class="rim2">Pengaturan <b>Tipe Diet</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Pengaturan <b>Tipe Diet</b></legend>
    <?php //$this->renderPartial('_tabMenu',array()); ?>
    <!--<div class="biru">
        <div class="white">-->
            <?php
            $this->breadcrumbs=array(
                    'Gztipediet Ms'=>array('index'),
                    'Manage',
            );
            $arrMenu = array();
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tipe Diet ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
            //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Tipe Diet', 'icon'=>'list', 'url'=>array('index'))) ;
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tipe Diet', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

            $this->menu=$arrMenu;

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#TipeDietM_tipediet_nama').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('tipe-diet-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");

            $this->widget('bootstrap.widgets.BootAlert'); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i> ')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut3 search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
            <!--<div class="block-tabel">-->
                <!--<h6>Tabel <b>Tipe Diet</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id'=>'tipe-diet-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                            'itemsCssClass'=>'table table-striped table-condensed',
                            'template'=>"{summary}\n{items}\n{pager}",
                    'columns'=>array(
                            array(
                                                'header'=>'ID',
                                                'value'=>'$data->tipediet_id',
                                            ),
                            'tipediet_nama',
                            'tipediet_namalainnya',
                             array(
                                'header'=>'<center>Status</center>',
                                'value'=>'($data->tipediet_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions'=>array('style'=>'text-align:center;'),
                            ),
            //		array(
            //                    'header'=>'Aktif',
            //                    'class'=>'CCheckBoxColumn',
            //                    'selectableRows'=>0,
            //                    'checked'=>'$data->tipediet_aktif',
            //                ),
                            array(
                                'header'=>Yii::t('zii','View'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{view}',
                                'buttons'=>array(
                                        'view' => array(
                                                      'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat tipe diet' ),
                                                    ),
                                     ),
                            ),
                            array(
                                'header'=>Yii::t('zii', 'Update'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{update}',
                                'buttons'=>array(
                                        'update' => array(
                                                      'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah tipe diet' ),
                                                    ),
                                     ),
                            ),
                            array(
                                'header'=>'<center>Hapus</center>',
                                'type'=>'raw',
                                'value'=>'($data->tipediet_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->tipediet_id)",array("id"=>"$data->tipediet_id","rel"=>"tooltip","title"=>"Menonaktifkan tipe diet"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->tipediet_id)",array("id"=>"$data->tipediet_id","rel"=>"tooltip","title"=>"Hapus tipe diet")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->tipediet_id)",array("id"=>"$data->tipediet_id","rel"=>"tooltip","title"=>"Hapus tipe diet"));',
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
        <!--</div>
    </div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Tipe Diet', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('tipeDietM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
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
    $("#satipediet-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#satipediet-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('tipe-diet-m-grid');
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
                                $.fn.yiiGridView.update('tipe-diet-m-grid');
                            }else{
                                myAlert('Data gagal dihapus karena data digunakan oleh Master Diet atau Master Jadwal Makan.');
                            }
                },"json");
            }
        }); 
    }
$(document).ready(function(){
$("input[name='TipeDietM[tipediet_nama]']").focus();
})
</script>
</fieldset>