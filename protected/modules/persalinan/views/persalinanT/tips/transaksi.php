<span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
<p>
<table border="0" style="padding :none;">
    <tr>
        <td style = "verticl-align:middle">1. </td>
        <td>Icon <i class="icon-calendar"></i><i class="icon-time"></i>
            berfungsi untuk menentukan tanggal dan waktu persalinan .</td>
    </tr>
    <tr>
        <td  style = "verticl-align:middle">2. </td>
        <td>
            <fieldset class='box'>
                <legend class="rim"><?php echo CHtml::checkBox('tipsRiwayatPasien',true, array('onkeypress'=>"return $(this).focusNextInputField(event)")) ?> &nbsp; </legend>
                <div id="tipsdivRiwayatPasien" class="control-group">
                    form       
                </div>
            </fieldset>
            Checkbox di checklist, maka akan menampilkan form, dan ketika checkbox di uncheck maka akan menyembunyikan form.
        </td>
    </tr>
    <tr>  
        <td  style = "verticl-align:middle">3. </td>
        <td>Gunakan tombol ini  <a class="btn btn-primary"><i class="icon-ok icon-white"></i>Simpan</a>
             berfungsi untuk menyimpan</td>
    </tr> 
    <tr>
        <td  style = "verticl-align:middle">4. </td>
        <td>Gunakan tombol ini <a class="btn btn-danger"><i class="icon-refresh icon-white"></i>
            Ulang</a> untuk mengulang kembali inputan.</td>
    </tr>
</table>
</p>
<script>
    $("#tipsRiwayatPasien").change(function(){
    $('#tipsdivRiwayatPasien').slideToggle(500);
});
</script>

