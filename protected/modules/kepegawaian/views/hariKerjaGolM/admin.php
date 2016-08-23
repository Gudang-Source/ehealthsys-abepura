<fieldset class="white-container">
    <legend class="rim2">Pengaturan <b>Hari Kerja Golongan</b></legend>
<?php /*
$this->breadcrumbs=array(
	'Hari Kerja Golongan  Ms'=>array('index'),
	'Manage',
); */

// $arrMenu = array();
    //(Yii::app()->user->checkAccess('Admin')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Hari Kerja Golongan  ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //(Yii::app()->user->checkAccess('Create')) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Hari Kerja Golongan ', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
                
// $this->menu=$arrMenu;

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
	$('.search-form').toggle();
    $('#KPHariKerjaGolM_jmlharikerja').focus();
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
//$this->renderPartial('_tabMenu',array());
?>

<?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut3 search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->

<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'golongan-gaji-m-grid',
	'dataProvider'=>$model->search(),
	'filter'=>$model,
        'template'=>"{pager}{summary}\n{items}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                /*
                array (
                        'name'=>'harikerjagol_id',
                        'value'=>'$data->harikerjagol_id',
                        'filter'=>false,
                ),
                 * 
                 */                
                array(
                    'header' => 'Kelompok Pegawai',
                    'name' => 'kelompokpegawai_id',
                    'value' => '$data->kelompokpegawai->kelompokpegawai_nama',
                    'filter' => Chtml::dropDownList('KPHariKerjaGolM[kelompokpegawai_id]', $model->kelompokpegawai_id, CHtml::listData(KPKelompokpegawaiM::model()->findAll('kelompokpegawai_aktif = true ORDER BY kelompokpegawai_nama ASC'),'kelompokpegawai_id','kelompokpegawai_nama'),array('empty'=>' -- Pilih --'))
                ),
		array(
                    'name'=>'periodeharikerjaawl',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->periodeharikerjaawl)',
                    'filter'=>$this->widget('MyDateTimePicker', array(
                            'model'=>$model, 
                            'attribute'=>'periodeharikerjaawl', 
                            'mode' => 'date',    
                            //'language' => 'ja',
                            // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                            'htmlOptions' => array(
                                'id' => 'datepicker_for_due_date2',
                                'size' => '10',
                                'style'=>'width:80%'
                            ),
                            'options' => array(  // (#3)                    
                                'dateFormat' => Params::DATE_FORMAT,                    
                                'maxDate' => 'd',
                            ),                            
                        ), 
                        true),
                    ),                  
                array(
                    'name'=>'periodehariakhir',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->periodehariakhir)',
                    'filter'=>$this->widget('MyDateTimePicker', array(
                            'model'=>$model, 
                            'attribute'=>'periodehariakhir', 
                            'mode' => 'date',    
                            //'language' => 'ja',
                            // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                            'htmlOptions' => array(
                                'id' => 'datepicker_for_due_date1',
                                'size' => '10',
                                'style'=>'width:80%'
                            ),
                            'options' => array(  // (#3)                    
                                'dateFormat' => Params::DATE_FORMAT,                    
                                'maxDate' => 'd',
                            ),                            
                        ), 
                        true),
                    ),                    
                array(
                    'name'=>'periodeharikerjaakhir',
                    'value'=>'MyFormatter::formatDateTimeForUser($data->periodeharikerjaakhir)',
                    'filter'=>$this->widget('MyDateTimePicker', array(
                            'model'=>$model, 
                            'attribute'=>'periodeharikerjaakhir', 
                            'mode' => 'date',    
                            //'language' => 'ja',
                            // 'i18nScriptFile' => 'jquery.ui.datepicker-ja.js', (#2)
                            'htmlOptions' => array(
                                'id' => 'datepicker_for_due_date',
                                'size' => '10',
                                'style'=>'width:80%'
                            ),
                            'options' => array(  // (#3)                    
                                'dateFormat' => Params::DATE_FORMAT,                    
                                'maxDate' => 'd',
                            ),                            
                        ), 
                        true),
                    ),                              
                array(
                    'header' => 'Jumlah Hari Bulan',
                    'name' => 'jmlharibln',
                    'value' => '$data->jmlharibln',
                    'filter'=>  CHtml::activeTextField($model, 'jmlharibln', array('class'=>'numbers-only','style'=>'text-align:right;')),
                    'htmlOptions' => array('style'=>'text-align:right;')
                ),
                array(
                        'header'=>'<center>Status</center>',
                        'value'=>'($data->harikerjagol_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
                        'buttons'=>array(
                            'update' => array (
                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                        ),
                         ),
                ),
                array(
                    'header'=>'Hapus',
                    'type'=>'raw',
                    'value'=>'($data->harikerjagol_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->harikerjagol_id)",array("id"=>"$data->harikerjagol_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->harikerjagol_id)",array("id"=>"$data->harikerjagol_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->harikerjagol_id)",array("id"=>"$data->harikerjagol_id","rel"=>"tooltip","title"=>"Hapus"));',
                    'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
                ),
	),
         'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                reinstallDatePicker();    
                reinstallDatePicker1();
                reinstallDatePicker2();
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
)); ?>

<?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Hari Kerja Golongan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
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
    $("#golongan-gaji-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#golongan-gaji-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);  

Yii::app()->clientScript->registerScript('re-install-date-picker', "
function reinstallDatePicker(id, data) {        
    $('#datepicker_for_due_date').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
function reinstallDatePicker1(id, data) {        
    $('#datepicker_for_due_date1').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
function reinstallDatePicker2(id, data) {        
    $('#datepicker_for_due_date2').datepicker(jQuery.extend({showMonthAfterYear:false},jQuery.datepicker.regional['id'],{'dateFormat':'".Params::DATE_FORMAT."','changeMonth':true, 'changeYear':true,'maxDate':'d'}));
}
");
?>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm('Apakah Anda yakin ingin menonaktifkan data ini untuk sementara?','Perhatian!',function(r){
            if (r){
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
        myConfirm('Apakah Anda yakin igin menghapus data ini ?','Perhatian!',function(r){
            if (r){
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