<script type="text/javascript">
function cekNoPengajuan(){
var pengajuansterlilisasi_no=$("#<?php echo CHtml::activeId($modCari,"pengajuansterlilisasi_no");?>").val();
	if (pengajuansterlilisasi_no == ""){
		myAlert('Isi No. Pengajuan yang akan dicari');
		return false;
	}else{
		$("#cspenerimaanperalatansteril-t-form").submit();
		return false;
	}
}
function print(caraPrint)
{
    var penerimaansterilisasi_id = '<?php echo isset($_GET['penerimaansterilisasi_id']) ? $_GET['penerimaansterilisasi_id'] : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&penerimaansterilisasi_id='+penerimaansterilisasi_id+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

$(document).ready(function(){
	var jmlRow = $('#table-peralatansteril tbody tr').length;
	if(jmlRow === 0){
		$('#pencarian').attr('disabled',false);
	}else{
		$('#pencarian').attr('disabled',true);
	}
});
</script>