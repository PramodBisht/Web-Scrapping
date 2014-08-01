
<html>
<body>
<form action="" type="get">
	<input type="text" name="url" value="http://in.linkedin.com/in/brijeshbharadwaj"/>
	<input type="submit">
</form>
</body>
</html>

<?php
if(isset($_GET['url'])&&!empty($_GET['url'])){
include('library/simple_html_dom.php');
 
$url=$_GET['url'];

$html = file_get_html($url);

if(strpos($url,"linkedin")!==false){

	//block for linkedin
echo "Job title is ".$html->find('p.headline-title')[0];
echo "Connection are ".$html->find('dd.overview-connections')[0];
echo "My summary is<br>";
echo $html->find('p.description')[0];
echo "My skills sets are<br>";
echo $html->find('ol.skills')[0];
}else
if(strpos($url,"twitter")!==false)
{
	//block for twitter
	
}
else
if(strpos($url,"angel")>=0){
	echo $url;
	$name=$html->find("h1.name")[0];
	try{
	$bio=$html->find('h2.bio')[0];
	if(isset($bio)==false){
		throw new Exception("User have not put bio");
	}
	}
	catch(Exception $e){
		echo $e->getMessage();
	}
	echo $name;
	echo $bio;
	echo "followers and following";
	echo $html->find('div.follows')[0];
	
	try{
	
	if(isset($html->find('div.item')[5])==false){
		throw new Exception("User have not mention any skills"."<br>");
	}else{
		echo "My skills are";
		echo $html->find('div.item')[5]."<br>";
	}
	}
	catch(Exception $e){
		echo $e->getMessage();
	}
	try{
	if(isset($html->find('div.item')[6])==false){
		throw new Exception("User have not mention oppurtunity he/she is looking for"."<br>");
	}else{
		
		echo $html->find('div.item')[6]."<br>";
	}
	}
	catch(Exception $e){
		echo $e->getMessage();
	}
	}

}
?>