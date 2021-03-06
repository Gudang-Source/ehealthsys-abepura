<div class="white-container">
<?php $js = <<<'EOF'

$(".sidebar-collapse > a").click();

EOF;

Yii::app()->clientScript->registerScript('collapser', $js, CClientScript::POS_READY);

?>
<?php
/* @var $this PengajuanPemotonganController */

$this->breadcrumbs=array(
	'Penerimaan Pemotongan'=>array('/pinjaman/penerimaanPengajuan'),
	'Informasi',
);

Yii::app()->clientScript->registerScript('search', "
	$('#informasi-penerimaanpemotongan-form').submit(function(){
		$.fn.yiiGridView.update('penerimaanpemotongan-m-grid', {
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
<legend class="rim2">Informasi <b>Penerimaan Pengajuan</b></legend>
<div class="col-md-12">			
    <div class="block-tabel">
        <h6>Informasi <b>Penerimaan Pengajuan</b></h6>
            <?php echo $this->renderPartial('subview/_tabelInformasi', array('penerimaanPemotongan'=>$penerimaanPemotongan)); ?>
    </div>
</div>

			
		<!--</div>
		<!--div class="panel-footer" style="text-align:center">
			<?php  //echo Chtml::link('<i class="entypo-print"></i> Print','#', array('class' => 'btn btn-success', 'onclick'=>'iPrint(); return false;')); ?>
		</div-->
	<!--</div>-->
         <fieldset class="box search-form">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend> 
            <?php echo $this->renderPartial('subview/_pencarianInformasi', array('penerimaanPemotongan'=>$penerimaanPemotongan)); ?>
        </fieldset>
</div>


<?php $urlPrint = $this->createUrl('printInformasi'); ?>
<script type="text/javascript">
	$("#btn-cari").click(function() {
		$.fn.yiiGridView.update('penerimaanpemotongan-m-grid', {data:$("#panel-pencarian :input").serialize()});
	});
	function iPrint() {
		var url = ($("#panel-pencarian :input").serialize()); //.split('&');
		//url.shift();
		//url = url.join('&');
		//window.open('<?php echo $urlPrint; ?>&' + url, "print", "width=800,height=600");
		window.open('<?php echo $urlPrint; ?>&' + url, '_blank');
	}
</script>