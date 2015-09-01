<html>
<head>
<title> </title>
<meta http-equiv="content-type" content="application/xhtml+xml; charset=utf-8" />
<script type="text/javascript">
function NameAdd(NameCity) {
    var re = /[^А-яЁё]/;
    var VChar = document.getElementById('NameCity').value;
    var valid = re.test(VChar);
    if (valid){
    	document.getElementById("e_name").style.display = "inline";
    	document.getElementById('btnSave').disabled = true;
    	}
    else{
    	document.getElementById("e_name").style.display = "none";
    	document.getElementById('btnSave').disabled = false;
    	}
}
function SizeAdd(SizeCity) {
    var re = /[^0-9]/;
    var VChar = document.getElementById('SizeCity').value;
    var valid = re.test(VChar);
    if (valid){
    	document.getElementById("e_size").style.display = "inline";
    	document.getElementById('btnSave').disabled = true;
    	}
    else{
    	document.getElementById("e_size").style.display = "none";
    	document.getElementById('btnSave').disabled = false;
    	}
}
function CitizenAdd(CitizenCity) {
    var re = /[^0-9]/;
    var VChar = document.getElementById('CitizenCity').value;
    var valid = re.test(VChar);
    if (valid){
    	document.getElementById("e_citizen").style.display = "inline";
    	document.getElementById('btnSave').disabled = true;
    	}
    else{
    	document.getElementById("e_citizen").style.display = "none";
    	document.getElementById('btnSave').disabled = false;
    	}
}
function StatusAdd(StatusCity) {
    var re = /[^А-яЁё]/;
    var VChar = document.getElementById('StatusCity').value;
    var valid = re.test(VChar);
    if (valid){
    	document.getElementById("e_status").style.display = "inline";
    	document.getElementById('btnSave').disabled = true;
    	}
    else{
    	document.getElementById("e_status").style.display = "none";
    	document.getElementById('btnSave').disabled = false;
    	}
}
function YearAdd(YearCity) {
    var re = /[^0-9]/;
    var VChar = document.getElementById('YearCity').value;
    var valid = re.test(VChar);
    if (valid){
    	document.getElementById("e_year").style.display = "inline";
    	document.getElementById('btnSave').disabled = true;
    	}
    else{
    	document.getElementById("e_year").style.display = "none";
    	document.getElementById('btnSave').disabled = false;
    	}
}
</script>
</head>
<body>
<?php

/////////////////////////ДОБАВЛЕНИЕ ИНФОРМАЦИИ О ГОРОДЕ ОБРАБОТКА ФОРМЫ//////////////////////////////////////////////////
if (isset($_POST['btnSave'])){
	$Name_City=htmlspecialchars($_POST['NameCity']);
	$Size_City=htmlspecialchars($_POST['SizeCity']);
	$Sitizen_City=htmlspecialchars($_POST['CitizenCity']);
	$Status_City=htmlspecialchars($_POST['StatusCity']);
	$Year_City=htmlspecialchars($_POST['YearCity']);
	$fail = fopen("city2.txt","a+");
	$text = "*".$Name_City."\r\n"."Площадь,".$Size_City."\r\n"."Население,".$Sitizen_City."\r\n"."Статус,".$Status_City."\r\n"."Год образовния,".$Year_City."\r\n";
	fwrite($fail,$text);
	fclose($fail);
}
/////////////////////////////////УДАЛЕНИЕ ДАННЫХ///////////////////////////////////////////
if (isset($_POST['DelCityInfo'])){
	$Del_City=$_POST['City'];
	if ($Del_City!="Выберите"){
		$file_handle = fopen("city2.txt", "r");
		$k=0;
		$j=0;
    	while (!feof($file_handle)) {
    		$line = fgets($file_handle);
    		$Del_City = str_replace("\r\n",'', strip_tags($Del_City));
    		$line = str_replace("\r\n",'', strip_tags($line));
		if ($line == "*".$Del_City)  $j=$k;
    		$k++;
    	}
	fclose($file_handle);
	$file=file("city2.txt");
	$file_handle=fopen("city2.txt","w");
	for($i=0;$i<sizeof($file);$i++){
    	if($i == $j){
			for($k=$j;$k<=$j+4;$k++){
			unset($file[$k]);
			$i++;
		}
    }
}
	fputs($file_handle,implode("",$file));
	fclose($file_handle);
	}
	else{
		echo"<b>Вы не выбрали город для удаления!</b><p>";
	}
}
///////////////////////////////////////////////////////////////////////////
$file_handle = fopen("city2.txt", "r");
echo "<form action=\"index2.php?\" method=\"post\">";
echo "<select name=\"City\">";
echo "<option selected>Выберите</option>";
while (!feof($file_handle)) {
    $line = fgets($file_handle);
    $first=substr($line,0,1);
    if ($first == "*"){
	$line=substr($line,1);
	echo "<option value=$line>$line</option>";
	}
}
echo "</select><p>";
echo "<input type=\"submit\" name=\"CityInfo\"value=\"Показать данные\">&nbsp;";
echo "<input type=\"submit\" name=\"DelCityInfo\"value=\"Удалить\">&nbsp;";
echo "<input type=\"submit\" name=\"AddCityInfo\"value=\"Добавить\">";
echo "</form>";
fclose($file_handle);
///////////
$file_handle = fopen("city2.txt", "r");
while (!feof($file_handle)) {
    $crepeat .= fgets($file_handle);
    $cityrepeat=str_ireplace("\r\n","!!!",$crepeat);
    }
fclose($file_handle);
?>
<script>
function clist(NameCity) {
    var Crepeat=2;
    var city_a="";
    var NCity = document.getElementById('NameCity').value;
    var input = "<?php echo $cityrepeat;?>";
	var city_array = input.split('!!!');
	for (var i = 0; i < city_array.length; i++) {
	city_a="*"+NCity;
	if(city_array[i]==city_a) Crepeat=1;
 	}
    if (Crepeat==1){
    	alert('Такой город уже есть в списке!');
    	document.getElementById('btnSave').disabled = true;
    	}
    else {
    	document.getElementById('btnSave').disabled = false;
    }
}
</script>
<?php
//////////////////////////////ВЫВОД ИНФОРМАЦИИ О ГОРОДЕ //////////////////////////////////////////////////
if (isset($_POST['CityInfo'])){
	$Ch_City=$_POST['City'];
	if ($Ch_City!="Выберите"){
		echo "Город -"." ".$Ch_City."<br>";
		$file_handle = fopen("city2.txt", "r");
		$k=0;
		$j=0;
    	while (!feof($file_handle)) {
    		$line = fgets($file_handle);
    		$Ch_City = str_replace("\r\n",'', strip_tags($Ch_City));
    		$line = str_replace("\r\n",'', strip_tags($line));
			if ($line == "*".$Ch_City) $j=$k;
    		$k++;
    	}
    fclose($file_handle);
    $file_handle = fopen("city2.txt", "r");
	$k=0;
    while (!feof($file_handle)) {
    	$line = fgets($file_handle);
    	$Ch_City = str_replace("\r\n",'', strip_tags($Ch_City));
    	$line = str_replace("\r\n",'', strip_tags($line));
	if (($k > $j) && ($k <= $j+4)) {
	    $p=explode(",",$line);
	    echo $p[0]." "."-"." ".$p[1]."<br>";
	}
    $k++;
    }
	fclose($file_handle);
	}
	else{
		echo"<b>Вы не выбрали город для просмотра!</b>";
	}
}
/////////////////////////ДОБАВЛЕНИЕ ИНФОРМАЦИИ О ГОРОДЕ//////////////////////////////////////////////////
if (isset($_POST['AddCityInfo'])){
	echo "<div id=\"form\">";
	echo "<b>Введите название города и данные о городе.</b><br>";
	echo "<FORM ACTION=\"index2.php\" METHOD=\"POST\" ID=\"FormAdd\">";
	echo "<table>";
	echo "<tr><td align=\"right\">Название города : </td><td><input required name=\"NameCity\" size=30 maxsize=22 ID=\"NameCity\" onBlur=\"NameAdd(this.value)\" /><span id=\"e_name\" style=\"display: none; color:#c00;\"> * Поле должно состоять из символов кириллицы</span></td></tr>";
	echo "<tr><td align=\"right\">Площадь города: </td><td><input required name=\"SizeCity\" size=30 maxsize=22 ID=\"SizeCity\" onBlur=\"SizeAdd(this.value)\" /> <span id=\"e_size\" style=\"display: none; color:#c00;\"> * Поле должно состоять из цифр</span></td></tr>";
	echo "<tr><td align=\"right\">Население города: </td><td><input required name=\"CitizenCity\" size=30 maxsize=22 ID=\"CitizenCity\" onBlur=\"CitizenAdd(this.value)\" /> <span id=\"e_citizen\" style=\"display: none; color:#c00;\"> * Поле должно состоять из цифр</span></td></tr>";
	echo "<tr><td align=\"right\">Статус города: </td><td><input required name=\"StatusCity\" size=30 maxsize=22 ID=\"StatusCity\" onBlur=\"StatusAdd(this.value)\" /> <span id=\"e_status\" style=\"display: none; color:#c00;\"> * Поле должно состоять из символов кириллицы</span></td></tr>";
	echo "<tr><td align=\"right\">Год образования: </td><td><input required name=\"YearCity\" size=30 maxsize=22 ID=\"YearCity\" onBlur=\"YearAdd(this.value)\" /> <span id=\"e_year\" style=\"display: none; color:#c00;\"> * Поле должно состоять из цифр</span></td></tr>";
	echo "<tr><td></td>";
	echo "<td><INPUT TYPE=\"submit\"  name=\"btnSave\" id=\"btnSave\" onClick=\"clist(this.value)\" value=\"Сохранить\"></td></tr>";
	echo "</table>";
	echo "</FORM>";
	echo "</div>";
}

?>
</body>
</html>
