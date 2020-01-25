function fileQueueError(file, errorCode, message) {
	try {
		var imageName = "error.gif";
		var errorName = "";
		if (errorCode === SWFUpload.errorCode_QUEUE_LIMIT_EXCEEDED) {
			errorName = "You have attempted to queue too many files.";
		}

		if (errorName !== "") {
			jq_alert(errorName);
			return;
		}

		switch (errorCode) {
			case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
				imageName = "zerobyte.gif";
				message = "Error!! Empty File";
				break;
			case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
				imageName = "toobig.gif";
				message = "Error!! File Size Exceeds";
				break;
			case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
				message = "Error!! Invalid Filetype";
				break;
			default:
				message = "Error!! File Already Uploaded";
				break;
		}
		jq_alert(message);
		addImage(base_url+"images/" + imageName,this.customSettings.thumb_target);

	} catch (ex) {
		this.debug(ex);
	}

}

function fileDialogComplete(numFilesSelected, numFilesQueued) {
	try {
		if (numFilesQueued > 0) {
			this.startUpload();
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadProgress(file, bytesLoaded) {

	try {
		var percent = Math.ceil((bytesLoaded / file.size) * 100);

		var progress = new FileProgress(file,  this.customSettings.upload_target);
		progress.setProgress(percent);
		if (percent === 100) {
			progress.setStatus("Creating thumbnail...");
			progress.toggleCancel(false, this);
		} else {
			progress.setStatus("Uploading...");
			progress.toggleCancel(true, this);
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadSuccess(file, serverData) {
	//alert(serverData)
	var returnData
	var file_name;
	var file_id;
	var img_dim_error;
	var im_error;
	try {
		returnData		= serverData.split("##++##");
		file_name		= returnData[0];
		//file_id		= returnData[1];
		file_path		= returnData[1];
		img_dim_error	= returnData[2];
		
		var progress = new FileProgress(file,  this.customSettings.upload_target);

		if (img_dim_error.substring(0, 20) === "IMG_DIMENSION_ERROR:") {
			im_error = 	img_dim_error.substring(20);
		}
		
		if (im_error != 'NONE' && im_error != 'N/A') {
			jq_alert(im_error);
			
			var old_value = document.getElementById(this.customSettings.hiddenFileID).value;
			//document.getElementById(this.customSettings.txtFileName).value = document.getElementById(this.customSettings.hiddenFileID).value;
			if(old_value != ''){
				addImage(file_path.substring(9)+old_value,this.customSettings.thumb_target);
				document.getElementById(this.customSettings.txtFileName).value = old_value;
			}
			progress.setCancelled();
			progress.setStatus("Cancelled");
			progress.toggleCancel(false);
			return false;
		
		} else {
			
			if (file_name.substring(0, 9) === "FILENAME:") {
				document.getElementById(this.customSettings.hiddenFileID).value = file_name.substring(9);
				jq_alert("File Uploaded Successfully");
			}
			
			/*************************************************************
			if (file_id.substring(0, 7) === "FILEID:") {
				//alert(file_id.substring(7))
				addImage(hostname + "thumbnail.php?id=" + file_id.substring(7),this.customSettings.thumb_target);
	
				progress.setStatus("Thumbnail Created.");
				progress.toggleCancel(false);
			*************************************************************/	
			if (file_path.substring(0, 9) === "FILEPATH:") {
				//alert(file_id.substring(7))
				if(im_error != 'N/A') {
					addImage(file_path.substring(9)+file_name.substring(9),this.customSettings.thumb_target);
					progress.setStatus("Thumbnail Created.");
				} else {
					//addImage(file_path.substring(9)+file_name.substring(9),this.customSettings.thumb_target);
					//document.getElementById(this.customSettings.thumb_target).innerHTML = '<a target="_blank" href="'+file_path.substring(9)+file_name.substring(9)+'">'+file_name.substring(9)+'</a>';
					progress.setStatus("File Uploaded.");
				}
				progress.toggleCancel(false);
			} else {
				addImage(base_url+"images/error.gif",this.customSettings.thumb_target);
				progress.setStatus("Error.");
				progress.toggleCancel(false);
			}
			
		}

	} catch (ex) {
		this.debug(ex);
	}
}

function uploadComplete(file) {
	//alert(this.customSettings.txtFileName);
	try {
		/*  I want the next upload to continue automatically so I'll call startUpload here */
		if (this.getStats().files_queued > 0) {
			this.startUpload();
		} else {
			document.getElementById(this.customSettings.txtFileName).value = file.name;
			var progress = new FileProgress(file,  this.customSettings.upload_target);
			progress.setComplete();
			progress.setStatus("File Received.");
			progress.toggleCancel(true);
			
		}
	} catch (ex) {
		this.debug(ex);
	}
}

function uploadError(file, errorCode, message) {
	var imageName =  "error.gif";
	var progress;
	try {
		switch (errorCode) {
			case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
				try {
					progress = new FileProgress(file,  this.customSettings.upload_target);
					progress.setCancelled();
					progress.setStatus("Cancelled");
					progress.toggleCancel(false);
					message = "Error!! Upload Cancelled";
				}
				catch (ex1) {
					this.debug(ex1);
				}
				break;
			case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
				try {
					progress = new FileProgress(file,  this.customSettings.upload_target);
					progress.setCancelled();
					progress.setStatus("Stopped");
					progress.toggleCancel(true);
					message = "Error!! Upload Stopped";
				}
				catch (ex2) {
					this.debug(ex2);
				}
			case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
				imageName = "uploadlimit.gif";
				message = "Error!! Upload Limit Exceeded";
				break;
			default:
				//alert(message);
				break;
		}
		jq_alert(message);
		addImage(base_url+"images/" + imageName,this.customSettings.thumb_target);

	} catch (ex3) {
		this.debug(ex3);
	}

}


function addImage(src,thumb_target) {
	//alert(src);
	var newImg = document.createElement("img");
	newImg.setAttribute('width', '100'); 
	newImg.style.margin = "5px";

	document.getElementById(thumb_target).innerHTML = '';
	document.getElementById(thumb_target).appendChild(newImg);
	if (newImg.filters) {
		try {
			newImg.filters.item("DXImageTransform.Microsoft.Alpha").opacity = 0;
		} catch (e) {
			// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
			newImg.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + 0 + ')';
		}
	} else {
		newImg.style.opacity = 0;
	}

	newImg.onload = function () {
		fadeIn(newImg, 0);
	};
	newImg.src = src;
}

function fadeIn(element, opacity) {
	var reduceOpacityBy = 5;
	var rate = 10;	// 15 fps


	if (opacity < 100) {
		opacity += reduceOpacityBy;
		if (opacity > 100) {
			opacity = 100;
		}

		if (element.filters) {
			try {
				element.filters.item("DXImageTransform.Microsoft.Alpha").opacity = opacity;
			} catch (e) {
				// If it is not set initially, the browser will throw an error.  This will set it if it is not set yet.
				element.style.filter = 'progid:DXImageTransform.Microsoft.Alpha(opacity=' + opacity + ')';
			}
		} else {
			element.style.opacity = opacity / 100;
		}
	}

	if (opacity < 100) {
		setTimeout(function () {
			fadeIn(element, opacity);
		}, rate);
	}
}
