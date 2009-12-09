active = true;
step = -1;
step = Math.ceil(step);
if (step == 0)
  active = false;

function calctime(secs, num1, num2) {
  s = ((Math.floor(secs/num1))%num2).toString();
  if (s.length < 2)
    s = "0" + s;
  return "<b>" + s + "</b>";
}



function Clock(secs) {
  if (secs < 0) {
    document.getElementById("vote").innerHTML = endmsg;
    return;
  }
  ShowTime = TimeFormat.replace(/%%D%%/g, calctime(secs,86400,100000));
  ShowTime = ShowTime.replace(/%%H%%/g, calctime(secs,3600,24));
  ShowTime = ShowTime.replace(/%%M%%/g, calctime(secs,60,60));
  ShowTime = ShowTime.replace(/%%S%%/g, calctime(secs,1,60));

  document.getElementById("vote").innerHTML = ShowTime;
  if (active)
    setTimeout("Clock(" + (secs+step) + ")", (Math.abs(step)-1)*1000 + 990);
}
