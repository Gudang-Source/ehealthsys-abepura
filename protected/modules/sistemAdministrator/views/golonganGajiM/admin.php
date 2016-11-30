<?php
    if ($this->hasTab):
?>
<fieldset class="box row-fluid">
    <legend class="rim">Pengaturan Golongan Gaji</legend>
<?php
    else:
?>
    <div class="white-container">
    <legend class="rim2">Pengaturan <b>Golongan Gaji</b></legend>
<?php
    endif;
?>


    <?php
    $this->breadcrumbs=array(
            'GolonganGaji Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //    (Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Golongan Gaji ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //    (Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Golongan Gaji', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
        $('#SAGolonganGajiM_masakerja').focus();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('golongan-gaji-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert');
   // $this->renderPartial($this->path_view_tab. '_tabMenu',array());
    ?>
    <!--<div class="biru">
        <div class="white">-->
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut search-form" style="display:none">
                <?php $this->renderPartial($this->path_view. '_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
           <!-- <div class="block-tabel">-->
                <!--<h6>Tabel <b>Golongan Gaji</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'golongan-gaji-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                            array(
                        'name'=>'golongangaji_id',
                        'value'=>'$data->golongangaji_id',
                        'filter'=>false,
                    ),
                    array(
                      'header' => 'Golongan',
                      'name' => 'golonganpegawai_id',
                      'value' => '$data->golonganpegawai->golonganpegawai_nama',
                      'filter' => CHtml::dropDownList('SAGolonganGajiM[golonganpegawai_id]', $model->golonganpegawai_id,CHtml::listData(SAGolonganPegawaiM::model()->findAll('golonganpegawai_aktif = true ORDER BY golonganpegawai_nama'), 'golonganpegawai_id', 'golonganpegawai_nama'), array('empty'=>'-- Pilih --'))
                    ),                    
                    array(
                        'header' => 'Masa Kerja',
                        'name' => 'masakerja',
                        'filter' => Chtml::activeTextField($model, 'masakerja', array('class'=>'numbers-only','style'=>'text-align:right;')),
                        'htmlOptions' => array('style'=>'text-align:right;')
                    ), 
            //	'jmlgaji',
                     array(
                        'name'=>'jmlgaji',
                        'value'=>'"Rp".MyFormatter::formatNumberForPrint($data->jmlgaji)',
                         'filter' => Chtml::activeTextField($model, 'jmlgaji', array('class'=>'numbers-only','style'=>'text-align:right;')),
                         'htmlOptions' => array('style'=>'text-align:right;')
                     ),
                    array(
                        'header' => 'Jenis Golongan',
                        'name' => 'jenisgolongan',
                        'value' => '$data->jenisgolongan',
                        'filter' => Chtml::activeTextField($model, 'jenisgolongan', array('class'=>'custom-only','style'=>'text-align:right;')),
                    ),                    
                    array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->golongangaji_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
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
//						'buttons'=>array(
//							'update' => array (
//							'visible'=>'Yii::app()->user->checkAccess("Update")',
//							),
//						),
					),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>'($data->golongangaji_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->golongangaji_id)",array("id"=>"$data->golongangaji_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->golongangaji_id)",array("id"=>"$data->golongangaji_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->golongangaji_id)",array("id"=>"$data->golongangaji_id","rel"=>"tooltip","title"=>"Hapus"));',
                        'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
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
                        $(".numbers-only").keyup(function() {
                            setNumbersOnly(this);
                        });
                        $(".custom-only").keyup(function() {
                            setCustomOnly(this);
                        });
                    }',
                )); ?>
           <!-- </div>
        </div>
    </div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Golongan Gaji', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('sistemAdministrator.views/tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#golongan-gaji-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#golongan-gaji-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';

        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',
        function(r){
            if(r){
               $.post(url, {id: id},
                    function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('golongan-gaji-m-grid');
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
        myConfirm('Yakin Akan Menghapus Data ini?','Perhatian!',
        function(r){
            if(r){
               $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('golongan-gaji-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
            }
        }); 
    }
</script>
</fieldset>
</div>