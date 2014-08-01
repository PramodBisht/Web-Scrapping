
<?php
if(isset($_GET['url'])&&!empty($_GET['url'])){
	
// example of how to use basic selector to retrieve HTML contents
include('library/simple_html_dom.php');
 
// get DOM from URL or file
$url=$_GET['url'];

$html = file_get_html($url);


echo "Job title is ".$html->find('p.headline-title')[0];
echo "Connection are ".$html->find('dd.overview-connections')[0];
echo $html->find('p.description')[0];

}
?>
<html>
<body>
<form action="" type="get">
	<input type="text" name="url" value="http://in.linkedin.com/in/brijeshbharadwaj"/>
	<input type="submit">
</form>
</body>
</html>