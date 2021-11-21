<?php

// Check if form was submitted
if(isset($_POST['submit'])) {

	// Configure upload directory and allowed file types
	$upload_dir = 'uploads'.DIRECTORY_SEPARATOR;
	$allowed_types = array('jpg', 'png', 'jpeg', 'gif');
	
	// Define maxsize for files i.e 10MB
	$maxsize = 12 * 1024 * 1024;
$ename = $_POST['ename'];
$iname = $_POST['iname'];
$dot='.';
$dash='-';
$space=' ';
	// Checks if user sent an empty form
	if(!empty(array_filter($_FILES['files']['name']))) {
		// Loop through each file in files[] array
		foreach ($_FILES['files']['tmp_name'] as $key => $value) {
			
			$file_tmpname = $_FILES['files']['tmp_name'][$key];
			$file_name = $_FILES['files']['name'][$key];
		    $datetime = date("Y-m-d H:i");
			$file_size = $_FILES['files']['size'][$key];
			$file_ext = pathinfo($file_name, PATHINFO_EXTENSION);
           $newname = $ename.$dash.$iname.$space.$datetime.$dot.$file_ext;
			// Set upload file path
			$filepath = $upload_dir.$newname;

			// Check file type is allowed or not
			if(in_array(strtolower($file_ext), $allowed_types)) {

				// Verify file size - 2MB max
				if ($file_size > $maxsize)		
					echo "Error: File size is larger than the allowed limit.";

				// If file with name already exist then append time in
				// front of name of the file to avoid overwriting of file
				if(file_exists($filepath)) {
					$filepath = $upload_dir.time().$file_name;
					
					if( move_uploaded_file($file_tmpname, $filepath)) {
				       
						echo "{$file_name} successfully uploaded <br />";
					}
					else {					
						echo "Error uploading {$file_name} <br />";
					}
				}
				else {
				
					if( move_uploaded_file($file_tmpname, $filepath)) {
		
						echo "{$file_name} successfully uploaded <br />";
					}
					else {					
						echo "Error uploading {$file_name} <br />";
					}
				}
			}
			else {
				
				// If file extension not valid
				echo "Error uploading {$file_name} ";
				echo "({$file_ext} file type is not allowed)<br / >";
			}
		}
	}
	else {
		
		// If no files selected
		echo "No files selected.";
	}
}

?>
