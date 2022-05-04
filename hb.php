<style type="text/css">
.button {margin:10;width:20px;height:20px;color:#FFFFFF;cursor:pointer;}
</style>
<script type="text/javascript">
function MM_setTextOfTextfield(objId,x,newText) { //v9.0
  with (document){ if (getElementById){
    var obj = getElementById(objId);} if (obj) obj.value = newText;
  }
}
function MM_showHideLayers() { //v9.0
  var i,p,v,obj,args=MM_showHideLayers.arguments;
  for (i=0; i<(args.length-2); i+=3) 
  with (document) if (getElementById && ((obj=getElementById(args[i]))!=null)) { v=args[i+2];
    if (obj.style) { obj=obj.style; v=(v=='show')?'visible':(v=='hide')?'hidden':v; }
    obj.visibility=v; }
}
</script>

<FORM name="form" action="https://www.mobicint.net/hco/login" method="post">
        <table width="225" border="0" cellpadding="3" cellspacing="0" role="presentation">
          <tr>
            <td height="40" align="center" valign="bottom"><input name="user" type="text" class="HBFormBox" id="user" onfocus="MM_setTextOfTextfield('user','','')" value="User Name" size="12" /> </td><td valign="bottom">           <span id="HB2" style="position: absolute; z-index: 1; visibility: hidden;">
                <input name="FormData" id="FormData" class="HBFormBox" size="12" type="password" />
                </span><span id="HB1" style="position: relative; z-index: 1; visibility: visible;">
                  <input name="password" id="password" onfocus="MM_showHideLayers('HB2','','show','HB1','','hide');document.form.FormData.focus()" value="Password" class="HBFormBox" size="12" type="text" />
                </span></td>
            </tr>
          <tr>
            <td align="center" colspan="2"><div class="left_info_nav"> <a href="https://mobicint.net/hco/forgotPassword" target="_blank">Forgot/New Password</a><br>
<a href="https://www.mobicint.net/hco/forgotUsername" target="_blank">Forgot Username</a> <span class="button" id="button_with_popup_selectable" style="font-size:18px; color:#023361;">?</span></div>
              <input name="imageField" type="submit" value="Log-on" width="41" height="13" border="0" />
              </td>
          </tr>
        </table>
        </FORM>
