<div class="white-container">
    <?php
    $this->breadcrumbs=array(
            'Penerimaanlinen Ts'=>array('index'),
            'Manage',
    );

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('informasipenerimaanlinen-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
    ?>
    <legend class="rim2">Informasi Penerimaan <b>Linen (Ruangan)</b></legend>
    <div class="block-tabel">
	<h6>Tabel <b>Penerimaan Linen</b></h6>
		<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'informasipenerimaanlinen-grid',
			'dataProvider'=>$modPengirimanlinen->searchInformasi(),
			'template'=>"{summary}\n{items}\n{pager}",
			'itemsCssClass'=>'table table-striped table-bordered table-condensed',
			'columns'=>array(
				array(
					'header'=>'No.',
					'value' => '($this->grid->dataProvider->pagination) ? 
							($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
							: ($row+1)',
					'type'=>'raw',
					'htmlOptions'=>array('style'=>'text-align:left; width:30px;'),
				),
				array(
					'header'=>'No. Pengiriman',
					'type'=>'raw',
					'value'=>'$data->nopengirimanlinen',
				),
				array(
					'header'=>'Tanggal Pengiriman',
					'type'=>'raw',
					'value'=>'MyFormatter::formatDateTimeForUser($data->tglpengirimanlinen)',
				),
				array(
					'name'=>'keterangan_pengiriman',
					'type'=>'raw',
					'value'=>'$data->keterangan_pengiriman',
				),
				array(
					'header'=>'Terima Linen',
					'type'=>'raw',
					'value'=>'CHtml::link("<button class=\'btn btn-success\'><i class=\'icon-ok icon-white\'></i> Proses</button>",  Yii::app()->controller->createUrl("/laundry/PenerimaanLinenRuanganT/index",array("id"=>$data->pengirimanlinen_id)),array("rel"=>"tooltip","title"=>"Klik untuk Penerimaan Linen","disabled"=>true));',    'htmlOptions'=>array('style'=>'text-align: left; width:100px')
				),
				array(
					'header'=>Yii::t('zii','Batal'),
					'class'=>'bootstrap.widgets.BootButtonColumn',
					'template'=>'{remove}',
					'buttons'=>array(
						'remove' => array (
								'label'=>"<i class='icon-form-silang'></i>",
								'options'=>array('title'=>Yii::t('mds','Remove Temporary')),
								'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/batalPengiriman",array("id"=>$data->pengirimanlinen_id))',
								'click'=>'function(){batalPengiriman(this);return false;}',
//								'visible'=>'(($data->ruangan_id == Yii::app()->user->getState("ruangan_id"))? TRUE : FALSE)'
						),
					),
					'htmlOptions'=>array('style'=>'text-align: left; width:40px')
				),
			),
			'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
		)); ?>
    </div>
    <fieldset class="box search-form">
            <?php $this->renderPartial($this->path_view.'_search',array(
                    'modPengirimanlinen'=>$modPengirimanlinen,'format'=>$format
            )); ?>
    </fieldset><!-- search-form -->
</div>
<script type="text/javascript">	
	function batalPengiriman(obj){
		myConfirm("Yakin akan membatalkan data ini untuk sementara?","Perhatian!",
			function(r){
				if(r){ 
					$.ajax({
						type:'GET',
						url:obj.href,
						data: {},//
						dataType: "json",
						success:function(data){
							$.fn.yiiGridView.update('informasipenerimaanlinen-grid');
							if(data.sukses > 0){
							}else{
								myAlert('Data gagal dibatalkan!');
							}
						},
						error: function (jqXHR, textStatus, errorThrown) { myAlert('Data gagal dibatalkan!'); console.log(errorThrown);}
					});
				}
			}
		);
		return false;
	}
</script>