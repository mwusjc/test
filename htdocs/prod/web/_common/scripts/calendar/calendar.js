

var weekend = [5,6];
var submitk = 0;

var gNow = new Date();
var ggWinCal;

Calendar.Months = ["Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"];
Calendar.MonthsFull = ["January","February","March","April","May","June","July","August","September","October","November","December"];

// Non-Leap year Month days..
Calendar.DOMonth = [31, 28, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

// Leap year Month days..
Calendar.lDOMonth = [31, 29, 31, 30, 31, 30, 31, 31, 30, 31, 30, 31];

function Calendar(p_item,p_item2, p_WinCal, p_day, p_month, p_year, p_format, p_submit) {
   
	this.submit = p_submit;

	if ((p_month == null) && (p_year == null))	return;

	if (p_WinCal == null)
		this.gWinCal = ggWinCal;
	else
		this.gWinCal = p_WinCal;
	
	if (p_month == null) {
		this.gMonthName = null;
		this.gMonthNameFull = null;
		this.gMonth = null;
	} else {
		this.gMonthName = Calendar.get_month(p_month);
		this.gMonthNameFull = Calendar.get_month_full(p_month);
		this.gMonth = new Number(p_month);
	}

	this.gYear = p_year;
	this.gFormat = p_format;
	this.gReturnItem = p_item;
	this.gReturnIntItem = p_item2;

	this.gInitMonth = this.gMonth;
	this.gInitYear = this.gYear;
	this.gInitDay = p_day;
}

Calendar.get_month = Calendar_get_month;
Calendar.get_month_full = Calendar_get_month_full;
Calendar.get_daysofmonth = Calendar_get_daysofmonth;
Calendar.calc_month_year = Calendar_calc_month_year;

function Calendar_get_month(monthNo) {
	return Calendar.Months[monthNo];
}

function Calendar_get_month_full(monthNo) {
	return Calendar.MonthsFull[monthNo];
}

function Calendar_get_daysofmonth(monthNo, p_year) {
	/* 
	Check for leap year ..
	1.Years evenly divisible by four are normally leap years, except for... 
	2.Years also evenly divisible by 100 are not leap years, except for... 
	3.Years also evenly divisible by 400 are leap years. 
	*/
	if ((p_year % 4) == 0) {
		if ((p_year % 100) == 0 && (p_year % 400) != 0)
			return Calendar.DOMonth[monthNo];
	
		return Calendar.lDOMonth[monthNo];
	} else
		return Calendar.DOMonth[monthNo];
}

function Calendar_calc_month_year(p_Month, p_Year, incr) {
	/* 
	Will return an 1-D array with 1st element being the calculated month 
	and second being the calculated year 
	after applying the month increment/decrement as specified by 'incr' parameter.
	'incr' will normally have 1/-1 to navigate thru the months.
	*/
	var ret_arr = new Array();
	
	if (incr == -1) {
		// B A C K W A R D
		if (p_Month == 0) {
			ret_arr[0] = 11;
			ret_arr[1] = parseInt(p_Year) - 1;
		}
		else {
			ret_arr[0] = parseInt(p_Month) - 1;
			ret_arr[1] = parseInt(p_Year);
		}
	} else if (incr == 1) {
		// F O R W A R D
		if (p_Month == 11) {
			ret_arr[0] = 0;
			ret_arr[1] = parseInt(p_Year) + 1;
		}
		else {
			ret_arr[0] = parseInt(p_Month) + 1;
			ret_arr[1] = parseInt(p_Year);
		}
	}
	
	return ret_arr;
}

function Calendar_calc_month_year(p_Month, p_Year, incr) {
	/* 
	Will return an 1-D array with 1st element being the calculated month 
	and second being the calculated year 
	after applying the month increment/decrement as specified by 'incr' parameter.
	'incr' will normally have 1/-1 to navigate thru the months.
	*/
	var ret_arr = new Array();
	
	if (incr == -1) {
		// B A C K W A R D
		if (p_Month == 0) {
			ret_arr[0] = 11;
			ret_arr[1] = parseInt(p_Year) - 1;
		}
		else {
			ret_arr[0] = parseInt(p_Month) - 1;
			ret_arr[1] = parseInt(p_Year);
		}
	} else if (incr == 1) {
		// F O R W A R D
		if (p_Month == 11) {
			ret_arr[0] = 0;
			ret_arr[1] = parseInt(p_Year) + 1;
		}
		else {
			ret_arr[0] = parseInt(p_Month) + 1;
			ret_arr[1] = parseInt(p_Year);
		}
	}
	
	return ret_arr;
}

// This is for compatibility with Navigator 3, we have to create and discard one object before the prototype object exists.
new Calendar();

Calendar.prototype.getMonthlyCalendarCode = function() {
	var vCode = "";

	// Begin Table Drawing code here..
	var yearNext = parseInt(this.gYear)+1;
	var yearPrev = parseInt(this.gYear)-1;

	var prevMMYYYY = Calendar.calc_month_year(this.gMonth, this.gYear, -1);
	var prevMM = Calendar_get_month(prevMMYYYY[0]);
	var prevYYYY = prevMMYYYY[1];

	var nextMMYYYY = Calendar.calc_month_year(this.gMonth, this.gYear, 1);
	var nextMM = Calendar_get_month(nextMMYYYY[0]);
	var nextYYYY = nextMMYYYY[1];

	var imgNext = '<img src="_common/images/arrows/small-arrow-next.gif" border=0>';
	var imgPrev = '<img src="_common/images/arrows/small-arrow-prev.gif" border=0>';

	vCode += '<table class="navTable" cellspacing="0" cellpadding="0" border="0"><tr>';
	vCode += '<td class="navRows" align="left"><a class="calLink" href="javascript:'+this.makeLink(0,this.gMonth,yearPrev)+'">'+imgPrev+imgPrev+' '+yearPrev+"</a></td>";
	vCode += '<td class="navRows" align="left"><a class="calLink" href="javascript:'+this.makeLink(0,prevMMYYYY[0],prevMMYYYY[1])+'">'+imgPrev+imgPrev+' '+prevMM+"</a></td>";
	vCode += '<td class="navRows" align="right"><a class="calLink" href="javascript:'+this.makeLink(0,nextMMYYYY[0],nextMMYYYY[1])+'">'+nextMM+' '+imgNext+imgNext+"</a></td>";
	vCode += '<td class="navRows" align="right"><a class="calLink" href="javascript:'+this.makeLink(0,this.gMonth,yearNext)+'">'+yearNext+' '+imgNext+imgNext+'</a></td>';
	vCode += '</tr></table>';
	vCode += '<table class="calendarTable" cellspacing="1" cellpadding="0" border="0">';
	vCode += '<tr><td class="monthYear" colspan="7">'+this.gMonthNameFull+" "+this.gYear+'</td></tr>';
	vCode += this.makeWeekDays();
	vCode += this.makeCalendarBody(this.submit);
	vCode += "</table>";

	return vCode;
}

Calendar.prototype.makeLink = function(dy,mo,yr) {
	if (this.gReturnItem!=null) {
		return "window.opener.Build('"+this.gReturnItem+"','"+this.gReturnIntItem+"','"+parseInt(dy)+"','"+parseInt(mo)+"','"+parseInt(yr)+"','"+this.gFormat+"');";
	} else {
		return "includeCalendar('"+this.mCalendarSpan+"','"+this.mBaseLink+"','"+parseInt(dy)+"','"+parseInt(mo)+"','"+parseInt(yr)+"');";
	} // else
}

Calendar.prototype.show = function() {
	var vCode = "";
	
	this.gWinCal.document.open();

	// Setup the page...
	this.wwrite("<html>");
	this.wwrite("<head><title>Calendar</title>");
	this.wwrite('<link rel="stylesheet" type="text/css" href="_common/css/calendar.css">');
	this.wwrite("</head>");

	this.wwrite("<body>");

	// Get the complete calendar code for the month..
	this.wwrite(this.getMonthlyCalendarCode());

	this.wwrite("</body></html>");
	this.gWinCal.document.close();
}

Calendar.prototype.wwrite = function(wtext) {
	this.gWinCal.document.writeln(wtext);
}

Calendar.prototype.makeWeekDays = function() {
	var vCode = "";
	vCode += "<tr>";
	vCode += "<th abbr='Monday' scope='col' title='Monday' class='wkDay'>Mon</th>";
	vCode += "<th abbr='Tuesday' scope='col' title='Tuesday' class='wkDay'>Tue</th>";
	vCode += "<th abbr='Wednesday' scope='col' title='Wednesday' class='wkDay'>Wed</th>";
	vCode += "<th abbr='Thursday' scope='col' title='Thursday' class='wkDay'>Thu</th>";
	vCode += "<th abbr='Friday' scope='col' title='Friday' class='wkDay'>Fri</th>";
	vCode += "<th abbr='Saturday' scope='col' title='Saturday' class='wkDay'>Sat</th>";
	vCode += "<th abbr='Sunday' scope='col' title='Sunday' class='wkDay'>Sun</th>";
	vCode += "</tr>";
	return vCode;
}

Calendar.prototype.makeCalendarBody = function(p_submit) {
	var vDate = new Date();
	vDate.setDate(1);
	vDate.setMonth(this.gMonth);
	vDate.setFullYear(this.gYear);

	
	var a = new String(this.gReturnItem);
	var formName = a.split(".");

	var submitclause="self.opener.document."+formName[0]+".submit();";
	if (p_submit != 1 && submitk != 1) 
		submitclause="";
	else
		submitk = 1;
	
	var vFirstDay=vDate.getDay();
	if (vFirstDay == 0)
	   vFirstDay=6;
	else
	   vFirstDay --;

	var vDay = 1;
	var vLastDay=Calendar.get_daysofmonth(this.gMonth, this.gYear);
	var vOnLastDay=0;
	var vCode = "";

	/*
	Get day for the 1st of the requested month/year..
	Place as many blank cells before the 1st day of the month as necessary. 
	*/

	vCode += "<tr class=dayRows>";
	for (i=0; i<vFirstDay; i++) {
		vCode += "<td class=dayOut>&nbsp;</td>";
	} // for

	// Write rest of the 1st week
	for (j=vFirstDay; j<7; j++) {
		if (this.isInitDay(vDay)) {
			tdClass = 'dayActive';
		} else if (this.isToday(vDay)) {
			tdClass = 'dayToday';
		} else if (this.checkIsWeekend(j)) {
			tdClass = 'dayWeekend';
		}  else {
			tdClass = 'dayIn';
		} // else

		if (this.gReturnItem!=null) {
			vLinkExtra = "onClick=\"myElem = self.opener.document.getElementById('" + this.gReturnItem + "'); myElem.value='" + this.format_data(vDay) + "'; " + submitclause + ";myElem = self.opener.document.getElementById('" + this.gReturnIntItem + "');myElem.value=parseInt("+this.get_data(vDay) + ");" + ";window.close();\"";
			vLink = '#';
		} else {
//			vLinkExtra = "onMouseOver=\"alert(events["+this.gYear+"]["+parseInt(this.gMonth+1)+"]["+vDay+"]);\"";
			vLinkExtra = '';

			vLink = this.mBaseLink+'&dy='+vDay+'&mo='+parseInt(this.gMonth+1)+'&yr='+this.gYear;
		} // else

		// see if today has event
		if (this.gReturnItem==null && events!=null && events[this.gYear]!=null && events[this.gYear][parseInt(this.gMonth+1)]!=null && events[this.gYear][parseInt(this.gMonth+1)][vDay]!=null) {
			vDayStr = '<u>'+vDay+'</u>';
			vTitle = events[this.gYear][parseInt(this.gMonth+1)][vDay] + ' entries';
		} else {
			vDayStr = vDay;
			vTitle = '';
		} // else

		vCode += '<td class='+tdClass+'><a class="calLink" title="'+vTitle+'" href="'+vLink+'" '+vLinkExtra+'>'+vDayStr+'</a></td>';
		vDay++;
	} // for
	vCode += "</tr>";

	

	// Write the rest of the weeks
	for (k=2; k<7; k++) {
		vCode += "<tr class=dayRows>";
		for (j=0; j<7; j++) {
			if (this.isInitDay(vDay)) {
				tdClass = 'dayActive';
			} else if (this.isToday(vDay)) {
				tdClass = 'dayToday';
			} else if (this.checkIsWeekend(j)) {
				tdClass = 'dayWeekend';
			}  else {
				tdClass = 'dayIn';
			} // else
			if (this.gReturnItem!=null) {
				vLinkExtra = "onClick=\"myElem = self.opener.document.getElementById('" + this.gReturnItem + "'); myElem.value='" + this.format_data(vDay) + "'; " + submitclause + ";myElem = self.opener.document.getElementById('" + this.gReturnIntItem + "');myElem.value=parseInt("+this.get_data(vDay) + ");" + ";window.close();\"";
				vLink = '#';
			} else {
				vLinkExtra = '';
//				vLinkExtra = "onMouseOver=\"alert(events["+this.gYear+"]["+parseInt(this.gMonth+1)+"]["+vDay+"]);\"";
				vLink = this.mBaseLink+'&dy='+vDay+'&mo='+parseInt(this.gMonth+1)+'&yr='+this.gYear;
			} // else

			// see if today has event
			if (this.gReturnItem==null && events!=null && events[this.gYear]!=null && events[this.gYear][parseInt(this.gMonth+1)]!=null && events[this.gYear][parseInt(this.gMonth+1)][vDay]!=null) {
				vDayStr = '<u>'+vDay+'</u>';
				vTitle = events[this.gYear][parseInt(this.gMonth+1)][vDay] + ' entries';
			} else {
				vDayStr = vDay;
				vTitle = '';
			} // else

			vCode += '<td class='+tdClass+'><a class="calLink" title="'+vTitle+'" href="'+vLink+'" '+vLinkExtra+'>'+vDayStr+'</a></td>';
			vDay++;

			if (vDay > vLastDay) {
				vOnLastDay = 1;
				break;
			} // if
		}

		if (j == 6) { vCode += "</tr>"; } // if
		if (vOnLastDay == 1) { break; } // if

	} // for
	
	// Fill up the rest of last week with proper blanks, so that we get proper square blocks
	for (m=1; m<(7-j); m++) {
		vCode += "<td class=dayOut>&nbsp;</td>";
	} // for
	
	return vCode;
}

Calendar.prototype.isToday = function(vday) {
	var vNowDay = gNow.getDate();
	var vNowMonth = gNow.getMonth();
	var vNowYear = gNow.getFullYear();
	if (vday == vNowDay && this.gMonth == vNowMonth && this.gYear == vNowYear) {
		return true;
	} // if
	return false;
}

Calendar.prototype.isInitDay = function(vday) {
	if (vday == this.gInitDay && this.gInitMonth == this.gMonth && this.gInitYear == this.gYear) {
		return true;
	} // if
	return false;
}

Calendar.prototype.checkIsWeekend = function(vday) {
	var i;
	// Return special formatting for the weekend day.
	for (i=0; i<weekend.length; i++) {
		if (vday == weekend[i]) {
			return true;
		}
	}
	return false;
}

Calendar.prototype.get_data = function(p_day) {
	var vData = new Date();
	vData.setDate(p_day);
	vData.setMonth(this.gMonth);
	vData.setYear(this.gYear);
	return (vData.getTime()/1000);
}

Calendar.prototype.format_data = function(p_day) {
	var vData;
	var vMonth = 1 + this.gMonth;
	vMonth = (vMonth.toString().length < 2) ? "0" + vMonth : vMonth;
	var vMon = Calendar.get_month(this.gMonth).substr(0,3).toUpperCase();
	var vFMon = Calendar.get_month(this.gMonth).toUpperCase();
	var vFullMon = Calendar.get_month(this.gMonth);
	var vY4 = new String(this.gYear);
	var vY2 = new String(this.gYear.substr(2,2));
	var vDD = (p_day.toString().length < 2) ? "0" + p_day : p_day;

	switch (this.gFormat) {
		case "MM\/DD\/YYYY" :
			vData = vMonth + "\/" + vDD + "\/" + vY4;
			break;
		case "MM\/DD\/YY" :
			vData = vMonth + "\/" + vDD + "\/" + vY2;
			break;
		case "MM-DD-YYYY" :
			vData = vMonth + "-" + vDD + "-" + vY4;
			break;
		case "MM-DD-YY" :
			vData = vMonth + "-" + vDD + "-" + vY2;
			break;
		case "DD\/MON\/YYYY" :
			vData = vDD + "\/" + vMon + "\/" + vY4;
			break;
		case "DD\/MON\/YY" :
			vData = vDD + "\/" + vMon + "\/" + vY2;
			break;
		case "DD-MON-YYYY" :
			vData = vDD + "-" + vMon + "-" + vY4;
			break;
		case "DD-MON-YY" :
			vData = vDD + "-" + vMon + "-" + vY2;
			break;
		case "DD\/MONTH\/YYYY" :
			vData = vDD + "\/" + vFMon + "\/" + vY4;
			break;
		case "DD\/MONTH\/YY" :
			vData = vDD + "\/" + vFMon + "\/" + vY2;
			break;
		case "DD-MONTH-YYYY" :
			vData = vDD + "-" + vFMon + "-" + vY4;
			break;
		case "DD-MONTH-YY" :
			vData = vDD + "-" + vFMon + "-" + vY2;
			break;
		case "DD\/MM\/YYYY" :
			vData = vDD + "\/" + vMonth + "\/" + vY4;
			break;
		case "DD\/MM\/YY" :
			vData = vDD + "\/" + vMonth + "\/" + vY2;
			break;
		case "DD-MM-YYYY" :
			vData = vDD + "-" + vMonth + "-" + vY4;
			break;
		case "DD-MM-YY" :
			vData = vDD + "-" + vMonth + "-" + vY2;
			break;
		case "MONTH DD, YYYY":
			vData = vFullMon + " " + vDD + ", " + vY4;
			break;
		default :
			vData = vDD + "." + vMonth + "." + vY4;
	} // switch
	return vData;
}

function Build(p_item, p_item2, p_day, p_month, p_year, p_format, p_submit) {
	var p_WinCal = ggWinCal;
	gCal = new Calendar(p_item, p_item2, p_WinCal,p_day,  p_month, p_year, p_format, p_submit);
	gCal.show();
}

/** include the calendar inside a page */
function includeCalendar(pSpanID,pBaseLink,dy,mo,yr) {
	gCal = new Calendar(null,null,null,dy,mo,yr,'',true);
	gCal.mCalendarSpan = pSpanID;
	gCal.mBaseLink = pBaseLink;
	document.getElementById(pSpanID).innerHTML = gCal.getMonthlyCalendarCode();
}

function show_calendar() {
	/* 
		p_month : 0-11 for Jan-Dec; 12 for All Months.
		p_year	: 4-digit year
		p_format: Date format (mm/dd/yyyy, dd/mm/yy, ...)
		p_item	: Return Item.
	*/
	
	
	p_item = arguments[0];
	p_item2 = arguments[1];

	if (arguments[2] == null)
		p_submit = 0;
	else
	   p_submit = 1;
	if (arguments[3] == null)
		p_month = new String(gNow.getMonth());
	else
		p_month = arguments[2];
	if (arguments[4] == "" || arguments[3] == null)
		p_year = new String(gNow.getFullYear().toString());
	else
		p_year = arguments[3];
	if (arguments[5] == null)
		p_format = "MONTH DD, YYYY";
	else
		p_format = arguments[4];

	vWinCal = window.open("","Calendar","width=250,height=200,status=no,resizable=no,top=200,left=200");
	vWinCal.opener = self;
	ggWinCal = vWinCal;
	
	myElem = document.getElementById(p_item);
	if (myElem.value == "")
		dt = new Date();
	else
		dt = new Date(myElem.value);

	p_day = new String(dt.getDate());
	p_month = new String(dt.getMonth());
	p_year = new String(dt.getFullYear().toString());
	Build(p_item, p_item2, p_day, p_month, p_year, p_format, p_submit);
}