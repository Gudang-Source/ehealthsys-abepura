<script type="text/javascript">
document.getElementById('ARLapverifikasiinasisV_verifikasiinasis_tglmasuk_date').setAttribute("style","display:none;");
document.getElementById('ARLapverifikasiinasisV_verifikasiinasis_tglmasuk_sampaidengan_date').setAttribute("style","display:none;");
document.getElementById('ARLapverifikasiinasisV_verifikasiinasis_tglkeluar_date').setAttribute("style","display:none;");
document.getElementById('ARLapverifikasiinasisV_verifikasiinasis_tglkeluar_sampaidengan_date').setAttribute("style","display:none;");
function cekTanggalMasuk(){

    var checklist = $('#ARLapverifikasiinasisV_ceklis_tglmasuk');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('ARLapverifikasiinasisV_verifikasiinasis_tglmasuk_date').setAttribute("style","display:block;");
        document.getElementById('ARLapverifikasiinasisV_verifikasiinasis_tglmasuk_sampaidengan_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('ARLapverifikasiinasisV_verifikasiinasis_tglmasuk_date').setAttribute("style","display:none;");
        document.getElementById('ARLapverifikasiinasisV_verifikasiinasis_tglmasuk_sampaidengan_date').setAttribute("style","display:none;");
    }
}	
function cekTanggalKeluar(){

    var checklist = $('#ARLapverifikasiinasisV_ceklis_tglkeluar');
    var pilih = checklist.attr('checked');
    if(pilih){
        document.getElementById('ARLapverifikasiinasisV_verifikasiinasis_tglkeluar_date').setAttribute("style","display:block;");
        document.getElementById('ARLapverifikasiinasisV_verifikasiinasis_tglkeluar_sampaidengan_date').setAttribute("style","display:block;");
    }else{
        document.getElementById('ARLapverifikasiinasisV_verifikasiinasis_tglkeluar_date').setAttribute("style","display:none;");
        document.getElementById('ARLapverifikasiinasisV_verifikasiinasis_tglkeluar_sampaidengan_date').setAttribute("style","display:none;");
    }
}	
</script>