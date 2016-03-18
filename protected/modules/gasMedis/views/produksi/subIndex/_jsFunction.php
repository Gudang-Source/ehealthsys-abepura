<script>

function setPegawai(jqdialog, id, nama) {
    if (jqdialog === "dialogPetugas") {
        $("#ProduksigasmedisT_petugasgasmedis_id").val(id);
        $("#ProduksigasmedisT_petugasgasmedis_nama").val(nama);
    } else if (jqdialog === "dialogMengetahui") {
        $("#ProduksigasmedisT_mengetahui_id").val(id);
        $("#ProduksigasmedisT_mengetahui_nama").val(nama);
    }
    $("#" + jqdialog).dialog("close");
}

function setGasMedis(id, nama) {
    $("#namaGasMedis").val(nama);
    $("#obatalkes_id").val(id);
}

function tambahGasMedis() {
    var id = $("#obatalkes_id").val();
    var jumlah = $("#qty").val();
    
    $("#namaGasMedis, #obatalkes_id").val("");
    $("#qty").val("1");
    
    $.post("<?php echo $this->createUrl('loadDetGasMedis'); ?>", {id: id, jumlah: jumlah},
    function(data) {
        $("#tabGasMedis tbody").append(data);
        setRowFormat();
    });
}

function setRowFormat() {
    $(".timings:not(.setted)")
            .timepicker(jQuery.extend({showMonthAfterYear:false}, jQuery.datepicker.regional['id'], {'showAnim':'fold','beforeShow':function(){customRange(this);},'dateFormat':'yy-mm-dd','changeFirstDay':false,'changeMonth':true,'timeText':'Waktu','hourText':'Jam','minuteText':'Menit','secondText':'Detik','showSecond':true,'timeOnlyTitle':'Pilih Waktu','timeFormat':'hh:mm:ss','changeYear':true,'yearRange':'-80y:+20y'}))
            .addClass("setted");
    $(".numbers-only:not(.setted)")
            .maskMoney({"defaultZero":true,"allowZero":true,"decimal":",","thousands":"","precision":0,"symbol":null})
            .addClass("setted");
}

function customRange(input) 
{ 
        var min = new Date(2008, 11 - 1, 1); //Set this to your absolute minimum date
        var dateMin = min;
        var dateMax = null;
        var dayRange = 6;  // Set this to the range of days you want to restrict to
    
//        myAlert($(input).attr('id'));
        if ($(input).attr('id') == "txtStartDate") 
        {
            if ($("#txtEndDate").datepicker("getDate") !== null)
            {
                dateMax = $("#txtEndDate").datepicker("getDate");
                dateMin = $("#txtEndDate").datepicker("getDate");
                dateMin.setDate(dateMin.getDate() - dayRange);
                if (dateMin < min)
                {
                        dateMin = min;
                }
             }
             else
             {
                dateMax = new Date(); //Set this to your absolute maximum date
             }   
             $("#txtStartDate").datepicker("option", "minDate",dateMin);
             
             if ($("#txtEndDate").val() !== null){
                  $("#txtStartDate").datepicker("option", "maxDate",$("#txtEndDate").datepicker("getDate"));
             }
             
        }
        else if ($(input).attr('id') == "txtEndDate")
        {
                dateMax = new Date(); //Set this to your absolute maximum date
                if ($("#txtStartDate").datepicker("getDate") !== null) 
                {
                        dateMin = $("#txtStartDate").datepicker("getDate");
                        var rangeMax = new Date(dateMin.getFullYear(), dateMin.getMonth(), dateMin.getDate() + dayRange);

                        if(rangeMax < dateMax)
                        {
                            dateMax = rangeMax; 
                        }
                }else{
                    
                }
                $("#txtEndDate").datepicker("option", "minDate",dateMin);
        }
            return {
                minDate: dateMin, 
                maxDate: dateMax
            }; 

}
function batalProduksi(obj) {
     myConfirm("Anda yakin untuk membatalkan produksi ini?",'Perhatian!',function(r){
            if(!r) {
                return false;
            }else{
                $(obj).parents('tr').remove();
            }
    });
}

function cekValidasi() {
    $("#produksigasmedis-form").submit();
}
</script>