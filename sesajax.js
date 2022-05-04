//script optimized by www.xtreeme.com)
function xtr_makeHttpRequest(url,callback_function,return_xml){
var http_request,response,i
var activex_ids=[
'MSXML2.XMLHTTP.3.0',
'MSXML2.XMLHTTP',
'Microsoft.XMLHTTP'
]
if(window.XMLHttpRequest){
http_request=new XMLHttpRequest()
if(http_request.overrideMimeType){
http_request.overrideMimeType('text/plain')}
}else if(window.ActiveXObject){
for(i=0;i<activex_ids.length;i++){
try{
http_request=new ActiveXObject(activex_ids[i])
}catch(e){}}}
if(!http_request){
alert('Unfortunately your browser doesn\'t support Ajax.')
return false}
http_request.onreadystatechange=function(){
if(http_request.readyState !==4){
return}
if(http_request.status !==200){
alert('There was a problem with the request.(Code: '+http_request.status+')')
return}
if(return_xml){
response=http_request.responseXML
}else{
response=http_request.responseText}
callback_function(response)}
http_request.open('GET',url,true)
http_request.send(null)}
function xtr_get_option_from_url(str,optionName){
var ind=str.indexOf(optionName+'=')
if(ind !=-1){
var optEnd=str.indexOf('&',ind+optionName.length+1)
if(optEnd==-1){
return decodeURIComponent(str.substr(ind+optionName.length+1))}
else{
return decodeURIComponent(str.substring(ind+optionName.length+1,optEnd))}}
return 0}
function xtr_paging_link(url){
var pos=xtr_get_option_from_url(url,'strt')
xtr_run_search(pos)}
function xtr_run_search_submit(){
xtr_run_search(0)}
function xtr_run_search(pos){
var strt=(!xtr_isset(pos)||pos<=0)?"":("strt="+pos)
var search_form=document.getElementById('SearchForm')
if(search_form){
var formData=xtr_get_form_data(document.getElementById('SearchForm'))
var params=(formData.length>0)?(formData+((strt.length>0)?((formData[formData.length-1]=='&')?strt:("&"+strt)): "")):(strt)
params=(params.length>0)?("?"+params):params
xtr_call_script(params)}}
function xtr_call_script(params){
xtr_makeHttpRequest("sessearch.php"+params,xtr_show_results)}
function xtr_on_resize(){
var def_bgHider=document.getElementById('xtr_bghider')
var def_element=document.getElementById('xtr_def_results')
if(def_bgHider&&def_element){
var hiderHeight=(xtr_get_height()-10)
var hiderWidth=(xtr_get_width()-10)
def_bgHider.style.left=0+'px'
def_bgHider.style.top=0+'px'
def_bgHider.style.width=hiderWidth+'px'
def_bgHider.style.height=hiderHeight+'px'
def_element.style.left=20+'px'
def_element.style.top=60+'px'
def_element.style.width=(hiderWidth-10-30-40-30-20)+'px'
def_element.style.height=(hiderHeight-10-20-40-30-60)+'px'}}
function xtr_key_down(e){
if(document.getElementById('xtr_bghider')&&
document.getElementById('xtr_def_results')&&
(e.keyCode==27 || e.key=='esc')){
xtr_search_close_results()}}
function xtr_on_load(){
var q=xtr_get_param('q')
if(xtr_isNonEmptyStr(q)){
xtr_setup_q_value(q)
var params="?"+xtr_get_url_params()
xtr_call_script(params)}
var form=document.forms ['SearchForm']
if(form)
xtr_js_set_event(form,'submit','xtr_run_search_submit')
xtr_js_set_event(window,'resize','xtr_on_resize',true)
xtr_js_set_event(window,'keydown','xtr_key_down',true)}
function xtr_get_width(){
var x=0
if(self.innerHeight){
x=self.innerWidth}
else if(document.documentElement&&document.documentElement.clientHeight){
x=document.documentElement.clientWidth}
else if(document.body){
x=document.body.clientWidth}
return x}
function xtr_get_height(){
var y=0
if(self.innerHeight){
y=self.innerHeight}
else if(document.documentElement&&document.documentElement.clientHeight){
y=document.documentElement.clientHeight}
else if(document.body){
y=document.body.clientHeight}
return y}
function xtr_search_close_results(){
var def_bgHider=document.getElementById('xtr_bghider')
if(def_bgHider){
def_bgHider.style.display='none'
def_bgHider.innerHTML=''}
var def_element=document.getElementById('xtr_def_results')
if(def_element){
def_element.style.display='none'
def_element.innerHTML=''}}
function xtr_show_results(content){
var customId=''
if(customId&&customId.length>0&&document.getElementById(customId))
document.getElementById(customId).innerHTML=content
else{
var def_bgHider=document.getElementById('xtr_bghider')
var def_element=document.getElementById('xtr_def_results')
if(def_bgHider&&def_element){
def_bgHider.style.display='block'
def_bgHider.innerHTML=
"<div id=\"results_div_top\" style=\"padding: 10px; padding-right:20px;\">"+
"<div style=\"float: right; margin-bottom:10px; cursor:pointer;\">"+"<img src=\"btn-close.png\" onClick=\"javascript:xtr_search_close_results()\">"+"</div>"+
"</div>"
def_element.style.display='block'
def_element.innerHTML=content
xtr_on_resize()}
else{
alert('Unable to find default search results <div> element.')}}}
function xtr_get_form_data(obj){
var getstr=""
for(var i=0;i<obj.elements.length;i++){
var tagName=obj.elements[i].tagName
if(tagName=="INPUT"){
if(obj.elements[i].type=="text" || obj.elements[i].type=="hidden"){
getstr+=obj.elements[i].name+"="+encodeURIComponent(obj.elements[i].value)+"&"}
if(obj.elements[i].type=="checkbox"){
if(obj.elements[i].checked){
getstr+=obj.elements[i].name+"="+encodeURIComponent(obj.elements[i].value)+"&"
}else{
getstr+=obj.elements[i].name+"=&"}}
if(obj.elements[i].type=="radio"){
if(obj.elements[i].checked){
getstr+=obj.elements[i].name+"="+encodeURIComponent(obj.elements[i].value)+"&"}}}
else if(tagName=="TEXTAREA"){
getstr+=obj.elements[i].name+"="+encodeURIComponent(obj.elements[i].value)+"&"}
else if(tagName=="SELECT"){
var sel=obj.elements[i]
getstr+=sel.name+"="+encodeURIComponent(sel.options[sel.selectedIndex].value)+"&"}
else if(tagName=="FIELDSET" || tagName=="UL" || tagName=="LI"){
var childstr=get_form_data(obj.elements[i])
if(childstr&&childstr.length>0){
getstr+=childstr}}}
return getstr}
function xtr_isset(obj){
try{
return(obj===undefined)?false:true}
catch(err){}
return false}
function xtr_get_param(name){
name=name.replace(/[\[]/,"\\\[").replace(/[\]]/,"\\\]")
var regexS="[\\?&]"+name+"=([^&#]*)"
var regex=new RegExp(regexS)
var results=regex.exec(window.location.href)
if(results==null)
return null
else
return decodeURIComponent(results[1]).replace(/\+/g,' ')}
function xtr_get_url_params(){
var params=window.location.href.slice(window.location.href.indexOf('?')+1)
return params ? params : ""}
function xtr_isNonEmptyStr(str){
return xtr_isset(str)&&str&&str.length>0}
function xtr_setup_q_value(q){
var qInput=document.getElementById('ses-q-field')
if(qInput)
qInput.value=q}
function xtr_js_set_event(obj,event,fun,bubble){
if(obj){
if(obj.addEventListener)
obj.addEventListener(event,eval(fun),bubble)
else if(obj.addEvent)
obj.addEvent(event,eval(fun))
else
obj.attachEvent('on'+event,eval(fun))}}
xtr_js_set_event(window,'load','xtr_on_load',true)
