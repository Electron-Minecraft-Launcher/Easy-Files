<?php

if (isset($_FILES['upload-files'])) {

	foreach ($_FILES as $file) {
		echo "<pre>---";
		var_dump($file);
		echo "</pre>";
	}


	// if ($_FILES['upload-files']['size'] > 10000000) {
	// 	header('Location: ./?error=too%20large%20file');
	// 	return;
	// }

}

// if (isset($_FILES['upload-folders'])) {
// 	var_dump($_FILES);
// 	return;

// 	if ($_FILES['upload-folders']['size'] > 2000000000) {
// 		header('Location: ./?error=too%20large%20folder');
// 		return;
// 	}
// }
