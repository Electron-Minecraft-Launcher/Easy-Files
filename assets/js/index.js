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
		<input type="text" name="new-folder" id="new-folder" style="margin-bottom: 0" placeholder="Nom du dossier">
		<button type="submit">Créer</button>
	</form>
	`
})

document.getElementById("close-modal").addEventListener("click", () => {
	document.getElementById("modal-background").style.display = "none"
})

let last = []

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
}