<div class="white-container">
    <legend class="rim2">Pengaturan <b>Jenis Kegiatan</b></legend>
    <?php
    $this->breadcrumbs=array(
            'Jenis Kegiatan'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Komponen Unit ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Komponen Unit', 'icon'=>'list', 'url'=>array('index'))) ;
                    //(Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Komponen Unit', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            $('#SAKJenisKegiatanM_jeniskegiatan_nama').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('sajenis-kegiatan-m-grid', {
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
        <h6>Tabel <b>Komponen Unit</b></h6>
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'sajenis-kegiatan-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>array(
                    ////'komponenunit_id',
                    array(
                            'header' => 'ID',
                            'name'=>'jeniskegiatan_id',
                            'value'=>'$data->jeniskegiatan_id',
                            'filter'=>false,
                    ),
                    array(
                            'header' => 'Kode Jenis Kegiatan',
                            'name' => 'jeniskegiatan_kode',
                            'value' => '$data->jeniskegiatan_kode',
                            'filter' => Chtml::activeTextField($model, 'jeniskegiatan_kode', array('class'=>'custom-only'))
                    ),
                    array(
                            'header' => 'Nama Jenis Kegiatan',
                            'name' => 'jeniskegiatan_nama',
                            'value' => '$data->jeniskegiatan_nama',
                            'filter' => Chtml::activeTextField($model, 'jeniskegiatan_nama', array('class'=>'custom-only'))
                    ),
                    array(
                            'header' => 'Ruangan Jenis Kegiatan',
                            'name' => 'jeniskegiatan_ruangan',
                            'value' => '$data->jeniskegiatan_ruangan',
                            //'filter' => Chtml::activeTextField($model, 'jeniskegiatan_ruangan', array('class'=>'custom-only'))
                            'filter' => Chtml::activeDropDownList($model, 'jeniskegiatan_ruangan', LookupM::getItems('jeniskegiatan'), array('empty'=>'-- Pilih --'))
                    ),                    
                    array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->jeniskegiatan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
                    //'komponenunit_aktif',
    //                array(
    //                        'header'=>'Aktif',
    //                        'class'=>'CCheckBoxColumn',
    //                        'selectableRows'=>0,
    //                        'checked'=>'$data->komponenunit_aktif',
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
                            'update'=>array(
                                'options'=>array('rel'=>'tooltip','title'=>'Ubah Jenis Kegiatan'),
                            ),
                        ),
                    ),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>'($data->jeniskegiatan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->jeniskegiatan_id)",array("id"=>"$data->jeniskegiatan_id","rel"=>"tooltip","title"=>"Menonaktifkan Jenis Kegiatan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jeniskegiatan_id)",array("id"=>"$data->jeniskegiatan_id","rel"=>"tooltip","title"=>"Hapus Jenis Kegiatan")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jeniskegiatan_id)",array("id"=>"$data->jeniskegiatan_id","rel"=>"tooltip","title"=>"Hapus Jenis Kegiatan"));',
                        'htmlOptions'=>array('style'=>'text-align:left; width:80px'),
                    ),
            ),
           'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                });
                 $("table").find("select").each(function(){
                    cekForm(this);
                });
                $(".custom-only").keyup(function() {
                    setCustomOnly(this);
                });
            }',
        )); ?>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Jenis Kegiatan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl($this->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $tips = array(
        '0' => 'lihat',
        '1' => 'ubah',
        '2' => 'nonaktif',
        '3' => 'hapus',
        '4' => 'masterPDF',
        '5' => 'masterEXCEL',
        '6' => 'masterPRINT',
        '7' => 'pencarianlanjut',
        '8' => 'cari',
        
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#sajenis-kegiatan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sajenis-kegiatan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
							$.fn.yiiGridView.update('sajenis-kegiatan-m-grid');
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
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sajenis-kegiatan-m-grid');
                            }else if(data.status == 'gagal_form'){
                                myAlert('Maaf, Data tidak bisa dihapus, karena sedang digunakan di tabel lain.')
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
           }
	   });
    }
</script>