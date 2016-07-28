<script>

var objdetid;
var objdetnama;

function loadSetoranKasir()
{
	var tgl_awal = $("#KUSetoranbdharaT_tgl_awal").val();
	var tgl_akhir = $("#KUSetoranbdharaT_tgl_akhir").val();
	
	$.post('<?php echo $this->createUrl('loadSetoran'); ?>', {
		tgl_awal: tgl_awal,
		tgl_akhir: tgl_akhir
	}, function(data)
	{
		$("#tab_setoran tbody").html(data.html);
		$("#tab_setoran tfoot").html(data.footer);
	}, "json");
}

function printSetoran(id) {
	window.open("<?php echo $this->createUrl('print') ?>&id="+id,"",'location=_new, width=1024px');
}

</script>

