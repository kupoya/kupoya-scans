<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Barcode extends MY_Controller {

	function __construct()
	{
		parent::__construct();
		
		// require user to be logged-in
		// removed the login requirement so that email notifications can use this too
		// $this->_requireLogin();

	}

	public function hello()
	{
		echo 'hello';
	}
	
	public function code128($text = null, $imgtype = 'png')
	{
			
		if ($text === null)
			return;
		
		$this->load->library('Barcode/Image_Barcode_code128');
		
		$obj = new Image_Barcode_code128();
		
		$obj->_barcodeheight = 90;
		$obj->_font = 5;
		$obj->_barwidth = 2;
		
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
