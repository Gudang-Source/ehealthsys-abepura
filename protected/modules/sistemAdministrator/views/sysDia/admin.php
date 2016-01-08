<?php //$this->renderPartial('_tabMenu',array()); ?>
<?php
$this->breadcrumbs=array(
	'Rmsys Dias'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sysdia ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' SASysdiaM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Sysdia', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
//$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#RMSysDia_kelompokumur_id').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('rmsys-dia-grid', {
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

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'rmsys-dia-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'sysdia_id',
		array(
                        'name'=>'sysdia_id',
                        'value'=>'$data->sysdia_id',
                        'filter'=>false,
                ),
        array(
                        'name'=>'kelompokumur_id',
                        'value'=>'$data->kelompokumur->kelompokumur_nama',
                        'filter'=>false,
                ),
		//'kelompokumur_id',
		'systolic_min',
		'systolic_max',
		'diastolic_min',
		'diastolic_max',
		/*
		'sysdia_range',
		'sysdia_nama',
		'sysdia_desc',
		'sysdia_aktif',
		*/
                array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->sysdia_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
//                array(
//                    'name'=>'sysdia_aktif',
//                    'class'=>'CCheckBoxColumn',
//                    'checked'=>'$data->sysdia_aktif',
//                    'id'=>'rows',
//                    'selectableRows'=>0,
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
                        'buttons'=>array(
                            'update' => array (
                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                        ),
                         ),
		),
        array(
            'header'=>'Hapus',
            'type'=>'raw',
            'value'=>'($data->sysdia_aktif)?CHtml::link("<i class=\'icon-remove\'></i> ","javascript:removeTemporary($data->sysdia_id)",array("id"=>"$data->sysdia_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->sysdia_id)",array("id"=>"$data->sysdia_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->sysdia_id)",array("id"=>"$data->sysdia_id","rel"=>"tooltip","title"=>"Hapus"));',
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
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Sysdia', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('sysDia/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
        
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
    $("#rmsys-dia-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rmsys-dia-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        var answer = confirm('Yakin akan menonaktifkan data ini untuk sementara?');
            if (answer){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('rmsys-dia-grid');
                            }else{
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                },"json");
           }
    }
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        var answer = confirm('Yakin Akan Menghapus Data ini ?');
            if (answer){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('rmsys-dia-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
    }
</script>