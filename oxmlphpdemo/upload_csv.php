<html>
<body>
<form action="process_csv.php" method="post"
enctype="multipart/form-data">
<label for="file">Filename:</label>
<input type="file" name="file" id="file" /> 
<br />
<br/>
Delimiter: 
<Input type = 'Radio' Name ='delimiter' value= 'comma' checked
<?PHP print $comma_delimiter; ?>
>Comma

<Input type = 'Radio' Name ='delimiter' value= 'semicolon' 
<?PHP print $semicolon_delimiter; ?>
>Semicolon
<Input type = 'Radio' Name ='delimiter' value= 'pipe' 
<?PHP print $pipe_delimiter; ?>
>Pipe
<Input type = 'Radio' Name ='delimiter' value= 'tab' 
<?PHP print $tab_delimiter; ?>
>Tab
<br/>
<input type="submit" name="submit" value="Submit" />
</form>
</body>
</html>