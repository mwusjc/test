  hlf.careers = {
    renderSingleCareer: function(data) {

      var pathArray = window.location.pathname.split( '/' );
      var slug = pathArray.pop();

      var index = hlf.careers.getCareerIndex(data, slug);

      // index not found, redirect back to careers page
      if (index === -1) {
        window.location.href = '/careers';
      }

      var currentDate = new Date();
      var publishStartDate = new Date(data[index].publishFrom);
      var publishEndDate = new Date(data[index].publishTo);

      if (hlf.careers.shouldBeDisplayed(data[index], currentDate, publishStartDate, publishEndDate)) {

        $('#job-title-and-location').append(data[index].title + ' - ' + data[index].location);
        $('#job-duties').append(markdown.toHTML(data[index].details.duties));
        $('#job-requirements').append(markdown.toHTML(data[index].details.requirements));

        $('input[name=location]').attr('value', data[index].location);
        $('input[name=title]').attr('value', data[index].title);
        $('input[name=id]').attr('value', data[index].id);


      } else {
        window.location.href = '/careers';
      }

    },

    getCareerIndex: function(data, searchTerm) {
      for (var i=0; i < data.length; i++) {
        if (data[i].id == searchTerm) {
            return i;
        }
      }
      return -1;
    },

    // only render the listing if publish is set to true
    // current date is ahead of publish start date
    // current date is before publish end date
    // publish end date is not set
    shouldBeDisplayed: function(career, currentDate, publishStartDate, publishEndDate) {
      return career.publish === true && currentDate > publishStartDate && (currentDate < publishEndDate || !career.publishTo);
    },

    renderCareers: function(data) {
      var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"
      ];
      var currentDate = new Date();

      $.each(data, function(key,item) {

        var publishStartDate = new Date(item.publishFrom);
        var publishEndDate = new Date(item.publishTo);

        mapping = {
          "_JOBID_" : item.id,
          "_JOBTITLE_" : item.title,
          "_POSTED_" : monthNames[publishStartDate.getMonth()] + ' ' + publishStartDate.getDate() + ', ' + publishStartDate.getFullYear()
        };
        html = hlf.drawTemplate("#tpl-career-listing", mapping);

        if (hlf.careers.shouldBeDisplayed(item, currentDate, publishStartDate, publishEndDate)) {
          if (item.location === 'Scarborough') {
            $('#scarborough-careers').append(html);
          } else if (item.location === 'Mississauga') {
            $('#mississauga-careers').append(html);
          }
        }
      });
    }

  };