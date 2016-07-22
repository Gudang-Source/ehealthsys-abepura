<div class="white-container">
    <legend class="rim2">Pengaturan <b>Intervensi</b></legend>
	<?php
	$this->breadcrumbs = array(
		'Bataskarakteristik Ms' => array('index'),
		'Manage',
	);

	Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('bataskarakteristik-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
	?>
	<?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
    <div class="cari-lanjut search-form" style="display:none">
		<?php
		$this->renderPartial($this->path_view. '_search', array(
			'model' => $model,
		));
		?>
    </div>
    <div class='block-tabel'>
        <h6>Tabel <b>Intervensi</b></h6>
		<?php
		if (isset($_GET['sukses'])) {
			Yii::app()->user->setFlash('success', '<strong>Berhasil!</strong> Data berhasil disimpan.');
		}
		?>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php
		$this->widget('ext.bootstrap.widgets.BootGridView', array(
			'id' => 'bataskarakteristik-m-grid',
			'dataProvider' => $model->search(),
			'filter' => $model,
			'template' => "{summary}\n{items}\n{pager}",
			'itemsCssClass' => 'table table-striped table-bordered table-condensed',
			'columns' => array(
				/*
				array(
					'header' => 'ID',
					'value' => '$data->intervensidet_id',
				),*/
				array(
					'header' => 'Diagnosa Keperawatan',
					'name' => 'diagnosakep_nama',
					'value' => 'isset($data->diagnosakep_nama) ? $data->diagnosakep_nama : " - "',
				),
				array(
					'header' => 'Nama Intervensi',
					'name' => 'intervensi_nama',
					'value' => 'isset($data->intervensi->intervensi_nama) ? $data->intervensi->intervensi_nama : " - "',
				),
				array(
					'header' => 'Indikator',
					'name' => 'intervensidet_indikator',
					'value' => 'isset($data->intervensidet_indikator) ? $data->intervensidet_indikator : " - "',
				),
				array(
					'header' => 'Status',
					'value' => '($data->intervensidet_aktif == true ? \'Aktif\': \'Tidak Aktif\')',
					'filter' => CHtml::dropDownList(
						'aktif', $model->aktif, array('1' => 'Aktif',
					'0' => 'Tidak Aktif',), array('empty' => '--Pilih--'))
				),
				array(
					'header' => Yii::t('zii', 'View'),
					'class' => 'bootstrap.widgets.BootButtonColumn',
					'template' => '{view}',
					'buttons' => array(
						'view' => array(
							'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/view",array("id"=>$data->intervensi_id))',
						),
					),
				),
				array(
					'header' => Yii::t('zii', 'Update'),
					'class' => 'bootstrap.widgets.BootButtonColumn',
					'template' => '{update}',
					'buttons' => array(
						'update' => array(
							'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->intervensi_id))',
						),
					),
				),
				array(
					'header' => '<center>Hapus</center>',
					'type' => 'raw',
					'value' => '($data->intervensidet_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->intervensidet_id)",array("id"=>"$data->intervensidet_id","rel"=>"tooltip","title"=>"Menonaktifkan Intervensi"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->intervensidet_id)",array("id"=>"$data->intervensidet_id","rel"=>"tooltip","title"=>"Hapus Intervensi")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->intervensidet_id)",array("id"=>"$data->intervensidet_id","rel"=>"tooltip","title"=>"Hapus Intervensi"));',
					'htmlOptions' => array('style' => 'text-align: center; width:80px'),
				),
			),
			'afterAjaxUpdate' => 'function(id, data){
                jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
		));
		?>
    </div>
	<?php
	echo CHtml::link(Yii::t('mds', '{icon} Tambah Intervensi', array('{icon}' => '<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id . '/create', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')) . "&nbsp&nbsp";
	echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
	echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
	echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
	$content = $this->renderPartial('sistemAdministrator.views/tips/master', array(), true);
	$this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
	$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
	$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
	$url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);
	
	$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#bataskarakteristik-k-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#bataskarakteristik-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
	Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
	?>
</div>
<script>
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('bataskarakteristik-m-grid');
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
                                $.fn.yiiGridView.update('bataskarakteristik-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
        });
    }

	$(document).ready(function () {
		$("input[name='SAIntervensidetM[intervensi_nama]']").focus();
	});

</script>