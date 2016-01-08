<?php
$this->breadcrumbs=array(
	'Sacara Masuk Ms'=>array('index'),
	'Manage',
);

$this->menu=array(
        array('label'=>Yii::t('mds','Manage').' Cara Masuk ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master')),
//	array('label'=>Yii::t('mds','List').' Cara Masuk', 'icon'=>'list', 'url'=>array('index')),
//	array('label'=>Yii::t('mds','Create').' Cara Masuk', 'icon'=>'file', 'url'=>array('create')),
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
        $('#SACaraMasukM_caramasuk_nama').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sacara-masuk-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<legend class="rim">Tabel Cara Masuk</legend>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sacara-masuk-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'caramasuk_id',
                array(
                    'header'=>'ID',
                    'value'=>'$data->caramasuk_id',
                ),		
                array(
                    'header'=>'Cara Masuk',
                    'value'=>'$data->caramasuk_nama',
                    'filter'=>CHtml::activeTextField($model, 'caramasuk_nama')
                ),	
		'caramasuk_namalainnya',
                array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->caramasuk_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
		//'caramasuk_aktif',
//                array(
//                        'header'=>'Aktif',
//                        'class'=>'CCheckBoxColumn',     
//                        'selectableRows'=>0,
//                        'id'=>'rows',
//                        'checked'=>'$data->caramasuk_aktif',
//                ),
		array(
                        'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                            'view'=>array(
                                'options'=>array('rel'=>'tooltip','title'=>'Lihat Cara Masuk'),
                            ),
                        ),
		),
		array(
                        'header'=>Yii::t('zii','Update'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update'=>array(
                                'options'=>array('rel'=>'tooltip','title'=>'Ubah Cara Masuk'),
                            ),
                        ),
		),
//		array(
//                        'header'=>Yii::t('zii','Delete'),
//			'class'=>'bootstrap.widgets.BootButtonColumn',
//                        'template'=>'{delete}',
//		),
                array(
                    'header'=>'Hapus',
                    'type'=>'raw',
                    'value'=>'($data->caramasuk_aktif)?CHtml::link("<i class=\'icon-remove\'></i> ","javascript:removeTemporary($data->caramasuk_id)",array("id"=>"$data->caramasuk_id","rel"=>"tooltip","title"=>"Menonaktifkan Cara Masuk"))." ".CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->caramasuk_id)",array("id"=>"$data->caramasuk_id","rel"=>"tooltip","title"=>"Hapus Cara Masuk")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->caramasuk_id)",array("id"=>"$data->caramasuk_id","rel"=>"tooltip","title"=>"Hapus Cara Masuk"));',
                    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
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

<?php 
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Cara Masuk', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/sistemAdministrator/CaraMasukM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
       $content = $this->renderPartial('../tips/master',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#saalatmedis-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saalatmedis-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sacara-masuk-m-grid');
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
                                $.fn.yiiGridView.update('sacara-masuk-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
	   });
    }
    $('.filters #SACaraMasukM_caramasuk_nama').focus();
</script>