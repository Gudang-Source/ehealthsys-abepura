<div class="white-container">
    <legend class="rim2">Pengaturan <b>Pemeriksaan Radiologi</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sapemeriksaan Rad Ms'=>array('index'),
            'Manage',
    );

   Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('.search-form form').submit(function(){
	$.fn.yiiGridView.update('sapemeriksaan-rad-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
"); ?>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
<div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
            'model'=>$model,
    )); ?>
</div><!-- search-form -->
<!--<div class="block-tabel">-->
    <!--<h6>Tabel <b>Pemeriksaan Radiologi</b></h6>-->
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'sapemeriksaan-rad-m-grid',
        'dataProvider'=>$model->searchTabel(),
        'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-condensed',
        'columns'=>array(
                ////'pemeriksaanrad_id',
               array(
                        'name'=>'pemeriksaanrad_id',
                        'value'=>'$data->pemeriksaanrad_id',
                        'filter'=>false,

                ),
                     array(
                        'name'=>'daftartindakan_nama',
                        //'filter'=>  CHtml::listData($model->DaftarTindakanItems, 'daftartindakan_id', 'daftartindakan_nama'),
                        //'filter'=>  //CHtml::listData(DaftartindakanM::model()->findAll(array('order'=>'daftartindakan_nama')), 'daftartindakan_id','daftartindakan_nama'),
                        'value'=>'$data->daftartindakan->daftartindakan_nama',

                ),
             array(     'header'=>'Jenis Pemeriksaan',
                        'name'=>'jenispemeriksaanrad_id',
                        'filter'=>  CHtml::activeDropDownList($model, 'jenispemeriksaanrad_id', CHtml::listData(JenispemeriksaanradM::model()->findAll(array('order'=>'jenispemeriksaanrad_nama', 'condition'=>'jenispemeriksaanrad_aktif = true')), 'jenispemeriksaanrad_id','jenispemeriksaanrad_nama'), array('empty'=>'--Pilih--')),
                        'value'=>'$data->jenispemeriksaanrad->jenispemeriksaanrad_nama',

                ),
                'pemeriksaanrad_nama',
                'pemeriksaanrad_namalainnya',

                array(
                    'header'=>'<center>Status</center>',
                    'value'=>'($data->pemeriksaanrad_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
//                array(
//                        'header'=>'Aktif',
//                        'class'=>'CCheckBoxColumn',     
//                        'selectableRows'=>0,
//                        'id'=>'rows',
//                        'checked'=>'$data->pemeriksaanrad_aktif',
//                ), 

                array(
                        'header'=>Yii::t('zii','View'),
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
                        'buttons'=>array(
                            'view'=>array(
                                'options'=>array('rel'=>'tooltip','title'=>'Lihat pemeriksaan radiologi'),
                            ),
                        ),
                ),
                array(
                        'header'=>Yii::t('zii','Update'),
                        'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array (
                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                          'options'=>array('rel'=>'tooltip','title'=>'Ubah pemeriksaan radiologi'),
                                        ),
                         ),
                ),
        array(
            'header'=>'Non Aktif',
            'type'=>'raw',
            'value'=>'($data->pemeriksaanrad_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->pemeriksaanrad_id)",array("id"=>"$data->pemeriksaanrad_id","rel"=>"tooltip","title"=>"Menonaktifkan pemeriksaan radiologi"))." ".CHtml::link("", "javascript:deleteRecord($data->pemeriksaanrad_id)",array("id"=>"$data->pemeriksaanrad_id","rel"=>"tooltip","title"=>"Hapus pemeriksaan radiologi")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->pemeriksaanrad_id)",array("id"=>"$data->pemeriksaanrad_id","rel"=>"tooltip"));',
            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
        ),
            array(
            'header'=>'Hapus',
            'type'=>'raw',
            'value'=>'($data->pemeriksaanrad_id)?CHtml::link("<i class=\'icon-form-sampah\'></i> ","javascript:statusDelete($data->pemeriksaanrad_id)",array("id"=>"$data->pemeriksaanrad_id","rel"=>"tooltip","title"=>"Menghapus pemeriksaan radiologi"))." ".CHtml::link("", "javascript:deleteRecord($data->pemeriksaanrad_id)",array("id"=>"$data->pemeriksaanrad_id","rel"=>"tooltip","title"=>"Hapus pemeriksaan radiologi")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->pemeriksaanrad_id)",array("id"=>"$data->pemeriksaanrad_id","rel"=>"tooltip"));',
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
<!--</div>-->
<?php 
echo CHtml::link(Yii::t('mds', '{icon} Tambah Pemeriksaan Radiologi
            ', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
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
    $("#sapemeriksaan-rad-m-search :input[name='"+ obj.name +"']").val(obj.value);
}     
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sapemeriksaan-rad-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=1');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                    
    ?>
</div>
<script type="text/javascript">
//    function removeTemporary(id){
//        var url = '<?php echo $url."/removeTemporary"; ?>';
//        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
//            if (r){
//                 $.post(url, {id: id},
//                     function(data){
//                        if(data.status == 'proses_form'){
//                                $.fn.yiiGridView.update('sapemeriksaan-rad-m-search');
//                            }else{
//                                myAlert('Data Gagal di Nonaktifkan')
//                            }
//                },"json");
//           }
//       });
//    }
//
//    function statusDelete(id){
//        var url = '<?php echo $url."/removeTemporary"; ?>';
//        myConfirm("Yakin Akan Menghapus Data ini ?","Perhatian!",function(r) {
//            if (r){
//                 $.post(url, {id: id},
//                     function(data){
//                        if(data.status == 'proses_form'){
//                                $.fn.yiiGridView.update('sapemeriksaan-rad-m-grid');
//                            }else{
//                                myAlert('Data Gagal di Hapus')
//                            }
//                },"json");
//           }
//       });
//    }
//
//    function deleteRecord(id){
//        var id = id;
//        var url = '<?php echo $url."/delete"; ?>';
//        myConfirm("Yakin Akan Menghapus Data ini ?","Perhatian!",function(r) {
//            if (r){
//                 $.post(url, {id: id},
//                     function(data){
//                        if(data.status == 'proses_form'){
//                                $.fn.yiiGridView.update('sapemeriksaan-rad-m-grid');
//                            }else{
//                                myAlert('Data Gagal di Hapus')
//                            }
//                },"json");
//           }
//        });
//    }
function nonActive(obj){
		myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('sapemeriksaan-rad-m-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal dinonaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
    $(document).ready(function(){
        $("input[name$='ROPemeriksaanRadM[daftartindakan_nama]']").focus();
    });
</script>