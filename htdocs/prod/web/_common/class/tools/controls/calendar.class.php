<?php   
/** CCalendar
* @package mbaa
* @author cgrecu
*/


class CCalendar extends CDBObject {
//  var $mMonths = array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec");
//  var $mMonthsFull = array("January","February","March","April","May","June","July","August","September","October","November","December");
 //var $mMonthsDays =  array(31,28,31,30,31,30,31,31,30,31,30,31);
  var $mWeekDaysFull =  array("Monday", "Tuesday", "Wednesday", "Thursday", "Friday", "Saturday", "Sunday");
  var $mWeekDays =  array("Mon", "Tue", "Wed", "Thu", "Fri", "Sat", "Sun");
  var $mTime;
  var $mYear;
  var $mMonth;
  var $mDay;
  var $mWeekDay;
  var $mDays;
  var $mEvents;	//array TimeStamp=> (ID,Title,Description,Url)
  //var $mBisect = 0;

  /** comment here */
  function CCalendar($pTimeStamp = 0) {
	$this->CDBObject();  	
	if (!$pTimeStamp) $pTimeStamp = time();
	$this->mTime = $pTimeStamp;
	$this->parseDate();
	$this->mEvents = array();
  }

  /** comment here */
  function display() {

	$start = max($this->mWeekDay,0);
	$starttime = $this->mFirstDay;
	//$this->getEvents();
	for($i=0; $i<$start; $i++) {
	  $data[0][$i] = "&nbsp;";
	}
	$week = 0;
//	$style0 = "background-color: #54d109;";
//	$style1 = "background-image: url(images/scheduler/top.gif); background-repeat: no-repeat; color: #ff9933; ";
//	$style2 = "background-image: url(images/scheduler/bottom.gif); background-repeat: no-repeat; color: #ff9933; ";
//	$style3 = "background-color: #eeeeee; text-decoration: line-through;  color: #ff9933;";
	$class1 = "inactive";
	$class2 = "active";
	$this->getEvents();
	for($i=1; $i<=$this->mDays; $i++) {
//	  $styleName = "style".intval($this->mEvents[$i]);
	  if (isset($this->mEvents[$i])) $class = $class2; else $class = $class1;
	  $href = new CHref("#self", $i);
	  if (isset($this->mEvents[$i])) $href->setJavaScript("onclick", "changeDate('".$this->mEvents[$i]."');");
	  else $href->setJavaScript("onclick", "alert('You cannot schedule an appointment for this date!');");
	  $href->mClass = $class;
	  $today = "<div class=\"$class\" style=\" \">".$href->display()."</div>";
//	  $today = "$i";
	  $data[$week][$start] = $today;
	  $start = ($start + 1) % 7;
	  if (!$start) $week ++;
	  $starttime += 86400;
	}
	for($i=$start; $i<7; $i++) {
	  $data[$week][$i] = "&nbsp;";
	}


//	echo count($data);die; 
	if ($week < 5) {
	  for($i=0; $i<7; $i++) {
		$data[5][$i] = "&nbsp;";
	  }
	}
	$vTable = new CGridTable($data);		
	$vTable->mCellSpacing = 4;
	$vTable->mWidth = 242;
	$vTable->mHeight = 174;
	$vTable->mID = "calender";	

	$rows = array($this->mWeekDays);
	$vHead = new CGridTable($rows);
	$vHead->mCellSpacing = 4;
	$vHead->mWidth = 242;
	$vHead->mHeight = 174;
	$vHead->mID = "calday";
	Return $vHead->display(). $vTable->display();
  }

  /** comment here */
  function parseDate() {

	$this->mYear = date("Y", $this->mTime);
	$this->mDay = date("d", $this->mTime);
	$this->mMonth = date("m", $this->mTime);
	$this->mFirstDay = strtotime("1 " . date("F Y", $this->mTime));
	$this->mWeekDay = date("w", $this->mFirstDay)-1;
	$this->mDays = date("t", $this->mTime);
  }

  /** comment here */
  function setEvents($pEvents) {
	//if ($pEvents) die2($pEvents);
  	$this->mEvents = $pEvents;
  }

  /** comment here */
  function getEvents() {
	$data = $this->mDatabase->getAll("select ID, Day, TimeStamp from booking_dates where Year = '".$this->mYear."' and Month = '".$this->mMonth."'");
	foreach ($data as $key=>$val) {
	  $this->mEvents[$val["Day"]] = $val["ID"];
	}
  }

  /** comment here */
  function displayNavigation() {
	$vDate = date("M Y", $this->mTime);
//	$month = date("m", $this->mTime);
//	$year = date("Y", $this->mTime);
//  

//	$vPrevYear = strtotime("-1 year", $this->mTime);//$this->mTime - 365 * 86400;
//	$vNextYear = strtotime("+1 year", $this->mTime);//$this->mTime + 365 * 86400;
//	$vPrevMonth = strtotime("-1 month", $this->mTime);//$this->mTime - 31 * 86400;
//	$vNextMonth = strtotime("+1 month", $this->mTime);//$this->mTime + 31 * 86400;
//	$img = new CImage("images/common/small/media_rewind.png");
//	$img->mVAlign = "center";
// 	$vPrevYear = new CHref($this->getBaseLink("Owners") . "schedule&propid=".$this->mPropertyID."&id=" . $vPrevYear, "<nobr>".$img->display() ."&nbsp;</nobr>");
// 	$vPrevYear->mClass = "link_job";
//	$rows[] = $vPrevYear->display();
//	$img = new CImage("images/common/small/media_back.png");
//	$vPrevMonth = new CHref($this->getBaseLink("Owners") . "schedule&propid=".$this->mPropertyID."&id=" . $vPrevMonth, $img->display());
//	$vPrevMonth->mClass = "link_job";
//	$rows[] = $vPrevMonth->display();
	$rows[] = $vDate;

//	$img = new CImage("images/common/small/media_play.png");
//	$vNextMonth = new CHref($this->getBaseLink("Owners") . "schedule&propid=".$this->mPropertyID."&id=" . $vNextMonth, $img->display());
//	$rows[] = $vNextMonth->display();
//
//	$img = new CImage("images/common/small/media_fast_forward.png");
//	$vNextYear = new CHref($this->getBaseLink("Owners") . "schedule&propid=".$this->mPropertyID."&id=" . $vNextYear, $img->display());
//	$rows[] = $vNextYear->display();
//	$rows = array();
	$vTable = new CGridTable(array($rows));
	$vTable->mTemplates["table"]["width"] = "148px";
	$vTable->mTemplates["table"]["margin"] = "0px 0px 1px 0px";
	$vTable->mTemplates['table']['border'] = '1px solid #eee';

	$vTable->mTemplates["breaker"]["font-weight"] = "bold";
	$vTable->mTemplates["breaker"]["font-size"] = "11px";
	$vTable->mTemplates["breaker"]["font-family"] = "tahoma";
	$vTable->mTemplates["breaker"]["padding"] = "2px 1px";
	$vTable->mTemplates["breaker"]["color"] = "#666";
	$vTable->mTemplates["breaker"]["background-color"] = "#f6f6f6";
	$vTable->mTemplates["breaker"]["text-align"] = "center";
//	$vTable->setColsWidths(array("45px", "45px", "117px", "45px", "45px"));
//	$vTable->setColsAligns(array("left", "left", "center", "right", "right"));
	Return "<center>" . $vTable->display() . "<center>";
  }
}

?>