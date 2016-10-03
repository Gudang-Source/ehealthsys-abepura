<div class="white-container">

<?php


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
    
    <legend class="rim2">Informasi Pegawai</legend>
    <div class="block-tabel">
		<h6>Tabel Pegawai</h6>
		<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
			'id'=>'pegawai-m-grid',
			'dataProvider'=>$model->search(),
			'filter'=>$model,
			'itemsCssClass' => 'table table-striped table-bordered table-condensed',
			'columns'=>array(
			array(
				'name'=>'nomorindukpegawai',
				'htmlOptions'=>array('width'=>'300px;'),
			),
			// 'no_kartupegawainegerisipil',
			//'pegawai_id',
			// 'noidentitas',
			array(
				'header'=>'Nama Pegawai',
				'type'=>'raw',
				'name'=>'nama_pegawai',
				'value'=>function($data) {
									return $data->namaLengkap;
								},
			),
			'tempatlahir_pegawai',
			array(
				'header'=>'Tgl Lahir',
				'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_lahirpegawai)',
				//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
			),
			array(
				'name'=>'jeniskelamin',
				'filter'=>CHtml::activeDropDownList($model, 'jeniskelamin', array('LAKI-LAKI'=>'LAKI-LAKI','PEREMPUAN'=>'PEREMPUAN'), array('empty'=>'-- Pilih --','style'=>'width:50px;')),
				),
			'alamat_pegawai',
			/*array(
				'name'=>'statusperkawinan',
				'filter'=>Params::statusPerkawinan(),
				),
			array(
				'name'=>'kelurahan_id',
				'value'=>'empty($data->kelurahan_id)?"-":$data->kelurahan->kelurahan_nama',
			),*/
			array(
					'header'=>'Golongan',
					'name'=>'golonganpegawai_id',
					'filter'=>CHtml::activeDropDownList($model, 'golonganpegawai_id', CHtml::listData(GolonganpegawaiM::model()->findAll(array('order'=>'golonganpegawai_nama')),'golonganpegawai_id','golonganpegawai_nama'), array('empty'=>'-- Pilih --')),
					'value'=>function($data) {
											$gol = GolonganpegawaiM::model()->findByPk($data->golonganpegawai_id);
											if (!empty($gol)) return $gol->golonganpegawai_nama;
											return "-";
										},
				), /*
			array(
				'header'=>'Unit',
				'name'=>'unit_id',
				'type'=>'raw',
				'value'=>function($data) {
									$unit = UnitM::model()->findByPk($data->unit_id);
									if (!empty($unit)) return $unit->namaunit;
									return "-";
								},
				'filter'=>CHtml::activeDropDownList($model, 'unit_id', CHtml::listData(UnitM::model()->findAll(),'unit_id','namaunit'), array('empty'=>'-- Pilih --')),
				'htmlOptions'=>array('width'=>'250px'),
			), */ /*
			array(
				'header'=>'Photo',
				'type'=>'raw',
				'value'=>'empty($data->photopegawai)?"-":CHtml::image(Params::urlPegawaiGambar().$data->photopegawai, $data->nama_pegawai, array("width"=>75, "height"=>100))',
				//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
			), */
				array(
					'header'=>'Print',
					'type'=>'raw',
					'value'=>function($data) {
												$anggota = KeanggotaanT::model()->findByAttributes(array(
													'pegawai_id'=>$data->pegawai_id,
												));
						if (!empty($anggota)) return '-';
						return CHtml::link('<i class="entypo-print"></i>', "#" /*Yii::app()->controller->createUrl('printSuratAnggota', array('id'=>$data->pegawai_id)) */,array(
							"rel"=>"tooltip",
							"title"=>"Klik untuk Mencetak Permohonan Keanggotaan",
							"onclick"=>"print(".$data->pegawai_id."); return false;"
						));
					},
					//'headerHtmlOptions'=>array('style'=>'color:#373e4a;'),
					'htmlOptions'=>array('style'=>'text-align: center'),
				), 
			),
		)); ?>
    </div>
		
</div>
<script type="text/javascript">
$('.numbersOnly').keyup(function() {
var d = $(this).attr('numeric');
var value = $(this).val();
var orignalValue = value;
value = value.replace(/[0-9]*/g, "");
var msg = "Only Integer Values allowed.";

if (d == 'decimal') {
value = value.replace(/\./, "");
msg = "Only Numeric Values allowed.";
}

if (value != '') {
orignalValue = orignalValue.replace(/([^0-9].*)/g, "")
$(this).val(orignalValue);
}
});

$('.alphaonlyK').bind('keyup blur',function(){
    $(this).val( $(this).val().replace(/[^a-zA-Z ]/g,'') );}
);

function convertToUpper(obj)
{
    var string = obj.value;
    $(obj).val(string.toUpperCase());
}

function readURL(input) {
if (input.files && input.files[0]) {
    var reader = new FileReader();

    reader.onload = function (e) {
        $('#photo_pegawai')
        .attr('src', e.target.result)
        .width(150)
        .height(200);
    };
        reader.readAsDataURL(input.files[0]);
    }
}

function print(id)
{
    
    window.open("<?php echo $this->createUrl('printSuratAnggota') ?>&id="+id,"",'location=_new, width=1024px');
    
}
</script>
