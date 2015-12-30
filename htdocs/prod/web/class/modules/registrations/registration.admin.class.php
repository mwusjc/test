<?php
/** CSurveyAdmin
* @package surveys
* @author cgrecu
*/


class CRegistrationAdmin extends CSectionAdmin{

  /** comment here */
  function CRegistrationAdmin() {
        $this->CSectionAdmin();
  }

  /** comment here */
  function registerClasses() {
  }

  /** comment here */
  function display() {
        $this->enforceRight("view_contact");
        $this->mDatabase->query("set names utf8");

        $sql = "SELECT * from contacts a ".
                        " WHERE 1=1  ";
        $sql .= " ##CRITERIA## ";

        $vSmart = new CSmartTable("users", $sql);
        $vSmart->mShowToggle = false;
        $vSmart->mItemsPerPage = 20;
        $vSmart->setIcons(array("edit", "view", "print", "delete"));
        $vSmart->mIconManager->mIcons["view"][2] = "View User Info";

        $vSmart->addHeader(array("First Name|true", "Last Name|true", "Email|true", "Date Signed|true"));
        $vSmart->addField("FirstName");
        $vSmart->addField("LastName");
        $vSmart->addField("Email");
        $vSmart->addDField("TimeStamp", "m/d/Y");

        $vSmart->addCompositeFilter("Name", "a.FirstName, a.LastName, a.Email", "Search", 1);
        $vSmart->addRFilter("a.TimeStamp", "Registration date between", "and", 1, "date");

        $vSmart->mShowSaveButton  = true;


        $vSmart->addExtraActions(new CHref($this->getBaseLink() . "create", "Add user"));

//        $url = $this->mDocument->mUrlObj->getURL() . "&o=export&type=pdf";
//        $vSmart->addExtraActions(new CHref($url, "Export to <b>Adobe PDF</b>(standard)"));

        $url = $this->mDocument->mUrlObj->getURL() . "&o=export&type=excel";
//        $vSmart->addExtraActions(new CHref($url, "Export to <b>Excel</b>"));

//        $url = $this->mDocument->mUrlObj->getURL() . "&o=export&type=all";
//        $vSmart->addExtraActions(new CHref($url, "Export to <b>Excel</b>(full)"));

        $url = $this->mDocument->mUrlObj->getURL() . "&o=print2";
//        $vSmart->addExtraActions(new CHref($url, "Print <b>current resultset</b>"));

        $vSmart->mColsWidths = array("23px", "130px", "120px", "180px", "90px", "70px");
        $vSmart->mColsAligns = array("left", "left", "left", "left", "left", "right");
        $vSmart->setTemplate("admin");
        Return $this->displayError() . $vSmart->display();
  }

  /** comment here */
  function displayEdit($pItemID = 0) {
          if ($pItemID) $this->enforceRight("edit_contact"); else $this->enforceRight("create_contact");
//          die2($this->mUserObj->mRights);
//          $this->enforceRight("edit_contacts");
        $label = "Users ::: ";
        if ($pItemID) $label .= "Edit user"; else $label .= "Create new user";
        $vUser = new CRegistration($pItemID);
        $vUser->unregisterForm();
        $vUser->displayEdit();
        Return $this->flushTemplate();
  }

  /** comment here */
  function displaySave($pItemID) {
    $this->enforceRight("edit_contact");
        $vUser = new CRegistration($pItemID);
        $vUser->save();
        $this->redirect($this->getStdLink());
  }


  /** comment here */
  function delete($pUserID) {
          $this->enforceRight("delete_contact");
          $vUser = new CRegistration($pUserID);
          $vUser->delete();
          $this->redirect($this->getBaseLink() . "main&id=$pID");
        }


/***********************************************************************************************************
****          END OF TEMPLATE FUNCTIONS - CONTINUE WITH SPECIAL FUNCTIONS                                                                        ****
***********************************************************************************************************/

  /** comment here */
  function run() {

                $this->enforceRight("export_contact");
                $sql = "SELECT Id, TimeStamp, FirstName, LastName, Email, PostCode from contacts a ".
                        " WHERE 1=1  ".
                        " ##CRITERIA## ";
                if ($_GET['type'] == "all")        $sql = "SELECT * from contacts a ".
                                                                                                        " WHERE 1=1  ".
                                                                                                        " ##CRITERIA## ";
                //        if ($this->mUserObj->mRowObj->GroupID > 1) $sql .= " AND a.GroupID > 1 ";
                //        $sql .= " ORDER BY a.OrigDate DESC";

                $vSmart = new CSmartTable("users", $sql);
                $vSmart->mStatusOn = 'active';
                $vSmart->mItemsPerPage = 20;
                $vSmart->setIcons(array("edit", "delete"));
                $vSmart->mIconManager->mIcons["view"][2] = "View User Info";

                $vSmart->addHeader(array("First Name|true", "Last Name|true", "Email|true", "City|true", "Date Signed|true"));
                $vSmart->addField("FirstName");
                $vSmart->addField("LastName");
                $vSmart->addField("Email");

                $vSmart->addCompositeFilter("Name", "a.FirstName, a.LastName, a.Email", "Search", 1);
                $vSmart->addRFilter("a.TimeStamp", "Registration date between", "and", 2, "date");

                $vSmart->display();
                $sql = $vSmart->mSql;
                $items = $this->mDatabase->getAllTrue($sql);

                if($_GET['type'] == "excel" || $_GET['type'] == "all")
                        $this->export_to_excel($items);
                elseif($_GET['type'] == "pdf")
                        $this->export_to_pdf($items);
                else
                        return "Operation not found!";
  }

  //******************** Export current page to Excel *****************************
   function export_to_excel(&$items) {

                require_once("_common/" . "/class/libs/excel/xml2excel.class.php");

                $xls = new CXML2Excel("contacts.xml");
                $xls->setDefaultStyle('<Font x:Family="Swiss" ss:Color="#333333" ss:Size="10" ss:FontName="Verdana"/><Alignment ss:Vertical="Bottom" ss:Horizontal="Left"/>');
                $xls->addStyle('<Alignment ss:Horizontal="Center"/>', 21);
                $xls->addStyle('<Font ss:Bold="1" ss:Color="#000000" ss:Size="10" x:Family="Swiss" ss:FontName="Verdana"/>', 22);
                $xls->addStyle('<Font ss:Color="#aaaaaa" ss:Size="10" x:Family="Swiss" ss:FontName="Verdana"/>', 23);
                $xls->addWorksheet("Report Results", "s23");
                $widths = array();$lookupFields = array();

                $i = 0;
                foreach ($items[0] as $key=>$val) {
                        if (strpos($key, "Time")  || strpos($key, "Date")  || strpos($key, "Stamp") ) $lookupFields[$i] = "date";
                        $i++;
                }
                foreach ($items as $key=>$val) {
                        $row = array();
                        $i = 0;
                        foreach ($val as $key2=>$val2) {
                                if ($lookupFields[$i] == "date") $row[] = date("F d, Y", $val2)        ; else $row[] = addslashes($val2);
                                if (!$key) $header[] = addslashes($key2);
                                if (!$key && $lookupFields[$i] == "date") $widths[$i] = 20;
                                else $widths[$i] = strlen($header[$i]);
                                if ($lookupFields[$i] != "date") $widths[$i] = max($widths[$i], strlen($val2));
                                $i ++;
                        }
                        if (!$key) $xls->addRow($header, 22);
                        $xls->addRow($row);
                }

                for($i=0; $i<count($items[0]); $i++) {
                        $xls->addColumn($i+1, array("AutoFitWidth"=>1, "Width"=> floor(7 * $widths[$i])));
                }

        $txt = $xls->display();
        header("Content-type: application/vnd.ms-excel");
        header('Content-Disposition: attachment; filename="'.uniqid("").'.xml"');
       die($txt);
   }


 //******************** creates Adobe Acrobat pdf of the current page  ***************************
function export_to_pdf(&$items) {
        $CellH = 8;
        ob_end_clean();

        $pdf=new FPDF('L','mm', 'A4');
        $pdf->AddPage();
        $pdf->SetFont('Arial','B',9);
        $pdf->SetMargins(2, 0);
        $pdf->Ln();

        $max_width = array();
        foreach ($items as $cur => $value) {
           $i = 0;
           if(strlen($items[$cur]['FirstName']) > $max_width['FirstName']) $max_width['FirstName'] = strlen($items[$cur]['FirstName']);
           if(strlen($items[$cur]['LastName']) > $max_width['LastName']) $max_width['LastName'] = strlen($items[$cur]['LastName']);
           if(strlen($items[$cur]['Email']) > $max_width['Email']) $max_width['Email'] = strlen($items[$cur]['Email']);
           if(strlen($items[$cur]['Address']) > $max_width['Address']) $max_width['Address'] = strlen($items[$cur]['Address']);
           if(strlen($items[$cur]['City']) > $max_width['City']) $max_width['City'] = strlen($items[$cur]['City']);
           if(strlen($items[$cur]['DayPhone']) > $max_width['DayPhone']) $max_width['DayPhone'] = strlen($items[$cur]['DayPhone']);
           if(strlen($items[$cur]['EveningPhone']) > $max_width['EveningPhone']) $max_width['EveningPhone'] = strlen($items[$cur]['EveningPhone']);
           if(strlen($items[$cur]['Province']) > $max_width['Province']) $max_width['Province'] = strlen($items[$cur]['Province']);
           if(strlen($items[$cur]['PostCode']) > $max_width['PostCode']) $max_width['PostCode'] = strlen($items[$cur]['PostCode']);
        }

        $coef = 1.4;
        $MAX_WIDTH = 50;
        $MIN_WIDTH = 27;
        foreach($max_width as $k => $value) {
                $max_width[$k] *= $coef;
                if($max_width[$k] > $MAX_WIDTH) $max_width[$k] = $MAX_WIDTH;
                if($max_width[$k] < $MIN_WIDTH) $max_width[$k] = $MIN_WIDTH;
        }
 /*
        foreach ($items as $cur => $value)  {
                if(strlen($items[$cur]['Email']) > 10) {
                        $temp_top = array_slice($items, 0, $cur+1);
                        $temp_mid = array (
                                $cur+1 => array("FirstName"=>"a",
                                                "LastName" => "a",
                                                "Email" => substr($items[$cur]['Email'], 10),
                                                "Address" => "a",
                                                "City" => "a",
                                                "DayPhone" => "a",
                                                "EveningPhone" => "a",
                                                "Province" => "a",
                                                "PostCode"  => "a"
                                                )
                        );
                        $temp_bot = array_slice($items, $cur+1, count($items));
                        $items = array_merge($temp_top, $temp_mid);
                        $items = array_merge($items, $temp_bot);
//                        die2($items);
                }
        }
*/
        $pdf->SetFillColor(0, 0, 0);
        $pdf->SetFont('Arial','',8);
        $CurrentNumber = 1;
        $j = 1;
        foreach ($items as $cur => $value) {
           $pdf->Cell(1, $CellH, "", 1, 0, C, 0);
           if($pdf->PageNo() != $CurrentPage) {
                 $pdf->SetFillColor(255, 255, 204);
                 $pdf->SetFont('Arial','B',9);
                 $pdf->Cell(7, $CellH, "#", 1, 0, C, 0);
                 $pdf->Cell($max_width['FirstName'], $CellH, "First Name", 1, 0, C, 1);
                 $pdf->Cell($max_width['LastName'], $CellH, "Last Name", 1, 0, C, 1);
                 $pdf->Cell($max_width['Email'], $CellH, "Email", 1, 0, C, 1);
                 $pdf->Cell($max_width['Address'], $CellH, "Address", 1, 0, C, 1);
                 $pdf->Cell($max_width['DayPhone'], $CellH, "Phone", 1, 0, C, 1);
                 $pdf->Cell($max_width['EveningPhone'], $CellH, "Evening Phone", 1, 0, C, 1);
                 $pdf->Cell($max_width['City'], $CellH, "City", 1, 0, C, 1);
                 $pdf->Cell($max_width['Province'], $CellH, "Province", 1, 0, C, 1);
                 $pdf->Cell($max_width['PostCode'], $CellH, "Post Code", 1, 0, C, 1);
                 $pdf->Ln();
                 $pdf->Cell(1, $CellH, "", 1, 0, C, 0);
                 $CurrentPage = $pdf->PageNo();
                 $pdf->SetFont('Arial','',8);
           }

           if($cur % 2)  $pdf->SetFillColor(230, 230, 230);
           else $pdf->SetFillColor(255, 255, 255);
           $pdf->Cell(7, $CellH, $j++, 1, 0, C, 0);
           $pdf->Cell($max_width['FirstName'], $CellH, $items[$cur]['FirstName'], 1, 0, C, 1);
           $pdf->Cell($max_width['LastName'], $CellH, $items[$cur]['LastName'], 1, 0, C, 1);
           $pdf->Cell($max_width['Email'], $CellH, $items[$cur]['Email'], 1, 0, C, 1);
           $pdf->Cell($max_width['Address'], $CellH, $items[$cur]['Address'], 1, 0, C, 1);
           $pdf->Cell($max_width['DayPhone'], $CellH, $items[$cur]['DayPhone'], 1, 0, C, 1);
           $pdf->Cell($max_width['EveningPhone'], $CellH, $items[$cur]['EveningPhone'], 1, 0, C, 1);
           $pdf->Cell($max_width['City'], $CellH, $items[$cur]['City'], 1, 0, C, 1);
           $pdf->Cell($max_width['Province'], $CellH, $items[$cur]['Province'], 1, 0, C, 1);
           $pdf->Cell($max_width['PostCode'], $CellH, $items[$cur]['PostCode'], 1, 0, C, 1);
           $pdf->Ln();
       }



        $pdf->Output();
        die();
}
//*************************************************************************************************


  /** comment here */
function export() {
        $this->enforceRight("export_contact");
        $sql = "SELECT Id, TimeStamp, FirstName, LastName, Email, Address, DayPhone, City, Province from contacts a ".
                        " WHERE 1=1  ".
                        " ##CRITERIA## ";
//        if ($this->mUserObj->mRowObj->GroupID > 1) $sql .= " AND a.GroupID > 1 ";
//        $sql .= " ORDER BY a.OrigDate DESC";

        $vSmart = new CSmartTable("users", $sql);
        $vSmart->mStatusOn = 'active';
        $vSmart->mItemsPerPage = 20;
        $vSmart->setIcons(array("edit", "delete"));
        $vSmart->mIconManager->mIcons["view"][2] = "View User Info";
//        $vSmart->mIconManager->mIcons["on"][2] = "Active C";
//        $vSmart->mIconManager->mIcons["off"][2] = "Suspended User";

        $vSmart->addHeader(array("First Name|true", "Last Name|true", "Email|true", "City|true", "Date Signed|true"));
        $vSmart->addField("FirstName");
        $vSmart->addField("LastName");
        $vSmart->addField("Email");
        $vSmart->addField("City");
        $vSmart->addField("OrigDate");

        $vSmart->addCompositeFilter("Name", "a.FirstName, a.LastName, a.Email", "Search", 1);
        $vSmart->addTFilter("a.City", "City", 1);
        $vSmart->addINFilter("a.ID", "Filter by community interest", $this->mDatabase->getAll2("select id, name from communities order by 2 asc"),2);
        $vSmart->addRFilter("a.TimeStamp", "Registration date between", "and", 2, "date");

        $vSmart->display();
        $sql = $vSmart->mSql;
        $data = $this->mDatabase->getAll($sql);
        $txt = "";
        foreach ($data as $key=>$val) {
                if (!$key) {
                        $fields = array();
                        foreach ($val as $key2=>$val2) {
                                $fields[] = str_replace('"', '""', $key2);
                        }
                        $txt .= implode("\t", $fields) . "\n";
                }
                $fields = array();
                foreach ($val as $key2=>$val2) {
                        if (strpos($key2, "imeStamp")) $val2 = date("m/d/Y", $val2);
                        $fields[] = str_replace('"', '""', $val2);
                }
//                $txt .= '"'.implode('","', $fields) . '"'."\n";
                $txt .= implode("\t", $fields) . "\n";
        }
        header("Content-Transfer-Encoding: text");
        header("Content-type: application/vnd.ms-excel");

        header('Content-Disposition: attachment; filename="contacts_'.date("ymdhi").'.xls"');
        header("Cache-Control: max-age=10");
        die($txt);
}



/** comment here */
function displayItem($pID) {
        $this->enforceRight("view_contact");
        $vContact = new CRegistration($pID);
        $prev = $this->mDatabase->getValue("contacts a","max(a.ID)", " a.ID < '$pID' ".$_SESSION["gAdminCriteria"]);
        if ($prev) {
                $prev = new CHref($this->getBaseLink(). "view&id=$prev", "<img src=\"http://wms.thebrandfactory.com/images/common/large/media_rewind.png\">");
                $prev = $prev->display();
        } else $prev = "&nbsp;";

        $next = $this->mDatabase->getValue("contacts a","min(ID)", " a.ID > '$pID' ".$_SESSION["gAdminCriteria"]);

        if ($next) {
                $next = new CHref($this->getBaseLink(). "view&id=$next", "<img src=\"http://wms.thebrandfactory.com/images/common/large/media_fast_forward.png\">");
                $next->setClass("nav");
                $next = $next->display();
        } else $next = "&nbsp;";

        $center = new CHref($this->getBaseLink(). "main", "<img src=\"http://wms.thebrandfactory.com/images/common/large/undo.png\">");
        $center->setClass("nav");
        $center = $center->display();

        $rows = array(array($prev, $center, $next));
        $table = new CGrid($rows);
        $table->setTemplate("simple");
        $table->setColsAligns(array("left", "center", "right"));
        $table->setColsWidths(array("25%", "50%", "25%"));
        Return $table->display() . $vContact->display();
}

/** comment here */
function displayPrint($pID = 0) {
        $this->enforceRight("export_contact");
        $this->mDocument->mPageTemplate = "_common/templates/print.html";
        if ($pID) {
                $vContact = new CRegistration($pID);
                Return $vContact->display();
        } else {
                $sql = "select * from contacts a where 1=1 ".$_SESSION["gAdminCriteria"];
                $data =$this->mDatabase->getAll($sql);
                $vContact = new CRegistration(0);
                foreach ($data as $key=>$val) {
                        $vContact->reload($val);
                        $txt .= $vContact->display();
                }
                Return $txt;
        }
}

/** comment here */
function displayEmail($pID = 0, $pListID = 0) {
        $this->enforceRight("email_list");
        $this->resetTemplate("_common/" . "templates/contacts/email.html");
        $form = new CForm("frmEdit", $this->getBaseLink(). "doemail&id=$pID&lid=$pListID");

        $vList = new CList($pListID);
        if ($vList->mRowObj->Query) {
                $sql = "select xx.email from (" . $vList->mRowObj->Query . ") xx";
//                die($sql);
        } else {
                if ($pID) $sql = "select email from contacts where id = '".addslashes($pID)."' and subscribed = 'yes' and email <> ''";
                else {
                        $sql = "select email from contacts a where 1=1 and subscribed = 'yes' and email <> '' ".$_SESSION["gAdminCriteria"];
                }
        }
        $data  = $this->mDatabase->getAll($sql);
        $emails = implode("; ", $data);

        $input = new CTextInput("FromName", "");
        $input->setClass("size400");
        $form->addElement($input);

        $input = new CTextInput("FromAddress", "");
        $input->setClass("size400");
        $form->addElement($input);

        $input = new CTextArea("To", $emails, 4, 60);
        $input->mEnabled = "disabled";
        $form->addElement($input);

        $this->mDocument->mHead->addScript(new CScript("", "http://wms.thebrandfactory.com/scripts/newsletter.js"));
        $input = new CComboBox("TemplateID", "masterDB.cms_newsletters", "ID", "Subject", "", "where AccountID = '".INI_ACCT_ID . "' and status = 'enabled' and (userid = '".$this->mUserID."' or Shared = 'yes')");
        $input->setExtraOption(array("", " -- select newsletter -- "));
        $input->setJavaScript("onchange", "if (this.value) getNewsletter(this.value);");
        $form->addElement($input);

        $input = new CTextInput("Subject", "");
        $input->setClass("size400");
        $form->addElement($input);

//        $input = new CTextArea("Message", "", 27, 60);
//        $form->addElement($input);


        $form->display();
        Return $form->flushTemplate();
}

/** comment here */
function email($pID, $pListID) {
        $this->enforceRight("email_list");
        $vList = new CList($pListID);
        if ($vList->mRowObj->Query) {
                $sql = $vList->mRowObj->Query;
        } else {
                if ($pID) $sql = "select ID, Email from contacts where email <> '' and subscribed = 'yes' and id = '".addslashes($pID)."'";
                if ($pListID) {
                        if (!array_key_exists("gAdminCriteria", $_SESSION)) die("session expired");
                        $sql = "select ID, Email from contacts a where 1=1 and subscribed = 'yes' and email <> '' ".$_SESSION["gAdminCriteria"];
                }
        }
//        die($sql);
        $vEdm = new CEDM();
        $vEdm->registerForm();
        $vEdm->mRowObj->EmailID = $_POST["TemplateID"];
        $vEdm->mRowObj->AccountID = INI_ACCT_ID;
        $vEdm->mRowObj->ListID = $pListID;
        $vEdm->mRowObj->TimeStamp  = time();
        $vEdm->mRowObj->QueryString  = $sql;
        $vEdm->send();
        $this->redirect($this->getBaseLink()  ."email_results&id=". $vEdm->mRowObj->ID);

        die;
}

        /** comment here */
        function displayEmailResults($id) {
                $this->enforceRight("email_list");
                $vEdm = new CEDM($id);
                $ok = $vEdm->mRowObj->SentOk;
                $notok = $vEdm->mRowObj->Sent - $vEdm->mRowObj->SentOk;
                $center = new CHref($this->getBaseLink("Lists"). "main", "<img src=\"http://wms.thebrandfactory.com/images/common/large/undo.png\">");
                $center->setClass("nav");
                $txt = "<p>".$center->display()."</p>";

                $txt .= "<p>EDM was dispatched to ".($ok + $notok)." email addresses</p>";
                $txt .= "<p>Successfully sent to: <span style='color:#33cc33;'>$ok</span> addresses";
                $txt .= "<br>Unsuccessfully sent to: <span style='color:#ff0000;'>$notok</span> addresses</p>";
                Return $txt;
        }

//        /** comment here */
//        function displaySaveSearch($pSection) {
//                $this->enforceRight("create_list");
//                $this->resetTemplate("_common/" . "templates/smart/save.html");
//                $vForm = new CForm("frmEdit", $this->getBaseLink() . "dosave_search&section=$pSection");
//                $input = new CTextInput("Name");
//                $input->setClass("size300");
//                $vForm->addElement($input);
//                $input = new CTextArea("Description", "", 4, 60);
//                $input->setClass("size300");
//                $vForm->addElement($input);
//                $vForm->display();
//                Return $this->flushTemplate();;
//        }
//
//        /** comment here */
//        function saveSearch() {
//                $this->enforceRight("create_list");
//                $obj = new CContent("cms_saved_searches", 0);
//                $obj->registerForm();
//                $obj->mRowObj->TimeStamp  = time();
//                $obj->mRowObj->UserID = $this->mUserID;
//                $obj->mRowObj->Section = $pSection;
//                $obj->easySave();
//                $this->redirect();
//        }

        /** comment here */
        function displayMassImport() {
                $this->enforceRight("edit_contact");

//                $sql = "select * from contacts where id >= 1294";
//                $data  = $this->mDatabase->getAll($sql);
//                $slots = $this->mDatabase->getAll("select * from booking_timeslots where bookings < 45 order by DateID ASC, SlotID ASC");
//                $start = 0;
//                foreach ($data as $key=>$val) {
//                        $slot = $slots[floor($start/6)]["ID"];
//                        $sql = "insert into bookings(UserID, TimeSlotID) values('".$val["ID"]."','".$slot."')";
//                        $this->mDatabase->query($sql);
//                        $start ++;
//                }
//                die('ok');

                $this->resetTemplate("_common/" . "templates/contacts/import.html");
                $form = new CForm("frmEdit", $this->getBaseLink(). "doimport");

                $input = new CComboBox("CommunityID", "communities", "ID", "Name");
                $input->setClass("size400");
                $form->addElement($input);

                $input = new CTextArea("CSV", "", 24, 60);
                $input->setClass("size400");
                $form->addElement($input);

                $input = new CCheckbox("Subscribe", "");
                $input->setValues("yes", "no");
                $input->setLabel(" auto-subscribe users");
                $form->addElement($input);

                $input = new CCheckbox("WithHeaders", "");
                $input->setValues("yes", "no");
                $input->setLabel(" first row indicates the column names");
                $form->addElement($input);

                $form->display();
                Return $form->flushTemplate();
        }

        /** comment here */
        function massImport() {
                $this->enforceRight("edit_contact");
                $emails = explode("\n", $_POST["CSV"]);
                if ($_POST["WithHeaders"] != "yes") {
                        foreach ($emails as $key=>$val) {
                                $email = trim($val);
                                if (!$email) continue;
                                $check = $this->mDatabase->getValue("contacts", "ID", "Email = '".$email."'");

                                if (!$check) {
                                        $sql = "insert into contacts(CommunityID, Email, Subscribed, TimeStamp) values('".$_POST["CommunityID"]."','$email','".$_POST["Subscribe"]."', unix_timestamp())";
                                        $this->mDatabase->query($sql);
                                        $check = $this->mDatabase->getLastID();
                                }
                                $check2 = $this->mDatabase->getValue("contact_homes", "count(*)", "ContactID = '$check' and TypeID = '".$_POST["CommunityID"]."'");
                                echo $email . " = " . $check2 . "<br>";
                                if (!$check2) {
                                        $sql = "insert into contact_homes(TypeID, ContactID) values('".$_POST["CommunityID"]."',".$check.")";
                                        $this->mDatabase->query($sql);
                                }
                        }
                } else {
                        $names = array();
                        foreach ($emails as $key=>$val) {
                                if (!$key) {
                                        $names = explode("\t", $val);
                                        continue;
                                }
                                $line = explode("\t", $val);
                                $fields = array();
                                foreach ($names as $key2=>$val2) {
                                        if ($val2) $fields[trim($val2)] = trim($line[$key2]);
                                }
                                $email = trim($fields["Email"]);
                                $fname = trim($fields["FirstName"]);
                                $lname = trim($fields["LastName"]);

                                if ($email)
                                        $check = $this->mDatabase->getValue("contacts", "ID", "Email = '".$email."'");
                                else {
                                        if ($fname && $lname) {
                                                $check = $this->mDatabase->getValue("contacts", "ID", "FirstName = '".addslashes($fname)."' and LastName = '".addslashes($lname)."'");
                                        } else continue;
                                }


                                if (!$check) {
                                        $sql = "insert into contacts" . $this->mDatabase->makeInsertQuery($fields);
                                        $this->mDatabase->query($sql);
                                        $check = $this->mDatabase->getLastID();
                                }
                                $check2 = $this->mDatabase->getValue("contact_homes", "count(*)", "ContactID = '$check' and TypeID = '".$_POST["CommunityID"]."'");

                                if (!$check2) {
                                        $sql = "insert into contact_homes(TypeID, ContactID) values('".$_POST["CommunityID"]."',".$check.")";
                                        $this->mDatabase->query($sql);
                                }
                        }
                }
                die('<hr>end');
                $this->redirect();
        }

        /** comment here */
        function ajaxNewsletterContent($id) {
                $vEmail  = new CEmail($id);
                $txt = '<htmlver>'.xmlentities($vEmail->mRowObj->HtmlVersion).'</htmlver>';
                $txt .= '<txtver>'.xmlentities(nl2br($vEmail->mRowObj->TxtVersion)).'</txtver>';
                $txt .= '<fromname>'.xmlentities(nl2br($vEmail->mRowObj->FromName)).'</fromname>';
                $txt .= '<fromaddress>'.xmlentities(nl2br($vEmail->mRowObj->FromAddress)).'</fromaddress>';
                $txt .= '<subject>'.xmlentities(nl2br($vEmail->mRowObj->Subject)).'</subject>';
                xml($txt);
        }

  /** comment here */
  function mainSwitch() {
        switch($this->mOperation) {
          case "export":
                Return $this->run();
          case "print":
                  Return $this->run();
          case "print2":
                  Return $this->displayPrint();
          case "email":
                  Return $this->displayEmail($_GET["id"], $_GET["lid"]);
          case "doemail":
                  Return $this->email($_GET["id"], $_GET["lid"]);
          case "email_results":
                  Return $this->displayEmailResults($_GET["id"]);
          case "save_search":
                  Return $this->displaySaveSearch($_GET["type"]);
          case "dosave_search":
                  Return $this->saveSearch();
          case "load_search":
                Return $this->displayLoadSearch();
          case "ajax_get_newsletter":
                  Return $this->ajaxNewsletterContent($_GET["id"]);
          case "import":
                  Return $this->displayMassImport();
          case "doimport":
                Return $this->massImport();
          case "bounces":
                  $vMailer = new CMailer();
          ini_set("display_errors", 1        );
                  $vMailer->parseBounces();
                  die('ok');
          default:
                  Return CSectionAdmin::mainSwitch();
        }
  }
}

?>