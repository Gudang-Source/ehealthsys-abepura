<div class="white-container">
    <legend class="rim2">Pengaturan <b>Paket BMHP</b></legend>
    <?php
    
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('satipe-paket-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <!--<div class="block-tabel">-->
        <!--<h6>Tabel <b>Paket Bmhp</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array( 
            'id'=>'satipe-paket-m-grid', 
            'dataProvider'=>$model->searchData(), 
            'filter'=>$model, 
			'template'=>"{summary}\n{items}\n{pager}", 
			'itemsCssClass'=>'table table-striped table-condensed', 
            'columns'=>array(
                array(
                    'header' => 'No',
                    'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
                ),
                array(
					'header'=>'Tipe Paket',
					'type'=>'raw',
					'value'=>'$data->tipepaket->tipepaket_nama',
					'filter'=>CHtml::activeDropdownList($model,'tipepaket_id',CHtml::listData(SATipePaketM::getItems(),'tipepaket_id','tipepaket_nama'),array('empty'=>'')),
                ),
                array(
					'header'=>'Kelompok Umur',
					'type'=>'raw',
					'value'=>'isset($data->kelompokumur->kelompokumur_nama) ? $data->kelompokumur->kelompokumur_nama : "-"',
					'filter'=>CHtml::activeDropdownList($model,'kelompokumur_id',CHtml::listData(SAKelompokUmurM::getItems(),'kelompokumur_id','kelompokumur_nama'),array('empty'=>'')),
                ),
                array(
					'header'=>'Daftar Tindakan',
					'type'=>'raw',
					'value'=>'isset($data->daftartindakan->daftartindakan_nama) ? $data->daftartindakan->daftartindakan_nama : "-"',
					'filter'=>CHtml::activeTextField($model,'daftartindakan_nama'),
                ),
                array(
					'header'=>'Kode Obat / Alkes',
					'type'=>'raw',
					'value'=>'isset($data->obatalkes->obatalkes_kode) ? $data->obatalkes->obatalkes_kode : "-"',
					'filter'=>CHtml::activeTextField($model,'obatalkes_kode'),
                ),
                array(
					'header'=>'Nama Obat / Alkes',
					'type'=>'raw',
					'value'=>'isset($data->obatalkes->obatalkes_nama) ? $data->obatalkes->obatalkes_nama : "-"',
					'filter'=>CHtml::activeTextField($model,'obatalkes_nama'),
                ),
				array(
					'header'=>'Satuan Kecil',
					'type'=>'raw',
					'value'=>'isset($data->satuankecil->satuankecil_nama) ? $data->satuankecil->satuankecil_nama : "-"',
					'filter'=>CHtml::activeDropdownList($model,'satuankecil_id',CHtml::listData(SASatuankecilM::getItems(),'satuankecil_id','satuankecil_nama'),array('empty'=>'')),
                ),
				array(
					'name'=>'qtypemakaian',
					'type'=>'raw',
					'value'=>'MyFormatter::formatNumberForPrint($data->qtypemakaian)',
					'filter'=>false,
                ),
				array(
					'name'=>'hargapemakaian',
					'type'=>'raw',
					'value'=>'MyFormatter::formatNumberForPrint($data->hargapemakaian)',
					'filter'=>false,
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
					'header'=>Yii::t('zii','Delete'), 
					'class'=>'bootstrap.widgets.BootButtonColumn', 
					'template'=>'{delete}', 
					'buttons'=>array( 
						'delete'=> array( 
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
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Paket Bmhp', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl(Yii::app()->controller->id.'/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial($this->path_view.'tips.master2',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>