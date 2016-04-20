<?php
$this->breadcrumbs=array(
	'Signa Obat Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Signa Obat ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                //array_push($arrMenu,array('label'=>Yii::t('mds','List').' FALookupM', 'icon'=>'list', 'url'=>array('index'))) ;
                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Signa Obat', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
//$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#".CHtml::activeId($model,'lookup_name')."').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('signaobat-m-gird', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut search-form" style="display:none">
    <?php $this->renderPartial($this->path_view.'_search',array(
            'model'=>$model,
    )); ?>
</div><!-- search-form -->
<!--<div class="block-tabel">-->
    <!--<h6>Tabel <b>Signa Obat</b></h6>-->
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'signaobat-m-gird',
	'dataProvider'=>$model->search(Params::LOOKUPTYPE_SIGNA_OA),
	'filter'=>$model,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-striped table-condensed',
	'columns'=>array(
		array(
			'header'=>'Signa Obat',
			'name'=>'lookup_name',
			'value'=>'$data->lookup_name',
		),
		array(
				'header'=>'Aktif',
				'value' => '($data->lookup_aktif == true ? \'Aktif\': \'Tidak Aktif\')'
		),   
		array(
			'header'=>Yii::t('zii','View'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template'=>'{view}',
			'buttons'=>array(
			   'view' => array(
					'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Signa Obat' ),
				),
			),
		),
		array(
			'header'=>Yii::t('zii','Update'),
			'class'=>'bootstrap.widgets.BootButtonColumn',
			'template'=>'{update}',
			'buttons'=>array(
				'update' => array(
					'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
					'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah Signa Obat' ),
				  ),
			 ),
		),
		array(
			'header'=>'<center>Hapus</center>',
			'type'=>'raw',
			'value'=>'($data->lookup_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Menonaktifkan Signa Obat"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Hapus Signa Obat")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->lookup_id)",array("id"=>"$data->lookup_id","rel"=>"tooltip","title"=>"Hapus Signa Obat"));',
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
<?php 
echo CHtml::link(Yii::t('mds', '{icon} Tambah Signa Obat', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 

$content = $this->renderPartial($this->path_view.'tips/tipsAdmin',array(),true);
$this->widget('UserTips',array('content'=>$content)); 

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sediaanobatracikan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sediaanobatracikan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('signaobat-m-gird');
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
                                $.fn.yiiGridView.update('signaobat-m-gird');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
        });
    }

    $(document).ready(function(){
        $("input[name='FALookupM[lookup_name]']").focus();
    });

</script>