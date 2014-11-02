var swfu;
var swfu2;
window.onload = function() {

// Max settings
swfu = new SWFUpload({
	upload_script : "upload.php?restoresessid=" + uploadSessionID,
	target : "SWFUploadTarget",
	flash_path : "SWFUpload.swf?x=" + Math.random(),
	allowed_filesize : 128000,	// 128 MB
	allowed_filetypes : "*.*",
	allowed_filetypes_description : "all image filetypes",
	browse_link_innerhtml : '<img id=\"myBrowseUpload\"  src="images/btn_browse.gif" border="0">',
	browse_link_innerhtml2 : '<img id=\"myBrowseUpload2\"  src="images/btn_browse.gif" border="0">',
	upload_link_innerhtml : "<img id=\"myBtnUpload\" src=\"images/btn_uploadfiles.gif\" border=\"0\">",
	browse_link_class : "swfuploadbtn browsebtn",
	upload_link_class : "swfuploadbtn uploadbtn",
	flash_loaded_callback : 'swfu.flashLoaded',
	upload_file_queued_callback : "fileQueued",
	upload_file_start_callback : 'uploadFileStart',
	upload_progress_callback : 'uploadProgress',
	upload_file_complete_callback : 'uploadFileComplete',
	upload_file_cancel_callback : 'uploadFileCancelled',
	upload_queue_complete_callback : 'uploadQueueComplete',
	upload_error_callback : 'uploadError',
	upload_cancel_callback : 'uploadCancel',
	auto_upload : false			
});

};
