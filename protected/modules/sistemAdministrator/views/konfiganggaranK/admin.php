<div class="white-container">
    <legend class='rim2'>Master <b>Periode Anggaran</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Agkonfiganggaran Ks'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('agkonfiganggaran-k-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,'format'=>$format,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Periode Anggaran</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'agkonfiganggaran-k-grid',
            'dataProvider'=>$model->search(),
    //	'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    array(
                            'header'=>'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                                            ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                            : ($row+1)',
                            'type'=>'raw',
                            'htmlOptions'=>array('style'=>'text-align:center; width:5px;'),
                    ),
                    array(
                            'name'=>'Periode Anggaran',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->tglanggaran)',
                    ),
                    array(
                            'name'=>'Sampai Dengan',
                            'type'=>'raw',
                            'value'=>'MyFormatter::formatDateTimeForUser($data->sd_tglanggaran)',
                    ),
                    'deskripsiperiode',
                    array(
                            'header'=>'Status Closing',
                            'type'=>'raw',
                            'value'=>'(($data->isclosing_anggaran) ? "Aktif" : "Tidak Aktif")',
                    ),
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
                'value'=>'($data->isclosing_anggaran)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:nonActive($data->konfiganggaran_id)",array("id"=>"$data->konfiganggaran_id","rel"=>"tooltip","title"=>"Klik untuk menonaktifkan closing anggaran"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->konfiganggaran_id)",array("id"=>"$data->konfiganggaran_id","rel"=>"tooltip","title"=>"Klik untuk menghapus periode anggaran")):CHtml::link("<i class=\'icon-form-check\'></i> ","javascript:active($data->konfiganggaran_id)",array("id"=>"$data->konfiganggaran_id","rel"=>"tooltip","title"=>"Klik untuk mengaktifkan closing anggaran"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->konfiganggaran_id)",array("id"=>"$data->konfiganggaran_id","rel"=>"tooltip","title"=>"klik untuk menghapus periode anggaran"));',
                'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
            ),
            ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
        )); ?>
    <!--</div>-->
    <?php 
    echo CHtml::link(Yii::t('mds','{icon} Tambah Periode Anggaran',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial($this->path_view.'tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
    $urlPrint= $this->createUrl('print');
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#agkonfiganggaran-k-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>
</div>
<script type="text/javascript">	
	function deleteRecord(id){
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm("Yakin Akan Menghapus Data ini ?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('agkonfiganggaran-k-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
       });
    }
	function nonActive(id){
        var url = '<?php echo $url."/nonActive"; ?>';
		myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
			if(r){ 
				$.post(url, {id: id},
				 function(data){
					if(data.status == 'proses_form'){
							$.fn.yiiGridView.update('agkonfiganggaran-k-grid');
						}else{
							myAlert('Data Gagal di Nonaktifkan')
						}
				},"json");
			}
		});
	}
	function active(id){
        var url = '<?php echo $url."/active"; ?>';
		myConfirm("Yakin akan mengaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('agkonfiganggaran-k-grid');
                            }else{
                                myAlert('Data Gagal di Aktifkan')
                            }
					},"json");
				}
			}
		);
	}
</script>