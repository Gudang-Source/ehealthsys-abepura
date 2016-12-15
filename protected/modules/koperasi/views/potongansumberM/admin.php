<?php
/*
$this->breadcrumbs=array(
	'Sumber Potongan'=>array('admin'),
	'Kelola',
);]
 * 
 */
/*
$this->menu=array(
array('label'=>'List Sumber Potongan','url'=>array('admin')),
array('label'=>'Create Sumber Potongan','url'=>array('create')),
);
 * 
 */ 

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('potongansumber-m-grid', {
data: $(this).serialize()
});
return false;
});
");
?>
<div class="white-container">
    <legend class='rim2'>Pengaturan <b>Sumber Potongan</b></legend>
		
<?php echo CHtml::link('Pencarian <i class="entypo-down-open"></i>','#',array('class'=>'search-button btn')); ?><div class="search-form" style="display:none">
	<?php $this->renderPartial('_search',array(
	'model'=>$model,
)); ?>
</div><!-- search-form -->
		
		
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'potongansumber-m-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'itemsCssClass' => 'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
					'name'=>'potongansumber_id',
					'filter'=>false,
					),
		'namapotongan',
		'namapotonganlainnya',
		//'potongansumber_aktif',
				array(
            	'header'=>'Status',
               'value'=>'($data->potongansumber_aktif == true ) ? "Aktif" : "Tidak Aktif"',
               'htmlOptions'=>array('style'=>'text-align:center;'),
               //'headerHtmlOptions'=>array('style'=>'vertical-align:top;text-align:center;color:#373e4a;'),
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
					'value'=>'($data->potongansumber_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->potongansumber_id)",array("id"=>"$data->potongansumber_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->potongansumber_id)",array("id"=>"$data->potongansumber_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->potongansumber_id)",array("id"=>"$data->potongansumber_id","rel"=>"tooltip","title"=>"Hapus"));',
					'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
				),
			),
		)); ?>		

		<div class="form-action">
			<?php  echo Chtml::link('Tambah Sumber Potongan',$this->createUrl('create'), array('class' => 'btn btn-success',"rel"=>"tooltip","title"=>"Klik untuk Menambahkan Data Master Sumber Potongan"))."&nbsp&nbsp";
                        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
                        
                    
                        
                        $content = $this->renderPartial('sistemAdministrator.views.tips.master',array(),true);
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
                                $.fn.yiiGridView.update('potongansumber-m-grid');
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
                                $.fn.yiiGridView.update('potongansumber-m-grid');
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
        //$('input[name="SASubsubkelompokM[subkelompok_kode]"]').focus();
    })
</script>
</div>
                        
                        
		</div>
</div>

