
<!-- Original:  Tomleung (lok_2000_tom@hotmail.com) This tag should not be removed-->
<!--Server time ticking clock v2.0 Updated by js-x.com-->
function MakeArrayday(size)
{
  this.length = size;
  for(var i = 1; i <= size; i++)
    this[i] = "";
  return this;
}
function MakeArraymonth(size)
{
  this.length = size;
  for(var i = 1; i <= size; i++)
    this[i] = "";
  return this;
}

var hours;
var minutes;
var seconds;
var timer=null;
function sClock(hours1,minutes1,seconds1)
{
  //alert(hours1);
  //alert(minutes1);
  //alert(seconds1);
  hours=parseInt(hours1);
  minutes=parseInt(minutes1);
  seconds=parseInt(seconds1);
  if(timer){clearInterval(timer);timer=null;}
  timer=setInterval("work();",1000);
}

function twoDigit(_v)
{
  if(_v<10)_v="0"+_v;
  return _v;
}

function work()
{
  if (!document.layers && !document.all && !document.getElementById) return;
  var runTime = new Date();
  var dn = "AM";
  var shours = hours;
  var sminutes = minutes;
  var sseconds = seconds;
  if (shours >= 12)
  {
    dn = "PM";
    shours-=12;
  }
  if (!shours) shours = 12;
  sminutes=twoDigit(sminutes);
  sseconds=twoDigit(sseconds);
  shours  =twoDigit(shours  );
  movingtime = ""+ shours + ":" + sminutes +":"+sseconds+" " + dn;
  if (document.getElementById)
    document.getElementById("clock").innerHTML=movingtime;
  else if (document.layers)
  {
    document.layers.clock.document.open();
    document.layers.clock.document.write(movingtime);
    document.layers.clock.document.close();
  }
  else if (document.all)
    clock.innerHTML = movingtime;

  if(++seconds>59)
  {
    seconds=0;
    if(++minutes>59)
    {
      minutes=0;
      if(++hours>23)
      {
        hours=0;
      }
    }
  }
}
