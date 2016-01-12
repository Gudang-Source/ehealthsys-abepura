<div class="white-container">
    <legend class="rim2">Pengaturan <b>Penjamin Pasien</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapenjamin Pasien Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
//                array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Penjamin Pasien ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')));
    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sapenjamin-pasien-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");



    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial($this->path_view_penjamin.'_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Penjamin Pasien</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sapenjamin-pasien-m-grid',
            'dataProvider'=>$model->searchPenjaminMCU(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'ID',
                            'value'=>'$data->penjamin_id',
                    ),
                    array(
                            'name'=>'carabayar_id',
                            'filter'=>  CHtml::listData($model->CaraBayarItems, 'carabayar_id', 'carabayar_nama'),
                            'value'=>'$data->carabayar->carabayar_nama',
                    ),
                    'penjamin_nama',
                    'penjamin_namalainnya',            
                    array(
                            'header'=>'<center>Status</center>',
                            'value'=>'($data->penjamin_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array(
                                    'view'=>array(
                                            'options'=>array('rel'=>'tooltip','title'=>'Lihat Penjamin Pasien'),
                                    ),
                            ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                    'update' => array(
                                            'options'=>array('rel'=>'tooltip','title'=>'Ubah Penjamin Pasien'),
                                     ),
                            ),
                    ),
                    array(
                            'header'=>'Hapus',
                            'type'=>'raw',
                            'value'=>'($data->penjamin_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->penjamin_id)",array("id"=>"$data->penjamin_id","rel"=>"tooltip","title"=>"Menonaktifkan Penjamin Pasien"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->penjamin_id)",array("id"=>"$data->penjamin_id","rel"=>"tooltip","title"=>"Hapus Penjamin Pasien")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->penjamin_id)",array("id"=>"$data->penjamin_id","rel"=>"tooltip","title"=>"Hapus Penjamin Pasien"));',
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
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Penjamin Pasien', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('sistemAdministrator.views.tips.master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');//
    $url= Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
          function cekForm(obj)
{
    $("#sapenjamin-pasien-m-search     :input[name='"+ obj.name +"']").val(obj.value);
}
    function print(obj)
    {
    window.open("${urlPrint}/"+$('#sapenjamin-pasien-m-search').serialize()+"&caraPrint="+obj,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('sapenjamin-pasien-m-grid');
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
                                $.fn.yiiGridView.update('sapenjamin-pasien-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
	   });
    }
</script>
