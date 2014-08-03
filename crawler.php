<?php 
	include('library/simple_html_dom.php');
	$db=mysqli_connect("localhost","root",NULL,"data");
	if (mysqli_connect_errno()) {
	  echo "Failed to connect to MySQL: " . mysqli_connect_error();
	}
	$query = "SELECT `link` FROM `linkedin` WHERE 1";
	
	$result=mysqli_query($db,$query);
	if(!$result){
		 printf("Error: %s\n", mysqli_error($db));
   		 exit();
	}
	while($row = mysqli_fetch_array($result)) {
		$url=$row['link'];
		scrape_linkedin($url);
		sleep(15);
		echo "running another loop";

	}
	function scrape_linkedin($url){

		if(isset($url)&&!empty($url)){
		  //using the simple html dom php library for web scrapping
		//echo $url;
		//$url=$_GET['url'];


		$html = file_get_html($url); //required for web scrapping 
		/* starting of code for the linkedin*/
		if(strpos($url,"linkedin")!==false){
			//block for linkedin
			//echo $url;
			$msg="";
			$counter=0;
			$skill="";
			$designation="";$no_of_connection="";
			
				
			$name=$html->find('span.full-name')[0]->plaintext;
			echo $name."<br>";

			if(isset($html->find('p.headline-title')[0])==false){
				$designation="job title is hidden"."<br>";
			}
			else{
				$designation=$html->find('p.headline-title')[0]->plaintext;
				echo $designation."<br>";
			}
			if(isset($html->find('dd.overview-connections')[0])==false){
				$no_of_connection="0";
			}
			else{
				$no_of_connection=$html->find('dd.overview-connections')[0]->plaintext;
				$no_of_connection=substr($no_of_connection, 0,strpos($no_of_connection, "+"));
				echo $no_of_connection."<br>";
			}
			if(isset($html->find('p.description')[0])==false){
				$desc="description is hidden";
			}
			else{
				$desc=$html->find('p.description')[0]->plaintext;
				str_replace("&#x25ba;",",", $desc);
				echo $desc;
			}
			if(isset($html->find('ol.skills')[0])==false){
				$skill="skill are not public";
				
			}
			else{
				echo "My skills sets are<br>";;
				$skill=$html->find('ol.skills')[0]->plaintext."<br>";
				echo $skill;
			}
			$db=mysqli_connect("localhost","root",NULL,"data");
			if (mysqli_connect_errno()) {
			  echo "Failed to connect to MySQL: " . mysqli_connect_error();
			}
			$sql = "CREATE TABLE IF NOT EXISTS `linkedin` (`Name` text,`designation` text,`connection` int(11),
					`description` text,`skills` text,`link` varchar(100)) ENGINE=MyISAM  DEFAULT CHARSET=utf8";
		    $result=mysqli_query($db,$sql);
		    if(!$result){
				 printf("Error: %s\n", mysqli_error($db));
		   		 exit();
			}
			$query = "SELECT * FROM `linkedin` WHERE `link`=\"$url\";";
			
			$result=mysqli_query($db,$query);
			if(!$result){
				 printf("Error: %s\n", mysqli_error($db));
		   		 exit();
			}
			if($result->num_rows==0){
				//there is no entry of profile found in db and this block will add new entry in our db.
				$query = "INSERT INTO `linkedin`(`Name`, `designation`, `connection`, `description`, `skills`, `link`) VALUES ('$name','$designation','$no_of_connection','$desc','$skill','$url');";
				$result=mysqli_query($db,$query);
				if(!$result){
					 printf("Error: %s\n", mysqli_error($db));
		   		 	exit();
				}else{
					echo "added to our linkedin table";
				}
			}	
		    else{
		     //this block will execute only if there is some data available in our db and then it will check for changes
			while($row = mysqli_fetch_array($result)) {

			  $counter=0;$counter1=0;$counter2=0;$counter3=0;$counter4=0;
			  $new=$row['Name'];
			  $name=trim($name);
			  $name=str_replace("  ", " ", $name);
			  $designation=trim($designation);
			  $designation=str_replace("  ", " ", $designation);
			  $no_of_connection=trim($no_of_connection);
			  $no_of_connection=str_replace("  ", " ", $no_of_connection);
			  $desc=trim($desc);
			  $desc=str_replace("  ", " ", $desc);
			  if(strcmp($name,$row['Name'])!==0){
		         $counter++;
			  }
			  if(strcmp($row['designation'],$designation)!==0){
			  	 $counter1++;
			  }
			  if(strcmp($row['connection'],$no_of_connection)!==0){
			  	
			  	 $counter2++;
			  }
			  if(strcmp($row['description'],$desc)!==0){
			  	 $counter3++;
			  }
			  if(strcmp($row['skills'],$skill)!==0){
			  	 $counter4++;
			  }
			  if($counter!=0){
			  	$msg.= "name is changed<br>";
			  	$q="UPDATE `linkedin` SET `Name`=\"$name\" WHERE `link`=\"$url\";";
			  	mysqli_query($db,$q);

			  }
			  if($counter1!=0){
			  	$msg.= "designation is changed<br>";
			  	$q="UPDATE `linkedin` SET `designation`=\"$designation\" WHERE `link`=\"$url\";";
			  	mysqli_query($db,$q);
			  }
			  if($counter2!=0){
			  	$msg.= "no of connection are changed<br>";
			  	$q="UPDATE `linkedin` SET `connection`=\"$no_of_connection\" WHERE `link`=\"$url\";";
			  	mysqli_query($db,$q);
			  }
			  if($counter3!=0){
			  	$msg.= "summary is changed<br>";
			  	$q="UPDATE `linkedin` SET `description`=\"$desc\" WHERE `link`=\"$url\";";
			  	mysqli_query($db,$q);
			  }
			  if($counter4!=0){
			  	$msg.= "skills are changed<br>";
			  	$q="UPDATE `linkedin` SET `skills`=\"$skill\" WHERE `link`=\"$url\";";
			  	mysqli_query($db,$q);
			  }
			  if($counter!==0||$counter1!==0||$counter2!==0||$counter3!==0||$counter4!==0){
			  	echo $msg."<br>";
			  	echo "now trigger the sending email";
			  }

			}//end of while block
		} // end of second if block	
			mysqli_close($db);
		}
	}
	}


?>