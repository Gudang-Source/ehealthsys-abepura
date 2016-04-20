<?php
$this->breadcrumbs=array(
	'Saperiodeposting Ms'=>array('index'),
	'Manage',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
	return false;
});
$('#saperiodeposting-m-search').submit(function(){
	$.fn.yiiGridView.update('saperiodeposting-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="white-container">
	<legend class="rim2">Pengaturan <b>Periode Posting</b></legend>
	<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

	<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
	<div class="cari-lanjut2 search-form" style="display:none">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,
	)); ?>
	</div><!-- search-form -->
	<!--<div class="block-tabel">-->
		<!--<h6 class="rim2">Tabel Periode Posting</h6>-->
	<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
		'id'=>'saperiodeposting-m-grid',
		'dataProvider'=>$model->search(),
		'filter'=>$model,
		'template'=>"{summary}\n{items}\n{pager}",
		'itemsCssClass'=>'table table-striped table-bordered table-condensed',
		'columns'=>array(
			array(
				'header'=>'No.',
				'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
				'type'=>'raw',
				'htmlOptions'=>array('style'=>'text-align:right;'),
			),
			array(
				'name'=>'konfiganggaran_id',
				'value'=>'$data->konfiganggaran->deskripsiperiode',
				'filter'=> CHtml::dropDownList('SAPeriodepostingM[konfiganggaran_id]',$model->konfiganggaran_id,CHtml::listData(KonfiganggaranK::model()->findAll(array('condition'=>'isclosing_anggaran = false','order'=>'deskripsiperiode')), 'konfiganggaran_id', 'deskripsiperiode'),array('empty'=>'--Pilih--')),
			),
			array(
				'name'=>'rekperiode_id',
				'value'=>'$data->rekperiode->deskripsi',
				'filter'=>  CHtml::dropDownList('SAPeriodepostingM[rekperiode_id]',$model->rekperiode_id,CHtml::listData(RekperiodM::model()->findAll(array('condition'=>'isclosing = false', 'order'=>'deskripsi')), 'rekperiod_id', 'deskripsi'),array('empty'=>'--Pilih--')),
			),
			'periodeposting_nama',
			array(
				'name'=>'tglperiodeposting_awal',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tglperiodeposting_awal)',
				'filter'=> false,
			),
			array(
				'name'=>'tglperiodeposting_akhir',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tglperiodeposting_akhir)',
				'filter'=> false,
			),
			'deskripsiperiodeposting',
			array(
				'header'=>'<center>Status</center>',
				'value'=>'($data->periodeposting_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
				'htmlOptions'=>array('style'=>'text-align:center;'),
			),
		/*
		'create_time',
		'update_time',
		'create_loginpemakai_id',
		'update_loginpemakai_id',
		'create_ruangan',
		'periodeposting_aktif',
		'rekperiode_id',
		*/
			array(
				'header'=>Yii::t('zii','View'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{view}',
				'buttons'=>array(
					'view' => array(),
				 ),
			),
			array(
				'header'=>Yii::t('zii','Update'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{update}',
				'buttons'=>array(
					'update' => array(),
				 ),
			),
			array(
				'header'=>'Hapus',
				'type'=>'raw',
				'value'=>'($data->periodeposting_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->periodeposting_id)",array("id"=>"$data->periodeposting_id","rel"=>"tooltip","title"=>"Menonaktifkan periodeposting Pasien"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->periodeposting_id)",array("id"=>"$data->periodeposting_id","rel"=>"tooltip","title"=>"Hapus periodeposting")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->periodeposting_id)",array("id"=>"$data->periodeposting_id","rel"=>"tooltip","title"=>"Hapus periodeposting"));',
				'htmlOptions'=>array('style'=>'text-align:left; width:80px'),
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
	echo CHtml::link(Yii::t('mds','{icon} Tambah Periode Posting',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 	
        $content = $this->renderPartial($this->path_tips.'master',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));                
	$urlPrint= $this->createUrl('print');
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url= Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saperiodeposting-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
?></div>
<script type="text/javascript">	
	  function cekForm(obj)
	{
		$("#saperiodeposting-m-search :input[name='"+ obj.name +"']").val(obj.value);
	}
	function removeTemporary(id){
        var url = '<?php echo $url."/NonActive"; ?>';
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('saperiodeposting-m-grid');
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
						if(data.warning){
							myAlert('Tidak dapat menghapus data ini, karena data ini digunakan di table : bukubesar_t');
						}else{
							if(data.status == 'proses_form'){
								$.fn.yiiGridView.update('saperiodeposting-m-grid');
							}else{
								myAlert('Data Gagal di Hapus')
							}
						}
                },"json");
           }
	   });
    }
</script>