<script type="text/javascript">
/**
 * javascript yang di running setelah halaman ready / load sempurna
 * posisi script ini harus tetap dibawah
 */

/*
 * untuk print pemanggilan pemeriksaan pasien mcu
 */

function ajaxGetList(){
		var Url = '<?php echo Yii::app()->createUrl($this->route); ?>';
        tgl_awal = $('#ARPendaftaranT_tgl_awal').val();
        tgl_akhir = $('#ARPendaftaranT_tgl_akhir').val();
        carabayar_id = $('#ARPendaftaranT_carabayar_id').val();
        penjamin_id = $('#ARPendaftaranT_penjamin_id').val();
		no_pendaftaran = $('#ARPendaftaranT_no_pendaftaran').val();
        if(carabayar_id == '' || penjamin_id == ''){
            myAlert('Isi Data Cara Bayar dan Penjamin');
        }else{
            $.get(Url, {tgl_awal:tgl_awal, tgl_akhir:tgl_akhir, carabayar_id:carabayar_id, penjamin_id:penjamin_id, no_pendaftaran:no_pendaftaran},function(data){
                $('#tableList tbody').html(data);
				$('#tableList').removeClass('animation-loading');
            });
        }
}

function print(caraPrint)
{
    var no_pemanggilan = '<?php echo isset($_GET['no_pemanggilan']) ? $_GET['no_pemanggilan'] : null ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&no_pemanggilan='+no_pemanggilan+'&caraPrint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}
	
function searchPerhitungan(){
	$('#form-perhitungan').addClass('animation-loading');	
	$.ajax({
		type:'POST',
		url:'<?php echo $this->createUrl('pencarianPendaftaran'); ?>',
		data: {data:$('#pencarianpendaftaran-form').serialize()},//
		dataType: "json",
		success:function(data){
			if(data.pesan !== ""){
				myAlert(data.pesan);
				$('#form-perhitungan').removeClass('animation-loading');
				return false;
			}
			$('#tabel-perhitungan > tbody').html(data.form);
			renameInputRow($("#tabel-perhitungan"));
			$('#form-perhitungan').removeClass('animation-loading');
		},
		error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
	});
}

function enableInputKartu()
{
    if($('#pakeKartu').is(':checked'))
        $('#divDenganKartu').show();
    else 
        $('#divDenganKartu').hide();
    if($('#ARTandabuktibayarT_dengankartu').val() != ''){
        //myAlert('isi');
        $('#ARTandabuktibayarT_bankkartu').removeAttr('readonly');
        $('#ARTandabuktibayarT_nokartu').removeAttr('readonly');
        $('#ARTandabuktibayarT_nostrukkartu').removeAttr('readonly');
    } else {
        //myAlert('kosong');
        $('#ARTandabuktibayarT_bankkartu').attr('readonly','readonly');
        $('#ARTandabuktibayarT_nokartu').attr('readonly','readonly');
        $('#ARTandabuktibayarT_nostrukkartu').attr('readonly','readonly');
        
        $('#ARTandabuktibayarT_bankkartu').val('');
        $('#ARTandabuktibayarT_nokartu').val('');
        $('#ARTandabuktibayarT_nostrukkartu').val('');
    }
}

function hitungTarif(){
	var jumlahTarif = $('#ARTarifkapitasiM_0_cekList').val();
	$('#ARPembayarankapitasidetailT_0_pembayarankapitasidetail_totalpembayaran').val(jumlahTarif);
	
}

$( document ).ready(function(){
	
});
</script>
    