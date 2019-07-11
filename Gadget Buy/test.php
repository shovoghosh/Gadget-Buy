<?php
	require_once("classes/Upload.php");

	if (isset($_FILES['file'])) {
		$allowed = array("jpg","png","jpeg");
		$upload = new Upload($_FILES['file'],"images/",170000,$allowed);
		 print_r($upload->GetResult());
	}
?>
<form action="test.php" method="post" enctype="multipart/form-data">
	<input type="file" name="file">
	<input type="submit">
</form>