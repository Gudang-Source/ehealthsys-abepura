<div class="white-container">
    <legend class="rim2">Pengaturan <b>Pabrik</b></legend>
    <?php  
    $sukses = null;
    if(isset($_GET['id'])){
        $sukses = $_GET['id'];
    }
    if($sukses > 0){
        Yii::app()->user->setFlash('success',"Data Pabrik berhasil disimpan !");
    }

    ?>
    <?php
    $this->breadcrumbs=array(
            'Gfpabrik Ms'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('gfpabrik-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Pabrik</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'gfpabrik-m-grid',
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
                            'htmlOptions'=>array('style'=>'text-align:center; width:10px;'),
                    ),
                    'pabrik_kode',
                    'pabrik_nama',
                    'pabrik_namalain',
                    'pabrik_alamat',
                    'pabrik_propinsi',
                    /*
                    'pabrik_kabupaten',
                    */
                    array(
                    'header'=>'Status',
                    'type'=>'raw',
                    'value'=>'(($data->pabrik_aktif) ? "Aktif" : "Tidak Aktif")',
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
                            'header'=>Yii::t('zii','Non Aktif'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{remove}{add}',
                            'buttons'=>array(
                                    'remove' => array (
                                                    'label'=>"<i class='icon-form-silang'></i>",
                                                    'options'=>array('title'=>Yii::t('mds','Nonaktif Sementara')),
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->pabrik_id))',
                                                    'click'=>'function(){nonActive(this);return false;}',
                                                    'visible'=>'(($data->pabrik_aktif) ? TRUE : FALSE)',
                                    ),
                                    'add' => array (
                                                    'label'=>"<i class='icon-form-check'></i>",
                                                    'options'=>array('title'=>Yii::t('mds','Add Temporary')),
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/active",array("id"=>$data->pabrik_id))',
                                                    'click'=>'function(){active(this);return false;}',
                                                    'visible'=>'(($data->pabrik_aktif) ? FALSE : TRUE)',
                                    ),
                                    'delete'=> array(),
                            )
                    ),
					array(
						'header'=>'Hapus',
						'type'=>'raw',
						'value'=>'CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->pabrik_id)",array("id"=>"$data->pabrik_id","rel"=>"tooltip","title"=>"Hapus Penjamin Pasien"));',
						'htmlOptions'=>array('style'=>'width:80px'),
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
    echo CHtml::link(Yii::t('mds','{icon} Tambah Pabrik',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
	$content = $this->renderPartial('../tips/master1',array(),true);
	$this->widget('UserTips',array('type'=>'master','content'=>$content));
	$urlPrint= $this->createUrl('print');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#gfpabrik-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>'
</div>
<script type="text/javascript">	
function cekForm(obj)
{
		$("#gfpabrik-m-search :input[name='"+ obj.name +"']").val(obj.value);
}	
	
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
							$.fn.yiiGridView.update('gfpabrik-m-grid');
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
	function active(obj){
		myConfirm("Yakin akan mengaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('gfpabrik-m-grid');
							if(data.sukses > 0){
								myAlert('Data berhasil diaktifkan!');
							}else{
								myAlert('Data gagal diaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal diaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
	function deleteRecord(id){
        var id = id;
        var url = '<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id.'/'.Yii::app()->controller->id)."/delete"; ?>';
        myConfirm("Yakin Akan Menghapus Data ini ?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                            $.fn.yiiGridView.update('gfpabrik-m-grid');
                        }else{
                            myAlert(data.konfirmasi);
                        }
                },"json");
           }
		});
    }
</script>