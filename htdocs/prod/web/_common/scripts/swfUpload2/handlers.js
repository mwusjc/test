var button_used = 0;
var queue_history = [];
var uploadSessionID;

function preparePage() {
	el=document.getElementById("myBtnUpload");
	el.style.display = "none";

}

function checkFileType() {
	for (i=0; i<queue_history.length; i++)
	{
		if (queue_history[i][2] == button_used)
		{
			return false;
		}
	}
	return true;
}

function getQueuePos(id) {
	for (i=0; i<queue_history.length; i++)
	{
		if (queue_history[i][1] == id)
		{
			return i;
		}
	}
	return -1;
}

function fileQueueError(fileObj, error_code, message)  {
	try {
		// Handle this error separately because we don't want to create a FileProgress element for it.
		switch(error_code) {
			case SWFUpload.QUEUE_ERROR.QUEUE_LIMIT_EXCEEDED:
				alert("You have attempted to queue too many files.\n" + (message == 0 ? "You have reached the upload limit." : "You may select " + (message > 1 ? "up to " + message + " files." : "one file.")));
				return;
				break;
			case SWFUpload.QUEUE_ERROR.FILE_EXCEEDS_SIZE_LIMIT:
				alert("The file you selected is too big.");
				this.debug("Error Code: File too big, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				return;
				break;
			case SWFUpload.QUEUE_ERROR.ZERO_BYTE_FILE:
				alert("The file you selected is empty.  Please select another file.");
				this.debug("Error Code: Zero byte file, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				return;
				break;
			case SWFUpload.QUEUE_ERROR.INVALID_FILETYPE:
				alert("The file you choose is not an allowed file type.");
				this.debug("Error Code: Invalid File Type, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				return;
				break;
			default:
				alert("An error occurred in the upload. Try again later.");
				this.debug("Error Code: " + error_code + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				return;
				break;
		}
	} catch (e) {}
}

function fileQueued(file) {
	queue_history[queue_history.length] = [file.name, file.id, button_used];
	
	types = new Array();
	if (defType == "asset")
	{
		types = "<select name='FileType" + file.id + "' id='FileType" + file.id + "'>";
			types += "<option value=1>logos</option>";
			types += "<option value=2>planograms</option>";
			types += "<option value=3>design definition</option>";
			types += "<option value=4>packout</option>";
			types += "<option value=5>structure</option>";
			types += "<option value=6>legal</option>";
			types += "<option value=7>qa/qc</option>";
			types += "<option value=8 selected>other</option>";
			types += "<option value=9 >pdf review (from n.a)</option>";
			types += "<option value=10>pdf review comments (from asia)</option>";
		types += "</select>";
	}

	if (defType == "tool")
	{
		types = "<select name='FileType" + file.id + "' id='FileType" + file.id + "'>";
			types += "<option value=101>project tools</option>";
			types += "<option value=102>sustainability tools</option>";
			types += "<option value=105>consumer  research</option>";
			types += "<option value=106>licensing   insights</option>";
			types += "<option value=107>industry  insights</option>";
			types += "<option value=103>other</option>";
			types += "<option value=104>archive</option>";
			types += "<option value=110>warning labels</option>";
		types += "</select>";
	}

	el  = document.getElementById("progressArea");
	txt = '<table width=420 id="progressTable'+file.id+'"><tr>';
	txt += '	<td width=300><div id="progressBar'+file.id+'" style="border: 1px solid #0066CC; height: 14px; width: 300px; padding: 0px; text-align: left; vertical-align:middle font-size: 12px; background-color: #DFE9EA; overflow: clip;">'+file.name+'</div></td>';
	txt += '<td width=100>'+types+'</td>';
	txt += '<td width=20><a href="#self" onclick="swfu.cancelFile(\''+file.id+'\')"><img src="_common/images/upload/remove_icon.gif" border="0"></a></td>';
	txt += '</tr>';
	el.innerHTML += txt;
	el = document.getElementById("uploadFile");
//	el.style.height = (parseInt(el.style.height) + 35) + "px" ;
//	el.style.top = (parseInt(el.style.top) - 12) + "px" ;


	el=document.getElementById("myBtnUpload");
	el.style.display = "block";
//	alert(queue_history.length);
}

function uploadStart(file) {
	el  = document.getElementById("progressBar" + file.id);
	el.innerHTML = '<img id="divProgressBar'+file.id+'" height=14 width=0 src="images/progress.gif">';
	return true;
}

function uploadFileCancelled(file) {
	tmp = [];
	for (i=0; i< queue_history.length; i++)
	{
		if (queue_history[i][1] != file.id)
		{
			tmp[tmp.length] = queue_history[i];
		}
		queue_history = tmp;
	}
	
	if (queue_history.length == 0)
	{
		el=document.getElementById("myBtnUpload");
		el.style.display = "none";
	}

	el = document.getElementById("progressTable" + file.id);
	el.style.display="none";

	el = document.getElementById("uploadFile");
//	el.style.height = (parseInt(el.style.height) - 35) + "px" ;
//	el.style.top = (parseInt(el.style.top) + 12) + "px" ;

}

function fileDialogComplete(num_files_selected) {
	validateForm();
}

function uploadProgress(fileObj, bytesLoaded, bytesTotal) {
	el3=document.getElementById("divProgressBar" + fileObj.id);
	var percent = Math.ceil((bytesLoaded / bytesTotal) * 300)
	el3.width = percent;
}

function uploadSuccess(fileObj, server_data) {
	try {
		fileObj.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
		var progress = new FileProgress(fileObj, this.customSettings.progress_target);
		progress.SetComplete();
		progress.SetStatus("Complete.");
		progress.ToggleCancel(false);
		
		if (server_data === " ") {
			this.customSettings.upload_successful = false;
		} else {
			this.customSettings.upload_successful = true;
			document.getElementById("hidFileID").value = server_data;
		}
		
	} catch (e) { }
}

function uploadComplete(fileObj) {
	queue_history.shift();
	if (queue_history.length > 0 )
	{
		el = document.getElementById("FileType" + queue_history[0][1]);
		this.setPostParams({filetype:el.options[el.selectedIndex].value});
		this.startUpload();
	} else {
		closeUploadDialog2();
		return true;
		el = document.getElementById("uploadFile");
		el.style.verticalAlign = "middle";
		el.style.textAlign = "center";
		el.innerHTML = "Upload was completed";
		el.innerHTML += "<br><br><center><input type='button' value='close' onclick='closeUploadDialog2();'></center>";
		return true;
	}
}

function uploadError(fileObj, error_code, message) {
	try {
		var txtFileName = document.getElementById("txtFileName");
		txtFileName.value = "";
		validateForm();
		
		// Handle this error separately because we don't want to create a FileProgress element for it.
		switch(error_code) {
			case SWFUpload.UPLOAD_ERROR.MISSING_UPLOAD_URL:
				alert("There was a configuration error.  You will not be able to upload a resume at this time.");
				this.debug("Error Code: No backend file, File name: " + file.name + ", Message: " + message);
				return;
				break;
			case SWFUpload.UPLOAD_ERROR.UPLOAD_LIMIT_EXCEEDED:
				alert("You may only upload 1 file.");
				this.debug("Error Code: Upload Limit Exceeded, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				return;
				break;
			case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
			case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
				break;
			default:
				alert("An error occurred in the upload. Try again later.");
				this.debug("Error Code: " + error_code + ", File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				return;
				break;
		}

		fileObj.id = "singlefile";	// This makes it so FileProgress only makes a single UI element, instead of one for each file
		var progress = new FileProgress(fileObj, this.customSettings.progress_target);
		progress.SetError();
		progress.ToggleCancel(false);

		switch(error_code) {
			case SWFUpload.UPLOAD_ERROR.HTTP_ERROR:
				progress.SetStatus("Upload Error");
				this.debug("Error Code: HTTP Error, File name: " + file.name + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.UPLOAD_FAILED:
				progress.SetStatus("Upload Failed.");
				this.debug("Error Code: Upload Failed, File name: " + file.name + ", File size: " + file.size + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.IO_ERROR:
				progress.SetStatus("Server (IO) Error");
				this.debug("Error Code: IO Error, File name: " + file.name + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.SECURITY_ERROR:
				progress.SetStatus("Security Error");
				this.debug("Error Code: Security Error, File name: " + file.name + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.FILE_CANCELLED:
				progress.SetStatus("Upload Cancelled");
				this.debug("Error Code: Upload Cancelled, File name: " + file.name + ", Message: " + message);
				break;
			case SWFUpload.UPLOAD_ERROR.UPLOAD_STOPPED:
				progress.SetStatus("Upload Stopped");
				this.debug("Error Code: Upload Stopped, File name: " + file.name + ", Message: " + message);
				break;
		}
	} catch (e) {}
}

/* This is an example of how to cancel all the files queued up.  It's made somewhat generic.  Just pass your SWFUpload
object in to this method and it loops through cancelling the uploads. */
function cancelQueue(instance) {
	document.getElementById(instance.customSettings.cancelButtonId).disabled = true;
	instance.stopUpload();
	var stats;
	
	do {
		stats = instance.getStats();
		instance.cancelUpload();
	} while (stats.files_queued !== 0);
	
}

/* **********************
   Event Handlers
   These are my custom event handlers to make my
   web application behave the way I went when SWFUpload
   completes different tasks.  These aren't part of the SWFUpload
   package.  They are part of my application.  Without these none
   of the actions SWFUpload makes will show up in my application.
   ********************** */
function fileDialogStart() {
	/* I don't need to do anything here */
}

function startFileUpload() {
	el = document.getElementById("FileType" + queue_history[0][1]);
	swfu.setPostParams({filetype:el.options[el.selectedIndex].value});
	swfu.startUpload();
}