function editable(e, id){
  let divid=e.id;
  let arrayDeCadenas = divid.split("_");
	let idtext=arrayDeCadenas[1];

  $("#"+e.id).after("<textarea class='form-control' name='texto_"+idtext+"' id='texto_"+idtext+"'>"+e.innerHTML+"</textarea>");
  $("#"+e.id).remove();

  $("#texto_"+idtext).summernote({
    lang: 'es-ES',
    placeholder: 'Texto',
    tabsize: 5,
    height: 200
  });

}


////////////change para submit de respuesta del paciente
$(document).on('change',"[is*='s-submit']",function(e){
    e.preventDefault();

    if(e.currentTarget.checked){
      $('.cond_'+e.currentTarget.value).show();
    }
    else{
      $('.cond_'+e.currentTarget.value).hide();
    }

    //////////id del formulario
    let id=e.target.form.id;
    let elemento = document.getElementById(id);
    procesar_resp(elemento);
});
$(document).on('submit',"[is*='resp-submit']",function(e){
  e.preventDefault();

   //////////id del formulario
   let id=e.currentTarget.attributes.id.nodeValue;
   let elemento = document.getElementById(id);

   procesar_resp(elemento);
});
function procesar_resp(elemento){
  /////////API que procesa el form
  let db=elemento.attributes.db.value+".php";
  let fun=elemento.attributes.fun.value;
  let idactividad=elemento.attributes.v_idactividad.value;
  let idpaciente=elemento.attributes.v_idpaciente.value;
  let idcontexto=elemento.attributes.v_idcontexto.value;

  var formData = new FormData(elemento);
  formData.append("function",fun);
  formData.append("idactividad",idactividad);
  formData.append("idpaciente", idpaciente);
  formData.append("idcontexto", idcontexto);

  let xhr = new XMLHttpRequest();
  xhr.open('POST', db);
  xhr.addEventListener('loadstart',(data)=>{
    //cargando(true);
  });
  xhr.addEventListener('load',(data)=>{
    if (!isJSON(data.target.response)){
      console.log(data.target.response);
      //cargando(false);
      Swal.fire({
        icon: 'error',
        title: "Error favor de verificar",
        showConfirmButton: false,
        timer: 1000
      });
      return;
    }
    var respon = JSON.parse(data.target.response);
    if (respon.error==0){
      carga_respuesta(idcontexto, idactividad, idpaciente);
      document.getElementById('progreso_'+respon.idsubactividad).innerHTML=respon.progreso;
      document.getElementById('prog_'+respon.idactividad).innerHTML=respon.proact;
      Swal.fire({
        position: 'bottom-start',
        text: "Guardado",
        showConfirmButton: false,
        timer: 100
      });
      //cargando(false);
    }
    else{
      cargando(false);
      Swal.fire({
        icon: 'info',
        title: respon.terror,
        showConfirmButton: false,
        timer: 1000
      });
    }
  });
  xhr.onerror =  ()=>{
    cargando(false);
    console.log("error");
  };
  xhr.send(formData);
}
function carga_respuesta(idcontexto, idactividad, idpaciente){
  var formData = new FormData();
	formData.append("idcontexto", idcontexto);
	formData.append("idactividad", idactividad);
	formData.append("idpaciente", idpaciente);
	formData.append("function", "upd");
	let xhr = new XMLHttpRequest();
	xhr.open('POST',"a_respuesta/db_.php");
	xhr.addEventListener('load',(data)=>{
    document.getElementById("con_"+idcontexto).innerHTML=data.target.response;
	});
	xhr.onerror = (e)=>{
		console.log(e);
	};
	xhr.send(formData);
}


////////////change para submit de respuesta del terapeuta
$(document).on('submit',"[is*='act-submit']",function(e){
  e.preventDefault();

   //////////id del formulario
   let id=e.currentTarget.attributes.id.nodeValue;
   let elemento = document.getElementById(id);
   procesar_act(elemento);
});
function procesar_act(elemento){

  let db=elemento.attributes.db.value+".php";
  let fun=elemento.attributes.fun.value;
  let idactividad=elemento.attributes.v_idactividad.value;
  let idpaciente=elemento.attributes.v_idpaciente.value;
  let idcontexto=elemento.attributes.v_idcontexto.value;

  var formData = new FormData(elemento);
  formData.append("function",fun);
  formData.append("idactividad",idactividad);
  formData.append("idpaciente", idpaciente);
  formData.append("idcontexto", idcontexto);

  let xhr = new XMLHttpRequest();
  xhr.open('POST', db);

  xhr.addEventListener('load',(data)=>{
    if (!isJSON(data.target.response)){
      cargando(false);
      Swal.fire({
        icon: 'error',
        title: "Error favor de verificar",
        showConfirmButton: false,
        timer: 1000
      });
      return;
    }
    var respon = JSON.parse(data.target.response);

    if (respon.error==0){
      cargando(false);
      document.getElementById('progreso_'+respon.idsubactividad).innerHTML=respon.progreso;
      document.getElementById('prog_'+respon.idactividad).innerHTML=respon.proact;

      carga_contexto(idcontexto, idactividad, idpaciente);
      Swal.fire({
        position: 'bottom-start',
        text: "Guardado",
        showConfirmButton: false,
        timer: 700
      });
    }
    else{
      cargando(false);
      Swal.fire({
        icon: 'info',
        title: respon.terror,
        showConfirmButton: false,
        timer: 1000
      });
    }
  });
  xhr.onerror =  ()=>{
    cargando(false);
    console.log("error");
  };
  xhr.send(formData);
}


function carga_contexto(idcontexto, idactividad, idpaciente){
  var formData = new FormData();
	formData.append("idcontexto", idcontexto);
	formData.append("idactividad", idactividad);
	formData.append("idpaciente", idpaciente);
	formData.append("function", "upd");
	let xhr = new XMLHttpRequest();
	xhr.open('POST',"a_pacientes/db_.php");
	xhr.addEventListener('load',(data)=>{
    document.getElementById("con_"+idcontexto).innerHTML=data.target.response;
	});
	xhr.onerror = (e)=>{
		console.log(e);
	};
	xhr.send(formData);
}

function ver_img(div){
  var x = document.getElementById(div);
  x.style.display = "flex";
}


$(document).on('change',".filter_x",function(e){
  let id=e.currentTarget.form.id;
  let elemento = document.getElementById(id);
  let dix;
  (elemento.attributes.dix !== undefined) ? dix=elemento.attributes.dix.nodeValue : dix="trabajo";
  let des;
  (elemento.attributes.des !== undefined) ? des=elemento.attributes.des.nodeValue : des="";
  var formData = new FormData(elemento);
  /////////esto es para todas las variables
  let variables = new Object();
  for(let contar=0;contar<elemento.attributes.length; contar++){
    let arrayDeCadenas = elemento.attributes[contar].name.split("_");
    if(arrayDeCadenas.length>1){
      formData.append(arrayDeCadenas[1], elemento.attributes[contar].value);
    }
  }
  let datos = new Object();
  datos.des=des+".php";
  datos.dix=dix;
  redirige_div(formData,datos);
});
