<div class="white-container">
<?php
/* @var $this PengajuanPemotonganController */

$this->breadcrumbs=array(
	'Pengajuan Pemotongan'=>array('/pinjaman/pengajuanPemotongan'),
	'Informasi',
);
Yii::app()->clientScript->registerScript('search', "
	$('#informasi-pengajuanpemotongan-form').submit(function(){
		$.fn.yiiGridView.update('pengajuanpemotongan-m-grid', {
			data: $(this).serialize()
		});
		return false;
	});
");
?>


<legend class="rim2">Informasi <b>Pengajuan Pemotongan</b></legend>
<div class="col-md-12">			
    <div class="block-tabel">
        <h6>Informasi <b>Pengajuan Pemotongan</b></h6>
            <?php echo $this->renderPartial('subview/_tabelInformasi', array('pengajuanPemotongan'=>$pengajuanPemotongan)); ?>
    </div>
</div>
     <fieldset class="box search-form">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend> 
            <?php echo $this->renderPartial('subview/_pencarianInformasi', array('pengajuanPemotongan'=>$pengajuanPemotongan)); ?>
     </fieldset>
			
		<!--</div>-->
		<div class="panel-footer" style="text-align:center">
			<?php  //echo Chtml::link('<i class="entypo-print"></i> Print','#', array('class' => 'btn btn-success', 'onclick'=>'iPrint(); return false;')); ?>
		</div>
	<!--</div>
</div>-->

<?php $urlPrint = $this->createUrl('printInformasi'); ?>
<script type="text/javascript">
	//$("#btn-cari").click(function() {
		//$.fn.yiiGridView.update('pengajuanpemotongan-m-grid', {data:$("#panel-pencarian :input").serialize()});
//	});
	function iPrint() {
		var url = ($("#panel-pencarian :input").serialize()); //.split('&');
		//url.shift();
		//url = url.join('&');
		window.open('<?php echo $urlPrint; ?>&' + url, "_blank");
		//window.open('<?php echo $urlPrint; ?>&' + url, "print", "width=800,height=600");
	}
</script>
</div>