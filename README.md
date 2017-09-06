# ImageText
A simple CodeIgniter PHP autocreate image with text

This code was tested with CodeIgniter 3.0+.

## Installation

- Move the libraries file to your libraries directory.
- You will need to change the `$font_path` settings in the library file to wherever you keep your assets.

## Usage

Place this code in the controller:
	
	$this->load->library('Imagetext');

You can just easy to use like this

	$src_im_path = "http://localhost/test/public/step.jpg";
	$filename = '1';
	$text = 'There was a guy who went into a shop to buy a parrot. Here werethree parrots in the shop. One was $5,000,There was a guy who went into a shop to buy a parrot.';
	$this->imagetext->create($src_im_path,$text,$filename);
	
## demo
view image like this:
http://wx4.sinaimg.cn/mw690/9f26e35dgy1fj21o1nqx7j20fa0frwi3.jpg
