<!-- <div class="row-fluid">
  <div class="span12"><legend class="rim2">Klasifikasi Pasien</legend><br />
  </div>
</div>
<?php $this->renderPartial('_tab'); ?> -->
<?php
$this->breadcrumbs=array(
	'Ppcarabayar Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#PPCarabayarM_carabayar_nama').focus();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('ppcarabayar-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");

$this->widget('bootstrap.widgets.BootAlert'); ?>

<?php 
echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="search-form cari-lanjut" style="display:none">
<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
<!--<legend class="rim">Tabel Cara Bayar</legend>-->

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'ppcarabayar-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{summary}\n{items}{pager}",
        'itemsCssClass'=>'table table-bordered table-striped table-condensed',
	'columns'=>array(
		////'carabayar_id',
		array(
                        'name'=>'carabayar_id',
                        'value'=>'$data->carabayar_id',
                        'filter'=>false,
                ),
		'carabayar_nama',
		'carabayar_namalainnya',
		'metode_pembayaran',
		//'carabayar_aktif',
		'carabayar_loket',
		/*
		'carabayar_singkatan',
		'carabayar_nourut',
		*/
                array(
                    'header'=>'Status',
                    'value'=>'($data->carabayar_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                ),
//                array(
//                    'header'=>'Aktif',
//                    'class'=>'CCheckBoxColumn',
//                    'selectableRows'=>0,
//                    'id'=>'rows',
//                    'checked'=>'$data->carabayar_aktif',
//                    
//                ),
                array(
                    'header'=>Yii::t('zii','View'),
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=icon-form-lihat></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("id"=>$data->carabayar_id)),
                                 array("class"=>"view",
                                       "rel"=>"tooltip",
                                       "title"=>"Lihat Cara Bayar",
                         ))',
                 ),
                array(
                    'header'=>Yii::t('zii','Update'),
                    'type'=>'raw',
                    'value'=>'CHtml::Link("<i class=icon-form-ubah></i>",Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/update",array("id"=>$data->carabayar_id)),
                                 array("class"=>"update",
                                       "rel"=>"tooltip",
                                       "title"=>"Ubah Cara Bayar",
                         ))',
                 ),
        array(
            'header'=>'Hapus',
            'type'=>'raw',
            'value'=>'($data->carabayar_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->carabayar_id)",array("id"=>"$data->carabayar_id","rel"=>"tooltip","title"=>"Menonaktifkan Cara Bayar"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->carabayar_id)",array("id"=>"$data->carabayar_id","rel"=>"tooltip","title"=>"Hapus Cara Bayar")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->carabayar_id)",array("id"=>"$data->carabayar_id","rel"=>"tooltip","title"=>"Hapus Cara Bayar"));',
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
        <td width="12%"><?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="search-form" style="display:none">
            <?php $this->renderPartial('_search',array(
                'model'=>$model,
            )); ?>
            </div><!-- search-form --></td>
        <td width="13%"><?php echo CHtml::link(Yii::t('mds', '{icon} Tambah Cara Bayar', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/pendaftaranPenjadwalan/carabayarM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'));?></td>
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

        echo CHtml::link(Yii::t('mds', '{icon} Tambah Cara Bayar', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/pendaftaranPenjadwalan/carabayarM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";       
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
    $("#ppcarabayar-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#ppcarabayar-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('ppcarabayar-m-grid');
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
                                $.fn.yiiGridView.update('ppcarabayar-m-grid');
                            }else{
                                myAlert('Data gagal dihapus karena data digunakan oleh Master Penjamin Pasien.');
                            }
                },"json");
           }
       });
    }
</script>