<div class="white-container">
    <legend class="rim2">Pengaturan <b>Tanggungan Pasien</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Satanggunganpenjamin Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
                    (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tanggungan Penjamin ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SATanggunganpenjaminM', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tanggungan Penjamin', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').slideToggle();
            return false;
    });
    $('form#sacara-bayar-m-search').submit(function(){
            $.fn.yiiGridView.update('satanggunganpenjamin-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
    <?php 
    $this->renderPartial($this->path_view.'_search',array(
            'modCaraBayar'=>$model,
    )); ?>
    </div><!-- search-form -->
    <!--<legend class='rim'>Tabel Tanggungan Penjamin</legend>-->
    <?php 
    $this->widget('ext.bootstrap.widgets.BootGroupGridView',array(
        'id'=>'satanggunganpenjamin-m-grid',
        'dataProvider'=>$model->searchTable(),
        'mergeColumns' => array('carabayar_id', 'kelaspelayanan_id'),
        'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(

            array(
                'name'=>'carabayar_id',
                'filter'=> CHtml::dropDownList('SATanggunganpenjaminM[carabayar_id]',$model->carabayar_id,CHtml::listData(CarabayarM::model()->findAllByAttributes(array('carabayar_aktif'=>true), array('order'=>'carabayar_nama ASC')), 'carabayar_id', 'carabayar_nama'),array('empty'=>'-- Pilih --')),
                'value'=>'$data->carabayar->carabayar_nama',
            ),
            array(
                'name'=>'kelaspelayanan_id',
                'filter'=> CHtml::dropDownList('SATanggunganpenjaminM[carabayar_id]',$model->carabayar_id,CHtml::listData(KelaspelayananM::model()->findAllByAttributes(array('kelaspelayanan_aktif'=>true), array('order'=>'kelaspelayanan_nama ASC')), 'kelaspelayanan_id', 'kelaspelayanan_nama'),array('empty'=>'-- Pilih --')),
                'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
            ),
            array(
                'name'=>'penjamin_id',
                'filter'=> CHtml::dropDownList('SATanggunganpenjaminM[carabayar_id]',$model->carabayar_id,CHtml::listData(PenjaminpasienM::model()->findAllByAttributes(array('penjamin_aktif'=>true), array('order'=>'penjamin_nama ASC')), 'penjamin_id', 'penjamin_nama'),array('empty'=>'-- Pilih --')),
                'value'=>'$data->penjamin->penjamin_nama',
            ),
            array(
                'header' => 'Status',
                'value' => '($data->tanggunganpenjamin_aktif)?"Aktif":"Tidak Aktif"'
            ),
            array(
                            'header'=>Yii::t('zii','View'),
                'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view' => array (
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>"$data->carabayar_id","idKelas"=>"$data->kelaspelayanan_id"))',
                                            ),
                             ),
            ),
            array(
                            'header'=>Yii::t('zii','Update'),
                'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                'update' => array (
                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>"$data->carabayar_id","idKelas"=>"$data->kelaspelayanan_id"))',
                                            ),
                             ),
            ),
           
            array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>'($data->tanggunganpenjamin_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->tanggunganpenjamin_id)",array("id"=>"$data->tanggunganpenjamin_id","rel"=>"tooltip","title"=>"Menonaktifkan Tanggungan Penjamin"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->tanggunganpenjamin_id)",array("id"=>"$data->tanggunganpenjamin_id","rel"=>"tooltip","title"=>"Hapus Tanggungan Penjamin")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->tanggunganpenjamin_id)",array("id"=>"$data->tanggunganpenjamin_id","rel"=>"tooltip","title"=>"Hapus Tanggungan Penjamin"));',
                        'htmlOptions'=>array('style'=>'text-align:left; width:80px'),
                    ),            
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    ));
    ?> 

<?php 
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Tanggungan Penjamin', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
        $content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        $url= Yii::app()->createAbsoluteUrl($module.'/'.$controller);
        
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sacara-bayar-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('satanggunganpenjamin-m-grid');
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
                                $.fn.yiiGridView.update('satanggunganpenjamin-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
	   });
    }
</script>