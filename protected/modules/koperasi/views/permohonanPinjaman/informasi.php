<?php $js = <<<'EOF'

$(".sidebar-collapse > a").click();

EOF;

Yii::app()->clientScript->registerScript('collapser', $js, CClientScript::POS_READY);

?>
<?php
/* @var $this PermohonanPinjamanController */

$this->breadcrumbs=array(
	'Informasi',
	'Permohonan Pinjaman',
);

Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
$('.search-form').toggle();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('pegawai-m-grid', {
data: $(this).serialize()

});
return false;
});
");
?>
<style type="text/css">
.input-group-addon{
	cursor: pointer;
}
</style>
<div class="col-md-12">
	<div class="panel panel-primary">
		<div class="panel-heading">
			<div class="panel-title">
				Persetujuan Pinjaman
			</div>
		</div>
		<div class="panel-body">
			<?php echo CHtml::link('Pencarian <i class="entypo-down-open"></i>','#',array('class'=>'search-button btn')); ?>
                    <div class="search-form" style="display: none;">
					<?php $this->renderPartial('_search',array(
					'model'=>$model,
				)); ?>
			</div><!-- search-form -->
		</div>

		<div class="panel-body">
				<?php $this->widget('bootstrap.widgets.TbGridView',array(
		'id'=>'pegawai-m-grid',
		'dataProvider'=>$model->searchInformasi(),
		'filter'=>$model,
		'itemsCssClass' => 'table-bordered datatable dataTable',
		'columns'=>array(
				array(
                'header' => 'No',
                'value' => '$this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1'
            ),
            array(
            	'name'=>'nopermohonan',
							//'header'=>'Tgl Permohonan <br>/ No Permohonan',
            	'header'=>'Surat Permohonan',
            	'type'=>'raw',
            	//'filter'=>false,
							//'value'=>'date("d/m/Y H:i", strtotime($data->tglpermohonanpinjaman))." /<br/>".$data->nopermohonan',
            	'value'=>function($data) {
								$tgl = date("d/m/Y", strtotime($data->tglpermohonanpinjaman));
								$no = $data->nopermohonan;
								$linkPermohonan = $tgl."<br/>".CHtml::link($no."<i class='entypo-print'></i>", Yii::app()->controller->createUrl("print", array("id"=>$data->permohonanpinjaman_id)), array("target"=>"_blank", "data-toggle"=>"tooltip", "title"=>"Klik untuk mencetak Surat Permohonan Pinjaman"));
								return $linkPermohonan;
							},
            ),
						array(
							'header'=>'Surat<br/>Perjanjian',
							'type'=>'raw',
							'value'=>function($data) use (&$pinjaman){
                                                                $pinjaman = PinjamanT::model()->findByPk($data->pinjaman_id);
                                                                if ($data->surat_peminjaman == 3) return "Ditolak";
                                                                else if ($data->surat_peminjaman == 1) return "Menunggu";
								// return $data->pinjaman_id;
								return CHtml::link('<i class="entypo-print"></i>', Yii::app()->controller->createUrl('/pinjaman/pinjaman/print', array('id'=>$data->pinjaman_id)), array('target'=>'_blank',  "data-toggle"=>"tooltip", "title"=>"Klik untuk mencetak Surat Perjanjian Pinjaman"))
								.$pinjaman->no_pinjaman."<br/>"
								.date("d/m/Y", strtotime($pinjaman->tglpinjaman));
							},
                                                        'filter'=>  CHtml::activeDropDownList($model, 'surat_peminjaman', array(
                                                            1 => 'Menunggu',
                                                            2 => 'Diterima',
                                                            3 => 'Dotilak',
                                                        ), array('empty'=>'-- Pilih --')),
							'htmlOptions'=>array('style'=>'text-align:center'),
						),
            array(
            	'header'=>'Golongan',
            	'name'=>'golonganpegawai_id',
            	'value'=>'$data->golonganpegawai_nama',
            	'filter'=>CHtml::activeDropDownList($model, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('condition'=>'golonganpegawai_aktif = true', 'order'=>'golonganpegawai_nama asc')), 'golonganpegawai_id', 'golonganpegawai_nama'), array('empty'=>'-- Pilih --')),
            ),
            /*
            array(
            	'header'=>'Unit',
            	'name'=>'unit_id',
            	'value'=>'$data->namaunit',
            	'filter'=>CHtml::activeDropDownList($model, 'unit_id', CHtml::listData(UnitM::model()->findAll(array('condition'=>'unit_aktif = true', 'order'=>'namaunit asc')), 'unit_id', 'namaunit'), array('empty'=>'-- Pilih --')),
            ), 
            array(
            	'name'=>'untukkeperluan',
            	'header'=>'Keperluan',
            	'filter'=>false,
            ), */
            array(
            	'name'=>'jenispinjaman_permohonan',
            	'filter'=>CHtml::activeDropDownList($model, 'jenispinjaman_permohonan', Params::jenisPinjaman(), array('empty'=>'-- Pilih --')),
            ),
            array(
					'header'=>'Sumber Potongan',
					'type'=>'raw',
					'htmlOptions'=>array('style'=>'width:90px'),
					'filter'=>CHtml::activeDropDownList($model, 'potongansumber_id',
					CHtml::listData(PotongansumberM::model()->findAll('potongansumber_aktif = true'), 'potongansumber_id', 'namapotongan'),
					array('empty'=>'-- Pilih --')),
					'value'=>function($data){
            		$func = 'dialogSumberPotongan('.$data->permohonanpinjaman_id.'); return false;';
            		if (empty($data->approval_id)) $func = $func;
            		else if ($data->status_disetujui == false) $func = 'alert("Permintaan pinjaman telah ditolak"); return false;';
            			if(!empty($data->Pinjaman)) {
								return $data->SumberPotongan."".CHtml::link("<button><i class=\'entypo-pencil\'></i>ubah</button>","#",
								 array("onclick"=>$func,"rel"=>"tooltip","title"=>"Klik untuk mengubah Sumber Potongan"));
            			}
            		},
            ),
						 /*
            array(
            	'header'=>'No Pinjaman',
            	'name'=>'nopermohonan',
           	), */
            array(
            	'name'=>'nokeanggotaan',
            	'header'=>'Nomor Anggota',
            ),
            array(
            	'name'=>'nama_pegawai',
            	'header'=>'Nama Anggota',
            ),
            //'jenispinjaman_permohonan',
            array(
            	'header'=>'Jml Permohonan',
            	'name'=>'jmlpinjaman',
            	'value'=>'MyFormatter::formatNumberForPrint($data->jmlpinjaman)',
            	'filter'=>false,
            	'htmlOptions'=>array('style'=>'text-align: right'),
            ),
            array(
            	'header'=>'Jml Pencairan',
            	'type'=>'raw',
            	'value'=>function($data) use (&$pinjaman) {
            		$func = 'return true;';
            		if (empty($data->approval_id)) $func = 'alert("Permintaan pinjaman belum disetujui"); return false;';
            		else if ($data->status_disetujui == false) $func = 'alert("Permohonan pinjaman telah ditolak"); return false;';

            		$pinjaman = PinjamanT::model()->findbyAttributes(array('permohonanpinjaman_id'=>$data->permohonanpinjaman_id));
            		if (empty($pinjaman)) {
            			return CHtml::link('<i class="entypo-publish"></i>',Yii::app()->controller->createUrl('pinjaman/index', array('permohonanId'=>$data->permohonanpinjaman_id)),array(
            				'target'=>'_blank',
            				'onclick'=>$func,
            				'data-toggle'=>'tooltip',
            				'title'=>'Klik untuk melakukan input perjanjian pinjaman',
            			)).'0';
            		} return MyFormatter::formatNumberForPrint($pinjaman->jml_pinjaman);
            	},
            	'htmlOptions'=>array('style'=>'text-align:right;'),
            ),
            //'permohonanpinjaman_id',
            /*array(
					'header'=>'Pinjaman ID',
					'type'=>'raw',
					'value'=>'$data->Pinjaman',
            ),*/
				array(
					'header'=>'Evaluasi Persetujuan',
					'type'=>'raw',
					'value'=>function($data) {
						$linkSPP = CHtml::link("<i class='entypo-print' style='color: green'></i> ", Yii::app()->controller->createUrl("/pinjaman/permohonanPinjaman/printSPP",array("id"=>$data->permohonanpinjaman_id)), array("target"=>"_blank","rel"=>"tooltip","title"=>"Klik untuk Mencetak Surat Persetujuan Pinjaman"));
						$status = "";
                                                $batal = "";
                                                if (!empty($data->approval_id)) {
                                                    if ($data->status_disetujui) {
                                                        $status = "<span class='setuju'>Disetujui</span>";
                                                        $batal = "<br/>".CHtml::link("<i class='entypo-cancel'></i>Batal", '#', array('onclick'=>'batalPinjaman('.$data->approval_id.'); return false;'));
                                                    } else {
                                                        $status = "<span class='setuju'>Tidak Disetujui</span>";
                                                    }
                                                } else {
                                                    $status = CHtml::link("<i class='entypo-check'></i>","#",
									 array("onclick"=>"dialogPersetujuan(".$data->permohonanpinjaman_id."); return false;","rel"=>"tooltip","title"=>"Klik untuk Menyetujui Permintaan Pinjaman"));
                                                }
                                                /*
                                                $status = !empty($data->approval_id)?($data->status_disetujui?
                                                        "<span class='setuju'>Disetujui</span></br>".CHtml::link("<i class='entypo-cancel'></i>Batal", '#', array('onclick'=>'return false;'))
                                                        :"<span class='setuju'>Tidak Disetujui</span>"):CHtml::link("<i class='entypo-check'></i>","#",
									 array("onclick"=>"dialogPersetujuan(".$data->permohonanpinjaman_id."); return false;","rel"=>"tooltip","title"=>"Klik untuk Menyetujui Permintaan Pinjaman"));
                                                 * 
                                                 */
						$pinjaman = PinjamanT::model()->findbyAttributes(array('permohonanpinjaman_id'=>$data->permohonanpinjaman_id));
						
                                                if (empty($pinjaman)) {
							if (!empty($data->approval_id) && $data->status_disetujui) {
								$status .= $linkSPP.$batal;
							}
						} else $status .= $linkSPP;
						return $status;
					},/*'',*/
					//'htmlOptions'=>array('class'=>'setuju'),
				), /*
				array(
					'header'=>'Print <br>Persetujuan',
					'type'=>'raw',
					'value'=>'($data->status_disetujui == false)?"-":',
					'htmlOptions'=>array('style'=>'text-align:center'),
				), */
			),
			'afterAjaxUpdate'=>'function(id, data) {
				updateWarnaStatus();
			}'
		)); ?>
		</div>
		<div class="panel-footer" style="text-align:center">
			<?php  echo Chtml::link('<i class="entypo-print"></i> Print','#', array('class' => 'btn btn-success', 'onclick'=>'iPrint(); return false;')); ?>
		</div>

	</div>
</div>
<?php echo $this->renderPartial('subview/_jsInformasi'); ?>
<?php echo Yii::app()->modal->register($this->renderPartial('subview/_dialogInformasi', null, true)); ?>
