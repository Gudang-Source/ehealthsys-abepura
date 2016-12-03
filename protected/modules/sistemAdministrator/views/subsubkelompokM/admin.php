<div class="white-container">
    <legend class="rim2">Pengaturan <b>Sub Sub Kelompok</b></legend>
<?php
$this->breadcrumbs=array(
	'Sasubsubkelompok Ms'=>array('index'),
	'Manage',
);

$arrMenu = array();
                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Sub Sub Kelompok ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                //array_push($arrMenu,array('label'=>Yii::t('mds','List').' SASubkelompokM', 'icon'=>'list', 'url'=>array('index'))) ;
                // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Sub Kelompok', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
$this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sasubsubkelompok-m-grid', {
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
<div class="block-tabel">
<h6>Tabel <b>Sub Sub Kelompok</b></h6>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'sasubsubkelompok-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
		////'subkelompok_id',
		array(
                        'name'=>'subsubkelompok_id',
                        'value'=>'$data->subsubkelompok_id',
                        'filter'=>false,
                ),
                array(
                        'header'=>'Golongan',
                        'filter'=> CHtml::activeDropDownList($model, 'golongan_id',CHtml::listData($model->GolonganItems, 'golongan_id', 'golongan_nama'), array('empty'=>'--Pilih--')),
                        'value'=>'$data->subkelompok->kelompok->bidang->golongan->golongan_nama',
                ),
                array(
                        'header'=>'Bidang',
                        'filter'=> CHtml::activeDropDownList($model,'bidang_id', CHtml::listData($model->getBidang(), 'bidang_id', 'bidang_nama'), array('empty'=>'--Pilih--')),
                        'value'=>'$data->subkelompok->kelompok->bidang->bidang_nama',
                ),
		array(
                        'header'=>'Kelompok',
                        'filter'=> CHtml::activeDropDownList($model,'kelompok_id', CHtml::listData($model->getKelompok(), 'kelompok_id', 'kelompok_nama'), array('empty'=>'--Pilih--')),
                        'value'=>'$data->subkelompok->kelompok->kelompok_nama',
                ),
		array(
                        'name'=>'subkelompok_id',
                        'filter'=> CHtml::activeDropDownList($model,'subkelompok_id',CHtml::listData($model->getSubKelompok(), 'subkelompok_id', 'subkelompok_nama'), array('empty'=>'--Pilih--')),
                        'value'=>'$data->subkelompok->subkelompok_nama',
                ),
                array(
                    'name' => 'subsubkelompok_kode',
                    'filter' => Chtml::activeTextField($model, 'subsubkelompok_kode', array('class' => 'angkadot-only'))
                ),
		array(
                    'name' => 'subsubkelompok_nama',
                    'filter' => Chtml::activeTextField($model, 'subsubkelompok_nama', array('class' => 'custom-only'))
                ),		
                array(
                    'name' => 'subsubkelompok_namalainnya',
                    'filter' => Chtml::activeTextField($model, 'subsubkelompok_namalainnya', array('class' => 'custom-only'))
                ),		            
                array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->subsubkelompok_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
//		array(
//                        'header'=>'Aktif',
//                        'class'=>'CCheckBoxColumn',     
//                        'selectableRows'=>0,
//                        'id'=>'rows',
//                        'checked'=>'$data->subkelompok_aktif',
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
                        //'buttons'=>array(
                         //   'update' => array (
                          //                'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                           //             ),
                       //  ),
		),
                array(
                    'header'=>'Hapus',
                    'type'=>'raw',
                    'value'=>'($data->subsubkelompok_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->subsubkelompok_id)",array("id"=>"$data->subsubkelompok_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->subsubkelompok_id)",array("id"=>"$data->subsubkelompok_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->subsubkelompok_id)",array("id"=>"$data->subsubkelompok_id","rel"=>"tooltip","title"=>"Hapus"));',
                    'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
                ),
	),
       'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            });
             $("table").find("select").each(function(){
                cekForm(this);
            });
            $(".angkadot-only").keyup(function(){
                setAngkaDotOnly(this);
            });
            $(".custom-only").keyup(function(){
                setCustomOnly(this);
            });
        }',
)); ?>
</div>
<?php 
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Sub Sub Kelompok', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
  $content = $this->renderPartial($this->path_tips.'master',array(),true);
$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
        $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#sasubsubkelompok-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sasubsubkelompok-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('sasubsubkelompok-m-grid');
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
                                $.fn.yiiGridView.update('sasubsubkelompok-m-grid');
                            }else if(data.status == 'gagal_form'){
                                myAlert('Maaf data ini tidak bisa dihapus dikarenakan digunakan pada table lain.')
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
	   });
    }
    $(document).ready(function(){
        $('input[name="SASubsubkelompokM[subkelompok_kode]"]').focus();
    })
</script>
</div>