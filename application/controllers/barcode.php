<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barcode extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		// require user to be logged-in
		$this->_requireLogin();

	}

	
	public function code128($text, $imgtype = 'png')
	{
			
		$this->load->library('Barcode/Image_Barcode_code128');
		
		$obj = new Image_Barcode_code128();
		
		$obj->_barcodeheight = 120;
		$obj->_font = 205;
		$obj->_barwidth = 6;
		
		$img = $obj->draw($text, $imgtype);
		
		if (PEAR::isError($img)) {
            return $img;
        }
        
        $this->output->set_header("Content-Type: image/" . $imgtype);
                
        
        //$trans_index = imagecolorallocate($img, 255,204,153);
        //imagecolortransparent( $img, $trans_index );
        
        imagealphablending( $img, false );
        imagesavealpha( $img, true );
        
        
        switch($imgtype) {
        	
        	case 'gif':
        		imagegif($img);
        		imagedestroy($img);
        		break;
        	
        	case 'jpg':
        		imagejpeg($img);
        		imagedestroy($img);
        		break;
        		
        	default:
        		imagepng($img);
        		imagedestroy($img);
        		break;
        		
        }
        
        //exit($img);	
		
	}
	
}
