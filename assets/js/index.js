let addOpen = false

document.getElementById("add").addEventListener("click", () => {
	if (addOpen == false) {
		document.getElementById("add-files").style.display = "block"
		addOpen = true
	} else {
		document.getElementById("add-files").style.display = "none"
		addOpen = false
	}
})

// let addFolderOpen = false

document.getElementById("add-folder").addEventListener("click", () => {
	document.getElementById("add-files").style.display = "none"
	addOpen = false
	document.getElementById("modal-background").style.display = "block"
	document.getElementById("modal-title").innerHTML = "Nouveau dossier"
	document.getElementById("modal-content").innerHTML = `
	<form method="POST">
		<input type="text" name="new-folder" id="new-folder" style="margin-bottom: 0" placeholder="Nom du dossier" selected>
		<input type="text" name="files-folder" style="display: none" value="${filesFolder}">
		<button type="submit">Créer</button>
	</form>
	`
})


document.getElementById("upload").addEventListener("click", () => {
	document.getElementById("add-files").style.display = "none"
	addOpen = false
	document.getElementById("modal-background").style.display = "block"
	document.getElementById("modal-title").innerHTML = "Importer des fichiers/dossiers"
	document.getElementById("modal-content").innerHTML = `	
		<form method="POST" enctype="multipart/form-data">
			<p><label for="upload-files">Importer des fichiers : <input id="upload-files" type="file" name="upload-files[]" accept"*" multiple></label></p>
			<p><label for="upload-folder">Importer un dossier : <input id="upload-folders" type="file" name="upload-folders[]" webkitdirectory mozdirectory></label></p>
			<input type="text" name="files-folder" style="display: none" value="${filesFolder}">
			<button type="submit">Importer</button>
		</form>
	`
})

document.getElementById("close-modal").addEventListener("click", () => {
	document.getElementById("modal-background").style.display = "none"
})

document.getElementById("close-modal").addEventListener("click", () => {
	document.getElementById("modal-background").style.display = "none"
})


function selectElement(id, e) {

	file = document.getElementById(id)

	if (last != [] && !e.ctrlKey) {
		last.forEach(element => {
			document.getElementById(element).style.backgroundColor = "#1e1e1e"
		})
	}

	if (e.ctrlKey) {

		let exists = false

		last.forEach(element => {
			if (element == id) exists = true
		})

		if (exists == true) {

			file.style.backgroundColor = "#1e1e1e"
			let index = last.indexOf(id)
			last.splice(index, 1)

		} else {
			last.push(id)
			file.style.backgroundColor = "#333333"
		}

	} else {
		if (last[0] == id && last.length == 1) {
			file.style.backgroundColor = "#1e1e1e"
			last = []
		} else {
			file.style.backgroundColor = "#333333"
			last = [id]
		}
	}

	if (last.length >= 1) {
		document.getElementById("delete").disabled = false
		document.getElementById("to-delete").value = JSON.stringify(last)
		document.getElementById("files-folder-delete").value = filesFolder
	} else {
		document.getElementById("delete").disabled = true
		document.getElementById("to-delete").value = ""
	}

}

function openFolder(path) {
	window.location.href = "./?path=" + path.replaceAll("/", "%2F")
}