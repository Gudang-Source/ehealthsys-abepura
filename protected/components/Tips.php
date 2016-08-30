<?php
/**
 * Params berisi:
 * 1. Nilai default
 * 2. Nilai id yang di sesuaikan dengan tabel di database
 * 3. Nilai konstant
 * 4. Nilai konstant yang disesuaikan dengan lookup_m
 */
Class Tips
{
    public static function getTips()
    {
        return array(
            'simpan'    => 'Gunakan tombol ini  <div class="btn btn-primary">'
                        .'<i class="icon-ok icon-white"></i> Simpan</div> berfungsi '
                        .' untuk menyimpan data.', 
            'ulang'    => 'Gunakan tombol ini  <div class="btn btn-danger">'
                        .'<i class="icon-refresh icon-white"></i> Ulang</div> berfungsi '
                        .' untuk mengulang kembali inputan.', 
            'ulang2'    => 'Gunakan tombol ini  <div class="btn btn-danger">'
                        .'<i class="icon-refresh icon-white"></i> Ulang</div> berfungsi '
                        .' untuk mengulang kembali pencarian.', 
            'cari'    => 'Gunakan tombol ini  <div class="btn btn-primary">'
                        .'<i class="icon-search icon-white"></i> Cari</div> berfungsi '
                        .' untuk mencari data.', 
            'print'    => 'Gunakan tombol ini  <div class="btn btn-info">'
                        .'<i class="icon-print icon-white"></i> Print</div> berfungsi '
                        .' untuk mencetak data.', 
            'status_print'    => 'Tombol ini  <div class="btn btn-info">'
                        .'<i class="icon-print icon-white"></i></div> berarti dapat digunakan (tombol aktif), sedangkan '
                        .' tombol ini  <div class="btn btn-info disabled" >'
                        .'<i class="icon-print icon-white"></i></div> berarti tidak dapat digunakan (tombol tidak aktif)', 
            'autocomplete-search' => 'icon ini  <i class="icon-list"></i><i class="icon-search"></i>'
                        .'  berfungsi untuk menampilkan list data sesuai dengan diketikkan dan menampilkan dialog box jika icon di klik.',
            'waktutime' => 'icon ini  <i class="icon-calendar"></i><i class="icon-time"></i>'
                        .'  berfungsi untuk menentukan tanggal dan waktu.',
            'tanggal' => 'icon ini  <i class="icon-calendar"></i>'
                        .'  berfungsi untuk menentukan tanggal.',
        );
    }
        
}
?>