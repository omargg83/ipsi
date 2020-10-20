<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>IPSI - Admin</title>
        <link href="style.css" rel="stylesheet" />

        <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js" crossorigin="anonymous"></script>

        <link rel="stylesheet" href="librerias15/load/css-loader.css">
        <link rel="stylesheet" href="librerias15/css/bootstrap.min.css">
        <link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.css" />
        <link rel="stylesheet" href="librerias15/swal/dist/sweetalert2.min.css">
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/uikit@3.5.5/dist/css/uikit.min.css" />
		  <!-- Custom fonts for this template-->
		  <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
		  <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

		  <!-- Custom styles for this template-->
		  <link href="css/sb-admin-2.min.css" rel="stylesheet">
			<link href="ipsi.css" rel="stylesheet">
      <style>
      .box {

      }
      </style>
    </head>
  <body>
    <section class="containerx">
      <div draggable="true" class="box" is='b-card'><div class='card'><div class='card-header'>A</div><div class='body'>algo</div></div></div>
      <div draggable="true" class="box" is='b-card'><div class='card'>B</div></div>
      <div draggable="true" class="box" is='b-card'><div class='card'>c</div></div>
    </section>
</body>
<script type="text/javascript">
  var dragSrcEl = null;

	class Divlink extends HTMLDivElement  {
		connectedCallback() {
			this.addEventListener('dragstart', (e) => {
			    console.log("dragstart");
          this.style.opacity = '0.4';
          dragSrcEl = this;
          e.dataTransfer.effectAllowed = 'move';
          e.dataTransfer.setData('text/html', this.innerHTML);
			});
			this.addEventListener('dragenter', (e) => {
			    console.log("dragenter");
          this.classList.add('over');
			});
			this.addEventListener('dragover', (e) => {
			    console.log("dragover");
          if (e.preventDefault) {
            e.preventDefault();
          }
          e.dataTransfer.dropEffect = 'move';
          return false;
			});
			this.addEventListener('dragleave', (e) => {
			    console.log("dragleave");
          this.classList.remove('over');
			});
			this.addEventListener('drop', (e) => {
			    console.log("drop");
          if (e.stopPropagation) {
            e.stopPropagation(); // stops the browser from redirecting.
          }
          if (dragSrcEl != this) {
            dragSrcEl.innerHTML = this.innerHTML;
            this.innerHTML = e.dataTransfer.getData('text/html');
          }
          return false;
			});
			this.addEventListener('dragend', (e) => {
			    console.log("dragend");
          this.style.opacity = '1';

          items.forEach(function (item) {
            console.log()
            item.classList.remove('over');
          });
			});
		}
	}
	customElements.define("b-card", Divlink, { extends: "div" });


/*
document.addEventListener('DOMContentLoaded', (event) => {
  var dragSrcEl = null;
  function handleDragStart(e) {
    this.style.opacity = '0.4';
    dragSrcEl = this;
    e.dataTransfer.effectAllowed = 'move';
    e.dataTransfer.setData('text/html', this.innerHTML);
  }

  function handleDragOver(e) {
    if (e.preventDefault) {
      e.preventDefault();
    }
    e.dataTransfer.dropEffect = 'move';
    return false;
  }

  function handleDragEnter(e) {
    this.classList.add('over');
  }

  function handleDragLeave(e) {
    this.classList.remove('over');
  }

  function handleDrop(e) {
    if (e.stopPropagation) {
      e.stopPropagation(); // stops the browser from redirecting.
    }
    if (dragSrcEl != this) {
      dragSrcEl.innerHTML = this.innerHTML;
      this.innerHTML = e.dataTransfer.getData('text/html');
    }
    return false;
  }

  function handleDragEnd(e) {
    this.style.opacity = '1';

    items.forEach(function (item) {
      item.classList.remove('over');
    });
  }


  let items = document.querySelectorAll('.containerx .box');
  items.forEach(function(item) {
    item.addEventListener('dragstart', handleDragStart, false);
    item.addEventListener('dragenter', handleDragEnter, false);
    item.addEventListener('dragover', handleDragOver, false);
    item.addEventListener('dragleave', handleDragLeave, false);
    item.addEventListener('drop', handleDrop, false);
    item.addEventListener('dragend', handleDragEnd, false);
  });
});
*/

</script>
