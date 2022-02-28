let langJson;

async function getLang() {

	if (lang == "fr")
		await axios.get("./assets/lang/fr.json").then(res => langJson = res.data);
	else
		await axios.get("./assets/lang/en.json").then(res => langJson = res.data);

}

getLang()

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
	document.getElementById("modal-title").innerHTML = langJson.newfolder
	document.getElementById("modal-content").innerHTML = `
	<form method="POST">
		<input type="text" name="new-folder" id="new-folder" style="margin-bottom: 0" placeholder="${langJson.foldername}" selected>
		<input type="text" name="files-folder" style="display: none" value="${filesFolder}">
		<button type="submit">${langJson.create}</button>
	</form>
	`
})


document.getElementById("upload").addEventListener("click", () => {
	document.getElementById("add-files").style.display = "none"
	addOpen = false
	document.getElementById("modal-background").style.display = "block"
	document.getElementById("modal-title").innerHTML = langJson.upload
	document.getElementById("modal-content").innerHTML = `	
		<form method="POST" enctype="multipart/form-data">
			<p><label for="upload-files">${langJson.uploadfiles} : <input id="upload-files" type="file" name="upload-files[]" accept"*" multiple></label></p>
			<p><label for="upload-folder">${langJson.uploadfolder} : <input id="upload-folder" type="file" name="upload-folder[]" webkitdirectory mozdirectory disabled title="${langJson.notavailable}"></label></p>
			<input type="text" name="files-folder" style="display: none" value="${filesFolder}">
			<button type="submit">${langJson.upload}</button>
			<p><i class="fas fa-exclamation-triangle"></i>&nbsp;&nbsp;${langJson.warningupload}</p>
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
			document.getElementById(element).style.backgroundColor = "#232323"
		})
	}

	if (e.ctrlKey) {

		let exists = false

		last.forEach(element => {
			if (element == id) exists = true
		})

		if (exists == true) {

			file.style.backgroundColor = "#232323"
			let index = last.indexOf(id)
			last.splice(index, 1)

		} else {
			last.push(id)
			file.style.backgroundColor = "#333333"
		}

	} else {
		if (last[0] == id && last.length == 1) {
			file.style.backgroundColor = "#232323"
			last = []
		} else {
			file.style.backgroundColor = "#333333"
			last = [id]
		}
	}

	if (last.length == 1) {
		document.getElementById("delete").disabled = false
		document.getElementById("to-delete").value = JSON.stringify(last)
		document.getElementById("files-folder-delete").value = filesFolder

		document.getElementById("rename").disabled = false
		document.getElementById("rename").value = JSON.stringify(last)
	} else if (last.length >= 1) {
		document.getElementById("delete").disabled = false
		document.getElementById("to-delete").value = JSON.stringify(last)
		document.getElementById("files-folder-delete").value = filesFolder

		document.getElementById("rename").disabled = true
		document.getElementById("rename").value = ""
	} else {
		document.getElementById("delete").disabled = true
		document.getElementById("to-delete").value = ""

		document.getElementById("rename").disabled = true
		document.getElementById("rename").value = ""
	}

}

function openFolder(path) {
	window.location.href = "./?path=" + path.replaceAll("/", "%2F")
}

function openElement(path) {
	window.open(filesFolderO + path, '_blank').focus();
}

function renameElement() {

	document.getElementById("modal-background").style.display = "block"
	document.getElementById("modal-title").innerHTML = langJson.rename + " <i>" + JSON.parse(document.getElementById("rename").value)[0] + "</i>"
	document.getElementById("modal-content").innerHTML = `
	<form method="POST">
		<input type="text" name="new-name-element" id="new-name-element" style="margin-bottom: 0" placeholder="${langJson.newname}" selected value="${JSON.parse(document.getElementById("rename").value)[0]}">
		<input type="text" name="old-name-element" style="display: none" value="${JSON.parse(document.getElementById("rename").value)[0]}">
		<input type="text" name="files-folder" style="display: none" value="${filesFolder}">
		<button type="submit">${langJson.rename}</button>
		<p><i class="fas fa-exclamation-triangle"></i>&nbsp;&nbsp;${langJson.warningrename}</p>
	</form>
	`
}