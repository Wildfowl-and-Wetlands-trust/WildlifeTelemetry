<script>
function enableFile(){
var csv=document.getElementById("csv");
var action=document.getElementById("action");
if(action.value=='d'||action.value=='i'||action.value=='b')
csv.disabled=false;
else
csv.disabled=true;
}
</script>
<form  method="post" enctype="multipart/form-data">
<label for="mode">Data Source</label>
<select name="mode" id="mode" onChange="enableFile()">
	<option>Please choose data source</option>
<?php
foreach(array("getFromEobs"=>"EObs","argos"=>"Argos Download","gsm"=>"GSM") as $key=>$val) {
	$sel=($_REQUEST["mode"]==$key)?" selected=\"true\"":"";
	echo "<option".$sel." value=\"$key\">$val</option>\n";
}
?>
</select>
<br/>
<label for="action">Action</label>
<select name="action" id="action" onChange="enableFile()">
	<option>Please choose action</option>
<?php
foreach(array("d"=>"Download","g"=>"Decode","i"=>"import","b"=>"Download Bin file","t"=>"test","r"=>"Remote Download") as $key=>$val) {
	$sel=($_REQUEST["action"]==$key)?" selected=\"true\"":"";
	echo "<option".$sel." value=\"$key\">$val</option>\n";
}
?>
</select>
<br/>
<label for='argostypes'>Argos file formats</label>
<select id='argostypes' name='argostypes[]' multiple>
	<option>DS</option>
	<option>DIAG</option>
	<option>XML</option>
</select>
<br/>
<?php
if(in_array($_POST["action"],array('d','i','b')))
	$hidefile=false;
else
	$hidefile=true;
?>
<input <?=($hidefile)?" disabled=\"true\"":"";?> type="file" id="csv" name="csv" value="" accept=".csv,application/vnd.msexcel"/>
<br/>
<input type="submit" name="submit" value="Submit" />
</form>
<?php
// GET and post paramaters need to be processed here!
$validparams=array("mode","downloadonly","numdays","period","filename","argostypearray");
foreach($validparams as $par){
	if(isset($_REQUEST[$par])) {
		$$par=$_REQUEST[$par];
		#echo "$par=".$$par."<br/>";
	}
}


if ( isset($_POST["submit"]) ) {
if($_FILES["csv"]["error"]==0){
$filename=$_FILES["csv"]["tmp_name"];
}
}
// certain modes require a file
if(in_array($mode,array("getFromEobs"))){
	if (!isset($filename)) {
	echo "You must select a file for $mode";
	exit;
	}
}
print_r($_POST["argostypes"]);
require("telemetry_core.php");
