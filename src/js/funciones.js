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

function obtener_logo() {

  return new Promise(function(logo, error){
    $.ajax({
      type: "POST",
      url: url,
      data:{
        op: "obtener_logo"
      },
      dataType: "json",
      success: function (response){
        console.log(response);
        if (response.status) {
          // $("#img_logo").attr("src",`data:image/png;base64,${response.logo}`)
          logo(response.logo)
        } else {
          error('No se encontro la imagen')
          // noificacion_swal('Logo','Se genero un error al consultar datos','error');
        }
      },
      error: function (request, status, error) {
        console.log("request: ", request)
        console.log("status: ", status)
        console.log("error: ", error)
        noificacion_swal('Error','Se genero un error al consultar los datos','error')
      }
  
    })
    
  })
}
  