<div class="white-container">
    <legend class="rim2">Pengaturan <b>Daftar Tindakan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Sadaftar Tindakan Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Daftar Tindakan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Daftar Tindakan', 'icon'=>'list', 'url'=>array('index'))) ;
                    // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Daftar Tindakan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tindakan Ruangan', 'icon'=>'file', 'url'=>array('createRuangan'))) :  '' ;


    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            $('#SADaftarTindakanM_komponenunit_id').focus();
            return false;
    });
    $('#sadaftar-tindakan-m-search').submit(function(){
            $.fn.yiiGridView.update('sadaftar-tindakan-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <div class="block-tabel">
        <h6>Tabel <b>Daftar Tindakan</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sadaftar-tindakan-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    ////'daftartindakan_id',
                    array(
                            'name'=>'daftartindakan_id',
                            'value'=>'$data->daftartindakan_id',
                            'filter'=>false,
                    ),
                 array(
                            'name'=>'komponenunit_id',
                            'filter'=>  Chtml::dropDownList('SADaftarTindakanM[komponenunit_id]',$model->komponenunit_id,CHtml::listData($model->KomponenUnitItems, 'komponenunit_id', 'komponenunit_nama'),array('empty'=>'-- Pilih --')),
                            'value'=>'$data->komponenunit->komponenunit_nama',
                    ),
                array(
                            'name'=>'kelompoktindakan_id',
                            'filter'=>  Chtml::dropDownList('SADaftarTindakanM[kelompoktindakan_id]',$model->kelompoktindakan_id,CHtml::listData($model->KelompokTindakanItems, 'kelompoktindakan_id', 'kelompoktindakan_nama'),array('empty'=>'-- Pilih --')),
                            'value'=>'$data->kelompoktindakan->kelompoktindakan_nama',
                    ),
                array(
                        'name'=>'kategoritindakan_id',
                        'filter'=>  Chtml::dropDownList('SADaftarTindakanM[kategoritindakan_id]',$model->kategoritindakan_id,CHtml::listData($model->KategoriTindakanItems, 'kategoritindakan_id', 'kategoritindakan_nama'),array('empty'=>'-- Pilih --')),
                        'value'=>'(isset($data->kategoritindakan)?$data->kategoritindakan->kategoritindakan_nama:"")',
                    ),

    ////		'komponenunit.komponenunit_nama',
    //		'kategoritindakan.kategoritindakan_nama',
    //		'kelompoktindakan.kelompoktindakan_nama',
    //		'daftartindakan_kode',
                    'daftartindakan_nama',
                     array(
                         'header'=>'Ruangan ',
                         'type'=>'raw',
                         'value'=>'$this->grid->getOwner()->renderPartial(\'_ruangan\',array(\'daftartindakan_id\'=>$data->daftartindakan_id),true)',
                     ), 
                    /*
                    'tindakanmedis_nama',
                    'daftartindakan_namalainnya',
                    'daftartindakan_katakunci',
                    'daftartindakan_karcis',
                    'daftartindakan_visite',
                    'daftartindakan_konsul',
                    'daftartindakan_akomodasi',
                    'daftartindakan_aktif',
                    */
                    array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->daftartindakan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
    //             array(
    //                        'header'=>'Aktif',
    //                        'class'=>'CCheckBoxColumn',     
    //                        'selectableRows'=>0,
    //                        'id'=>'rows',
    //                        'checked'=>'$data->daftartindakan_aktif',
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
                            'buttons'=>array(
                                'update' => array (
                                              'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                            ),
                             ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Delete'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions'=>array('style'=>'width:80px;text-align:left'),
                            'template'=>'{remove} {delete}',
                            'buttons'=>array(

                                    'remove' => array (
                                                    'label'=>"<i class='icon-form-silang'></i>",
                                                    'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
                                                    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>$data->daftartindakan_id))',
                                                    'click'=>'function(){removeTemporary(this);return false;}',
                                    ),
                                    'delete'=> array(),
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
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Daftar Tindakan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sadaftar-tindakan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sadaftar-tindakan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(obj){
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('sadaftar-tindakan-m-grid');
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
</script>