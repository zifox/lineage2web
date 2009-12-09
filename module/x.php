
<html>
<head>
<style type="text/css">
<!--
.style1 {
 color: #a88876;
 font-weight: bold;
}
.style4 {font-size: 12px; font-weight: bold; }
.style7 {color: #663300}
.style9 {font-size: 12px; font-weight: bold; color: #A88876; }
.style11 {
 color: #FF0000;
 font-weight: bold;
 font-size: 12px;
}
-->
</style>
<style type="text/css">
<!--
body,td,th {
 color: #CCCCCC;
}
.style12 {color: #A88876}
-->
</style>
<script type="text/javascript" src="data_control/mootools.js">
<script type="text/javascript">
 window.addEvent('load', function(){
  var Tips1 = new Tips($$('.Tips1'), {
   maxTitleChars: 50
  });
  $('nav').getElements('li').each(function(el){
   el.onmouseover = function(){ el.addClass('sfhover'); };
   el.onmouseout = function(){ el.removeClass('sfhover'); };
  });
 });
</script>
</head>

<script type='text/javascript'>
  var voteImage = new Asset.image('http://l2.pvpland.lv/l2.gif');
  var voteLinks = ['http://www.xtremetop100.com/in.php?site=1132252674'];
  var voteNr = 1;

  var hiddenNodes = new Array();

  window.addEvent('load', function(){
      if(window.ie){
          $$('select').each(function(el){
              hiddenNodes.push(el);
              el.setStyle('visibility', 'hidden');
          });
      }

      var blackLayer = new Element('div', {
          'styles': {
              'position': 'absolute',
              'top': '0px',
              'left': '0px', 
              'width': window.getScrollWidth(),
              'height': window.getScrollHeight(),
              'background-color': '#000000',
              'opacity': 0.0,
              'z-index': 799997
          }
      }).injectInside(document.body);
      
      var voteContainer = new Element('div', {
          'styles': {
              'position': 'absolute',
              'top': ( window.getScrollTop() + ( window.getHeight() - voteImage.height ) / 2 ),
              'left': ( window.getScrollLeft() + ( window.getWidth() - voteImage.width ) / 2 ),
              'width': voteImage.width,
              'background-color': '#000000',
              'z-index': 99999
          }
      }).injectInside(document.body);
      
      var voteLink = new Element('a', {
          'href': voteLinks[voteNr - 1],
          'target': '_blank'
      }).injectInside(voteContainer);
      voteImage.setStyle('border', '1px solid #FFFFFF').injectInside(voteLink);

      var voteNumber = new Element('div', {
          'styles': {
              'position': 'absolute',
              'top': '125px',
              'right': '125px',
              'font-size': 114,
              'font-weight': 'bold',
              'color': '#FFFFFF',
              'padding': '111px'
          }
      }).setText('').injectInside(voteContainer);
      
      var voteAbort = new Element('div', {
          'styles': {
              'color': '#FFFFFF',
              'cursor': 'pointer',
              'text-align': 'center'
          }
      }).setText('').injectInside(voteContainer);
      
      voteAbort.addEvent('click', function(){
     createCookie('vote', 'vote', '10');
          if(window.ie) hiddenNodes.each(function(el){ el.setStyle('visibility', ''); });
          blackLayer.remove();
          voteContainer.remove();
          window.removeEvents('scroll').removeEvents('resize');
          Garbage.trash([blackLayer, voteContainer]);
      });
      
      voteLink.addEvent('click', function(){
     createCookie('vote', 'vote', '720');
          voteNr++;
          (function(){
              if(voteNr > voteLinks.length){
                  if(window.ie) hiddenNodes.each(function(el){ el.setStyle('visibility', ''); });
                  blackLayer.remove();
                  voteContainer.remove();
                  window.removeEvents('scroll').removeEvents('resize');
                  Garbage.trash([blackLayer, voteContainer]);
              }else{
                  voteLink.href = voteLinks[voteNr - 1];
                  voteNumber.setText('Click here to vote');
              }
          }).delay(10);
      });
      
      window.addEvent('scroll', function(){
          voteContainer.setStyles({
              'top': ( window.getScrollTop() + ( window.getHeight() - voteImage.height ) / 2 ),
              'left': ( window.getScrollLeft() + ( window.getWidth() - voteImage.width ) / 2 )
          })
      });
      
      window.addEvent('resize', function(){
          blackLayer.setStyles({
              'width': window.getScrollWidth(),
              'height': window.getScrollHeight()
          });
          voteContainer.setStyles({
              'top': ( window.getScrollTop() + ( window.getHeight() - voteImage.height ) / 2 ),
              'left': ( window.getScrollLeft() + ( window.getWidth() - voteImage.width ) / 2 )
          })
      });
  });</script>