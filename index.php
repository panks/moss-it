<?php

$lang = $_POST["language"];

//Check if there are any files ready for upload
if (isset($_FILES['uploaded_files'])) {
    $foldername = time() . rand(0, 999);
    system('mkdir ./uploads/' . $foldername, $retval);
    //For each file get the $key so you can check them by their key value
    foreach ($_FILES['uploaded_files']['name'] as $key => $value) {
        //If the file was uploaded successful and there is no error
        if (is_uploaded_file($_FILES['uploaded_files']['tmp_name'][$key]) && $_FILES['uploaded_files']['error'][$key] == 0) {
            //Create an unique name for the file using the current timestamp, an random number and the filename			
            $filename = $_FILES['uploaded_files']['name'][$key];
            // $filename = time().rand(0,999).$filename;
            $filename = $filename;
            
            //Check if the file was moved
            if (move_uploaded_file($_FILES['uploaded_files']['tmp_name'][$key], 'uploads/' . $foldername . '/' . $filename)) {
                echo 'The file ' . $_FILES['uploaded_files']['name'][$key] . ' was uploaded successful <br/>';
            } else {
                echo move_uploaded_file($_FILES['uploaded_files']['tmp_name'][$key], 'uploads/' . $foldername . '/' . $filename);
                echo 'The file was not moved.';
            }
            
        } else {
            echo 'The file was not uploaded.';
        }
    }
    
    
    $handles = array( // [1]
        0 => array(
            "pipe",
            "r"
        ), // stdin 
        1 => array(
            "pipe",
            "w"
        ), // stdout 
        2 => array(
            "file",
            "test-errors.txt",
            "a"
        ) // stderr 
    );
    $process = shell_exec('python test.py ./uploads/' . $foldername . ' ' . $lang);
    sleep(5);
    echo "Running moss... <br><br>";
    foreach (glob("./res/res" . $foldername . ".txt") as $filename) {
        echo nl2br(file_get_contents($filename));
        echo "<br></br>";
    }
    
    $process = proc_open('rm -r ./uploads/' . $foldername, $handles, $pipes);
    $process = proc_open('rm ./res/res' . $foldername . '.txt', $handles, $pipes);
    
}

?>


<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8"/>
	<link rel="stylesheet" href="style.css" media="screen, projection"/>
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.1/jquery.min.js" type="text/javascript"></script>
	
	<script type="text/javascript">
	$(document).ready(function(){
	
		$('.add_field').click(function(){
	
			var input = $('#input_clone');
			var clone = input.clone(true);
			clone.removeAttr ('id');
			clone.val('');
			clone.appendTo('.input_holder'); 
			
		});

		$('.remove_field').click(function(){
		
			if($('.input_holder input:last-child').attr('id') != 'input_clone'){
				$('.input_holder input:last-child').remove();
			}
		
		});
	
	});
	
	</script>
</head>

<body>
<h1>moss-it</h1>
Compare files (source codes) using moss
<form action="index.php" method="POST" enctype="multipart/form-data">
	<div class="input_holder">
		<br><br>
		Language: 
		<select name="language">
			<option value="c">c</option>
			<option value="cc">cc</option>
			<option value="java">java</option>
			<option value="ml">ml</option>
			<option value="pascal">pascal</option>
			<option value="ada">ada</option>
			<option value="lisp">lisp</option>
			<option value="scheme">scheme</option>
			<option value="haskell">haskell</option>
			<option value="fortran">fortran</option>
			<option value="ascii">ascii</option>
			<option value="vhdl">vhdl</option>
			<option value="perl">perl</option>
			<option value="matlab">matlab</option>
			<option value="python">python</option>
			<option value="mips">mips</option>
			<option value="prolog">prolog</option>
			<option value="spice">spice</option>
			<option value="vb">vb</option>
			<option value="csharp">csharp</option>
			<option value="modula2">modula2</option>
			<option value="a8086">a8086</option>
			<option value="javascript">javascript</option>
			<option value="plsql">plsql</option>
			<option value="verilog">verilog</option>
		</select> 
		<br><br>
		Add your files here:<br>
		<span class="add_field">+</span>
		<span class="remove_field">-</span>
		<input type="file" name="uploaded_files[]" id="input_clone" />
		<input type="file" name="uploaded_files[]" id="input_clone" />
	</div>
	<input type="submit" value="Compare files" />
</form>
<br><br><br>
<a href="copyright">Copyright</a> | <a href="usage">Usage</a>
</body>

</html>
