<?php

class MyOdontogramAction extends CAction
{
    protected $canvasWidth = 32;
    protected $canvasHeight = 32;
    protected $atas = array();
    protected $kanan = array();
    protected $bawah = array();
    protected $kiri = array();
    protected $lebar = 9;
    protected $tebal = 9;
    
    public $code = 'wwwww';

    public function __construct()
    {
        $height = $this->canvasHeight;
        $width = $this->canvasWidth;
        $xCenter = $this->canvasWidth/2;
        $yCenter = $this->canvasHeight/2;
        
        $this->atas = array(
                0,  0,  // Point 1 (x, y)
                $xCenter,  $yCenter, // Point 2 (x, y)
                $width,  0,  // Point 3 (x, y)
            );
        $this->kanan = array(
                $width,  0,  // Point 1 (x, y)
                $xCenter,  $yCenter, // Point 2 (x, y)
                $width,  $height,  // Point 3 (x, y)
            );
        $this->bawah = array(
                $width,  $height,  // Point 1 (x, y)
                $xCenter,  $yCenter, // Point 2 (x, y)
                0,  $height,  // Point 3 (x, y)
            );
        $this->kiri = array(
                0,  $height,  // Point 1 (x, y)
                $xCenter,  $yCenter, // Point 2 (x, y)
                0,  0,  // Point 3 (x, y)
            );
    }

    protected function drawBorder($im, $color, $widthCanvas, $heightCanvas,$i)
    {
        imageline($im, 0, 0, $widthCanvas, 0, $color);
        imageline($im, $widthCanvas-1, 0, $widthCanvas-1, $heightCanvas, $color);
        imageline($im, 0, $heightCanvas-1, $widthCanvas, $heightCanvas-1, $color);
        imageline($im, 0, $heightCanvas, 0, 0, $color);
    }
    
    protected function drawKotakTengah($im,$tebal,$lebar,$widthCanvas,$heightCanvas,$color,$borderColor)
    {
        //bikin kotak di tengah
        imagefilledrectangle($im, $tebal, $lebar, $widthCanvas-$tebal, $heightCanvas-$lebar, $color);
        // bikin border kotak yg di tengah
        imagerectangle($im, $tebal, $lebar, $widthCanvas-$tebal, $heightCanvas-$lebar, $borderColor);
            
    }
    
    protected function drawSegitiga($im, $points, $numPoints, $color)
    {
        imagefilledpolygon($im, $points, $numPoints, $color);
    }
    
    protected function drawBorderSilang($im, $x1, $y1, $x2, $y2, $widthCanvas, $heightCanvas, $color)
    {
            // bikin border silang
            imageline($im, 0, 0, $x2, $y2, $color);
            imageline($im, $widthCanvas-1, $y1, $x2-1, $y2, $color);
            imageline($im, $x1, $heightCanvas-1, $x2, $y2-1, $color);
            imageline($im, $widthCanvas, $heightCanvas, $x2, $y2, $color);
    }
    
    protected function drawGigiHilang($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,0xff,0x00,0x00);
            $gray    = ImageColorAllocate($img,193,193,193);
            $black   = ImageColorAllocate($img,0x00,0x00,0x00);
            // bikin kanvas (kotak besar)
            imagefilledrectangle($img, 0, 0, $widthCanvas, $heightCanvas, $gray);
            $this->drawKotakTengah($img, $this->tebal, $this->lebar, $widthCanvas, $heightCanvas, $gray, $black);
            $this->drawBorder($img, $black, $widthCanvas, $heightCanvas,$i);
            
            // bikin border silang
            imageline($img, 0, 0, $widthCanvas, $heightCanvas, $color);
            imageline($img, $widthCanvas, 0, 0, $heightCanvas, $color);
            
            imageline($img, 1, 0, $widthCanvas, $heightCanvas-1, $color);
            imageline($img, $widthCanvas-1, 0, 0, $heightCanvas-1, $color);
            
            imageline($img, 0, 1, $widthCanvas-1, $heightCanvas, $color);
            imageline($img, $widthCanvas-2, 0, 0, $heightCanvas-2, $color);
    }
    
    protected function drawGigiTiruanLepas($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,255,255,0);
            imageline($img, 5, $heightCanvas-10, $widthCanvas-5, $heightCanvas-10, $color);
            imageline($img, 5, $heightCanvas-9, $widthCanvas-5, $heightCanvas-9, $color);
            imageline($img, 5, $heightCanvas-8, $widthCanvas-5, $heightCanvas-8, $color);
    }
    
    protected function drawNonVital($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,0xff,0x00,0x00);
            imageline($img, $widthCanvas, 0, $widthCanvas-10, 0, $color);
            imageline($img, $widthCanvas-10, 0, 10, $heightCanvas, $color);
            imageline($img, 0, $heightCanvas, 10, $heightCanvas, $color);
            
            imageline($img, $widthCanvas, 1, $widthCanvas-10, 1, $color);
            imageline($img, $widthCanvas-10, 1, 11, $heightCanvas, $color);
            imageline($img, 0, $heightCanvas-1, 10, $heightCanvas-1, $color);
            imageline($img, 0, $heightCanvas-2, 10, $heightCanvas-2, $color);
    }
    
    protected function drawJembatan($img, $widthCanvas, $heightCanvas)
    {
            $color = Imagecolorallocate($img, 48, 128, 20);
            imageline($img, 5, 11, $widthCanvas-5, 11, $color);
            imageline($img, 5, 10, $widthCanvas-5, 10, $color);
            imageline($img, 5, 9, $widthCanvas-5, 9, $color);
    }
    
    protected function drawSisaAkar($img, $widthCanvas, $heightCanvas)
    {
            $color = ImageColorAllocate($img,0x00,0x00,0xff);
            imageline($img, 0, $heightCanvas/2, $widthCanvas/2, $heightCanvas, $color);
            imageline($img, $widthCanvas/2, $heightCanvas, $widthCanvas, 0, $color);
            
            imageline($img, 0, ($heightCanvas/2)-1, ($widthCanvas/2)+1, $heightCanvas, $color);
            imageline($img, ($widthCanvas/2)+1, $heightCanvas, $widthCanvas+1, 0, $color);
            
            imageline($img, 0, ($heightCanvas/2)+1, ($widthCanvas/2)-1, $heightCanvas, $color);
            imageline($img, ($widthCanvas/2)-1, $heightCanvas, $widthCanvas-1, 0, $color);
    }
    
    protected function drawBelumErupsi($img,$x,$y)
    {
            $color = Imagecolorallocate($img, 0, 104, 139);
            $fontSize = 14;
            $angle = 0;
            imagettftext($img, $fontSize, $angle, $x, $y, $color, dirname(__FILE__) . '/NOTTB___.TTF', 'UE');
    }
    
    protected function drawErupsiSebagian($img,$x,$y)
    {
            $color = ImageColorAllocate($img,0x00,0x00,0xff);
            $fontSize = 14;
            $angle = 0;
            imagettftext($img, $fontSize, $angle, $x, $y, $color, dirname(__FILE__) . '/NOTTB___.TTF', 'PE');
    }
    
    protected function drawAnomaliBentuk($img,$x,$y)
    {
            $color = Imagecolorallocate($img, 0, 205, 0);
            $fontSize = 14;
            $angle = 0;
            imagettftext($img, $fontSize, $angle, $x, $y, $color, dirname(__FILE__) . '/NOTTB___.TTF', 'A');
    }
    
    protected function drawFromCode($img, $widthCanvas, $heightCanvas, $code)
    {                        
            switch ($code) {
                case 'E': // belum erupsi
                    $this->drawBelumErupsi($img, 7, ($heightCanvas-10));
                    break;
                case 'S': // erupsi sebagian
                    $this->drawErupsiSebagian($img, 7, ($heightCanvas-10));
                    break;
                case 'B': // anomali bentuk
                    $this->drawAnomaliBentuk($img, 10, ($heightCanvas-10)); 
                    break;
                case 'V': // non vital
                    $this->drawNonVital($img, $widthCanvas, $heightCanvas);
                    break;
                case 'A': // sisa akar
                    $this->drawSisaAkar($img, $widthCanvas, $heightCanvas); 
                    break;
                case 'H': // gigi hilang
                    $this->drawGigiHilang($img, $widthCanvas, $heightCanvas);
                    break;
                case 'J': // jembatan
                    $this->drawJembatan($img, $widthCanvas, $heightCanvas);
                    break;
                case 'L': // gigi tiruan lepas
                    $this->drawGigiTiruanLepas($img, $widthCanvas, $heightCanvas);
                    break;

                default:
                    break;
            }
    }
    
    protected function warnaFromCode($code)
    {            
            switch ($code) {
                case 'w':$warna = 'white';
                    break;
                case 'r':$warna = 'maroon';         // Tambalan logam
                    break;
                case 'n':$warna = 'turquoise';      // Tambalan no logam
                    break;
                case 'g':$warna = 'green';          // Mahkota Logam
                    break;
                case 'b':$warna = 'lightblue';      // Mahkota non logam
                    break;
                case 'K':$warna = 'gray';           // Karies
                    break;

                default:$warna = 'white';
                    break;
            }

            return $warna;
    }
    
    protected function gambarFromCode($code)
    {            
            switch ($code) {
                case 'E': // belum erupsi
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/erupsi.png';
                    break;
                case 'S': // erupsi sebagian
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/erupsisebagian.png';
                    break;
                case 'B': // anomali bentuk
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/anomalibentuk.png'; 
                    break;
                case 'V': // non vital
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/nonvital.png';
                    break;
                case 'A': // sisa akar
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/sisaakar.png'; 
                    break;
                case 'H': // gigi hilang
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/gigihilang.png';
                    break;
                case 'J': // jembatan
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/jembatan.png';
                    break;
                case 'L': // gigi tiruan lepas
                    $gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/gigilepas.png';
                    break;

                default:$gambar = Yii::getPathOfAlias('webroot.protected.extensions.MyOdontogram').'/smile.png';
                    break;
            }

            return $gambar;
    }

    public function run()
    {
            if(!empty($_GET['code']))
                $this->code = $_GET['code'];
            $this->renderImage($this->code);
            Yii::app()->end();
    }
    
    protected function renderImage($code)
    {
            $image   = imagecreatetruecolor($this->canvasWidth, $this->canvasHeight);
            $black   = ImageColorAllocate($image,0x00,0x00,0x00);
            $white   = ImageColorAllocate($image,0xff,0xff,0xff);
            $red     = ImageColorAllocate($image,0xff,0x00,0x00);
            $green   = ImageColorAllocate($image,0x00,0xff,0x00);
            $blue    = ImageColorAllocate($image,0x00,0x00,0xff);
            
            $maroon  = ImageColorAllocate($image,255,52,179);
            $gray    = ImageColorAllocate($image,193,193,193);
            $skyblue = ImageColorAllocate($image,135,206,235);
            $lightblue = ImageColorAllocate($image,173,216,230);
            $turquoise = ImageColorAllocate($image,0,254,255);
            $sapgreen = imagecolorallocate($image, 48, 128, 20);
            $green3 = imagecolorallocate($image, 0, 205, 0);
            $yellow = imagecolorallocate($image, 255, 255, 0);
            $deepskyblue = imagecolorallocate($image, 0, 104, 139);

            $xCenter = $this->canvasWidth / 2;
            $yCenter = $this->canvasHeight / 2;            
            
            $warnaAtas = $this->warnaFromCode($this->code[0]);
            $warnaKanan = $this->warnaFromCode($this->code[1]);
            $warnaBawah = $this->warnaFromCode($this->code[2]);
            $warnaKiri = $this->warnaFromCode($this->code[3]);
            $warnaTengah = $this->warnaFromCode($this->code[4]);
            // bikin kanvas (kotak besar)
            imagefilledrectangle($image, 0, 0, $this->canvasWidth, $this->canvasHeight, $white);
            // bikin segitiga atas
            $this->drawSegitiga($image, $this->atas, 3, $$warnaAtas);
            // bikin segitiga kanan
            $this->drawSegitiga($image, $this->kanan, 3, $$warnaKanan);
            // bikin segitiga bawah
            $this->drawSegitiga($image, $this->bawah, 3, $$warnaBawah);
            // bikin segitiga kiri
            $this->drawSegitiga($image, $this->kiri, 3, $$warnaKiri);
            $this->drawBorderSilang($image, 0, 0, $xCenter, $yCenter, $this->canvasWidth, $this->canvasHeight, $black);
            
            $this->drawKotakTengah($image, $this->tebal, $this->lebar, $this->canvasWidth, $this->canvasHeight, $$warnaTengah, $black);
            
            $this->drawBorder($image, $black, $this->canvasWidth, $this->canvasHeight,$i);
            
            $lengthCode = strlen($this->code);
            if($lengthCode > 5 && !empty($this->code[($lengthCode-1)])) {
//                $file = $this->gambarFromCode($this->code[($lengthCode-1)]);
//                $src = imagecreatefrompng($file);
//                imagecopy( $image, $src, 9, 9, 0, 0, 15, 15);
                for($r=5;$r<$lengthCode;$r++){
                    $code = $this->code[$r];
                    $this->drawFromCode($image, $this->canvasWidth, $this->canvasHeight, $code);
                }
            }
            
            
            header('Pragma: public');
            header('Expires: 0');
            header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
            header('Content-Transfer-Encoding: binary');
            header("Content-type: image/png");
            imagepng($image);
            imagedestroy($image);
    }
}
?>
