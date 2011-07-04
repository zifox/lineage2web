// ---- Bloquear botão direito do mouse (JS)
function click() {
if (event.button==2||event.button==3) {
oncontextmenu='return false';
}
}
document.onmousedown=click
document.oncontextmenu = new Function("return false;")

// ---- PopUp
function abrir(URL) {

  var w = 700;
  var h = 540;

  var left = (screen.width - w) / 2;
  var top = (screen.height - h) / 2;

  window.open(URL,'janela', 'width='+w+', height='+h+', top='+top+', left='+left+', scrollbars=yes, status=no, toolbar=no, location=no, directories=no, menubar=no, resizable=no, fullscreen=no');

}