<span class="required"><i>Bagian dengan tanda * harus diisi.</i></span>
<p>
<table border="0" style="padding :none;">
     <tr>
    <td style = "vertical-align:middle">1. </td>
    <td>Icon <i class="icon-calendar"></i>berfungsi untuk menentukan tanggal.</td>
  </tr>
  <tr>
    <td style = "vertical-align:middle">2. </td>
    <td>Icon <i class="icon-calendar"></i><i class="icon-time"></i> berfungsi untuk menentukan tanggal dan waktu.</td>
  </tr>
  <tr>
    <td style = "vertical-align:middle">3. </td>
    <td>Icon <i class="icon-plus"></i> berfungsi untuk menambahkan baris.</td>
  </tr>
  <tr>
    <td style = "vertical-align:middle">4. </td>
    <td>Icon <i class="icon-minus"></i> berfungsi untuk membatalkan baris.</td>
  </tr>
  <tr>
      <td  style = "vertical-align:middle">5. </td>
      <td>
           <fieldset class="box">
                <legend class="rim">
                    <?php echo CHtml::checkBox('asd', 'asd', array('checked' => true, 'onchange' => 'bukaUraianTips(this)', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>                    
                    Klik
                </legend>
                    <div id="div_tips">
                            <table id="tips" class="table table-striped table-condensed">                                
                                <tbody>             
                                    <td>Uraian...</td>
                                </tbody>
                            </table>
                        </div>
         
           </fieldset>
          <br>
          Klik tanda checkbox untuk menampilkan form untuk menginput uraian dan sebaliknya untuk menyembunyikan.
      </td>
  </tr>  
    <tr>
        <td style = "vertical-align:middle">6. </td>
        <td>Tombol ini  <button class="btn btn-info disabled" name="yt0"  type="button"><i class = "icon-print icon-white"></i> </button> tidak dapat digunakan (tidak aktif), sedangkan 
            <button class="btn btn-info" name="yt0"  type="button"><i class = "icon-print icon-white"></i></button> tombol ini dapat digunakan (aktif).        
        </td>
    <tr>
    <tr>
        <td  style = "vertical-align:middle">7. </td>
        <td>Gunakan tombol ini <a class="btn btn-info" >
        <i class="icon-print icon-white"></i>
        Print
        </a> berfungsi untuk mencetak data.</td>
    </tr>
    <tr>
        <td  style = "vertical-align:middle">8. </td>
        <td>Gunakan tombol ini <a class="btn btn-primary" >
            <i class="icon-ok icon-white"></i>
            Ulang
            </a> berfungsi untuk menyimpan data.
        </td>
  </tr>
    <tr>
        <td  style = "vertical-align:middle">9. </td>
        <td>Gunakan tombol ini <a class="btn btn-danger" >
            <i class="icon-refresh icon-white"></i>
            Ulang
            </a> berfungsi untuk mengulang kembali inputan.
        </td>
  </tr>   
</table>
</p>

