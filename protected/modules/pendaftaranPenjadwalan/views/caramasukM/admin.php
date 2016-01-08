<!-- <div class="row-fluid">
  <div class="span12"><legend class="rim2">Identitas Pasien</legend><br />
  </div>
</div>


<?php $this->renderPartial('_tab'); ?>
 -->
<?php
$this->breadcrumbs=array(
	'Ppcaramasuk Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#PPCaramasukM_caramasuk_nama').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ppcaramasuk-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");


$this->widget('bootstrap.widgets.BootAlert'); ?>


<?php

 echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class=" cari-lanjut search-form" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->


<!--<legend class="rim">Tabel Cara Masuk</legend>-->
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'ppcaramasuk-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
		////'caramasuk_id',
		array(
                        'name'=>'caramasuk_id',
                        'value'=>'$data->caramasuk_id',
                        'filter'=>false,
                ),
		'caramasuk_nama',
		'caramasuk_namalainnya',
                array(
                    'header'=>'Status',
                    'value'=>'($data->caramasuk_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=icon-form-lihat></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>$data->caramasuk_id)),
                                 array("class"=>"view",
                                       "rel"=>"tooltip",
                                       "title"=>"Lihat Cara Masuk",
                         ))',
                 ),
                array(
                    'header'=>Yii::t('zii','Update'),
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=icon-form-ubah></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>$data->caramasuk_id)),
                                 array("class"=>"update",
                                       "rel"=>"tooltip",
                                       "title"=>"Ubah Cara Masuk",
                         ))',
                 ),
        array(
            'header'=>'Hapus',
            'type'=>'raw',
            'value'=>'($data->caramasuk_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->caramasuk_id)",array("id"=>"$data->caramasuk_id","rel"=>"tooltip","title"=>"Menonaktifkan Cara Masuk"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->caramasuk_id)",array("id"=>"$data->caramasuk_id","rel"=>"tooltip","title"=>"Hapus Cara Masuk")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->caramasuk_id)",array("id"=>"$data->caramasuk_id","rel"=>"tooltip","title"=>"Hapus Cara Masuk"));',
            'htmlOptions'=>array('style'=>'width:80px'),
        ),
	),
        'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
        }',
)); ?>

<?php 
/*
<table>
    <tr>
        <td width="11.1%"><?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search',array(
                'model'=>$model,
            )); ?>
            </div><!-- search-form --></td>
        <td width="13%"><?php echo CHtml::link(Yii::t('mds', '{icon} Tambah Cara Masuk', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/pendaftaranPenjadwalan/CaramasukM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?></td>
        <td width="8%"><?php $this->widget('bootstrap.widgets.BootButtonGroup', array(
        'type'=>'primary', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
        'buttons'=>array(
            array('label'=>'Print', 'icon'=>'icon-print icon-white', 'url'=>'#', 'htmlOptions'=>array('onclick'=>'print(\'PRINT\')')),
            array('label'=>'', 'items'=>array(
                array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'PDF\')')),
                array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'EXCEL\')')),
                array('label'=>'Grafik','icon'=>'icon-print', 'url'=>'', 'itemOptions'=>array('onclick'=>'print(\'GRAFIK\')')),
            )),       
        ),
//        'htmlOptions'=>array('class'=>'btn')
        ));?>
        </td>
        <td><?php $content = $this->renderPartial('../tips/master',array(),true);
            $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
            $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller); ?>   </td>
    </tr>
</table>
*/?>


<?php
       
        echo CHtml::link(Yii::t('mds', '{icon} Tambah Cara Masuk', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/pendaftaranPenjadwalan/CaramasukM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
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
    $("#ppcaramasuk-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
        
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ppcaramasuk-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('ppcaramasuk-m-grid');
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
                                $.fn.yiiGridView.update('ppcaramasuk-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
       });
    }
</script>