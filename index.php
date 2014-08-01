
<html>
<body>
<p>put the linkedin, twitter and Angel.co link in a box and fetch the result.</p>
<form action="" type="get">
	<input type="text" name="url" value="http://in.linkedin.com/in/brijeshbharadwaj"/>
	<input type="submit">
</form>
</body>
</html>

<?php
if(isset($_GET['url'])&&!empty($_GET['url'])){
include('library/simple_html_dom.php');  //using the simple html dom for php library for web scrapping

$url=$_GET['url'];

$html = file_get_html($url); //required for web scrapping 

if(strpos($url,"linkedin")!==false){
	//block for linkedin
	$msg="";
	$counter=0;
	try{
		if(isset($html->find('p.headline-title')[0])==false){
			$msg.="job title is hidden"."<br>";
			$counter++;
		}
		else{
			echo $html->find('p.headline-title')[0]."<br>";
		}
		if(isset($html->find('dd.overview-connections')[0])==false){
			$msg.="no of connections are hidden"."<br>";
			$counter++;
		}
		else{
			echo $html->find('dd.overview-connections')[0]."<br>";
		}
		if(isset($html->find('p.description')[0])==false){
			$msg.="no of connections are hidden"."<br>";
			$counter++;
		}
		else{
			echo $html->find('p.description')[0]."<br>";
		}
		if(isset($html->find('ol.skills')[0])==false){
			$msg.="skill are not public";
			$counter++;

		}
		else{
			echo "My skills sets are<br>";;
			echo $html->find('ol.skills')[0]."<br>";
		}
		if($counter!=0){
			throw new Exception($msg);
		}
	}
	catch(Exception $e){
		echo $e->getMessage();
	}
	
	
}else
if(strpos($url,"twitter")!==false)
{
	//block for twitter
	$msg="";
	$counter=0;
	echo $html->find('h1.ProfileHeaderCard-name')[0];
	try{
		if(isset($html->find('p.ProfileHeaderCard-bio')[0])==false){
			$msg.="bio is not public"."<br>";
			$counter++;
		}
		else{
			echo $html->find('p.ProfileHeaderCard-bio')[0]."<br>";
		}
		if(isset($html->find('span.ProfileHeaderCard-locationText')[0])==false){
			$msg.="location is not public"."<br>";
			$counter++;
		}
		else{
			echo $html->find('span.ProfileHeaderCard-locationText')[0]."<br>";
		}
		if(isset($html->find('span.ProfileHeaderCard-urlText')[0])==false){
			$msg.="linkedin link is not public"."<br>";
			$counter++;
		}
		else{
			echo $html->find('span.ProfileHeaderCard-urlText')[0]."<br>";
		}
		if($counter!=0){
			throw new Exception($msg);
			
		}

	}
	catch(Exception $e){
		echo $e->getMessage();
	}

}
else
if(strpos($url,"angel")>=0){
	echo $url;
	$msg="";
	$name=$html->find("h1.name")[0];
	echo $name;
	$counter=0;
	try{
	$bio=$html->find('h2.bio')[0];
		if(isset($bio)==false){
			$msg.="User have not put bio"."<br>";
			echo $msg;
			$counter++;
		}else{
			echo $bio."<br>";
		}
		echo "followers and following";
		echo $html->find('div.follows')[0];
		if(isset($html->find('div.item')[5])==false){
			$msg.="User have not mention any skills"."<br>";
			$counter++;
		}else{
			echo "My skills are";
			echo $html->find('div.item')[5]."<br>";
		}
		if(isset($html->find('div.item')[6])==false){
			$msg.="User have not mention oppurtunity he/she is looking for"."<br>";
			$counter++;
		}else{
			echo $html->find('div.item')[6]."<br>";
		}
		if($counter!=0){
			throw new Exception($msg);
			
		}
	}
	catch(Exception $e){
		//echo "inside catch";
		echo $e->getMessage();
	}
	
	
	
	
	
	}

}
?>