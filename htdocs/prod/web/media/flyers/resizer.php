<?php
	//	this special purpose 404 creates the asset lazily
	$size_variant = '/_(\w{2})\./';
	if (preg_match($size_variant, $_SERVER['REQUEST_URI'], $matches)) {
		$destination = $_SERVER['DOCUMENT_ROOT'] . $_SERVER['REQUEST_URI'];
		$original_file = preg_replace($size_variant,'.', $destination);
		switch ($matches[1]) {
			case 'hf':
			$new_width = 300;
			break;
			case 'tn':
			if ( strpos($destination, '/products/') ) {
				$new_width = 80;
			} else {
				$new_width = 150;
			}
			break;
		}
		$image = new Imagick($original_file);
		$image->thumbnailImage($new_width, 0);
		file_put_contents($destination, $image);
		header('Content-type: image/jpeg');
		echo $image;
	}
?>