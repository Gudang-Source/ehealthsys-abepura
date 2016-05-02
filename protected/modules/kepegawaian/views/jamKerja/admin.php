<!--<div class="white-container">
    <legend class="rim2">Pengaturan <b>Jam Kerja</b></legend>-->
<fieldset class="box row-fluid">
    <legend class="rim">Pengaturan Jam Kerja</legend>
    <?php
    $this->breadcrumbs=array(
            'Kpjamkerja Ms'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('kpjamkerja-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    //$this->renderPartial('_tabMenu',array());
    ?>
    <!--<div class="biru">
        <div class="white">-->
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut3 search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
            <!--<div class="block-tabel">-->
                <!--<h6>Tabel <b>Jam Kerja</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'kpjamkerja-m-grid',
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
                            ////'jamkerja_id',
							array(
								'header'=>'Nama Shift',
								'value'=>'$data->shift->shift_nama',
								'filter'=> CHtml::activeDropDownList($model,'shift_id',CHtml::listData(ShiftM::model()->findAll(), "shift_id", "shift_nama"),array('empty'=>'--Pilih--')),
							),
                            'jamkerja_nama',
                            'jammasuk',
                            'jampulang',
                            'jamisitrahat',
                            /*
                            'jammasukistirahat',
                            'jammulaiscanmasuk',
                            'jamakhirscanmasuk',
                            'jammulaiscanplng',
                            'jamakhirscanplng',
                            'toleransiterlambat',
                            'toleransiplgcpt',
                            'jamkerja_aktif',
                            */
							array(
                                'header'=>'<center>Status</center>',
                                'value'=>'($data->jamkerja_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
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
									'header'=>'Hapus',
									'type'=>'raw',
									'value'=>'($data->jamkerja_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->jamkerja_id)",array("id"=>"$data->jamkerja_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jamkerja_id)",array("id"=>"$data->jamkerja_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->jamkerja_id)",array("id"=>"$data->jamkerja_id","rel"=>"tooltip","title"=>"Hapus"));',
									'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
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
        <!--</div>
    </div>-->
    <?php 
    echo CHtml::link(Yii::t('mds','{icon} Tambah Jam Kerja',array('{icon}'=>'<i class="icon-plus icon-white"></i>')),$this->createUrl($this->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp"; 
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
    $("#kpjamkerja-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
		
function print(caraPrint){
	window.open("${urlPrint}/"+$('#kpjamkerja-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
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
                                $.fn.yiiGridView.update('kpjamkerja-m-grid');
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
                                $.fn.yiiGridView.update('kpjamkerja-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
            }
        }); 
    }
</script>
</fieldset>