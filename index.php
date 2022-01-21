<?php

include('./config.php');

if (isset($_GET['path']))
	$files_folder = $files_folder . $_GET['path'];

include('./assets/includes/new_folder.php');
include('./assets/includes/upload.php');
include('./assets/includes/delete.php');

?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Easy Files</title>
	<link rel="stylesheet" href="./assets/css/index.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<script>
	let filesFolder = "<?php if (isset($_GET['path'])) echo $_GET['path'] ?>"
	let last = [];
</script>

<body style="background-color: #1e1e1e; color: white;">

	<button class="small" id="add"><i class="fas fa-plus"></i>&nbsp;&nbsp;<i class="fas fa-caret-down"></i></button>

	<form method="POST" style="display: inline;">
		<button class="small w35 margin-left" id="delete" disabled><i class="fas fa-trash"></i></button>
		<input type="text" name="to-delete" id="to-delete" style="display: none">
		<input type="text" name="files-folder" id="files-folder-delete" style="display: none">
	</form>

	<div class="add-files" id="add-files">
		<p class="add-options" id="add-folder"><i class="fas fa-folder"></i>&nbsp;&nbsp;Nouveau Dossier</p>
		<p class="add-options" id="upload"><i class="fas fa-upload"></i>&nbsp;&nbsp;Importer des fichiers/dossiers</p>
	</div>

	<p id="path"><a href="./?path=" class="path"><i class="fas fa-home"></i></a><?php

																																							if (isset($_GET['path'])) {

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
																																							}

																																							?></p>

	<table>

		<tr>
			<th style="width: 24px">
			</th>
			<th style="width: 512px">
				Nom
			</th>
			<th style="width: 200px">
				Date de modification
			</th>
			<th style="width: 100px">
				Taille
			</th>
		</tr>


		<?php

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
						<?= date("d.m.Y H:i", filemtime($files_folder . $file)) ?>
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
					$url = $_GET['path'] . $file . "/";
				} else {
					$url = $file . "/";
				}


			?>
				<tr id="<?= $file ?>" onclick="selectElement('<?= $file ?>', event)">
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
						else if (
							pathinfo($url, PATHINFO_EXTENSION) == "txt" ||
							pathinfo($url, PATHINFO_EXTENSION) == null
						)
							echo '<i class="fas fa-file-alt"></i>';

						?>
						<!-- <img src="./assets/images/folder.png" width="20px"> -->
					</td>
					<td>
						<?= $file ?>
					</td>
					<td>
						<?= date("d.m.Y H:i", filemtime($files_folder . $file)) ?>
					</td>
					<td style="border-bottom-right-radius: 5px; border-top-right-radius: 5px;">
						<?php

						if (filesize($files_folder . $file) < 1000)
							echo filesize($files_folder . $file) . " o";
						else if (filesize($files_folder . $file) < 1000000)
							echo round(filesize($files_folder . $file) / 1000, 2) . " Ko";
						else if (filesize($files_folder . $file) < 1000000000)
							echo round(filesize($files_folder . $file) / 1000000, 2) . " Mo";
						else
							echo round(filesize($files_folder . $file) / 000000000, 2) . " Go";


						?>
					</td>
				</tr>


		<?php

			}
		}

		?>

	</table>

	<div class="modal-background" id="modal-background">

		<div class="modal">
			<button class="small" style="float: right; width: 32px" id="close-modal"><i class="fas fa-times"></i></button>
			<p class="modal-title" id="modal-title"></p>
			<div class="modal-content" id="modal-content">

			</div>
		</div>

	</div>

</body>

<script src="./assets/js/index.js"></script>

</html>