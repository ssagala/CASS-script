<?php include('Connections/conn.php'); /*error_reporting(0); */
// Set a higher execution time limit
set_time_limit(300);

// Define batch size
//$batchSize = 100;
ini_set('memory_limit','256M');  ?>
<?php
//initialize the session
if (!isset($_SESSION)) {
  session_start();
}

// ** Logout the current user. **
$logoutAction = $_SERVER['PHP_SELF']."?doLogout=true";
if ((isset($_SERVER['QUERY_STRING'])) && ($_SERVER['QUERY_STRING'] != "")){
  $logoutAction .="&". htmlentities($_SERVER['QUERY_STRING']);
}

if ((isset($_GET['doLogout'])) &&($_GET['doLogout']=="true")){ /* to fully log out a visitor we need to clear the session varialbles*//* we need to delete from the online users table the session_id when the user clicks logout *//*Code for online users goes here */ include('delonlineusers.php');
  //to fully log out a visitor we need to clear the session varialbles
  $_SESSION['MM_Username'] = NULL;
  $_SESSION['MM_UserGroup'] = NULL;
  $_SESSION['PrevUrl'] = NULL;
  unset($_SESSION['MM_Username']);
  unset($_SESSION['MM_UserGroup']);
  unset($_SESSION['PrevUrl']);
	
  $logoutGoTo = "index.php";
  if ($logoutGoTo) {
    header("Location: $logoutGoTo");
    exit;
  }
}
?>
<?php
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False; 

  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { 
      $isValid = true; 
    } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { 
      $isValid = true; 
    } 
    if (($strUsers == "") && true) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

$MM_restrictGoTo = "index.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($QUERY_STRING) && strlen($QUERY_STRING) > 0) 
  $MM_referrer .= "?" . $QUERY_STRING;
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
  






if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($theValue) : mysqli_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

/* now get the actual civil case categories corresponding to the case_type id*/
/*mysqli_select_db($conn, $database_conn);
$query_get_cv_case_categories = "SELECT * FROM ".$case_types_table." where case_type_id=$case_type_id ORDER BY case_type_id ASC";
$get_cv_case_categories = mysqli_query($conn, $query_get_cv_case_categories) or die(mysqli_error());*/
//$row_get_cv_case_categories = mysqli_fetch_assoc($get_cv_case_categories);
//$totalRows_get_cv_case_categories = mysqli_num_rows($get_cv_case_categories);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta http-equiv="X-UA-Compatible" content="IE=Edge" />
<title>Court Case Administration System</title>
<link rel="icon" href="images/ccasfav.ico" type="image/x-icon" />
<link href="styler/forms_kawuki.css" rel="stylesheet" type="text/css" />
<link href="styler/bubblegum.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
#apDiv1 {
	position:absolute;
	left:614px;
	top:25px;
	width:111px;
	height:16px;
	z-index:1;
}
#apDiv2 {
	position:absolute;
	left:515px;
	top:55px;
	width:176px;
	height:28px;
	z-index:1;
}
#apDiv3 {
	position:absolute;
	left:617px;
	top:26px;
	width:109px;
	height:16px;
	z-index:1;
}
#apDiv4 {
	position:absolute;
	left:1075px;
	top:11px;
	width:48px;
	height:16px;
	z-index:1;
}
#apDiv5 {
	position:absolute;
	left:1024px;
	top:10px;
	width:34px;
	height:16px;
	z-index:1;
}
#apDiv6 {
	position:absolute;
	left:933px;
	top:10px;
	width:75px;
	height:16px;
	z-index:1;
	font-weight: bold;
}
#apDiv7 {
	position:absolute;
	left:919px;
	top:10px;
	width:14px;
	height:16px;
	z-index:1;
}
#apDiv8 {
	position:absolute;
	left:860px;
	top:10px;
	width:58px;
	height:16px;
	z-index:1;
}
#apDiv9 {
	position:absolute;
	left:844px;
	top:10px;
	width:14px;
	height:16px;
	z-index:1;
}
#apDiv10 {
	position:absolute;
	left:1059px;
	top:10px;
	width:14px;
	height:16px;
	z-index:1;
}
#apDiv11 {
	position:absolute;
	left:1010px;
	top:10px;
	width:14px;
	height:16px;
	z-index:1;
}
#apDiv {
	position:absolute;
	left:711px;
	top:10px;
	width:130px;
	height:16px;
	z-index:1;
	font-size: 11px;
	font-weight: bold;
}
#apDiv12 {
	position:absolute;
	left:8px;
	top:10px;
	width:372px;
	height:45px;
	z-index:2;
	font-size:16px
}
#apDiv13 {
	position:absolute;
	width:188px;
	height:296px;
	z-index:3;
	left: 378px;
	top: 144px;
	background-color: #9999FF;
}
-->
</style>
<script src="SpryAssets/SpryTabbedPanels.js" type="text/javascript"></script>
<style type="text/css">
<!--
#apDiv14 {
	position:absolute;
	left:364px;
	top:54px;
	width:129px;
	height:30px;
	z-index:3;
}
#apDiv15 {	position:absolute;
	left:364px;
	top:54px;
	width:129px;
	height:30px;
	z-index:3;
}
.dd {
	color: #000;
}
-->
</style>
<link href="SpryAssets/SpryTabbedPanels.css" rel="stylesheet" type="text/css" />
<script type="text/javascript">

function printSelection(node){

  var content=node.innerHTML
  var pwin=window.open('','print_content','width=100,height=100');

  pwin.document.open();
  pwin.document.write('<html><body onload="window.print()">'+content+'</body></html>');
  pwin.document.close();
 
  setTimeout(function(){pwin.close();},1000);

}
</script>

</head>

<body style="background:#FFF">
<div id="print">
<table width="100%" border="0" style="background:#FFF; color:#000">

  <tr>
    <td align="center" valign="top" class="h3causelist" >
    
        <?php $fromdate=$_GET['fromdate'];
	
	$todate=$_GET['todate'];
	$sitting_court_id=$_GET['sitting_court_id'];
	
	
	$case_maintence_sht=$_GET['case_maintence_sht'];
	
   //	echo $todate; exit;
	
	 ?>
	
	<?php
/*	$case_maintence_sht=$_POST['case_maintence_sht'];
	$fromdate=$_POST['from_date'];
	
	$todate=$_POST['to_date'];*/
	
			   $user2=$_SESSION['MM_Username'];
$ip2=$_SERVER['REMOTE_ADDR'];
/*get the court_id of the court whose data you want to register.tbl_track_court*/
mysqli_select_db($conn, $database_conn);
$query_get_current_court = "SELECT * FROM tbl_court_track where username='$user2' and ipaddress='$ip2'";
$get_current_court = mysqli_query($conn, $query_get_current_court) or die(mysqli_error());
$row_get_current_court = mysqli_fetch_assoc($get_current_court);
//$totalRows_get_current_court = mysqli_num_rows($get_current_court);
$court_Id3=$row_get_current_court['court_id'];
$court_division_id=$row_get_current_court['court_division_id']; 

/*get the court type id belonging to a particular court from the courts table*/
mysqli_select_db($conn, $database_conn);
$query_get_court_type_id = "SELECT * FROM courts where court_id='$court_Id3'";
$get_court_type_id = mysqli_query($conn, $query_get_court_type_id) or die(mysqli_error());
$row_court_type_id  = mysqli_fetch_assoc($get_court_type_id);
$court_type_id=$row_court_type_id['court_type_id'];
$mag_id=$row_court_type_id['magisterial_area_id'];
$mag_seq_no=$row_court_type_id['seq_no'];
$location=$row_court_type_id['location'];
$location=strtoupper($location);


if($sitting_court_id!=""){
		
		$sitting_court_id_where_state=" and sitting_court_id='$sitting_court_id' ";
		/*also get the sitting location of the court where the court	where the session will be held*/
mysqli_select_db($conn, $database_conn);
$query_get_sitting_court_location = "SELECT * FROM courts where court_id='$sitting_court_id'";
$get_sitting_court_location = mysqli_query($conn, $query_get_sitting_court_location) or die(mysqli_error());
$row_sitting_court_location  = mysqli_fetch_assoc($get_sitting_court_location);
$sitting_court_location=$row_sitting_court_location['location'];
$location=strtoupper($sitting_court_location);
		}
		else{
			$sitting_court_id_where_state="";
			$location=$location;
			
			}
/*for high court and lower courts redirect to causelistmaker2 to use different views*/
/*if($court_type_id==1 || $court_type_id==5 || $court_type_id==6)

	{
		header("location:causelistmaker2.php?todate=$todate&fromdate=$fromdate&case_maintence_sht=$case_maintence_sht&");
			exit;
		
		}
		elseif($court_type_id==2)

	{
		header("location:causelistmaker3.php?todate=$todate&fromdate=$fromdate&case_maintence_sht=$case_maintence_sht&");
			exit;
		
		}*/


/*if($case_maintence_sht!="")*/
if($case_maintence_sht!="")
{
	/*$new="javascript:window.open(casemantcesht.php)";*/
//echo "checked";

?>
<script type="text/javascript">window.open('casemantceshtcoaensup.php?fromdate=<?php echo $fromdate; ?>&todate=<?php echo $todate; ?>')</script>

<?php
//header("Location: ".$new); 
//header("Location: javascript:window.open(h.php)"); 
//echo header:"
}
//exit;


$civil_division_id="CV";
$criminal_division_id="CR";
$commercial_division_id="CC";
$anti_corruption_division_id="AC";
$family_division_id="FD";
$land_division_id="LD";
$international_crimes_division_id="ICD";
$executions_and_bailiffs="EXD";

if($court_division_id==$civil_division_id)
{$court_division="CIVIL";}
if($court_division_id==$criminal_division_id)
{$court_division="CRIMINAL";}
if($court_division_id==$commercial_division_id)
{$court_division="COMMERCIAL";}
if($court_division_id==$anti_corruption_division_id)
{$court_division="ANTI-CORRUPTION";}
if($court_division_id==$family_division_id)
{$court_division="FAMILY";}
if($court_division_id==$land_division_id)
{$court_division="LAND";}
if($court_division_id==$international_crimes_division_id)
{$court_division="INTERNATIONAL CRIMES";}
if($court_division_id==$executions_and_bailiffs)
{$court_division="EXECUTION AND BAILIFFS";}

if($court_division_id==$criminal_division_id || $court_division_id==$anti_corruption_division_id || $court_division_id==$international_crimes_division_id )
{
	
	$selection_table_or_view="vw_cr_cc_causelist_for_hct_cm_gI_g2";
	//$selection_table_or_view_original="vw_cr_cc_causelist";
	$case_types_table="cr_case_types";
	$sitting_types_table="cr_sitting_types";
	/*$start_date="date_of_change";*/
	}
	else{
		
		/*$selection_table_or_view="vw_cc_causelist";*/
		$selection_table_or_view="vw_cv_cc_causelist_for_hct_cm_gI_g2";
		$case_types_table="cv_case_types_codes";
		$sitting_types_table="cv_sitting_type_codes";
		/*$start_date="date_change";*/
		}


$supreme_court_type_id=4;
$coa_court_type_id=3;
$hct_court_type_id=2;
/*get the court type belonging to a particular court from the courts table*/
mysqli_select_db($conn, $database_conn);
$query_get_court_type = "SELECT * FROM court_types where court_type_id='$court_type_id'";
$get_court_type = mysqli_query($conn, $query_get_court_type) or die(mysqli_error());
$row_court_type = mysqli_fetch_assoc($get_court_type);
$courttype=$row_court_type['court_type'];
$courttype=strtoupper($courttype);
/*get the magisterial_id from which a court belongs*/
/*mysqli_select_db($conn, $database_conn);
$query_get_mag_id = "SELECT magisterial_area_id, seq_no FROM courts where court_id='$court_Id3' ";
$get_mag_id_res = mysqli_query($conn, $query_get_mag_id) or die(mysqli_error());
while($row_get_mag_id = mysqli_fetch_array($get_mag_id_res)){


}*/
/*get the magisterial area that appies to the supplied mag_id */
mysqli_select_db($conn, $database_conn);
$query_getmagareas = "SELECT * FROM magisterial_areas where magisterial_area_id='$mag_id' ";
$getmagareas = mysqli_query($conn, $query_getmagareas) or die(mysqli_error()); 
while($row_getmagareas_abb = mysqli_fetch_array($getmagareas)){

$mag_area=$row_getmagareas_abb['magisterial_area'];
$mag_area=strtoupper($mag_area);
}
	echo "THE REPUBLIC OF UGANDA<br />
      IN THE ".$courttype." OF ".$mag_area."  AT ".$location."<br />".$court_division." REGISTRY CAUSELIST FOR THE SITTINGS OF : $fromdate to $todate"; ?></td>
</tr>
  <tr>
    <td>
    
<table width='90%' border='0' style="margin-left:5%; margin-right:5%">
      <tr>
        <th class='causelistth'>&nbsp;</th>
        <th class='causelistth'>&nbsp;</th>
        <th class='causelistth'>&nbsp;</th>
        <th class='causelistth'>&nbsp;</th>
        <th class='causelistth'>&nbsp;</th>
        <th class='causelistth'>&nbsp;</th>
        <th class='causelistth'>&nbsp;</th>
        </tr>
      
<?php 
	/*first update cr_presiding_officer with new coram id*/
	if($court_division_id==$criminal_division_id || $court_division_id==$anti_corruption_division_id || $court_division_id==$international_crimes_division_id )
{
$update_presiding_officer=mysqli_query("update cr_presiding_officer AS t1
inner join (
select distinct 
z.case_id, 
z.start_date, 
concat(min(t3.grade), '-', group_concat(distinct z.judicial_officer_id order by z.judicial_officer_id SEPARATOR '-')) as tid, z.judicial_officer_id 
from 
cr_presiding_officer as z
inner join
judicial_officers
 AS t3
on (
z.judicial_officer_id = t3.judicial_officer_id
)
group by
 z.case_id, z.start_date
) as t2 
on (
t1.case_id = t2.case_id and t1.start_date = t2.start_date
)

set t1.coram_id = t2.tid");

}
  else
  {
	$update_presiding_officer2=mysqli_query($conn,"update cv_case_presiding_officer AS t1
inner join (
select distinct 
z.case_id, 
z.start_date, 
concat(min(t3.grade), '-', group_concat(distinct z.judicial_officer_id order by z.judicial_officer_id SEPARATOR '-')) as tid, z.judicial_officer_id 
from 
cv_case_presiding_officer as z
inner join
judicial_officers
 AS t3
on (
z.judicial_officer_id = t3.judicial_officer_id
)
group by
 z.case_id, z.start_date
) as t2 
on (
t1.case_id = t2.case_id and t1.start_date = t2.start_date
)

set t1.coram_id = t2.tid");
	}

	$fromdate=date('Y-m-d H:i:s', strtotime($fromdate)); 
    $todate=date('Y-m-d H:i:s', strtotime($todate)); 
	   
$user=$_SESSION['MM_Username'];
$ip=$_SERVER['REMOTE_ADDR'];
/*get the court_id of the court whose data you want to register.tbl_track_court*/

mysqli_select_db($conn, $database_conn);
$query_get_current_court = "SELECT court_id FROM tbl_court_track where username='$user' and ipaddress='$ip'";
$get_current_court = mysqli_query($conn, $query_get_current_court) or die(mysqli_error());
$row_get_current_court = mysqli_fetch_assoc($get_current_court);
//$totalRows_get_current_court = mysqli_num_rows($get_current_court);
$court_Id=$row_get_current_court['court_id'];


$todate=date('Y-m-d 23:59:59', strtotime($todate)); 
/*Print the sitting time*/


/*$civil_division_id="CV";
$criminal_division_id="CR";
$commercial_division_id="CC";
$anti_corruption_division_id="AC";
$family_division_id="FD";
$land_division_id="LD";
$international_crimes_division_id="ICD";
$executions_and_bailiffs="EXD";*/
/*get all sitting dates/time for a specified period*/
$query_get_sitting_time="SELECT *, SUBSTRING(sitting_time,1,10) AS day2  FROM ".$selection_table_or_view." where court_id='$court_Id' AND court_division_id='$court_division_id' and sitting_time between '$fromdate' and '$todate'  $sitting_court_id_where_state group by day2 ORDER BY sitting_time";

/*echo $query_get_sitting_time; exit;*/

/*$query_get_sitting_time="SELECT *  FROM ".$selection_table_or_view."  where court_id='$court_Id' AND court_division_id='$court_division_id' and sitting_time between '$fromdate' and '$todate' group by sitting_time ORDER BY sitting_time";*/

$get_all_sittings_time = mysqli_query($conn, $query_get_sitting_time) or die(mysqli_error());
$count_sittings=mysqli_num_rows($get_all_sittings_time);
//echo $query_get_sitting_time; exit;

/*Check to see if there are sittings and or not for the specified period of time. if there are no siitings alert the user. e.g there are no Cases to be heard for the specified period of time. else proceed and get the sitting dates*/
 if($count_sittings==0)
 	{
	 echo "<div style='color:#000; border:1px solid #F90; background-color: #F0FFE1; padding:10px 20px; font-weight:bold; text-align:center; margin:30px 30px 30px 30px;'>	
    	<h3>Sorry there are no Cases to be heard for the specified period</h3>

    </div>";
	 }
  else{
	  while($row_get_all_sittings_time = mysqli_fetch_array($get_all_sittings_time))
	   {
		$sitting_time=$row_get_all_sittings_time['sitting_time'];
		$sitting_time_day=date('Y-m-d',strtotime($sitting_time));
		/*convert sitting time to day.*/
	    $sitting_time_actual_day=strtoupper(date('l, d-M-Y',strtotime($sitting_time)));
		 
	/*Print the day*/
		echo "
        <tr><td colspan='2' class='h2causelist' style='border-bottom:solid 1px #000; border-right:solid 1px #000; font-size=14px; color:#FFF; background:#000'>$sitting_time_actual_day</td></tr>";
		
		/*get the corams/judicial officers using the coram id*/
		
$query_get_coram_id="SELECT coram_id FROM ".$selection_table_or_view." where court_id='$court_Id' AND court_division_id='$court_division_id' and sitting_time between  '$sitting_time_day' and '$sitting_time_day 23:59:59'  $sitting_court_id_where_state group by coram_id ORDER BY isnull(coram_id+0),(coram_id+0) asc ";

$get_all_coram_id = mysqli_query($conn, $query_get_coram_id) or die(mysqli_error());
//echo $query_get_coram_id; exit;
while($row_get_all_coram_id = mysqli_fetch_array($get_all_coram_id))
	   {
		  /*get the coram_ids*/ 
		  $coram_id=$row_get_all_coram_id['coram_id'];
		 
	/*check if the court is COA or supreme court*/	 
	if($court_Id=='001' || ($court_Id=='011'))
	{
		$before='CORAM::';
	}
	else
	{
		$before='BEFORE::';
	} 
		
 /*if(($court_division_id==$criminal_division_id) || ($court_division_id==$anti_corruption_division_id) ){*/
		  /*Now get the Juducial officers belonging to a particular coram*/
		  if(is_null($coram_id))
		  {$query_get_judicial_officer="SELECT judicial_officer, title, court_room,grade FROM ".$selection_table_or_view."  where court_id='$court_Id' AND court_division_id='$court_division_id' and sitting_time between '$sitting_time_day' and '$sitting_time_day 23:59:59' $sitting_court_id_where_state  and coram_id is null group by judicial_officer_id ORDER BY (grade+0)";}
		  else
		  {$query_get_judicial_officer="SELECT judicial_officer, title, court_room, grade FROM ".$selection_table_or_view."  where court_id='$court_Id' AND court_division_id='$court_division_id' and sitting_time between '$sitting_time_day' and '$sitting_time_day 23:59:59' $sitting_court_id_where_state and coram_id='$coram_id' group by judicial_officer_id ORDER BY (grade+0) ";

            }
//echo  $query_get_judicial_officer; exit;	
	

/*close the opening judicial/division id if statement*/
		// }
		 /*else
		 {
			 	  /*Now get the Juducial officers belonging to a particular coram*/
		/*  if(is_null($coram_id))
		  {$query_get_judicial_officer="(SELECT judicial_officer, title, court_room,grade FROM vw_cc_causelist  where court_id='$court_Id' AND court_division_id='$court_division_id' and sitting_time between '$sitting_time_day' and '$sitting_time_day 23:59:59'  and coram_id is null group by judicial_officer_id)
		  
		  union
		  
		  (SELECT judicial_officer, title, court_room,grade FROM vw_cr_cc_causelist  where court_id='$court_Id' AND court_division_id='CR' and sitting_time between '$sitting_time_day' and '$sitting_time_day 23:59:59'  and coram_id is null group by judicial_officer_id) ORDER BY (grade+0)
		  
		  
		  ";}
		  else
		  {$query_get_judicial_officer="(SELECT judicial_officer, title, court_room, grade FROM vw_cc_causelist  where court_id='$court_Id' AND court_division_id='$court_division_id' and sitting_time between '$sitting_time_day' and '$sitting_time_day 23:59:59' and coram_id='$coram_id' group by judicial_officer_id)
		  
		  union
		  
		(SELECT judicial_officer, title, court_room, grade FROM vw_cr_cc_causelist  where court_id='$court_Id' AND court_division_id='CR' and sitting_time between '$sitting_time_day' and '$sitting_time_day 23:59:59' and coram_id='$coram_id' group by judicial_officer_id) ORDER BY (grade+0)  
		  
		  
		  ";

}
			 
			 } */
	
	/*  $query_get_judicial_officer="SELECT judicial_officer, title FROM ".$selection_table_or_view."  where court_id='$court_Id' AND court_division_id='$court_division_id' and sitting_time='$sitting_time' and coram_id='$coram_id' group by judicial_officer_id ORDER BY (grade+0)";*/
//echo  $query_get_judicial_officer; exit;
$get_judicial_officer = mysqli_query($conn, $query_get_judicial_officer) or die(mysqli_error());
		  $m=0;
		  while($row_get_judicial_officer  = mysqli_fetch_array($get_judicial_officer))
	         {
		    $judicial_officer=$row_get_judicial_officer['judicial_officer'];	
			$judicial_officer=strtoupper($judicial_officer);
			$title=$row_get_judicial_officer['title'];	
		   
		   $judicial_officer_and_his_title=$title." ".$judicial_officer;
           $judicial_officer_and_his_title=strtoupper($judicial_officer_and_his_title);
		   
		 
		 
		 if($m==0){
		  $court_room=$row_get_judicial_officer['court_room'];	;
          $court_room=strtoupper($court_room);
		  $actual_court_room_naming="COURT ROOM :: ";
		  $court_room_data="<td class='courtroom' >$actual_court_room_naming $court_room</td>";
		  }
		  else{
			  $court_room="";
			  $actual_court_room_naming="";
			  $court_room_data="";
			  }

		
		if($judicial_officer!="Not Allocated"){
		  echo "<tr><td class='causelistcontenth1'>$before</td><td colspan='2' class='causelistcontenth1'><b>$judicial_officer_and_his_title</b></td><td>&nbsp;</td>$court_room_data</tr>";}
else{
		echo "<tr><td class='causelistcontenth1'>$before</td><td colspan='2' style='border-bottom:solid 1px #000; border-right:solid 1px #000; color:#000; background:#FFF'><b>$judicial_officer</b></td><td>&nbsp;</td>$court_room_data</tr>";
	}
	
	$before="";
	$m++;
	
		       /*close the while loop for the judicial officers*/
		        }
		 
		  /*Now get the actual cases of per coram on a aparticular day, use coram_id and sitting_time*/
		  if($court_division_id==$criminal_division_id || $court_division_id==$anti_corruption_division_id || $court_division_id==$international_crimes_division_id )
{
	/*update cr_presiding_officer with new coram id*/
/*$update_presiding_officer=mysqli_query("update cr_presiding_officer AS t1
inner join (
select distinct 
z.case_id, 
z.start_date, 
concat(min(t3.grade), '-', group_concat(distinct z.judicial_officer_id order by z.judicial_officer_id SEPARATOR '-')) as tid, z.judicial_officer_id 
from 
cr_presiding_officer as z
inner join
judicial_officers
 AS t3
on (
z.judicial_officer_id = t3.judicial_officer_id
)
group by
 z.case_id, z.start_date
) as t2 
on (
t1.case_id = t2.case_id and t1.start_date = t2.start_date
)

set t1.coram_id = t2.tid");*/

	
		/*update cv_case_presiding_officer with new coram id*/
/*$update_presiding_officer2=mysqli_query("update cv_case_presiding_officer AS t1
inner join (
select distinct 
z.case_id, 
z.start_date, 
concat(min(t3.grade), '-', group_concat(distinct z.judicial_officer_id order by z.judicial_officer_id SEPARATOR '-')) as tid, z.judicial_officer_id 
from 
cv_case_presiding_officer as z
inner join
judicial_officers
 AS t3
on (
z.judicial_officer_id = t3.judicial_officer_id
)
group by
 z.case_id, z.start_date
) as t2 
on (
t1.case_id = t2.case_id and t1.start_date = t2.start_date
)

set t1.coram_id = t2.tid");
	*/
	
	
	
	$cases_headers = " </th></tr>
			<tr><td colspan='7' class='causelistcontenth1'><div  style='margin-top:8px;'></div></td></tr>
			<tr><td class='causelistcontenth1' >Time</td>
			<th class='causelistcontenth1'>Case number</th>
			<th class='causelistcontenth1'>Case Category</th>
			<th class='causelistcontenth1' style='text-align:center;'>Parties</th>
			<th class='causelistcontenth1'>Charge</th>
			<th class='causelistcontenth1'>Sitting Type</th>
			<th class='causelistcontenth1'>Nature of Appl./Appeal</th>
		  </tr><tr><td colspan='7' class='causelistcontenth1'><hr /></td></tr>"; 
		if(is_null($coram_id))
		{
			  $query_get_all_cases_per_coram="SELECT  case_id,sitting_time,offence,case_sub_type,court_division_id,court_id, case_type_id,case_seq_no,case_year, sitting_type_id, stage,stage_id, short_form_name1,short_form_name2,sitting_type,case_number,case_type FROM ".$selection_table_or_view." where court_id='$court_Id' AND court_division_id='$court_division_id' and sitting_time between '$sitting_time_day' and '$sitting_time_day 23:59:59' $sitting_court_id_where_state  and coram_id is null group by case_id ORDER BY sitting_time "; 
			}  else{
  $query_get_all_cases_per_coram="SELECT case_id,sitting_time,offence,case_sub_type,court_division_id,court_id, case_type_id,case_seq_no,case_year, sitting_type_id, stage,stage_id, short_form_name1,short_form_name2,sitting_type,case_number,case_type FROM ".$selection_table_or_view." where court_id='$court_Id' AND court_division_id='$court_division_id' and sitting_time between '$sitting_time_day' and '$sitting_time_day 23:59:59'  $sitting_court_id_where_state and coram_id='$coram_id' group by case_id ORDER BY sitting_time
  
  
  
  
   "; }
$get_all_cases_per_coram= mysqli_query($conn, $query_get_all_cases_per_coram) or die(mysqli_error());

$j=1;
//echo $query_get_all_cases_per_coram; exit;
while($row_get_all_sittings_per_coram=mysqli_fetch_array($get_all_cases_per_coram))
		{
			$cc_case_type=$row_get_all_sittings_per_coram['case_type'];
			$sitting_type=$row_get_all_sittings_per_coram['sitting_type'];
			$case_number=$row_get_all_sittings_per_coram['case_number'];
	$case_id=$row_get_all_sittings_per_coram['case_id'];
	$court_division_id2=$row_get_all_sittings_per_coram['court_division_id'];
	$court_id2=$row_get_all_sittings_per_coram['court_id'];
	$case_type_id2=$row_get_all_sittings_per_coram['case_type_id'];
	$case_seq_no=$row_get_all_sittings_per_coram['case_seq_no'];
	$charge=$row_get_all_sittings_per_coram['offence'];
	$charge=strtoupper($charge);
	$case_year2=$row_get_all_sittings_per_coram['case_year'];
	$sitting_type_id=$row_get_all_sittings_per_coram['sitting_type_id'];
	$position_id=$row_get_all_sittings_per_coram['stage_id'];
	$nature_of_appeal=$row_get_all_sittings_per_coram['case_sub_type'];
	$nature_of_appeal=strtoupper($nature_of_appeal);
	$short_form_name3=$row_get_all_sittings_per_coram['short_form_name1'];
	$short_form_name3=strtoupper(stripslashes($short_form_name3));
	$short_form_name4=$row_get_all_sittings_per_coram['short_form_name2'];
	$short_form_name4=strtoupper(stripslashes($short_form_name4));
	$sit=$row_get_all_sittings_per_coram['sitting_time'];
	$sit2=date('H:i', strtotime($sit));
	
	/*if time is in 24 hours and is grater than 13:00, then chage time to show in 12 hours clock*/
	if($sit2 >='13:00')
{
	/* coverting existing time to seconds*/
	$sit2=strtotime($sit2);
	/*subtract 12:00 hours from exsiting time in seconds*/
	$sit2=strtotime('-12 hours', $sit2);
	/*convert the time difference in seconds to hours and minutes */
	$sit2=date('H:i', $sit2);
	}
	
	
		 if(($sit2=="00:00") && ($court_type_id==$coa_court_type_id || $court_type_id==$supreme_court_type_id))
	      {
	      $sit2="09:30";
	      }

		  else if(($sit2=="00:00") && ($court_type_id==$hct_court_type_id))
		  {
			  $sit2='09:00';
		  }
		  else
		  {
		  $sit2=$sit2;
		  }
		
		/* zerofill the case seqn_no it, width is the number of zeros and the 0 is the number to be repeated.*/
        $width=4;
		$case_seq_no=str_pad((string)$case_seq_no, $width, "0", STR_PAD_LEFT);	

/*get the magisterial_id from which a court belongs*/
/*mysqli_select_db($conn, $database_conn);
$query_get_mag_id = "SELECT magisterial_area_id, seq_no FROM courts where court_id='$court_id2' ";
$get_mag_id_res = mysqli_query($conn, $query_get_mag_id) or die(mysqli_error());


while($row_get_mag_id = mysqli_fetch_array($get_mag_id_res)){

$mag_id=$row_get_mag_id['magisterial_area_id'];
$mag_seq_no=$row_get_mag_id['seq_no'];
}*/
/*get the magisterial abbreviation (3 characteres that appies to the supplied mag_id */
/*mysqli_select_db($conn, $database_conn);
$query_getmagareas = "SELECT abb FROM magisterial_areas where magisterial_area_id='$mag_id' ";
$getmagareas = mysqli_query($conn, $query_getmagareas) or die(mysqli_error());


while($row_getmagareas_abb = mysqli_fetch_array($getmagareas)){

$mag_abb=$row_getmagareas_abb['abb'];
}*/
/*Declare court code= abb + */

//$court_code=$mag_abb."-".$mag_seq_no;

/*Get case type_ abbreviation from the supplied case type _id*/
/*mysqli_select_db($conn, $database_conn);
if($court_division_id2==$criminal_division_id || $court_division_id2==$anti_corruption_division_id || $court_division_id==$international_crimes_division_id)
{
	
	
	$case_types_table="cr_case_types";
	$sitting_types_table="cr_sitting_types";

	}
	else{
		
		
		$case_types_table="cv_case_types_codes";
		$sitting_types_table="cv_sitting_type_codes";*/
		/*$start_date="date_change";*/
/*		}
$query_get_case_type_abbrv = "SELECT * FROM ".$case_types_table." where case_type_id='$case_type_id2' ";
$get_case_type_abbrv = mysqli_query($conn, $query_get_case_type_abbrv) or die(mysqli_error());
while($row_get_case_type_abbrv = mysqli_fetch_array($get_case_type_abbrv)){*/
//$totalRows_get_case_type_abbrv = mysqli_num_rows($get_case_type_abbrv);
/*$cc_case_type_abb=$row_get_case_type_abbrv['abb'];
$cc_case_type=$row_get_case_type_abbrv['case_type'];
}*/
/*Now combine all ids to get the case number */
//$case_number=$court_code."-".$court_division_id2."-".$cc_case_type_abb."-".$case_seq_no."-".$case_year2;


/*get the sitting type equaling to the supplied sitting type id*/
/*mysqli_select_db($conn, $database_conn);
$query_get_cv_sitting_types = "SELECT * FROM ".$sitting_types_table." where sitting_type_id='$sitting_type_id'";
$get_cv_sitting_types = mysqli_query($conn, $query_get_cv_sitting_types) or die(mysqli_error());*/
//$row_get_cv_sitting_types = mysqli_fetch_assoc($get_cv_sitting_types);
/*$totalRows_get_cv_sitting_types = mysqli_num_rows($get_cv_sitting_types);*/

		/*	while($row_get_cv_sitting_types = mysqli_fetch_array($get_cv_sitting_types)){
			
			$sitting_type=$row_get_cv_sitting_types['sitting_type'];
			
			} */
			
		echo $cases_headers;
		  	 echo "<tr>
       <td class='causelistcontent'><span style='margin-right:2px;'>$j.</span> $sit2</td>
	   <td class='causelistcontent' style='width:200px;'>$case_number</td>
	   <td class='causelistcontent'>$cc_case_type</td>
        <td class='causelistcontent'>$short_form_name3 VS $short_form_name4</td>
       <td class='causelistcontent'>$charge</td>
	   <td class='causelistcontent'>$sitting_type</td>
	   <td class='causelistcontent'>$nature_of_appeal</td>
       </tr>
	   <tr><td colspan='7'>&nbsp;</td></tr>";
		
		$j++;
		$cases_headers="";	
		/*close the criminal cases or ACD while loop*/
		}



/*close the if statement that checks if the division is criminal or ACD*/
}

else
{
	
	/*update cv_case_presiding_officer with new coram id*/
/*$update_presiding_officer2=mysqli_query("update cv_case_presiding_officer AS t1
inner join (
select distinct 
z.case_id, 
z.start_date, 
concat(min(t3.grade), '-', group_concat(distinct z.judicial_officer_id order by z.judicial_officer_id SEPARATOR '-')) as tid, z.judicial_officer_id 
from 
cv_case_presiding_officer as z
inner join
judicial_officers
 AS t3
on (
z.judicial_officer_id = t3.judicial_officer_id
)
group by
 z.case_id, z.start_date
) as t2 
on (
t1.case_id = t2.case_id and t1.start_date = t2.start_date
)

set t1.coram_id = t2.tid");
*/
	/*update cr_presiding_officer with new coram id*/
/*$update_presiding_officer=mysqli_query("update cr_presiding_officer AS t1
inner join (
select distinct 
z.case_id, 
z.start_date, 
concat(min(t3.grade), '-', group_concat(distinct z.judicial_officer_id order by z.judicial_officer_id SEPARATOR '-')) as tid, z.judicial_officer_id 
from 
cr_presiding_officer as z
inner join
judicial_officers
 AS t3
on (
z.judicial_officer_id = t3.judicial_officer_id
)
group by
 z.case_id, z.start_date
) as t2 
on (
t1.case_id = t2.case_id and t1.start_date = t2.start_date
)

set t1.coram_id = t2.tid");*/
	
	
$cases_headers ="</th></tr>
		<tr><td colspan='7' class='causelistcontenth1'><div  style='margin-top:8px;'></div></td></tr>
        <tr><td class='causelistcontenth1' >Time</td>
        <th class='causelistcontenth1'>Case number</th>
        <th class='causelistcontenth1'>Case Category</th>
        <th class='causelistcontenth1' style='text-align:center;'>Parties</th>
        <th class='causelistcontenth1'>Claim</th>
        <th class='causelistcontenth1'>Sitting Type</th>
        <th class='causelistcontenth1'>Position</th>
      </tr><tr><td colspan='7' class='causelistcontenth1'><hr /></td></tr>";
if(is_null($coram_id))
		{
			  $query_get_all_cases_per_coram="SELECT case_id,sitting_time,desc_of_claim,case_sub_type,court_division_id,court_id, case_type_id,case_seq_no,case_year, sitting_type_id, position,position_id, short_form_name1,short_form_name2 FROM ".$selection_table_or_view." where court_id='$court_Id' AND court_division_id='$court_division_id' and sitting_time between '$sitting_time_day' and '$sitting_time_day 23:59:59' $sitting_court_id_where_state and coram_id is null group by case_id ORDER BY sitting_time"; 
			}  else{
  $query_get_all_cases_per_coram="SELECT case_id,sitting_time,desc_of_claim,case_sub_type,court_division_id,court_id,case_type_id,case_seq_no,case_year, sitting_type_id, position,position_id, short_form_name1,short_form_name2 FROM ".$selection_table_or_view."  where court_id='$court_Id' AND court_division_id='$court_division_id' and sitting_time between '$sitting_time_day' and '$sitting_time_day 23:59:59' $sitting_court_id_where_state and  coram_id='$coram_id' group by case_id ORDER BY sitting_time
  
  
  
  
   "; }
$get_all_cases_per_coram= mysqli_query($conn, $query_get_all_cases_per_coram) or die(mysqli_error());
//echo $query_get_all_cases_per_coram; exit;
$j=1;
while($row_get_all_sittings_per_coram=mysqli_fetch_array($get_all_cases_per_coram))
		{
			
	$case_id=$row_get_all_sittings_per_coram['case_id'];
	$court_division_id2=$row_get_all_sittings_per_coram['court_division_id'];
	$court_id2=$row_get_all_sittings_per_coram['court_id'];
	$case_type_id2=$row_get_all_sittings_per_coram['case_type_id'];
	$case_seq_no=$row_get_all_sittings_per_coram['case_seq_no'];
	$desc_of_claim=$row_get_all_sittings_per_coram['desc_of_claim'];
	$case_year2=$row_get_all_sittings_per_coram['case_year'];
	$sitting_type_id=$row_get_all_sittings_per_coram['sitting_type_id'];
	$position_id =$row_get_all_sittings_per_coram['position_id'];
	$nature_of_appeal=$row_get_all_sittings_per_coram['case_sub_type'];
	$nature_of_appeal=strtoupper($nature_of_appeal);
	$short_form_name3=$row_get_all_sittings_per_coram['short_form_name1'];
	$short_form_name3=strtoupper(stripslashes($short_form_name3));
	$short_form_name4=$row_get_all_sittings_per_coram['short_form_name2'];
	$short_form_name4=strtoupper(stripslashes($short_form_name4));
	$sit=$row_get_all_sittings_per_coram['sitting_time'];
	$sit2=date('H:i', strtotime($sit));
	
	/*if time is in 24 hours and is grater than 13:00, then chage time to show in 12 hours clock*/
	if($sit2 >='13:00')
{
	/* coverting existing time to seconds*/
	$sit2=strtotime($sit2);
	/*subtract 12:00 hours from exsiting time in seconds*/
	$sit2=strtotime('-12 hours', $sit2);
	/*convert the time difference in seconds to hours and minutes */
	$sit2=date('H:i', $sit2);
	}

		
		 if(($sit2=="00:00") && ($court_type_id==$coa_court_type_id || $court_type_id==$supreme_court_type_id))
	      {
	      $sit2="09:30";
	      }

		  else if(($sit2=="00:00") && ($court_type_id==$hct_court_type_id))
		  {
			  $sit2='09:00';
		  }
		  else
		  {
		  $sit2=$sit2;
		  }

	//$case_number=strtoupper($case_number);
	$desc_of_claim=strtoupper($desc_of_claim);
	//$cc_case_type=strtoupper($cc_case_type);
	//$sitting_type=strtoupper($sitting_type);
	$position=$row_get_all_sittings_per_coram['position'];
	$position =strtoupper($position);


		
	/* zerofill the case seqn_no it, width is the number of zeros and the 0 is the number to be repeated.*/
        $width=4;
		$case_seq_no=str_pad((string)$case_seq_no, $width, "0", STR_PAD_LEFT);	

/*get the magisterial_id from which a court belongs*/
mysqli_select_db($conn, $database_conn);
$query_get_mag_id = "SELECT magisterial_area_id, seq_no FROM courts where court_id='$court_id2' ";
$get_mag_id_res = mysqli_query($conn, $query_get_mag_id) or die(mysqli_error());


while($row_get_mag_id = mysqli_fetch_array($get_mag_id_res)){

$mag_id=$row_get_mag_id['magisterial_area_id'];
$mag_seq_no=$row_get_mag_id['seq_no'];
}
/*get the magisterial abbreviation (3 characteres that appies to the supplied mag_id */
mysqli_select_db($conn, $database_conn);
$query_getmagareas = "SELECT abb FROM magisterial_areas where magisterial_area_id='$mag_id' ";
$getmagareas = mysqli_query($conn, $query_getmagareas) or die(mysqli_error());


while($row_getmagareas_abb = mysqli_fetch_array($getmagareas)){

$mag_abb=$row_getmagareas_abb['abb'];
}
/*Declare court code= abb + */

$court_code=$mag_abb."-".$mag_seq_no;

/*Get case type_ abbreviation from the supplied case type _id*/
if($court_division_id2==$criminal_division_id || $court_division_id2==$anti_corruption_division_id || $court_division_id==$international_crimes_division_id)
{
	
	
	$case_types_table="cr_case_types";
	$sitting_types_table="cr_sitting_types";

	}
	else{
		
		
		$case_types_table="cv_case_types_codes";
		$sitting_types_table="cv_sitting_type_codes";
		/*$start_date="date_change";*/
		}
mysqli_select_db($conn, $database_conn);
$query_get_case_type_abbrv = "SELECT * FROM ".$case_types_table." where case_type_id='$case_type_id2' ";
$get_case_type_abbrv = mysqli_query($conn, $query_get_case_type_abbrv) or die(mysqli_error());
while($row_get_case_type_abbrv = mysqli_fetch_array($get_case_type_abbrv)){
//$totalRows_get_case_type_abbrv = mysqli_num_rows($get_case_type_abbrv);
$cc_case_type_abb=$row_get_case_type_abbrv['abb'];
$cc_case_type=$row_get_case_type_abbrv['case_type'];
}
/*Now combine all ids to get the case number */
$case_number=$court_code."-".$court_division_id2."-".$cc_case_type_abb."-".$case_seq_no."-".$case_year2;


/*get the sitting type equaling to the supplied sitting type id*/
mysqli_select_db($conn, $database_conn);
$query_get_cv_sitting_types = "SELECT * FROM ".$sitting_types_table." where sitting_type_id='$sitting_type_id'";
$get_cv_sitting_types = mysqli_query($conn, $query_get_cv_sitting_types) or die(mysqli_error());
//$row_get_cv_sitting_types = mysqli_fetch_assoc($get_cv_sitting_types);
/*$totalRows_get_cv_sitting_types = mysqli_num_rows($get_cv_sitting_types);*/

while($row_get_cv_sitting_types = mysqli_fetch_array($get_cv_sitting_types)){

$sitting_type=$row_get_cv_sitting_types['sitting_type'];

} 

echo $cases_headers;
  echo "<tr>
       <td class='causelistcontent'><span style='margin-right:2px;'>$j.</span>  $sit2</td>
	   <td class='causelistcontent' style='width:200px;'>$case_number</td>
	   <td class='causelistcontent'>$cc_case_type</td>
        <td class='causelistcontent'>$short_form_name3 VS $short_form_name4</td>
       <td class='causelistcontent'>$desc_of_claim</td>
	   <td class='causelistcontent'>$sitting_type</td>
	   <td class='causelistcontent'>$position</td>
       </tr>
	   <tr><td colspan='7'>&nbsp;</td></tr>";	
		
		$j++;
		$cases_headers="";	
		/*close the civil cases while loop*/
		}


/*close the else statement that checks if the division is not criminal or ACD*/
}
		  
		  
		  
		 /*close the while loop for the coram_ids*/
		   }

       
	   
	    /*close the bigger while loop for sitting time*/
	    }
	  /*Close the bigger else statement*/
	  }
?>
</table>
</td></tr></table>
</div>
<div style="float:left; margin-top:5px; margin-left:80px; cursor:pointer"><img src="images/Print.png" height="30" width="30" onclick="printSelection(document.getElementById('print'));return false" title="Print this report" /></div>
</body>
</html>