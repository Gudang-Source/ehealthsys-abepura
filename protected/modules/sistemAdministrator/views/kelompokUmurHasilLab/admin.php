<fieldset class="box">
    <legend class="rim">Pengaturan Kelompok Umur</legend>
            <?php
            $this->breadcrumbs=array(
                    'Lbkelkumurhasillab Ms'=>array('index'),
                    'Manage',
            );

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('lbkelkumurhasillab-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");
            ?>
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut search-form" style="display:none">
                <?php $this->renderPartial($this->path_view.'_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
            <!--<div class="block-tabel">-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'lbkelkumurhasillab-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(
                            array(
                                    'header'=>'No.',
                                    'value' => '($this->grid->dataProvider->pagination) ? 
                                                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                                    : ($row+1)',
                                    'type'=>'raw',
                                    'htmlOptions'=>array('style'=>'text-align:right;'),
                            ),
                            ////'kelkumurhasillab_id',
                            array(
                                    'name'=>'kelkumurhasillab_id',
                                    'value'=>'$data->kelkumurhasillab_id',
                                    'filter'=>false,
                            ),
                            'kelkumurhasillabnama',
                            'umurminlab',
                            'umurmakslab',
                            //'satuankelumur',//
                             array(
                                    'name'=>'satuankelumur',
                                    'value'=>'$data->satuankelumur',
                                    'filter'=> CHtml::dropDownList('SAKelkumurhasillabM[satuankelumur]',$model->satuankelumur, LookupM::getItems(Params::LOOKUPTYPE_SATUAN_KELOMPOK_UMUR),array('empty'=>'--Pilih--','class'=>'span3 satuankelumur',  'onchange'=>'setHariLab()')),                                    
                            ),
                            'kelkumurhasillab_urutan',
                            array(
                                    'header'=>'Status',
                                    'value'=>'($data->kelkumurhasillab_aktif == 1 )? "Aktif" : "Tidak Aktif"',
            //			'filter'=>  CHtml::listData($model->getStatus, 'kelkumurhasillab_id', 'kelkumurhasillab_nama'),
                                    'htmlOptions'=>array('style'=>'text-align:center;'),
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
                                    'header'=>Yii::t('zii','Delete'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{add} {remove} {delete}',
                                    'buttons'=>
                                    array(
                                            'add' => array (
                                                            'label'=>"<i class='icon-form-check'></i>",
                                                            'options'=>array('title'=>Yii::t('mds','Active Temporary')),
                                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/active",array("id"=>$data->kelkumurhasillab_id))',
                                                            'visible'=>'($data->kelkumurhasillab_aktif) ? FALSE : TRUE',
                                                            'click'=>'function(){active(this);return false;}',
                                            ),
                                            'remove' => array (
                                                            'label'=>"<i class='icon-form-silang'></i>",
                                                            'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                            'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/nonActive",array("id"=>$data->kelkumurhasillab_id))',
                                                            'visible'=>'($data->kelkumurhasillab_aktif) ? TRUE : FALSE',
                                                            'click'=>'function(){nonActive(this);return false;}',
                                            ),
                                            'delete'=> array(
                                                      'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete", array("id"=>"$data->kelkumurhasillab_id"))',
                                                      'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus' ),
                                            ),
                                    )
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
    //echo CHtml::link(Yii::t('mds','{icon} Tambah Kelompok Umur Hasil Lab',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
    echo CHtml::link(Yii::t('mds','{icon} Tambah Kelompok Umur',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial($this->path_view.'tips.tipsAdmin',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $urlPrint= $this->createUrl('print');
	
$js = <<< JSCRIPT
function cekForm(obj)
{
    $("#lbkelkumurhasillab-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#lbkelkumurhasillab-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);    
    ?>
<script type="text/javascript">	
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
							$.fn.yiiGridView.update('lbkelkumurhasillab-m-grid');
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
							$.fn.yiiGridView.update('lbkelkumurhasillab-m-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal diaktifkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dinonaktifkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
</script>
</fieldset>