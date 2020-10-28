<?php

// Load php classes
require_once('src/Helper/Fileupload.php');
require_once('src/Helper/Gallery.php');

use Helper\Fileupload;
use Helper\Gallery;

// Check for uploads
$objUpload = new Fileupload('file', 'fileadmin/images', 'fileadmin/thumbs');
if ($objUpload->hasImageUpload()) {
    $objUpload->uploadImage();
    $objUpload->reload();
}

// Collect images
$objGallery = new Gallery('fileadmin/images', 'fileadmin/thumbs');
$arrImages = $objGallery->getImages();
?>


<!doctype html>
<html lang="en">
	<head>
		<!-- Required meta tags -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<!-- Bootstrap CSS -->
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/css/bootstrap.min.css" integrity="sha384-TX8t27EcRE3e/ihU7zmQxVncDAy5uIKz4rEkgIXeMed4M0jlfIDPvg6uqKI2xXr2" crossorigin="anonymous">
		<link rel="stylesheet" href="fileadmin/style/stylesheet.css">
		<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.css" integrity="sha512-H9jrZiiopUdsLpg94A333EfumgUBpO9MdbxStdeITo+KEIMaNfHNvwyjjDJb+ERPaRS6DpyRlKbvPUasNItRyw==" crossorigin="anonymous"/>

		<title>fileupload!</title>
	</head>

	<body>
	<div id="wrapper">
		<div class="container">
			<h1>Upload your images here!</h1>
			<div>
				<a href=""ttps://github.com/markocupic/medien-und-informatik-projekte/tree/main/projekt-imageupload">PHP image upload</a>
			</div>

			<div class="form mb-5">
				<form action="index.php" method="post" enctype="multipart/form-data">
					<label>Please select an image file.
						<input name="file" type="file" accept="image/jpeg">
					</label>
					<div class="mt-4">
						<button type="submit" class="btn btn-primary">Submit</button>
					</div>
				</form>
			</div>

			<!-- List images -->
			<div class="row">
					<?php foreach ($arrImages as $arrImage): ?>
						<div class="col-3">
							<figure class="mb-4">
								<a href="<?= $arrImage['image'] ?>" data-fancybox="gallery">
									<img src="<?= $arrImage['thumbnail'] ?>" class="img_fluid">
								</a>
							</figure>
						</div>
					<?php endforeach; ?>
			</div>
		</div>
	</div>


	<!-- jQuery and Bootstrap Bundle (includes Popper) -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.5.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ho+j7jyWK8fNQe+A12Hb8AhRq26LrZ/JpcUGGOn+Y7RsweNrtN/tE3MoK7ZeZDyx" crossorigin="anonymous"></script>
	<!-- fancybox -->
	<script src="https://cdnjs.cloudflare.com/ajax/libs/fancybox/3.5.7/jquery.fancybox.min.js" integrity="sha512-uURl+ZXMBrF4AwGaWmEetzrd+J5/8NRkWAvJx5sbPSSuOb0bZLqf+tOzniObO00BjHa/dD7gub9oCGMLPQHtQA==" crossorigin="anonymous"></script>

	</body>
</html>