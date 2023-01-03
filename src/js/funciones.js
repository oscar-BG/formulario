let url = 'operaciones.php'

function abrir_loader() {
  var img_path = "src/imagenes/loader.svg";
  
  loader_swal = Swal.fire({
    imageUrl: img_path,
    imageHeight: 40,
    width: 110,
    showConfirmButton: false,
    allowOutsideClick: false,
    background: '#fff'
  });
}

function cerrar_loader() {
  Swal.close();
}

function noificacion_swal(titulo, mensaje, icono) {
  Swal.fire(
    titulo,
    mensaje,
    icono
  )
}

function cerrar_sesion() {
  Swal.fire({
    title: 'Cerrar sesión',
    text: "¿Está seguro de cerrar su sesión?",
    icon: 'question',
    showCancelButton: true,
    confirmButtonColor: '#d33',
    confirmButtonText: 'Cerrar sesión',
    cancelButtonText: 'Cancelar'
  }).then((result) => {
    if (result.isConfirmed) {
      localStorage.clear();
      window.location = "index.html"
    }
  })

}


  