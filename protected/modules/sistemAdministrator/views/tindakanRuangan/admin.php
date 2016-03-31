<div class="white-container">
    <legend class="rim2">Pengaturan <b>Tindakan Ruangan</b></legend>
    <?php
    $this->breadcrumbs=array(
        'Saruangan Ms'=>array('index'),
        'Manage',
    );
    Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#SATindakanruanganM_instalasi_nama').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('saruangan-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");
    
	$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
	$module = Yii::app()->controller->module->id;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php  echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut search-form" style="display:none">
    <?php $this->renderPartial($this->path_view.'_search',array(
        'model'=>$model,
    )); ?>
    </div><!-- search-form -->
    <!--<legend class='rim'>Tabel Tindakan Ruangan</legend>-->
    <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'saruangan-m-grid',
        'dataProvider'=>$model->search(),
        'filter'=>$model,
            'template'=>"{summary}\n{items}{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
        'columns'=>array(                        
			array(
				'header'=>'Kelompok Tindakan',
				'name'=>'kelompoktindakan_nama',
				'value'=>'isset($data->daftartindakan->kelompoktindakan->kelompoktindakan_nama)?$data->daftartindakan->kelompoktindakan->kelompoktindakan_nama:" - "',
//				'filter'=>true,
                                'filter' => CHtml::dropDownList("SATindakanruanganM[kelompoktindakan_nama]",$model->kelompoktindakan_nama,CHtml::listData(KelompoktindakanM::model()->findAll("kelompoktindakan_aktif = TRUE ORDER BY kelompoktindakan_nama ASC"), 'kelompoktindakan_nama', 'kelompoktindakan_nama'),array('empty'=>'--Pilih--')),
				  ),
                        array(
				'header'=>'Komponen Unit',
				'name'=>'komponenunit_nama',
				'value'=>'isset($data->daftartindakan->komponenunit->komponenunit_nama)?$data->daftartindakan->komponenunit->komponenunit_nama:" - "',
                                //'filter' => CHtml::dropDownList("SATindakanruanganM[kategoritindakan_nama]",$model->kategoritindakan_nama,CHtml::listData(KategoritindakanM::model()->findAll("kategoritindakan_aktif = TRUE ORDER BY kategoritindakan_nama ASC"), 'kategoritindakan_nama', 'kategoritindakan_nama'),array('empty'=>'--Pilih--')),
				  ),
			array(
				'header'=>'Kategori Tindakan',
				'name'=>'kategoritindakan_nama',
				'value'=>'isset($data->daftartindakan->kategoritindakan->kategoritindakan_nama)?$data->daftartindakan->kategoritindakan->kategoritindakan_nama:" - "',
                                'filter' => CHtml::dropDownList("SATindakanruanganM[kategoritindakan_nama]",$model->kategoritindakan_nama,CHtml::listData(KategoritindakanM::model()->findAll("kategoritindakan_aktif = TRUE ORDER BY kategoritindakan_nama ASC"), 'kategoritindakan_nama', 'kategoritindakan_nama'),array('empty'=>'--Pilih--')),
				  ),
			array(
				'header'=>'Kode Tindakan',
				'name'=>'daftartindakan_kode',
				'value'=>'isset($data->daftartindakan->daftartindakan_kode)?$data->daftartindakan->daftartindakan_kode:" - "',
			),
			array(
				'header'=>'Nama Tindakan',
				'name'=>'daftartindakan_nama',
				'value'=>'isset($data->daftartindakan->daftartindakan_nama)?$data->daftartindakan->daftartindakan_nama:" - "',
			),
			array(
				'header'=>Yii::t('zii','View'),
				'class'=>'bootstrap.widgets.BootButtonColumn',
				'template'=>'{view}',
				'buttons'=>array(
								'view' => array (
										'label'=>"<i class='icon-view'></i>",
										'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/view",array("idRuangan"=>"$data->ruangan_id","idTindakan"=>"$data->daftartindakan_id"))',
										'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat Tindakan Ruangan' ),
								),
				)
            ),
			array(
					'header'=>'Hapus',
					'class'=>'ext.bootstrap.widgets.BootButtonColumn',
					'template'=>'{delete}',
					'buttons'=>array(
						'delete'=>array(
								'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/Delete",array("ruangan_id"=>"$data->ruangan_id","daftartindakan_id"=>"$data->daftartindakan_id"))',
						),
					),
			),
        ),
            'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); ?>

    <?php 

    echo CHtml::link(Yii::t('mds', '{icon} Tambah Tindakan Ruangan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp" :  '' ;
    echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp" :  '' ;
    echo (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp" :  '' ;
    $content = $this->renderPartial($this->path_view.'tips.tipsAdmin',array(),true);
    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);
$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#saruangan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
?>
<script type="text/javascript">
    $(document).ready(function(){
        $('input[name="SATindakanruanganM[daftartindakan_nama]"]').focus();
    });
</script>
</div>