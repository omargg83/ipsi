function editable(e, id){
  let divid=e.id;
  let arrayDeCadenas = divid.split("_");
	let idtext=arrayDeCadenas[1];
  console.log(idtext);

  $("#"+e.id).after("<textarea class='form-control' name='texto_"+idtext+"' id='texto_"+idtext+"'>"+e.innerHTML+"</textarea>");
  $("#"+e.id).remove();

  $("#texto_"+idtext).summernote({
    lang: 'es-ES',
    placeholder: 'Texto',
    tabsize: 5,
    height: 250
  });

}
