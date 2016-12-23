
		<?php	$this->widget('ext.bootstrap.widgets.BootGridView',array(
				'id'=>'penangguhanangsuran-m-grid',
				'dataProvider'=>$penangguhan->searchInformasi(),
				'filter'=>null,
				'itemsCssClass' => 'table table-striped table-condensed',
				'columns'=>array(
					array(
						'name'=>'tglpermpenangguhan',
						'value'=>'date("d/m/Y", strtotime($data->tglpermpenangguhan));',
					),
					'nokeanggotaan',
					'nama_pegawai',
					'jnspenangguhan',
					array(
						'name'=>'jumlahpinjaman',
						'value'=>'MyFormatter::formatNumberForPrint($data->jumlahpinjaman)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					),
					array(
						'name'=>'kesanggupanbayar',
						'value'=>'MyFormatter::formatNumberForPrint($data->kesanggupanbayar)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					),
					array(
						'name'=>'sisapinjaman',
						'value'=>'MyFormatter::formatNumberForPrint($data->sisapinjaman)',
						'htmlOptions'=>array('style'=>'text-align: right'),
					), 
				),
				//'afterAjaxUpdate'=>'function(id, data) {registerNum(); hitungTotalAngsuran(); }',
			));
		?>
	<!--</div>
	<div class="panel-body col-sm-12">
		<?php // echo Chtml::link('<i class="entypo-print"></i> Print','#', array('class' => 'btn btn-success', 'onclick'=>'iPrint(); return false;')); ?>
	</div>
</div>-->