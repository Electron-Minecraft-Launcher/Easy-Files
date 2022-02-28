<?php

include('./config.php');

$files_folder_o = $files_folder;

if (isset($_GET['path']))
	$files_folder = $files_folder . $_GET['path'];

include('./assets/includes/new_folder.php');
include('./assets/includes/upload.php');
include('./assets/includes/delete.php');
include('./assets/includes/rename.php');

?>

<!DOCTYPE html>
<html lang="<?= $lang ?>">

<head>
	<meta charset="UTF-8">
	<title>Easy Files</title>
	<link rel="stylesheet" href="./assets/css/index.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer">
	<script src="https://cdnjs.cloudflare.com/ajax/libs/axios/0.24.0/axios.min.js" integrity="sha512-u9akINsQsAkG9xjc1cnGF4zw5TFDwkxuc9vUp5dltDWYCSmyd0meygbvgXrlc/z7/o4a19Fb5V0OUE58J7dcyw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
</head>

<script>
	let filesFolder = "<?php if (isset($_GET['path'])) echo $_GET['path'] ?>"
	let filesFolderO = "<?= $files_folder_o ?>"
	let last = [];
	let lang = "<?= $lang ?>"
</script>

<?php

if ($lang == "fr")
	$lang_json = json_decode(file_get_contents("./assets/lang/fr.json"));
else
	$lang_json = json_decode(file_get_contents("./assets/lang/en.json"));

?>

<body style="background-color: #232323; color: white;">

	<button class="small" style="margin: 0 10px auto auto" id="add"><i class="fas fa-plus"></i>&nbsp;&nbsp;<i class="fas fa-caret-down"></i></button>

	<form method="POST" style="display: inline;">
		<button class="small" id="delete" style="width: 36px; margin: 0 7px auto auto" disabled><i class="fas fa-trash"></i></button>
		<input type="text" name="to-delete" id="to-delete" style="display: none">
		<input type="text" name="files-folder" id="files-folder-delete" style="display: none">
	</form>

	<button class="small" id="rename" style="width: 36px; margin-top: 0 " disabled onclick="renameElement()"><i class="fas fa-i-cursor"></i></button>

	<div class="add-files" id="add-files">
		<p class="add-options" id="add-folder"><i class="fas fa-folder"></i>&nbsp;&nbsp;<?= $lang_json->newfolder ?></p>
		<p class="add-options" id="upload"><i class="fas fa-upload"></i>&nbsp;&nbsp;<?= $lang_json->uploadfilesfolder ?></p>
	</div>

	<p id="path" class="path"><a href="./?path="><i class="fas fa-home"></i></a><?php

																																							if (isset($_GET['path']) && $_GET['path'] != null) {

																																								$path = explode("/", $_GET['path']);

																																								foreach ($path as $key => $dir) {

																																									$url_path = null;
																																									$i = 0;

																																									while ($i < $key + 1) {
																																										$url_path .= str_replace(" ", "%20", $path[$i]) . "%2F";
																																										$i++;
																																									}

																																									echo '
																																									<i class="fas fa-caret-right path-caret"></i><a href="./?path=' . $url_path . '" class="path">' . $dir . '</a>';
																																								}
																																							} else echo ' <i class="fas fa-caret-right path-caret"></i>';

																																							?></p>

	<table>

		<tr>
			<th style="width: 24px">
			</th>
			<th style="width: 512px">
				<?= $lang_json->name ?>
			</th>
			<th style="width: 200px">
				<?= $lang_json->date ?>
			</th>
			<th style="width: 100px">
				<?= $lang_json->size ?>
			</th>
		</tr>


		<?php

		if (is_dir($files_folder)) {

			$scan = array_diff(scandir($files_folder), array('.', '..'));

			foreach ($scan as $file) {

				if (is_dir($files_folder . $file)) {

					if (isset($_GET['path'])) {
						$url = $_GET['path'] . $file . "/";
					} else {
						$url = $file . "/";
					}


		?>
					<tr id="<?= $file ?>" onclick="selectElement('<?= $file ?>', event)" ondblclick="openFolder('<?= $url ?>')">
						<td style="border-bottom-left-radius: 5px; border-top-left-radius: 5px; text-align: center">
							<i class="fas fa-folder"></i>
						</td>
						<td>
							<?= $file ?>
						</td>
						<td>
							<?php
							if ($lang == "fr") echo date("d.m.Y H:i", filemtime($files_folder . $file));
							else echo date("Y.m.d H:i", filemtime($files_folder . $file));
							?>
						</td>
						<td style="border-bottom-right-radius: 5px; border-top-right-radius: 5px;">

						</td>
					</tr>


				<?php

				}
			}

			foreach ($scan as $file) {

				if (!is_dir($files_folder . $file)) {

					if (isset($_GET['path'])) {
						$url = $_GET['path'] . $file;
					} else {
						$url = $file;
					}


				?>
					<tr id="<?= $file ?>" onclick="selectElement('<?= $file ?>', event)" ondblclick="openElement('<?= $url ?>')">
						<td style="border-bottom-left-radius: 5px; border-top-left-radius: 5px; text-align: center">
							<?php

							if (pathinfo($url, PATHINFO_EXTENSION) == "jar")
								echo '<i class="fab fa-java"></i>';
							else if (
								pathinfo($url, PATHINFO_EXTENSION) == "png" ||
								pathinfo($url, PATHINFO_EXTENSION) == "jpg" ||
								pathinfo($url, PATHINFO_EXTENSION) == "jpeg" ||
								pathinfo($url, PATHINFO_EXTENSION) == "gif" ||
								pathinfo($url, PATHINFO_EXTENSION) == "bmp"
							)
								echo '<i class="fas fa-image"></i>';
							else if (
								pathinfo($url, PATHINFO_EXTENSION) == "mp4" ||
								pathinfo($url, PATHINFO_EXTENSION) == "avi" ||
								pathinfo($url, PATHINFO_EXTENSION) == "wmv" ||
								pathinfo($url, PATHINFO_EXTENSION) == "mov" ||
								pathinfo($url, PATHINFO_EXTENSION) == "ogv" ||
								pathinfo($url, PATHINFO_EXTENSION) == "ogg" ||
								pathinfo($url, PATHINFO_EXTENSION) == "flv"
							)
								echo '<i class="fas fa-film"></i>';
							else if (
								pathinfo($url, PATHINFO_EXTENSION) == "mp3" ||
								pathinfo($url, PATHINFO_EXTENSION) == "ma4" ||
								pathinfo($url, PATHINFO_EXTENSION) == "wav" ||
								pathinfo($url, PATHINFO_EXTENSION) == "m4a"
							)
								echo '<i class="fas fa-music"></i>';
							else
								echo '<i class="fas fa-file-alt"></i>';

							?>
						</td>
						<td>
							<?= $file ?>
						</td>
						<td>
							<?php
							if ($lang == "fr") echo date("d.m.Y H:i", filemtime($files_folder . $file));
							else echo date("Y.m.d h:i A", filemtime($files_folder . $file));
							?>
						</td>
						<td style="border-bottom-right-radius: 5px; border-top-right-radius: 5px;">
							<?php

							if ($lang == "fr") {

								if (filesize($files_folder . $file) < 1000)
									echo filesize($files_folder . $file) . " o";
								else if (filesize($files_folder . $file) < 1000000)
									echo round(filesize($files_folder . $file) / 1000, 2) . " Ko";
								else if (filesize($files_folder . $file) < 1000000000)
									echo round(filesize($files_folder . $file) / 1000000, 2) . " Mo";
								else
									echo round(filesize($files_folder . $file) / 000000000, 2) . " Go";
							} else {

								if (filesize($files_folder . $file) < 1000)
									echo filesize($files_folder . $file) . " B";
								else if (filesize($files_folder . $file) < 1000000)
									echo round(filesize($files_folder . $file) / 1000, 2) . " KB";
								else if (filesize($files_folder . $file) < 1000000000)
									echo round(filesize($files_folder . $file) / 1000000, 2) . " MB";
								else
									echo round(filesize($files_folder . $file) / 000000000, 2) . " GB";
							}

							?>
						</td>
					</tr>


			<?php

				}
			}

			?>

	</table>
<?php
		} else {
			echo '
						</table>
						<p class="center" style="margin-top: 15px">Directory not found.</p>
						';
		}
?>

<p style="margin-top: 50px;"><?= $lang_json->more ?></p>

</div>

</div>

<div class="modal-background" id="modal-background">

	<div class="modal">
		<button class="small" style="float: right; width: 32px; margin-top: 0" id="close-modal"><i class="fas fa-times"></i></button>
		<p class="modal-title" id="modal-title"></p>
		<div class="modal-content" id="modal-content">
		</div>
	</div>

</div>

</body>

<script src="./assets/js/index.js"></script>

</html>