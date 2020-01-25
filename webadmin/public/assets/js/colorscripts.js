
function Barva(koda)
{document.getElementById("vzorec").bgColor=koda;document.hcc.barva.value=koda.toUpperCase();document.hcc.barva.select();}
function HexToR(h){return parseInt((cutHex(h)).substring(0,2),16)}
function HexToG(h){return parseInt((cutHex(h)).substring(2,4),16)}
function HexToB(h){return parseInt((cutHex(h)).substring(4,6),16)}
function cutHex(h){return(h.charAt(0)=="#")?h.substring(1,7):h}
function checkcolor1(barva)
{var hexbarva,sError;sError="";hexbarva=barva.replace('#','');if(hexbarva==""){sError="1";}
if(hexbarva.length!=6){sError="1";}
var illegalChars="/[\(\)\<\>\,\;\:\\\/\"\[\]ghijklmnoprstuvzwxyqGHIJKLMNOPRSTUVZQWXY]/";if(hexbarva.match(illegalChars)){document.getElementById('startcolor').style.backgroundColor="#F78181";sError="1";}
if(sError=="")
{document.getElementById('startcolor').style.backgroundColor="#FFFFFF";}
else
{hexbarva="FFFFFF";document.getElementById('startcolor').style.backgroundColor="#F78181";}
return hexbarva;}