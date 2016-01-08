<div class="white-container">
    <?php
    Yii::app()->clientScript->registerScript('search', "
    $('#pengajuansterilisasi-info-search').submit(function(){
            $('#informasipengajuansterilisasi-grid').addClass('animation-loading');
            $.fn.yiiGridView.update('informasipengajuansterilisasi-grid', {
                            data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <legend class="rim2">Informasi <b>Pengajuan Sterilisasi</b></legend>
    <div class="block-tabel">
	<h6>Tabel <b>Pengajuan Sterilisasi</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasipengajuansterilisasi-grid',
			'dataProvider'=>$model->searchInformasi(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'No. Pengajuan',
					'type'=>'raw',
					'value'=>'$data->pengajuansterlilisasi_no',
				),
				array(
					'header'=>'Tanggal Pengajuan',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->pengajuansterlilisasi_tgl)',
				),
				array(
					'header'=>'Instalasi',
					'type'=>'raw',
					'value'=>'$data->ruangan->instalasi->instalasi_nama',
				),
				array(
					'header'=>'Ruangan',
					'type'=>'raw',
					'value'=>'$data->ruangan->ruangan_nama',
				),
				array(
					'header'=>'Keterangan',
					'type'=>'raw',
					'value'=>'$data->pengajuansterlilisasi_ket',
				),
				array(
					'header'=>'Lihat Detail',
					'type'=>'raw',
					'value'=>'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/informasiPengajuanSterilisasi/detail",array("id"=>$data->pengajuansterlilisasi_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Pengajuan Sterilisasi", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));','htmlOptions'=>array('style'=>'text-align: center; width:40px')
				),
				array(
					'header'=>Yii::t('zii','Batal'),
					'class'=>'bootstrap.widgets.BootButtonColumn',
					'template'=>'{remove}',
					'buttons'=>array(
						'remove' => array (
								'label'=>"<i class='icon-form-silang'></i>",
								'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
								'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/batalPengajuanSteril",array("id"=>$data->pengajuansterlilisasi_id))',
								'click'=>'function(){batalPengiriman(this);return false;}',
//								'visible'=>'(($data->ruangan_id == Yii::app()->user->getState("ruangan_id"))? TRUE : FALSE)'
						),
					),
					'htmlOptions'=>array('style'=>'text-align: center; width:40px')
				),
			),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
		)); ?>
    </div>
    <fieldset class="box search-form">
	<?php $this->renderPartial($this->path_view.'_search',array(
		'model'=>$model,'format'=>$format
	)); ?>
    </fieldset><!-- search-form -->
</div>
<?php $this->renderPartial($this->path_view.'_jsFunctions',array()); ?>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Pengajuan Sterilisasi',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'resizable' => false,
    ),
));

echo '<iframe src="" name="frameDetail" width="100%" height="500">
</iframe>';

$this->endWidget();
?>