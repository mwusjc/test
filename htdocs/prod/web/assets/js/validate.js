var process;
var apibaseURL = "http://localhost:10010/v1";
var ApplicationProcess = ApplicationProcess || {};

// Init & initial AJAX call to API
ApplicationProcess.init = function (jobslug, resumeInput, coverLetterInput, formData, apiBase) {
  this.resumeInput = resumeInput;
  this.coverLetterInput = coverLetterInput;
  this.jobslug = jobslug;
  this.today = new Date();
  this.apibaseURL = apiBase;
  this.resumedata = {};
  this.coverdata = null;
  this.formData = formData;

  var email = ApplicationProcess.formData.get('emailAddress');

  ApplicationProcess.resumedata = {
    name: ApplicationProcess.resumeInput.name,
    contentType: ApplicationProcess.resumeInput.type,
    size: ApplicationProcess.resumeInput.size,
    assetType: 'resume'
  };
  ApplicationProcess.resumedata.s3Key = '/' + ApplicationProcess.jobslug + '/' + email + '/' + ApplicationProcess.resumedata.name;

  if (typeof ApplicationProcess.coverLetterInput !== 'undefined') {
    ApplicationProcess.coverdata = {
      name: ApplicationProcess.coverLetterInput.name,
      contentType: ApplicationProcess.coverLetterInput.type,
      size: ApplicationProcess.coverLetterInput.size,
      assetType: 'cover-letter'
    };
    ApplicationProcess.coverdata.s3Key = '/' + ApplicationProcess.jobslug + '/' + email + '/' + ApplicationProcess.coverdata.name;
  }

  var body = JSON.stringify({
    "firstName": ApplicationProcess.formData.get('firstName'),
    "lastName": ApplicationProcess.formData.get('lastName'),
    "emailAddress": ApplicationProcess.formData.get('emailAddress'),
    "phoneNumber": ApplicationProcess.formData.get('phoneNumber'),
    "assets": [],
    "jobSlug": ApplicationProcess.jobslug
  });
  var ajaxopts = {
    contentType: 'application/json',
    crossDomain: true,
    dataType: 'json',
    jsonp: false,
    data: body,
    method: 'POST',
    url: ApplicationProcess.apibaseURL + '/jobs/' + ApplicationProcess.jobslug + '/applications'
  };

  $.ajax(ajaxopts).done(ApplicationProcess.getResumeSignedUrl());
};

// Generic get signed URL method
ApplicationProcess.getSignedURL = function (type) {

  var ajaxopts = {
    contentType: 'application/json',
    crossDomain: true,
    dataType: 'json',
    jsonp: false,
    method: 'GET',
    url: ApplicationProcess.apibaseURL + '/utils/signedUrl'
  };

  var filedata = (type === 'cover-letter') ? ApplicationProcess.coverdata : ApplicationProcess.resumedata;
  ajaxopts.data = "path=" + ApplicationProcess.jobslug
    + "&filename=" + filedata.s3Key
    + "&contentType=" + filedata.contentType
    + "&contentLength=" + filedata.size
    + "&action=putObject";

  console.log(ajaxopts.data);
  return $.ajax(ajaxopts);
};

// Calls get signed URL for resume and calls resume upload method
ApplicationProcess.getResumeSignedUrl = function () {
  ApplicationProcess.getSignedURL('resume').done(ApplicationProcess.uploadResume);
};

// Calls get signed URL for cover letter and calls cover letter upload method
ApplicationProcess.getCoverSignedUrl = function () {
  ApplicationProcess.getSignedURL('cover-letter').done(ApplicationProcess.uploadCoverLetter);
};


ApplicationProcess.uploadResume = function (response) {
  var signed = ApplicationProcess.upload('resume', response.signedUrl);
  if (ApplicationProcess.coverdata !== null) {
    signed.done(ApplicationProcess.getCoverSignedUrl);
  } else {
    signed.done(ApplicationProcess.postFileData);
  }
};

ApplicationProcess.uploadCoverLetter = function (response) {
  var signed = ApplicationProcess.upload('cover-letter', response.signedUrl);
  signed.done(ApplicationProcess.postFileData);
};

  // Generic upload file method
ApplicationProcess.upload = function (type, url) {
  var filedata = new FormData();
  var thefile = (type === 'cover-letter') ? ApplicationProcess.coverLetterInput : ApplicationProcess.resumeInput;
  thefile.name = (type === 'cover-letter') ? ApplicationProcess.coverdata.name : ApplicationProcess.resumedata.name;
  console.log(thefile);
  filedata.append('file', thefile);

  return $.ajax({
    url: url,
    method: "PUT",
    data: filedata,
    crossDomain: true,
    processData: false,
    contentType: filedata.type,
    headers: {'Access-Control-Allow-Origin': '*'}
  });
};

ApplicationProcess.postFileData = function () {
  var email = ApplicationProcess.formData.get('emailAddress');
  var pushdata = {
    url: ApplicationProcess.apibaseURL + '/applications/' + ApplicationProcess.jobslug + '/' + email + '/assets',
    method: 'POST',
    data: ApplicationProcess.resumedata,
    contentType: 'application/json',
    crossDomain: true,
    dataType: 'json',
    jsonp: false
  };
  var resumepush = $.ajax(pushdata);

  if (typeof ApplicationProcess.coverLetterInput !== 'undefined') {
    pushdata.data = ApplicationProcess.coverdata;
    resumepush.done(function () {
      $.ajax(pushdata);
    });
  }
};

ApplicationProcess.error = function (err) {

};

ApplicationProcess.complete = function() {
  
}

ApplicationProcess.serialize = function (obj) {
    var str = [];
    for (var p in obj) {
      if (obj.hasOwnProperty(p)) {
        str.push(encodeURIComponent(p) + "=" + encodeURIComponent(obj[p]));
      }
      return str.join("&");
    }
};

(function(){

  var hasHtml5Validation = function() {
    return typeof document.createElement('input').checkValidity === 'function';
  };

  if (hasHtml5Validation()) {

    // Contact Form / Visit Us Validation
    $('#form').submit(function (e) {
      if (!this.checkValidity()) {
        e.preventDefault();
        $(this).addClass('invalid');
        $('#form-status').html('Invalid form inputs. Please try again.');
      } else {
        $(this).removeClass('invalid');
        $('#form-status').html('');
      }
    });

    // Job Application Form Validation
    $('#job-application').submit(function (e) {
      e.preventDefault();
      if (!this.checkValidity()) {
        $(this).addClass('invalid');
        $('#form-status').html('Invalid form inputs. Please try again.');
      } else {
        $(this).removeClass('invalid');

        // Some fun variables
        var jobslug = $('input[name=id]').val();
        var resumeInput = document.getElementById('upload-resume-file').files[0];
        var coverInput = document.getElementById('upload-coverletter-file').files[0];

        // BEGIN THE CLASS OF POSTING AND UPLOADING!!!
        ApplicationProcess.init(jobslug, resumeInput, coverInput, new FormData(this), apibaseURL);
      }
    });
  }

})();


