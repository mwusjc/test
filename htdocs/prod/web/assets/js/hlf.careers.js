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
        if (data[i].slug === searchTerm) {
            return i;
        }
      }
      return -1;
    },

    // current date is ahead of publish start date
    // current date is before publish end date
    shouldBeDisplayed: function(currentDate, publishStartDate, publishEndDate) {
      var currentDate = new Date();
      return currentDate > publishStartDate && currentDate < publishEndDate;
    },

    renderCareers: function(data) {
      var monthNames = ["January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December"
      ];
      var currentDate = new Date();

      $.each(data, function(key,item) {

        var publishStartDate = new Date(item.datePublishTo.slice(0, -2));
        var publishEndDate = new Date(item.datePublishFrom.slice(0, -2));
        if (hlf.careers.shouldBeDisplayed(item, currentDate, publishStartDate, publishEndDate)) {
          mapping = {
            "_JOBID_" : item.slug,
            "_JOBTITLE_" : item.title,
            "_POSTED_" : monthNames[publishEndDate.getMonth()] + ' ' + publishEndDate.getDate() + ', ' + publishStartDate.getFullYear()
          };
          html = hlf.drawTemplate("#tpl-career-listing", mapping);
          $('#' + item.location + '-careers').append(html);
        }
      });
    }

  };