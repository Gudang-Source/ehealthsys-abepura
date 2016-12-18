<div class="panel panel-primary col-sm-12">
	<div class="panel-heading panel-heading2">
		<div class="panel-title">Data Pengajuan Pemotongan</div>
	</div>
	<div class="panel-body col-sm-12">
		<?php	$this->widget('bootstrap.widgets.TbGridView',array(
				'id'=>'pengajuanpemotongan-m-grid',
				'dataProvider'=>$pengajuanPemotongan->searchInformasi(),
				'filter'=>null,
				'itemsCssClass' => 'table-bordered datatable dataTable',
				'columns'=>array(
					array(
						'header'=>'Tgl Pengajuan / <br/> No Pengajuan',
						'type'=>'raw',
						'value'=>function($data) {
							$link = CHtml::link('<i class="entypo-print"></i>'.$data->nopengajuan, Yii::app()->controller->createUrl('print', array('no'=>$data->nopengajuan)), array('target'=>'_blank'));
							return date("d/m/Y", strtotime($data->tglpengajuanpemb))."<br/>".$link;
						},
						'headerHtmlOptions'=>array('style'=>'text-align:center;color:#373E4A')
					), /*
					array(
						'name'=>'nopengajuan',
						'headerHtmlOptions'=>array('style'=>'text-align:center')
						), */
					array(
						'name'=>'namaunit',
						'header'=>'Unit',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
					),
					array(
						'header'=>'Sumber Potongan',
						'name'=>'namapotongan',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'type'=>'raw',
						'value'=>function($data) {
								$pengajuan = PengajuanpembayaranT::model()->findByPk($data->pengajuanpembayaran_id);
								$angsuran = JmlangsuranT::model()->findByPk($pengajuan->jmlangsuran_id);
								$pinjaman = PinjamanT::model()->findByPk($angsuran->pinjaman_id);
								$potongan = CHtml::listData(PotonganpinjamandariT::model()->findAllByAttributes(array('pinjaman_id'=>$pinjaman->pinjaman_id)), 'potongansumber_id', 'potongansumber_id');
								return
								CHtml::link($data->namapotongan.'<i class="entypo-pencil"></i>', '#', array('onclick'=>'editSumber(this); return false;', 'data-toggle'=>'tooltip', 'title'=>'Klik untuk mengubah sumber potongan')).
								CHtml::dropDownList('sumberpotongan', $data->potongansumber_id,
								CHtml::listData(PotongansumberM::model()->findAllByAttributes(array('potongansumber_id'=>$potongan)), 'potongansumber_id', 'namapotongan'),
								array('hidden'=>true, 'onchange'=>"gantiSumber(this, '".$data->nopengajuan."')"));
						},
					),
					array(
						'header'=>'No Anggota /<br/> Nama Anggota',
						'type'=>'raw',
						'name'=>'nokeanggotaan',
						'value'=>'$data->nokeanggotaan." /<br/>".$data->nama_pegawai',
						'htmlOptions'=>array('style'=>'width:100px'),
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
					),
					/*array(
						'header'=>'Nama Anggota',
						'name'=>'nama_pegawai',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
					),*/
					array(
						'header'=>'Simpanan Wajib',
						'name'=>'simpananwajib',
						'value'=>'MyFormatter::formatNumberForPrint($data->simpananwajib)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
					),
					array(
						'header'=>'Simpanan Sukarela',
						'name'=>'simpanansukarela',
						'value'=>'MyFormatter::formatNumberForPrint($data->simpanansukarela)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
					),
					array(
						'header'=>'Pokok Angsuran',
						'name'=>'jmlpokok_pengangs',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpokok_pengangs)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
					),
					array(
						'header'=>'Jasa Angsuran',
						'name'=>'jmljasaangs_pengangs',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmljasaangs_pengangs)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
					),
					array(
						'header'=>'Denda Angsuran',
						'name'=>'jmldendaangs_pengangs',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmldendaangs_pengangs)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
					),
					array(
						'header'=>'Total Pengajuan',
						'name'=>'jmlpengajuan_pengangsuran',
						'value'=>'MyFormatter::formatNumberForPrint($data->jmlpengajuan_pengangsuran)',
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
					),
					array(
						'header'=>'Sisa Pengajuan',
						'type'=>'raw',
						'value'=>function($data) use (&$is_sisa) {
							$is_sisa = false;
							$sisa = $data->jmlpengajuan_pengangsuran;
							$angsuran = PembayaranangsuranT::model()->findAllByAttributes(array('pengajuanpembayaran_id'=>$data->pengajuanpembayaran_id));

							if (count($angsuran) != 0) {
								$sisa -= $data->simpananwajib + $data->simpanansukarela;
								foreach ($angsuran as $item) $sisa -= $item->jmlbayar_pembangsuran;
							}

							if ($sisa != 0) $is_sisa = true;
							//return MyFormatter::formatNumberForPrint($data->simpananwajib);
							//return MyFormatter::formatNumberForPrint($data->pengajuanpembayaran_id);
							return MyFormatter::formatNumberForPrint($sisa);
						},
						'headerHtmlOptions'=>array('style'=>'text-align:center'),
						'htmlOptions'=>array('style'=>'text-align:right'),
					),
					array(
						'header'=>'Transaksi <br/>Penerimaan',
						'type'=>'raw',
						'value'=>function($data) use (&$is_sisa) {
							if ($is_sisa) return CHtml::link("<i class='entypo-credit-card'></i>", Yii::app()->createUrl("pinjaman/penerimaanPengajuan/index", array("no"=>$data->nopengajuan)), array("target"=>"_blank","rel"=>"tooltip","title"=>"Klik untuk melakukan transaksi penerimaan"));
							return '-';
						},
						//'CHtml::link("<i class=\'entypo-credit-card\'></i>", Yii::app()->createUrl("pinjaman/penerimaanPengajuan/index", array("no"=>$data->nopengajuan)), array("target"=>"_blank","rel"=>"tooltip","title"=>"Klik untuk melakukan transaksi penerimaan"))',
						'headerHtmlOptions'=>array('style'=>'text-align:center;color:#373E4A'),
						'htmlOptions'=>array('style'=>'text-align:center'),
					),
				),
				//'afterAjaxUpdate'=>'function(id, data) {registerNum(); hitungTotalAngsuran(); }',
			));
		?>
	</div>
</div>
<?php echo Yii::app()->modal->register($this->renderPartial('subview/_dialogRincianPengajuan', null, true)); ?>


<?php $url = $this->createUrl('informasi'); ?>

<script type="text/javascript">

function gantiSumber(obj, id) {
	$.post('<?php echo $url; ?>', {
		ajax:true,
		f:'gantiSumber',
		param:{val:$(obj).val(), id:id}
	}, function(data) {
		$("#btn-cari").click();
	});
}

function editSumber(obj) {
	$(obj).hide();
	$(obj).parent().find('#sumberpotongan').show();
}

function dialogRincian(id) {
	alert(id);
		$("#dialog_rincian").modal("show");
}
</script>
