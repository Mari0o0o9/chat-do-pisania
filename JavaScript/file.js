function img() {
    var file = document.getElementById('file');
    var name = document.getElementById('fileName');

    file.addEventListener("change", ()=> {
        if (file.files.length > 0) {
            name.innerHTML = file.files[0].name;
        }
        else {
            name.innerHTML = "Nie wybrano pliku...";
        }
    })
}
img();