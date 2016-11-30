
<div class="white-container">
    <legend class='rim2'>Pengaturan <b>Kurs Rp.</b></legend>
    <?php
        $this->breadcrumbs=array(
                'Kursrp Ms'=>array('index'),
                'Manage',
        );

    $arrMenu = array();
    //(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Kurs Rp. ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    $this->menu=$arrMenu;
    Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
                $('.search-form').toggle();
                $('#KUKursrpM_matauang_id').focus();
                return false;
        });
        $('.search-form form').submit(function(){
                $.fn.yiiGridView.update('kursrp-m-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
    ");

        $this->widget('bootstrap.widgets.BootAlert'); 
    ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Kurs Rp.</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',  
			array('id'=>'kursrp-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-bordered table-condensed',
            'columns'=>  array(
				array(
                            'header'=>'No',
                            'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
                    ),
                    array(
                            'header'=>'Mata Uang',
                            'name'=>'matauang_id',
                            'filter'=> CHtml::dropDownList('KUKursrpM[matauang_id]',$model->matauang_id,CHtml::listData(MatauangM::model()->findAll("matauang_aktif = TRUE ORDER BY matauang ASC"),'matauang_id','matauang'),array('empty'=>'-- Pilih --')),
                            'value'=>'isset($data->matauang_id)?$data->matauang->matauang:"-"',
						    
                    ),
					array(
                        'name'=>'tglkursrp',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tglkursrp)',
                        'filter'=>$this->widget('MyDateTimePicker',array(
                                        'model'=>$model,
                                        'attribute'=>'tglkursrp',
                                        'mode'=>'date',
                                        'options'=> array(
                                            'dateFormat'=>Params::DATE_FORMAT,
                                            ),
                                        'htmlOptions'=>array('readonly'=>false, 'class'=>'dtPicker3','id'=>'tglkursrp'),
                                        ),true
                                    ),
                        'htmlOptions'=>array('width'=>'80','style'=>'text-align:center'),
                    ),
                    array(
                        'header' => 'Nilai',
                        'name' => 'nilai',
                        'value' => 'number_format($data->nilai,0,"",".")',
                        'htmlOptions' => array('style' => 'text-align:right'),                        
                        'filter'=>CHtml::activeTextField($model,'nilai',array('class'=>'integer2','style'=>'text-align:right;', 'onkeypress' => "return $(this).focusNextInputField(event);",'onblur'=>"$.fn.yiiGridView.update('kursrp-m-grid',{data: $(this).serialize()});return false;" )),
                    ),
//                    'rupiah',
                    array(
                            'header'=>'Rupiah',
                            'name' => 'rupiah',
                            //'filter'=>  CHtml::activeTextField($model, 'rupiah'),
                            'value'=>'"Rp".number_format($data->rupiah,0,"",".")',
                            'htmlOptions' => array('style' => 'text-align:right'),
                            'filter'=>CHtml::textField('KUKursrpM[rupiah]',$model->rupiah,array('class'=>'integer2','style'=>'text-align:right;', 'onkeypress' => "return $(this).focusNextInputField(event);",'onblur'=>"$.fn.yiiGridView.update('kursrp-m-grid',{data: $(this).serialize()});return false;" )),
                    ),
                    array(
                            'header'=>'Status',
                            'value'=>'($data->kursrp_aktif == 1) ? "Aktif" : "Tidak Aktif" ',
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
                'value'=>'($data->kursrp_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->kursrp_id)",array("id"=>"$data->kursrp_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->kursrp_id)",array("id"=>"$data->kursrp_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->kursrp_id)",array("id"=>"$data->kursrp_id","rel"=>"tooltip","title"=>"Hapus"));',
                'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
								),
            ),
//            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
			'afterAjaxUpdate'=>'function(id, data){
                 jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                 jQuery(\'#tglkursrp\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tglkursrp_date\').on(\'click\', function(){jQuery(\'#tglkursrp\').datepicker(\'show\');});
                
				jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                });
                 $("table").find("select").each(function(){
                    cekForm(this);
                });
                $(".integer2").keyup(function() {
                         $(this).val(formatInteger($(this).val()));                         
                    });
            }',
		   )); ?>
    <!--</div>-->
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Kurs Rp.', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
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
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#kursrp-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
	function cekForm(obj)
	{
		$("#kursrp-m-search :input[name='"+ obj.name +"']").val(obj.value);
	}
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Apakah Anda ingin menonaktifkan data ini untuk sementara?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('kursrp-m-grid');
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
        myConfirm("Apakah Akan yakin ingin menghapus item ini ?",'Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
						 if(data.warning){
							 myAlert(data.pesan);
						 }else{
							if(data.status == 'proses_form'){
								$.fn.yiiGridView.update('kursrp-m-grid');
							}else{
								myAlert('Data Gagal	 di Hapus')
							}
						 }
                },"json");
           }
        });
    }
</script>