<div class="white-container">
<?php
/* @var $this InfromasiKartuAngsuranController */

$this->breadcrumbs=array(
	'Kartu Angsuran',
);

Yii::app()->clientScript->registerScript('search', "
	$('#informasi-kartuangsuran-form').submit(function(){
		$.fn.yiiGridView.update('kartuangsuran-m-grid', {
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

<legend class="rim2">Informasi <b>Kartu Angsuran Anggota</b></legend>
<div class="col-md-12">			
    <div class="block-tabel">
        <h6>Informasi <b>Kartu Angsuran Anggota</b></h6>
        <?php echo $this->renderPartial('subview/_tabelInformasiAngsuran', array('angsuran'=>$angsuran)); ?>
    </div>
</div>   

     <fieldset class="box search-form">
        <legend class="rim"><i class="entypo-search"></i> Pencarian</legend> 
        
        <?php echo $this->renderPartial('subview/_pencarian', array('angsuran'=>$angsuran)); ?>
      
    </fieldset>
			
			
			<?php echo $this->renderPartial('subview/_js', array()); ?>
			<?php //echo Chtml::link('<i class="entypo-print"></i> Print',$this->createUrl('/pinjaman/InfromasiKartuAngsuran/print'), array('class' => 'btn btn-success','target'=>'_blank')); ?>
			<?php //echo Chtml::link('<i class="entypo-print"></i> Print','#', array('onclick'=>'iPrint(); return false;','class' => 'btn btn-success')); ?>
		

<?php echo $this->renderPartial('subview/_dialog', array(), true); ?>

</div>
