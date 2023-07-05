import Dropzone from "dropzone";

//Esta linea de codigo hace que los campos que tienen el id "dropzone "no
// adopten el campo, evita la deteccion automatica, haciendo que sea necesari
// la cracion de una instancia manual

Dropzone.autoDiscover = false;


const dropzone = new Dropzone("#dropzone", {
    dictDefaultMessage: "Sube aqui tu imagen",
    acceptedFiles: ".png, .jpg, .jpeg, .gif",
    addRemoveLinks: true,
    dictRemoveFile: "Borrar archivo",
    maxFiles: 1,
    uploadMultiple: false,

    init: function () {
        // alert("dropzone Creado");
        if (document.querySelector('[name="imagen"]').value.trim()) {

            //creacion de un objeto
            const imagenPublicada = {}
            //especificando un tamaño obligatorio
            imagenPublicada.size = 1234;
            //asignando un nombre
            imagenPublicada.name = document.querySelector('[name="imagen"]').value;

            this.options.addedfile.call(this, imagenPublicada);
            // this.options.thumbnail.call(this, imagenPublicada, `uploads/${imagenPublicada.name}`);
            this.options.thumbnail.call(this, imagenPublicada, `/uploads/${imagenPublicada.name}`);

            imagenPublicada.previewElement.classList.add('dz-success', 'dz-complete');

        }
    },
});



//Eventos para debuguer de manaera mas comoda


//exitoso
dropzone.on("success", function (file, response) {
    // console.log(response.imagen);
    document.querySelector('[name="imagen"]').value = response.imagen
});


dropzone.on("removedfile", function () {
    document.querySelector('[name="imagen"]').value = "";

});


