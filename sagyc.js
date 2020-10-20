/*
	Libreria Propia V.1
	Ruben Omar García
*/

	class MenuLink extends HTMLAnchorElement {
		connectedCallback() {
			this.addEventListener('click', (e) => {cargando(true);
				let formData = new FormData();

				let hash=e.currentTarget.hash.slice(1);
				let arrayDeCadenas = hash.split("?");
				let nhash=arrayDeCadenas[0];
				if(arrayDeCadenas.length>1){
					let query=arrayDeCadenas[1];
					var vars = query.split("&");
					for (var i=0; i < vars.length; i++) {
					var pair = vars[i].split("=");
						formData.append(pair[0],pair[1]);
					}
				}

				let datos = new Object();
				datos.des=nhash+".php";
				datos.dix="contenido";
				redirige_div(formData,datos);
			});
		}
	}
	customElements.define("menu-link", MenuLink, { extends: "a" });

	class ConfirmLink extends HTMLAnchorElement {
	  connectedCallback() {
	    this.addEventListener('click', (e) => {
	      proceso_db(e);
	    });
	  }
	}
	customElements.define("a-link", ConfirmLink, { extends: "a" });

	class CiLink extends HTMLLIElement {
	  connectedCallback() {
	    this.addEventListener('click', (e) => {
	      proceso_db(e);
	    });
	  }
	}
	customElements.define("li-link", CiLink, { extends: "li" });

	class Buttonlink extends HTMLButtonElement  {
		connectedCallback() {
			this.addEventListener('click', (e) => {
				proceso_db(e);
			});
		}
	}
	customElements.define("b-link", Buttonlink, { extends: "button" });


	//////////////////////////especial submit
	class Sublink extends HTMLInputElement   {
		connectedCallback() {
			this.addEventListener('change', (e) => {
				e.preventDefault();

				//////////id del formulario
		 		let id=e.target.form.id;
		 		let elemento = document.getElementById(id);

				/////////API que procesa el form
		 		let db;
				(elemento.attributes.db !== undefined) ? db=elemento.attributes.db.nodeValue : db="";

				/////////funcion del api que procesa el form
		 		let fun;
				(elemento.attributes.fun !== undefined) ? fun=elemento.attributes.fun.nodeValue : fun="";

				/////////Div de destino despues de guardar
				let dix;
				(elemento.attributes.dix !== undefined) ? dix=elemento.attributes.dix.nodeValue : dix="trabajo";

				/////////div destino despues de guardar
		 		let des;
				(elemento.attributes.des !== undefined) ? des=elemento.attributes.des.nodeValue : des="";

				let desid;
				(elemento.attributes.desid !== undefined) ? desid=elemento.attributes.desid.nodeValue : desid="";

				////////FORM pertenece a ventanamodal
		 		let cmodal;
				(elemento.attributes.cmodal !== undefined) ? cmodal=elemento.attributes.cmodal.nodeValue : cmodal="";

				let datos = new Object();
				datos.des=des+".php";
				datos.desid=desid;
				datos.db=db+".php";
				datos.dix=dix;
				datos.fun=fun;
				datos.cmodal=cmodal;
				var formDestino = new FormData();

				var formData = new FormData(elemento);
				formData.append("function", datos.fun);

				/////////esto es para todas las variables
				let variables = new Object();
				for(let contar=0;contar<elemento.attributes.length; contar++){
					let arrayDeCadenas = elemento.attributes[contar].name.split("_");
					if(arrayDeCadenas.length>1){
						formData.append(arrayDeCadenas[1], elemento.attributes[contar].value);
						formDestino.append(arrayDeCadenas[1], elemento.attributes[contar].value);
					}
				}

				if(db.length>4){
					cargando(true);
					let xhr = new XMLHttpRequest();
					xhr.open('POST',datos.db);
					xhr.addEventListener('load',(data)=>{
						if (!isJSON(data.target.response)){
							console.log(data.target.response);
							Swal.fire({
								type: 'error',
								title: "Error favor de verificar",
								showConfirmButton: false,
								timer: 1000
							});
							return;
						}

						var respon = JSON.parse(data.target.response);
						if (respon.error==0){
							if (datos.desid !== undefined && datos.desid.length>0) {
								document.getElementById(datos.desid).value=respon.id1;
								formDestino.append(datos.desid, respon.id1);
							}
							if (datos.des !== undefined && datos.des.length>4) {
								redirige_div(formDestino,datos);
							}
							if(datos.cmodal==1){
								$('#myModal').modal('hide');
							}
							cargando(false);
							Swal.fire({
								type: 'success',
								title: "Se guardó correctamente ",
								showConfirmButton: false,
								timer: 500
							});
						}
						else{
							Swal.fire({
								type: 'info',
								title: respon.terror,
								showConfirmButton: false,
								timer: 1000
							});
						}
					});
					xhr.onerror =  ()=>{
						console.log("error");
					};
					xhr.send(formData);
					cargando(false);
				}
			});
		}
	}
	customElements.define("s-submit", Sublink, { extends: "input" });

	class Formsubmit extends HTMLFormElement {
		connectedCallback() {
		 this.addEventListener('submit', (e) => {
			 	e.preventDefault();

				//////////id del formulario
		 		let id=e.currentTarget.attributes.id.nodeValue;
		 		let elemento = document.getElementById(id);

				/////////API que procesa el form
		 		let db;
				(elemento.attributes.db !== undefined) ? db=elemento.attributes.db.nodeValue : db="";

				/////////funcion del api que procesa el form
		 		let fun;
				(elemento.attributes.fun !== undefined) ? fun=elemento.attributes.fun.nodeValue : fun="";

				/////////Div de destino despues de guardar
				let dix;
				(elemento.attributes.dix !== undefined) ? dix=elemento.attributes.dix.nodeValue : dix="trabajo";

				/////////div destino despues de guardar
		 		let des;
				(elemento.attributes.des !== undefined) ? des=elemento.attributes.des.nodeValue : des="";

				let desid;
				(elemento.attributes.desid !== undefined) ? desid=elemento.attributes.desid.nodeValue : desid="";

				////////FORM pertenece a ventanamodal
		 		let cmodal;
				(elemento.attributes.cmodal !== undefined) ? cmodal=elemento.attributes.cmodal.nodeValue : cmodal="";

				let datos = new Object();
				datos.des=des+".php";
				datos.desid=desid;
				datos.db=db+".php";
				datos.dix=dix;
				datos.fun=fun;
				//datos.tp=tp;
				//datos.iddest=iddest;
				//datos.omodal=omodal;
				datos.cmodal=cmodal;
				var formDestino = new FormData();

				var formData = new FormData(elemento);
				formData.append("function", datos.fun);

				/////////esto es para todas las variables
				let variables = new Object();
				for(let contar=0;contar<elemento.attributes.length; contar++){
					let arrayDeCadenas = elemento.attributes[contar].name.split("_");
					if(arrayDeCadenas.length>1){
						formData.append(arrayDeCadenas[1], elemento.attributes[contar].value);
						formDestino.append(arrayDeCadenas[1], elemento.attributes[contar].value);
					}
				}

				if(db.length>4){
					Swal.fire({
						title: '¿Desea procesar los cambios realizados?',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						confirmButtonText: 'Guardar'
					}).then((result) => {
						if (result.value) {
							cargando(true);
							let xhr = new XMLHttpRequest();
							xhr.open('POST',datos.db);
							xhr.addEventListener('load',(data)=>{
								if (!isJSON(data.target.response)){
									console.log(data.target.response);
									Swal.fire({
										type: 'error',
										title: "Error favor de verificar",
										showConfirmButton: false,
										timer: 1000
									});
									return;
								}

								var respon = JSON.parse(data.target.response);
								if (respon.error==0){
									if (datos.desid !== undefined && datos.desid.length>0) {
										document.getElementById(datos.desid).value=respon.id1;
										formDestino.append(datos.desid, respon.id1);
									}
									if (datos.des !== undefined && datos.des.length>4) {
										redirige_div(formDestino,datos);
									}
									if(datos.cmodal==1){
										$('#myModal').modal('hide');
									}
									cargando(false);
									Swal.fire({
										type: 'success',
										title: "Se guardó correctamente ",
										showConfirmButton: false,
										timer: 1000
									});
								}
								else{
									Swal.fire({
										type: 'info',
										title: respon.terror,
										showConfirmButton: false,
										timer: 1000
									});
								}
							});
							xhr.onerror =  ()=>{
								console.log("error");
							};
							xhr.send(formData);
							cargando(false);
						}
					});

				}
				else{
					cargando(true);
					let xhr = new XMLHttpRequest();
					xhr.open('POST',datos.des);
					xhr.addEventListener('load',(data)=>{
						document.getElementById(datos.dix).innerHTML = data.target.response;
					});
					xhr.onerror =  ()=>{
						console.log("error");
					};
					xhr.send(formData);
					cargando(false);
				}
		 })
		}
	}
	customElements.define("f-submit", Formsubmit, { extends: "form" });

	class Formlogin extends HTMLFormElement {
		connectedCallback() {
		 this.addEventListener('submit', (e) => {
				e.preventDefault();

				//////////id del formulario
				let id=e.currentTarget.attributes.id.nodeValue;
				let elemento = document.getElementById(id);

				/////////API que procesa el form
				let db;
				(elemento.attributes.db !== undefined) ? db=elemento.attributes.db.nodeValue : db="";

				/////////funcion del api que procesa el form
				let fun;
				(elemento.attributes.fun !== undefined) ? fun=elemento.attributes.fun.nodeValue : fun="";

				/////////div destino despues de guardar
				let des;
				(elemento.attributes.des !== undefined) ? des=elemento.attributes.des.nodeValue : des="";

				let datos = new Object();
				datos.db=db+".php";
				datos.fun=fun;
				datos.des=des+".php";


				var formData = new FormData(elemento);
				formData.append("function", datos.fun);

				let xhr = new XMLHttpRequest();
				xhr.open('POST',datos.db);
				xhr.addEventListener('load',(resp)=>{
					var data = JSON.parse(resp.target.response);
		      if (data.acceso==1){
						location.href="../";
		      }
		      else{
		        Swal.fire({
		            type: 'error',
		            title: 'Usuario o contraseña incorrecta',
		            showConfirmButton: false,
		            timer: 1000
		        })
		      }
				});
				xhr.onerror =  ()=>{
					console.log("error");
				};
				xhr.send(formData);

		 })
		}
	}
	customElements.define("f-login", Formlogin, { extends: "form" });

	//////////////////////////Solo para un proceso antes del flujo ejem. al borrar que primero borre y luego redirive_div
	function proceso_db(e){
		cargando(true);

		let des;	/////////////el destino
		e.currentTarget.attributes.des!==undefined ? des=e.currentTarget.attributes.des.nodeValue : des="";

		let dix; 	/////////////	el div donde se pone el destino
		e.currentTarget.attributes.dix!==undefined ? dix=e.currentTarget.attributes.dix.nodeValue : dix="";

		let db;		/////////////en caso de base de datos
		e.currentTarget.attributes.db!==undefined ? db=e.currentTarget.attributes.db.nodeValue : db="";

		let fun;	///////////// la funcion a ejecutar
		e.currentTarget.attributes.fun!==undefined ? fun=e.currentTarget.attributes.fun.nodeValue : fun="";

		let tp;	///////////// la funcion a ejecutar
		e.currentTarget.attributes.tp!==undefined ? tp=e.currentTarget.attributes.tp.nodeValue : tp="";

		let iddest;
		e.currentTarget.attributes.iddest!==undefined ? iddest=e.currentTarget.attributes.iddest.nodeValue : iddest="";

		let omodal;
		e.currentTarget.attributes.omodal!==undefined ? omodal=e.currentTarget.attributes.omodal.nodeValue : omodal="";

		let cmodal;
		(e.currentTarget.attributes.cmodal !== undefined) ? cmodal=e.currentTarget.attributes.cmodal.nodeValue : cmodal="0";

		let datos = new Object();
		datos.des=des+".php";
		datos.db=db+".php";
		datos.dix=dix;
		datos.fun=fun;
		datos.tp=tp;
		datos.iddest=iddest;
		datos.omodal=omodal;
		datos.cmodal=cmodal;

		/////////esto es para todas las variables
		var variables = new FormData();
		var formData = new FormData();
		for(let contar=0;contar<e.currentTarget.attributes.length; contar++){
			let arrayDeCadenas = e.currentTarget.attributes[contar].name.split("_");
			if(arrayDeCadenas.length>1){
				formData.append(arrayDeCadenas[1], e.currentTarget.attributes[contar].value);
				variables.append(arrayDeCadenas[1], e.currentTarget.attributes[contar].value);
			}
		}
		if(datos.cmodal==1){
			$('#myModal').modal('hide');
			cargando(false);
			return;
		}
		if(datos.cmodal==2){
			$('#myModal').modal('hide');
			cargando(false);
		}
		//////////////poner aqui proceso en caso de existir funcion
		if(fun.length>0){
			if(datos.tp.length>0){
				formData.append("function", datos.fun);
				Swal.fire({
					title: datos.tp,
					showCancelButton: true,
					confirmButtonColor: '#3085d6',
					cancelButtonColor: '#d33',
					confirmButtonText: 'Aceptar'
				}).then((result) => {
					if (result.value) {
						let variable=0;
						let xhr = new XMLHttpRequest();
						xhr.open('POST',datos.db);
						xhr.addEventListener('load',(data)=>{
							console.log(data.target.response);
							if (!isJSON(data.target.response)){
								Swal.fire({
									type: 'error',
									title: "Error favor de verificar",
									showConfirmButton: false,
									timer: 1000
								});
								console.log(data.target.response);
								return;
							}
							var respon = JSON.parse(data.target.response);
							if (respon.error==0){
								Swal.fire({
									type: 'success',
									title: "Listo",
									showConfirmButton: false,
									timer: 1000
								});
								if (des.length>0){
									redirige_div(variables,datos);
								}
							}
							else{
								Swal.fire({
									type: 'info',
									title: respon.terror,
									showConfirmButton: false,
									timer: 1000
								});
							}
						});
						xhr.onerror = (e)=>{

						};
						xhr.send(formData);
					}
				});
			}
		}
		else{
			redirige_div(formData,datos);
		}
		cargando(false);
	}
	//////////////////////////redirige si es necesario
	function redirige_div(formData,datos){
		//console.log(datos);
		//for(var pair of formData.entries()) {
   		//console.log(pair[0]+ ', '+ pair[1]);
		//}
		let xhr = new XMLHttpRequest();
		xhr.open('POST', datos.des);
		xhr.addEventListener('load',(datares)=>{
			if(datares.target.status=="404"){
				Swal.fire({
						type: 'error',
						title: "No encontrado: "+datos.des,
						showConfirmButton: false,
				})
				return 0;
			}
			else{
				if(datos.omodal==1){
					$('#myModal').modal('show');
					datos.dix="modal_form";
				}
				document.getElementById(datos.dix).innerHTML = datares.target.responseText;
				var scripts = document.getElementById(datos.dix).getElementsByTagName("script");
				for (var i = 0; i < scripts.length; i++) {
			    eval(scripts[i].innerText);
				}
			}
		});
		xhr.onerror = (e)=>{
			console.log(e);
		};
		xhr.send(formData);
		cargando(false);
	}
	function cargando(valor) {
		let element = document.getElementById("cargando_div");
		if(valor){
			element.classList.add("is-active");
		}
		else{
			element.classList.remove("is-active");
		}
	}
	function isJSON (something) {
		if (typeof something != 'string')
				something = JSON.stringify(something);
		try {
				JSON.parse(something);
				return true;
		} catch (e) {
				return false;
		}
	}

/*

var dragSrcEl = null;
var dragdestino = null;

class Divlink extends HTMLDivElement  {
	connectedCallback() {
		this.addEventListener('dragstart', (e) => {
				this.style.opacity = '0.4';
				dragSrcEl = this;
				e.dataTransfer.effectAllowed = 'move';
				e.dataTransfer.setData('text/html', this.innerHTML);
		});
		this.addEventListener('dragenter', (e) => {
			this.classList.add('over');
			if (dragSrcEl != this) {
				dragdestino=this;
				let tmp=dragSrcEl.innerHTML;
				dragSrcEl.innerHTML=this.innerHTML;
				//dragdestino.innerHTML = tmp.innerHTML;
				//dragSrcEl.innerHTML=
				//dragSrcEl.innerHTML = dragdestino.innerHTML;
			}
		});
		this.addEventListener('dragover', (e) => {
				if (e.preventDefault) {
					e.preventDefault();
				}
				e.dataTransfer.dropEffect = 'move';
				return false;
		});
		this.addEventListener('dragleave', (e) => {
				this.classList.remove('over');
		});
		this.addEventListener('drop', (e) => {
			if (e.stopPropagation) {
				e.stopPropagation(); // stops the browser from redirecting.
			}
			if (dragSrcEl != this) {
				console.log("destino:"+this.dataset.orden);
				console.log("idSUbactividad:"+dragSrcEl.id);

				dragSrcEl.innerHTML = this.innerHTML;
				this.innerHTML = e.dataTransfer.getData('text/html');

				let idx = dragSrcEl.id.split("_");

				let formData = new FormData();
				formData.append("destino",this.dataset.orden);
				formData.append("id",idx[1]);
				formData.append("function","orden_subact");

				let xhr = new XMLHttpRequest();
				xhr.open('POST',"a_actividades/db_.php");
				xhr.addEventListener('load',(data)=>{
					console.log(data.target.response);
				});
				xhr.onerror =  ()=>{
					console.log("error");
				};
				xhr.send(formData);
			}
			return false;
		});
		this.addEventListener('dragend', (e) => {
				this.style.opacity = '1';
		});
	}
}
customElements.define("b-card", Divlink, { extends: "div" });

function insertAfter(e,i){
    if(e.nextSibling){
        e.parentNode.insertBefore(i,e.nextSibling);
    } else {
        e.parentNode.appendChild(i);
    }
}



let selected = null

class dragli extends HTMLLIElement {
	connectedCallback() {
		this.addEventListener('dragstart', (e) => {
			e.dataTransfer.effectAllowed = 'move'
			e.dataTransfer.setData('text/plain', null)
			selected = e.target
		});
		this.addEventListener('dragover', (e) => {
			if (isBefore(selected, e.target)) {
				//e.target.parentNode.insertBefore(selected, e.target)
			} else {
				//e.target.parentNode.insertBefore(selected, e.target.nextSibling)
			}
		});
		this.addEventListener('dragend', (e) => {
			selected = null;
		});
	}
}
customElements.define("b-order", dragli, { extends: "li" });

function isBefore(el1, el2) {
  let cur
  if (el2.parentNode === el1.parentNode) {
    for (cur = el1.previousSibling; cur; cur = cur.previousSibling) {
      if (cur === el2) return true;
    }
  }
  return false;
}

*/
