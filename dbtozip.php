<?php 
$db = new PDO("mysql:host=localhost;databasename=addyourdbname;charset=utf8", "yourdatabaseusername","yourdatabasepassword"); //Edit database link here by your own

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">	
<head>
<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css"
integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js"
integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous">
</script>
    <title>ZipArchive - DATA EXTRACTION FROM DATABASE-TRANSFER TO ZIP</title>
</head>
<body>

<?php


if ($_POST):

	$myquery = $db->prepare("select * from yourtablename");//select the table you want to export to zip file.Edit this place for yourself.
	$data = $myquery->execute();

	while ($finalsituation = $myquery->fetch(PDO::FETCH_ASSOC)):

		@$allpacket.= $finalsituation["tablecolumnname"]. "- ".$finalsituation["tablecolumnname"]."\n\n";//select the columns of the table.If there are more columns in the table, you can add it with the dot operator as in the example.Edit this place for yourself.

	endwhile;

	$myfile = fopen("db/data.txt","w");/*We transfer all the data we pulled from the database into a file. I created a folder named db in the directory where I was working and asked it to create a txt file under the folder for the data to be transferred from the database and save it to the data.txt file. Organize this place for yourself.
	*/
	
	if (fwrite($myfile,$allpacket)):

		echo "Data Transferred";

	else:
		
		echo "Data Failed to Transfer";

	endif;

	fclose($myfile);//close opened file

	//The process of transferring the file we created to the zip file
	$zip = new ZipArchive();
	$filename = "db/data.zip";/*We are telling it to create a zip file named data.zip under the db folder we created in the directory where we are working. Edit this according to your own. */

	//It will create a zip file
	if ($zip->open($filename,ZIPARCHIVE::CREATE) !== TRUE):

		exit("Failed to Create File");

	else:

		$zip->addFromString("db/data.txt",$allpacket);/* Type in the name of the txt file you will save the data to. Arrange it for yourself. */
		$zip->close();//close file
		//if the transaction is successful
		echo "Successfully Transferred";

	endif;

else:

?>
    <div class="container">

        <div class="row">
            <div class="col-xl-4 col-lg-4 col-md-4 col-sm-4 text-center mx-auto border border-secondary mt-3">
                <div class="row">
                    <div class="col-xl-12 col-lg-12 col-md-12 col-sm-12 text-center mx-auto m-2">
                        <form method="post" action="">
                            <input type="submit" name="submit" value="TRANSFER" class="btn btn-success btn-block" />
                        </form>
                    </div>
                </div>
            </div>


        </div>


    </div>

    <?php 
endif;
?>

</body>

</html>
