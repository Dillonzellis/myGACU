<? 
//connect to mysql
//change user and password to your mySQL name and password
mysql_connect("localhost","hallc2","zbcna+an"); 
	
//select which database you want to edit
mysql_select_db("hallc2"); 

//If cmd has not been initialized
if(!isset($cmd)) 
{
   //display all the news
   $result = mysql_query("select * from optin order by id DESC"); 
   
   //run the while loop that grabs all the news scripts
   while($r=mysql_fetch_array($result)) 
   { 
      //grab the title and the ID of the news
      $id=$r["id"];//take out the title
      $name=$r["name"];//take out the id
     
	 //make the title a link
      echo "<a href='delete2.php?cmd=delete&id=$id'>$name - Delete</a>";
      echo "<br>";
    }
}
?>
<?
if($_GET["cmd"]=="delete")
{
    $sql = "DELETE FROM optin WHERE id=$id";
    $result = mysql_query($sql);
    echo "Application deleted!";
	echo "<br>";
	echo "Click <a href='optin.php'>here</a> to go back";
}
?>

