<?php

if (isset($_POST['new-folder']) && strlen($_POST['new-folder']) >= 1) {

	if (
		strpos($_POST['new-folder'], "*") !== false ||
		strpos($_POST['new-folder'], "\\") !== false ||
		strpos($_POST['new-folder'], "/") !== false ||
		strpos($_POST['new-folder'], "?") !== false ||
		strpos($_POST['new-folder'], ":") !== false ||
		strpos($_POST['new-folder'], ">") !== false ||
		strpos($_POST['new-folder'], "<") !== false ||
		strpos($_POST['new-folder'], "|") !== false ||
		strpos($_POST['new-folder'], "\"") !== false
	) {
		header('Location: ./?error=invalid%20foldername');
	} else if (file_exists("./files/" . $_POST['new-folder'])) {
		header('Location: ./?error=folder%20already%20existing');
	} else {
		mkdir("./files/" . $_POST['new-folder'], 0777, false);
		header('Location: ./?success=fodler%20created');
	}
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
	<meta charset="UTF-8">
	<title>Easy Files</title>
	<link rel="stylesheet" href="./assets/css/index.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" integrity="sha512-1ycn6IcaQQ40/MKBW2W4Rhis/DbILU74C1vSrLJxCq57o941Ym01SwNsOMqvEBFlcgUa6xLiPY/NS5R+E6ztJQ==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body style="background-color: #1e1e1e; color: white;">

	<!-- <form method="POST">

		<input type="text" name="new-folder" id="new-folder" placeholder="Nouveau dossier">
		<button type="submit">Créer</button>

	</form> -->

	<button class="small" id="add"><i class="fas fa-plus"></i>&nbsp;&nbsp;<i class="fas fa-caret-down"></i></button>

	<div class="add-files" id="add-files">
		<p class="add-options" id="add-folder"><i class="fas fa-folder"></i>&nbsp;&nbsp;Nouveau Dossier</p>
		<p class="add-options" id="upload"><i class="fas fa-upload"></i>&nbsp;&nbsp;Charger des fichiers/dossiers</p>
	</div>

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

		$scan = array_diff(scandir("./files/"), array('.', '..'));

		foreach ($scan as $file) {

			if (is_dir("./files/" . $file)) {

		?>

				<tr id="<?= $file ?>" onclick="selectElement('<?= $file ?>', event)">
					<td style="border-bottom-left-radius: 5px; border-top-left-radius: 5px;">
						<img src="./assets/images/folder.png" width="20px">
					</td>
					<td>
						<?= $file ?>
					</td>
					<td>
						<?= date("d.m.Y H:i", filemtime("./files/" . $file)) ?>
					</td>
					<td style="border-bottom-right-radius: 5px; border-top-right-radius: 5px;">

					</td>
				</tr>

		<?php

			}
		}

		foreach ($scan as $file) {

			if (!is_dir("./files/" . $file)) {
				// echo "<p>&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp" . $file . "&nbsp&nbsp&nbsp;<button></button></p>";
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