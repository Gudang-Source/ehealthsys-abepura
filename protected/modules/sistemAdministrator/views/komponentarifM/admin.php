<div class="white-container">
<legend class="rim2">Pengaturan <b>Komponen Tarif</b></legend>
<?php
$this->breadcrumbs=array(
	'Sakomponen Tarif Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Komponen Tarif ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Komponen Tarif', 'icon'=>'list', 'url'=>array('index'))) ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen Tarif', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen Tarif Instalasi', 'icon'=>'file', 'url'=>array('createKomponenTarifInstalasi'))) :  '' ;

                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sakomponen-tarif-m-grid', {
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
<div class="block-tabel">
	<h6>Tabel <b>Komponen Tarif</b></h6>
	<?php 
   $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
   $module = Yii::app()->controller->module->id;
$this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sakomponen-tarif-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'komponentarif_id',
		array(
                        'name'=>'komponentarif_id',
                        'value'=>'$data->komponentarif_id',
                        'filter'=>false,
                ),
		'komponentarif_nama',
		'komponentarif_namalainnya',
		'komponentarif_urutan',
		//'komponentarif_aktif',
                array(
                     'header'=>'Instalasi',
                     'type'=>'raw',
                     'value'=>'$this->grid->getOwner()->renderPartial(\'_komponenTarifInstalasi\',array(\'komponentarif_id\'=>$data->komponentarif_id),true)',
                    'filter'=>(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? CHtml::link('<i class="icon-file"></i>'.Yii::t('mds','Create'), Yii::app()->createUrl($module.'/'.$controller.'/createKomponenTarifInstalasi') ) : '',
                    ), 
//		array(
//                        'header'=>'Aktif',
//                        'class'=>'CCheckBoxColumn',
//                        'selectableRows'=>0,
//                        'checked'=>'$data->komponentarif_aktif',
//                ),
                array(
                    'header'=>'Persentase',
                    'type'=>'raw',
                    'value'=>function($data) {
                        $kel = PersenkelkomponentarifM::model()->findAllByAttributes(array(
                            'komponentarif_id'=>$data->komponentarif_id,
                        ));
                        if (count($kel) == 0) return "-";
                        
                        $st = "<ul>";
                        foreach ($kel as $item) {
                            $st .= "<li>".$item->kelompokkomponentarif->kelompokkomponentarif_nama
                                    ." (".$item->persentase."%)</li>";
                        }
                        $st .= "</ul>";
                        
                        return $st;
                    }
                ),
                array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->komponentarif_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
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
                    'value'=>'($data->komponentarif_aktif)?CHtml::link("<i class=\'icon-remove\'></i> ","javascript:removeTemporary($data->komponentarif_id)",array("id"=>"$data->komponentarif_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->komponentarif_id)",array("id"=>"$data->komponentarif_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->komponentarif_id)",array("id"=>"$data->komponentarif_id","rel"=>"tooltip","title"=>"Hapus"));',
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
</div>


<?php 
 
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Komponen Tarif', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";        
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
    $("#sakomponen-tarif-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sakomponen-tarif-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('sakomponen-tarif-m-grid');
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
                                $.fn.yiiGridView.update('sakomponen-tarif-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
	   });
    }
$(document).ready(function(){
        $("input[name='SAKomponentarifM[komponentarif_nama]']").focus();
});
</script>
</div>
