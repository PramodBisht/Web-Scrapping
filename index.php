
<?php
if(isset($_GET['url'])&&!empty($_GET['url'])){
	echo "for linkedIn";
// example of how to use basic selector to retrieve HTML contents
include('library/simple_html_dom.php');
 
// get DOM from URL or file
$url=$_GET['url'];
echo "url is ".$url."<br>";

$html = file_get_html($url);
/*
// find all link
foreach($html->find('a') as $e) 
    echo $e->href . '<br>';

// find all image
foreach($html->find('img') as $e)
    echo $e->src . '<br>';

// find all image with full tag
foreach($html->find('img') as $e)
    echo $e->outertext . '<br>';

// find all div tags with id=gbar
foreach($html->find('div#gbar') as $e)
    echo $e->innertext . '<br>';

// find all span tags with class=gb1
foreach($html->find('span.gb1') as $e)
    echo $e->outertext . '<br>';

// find all td tags with attribite align=center
foreach($html->find('td[align=center]') as $e)
    echo $e->innertext . '<br>';
    
// extract text from table
echo $html->find('td[align="center"]', 1)->plaintext.'<br><hr>';

// extract text from HTML
echo $html->plaintext;
*/


echo "Job title is ".$html->find('p.headline-title')[0];
echo "Connection are ".$html->find('dd.overview-connections')[0];

}
?>
<html>
<body>
<form action="" type="get">
	<input type="text" name="url" value="http://in.linkedin.com/in/abhinavajey"/>
	<input type="submit">
</form>
</body>
</html>