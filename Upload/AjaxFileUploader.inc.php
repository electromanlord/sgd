<?
@session_start();

class AjaxFileuploader {

	var $uploadDirectory ='';
	var $uploaderIdArray=array();
	
	/**
	 * Constructor Function
	 * 
	 */
	function AjaxFileuploader($uploadDirectory) {
		if (trim($uploadDirectory) != '' && is_dir($uploadDirectory)) {
			$this->uploadDirectory=trim($uploadDirectory);			
		}
	}

	/**
	 * 
	 * This function return all the files in the upload directory, sorted according to their file types
	 *
	 * @return array
	 */		
	function getAllUploadedFiles() {
		$returnArray = array();
		$allFiles = $this->scanUploadedDirectory();
		return $returnArray;
	}

	/**
	 * 
	 * This function scans uploaded directory and returns all the files in it
	 *  
	 * @return array
	 */
	function scanUploadedDirectory() {
		$returnArray = array();
		if ($handle = opendir($this->uploadDirectory)) {
			while (false !== ($file = readdir($handle))) {
				if (is_file($this->uploadDirectory."/".$file)) {
					$returnArray[] = $file;
				}
			}
			closedir($handle);
		}
		else {
			die("<b>ERROR: </b> Could not read directory: ". $this->uploadDirectory);
		}
		return $returnArray;
	}

	/**
	 * This function returns html code for uploading a file
	 * 
	 * @param string $uploaderId
	 * 
	 * @return string
	 */
	function showFileUploader($uploaderId) {
		if (in_array($uploaderId, $this->uploaderIdArray)) {
			die($uploaderId." already used. please choose another id.");
			return '';
		}
		else {
			$this->uploaderIdArray[] = $uploaderId;
			return '<form id="formName'.$uploaderId.'" method="post" enctype="multipart/form-data" action="imageupload.php?dirname='.$this->uploadDirectory.'" target="iframe'.$uploaderId.'">
						<input type="hidden" name="id" value="'.$uploaderId.'" />							
						<span id="uploader'.$uploaderId.'" style="font-family:verdana;font-size:10;">
							Upload File: <input name="'.$uploaderId.'" type="file" value="'.$uploaderId.'" onchange=\'return uploadFile(this,"'.$this->uploadDirectory.'")\' /></span>
						<span id="loading'.$uploaderId.'"></span>						
						<iframe name="iframe'.$uploaderId.'" src="imageupload.php" width="400" height="100" style="display:none"> </iframe>
					</form>';
		}
	}
}
?>