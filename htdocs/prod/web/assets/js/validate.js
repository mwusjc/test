(function(){

	function hasHtml5Validation () {
		return typeof document.createElement('input').checkValidity === 'function';
	}

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
	    if (!this.checkValidity()) {
	      e.preventDefault();
	      $(this).addClass('invalid');
	      $('#form-status').html('Invalid form inputs. Please try again.');
	    } else {
	      $(this).removeClass('invalid');
	      $('#form-status').html('');
	    }
	  });
	}

})();


