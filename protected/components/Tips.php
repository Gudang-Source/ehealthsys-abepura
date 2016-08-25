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
            'autocomplete-search' => 'icon ini  <i class="icon-list"></i><i class="icon-search"></i>'
                        .'  berfungsi untuk menampilkan list data sesuai dengan diketikkan dan menampilkan dialog box jika icon di klik.',
            'waktutime' => 'icon ini  <i class="icon-calendar"></i><i class="icon-time"></i>'
                        .'  berfungsi untuk menentukan tanggal dan waktu.',
        );
    }
        
}
?>