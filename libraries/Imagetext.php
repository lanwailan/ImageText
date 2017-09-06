<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

class Imagetext {

    public function __construct(){
        $this->ci = &get_instance();
    }

    /*
    +-------------------------------------+
        Name: create
        Purpose: given the image address and
        text, conbine them through this
        @param return : none
    +-------------------------------------+
    */
   
   
    public function create($src_im_path,$text,$filename){

         // Change to your config
        $font_path = FCPATH.'public/arial.ttf';

        //source image
        
        list($src_width,$src_height,$src_attr) = getimagesize($src_im_path);
        switch ($src_attr) {
            case '1':  //GIF
                $src_im = @imagecreatefromgif($src_im_path);
                break;
            case '2':  //JPG
                $src_im = @imagecreatefromjpeg($src_im_path);
                break;
            case '3':  //PNG
                $src_im = @imagecreatefrompng($src_im_path);
                break;            
            default:
                log_message('error', 'Imagetext Library: Could not process such image type');
                break;
        }

        //create target image
        $dst_im = imagecreatetruecolor($src_width, $src_height+100);

        $color = imagecolorAllocate($dst_im,255,255,255);   //background color

        imagefill($dst_im,0,0,$color);

        //copy source image to target image
        imagecopy( $dst_im, $src_im, 0, 0, 0, 0, $src_width, $src_height );

        //text color
        $text_color = imagecolorallocate($dst_im, 0, 0, 0);
        
        $font_size = 14;
        //imagettftext($dst_im,14,0,4,40,$text_color,$font_path,$text);
        $this->text_divide($dst_im,$src_width,$src_height,$font_size,$text_color,$font_path,$text);
        
        //output image
        $this->image_download($dst_im,$filename);

    }

    /*
    +-------------------------------------+
        Name: image_download
        Purpose: force browser to auto download image
        @param return : none
    +-------------------------------------+
    */

    private function image_download($file_source,$filename){
        header('Pragma: public');   // required
        header('Expires: 0');       // no cache
        header('Content-Description: File Transfer');
        header('Content-Type: application/octet-stream');
        header('Content-Disposition: attachment; filename='.$filename.'.jpg');
        header('Content-Transfer-Encoding: binary');
        header('Connection: close');
        imagejpeg($file_source);
        readfile($file_source);       // push it out
        imagedestroy($file_source);
        exit();
    }

    private function text_divide($image,$width,$height,$font_size,$text_color,$font_path,$text){

        $x = 9;
        $textArray = explode(" ",$text);
        $count = count($textArray);
        $maxLength = strlen($text);

        $line = (($x * $maxLength)/($width-40)); // lines of text
        
        if($line > 0){
            $tcount = 0;
            $newArr = array();
            $i =0;
            foreach ($textArray as $key => $value) {

                 if($tcount < $width-40 ){
                    $tcount += ($x) * (1+strlen($value));
                    $newArr[$i][$key] = $value;
                 }else{
                    $tcount = 0;
                    $i++;
                    $tcount += ($x) * (1+strlen($value));
                    $newArr[$i][$key] = $value;
                 }
            }

            foreach ($newArr as $key => $value) {

                $split_text = implode(" ", $newArr[$key]);
                $text_x =20;
                $text_y = $height +30+ 20*($key);
                imagettftext($image,$font_size,0,$text_x,$text_y,$text_color,$font_path,$split_text);
            }

        }else{
            $text_x = (int) ( $width - $font_size * $maxLength )/2;
            $text_y = $height + 30;
            imagettftext($image,$font_size,0,$text_x,$text_y,$text_color,$font_path,$text);
        }
    }
    
}