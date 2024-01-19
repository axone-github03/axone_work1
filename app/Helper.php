<?php

use App\Models\Lead;
use App\Models\User;
use App\Models\CRMLog;
use App\Models\Inquiry;
use App\Models\CityList;
use App\Models\DebugLog;
use App\Models\LeadCall;
use App\Models\Architect;
use App\Models\StateList;
use App\Models\TeleSales;
use App\Models\InquiryLog;
use App\Models\ProductLog;
use App\Models\SalePerson;
use App\Models\LeadStatusUpdate;
use App\Models\UserContact;
use App\Models\UserFiles;
use App\Models\CountryList;
use App\Models\UserNotes;
use App\Models\Electrician;
use App\Models\UserCallAction;
use App\Models\UserMeetingParticipant;
use App\Models\CRMSettingMeetingTitle;
use App\Models\UserMeetingAction;
use App\Models\UserTaskAction;
use App\Models\LeadTimeline;
use App\Models\UserLog;
use Illuminate\Http\Request;
use App\Models\ChannelPartner;
use App\Models\UserNotification;
use App\Models\wlmst_appversion;
use App\Models\MarketingProductLog;
use Illuminate\Support\Facades\Auth;
use App\Models\Wlmst_ServiceExecutive;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Storage;
use App\Models\wlmst_user_created_board_log;
use App\Http\Controllers\Whatsapp\WhatsappApiContoller;


function successRes($msg = "Success", $statusCode = 200)
{
	$return = array();
	$return['status'] = 1; // 1=Success; 0=error; 2=appupdate
	$return['status_code'] = $statusCode;
	$return['msg'] = $msg;
	return $return;
}

function errorRes($msg = "Error", $statusCode = 400)
{

	$return = array();
	$return['status'] = 0; // 1=Success; 0=error; 2=appupdate
	$return['status_code'] = $statusCode;
	$return['msg'] = $msg;
	return $return;
}

function getSpacesFolder()
{
	// return $_SERVER['HTTP_HOST'];
	return "erp.whitelion.in";
}

function uploadFileOnSpaces($diskFilePath, $spaceFilePath)
{
	$spacesFolder = getSpacesFolder();
	return Storage::disk('spaces')->put($spacesFolder . "/" . $spaceFilePath, @file_get_contents($diskFilePath));
}

function getSpaceFilePath($filePath)
{
	$spacesFolder = getSpacesFolder();
	return "https://whitelion.sgp1.digitaloceanspaces.com/" . $spacesFolder . "" . $filePath;
}

function loadTextLimit($string, $limit)
{
	$string = htmlspecialchars_decode($string);
	if (strlen($string) > $limit) {
		return substr($string, 0, $limit - 3) . "...";
	} else {
		return $string;
	}
}

function randomString($stringType, $stringLenth)
{
	if ($stringType == "numeric") {
		$characters = '0123456789';
	} else if ($stringType == "alpha-numeric") {
		$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
	}
	$randstring = '';
	for ($i = 0; $i < $stringLenth; $i++) {

		$randstring .= $characters[rand(0, strlen($characters) - 1)];
	}
	return $randstring;
}

function websiteTimeZone()
{
	return "Asia/Kolkata";
}

function convertDateTime($GMTDateTime)
{

	$TIMEZONE = websiteTimeZone();
	try {

		// $GMTDateTime = str_replace("T", " ", $GMTDateTime);
		// $GMTDateTime = explode(".", $GMTDateTime);
		// $GMTDateTime = $GMTDateTime[0];
		// print_r($GMTDateTime);
		// die;

		$dt = new DateTime('@' . strtotime($GMTDateTime));
		$dt->setTimeZone(new DateTimeZone($TIMEZONE));
		return $dt->format('d/m/Y h:i A');
	} catch (Exception $e) {

		return $GMTDateTime;
	}
}

function convertDateAndTime($GMTDateTime, $type)
{

	$TIMEZONE = websiteTimeZone();
	try {

		$dt = new DateTime('@' . strtotime($GMTDateTime));
		$dt->setTimeZone(new DateTimeZone($TIMEZONE));
		if ($type == "date") {
			return $dt->format('d/m/Y');
		} else if ($type == "time") {
			return $dt->format('h:i A');
		}
	} catch (Exception $e) {

		return $GMTDateTime;
	}
}

function convertDateAndTimeMounth($GMTDateTime, $type)
{

	$TIMEZONE = websiteTimeZone();
	try {

		$dt = new DateTime('@' . strtotime($GMTDateTime));
		$dt->setTimeZone(new DateTimeZone($TIMEZONE));
		if ($type == "date") {
			return $dt->format('d M Y');
		} else if ($type == "time") {
			return $dt->format('h:i A');
		}
	} catch (Exception $e) {

		return $GMTDateTime;
	}
}

function convertDateAndTime2($GMTDateTime, $type)
{
	if ($type == "date") {
		return date('d M Y', strtotime($GMTDateTime));;
	} else if ($type == "time") {
		return date('h:i A', strtotime($GMTDateTime));;
	}
}

function convertOrderDateTime($GMTDateTime, $showType)
{

	$TIMEZONE = websiteTimeZone();
	try {

		$dt = new DateTime('@' . strtotime($GMTDateTime));
		$dt->setTimeZone(new DateTimeZone($TIMEZONE));

		if ($showType == "date") {
			return $dt->format('d M y');
		} else if ($showType == "time") {
			return $dt->format('h:i:s A');
		}
	} catch (Exception $e) {

		return $GMTDateTime;
	}
}

function saveLeadTimeline($params)
{

	$LeadTimeline = new LeadTimeline();
	$LeadTimeline->user_id = Auth::user()->id;
	$LeadTimeline->type = $params['type'];
	$LeadTimeline->lead_id = $params['lead_id'];
	$LeadTimeline->reffrance_id = $params['reffrance_id'];
	$LeadTimeline->description = $params['description'];
	$LeadTimeline->save();
}

function saveDebugLog($params)
{

	$DebugLog = new DebugLog();
	$DebugLog->user_id = Auth::user()->id;
	$DebugLog->name = $params['name'];
	$DebugLog->description = $params['description'];
	$DebugLog->save();
}

function saveProductLog($params)
{

	$DebugLog = new ProductLog();
	$DebugLog->product_inventory_id = $params['product_inventory_id'];
	$DebugLog->request_quantity = $params['request_quantity'];
	$DebugLog->quantity = $params['quantity'];
	//$DebugLog->user_id = 275;
	$DebugLog->user_id = Auth::user()->id;
	$DebugLog->name = $params['name'];
	$DebugLog->description = $params['description'];
	$DebugLog->save();
}

function saveMarketingProductLog($params)
{

	$DebugLog = new MarketingProductLog();
	$DebugLog->marketing_product_inventory_id = $params['marketing_product_inventory_id'];
	$DebugLog->request_quantity = $params['request_quantity'];
	$DebugLog->quantity = $params['quantity'];
	//$DebugLog->user_id = 275;
	$DebugLog->user_id = Auth::user()->id;
	$DebugLog->name = $params['name'];
	$DebugLog->description = $params['description'];
	$DebugLog->save();
}

function saveInquiryLog($params)
{

	$DebugLog = new InquiryLog();
	$DebugLog->inquiry_id = $params['inquiry_id'];
	$DebugLog->user_id = Auth::user()->id;
	$DebugLog->name = $params['name'];
	$DebugLog->description = $params['description'];
	$DebugLog->save();
}
function saveCRMUserLog($params)
{

	if (isset(Auth::user()->id) && Auth::user()->id != "") {

		$params['user_id'] = Auth::user()->id;
	}

	if (isset($params['inquiry_id'])) {

		$params['inquiry_id'] = $params['inquiry_id'];
	} else {
		$params['inquiry_id'] = 0;
	}

	if (isset($params['is_manually'])) {

		$params['is_manually'] = $params['is_manually'];
	} else {
		$params['is_manually'] = 0;
	}

	if (isset($params['points'])) {

		$params['points'] = $params['points'];
	} else {
		$params['points'] = 0;
	}

	if (isset($params['order_id'])) {

		$params['order_id'] = $params['order_id'];
	} else {
		$params['order_id'] = 0;
	}

	$DebugLog = new CRMLog();
	$DebugLog->user_id = $params['user_id'];
	$DebugLog->for_user_id = $params['for_user_id'];
	$DebugLog->inquiry_id = $params['inquiry_id'];
	$DebugLog->is_manually = $params['is_manually'];
	$DebugLog->points = $params['points'];
	$DebugLog->order_id = $params['order_id'];
	$DebugLog->name = $params['name'];
	$DebugLog->description = $params['description'];
	$DebugLog->save();
}

function getCityName($cityId)
{

	$CityListName = "";

	$CityList = CityList::select('name')->find($cityId);
	if ($CityList) {
		$CityListName = $CityList->name;
	}

	return $CityListName;
}

function getStateName($stateId)
{

	$StateListName = "";

	$StateList = StateList::select('name')->find($stateId);
	if ($StateList) {
		$StateListName = $StateList->name;
	}

	return $StateListName;
}

function getCountryName($stateId)
{

	$CountryListName = "";

	$CountryList = CountryList::select('name')->find($stateId);
	if ($CountryList) {
		$CountryListName = $CountryList->name;
	}

	return $CountryListName;
}

function priceLable($price)
{
	return number_format($price, 2);
}

function productFeatureList()
{

	$featureList = array();
	$featureList[1]['id'] = 1;
	$featureList[1]['code'] = "ON-OFF";
	$featureList[1]['display_name'] = "On/Off";

	$featureList[2]['id'] = 2;
	$featureList[2]['code'] = "FAN";
	$featureList[2]['display_name'] = "Fan";

	$featureList[3]['id'] = 3;
	$featureList[3]['code'] = "MASTER";
	$featureList[3]['display_name'] = "Master";

	$featureList[4]['id'] = 4;
	$featureList[4]['code'] = "CURTAIN";
	$featureList[4]['display_name'] = "Curtain";

	$featureList[5]['id'] = 5;
	$featureList[5]['code'] = "DIMMER";
	$featureList[5]['display_name'] = "Dimmer";

	$featureList[6]['id'] = 5;
	$featureList[6]['code'] = "BELL";
	$featureList[6]['display_name'] = "Bell";

	$featureList[7]['id'] = 5;
	$featureList[7]['code'] = "HL";
	$featureList[7]['display_name'] = "HL";

	return $featureList;
}

function getCRMStageOfSiteStatusLable($setting)
{

	$setting = (int) $setting;

	if ($setting == 0) {
		$setting = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($setting == 1) {
		$setting = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $setting;
}

function getCRMSiteTypeStatusLable($setting)
{

	$setting = (int) $setting;

	if ($setting == 0) {
		$setting = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($setting == 1) {
		$setting = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $setting;
}
function getCRMBHKStatusLable($setting)
{

	$setting = (int) $setting;

	if ($setting == 0) {
		$setting = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($setting == 1) {
		$setting = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $setting;
}
function getCRMWantToCoverStatusLable($setting)
{

	$setting = (int) $setting;

	if ($setting == 0) {
		$setting = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($setting == 1) {
		$setting = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $setting;
}

function getCRMSouceTypeStatusLable($setting)
{

	$setting = (int) $setting;

	if ($setting == 0) {
		$setting = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($setting == 1) {
		$setting = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $setting;
}

function getCRMCompetitorsStatusLable($setting)
{

	$setting = (int) $setting;

	if ($setting == 0) {
		$setting = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($setting == 1) {
		$setting = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $setting;
}

function getCRMSourceStatusLable($setting)
{

	$setting = (int) $setting;

	if ($setting == 0) {
		$setting = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($setting == 1) {
		$setting = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $setting;
}

function getCRMSSubStatusLable($setting)
{

	$setting = (int) $setting;

	if ($setting == 0) {
		$setting = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($setting == 1) {
		$setting = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $setting;
}

function getCRMContactTagLable($setting)
{

	$setting = (int) $setting;

	if ($setting == 0) {
		$setting = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($setting == 1) {
		$setting = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $setting;
}

function getGiftOrderLable($OrderStatus)
{
	// code...
	$OrderStatus = (int) $OrderStatus;

	if ($OrderStatus == 0) {
		$OrderStatus = '<span class="badge badge-pill badge badge-soft-warning font-size-11"> PLACED / ON REVIEW</span>';
	} else if ($OrderStatus == 1) {

		$OrderStatus = '<span class="badge badge-pill badge badge-soft-success font-size-11">  ACCEPTED</span>';
	} else if ($OrderStatus == 2) {

		$OrderStatus = '<span class="badge badge-pill badge badge-soft-success font-size-11">  DISPATCHED</span>';
	} else if ($OrderStatus == 3) {

		$OrderStatus = '<span class="badge badge-pill badge badge-soft-danger font-size-11">  REJECTED</span>';
	} else if ($OrderStatus == 4) {

		$OrderStatus = '<span class="badge badge-pill badge badge-soft-primary font-size-11">  DELIEVERED</span>';
	} else if ($OrderStatus == 5) {

		$OrderStatus = '<span class="badge badge-pill badge badge-soft-info font-size-11">  RECEIVED</span>';
	}

	return $OrderStatus;
}

function getOrderLable($OrderStatus)
{
	// code...
	$OrderStatus = (int) $OrderStatus;

	if ($OrderStatus == 0) {
		$OrderStatus = '<span class="badge badge-pill badge badge-soft-warning font-size-11"> PLACED</span>';
	} else if ($OrderStatus == 1) {

		$OrderStatus = '<span class="badge badge-pill badge badge-soft-info font-size-11"> PROCESSING</span>';
	} else if ($OrderStatus == 2) {

		$OrderStatus = '<span class="badge badge-pill badge badge-soft-orange font-size-11"> PARTIALLY DISPATCHED</span>';
	} else if ($OrderStatus == 3) {

		$OrderStatus = '<span class="badge badge-pill badge badge-soft-success font-size-11"> FULLY DISPATCHED</span>';
	} else if ($OrderStatus == 4) {

		$OrderStatus = '<span class="badge badge-pill badge badge-soft-danger font-size-11"> CANCELLED</span>';
	}
	return $OrderStatus;
}

function getOrderStatus($OrderStatus)
{
	// code...
	$OrderStatus = (int) $OrderStatus;

	if ($OrderStatus == 0) {
		$OrderStatus = 'PLACED';
	} else if ($OrderStatus == 1) {

		$OrderStatus = 'PROCESSING';
	} else if ($OrderStatus == 2) {

		$OrderStatus = 'PARTIALLY DISPATCHED';
	} else if ($OrderStatus == 3) {

		$OrderStatus = 'FULLY DISPATCHED';
	} else if ($OrderStatus == 4) {

		$OrderStatus = 'CANCELLED';
	}
	return $OrderStatus;
}

function getMarketingRequestStatus($MarketingRequestStatus)
{
	// code...
	$MarketingRequestStatus = (int) $MarketingRequestStatus;

	if ($MarketingRequestStatus == 0) {
		$MarketingRequestStatus = 'REQUESTED';
	} else if ($MarketingRequestStatus == 1) {

		$MarketingRequestStatus = 'APPROVED';
	} else if ($MarketingRequestStatus == 2) {

		$MarketingRequestStatus = 'PARTIALLY APPROVED';
	} else if ($MarketingRequestStatus == 3) {

		$MarketingRequestStatus = 'REJECTED';
	}
	return $MarketingRequestStatus;
}

function getMarketingRequestDelieveryChallanStatus($MarketingDelieveryChallanStatus)
{
	// code...
	$MarketingDelieveryChallanStatus = (int) $MarketingDelieveryChallanStatus;

	if ($MarketingDelieveryChallanStatus == 0) {
		$MarketingDelieveryChallanStatus = 'CHALLAN RAISED';
	} else if ($MarketingDelieveryChallanStatus == 1) {

		$MarketingDelieveryChallanStatus = 'PACKED';
	} else if ($MarketingDelieveryChallanStatus == 2) {

		$MarketingDelieveryChallanStatus = 'DISPATCHED';
	}
	return $MarketingDelieveryChallanStatus;
}

function getInvoiceLable($invoiceStatus)
{

	if ($invoiceStatus == 0) {
		$invoiceStatus = '<span class="badge badge-pill badge bg-primary font-size-11">INVOICE RAISED</span>';
	} else if ($invoiceStatus == 1) {

		$invoiceStatus = '<span class="badge badge-pill badge-soft-info font-size-11"> PACKED</span>';
	} else if ($invoiceStatus == 2) {

		$invoiceStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> DISPATCHED</span>';
	} else if ($invoiceStatus == 3) {

		$invoiceStatus = '<span class="badge badge-pill badge-soft-dark font-size-11"> RECIEVED</span>';
	} else if ($invoiceStatus == 4) {

		$invoiceStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> CANCELLED</span>';
	}
	return $invoiceStatus;
	// code...
}

function getInvoiceStatus($invoiceStatus)
{

	if ($invoiceStatus == 0) {
		$invoiceStatus = 'INVOICE RAISED';
	} else if ($invoiceStatus == 1) {

		$invoiceStatus = 'PACKED';
	} else if ($invoiceStatus == 2) {

		$invoiceStatus = 'DISPATCHED';
	} else if ($invoiceStatus == 3) {

		$invoiceStatus = 'RECIEVED';
	} else if ($invoiceStatus == 4) {

		$invoiceStatus = 'CANCELLED';
	}
	return $invoiceStatus;
	// code...
}

function getPaymentModeName($paymentMode)
{

	if ($paymentMode == 0) {
		$paymentMode = "PDC";
	} else if ($paymentMode == 1) {
		$paymentMode = "ADVANCE";
	} else if ($paymentMode == 2) {
		$paymentMode = "CREDIT";
	}
	return $paymentMode;
}

function getPaymentLable($paymentMode)
{

	if ($paymentMode == 0) {
		$paymentMode = '<span class="badge badge-pill badge-soft-danger font-size-11">PDC</span>';
	} else if ($paymentMode == 1) {

		$paymentMode = '<span class="badge badge-pill badge-soft-danger font-size-11"> ADVANCE</span>';
	} else if ($paymentMode == 2) {

		$paymentMode = '<span class="badge badge-pill badge-soft-success font-size-11"> CREDIT</span>';
	}
	return $paymentMode;
}

function getProductGroupLable($ProductGroupStatus)
{
	// code...
	$ProductGroupStatus = (int) $ProductGroupStatus;

	if ($ProductGroupStatus == 0) {
		$ProductGroupStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($ProductGroupStatus == 1) {
		$ProductGroupStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $ProductGroupStatus;
}

function getDataMasterStatusLable($dataMasterStatus)
{
	// code...
	$dataMasterStatus = (int) $dataMasterStatus;

	if ($dataMasterStatus == 0) {
		$dataMasterStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($dataMasterStatus == 1) {
		$dataMasterStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	} else if ($dataMasterStatus == 2) {
		$dataMasterStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';
	}
	return $dataMasterStatus;
}

function getMainMasterStatusLable($mainMasterStatus)
{
	$mainMasterStatus = (int) $mainMasterStatus;

	if ($mainMasterStatus == 0) {
		$mainMasterStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($mainMasterStatus == 1) {
		$mainMasterStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	} else if ($mainMasterStatus == 2) {
		$mainMasterStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';
	}
	return $mainMasterStatus;
}

function getExhibitionStatusLable($exhibitionStatus)
{
	$exhibitionStatus = (int) $exhibitionStatus;

	if ($exhibitionStatus == 0) {
		$exhibitionStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Completed</span>';
	} else if ($exhibitionStatus == 1) {
		$exhibitionStatus = '<span class="badge badge-pill badge-soft-success font-size-11">Live/Upcoming</span>';
	}
	return $exhibitionStatus;
}

function getSalesHierarchyStatusLable($salesHierarchyStatus)
{

	$salesHierarchyStatus = (int) $salesHierarchyStatus;

	if ($salesHierarchyStatus == 0) {
		$salesHierarchyStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($salesHierarchyStatus == 1) {
		$salesHierarchyStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	} else if ($salesHierarchyStatus == 2) {
		$salesHierarchyStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';
	}
	return $salesHierarchyStatus;
}

function getPurchaseHierarchyStatusLable($salesHierarchyStatus)
{

	$salesHierarchyStatus = (int) $salesHierarchyStatus;

	if ($salesHierarchyStatus == 0) {
		$salesHierarchyStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($salesHierarchyStatus == 1) {
		$salesHierarchyStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	} else if ($salesHierarchyStatus == 2) {
		$salesHierarchyStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';
	}
	return $salesHierarchyStatus;
}

function getCityStatusLable($cityStatus)
{

	$cityStatus = (int) $cityStatus;

	if ($cityStatus == 0) {
		$cityStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($cityStatus == 1) {
		$cityStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	} else if ($cityStatus == 2) {
		$cityStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';
	}
	return $cityStatus;
}

function getArchitectsStatus()
{
	$ArchitectsStatus = array();
	$ArchitectsStatus[2]['id'] = 2;
	$ArchitectsStatus[2]['name'] = "Pending";
	$ArchitectsStatus[2]['code'] = "Pending";
	$ArchitectsStatus[2]['header_code'] = "Entry";
	$ArchitectsStatus[2]['sequence_id'] = 1;
	$ArchitectsStatus[2]['access_user_type'] = array(0, 9);

	$ArchitectsStatus[4]['id'] = 4;
	$ArchitectsStatus[4]['name'] = "Approved";
	$ArchitectsStatus[4]['code'] = "Telecaller Approved";
	$ArchitectsStatus[4]['header_code'] = "Verified by Telecaller";
	$ArchitectsStatus[4]['sequence_id'] = 2;
	$ArchitectsStatus[4]['access_user_type'] = array(9);

	$ArchitectsStatus[1]['id'] = 1;
	$ArchitectsStatus[1]['name'] = "Approved";
	$ArchitectsStatus[1]['code'] = "HOD Approved";
	$ArchitectsStatus[1]['header_code'] = "On Boarded";
	$ArchitectsStatus[1]['sequence_id'] = 3;
	$ArchitectsStatus[1]['access_user_type'] = array(0);

	$ArchitectsStatus[0]['id'] = 0;
	$ArchitectsStatus[0]['name'] = "Reject";
	$ArchitectsStatus[0]['code'] = "Reject";
	$ArchitectsStatus[0]['header_code'] = "Rejected";
	$ArchitectsStatus[0]['sequence_id'] = 4;
	$ArchitectsStatus[0]['access_user_type'] = array(0, 9);

	$ArchitectsStatus[3]['id'] = 3;
	$ArchitectsStatus[3]['name'] = "Data Mismatch";
	$ArchitectsStatus[3]['code'] = "Data Mismatch";
	$ArchitectsStatus[3]['header_code'] = "Data Mismatch";
	$ArchitectsStatus[3]['sequence_id'] = 5;
	$ArchitectsStatus[3]['access_user_type'] = array(0, 9);


	return $ArchitectsStatus;
}

function getElectricianStatus()
{
	$ArchitectsStatus = array();
	$ArchitectsStatus[2]['id'] = 2;
	$ArchitectsStatus[2]['name'] = "Pending";
	$ArchitectsStatus[2]['code'] = "Pending";
	$ArchitectsStatus[2]['header_code'] = "Entry";
	$ArchitectsStatus[2]['sequence_id'] = 1;
	$ArchitectsStatus[2]['access_user_type'] = array(0, 9);

	$ArchitectsStatus[4]['id'] = 4;
	$ArchitectsStatus[4]['name'] = "Approved";
	$ArchitectsStatus[4]['code'] = "Telecaller Approved";
	$ArchitectsStatus[4]['header_code'] = "Verified by Telecaller";
	$ArchitectsStatus[4]['sequence_id'] = 2;
	$ArchitectsStatus[4]['access_user_type'] = array(9);

	$ArchitectsStatus[1]['id'] = 1;
	$ArchitectsStatus[1]['name'] = "Approved";
	$ArchitectsStatus[1]['code'] = "HOD Approved";
	$ArchitectsStatus[1]['header_code'] = "On Boarded";
	$ArchitectsStatus[1]['sequence_id'] = 3;
	$ArchitectsStatus[1]['access_user_type'] = array(0);

	$ArchitectsStatus[0]['id'] = 0;
	$ArchitectsStatus[0]['name'] = "Reject";
	$ArchitectsStatus[0]['code'] = "Reject";
	$ArchitectsStatus[0]['header_code'] = "Rejected";
	$ArchitectsStatus[0]['sequence_id'] = 4;
	$ArchitectsStatus[0]['access_user_type'] = array(0, 9);

	$ArchitectsStatus[3]['id'] = 3;
	$ArchitectsStatus[3]['name'] = "Data Mismatch";
	$ArchitectsStatus[3]['code'] = "Data Mismatch";
	$ArchitectsStatus[3]['header_code'] = "Data Mismatch";
	$ArchitectsStatus[3]['sequence_id'] = 5;
	$ArchitectsStatus[3]['access_user_type'] = array(0, 9);


	return $ArchitectsStatus;
}

function getArchitectsStatusLable($architectsStatus)
{
	$architectsStatus = (int) $architectsStatus;
	if ($architectsStatus == 0) {
		$architectsStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Rejected</span>';
	} else if ($architectsStatus == 1) {
		$architectsStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> On Borded</span>';
	} else if ($architectsStatus == 2) {
		$architectsStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Entry</span>';
	} else if ($architectsStatus == 3) {
		$architectsStatus = '<span class="badge badge-pill badge-soft-danger font-size-11">Data Mismatch</span>';
	} else if ($architectsStatus == 4) {
		$architectsStatus = '<span class="badge badge-pill badge-soft-danger font-size-11">Verified by Telecaller</span>';
	}
	return $architectsStatus;
}

function getElectricianStatusStatusLable($architectsStatus)
{
	$architectsStatus = (int) $architectsStatus;
	if ($architectsStatus == 0) {
		$architectsStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Rejected</span>';
	} else if ($architectsStatus == 1) {
		$architectsStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> On Borded</span>';
	} else if ($architectsStatus == 2) {
		$architectsStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Entry</span>';
	} else if ($architectsStatus == 3) {
		$architectsStatus = '<span class="badge badge-pill badge-soft-danger font-size-11">Data Mismatch</span>';
	} else if ($architectsStatus == 4) {
		$architectsStatus = '<span class="badge badge-pill badge-soft-danger font-size-11">Verified by Telecaller</span>';
	}
	return $architectsStatus;
}
// function getArchitectsStatusLable($architectsStatus)
// {
// 	$architectsStatus = (int) $architectsStatus;
// 	if ($architectsStatus == 0) {
// 		$architectsStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Rejected</span>';
// 	} else if ($architectsStatus == 1) {
// 		$architectsStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> On Borded</span>';
// 	} else if ($architectsStatus == 2) {
// 		$architectsStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Entry</span>';
// 	} else if ($architectsStatus == 3) {
// 		$architectsStatus = '<span class="badge badge-pill badge-soft-danger font-size-11">Data Mismatch</span>';
// 	} else if ($architectsStatus == 4) {
// 		$architectsStatus = '<span class="badge badge-pill badge-soft-danger font-size-11">Verified by Telecaller</span>';
// 	}
// 	return $architectsStatus;
// }

function getUserStatusLable($userStatus)
{

	$userStatus = (int) $userStatus;
	if ($userStatus == 0) {
		$userStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($userStatus == 1) {
		$userStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	} else if ($userStatus == 2) {
		$userStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Pending</span>';
	}
	return $userStatus;
}

function getUserStatus($userStatus)
{

	$userStatus = (int) $userStatus;
	if ($userStatus == 0) {
		$userStatus = 'Inactive';
	} else if ($userStatus == 1) {
		$userStatus = 'Active';
	} else if ($userStatus == 2) {
		$userStatus = 'Pending';
	}
	return $userStatus;
}

function getCompanyStatusLable($companyStatus)
{

	$companyStatus = (int) $companyStatus;
	if ($companyStatus == 0) {
		$companyStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($companyStatus == 1) {
		$companyStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	} else if ($companyStatus == 2) {
		$companyStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';
	}
	return $companyStatus;
}

function getGiftCategoryStatusLable($GiftCategoryStatus)
{

	$GiftCategoryStatus = (int) $GiftCategoryStatus;
	if ($GiftCategoryStatus == 0) {
		$GiftCategoryStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($GiftCategoryStatus == 1) {
		$GiftCategoryStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $GiftCategoryStatus;
}

function getGiftProductStatusLable($GiftCategoryStatus)
{

	$GiftCategoryStatus = (int) $GiftCategoryStatus;
	if ($GiftCategoryStatus == 0) {
		$GiftCategoryStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($GiftCategoryStatus == 1) {
		$GiftCategoryStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $GiftCategoryStatus;
}

function getCRMHelpDocumentStatusLable($HelpDocumentStatus)
{

	$HelpDocumentStatus = (int) $HelpDocumentStatus;
	if ($HelpDocumentStatus == 0) {
		$HelpDocumentStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($HelpDocumentStatus == 1) {
		$HelpDocumentStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	}
	return $HelpDocumentStatus;
	// code...
}

/////

function getUserTypes()
{

	$userTypes = array();
	$userTypes[0]['id'] = 0;
	$userTypes[0]['name'] = "Admin";
	$userTypes[0]['short_name'] = "ADMIN";
	$userTypes[0]['lable'] = "user-admin";
	$userTypes[0]['key'] = "t-user-admin";
	$userTypes[0]['can_login'] = 1;

	$userTypes[1]['id'] = 1;
	$userTypes[1]['name'] = "Company Admin";
	$userTypes[1]['short_name'] = "COMPANY ADMIN";
	$userTypes[1]['lable'] = "user-company-admin";
	$userTypes[1]['key'] = "t-user-company-admin";
	$userTypes[1]['can_login'] = 1;

	$userTypes[2]['id'] = 2;
	$userTypes[2]['name'] = "Sales user";
	$userTypes[2]['short_name'] = "SALES USER";
	$userTypes[2]['lable'] = "sales-admin";
	$userTypes[2]['key'] = "t-sales-user";
	$userTypes[2]['can_login'] = 1;

	return $userTypes;
}


function getChannelPartners()
{
	$userTypes = array();
	$userTypes[101]['id'] = 101;
	$userTypes[101]['name'] = "ASM(Autorise Stockist Merchantize)";
	$userTypes[101]['lable'] = "channel-partner-asm";
	$userTypes[101]['short_name'] = "ASM";
	$userTypes[101]['key'] = "t-channel-partner-stockist";
	// $userTypes[101]['url'] = route('channel.partners.stockist');
	// $userTypes[101]['url_view'] = route('channel.partners.stockist.view');
	// $userTypes[101]['url_sub_orders'] = route('orders.sub.asm');
	$userTypes[101]['can_login'] = 1;
	$userTypes[101]['inquiry_tab'] = 1;

	$userTypes[102]['id'] = 102;
	$userTypes[102]['name'] = "ADM(Authorize Distributor Merchantize)";
	$userTypes[102]['lable'] = "channel-partner-adm";
	$userTypes[102]['short_name'] = "ADM";
	$userTypes[102]['key'] = "t-channel-partner-adm";
	// $userTypes[102]['url'] = route('channel.partners.adm');
	// $userTypes[102]['url_view'] = route('channel.partners.adm.view');
	// $userTypes[102]['url_sub_orders'] = route('orders.sub.adm');
	$userTypes[102]['can_login'] = 1;
	$userTypes[102]['inquiry_tab'] = 1;

	$userTypes[103]['id'] = 103;
	$userTypes[103]['name'] = "APM(Authorize Project Merchantize)";
	$userTypes[103]['lable'] = "channel-partner-apm";
	$userTypes[103]['short_name'] = "APM";
	$userTypes[103]['key'] = "t-channel-partner-apm";
	// $userTypes[103]['url'] = route('channel.partners.apm');
	// $userTypes[103]['url_view'] = route('channel.partners.apm.view');
	// $userTypes[103]['url_sub_orders'] = route('orders.sub.apm');
	$userTypes[103]['can_login'] = 1;
	$userTypes[103]['inquiry_tab'] = 1;

	$userTypes[104]['id'] = 104;
	$userTypes[104]['name'] = "AD(Authorised Dealer)";
	$userTypes[104]['lable'] = "channel-partner-ad";
	$userTypes[104]['short_name'] = "AD";
	$userTypes[104]['key'] = "t-channel-partner-ad";
	// $userTypes[104]['url'] = route('channel.partners.ad');
	// $userTypes[104]['url_view'] = route('channel.partners.ad.view');
	// $userTypes[104]['url_sub_orders'] = route('orders.sub.ad');
	$userTypes[104]['can_login'] = 1;
	$userTypes[104]['inquiry_tab'] = 1;

	$userTypes[105]['id'] = 105;
	$userTypes[105]['name'] = "Retailer";
	$userTypes[105]['lable'] = "channel-partner-retailer";
	$userTypes[105]['short_name'] = "Retailer";
	$userTypes[105]['key'] = "t-channel-partner-retailer";
	// $userTypes[105]['url'] = route('channel.partners.retailer');
	// $userTypes[105]['url_view'] = route('channel.partners.retailer.view');
	// $userTypes[105]['url_sub_orders'] = route('orders.sub.retailer');
	$userTypes[105]['can_login'] = 1;
	$userTypes[105]['inquiry_tab'] = 1;

	return $userTypes;
}

function getArchitects()
{

	$userTypes = array();
	$userTypes[201]['id'] = 201;
	$userTypes[201]['name'] = "Architect(Non Prime)";
	$userTypes[201]['lable'] = "architect-non-prime";
	$userTypes[201]['short_name'] = "NON PRIME";
	$userTypes[201]['another_name'] = "ARCHITECH";
	// $userTypes[201]['url'] = route('architects.prime');
	//$userTypes[201]['url'] = route('architects.non.prime');
	$userTypes[201]['can_login'] = 0;

	$userTypes[202]['id'] = 202;
	$userTypes[202]['name'] = "Architect(Prime)";
	$userTypes[202]['lable'] = "architect-prime";
	$userTypes[202]['short_name'] = "PRIME";
	$userTypes[202]['another_name'] = "ARCHITECH";
	// $userTypes[202]['url'] = route('architects.prime');
	$userTypes[202]['can_login'] = 1;

	return $userTypes;
}

function getElectricians()
{

	$userTypes = array();
	$userTypes[301]['id'] = 301;
	$userTypes[301]['name'] = "Electrician(Non Prime)";
	$userTypes[301]['lable'] = "electrician-non-prime";
	$userTypes[301]['short_name'] = "NON PRIME";
	$userTypes[301]['another_name'] = "ELECTRICIAN";
	//$userTypes[301]['url'] = route('electricians.non.prime');
	// $userTypes[301]['url'] = route('electricians.prime');
	$userTypes[301]['can_login'] = 0;

	$userTypes[302]['id'] = 302;
	$userTypes[302]['name'] = "Electrician(Prime)";
	$userTypes[302]['lable'] = "electrician-prime";
	$userTypes[302]['short_name'] = "PRIME";
	$userTypes[302]['another_name'] = "ELECTRICIAN";
	// $userTypes[302]['url'] = route('electricians.prime');
	$userTypes[302]['can_login'] = 1;

	return $userTypes;
}

function CRMUserType()
{

	$userTypes = array();

	$userTypes[202]['id'] = 202;
	$userTypes[202]['name'] = "Architect(Prime)";
	$userTypes[202]['lable'] = "architect-prime";
	$userTypes[202]['short_name'] = "PRIME";
	$userTypes[202]['another_name'] = "ARCHITECH";

	$userTypes[302]['can_login'] = 1;
	$userTypes[302]['id'] = 302;
	$userTypes[302]['name'] = "Electrician(Prime)";
	$userTypes[302]['lable'] = "electrician-prime";
	$userTypes[302]['short_name'] = "PRIME";
	$userTypes[302]['another_name'] = "ELECTRICIAN";

	return $userTypes;
}

function getCustomers()
{

	$userTypes = array();
	$userTypes[10000]['id'] = 10000;
	$userTypes[10000]['name'] = "User";
	$userTypes[10000]['lable'] = "user";
	$userTypes[10000]['short_name'] = "USER";
	$userTypes[10000]['another_name'] = "USER";
	$userTypes[10000]['can_login'] = 0;
	return $userTypes;
}

function getInquiryStatus()
{

	//Inquiry status type
	$inquiryStatus = array();
	$inquiryStatus[202]['id'] = 202;
	$inquiryStatus[202]['name'] = "Focus";
	$inquiryStatus[202]['key'] = "t-inquiry-focus";
	$inquiryStatus[202]['for_architect_ids'] = array(0);
	$inquiryStatus[202]['for_electrician_ids'] = array(0);
	$inquiryStatus[202]['for_user_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[202]['for_third_party_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[202]['for_sales_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[202]['for_tele_sales_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[202]['for_channel_partner_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[202]['can_move_user'] = array();
	$inquiryStatus[202]['can_move_third_party'] = array();
	$inquiryStatus[202]['can_move_sales'] = array();
	$inquiryStatus[202]['can_move_tele_sales'] = array();
	$inquiryStatus[202]['can_move_channel_partner'] = array();
	$inquiryStatus[202]['only_id_question'] = 0;
	$inquiryStatus[202]['need_followup'] = 0;
	$inquiryStatus[202]['has_question'] = 0;
	$inquiryStatus[202]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[202]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[202]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[202]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[202]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[202]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[202]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[202]['background'] = "#0d0d0d";
	$inquiryStatus[202]['color'] = "#ffffff";
	$inquiryStatus[202]['index'] = -1;

	$inquiryStatus[201]['id'] = 201;
	$inquiryStatus[201]['name'] = "Running";
	$inquiryStatus[201]['key'] = "t-inquiry-running";
	$inquiryStatus[201]['for_architect_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[201]['for_electrician_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[201]['for_user_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[201]['for_third_party_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[201]['for_sales_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[201]['for_tele_sales_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[201]['for_channel_partner_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[201]['can_move_user'] = array();
	$inquiryStatus[201]['can_move_third_party'] = array();
	$inquiryStatus[201]['can_move_sales'] = array();
	$inquiryStatus[201]['can_move_tele_sales'] = array();
	$inquiryStatus[201]['can_move_channel_partner'] = array();
	$inquiryStatus[201]['only_id_question'] = 0;
	$inquiryStatus[201]['need_followup'] = 0;
	$inquiryStatus[201]['has_question'] = 0;
	$inquiryStatus[201]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[201]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[201]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[201]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[201]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[201]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[201]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[201]['background'] = "#0d0d0d";
	$inquiryStatus[201]['color'] = "#ffffff";
	$inquiryStatus[201]['index'] = 0;

	$inquiryStatus[1]['id'] = 1;
	$inquiryStatus[1]['name'] = "Inquiry";
	$inquiryStatus[1]['key'] = "t-inquiry";
	$inquiryStatus[1]['for_architect_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[1]['for_electrician_ids'] = array(1, 42, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[1]['for_user_ids'] = array(1);
	$inquiryStatus[1]['for_third_party_ids'] = array(1);
	$inquiryStatus[1]['for_sales_ids'] = array(1);
	$inquiryStatus[1]['for_tele_sales_ids'] = array(1);
	$inquiryStatus[1]['for_channel_partner_ids'] = array(1);
	$inquiryStatus[1]['can_move_user'] = array(1, 2, 3, 4, 5, 6, 7, 13, 9, 10, 102);
	$inquiryStatus[1]['can_move_third_party'] = array(1, 2, 3, 4, 5, 6, 7, 13, 9, 10, 102);
	$inquiryStatus[1]['can_move_sales'] = array(1, 2, 3, 4, 5, 6, 7, 13, 9, 102);
	$inquiryStatus[1]['can_move_tele_sales'] = array(1, 2, 3, 4, 5, 6, 7, 13, 9, 102);
	$inquiryStatus[1]['can_move_channel_partner'] = array(1, 2, 3, 4, 5, 6, 7, 13, 9, 102);
	$inquiryStatus[1]['only_id_question'] = 0;
	$inquiryStatus[1]['need_followup'] = 1;
	$inquiryStatus[1]['has_question'] = 0;
	$inquiryStatus[1]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[1]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[1]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[1]['can_display_on_inquiry_architect'] = 1;
	$inquiryStatus[1]['can_display_on_inquiry_electrician'] = 1;
	$inquiryStatus[1]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[1]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[1]['background'] = "#0d0d0d";
	$inquiryStatus[1]['color'] = "#ffffff";
	$inquiryStatus[1]['highlight_deadend_followup'] = 1;
	$inquiryStatus[1]['index'] = 1;

	$inquiryStatus[2]['id'] = 2;
	$inquiryStatus[2]['name'] = "Potential Inquiry";
	$inquiryStatus[2]['key'] = "t-potential-inquiry";
	$inquiryStatus[2]['for_architect_ids'] = array(2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[2]['for_electrician_ids'] = array(2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[2]['for_user_ids'] = array(2);
	$inquiryStatus[2]['for_third_party_ids'] = array(2);
	$inquiryStatus[2]['for_sales_ids'] = array(2);
	$inquiryStatus[2]['for_tele_sales_ids'] = array(2);
	$inquiryStatus[2]['for_channel_partner_ids'] = array(2);
	$inquiryStatus[2]['can_move_user'] = array(2, 3, 4, 5, 6, 7, 13, 9, 10, 102);
	$inquiryStatus[2]['can_move_third_party'] = array(2, 3, 4, 5, 6, 7, 9, 10, 102);
	$inquiryStatus[2]['can_move_sales'] = array(2, 3, 4, 5, 6, 7, 13, 9, 102);
	$inquiryStatus[2]['can_move_tele_sales'] = array(2, 3, 4, 5, 6, 7, 13, 9, 102);
	$inquiryStatus[2]['can_move_channel_partner'] = array(2, 3, 4, 5, 6, 7, 13, 9, 102);
	$inquiryStatus[2]['only_id_question'] = 0;
	$inquiryStatus[2]['need_followup'] = 1;
	$inquiryStatus[2]['has_question'] = 1;
	$inquiryStatus[2]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[2]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[2]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[2]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[2]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[2]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[2]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[2]['background'] = "#f19e06";
	$inquiryStatus[2]['color'] = "#ffffff";
	$inquiryStatus[2]['highlight_deadend_followup'] = 1;
	$inquiryStatus[2]['index'] = 2;

	$inquiryStatus[3]['id'] = 3;
	$inquiryStatus[3]['name'] = "Demo Done";
	$inquiryStatus[3]['key'] = "t-demo-done";
	$inquiryStatus[3]['for_architect_ids'] = array(2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[3]['for_electrician_ids'] = array(2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[3]['for_user_ids'] = array(3);
	$inquiryStatus[3]['for_third_party_ids'] = array(3);
	$inquiryStatus[3]['for_sales_ids'] = array(3);
	$inquiryStatus[3]['for_tele_sales_ids'] = array(3);
	$inquiryStatus[3]['for_channel_partner_ids'] = array(3);
	$inquiryStatus[3]['can_move_user'] = array(3, 4, 5, 6, 7, 13, 9, 10, 102);
	$inquiryStatus[3]['can_move_third_party'] = array(3, 4, 5, 6, 7, 13, 9, 10, 102);
	$inquiryStatus[3]['can_move_sales'] = array(3, 4, 5, 6, 7, 13, 9, 102);
	$inquiryStatus[3]['can_move_tele_sales'] = array(3, 4, 5, 6, 7, 13, 9, 102);
	$inquiryStatus[3]['can_move_channel_partner'] = array(3, 4, 5, 6, 7, 13, 9, 102);
	$inquiryStatus[3]['only_id_question'] = 0;
	$inquiryStatus[3]['need_followup'] = 1;
	$inquiryStatus[3]['has_question'] = 1;
	$inquiryStatus[3]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[3]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[3]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[3]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[3]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[3]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[3]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[3]['background'] = "#f5b3be";
	$inquiryStatus[3]['color'] = "#ffffff";
	$inquiryStatus[3]['highlight_deadend_followup'] = 1;
	$inquiryStatus[3]['index'] = 3;

	$inquiryStatus[4]['id'] = 4;
	$inquiryStatus[4]['name'] = "Site Visit";
	$inquiryStatus[4]['key'] = "t-site-visit";
	$inquiryStatus[4]['for_architect_ids'] = array(0);
	$inquiryStatus[4]['for_electrician_ids'] = array(0);
	$inquiryStatus[4]['for_user_ids'] = array(4);
	$inquiryStatus[4]['for_third_party_ids'] = array(4);
	$inquiryStatus[4]['for_sales_ids'] = array(4);
	$inquiryStatus[4]['for_tele_sales_ids'] = array(4);
	$inquiryStatus[4]['for_channel_partner_ids'] = array(4);
	$inquiryStatus[4]['can_move_user'] = array(4, 5, 6, 7, 13, 9, 10, 102);
	$inquiryStatus[4]['can_move_third_party'] = array(4, 5, 6, 7, 13, 9, 10, 102);
	$inquiryStatus[4]['can_move_sales'] = array(4, 5, 6, 7, 13, 9, 101);
	$inquiryStatus[4]['can_move_tele_sales'] = array(4, 5, 6, 7, 13, 9, 102);
	$inquiryStatus[4]['can_move_channel_partner'] = array(4, 5, 6, 7, 13, 9, 102);
	$inquiryStatus[4]['only_id_question'] = 0;
	$inquiryStatus[4]['need_followup'] = 1;
	$inquiryStatus[4]['has_question'] = 1;
	$inquiryStatus[4]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[4]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[4]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[4]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[4]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[4]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[4]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[4]['background'] = "#b12d2d";
	$inquiryStatus[4]['color'] = "#ffffff";
	$inquiryStatus[4]['highlight_deadend_followup'] = 1;
	$inquiryStatus[4]['index'] = 4;

	$inquiryStatus[5]['id'] = 5;
	$inquiryStatus[5]['name'] = "Quotation";
	$inquiryStatus[5]['key'] = "t-quotation";
	$inquiryStatus[5]['for_architect_ids'] = array(0);
	$inquiryStatus[5]['for_electrician_ids'] = array(0);
	$inquiryStatus[5]['for_user_ids'] = array(5);
	$inquiryStatus[5]['for_third_party_ids'] = array(5);
	$inquiryStatus[5]['for_sales_ids'] = array(5);
	$inquiryStatus[5]['for_tele_sales_ids'] = array(5);
	$inquiryStatus[5]['for_channel_partner_ids'] = array(5);
	$inquiryStatus[5]['can_move_user'] = array(5, 6, 7, 13, 9, 10, 102);
	$inquiryStatus[5]['can_move_third_party'] = array(5, 6, 7, 13, 9, 10, 102);
	$inquiryStatus[5]['can_move_sales'] = array(5, 6, 7, 13, 9, 102);
	$inquiryStatus[5]['can_move_tele_sales'] = array(5, 6, 7, 13, 9, 102);
	$inquiryStatus[5]['can_move_channel_partner'] = array(5, 6, 7, 13, 9, 102);
	$inquiryStatus[5]['only_id_question'] = 0;
	$inquiryStatus[5]['need_followup'] = 1;
	$inquiryStatus[5]['has_question'] = 1;
	$inquiryStatus[5]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[5]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[5]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[5]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[5]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[5]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[5]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[5]['background'] = "#750375";
	$inquiryStatus[5]['color'] = "#ffffff";
	$inquiryStatus[5]['highlight_deadend_followup'] = 1;
	$inquiryStatus[5]['index'] = 5;

	$inquiryStatus[6]['id'] = 6;
	$inquiryStatus[6]['name'] = "Negotiation";
	$inquiryStatus[6]['key'] = "t-negotiation";
	$inquiryStatus[6]['for_architect_ids'] = array(0);
	$inquiryStatus[6]['for_electrician_ids'] = array(0);
	$inquiryStatus[6]['for_user_ids'] = array(6);
	$inquiryStatus[6]['for_third_party_ids'] = array(6);
	$inquiryStatus[6]['for_sales_ids'] = array(6);
	$inquiryStatus[6]['for_tele_sales_ids'] = array(6);
	$inquiryStatus[6]['for_channel_partner_ids'] = array(6);
	$inquiryStatus[6]['can_move_user'] = array(6, 7, 13, 9, 10, 102);
	$inquiryStatus[6]['can_move_third_party'] = array(6, 7, 13, 9, 10, 102);
	$inquiryStatus[6]['can_move_sales'] = array(6, 7, 13, 9, 102);
	$inquiryStatus[6]['can_move_tele_sales'] = array(6, 7, 13, 9, 102);
	$inquiryStatus[6]['can_move_channel_partner'] = array(6, 7, 13, 9, 102);
	$inquiryStatus[6]['only_id_question'] = 0;
	$inquiryStatus[6]['need_followup'] = 1;
	$inquiryStatus[6]['has_question'] = 1;
	$inquiryStatus[6]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[6]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[6]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[6]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[6]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[6]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[6]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[6]['background'] = "#e70e0e";
	$inquiryStatus[6]['color'] = "#ffffff";
	$inquiryStatus[6]['highlight_deadend_followup'] = 1;
	$inquiryStatus[6]['index'] = 6;

	$inquiryStatus[7]['id'] = 7;
	$inquiryStatus[7]['name'] = "Token Received";
	$inquiryStatus[7]['key'] = "t-token-received";
	$inquiryStatus[7]['for_architect_ids'] = array(0);
	$inquiryStatus[7]['for_electrician_ids'] = array(0);
	$inquiryStatus[7]['for_user_ids'] = array(7);
	$inquiryStatus[7]['for_third_party_ids'] = array(7);
	$inquiryStatus[7]['for_sales_ids'] = array(7);
	$inquiryStatus[7]['for_tele_sales_ids'] = array(7);
	$inquiryStatus[7]['for_channel_partner_ids'] = array(7);
	$inquiryStatus[7]['can_move_user'] = array(7, 13, 9, 10, 102);
	$inquiryStatus[7]['can_move_third_party'] = array(7, 13, 9, 10, 102);
	$inquiryStatus[7]['can_move_sales'] = array(7, 13, 9, 102);
	$inquiryStatus[7]['can_move_tele_sales'] = array(7, 13, 9, 102);
	$inquiryStatus[7]['can_move_channel_partner'] = array(7, 13, 9, 102);
	$inquiryStatus[7]['only_id_question'] = 0;
	$inquiryStatus[7]['need_followup'] = 1;
	$inquiryStatus[7]['has_question'] = 1;
	$inquiryStatus[7]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[7]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[7]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[7]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[7]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[7]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[7]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[7]['background'] = "#418107";
	$inquiryStatus[7]['color'] = "#ffffff";
	$inquiryStatus[7]['highlight_deadend_followup'] = 1;
	$inquiryStatus[7]['index'] = 7;

	$inquiryStatus[8]['id'] = 8;
	$inquiryStatus[8]['name'] = "Prediction";
	$inquiryStatus[8]['key'] = "t-predication";
	$inquiryStatus[8]['for_architect_ids'] = array(0);
	$inquiryStatus[8]['for_electrician_ids'] = array(0);
	$inquiryStatus[8]['for_user_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[8]['for_third_party_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[8]['for_sales_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[8]['for_tele_sales_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[8]['for_channel_partner_ids'] = array(1, 2, 3, 4, 5, 6, 7, 8);
	$inquiryStatus[8]['can_move_user'] = array(8, 9, 10, 102);
	$inquiryStatus[8]['can_move_third_party'] = array(8, 9, 10, 102);
	$inquiryStatus[8]['can_move_sales'] = array(8, 9, 102);
	$inquiryStatus[8]['can_move_tele_sales'] = array(8, 9, 102);
	$inquiryStatus[8]['can_move_channel_partner'] = array(8, 9, 102);
	$inquiryStatus[8]['only_id_question'] = 0;
	$inquiryStatus[8]['need_followup'] = 1;
	$inquiryStatus[8]['has_question'] = 1;
	$inquiryStatus[8]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[8]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[8]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[8]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[8]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[8]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[8]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[8]['background'] = "#e70e0e";
	$inquiryStatus[8]['color'] = "#ffffff";
	$inquiryStatus[8]['highlight_deadend_followup'] = 1;
	$inquiryStatus[8]['index'] = 8;

	$inquiryStatus[13]['id'] = 13;
	$inquiryStatus[13]['name'] = "Material Ordered";
	$inquiryStatus[13]['key'] = "t-lapsed";
	$inquiryStatus[13]['for_architect_ids'] = array(13);
	$inquiryStatus[13]['for_electrician_ids'] = array(13);
	$inquiryStatus[13]['for_user_ids'] = array(13);
	$inquiryStatus[13]['for_third_party_ids'] = array(13);
	$inquiryStatus[13]['for_sales_ids'] = array(13);
	$inquiryStatus[13]['for_tele_sales_ids'] = array(13);
	$inquiryStatus[13]['for_channel_partner_ids'] = array(12);
	$inquiryStatus[13]['can_move_user'] = array(13, 9, 10, 102);
	$inquiryStatus[13]['can_move_third_party'] = array(13, 9, 10, 102);
	$inquiryStatus[13]['can_move_sales'] = array(13, 9, 10, 102);
	$inquiryStatus[13]['can_move_tele_sales'] = array(13, 9, 10, 102);
	$inquiryStatus[13]['can_move_channel_partner'] = array(13, 9, 10, 102);
	$inquiryStatus[13]['only_id_question'] = 0;
	$inquiryStatus[13]['need_followup'] = 1;
	$inquiryStatus[13]['has_question'] = 1;
	$inquiryStatus[13]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[13]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[13]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[13]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[13]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[13]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[13]['can_display_on_inquiry_channel_partner'] = 0;
	$inquiryStatus[13]['background'] = "#e70e0e";
	$inquiryStatus[13]['color'] = "#ffffff";
	$inquiryStatus[13]['highlight_deadend_followup'] = 0;
	$inquiryStatus[13]['index'] = 9;

	$inquiryStatus[9]['id'] = 9;
	$inquiryStatus[9]['name'] = "Material Sent";
	$inquiryStatus[9]['key'] = "t-material-sent";
	$inquiryStatus[9]['for_architect_ids'] = array(9, 11, 10);
	$inquiryStatus[9]['for_electrician_ids'] = array(9, 11, 10);
	$inquiryStatus[9]['for_user_ids'] = array(9, 11, 10);
	$inquiryStatus[9]['for_third_party_ids'] = array(9, 11, 10);
	$inquiryStatus[9]['for_sales_ids'] = array(9, 11, 10);
	$inquiryStatus[9]['for_tele_sales_ids'] = array(9, 11, 10);
	$inquiryStatus[9]['for_channel_partner_ids'] = array(9, 11, 10);
	$inquiryStatus[9]['can_move_user'] = array(9, 10, 12, 14, 102);
	$inquiryStatus[9]['can_move_third_party'] = array(9, 10, 12, 14, 102);
	$inquiryStatus[9]['can_move_sales'] = array(9, 12, 102);
	$inquiryStatus[9]['can_move_tele_sales'] = array(9, 12, 102);
	$inquiryStatus[9]['can_move_channel_partner'] = array(9, 102);
	$inquiryStatus[9]['only_id_question'] = 0;
	$inquiryStatus[9]['need_followup'] = 0;
	$inquiryStatus[9]['has_question'] = 1;
	$inquiryStatus[9]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[9]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[9]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[9]['can_display_on_inquiry_architect'] = 1;
	$inquiryStatus[9]['can_display_on_inquiry_electrician'] = 1;
	$inquiryStatus[9]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[9]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[9]['background'] = "#e70e0e";
	$inquiryStatus[9]['color'] = "#ffffff";
	$inquiryStatus[9]['highlight_deadend_followup'] = 0;
	$inquiryStatus[9]['index'] = 10;

	$inquiryStatus[11]['id'] = 11;
	$inquiryStatus[11]['name'] = "Direct Material Sent";
	$inquiryStatus[11]['key'] = "t-direct-material-sent";
	$inquiryStatus[11]['for_architect_ids'] = array(9, 10);
	$inquiryStatus[11]['for_electrician_ids'] = array(9, 10);
	$inquiryStatus[11]['for_user_ids'] = array(10);
	$inquiryStatus[11]['for_third_party_ids'] = array(10);
	$inquiryStatus[11]['for_sales_ids'] = array(10);
	$inquiryStatus[11]['for_tele_sales_ids'] = array(10);
	$inquiryStatus[11]['for_channel_partner_ids'] = array(10);
	$inquiryStatus[11]['can_move_user'] = array(11, 10, 102);
	$inquiryStatus[11]['can_move_third_party'] = array(11, 10, 102);
	$inquiryStatus[11]['can_move_sales'] = array(11, 102);
	$inquiryStatus[11]['can_move_tele_sales'] = array(11, 102);
	$inquiryStatus[11]['can_move_channel_partner'] = array(11, 102);
	$inquiryStatus[11]['only_id_question'] = 1;
	$inquiryStatus[11]['need_followup'] = 0;
	$inquiryStatus[11]['has_question'] = 1;
	$inquiryStatus[11]['can_display_on_inquiry_user'] = 0;
	$inquiryStatus[11]['can_display_on_inquiry_third_party'] = 0;
	$inquiryStatus[11]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[11]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[11]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[11]['can_display_on_inquiry_sales_person'] = 0;
	$inquiryStatus[11]['can_display_on_inquiry_channel_partner'] = 0;
	$inquiryStatus[11]['background'] = "#e70e0e";
	$inquiryStatus[11]['color'] = "#ffffff";
	$inquiryStatus[11]['highlight_deadend_followup'] = 0;
	$inquiryStatus[11]['index'] = 11;

	$inquiryStatus[14]['id'] = 14;
	$inquiryStatus[14]['name'] = "Points Query";
	$inquiryStatus[14]['key'] = "t-point-query";
	$inquiryStatus[14]['for_architect_ids'] = array(14);
	$inquiryStatus[14]['for_electrician_ids'] = array(14);
	$inquiryStatus[14]['for_user_ids'] = array(14);
	$inquiryStatus[14]['for_third_party_ids'] = array(14);
	$inquiryStatus[14]['for_sales_ids'] = array(14);
	$inquiryStatus[14]['for_tele_sales_ids'] = array(14);
	$inquiryStatus[14]['for_channel_partner_ids'] = array(14);
	$inquiryStatus[14]['can_move_user'] = array(14, 12, 10);
	$inquiryStatus[14]['can_move_third_party'] = array();
	$inquiryStatus[14]['can_move_sales'] = array(2);
	$inquiryStatus[14]['can_move_tele_sales'] = array(9);
	$inquiryStatus[14]['can_move_channel_partner'] = array();
	$inquiryStatus[14]['only_id_question'] = 1;
	$inquiryStatus[14]['need_followup'] = 0;
	$inquiryStatus[14]['has_question'] = 1;
	$inquiryStatus[14]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[14]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[14]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[14]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[14]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[14]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[14]['can_display_on_inquiry_channel_partner'] = 0;
	$inquiryStatus[14]['background'] = "#e70e0e";
	$inquiryStatus[14]['color'] = "#ffffff";
	$inquiryStatus[14]['highlight_deadend_followup'] = 0;
	$inquiryStatus[14]['index'] = 11;

	$inquiryStatus[12]['id'] = 12;
	$inquiryStatus[12]['name'] = "Points Lapsed";
	$inquiryStatus[12]['key'] = "t-lapsed";
	$inquiryStatus[12]['for_architect_ids'] = array(12);
	$inquiryStatus[12]['for_electrician_ids'] = array(12);
	$inquiryStatus[12]['for_user_ids'] = array(12);
	$inquiryStatus[12]['for_third_party_ids'] = array(12);
	$inquiryStatus[12]['for_sales_ids'] = array(12);
	$inquiryStatus[12]['for_tele_sales_ids'] = array(12);
	$inquiryStatus[12]['for_channel_partner_ids'] = array(12);
	$inquiryStatus[12]['can_move_user'] = array(12, 10);
	$inquiryStatus[12]['can_move_third_party'] = array();
	$inquiryStatus[12]['can_move_sales'] = array();
	$inquiryStatus[12]['can_move_tele_sales'] = array();
	$inquiryStatus[12]['can_move_channel_partner'] = array();
	$inquiryStatus[12]['only_id_question'] = 1;
	$inquiryStatus[12]['need_followup'] = 0;
	$inquiryStatus[12]['has_question'] = 1;
	$inquiryStatus[12]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[12]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[12]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[12]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[12]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[12]['can_display_on_inquiry_sales_person'] = 0;
	$inquiryStatus[12]['can_display_on_inquiry_channel_partner'] = 0;
	$inquiryStatus[12]['background'] = "#e70e0e";
	$inquiryStatus[12]['color'] = "#ffffff";
	$inquiryStatus[12]['highlight_deadend_followup'] = 0;
	$inquiryStatus[12]['index'] = 12;

	$inquiryStatus[10]['id'] = 10;
	$inquiryStatus[10]['name'] = "Claimed";
	$inquiryStatus[10]['key'] = "t-claimed";
	$inquiryStatus[10]['for_architect_ids'] = array(9, 10);
	$inquiryStatus[10]['for_electrician_ids'] = array(9, 10);
	$inquiryStatus[10]['for_user_ids'] = array(9, 10);
	$inquiryStatus[10]['for_third_party_ids'] = array(10);
	$inquiryStatus[10]['for_sales_ids'] = array(10);
	$inquiryStatus[10]['for_tele_sales_ids'] = array(10);
	$inquiryStatus[10]['for_channel_partner_ids'] = array(10);
	$inquiryStatus[10]['can_move_user'] = array(10);
	$inquiryStatus[10]['can_move_third_party'] = array(10);
	$inquiryStatus[10]['can_move_sales'] = array(10);
	$inquiryStatus[10]['can_move_tele_sales'] = array(10);
	$inquiryStatus[10]['can_move_channel_partner'] = array(10);
	$inquiryStatus[10]['only_id_question'] = 0;
	$inquiryStatus[10]['need_followup'] = 0;
	$inquiryStatus[10]['has_question'] = 1;
	$inquiryStatus[10]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[10]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[10]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[10]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[10]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[10]['can_display_on_inquiry_sales_person'] = 0;
	$inquiryStatus[10]['can_display_on_inquiry_channel_partner'] = 0;
	$inquiryStatus[10]['background'] = "#e70e0e";
	$inquiryStatus[10]['color'] = "#ffffff";
	$inquiryStatus[10]['highlight_deadend_followup'] = 0;
	$inquiryStatus[10]['index'] = 13;

	$inquiryStatus[101]['id'] = 101;
	$inquiryStatus[101]['name'] = "Non Potential";
	$inquiryStatus[101]['key'] = "t-non-potential";
	$inquiryStatus[101]['for_architect_ids'] = array();
	$inquiryStatus[101]['for_electrician_ids'] = array();
	$inquiryStatus[101]['for_user_ids'] = array();
	$inquiryStatus[101]['for_third_party_ids'] = array();
	$inquiryStatus[101]['for_sales_ids'] = array();
	$inquiryStatus[101]['for_tele_sales_ids'] = array();
	$inquiryStatus[101]['for_channel_partner_ids'] = array();
	$inquiryStatus[101]['can_move_user'] = array();
	$inquiryStatus[101]['can_move_third_party'] = array();
	$inquiryStatus[101]['can_move_sales'] = array();
	$inquiryStatus[101]['can_move_tele_sales'] = array();
	$inquiryStatus[101]['can_move_channel_partner'] = array();
	$inquiryStatus[101]['only_id_question'] = 1;
	$inquiryStatus[101]['need_followup'] = 0;
	$inquiryStatus[101]['has_question'] = 0;
	$inquiryStatus[101]['can_display_on_inquiry_user'] = 0;
	$inquiryStatus[101]['can_display_on_inquiry_third_party'] = 0;
	$inquiryStatus[101]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[101]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[101]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[101]['can_display_on_inquiry_sales_person'] = 0;
	$inquiryStatus[101]['can_display_on_inquiry_channel_partner'] = 0;
	$inquiryStatus[101]['background'] = "#88cbe6";
	$inquiryStatus[101]['color'] = "#ffffff";
	$inquiryStatus[101]['highlight_deadend_followup'] = 0;
	$inquiryStatus[101]['index'] = 4;

	$inquiryStatus[102]['id'] = 102;
	$inquiryStatus[102]['name'] = "Rejected";
	$inquiryStatus[102]['key'] = "t-rejected";
	$inquiryStatus[102]['for_architect_ids'] = array(102);
	$inquiryStatus[102]['for_electrician_ids'] = array(102);
	$inquiryStatus[102]['for_user_ids'] = array(102);
	$inquiryStatus[102]['for_third_party_ids'] = array(102);
	$inquiryStatus[102]['for_sales_ids'] = array(102);
	$inquiryStatus[102]['for_tele_sales_ids'] = array(102);
	$inquiryStatus[102]['for_channel_partner_ids'] = array(102);
	$inquiryStatus[102]['can_move_user'] = array(102);
	$inquiryStatus[102]['can_move_third_party'] = array(102);
	$inquiryStatus[102]['can_move_sales'] = array(102);
	$inquiryStatus[102]['can_move_tele_sales'] = array(102);
	$inquiryStatus[102]['can_move_channel_partner'] = array(102);
	$inquiryStatus[102]['only_id_question'] = 1;
	$inquiryStatus[102]['need_followup'] = 0;
	$inquiryStatus[102]['has_question'] = 1;
	$inquiryStatus[102]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[102]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[102]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[102]['can_display_on_inquiry_architect'] = 1;
	$inquiryStatus[102]['can_display_on_inquiry_electrician'] = 1;
	$inquiryStatus[102]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[102]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[102]['background'] = "#88cbe6";
	$inquiryStatus[102]['color'] = "#ffffff";
	$inquiryStatus[102]['highlight_deadend_followup'] = 0;
	$inquiryStatus[102]['index'] = 15;

	$inquiryStatus[0]['id'] = 0;
	$inquiryStatus[0]['name'] = "All";
	$inquiryStatus[0]['key'] = "t-all";
	$inquiryStatus[0]['for_architect_ids'] = array(0);
	$inquiryStatus[0]['for_electrician_ids'] = array(0);
	$inquiryStatus[0]['for_user_ids'] = array(0);
	$inquiryStatus[0]['for_third_party_ids'] = array(0);
	$inquiryStatus[0]['for_sales_ids'] = array(0);
	$inquiryStatus[0]['for_tele_sales_ids'] = array(0);
	$inquiryStatus[0]['for_channel_partner_ids'] = array(0);
	$inquiryStatus[0]['can_move_user'] = array(0);
	$inquiryStatus[0]['can_move_third_party'] = array();
	$inquiryStatus[0]['can_move_sales'] = array();
	$inquiryStatus[0]['can_move_tele_sales'] = array();
	$inquiryStatus[0]['can_move_channel_partner'] = array();
	$inquiryStatus[0]['only_id_question'] = 0;
	$inquiryStatus[0]['need_followup'] = 0;
	$inquiryStatus[0]['has_question'] = 0;
	$inquiryStatus[0]['can_display_on_inquiry_user'] = 1;
	$inquiryStatus[0]['can_display_on_inquiry_third_party'] = 1;
	$inquiryStatus[0]['can_display_on_inquiry_tele_sales'] = 1;
	$inquiryStatus[0]['can_display_on_inquiry_architect'] = 0;
	$inquiryStatus[0]['can_display_on_inquiry_electrician'] = 0;
	$inquiryStatus[0]['can_display_on_inquiry_sales_person'] = 1;
	$inquiryStatus[0]['can_display_on_inquiry_channel_partner'] = 1;
	$inquiryStatus[0]['background'] = "#0d0d0d";
	$inquiryStatus[0]['color'] = "#ffffff";
	$inquiryStatus[0]['highlight_deadend_followup'] = 1;
	$inquiryStatus[0]['index'] = 16;

	//	$inquiryStatus[0]['sub_ids'] = array(0);
	// $inquiryStatus[0]['is_last_status'] = 0;
	// $inquiryStatus[0]['need_followup'] = 0;

	// $inquiryStatus[1]['id'] = 1;
	// $inquiryStatus[1]['sub_ids'] = array(1);
	// $inquiryStatus[1]['name'] = "Inquiry";
	// $inquiryStatus[1]['key'] = "t-inquiry";
	// $inquiryStatus[1]['can_move_user'] = array(1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 101);
	// $inquiryStatus[1]['is_last_status'] = 0;
	// $inquiryStatus[1]['need_followup'] = 1;

	// $inquiryStatus[2]['id'] = 2;
	// $inquiryStatus[2]['sub_ids'] = array(2, 3, 4, 5, 6, 7, 8);
	// $inquiryStatus[2]['name'] = "Potential Inquiry";
	// $inquiryStatus[2]['key'] = "t-potential-inquiry";
	// $inquiryStatus[2]['can_move_user'] = array(2, 3, 4, 5, 6, 7, 8, 9, 10, 101);
	// $inquiryStatus[2]['is_last_status'] = 0;
	// $inquiryStatus[2]['need_followup'] = 1;

	// $inquiryStatus[3]['id'] = 3;
	// $inquiryStatus[3]['sub_ids'] = array(0);
	// $inquiryStatus[3]['name'] = "Demo Done";
	// $inquiryStatus[3]['key'] = "t-demo-done";
	// $inquiryStatus[3]['can_move_user'] = array(3, 4, 5, 6, 7, 8, 9, 10, 101);
	// $inquiryStatus[3]['is_last_status'] = 0;
	// $inquiryStatus[3]['need_followup'] = 1;

	// $inquiryStatus[4]['id'] = 4;
	// $inquiryStatus[4]['sub_ids'] = array(0);
	// $inquiryStatus[4]['name'] = "Site Visit";
	// $inquiryStatus[4]['key'] = "t-site-visit";
	// $inquiryStatus[4]['can_move_user'] = array(4, 5, 6, 7, 8, 9, 10, 101);
	// $inquiryStatus[4]['is_last_status'] = 0;
	// $inquiryStatus[4]['need_followup'] = 1;

	// $inquiryStatus[5]['id'] = 5;
	// $inquiryStatus[5]['sub_ids'] = array(0);
	// $inquiryStatus[5]['name'] = "Quotation";
	// $inquiryStatus[5]['key'] = "t-quotation";
	// $inquiryStatus[5]['can_move_user'] = array(5, 6, 7, 8, 9, 10, 102);
	// $inquiryStatus[5]['is_last_status'] = 0;
	// $inquiryStatus[5]['need_followup'] = 1;

	// $inquiryStatus[6]['id'] = 6;
	// $inquiryStatus[6]['sub_ids'] = array(0);
	// $inquiryStatus[6]['name'] = "Negotiation";
	// $inquiryStatus[6]['key'] = "t-negotiation";
	// $inquiryStatus[6]['can_move_user'] = array(6, 7, 8, 9, 10, 102);
	// $inquiryStatus[6]['is_last_status'] = 0;
	// $inquiryStatus[6]['need_followup'] = 1;

	// $inquiryStatus[7]['id'] = 7;
	// $inquiryStatus[7]['sub_ids'] = array(0);
	// $inquiryStatus[7]['name'] = "Order Confrimed";
	// $inquiryStatus[7]['key'] = "t-order-confrimed";
	// $inquiryStatus[7]['can_move_user'] = array(7, 8, 9, 10, 102);
	// $inquiryStatus[7]['is_last_status'] = 0;
	// $inquiryStatus[7]['need_followup'] = 1;

	// $inquiryStatus[8]['id'] = 8;
	// $inquiryStatus[8]['sub_ids'] = array(0);
	// $inquiryStatus[8]['name'] = "Closing";
	// $inquiryStatus[8]['key'] = "t-closing";
	// $inquiryStatus[8]['can_move_user'] = array(8, 9, 10, 102);
	// $inquiryStatus[8]['is_last_status'] = 0;
	// $inquiryStatus[8]['need_followup'] = 1;

	// $inquiryStatus[9]['id'] = 9;
	// $inquiryStatus[9]['sub_ids'] = array(9, 10);
	// $inquiryStatus[9]['name'] = "Material Sent";
	// $inquiryStatus[9]['key'] = "t-material-sent";
	// $inquiryStatus[9]['can_move_user'] = array(9, 10, 102);
	// $inquiryStatus[9]['is_last_status'] = 0;
	// $inquiryStatus[9]['need_followup'] = 0;

	// $inquiryStatus[10]['id'] = 10;
	// $inquiryStatus[10]['sub_ids'] = array(10);
	// $inquiryStatus[10]['name'] = "Claimed";
	// $inquiryStatus[10]['key'] = "t-climed";
	// $inquiryStatus[10]['can_move_user'] = array(10);
	// $inquiryStatus[10]['is_last_status'] = 0;
	// $inquiryStatus[10]['need_followup'] = 0;

	// $inquiryStatus[101]['id'] = 101;
	// $inquiryStatus[101]['sub_ids'] = array(101);
	// $inquiryStatus[101]['name'] = "Non Potential";
	// $inquiryStatus[101]['key'] = "t-non-potential";
	// $inquiryStatus[101]['can_move_user'] = array(101);
	// $inquiryStatus[101]['is_last_status'] = 1;
	// $inquiryStatus[101]['need_followup'] = 0;

	// $inquiryStatus[102]['id'] = 102;
	// $inquiryStatus[102]['sub_ids'] = array(102);
	// $inquiryStatus[102]['name'] = "Rejected";
	// $inquiryStatus[102]['key'] = "t-rejected";
	// $inquiryStatus[102]['can_move_user'] = array(102);
	// $inquiryStatus[102]['is_last_status'] = 1;
	// $inquiryStatus[102]['need_followup'] = 0;

	return $inquiryStatus;
}

function getLeadStatus($statusID = '')
{

	$leadStatus = array();
	$leadStatus[1]['id'] = 1;
	$leadStatus[1]['name'] = "Entry";
	$leadStatus[1]['type'] = 0;
	$leadStatus[1]['index'] = 1;
	$leadStatus[1]['is_active'] = 0;

	$leadStatus[2]['id'] = 2;
	$leadStatus[2]['name'] = "Call";
	$leadStatus[2]['type'] = 0;
	$leadStatus[2]['index'] = 2;
	$leadStatus[2]['is_active'] = 0;

	$leadStatus[3]['id'] = 3;
	$leadStatus[3]['name'] = "Qualified";
	$leadStatus[3]['type'] = 0;
	$leadStatus[3]['index'] = 3;
	$leadStatus[3]['is_active'] = 0;

	$leadStatus[4]['id'] = 4;
	$leadStatus[4]['name'] = "Demo Meeting Done";
	$leadStatus[4]['type'] = 0;
	$leadStatus[4]['index'] = 4;
	$leadStatus[4]['is_active'] = 0;

	$leadStatus[5]['id'] = 5;
	$leadStatus[5]['name'] = "Not Qualified";
	$leadStatus[5]['type'] = 0;
	$leadStatus[5]['index'] = 5;
	$leadStatus[5]['is_active'] = 0;

	$leadStatus[6]['id'] = 6;
	$leadStatus[6]['name'] = "Cold";
	$leadStatus[6]['type'] = 0;
	$leadStatus[6]['index'] = 6;
	$leadStatus[6]['is_active'] = 0;

	// $leadStatus[7]['id'] = 7;
	// $leadStatus[7]['name'] = "Demo Meeting Done";
	// $leadStatus[7]['type'] = 0;
	// $leadStatus[7]['index'] = 7;

	$leadStatus[100]['id'] = 100;
	$leadStatus[100]['name'] = "Quotation";
	$leadStatus[100]['type'] = 1;
	$leadStatus[100]['index'] = 7;
	$leadStatus[100]['is_active'] = 0;

	$leadStatus[101]['id'] = 101;
	$leadStatus[101]['name'] = "Negotiation";
	$leadStatus[101]['type'] = 1;
	$leadStatus[101]['index'] = 8;
	$leadStatus[101]['is_active'] = 0;

	$leadStatus[102]['id'] = 102;
	// $leadStatus[102]['name'] = "Order Confirm";
	$leadStatus[102]['name'] = "Token Received";
	$leadStatus[102]['type'] = 1;
	$leadStatus[102]['index'] = 9;
	$leadStatus[102]['is_active'] = 0;

	$leadStatus[103]['id'] = 103;
	$leadStatus[103]['name'] = "Won";
	$leadStatus[103]['type'] = 1;
	$leadStatus[103]['index'] = 10;
	$leadStatus[103]['is_active'] = 0;

	$leadStatus[104]['id'] = 104;
	$leadStatus[104]['name'] = "Lost";
	$leadStatus[104]['type'] = 1;
	$leadStatus[104]['index'] = 11;
	$leadStatus[104]['is_active'] = 0;

	$leadStatus[105]['id'] = 105;
	$leadStatus[105]['name'] = "Cold";
	$leadStatus[105]['type'] = 1;
	$leadStatus[105]['index'] = 12;
	$leadStatus[105]['is_active'] = 0;

	if ($statusID != 0 && $statusID != '') {
		$leadStatus[$statusID]['is_active'] = 1;
	}

	return $leadStatus;
}
function getLeadStatusForArcEle($LeadStatus)
{

	$leadStatus = array();
	$leadStatus[1]['id'] = 1;
	$leadStatus[1]['name'] = "Entry";
	$leadStatus[1]['is_active'] = 0;

	$leadStatus[2]['id'] = 2;
	$leadStatus[2]['name'] = "In Progress";
	$leadStatus[2]['is_active'] = 0;

	$leadStatus[3]['id'] = 3;
	$leadStatus[3]['name'] = "Won";
	$leadStatus[3]['is_active'] = 0;

	$leadStatus[4]['id'] = 4;
	$leadStatus[4]['name'] = "Lost";
	$leadStatus[4]['is_active'] = 0;

	$leadStatus[5]['id'] = 5;
	$leadStatus[5]['name'] = "Point Claim";
	$leadStatus[5]['is_active'] = 0;


	if ($LeadStatus == 1) {
		$leadStatus[1]['is_active'] = 1;
	} else if ($LeadStatus == 103) {
		$leadStatus[3]['is_active'] = 1;
	} else if ($LeadStatus == 5 || $LeadStatus == 6 || $LeadStatus == 104 || $LeadStatus == 105) {
		$leadStatus[4]['is_active'] = 1;
	} else {
		$leadStatus[2]['is_active'] = 1;
	}

	return $leadStatus;
}

function getLeadNextStatus($status_id)
{
	if (in_array($status_id, [5, 6, 103, 104, 105])) {
		$nextstatus = array();
		$nextstatus['id'] = 0;
		$nextstatus['name'] = "None";
		$nextstatus['type'] = 0;
		$nextstatus['index'] = 0;
		$nextstatus['is_active'] = 0;
	} else {

		$status_id = (int) $status_id;
		$next_status_index = (int) getLeadStatus()[$status_id]['index'] + 1;
		$nextstatus = "";
		foreach (getLeadStatus() as $key => $value) {
			if ($value['index'] == $next_status_index) {
				$nextstatus = $value;
			}
		}
	}

	return $nextstatus;
}

function getArchitectsSourceTypes()
{

	$sourceTypes = array();

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "None";
	$sourceTypeObject['type'] = "fix";
	$sourceTypeObject['id'] = 50;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Electrician(Non Prime)";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 301;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Electrician(Prime)";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 302;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "ASM";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 101;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "ADM";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 102;
	$sourceTypes[$cSourceType] = $sourceTypeObject;
	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "APM";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 103;
	$sourceTypes[$cSourceType] = $sourceTypeObject;
	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "AD";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 104;
	$sourceTypes[$cSourceType] = $sourceTypeObject;
	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Retailer";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 105;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	// $cSourceType = count($sourceTypes);
	// $sourceTypeObject = array();
	// $sourceTypeObject['lable'] = "Retailer";
	// $sourceTypeObject['type'] = "textrequired";
	// $sourceTypeObject['id'] = 51;
	// $sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Whitelion HO";
	$sourceTypeObject['type'] = "textnotrequired";
	$sourceTypeObject['id'] = 52;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Cold call";
	$sourceTypeObject['type'] = "fix";
	$sourceTypeObject['id'] = 53;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Marketing activities";
	$sourceTypeObject['type'] = "fix";
	$sourceTypeObject['id'] = 54;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Other";
	$sourceTypeObject['type'] = "textrequired";
	$sourceTypeObject['id'] = 55;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Existing Client";
	$sourceTypeObject['type'] = "textnotrequired";
	$sourceTypeObject['id'] = 56;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	return $sourceTypes;
}

function getInquirySourceTypes()
{

	$sourceTypes = array();
	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Architect(Non Prime)";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 201;
	$sourceTypes[$cSourceType] = $sourceTypeObject;
	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Architect(Prime)";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 202;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Electrician(Non Prime)";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 301;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Electrician(Prime)";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 302;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "ASM";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 101;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "ADM";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 102;
	$sourceTypes[$cSourceType] = $sourceTypeObject;
	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "APM";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 103;
	$sourceTypes[$cSourceType] = $sourceTypeObject;
	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "AD";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 104;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Retailer";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 105;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	// $cSourceType = count($sourceTypes);
	// $sourceTypeObject = array();
	// $sourceTypeObject['lable'] = "Retailer";
	// $sourceTypeObject['type'] = "textrequired";
	// $sourceTypeObject['id'] = 1;
	// $sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Whitelion HO";
	$sourceTypeObject['type'] = "textnotrequired";

	$sourceTypeObject['id'] = 2;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Cold call";
	$sourceTypeObject['type'] = "fix";
	$sourceTypeObject['id'] = 3;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Marketing activities";
	// $sourceTypeObject['type'] = "fix";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 4;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Other";
	$sourceTypeObject['type'] = "textrequired";
	$sourceTypeObject['id'] = 5;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Existing Client";
	$sourceTypeObject['type'] = "textnotrequired";
	$sourceTypeObject['id'] = 6;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Third Party";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 8;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Exhibition";
	$sourceTypeObject['type'] = "exhibition";
	$sourceTypeObject['id'] = 9;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$isAdminOrCompanyAdmin = isAdminOrCompanyAdmin();
	if ($isAdminOrCompanyAdmin == 1) {

		$cSourceType = count($sourceTypes);
		$sourceTypeObject = array();
		$sourceTypeObject['lable'] = "None";
		$sourceTypeObject['type'] = "fix";
		$sourceTypeObject['id'] = 0;
		$sourceTypes[$cSourceType] = $sourceTypeObject;
	}

	return $sourceTypes;
}

function getLeadSourceTypes()
{

	$sourceTypes = array();
	// $cSourceType = count($sourceTypes);
	// $sourceTypeObject = array();
	// $sourceTypeObject['lable'] = "Architect(Non Prime)";
	// $sourceTypeObject['type'] = "user";
	// $sourceTypeObject['id'] = 201;
	// $sourceTypes[$cSourceType] = $sourceTypeObject;
	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	// $sourceTypeObject['lable'] = "Architect(Prime)";
	$sourceTypeObject['lable'] = "Architect";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 202;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	// $sourceTypeObject = array();
	// $sourceTypeObject['lable'] = "Electrician(Non Prime)";
	// $sourceTypeObject['type'] = "user";
	// $sourceTypeObject['id'] = 301;
	// $sourceTypes[$cSourceType] = $sourceTypeObject;

	// $cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	// $sourceTypeObject['lable'] = "Electrician(Prime)";
	$sourceTypeObject['lable'] = "Electrician";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 302;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "ASM";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 101;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "ADM";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 102;
	$sourceTypes[$cSourceType] = $sourceTypeObject;
	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "APM";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 103;
	$sourceTypes[$cSourceType] = $sourceTypeObject;
	$cSourceType = count($sourceTypes);

	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "AD";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 104;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Retailer";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 105;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Whitelion HO";
	$sourceTypeObject['type'] = "textnotrequired";

	$sourceTypeObject['id'] = 2;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Cold call";
	$sourceTypeObject['type'] = "fix";
	$sourceTypeObject['id'] = 3;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Marketing activities";
	// $sourceTypeObject['type'] = "fix";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 4;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Other";
	$sourceTypeObject['type'] = "textrequired";
	$sourceTypeObject['id'] = 5;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Existing Client";
	$sourceTypeObject['type'] = "textnotrequired";
	$sourceTypeObject['id'] = 6;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Third Party";
	$sourceTypeObject['type'] = "user";
	$sourceTypeObject['id'] = 8;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	$cSourceType = count($sourceTypes);
	$sourceTypeObject = array();
	$sourceTypeObject['lable'] = "Exhibition";
	$sourceTypeObject['type'] = "exhibition";
	$sourceTypeObject['id'] = 9;
	$sourceTypes[$cSourceType] = $sourceTypeObject;

	return $sourceTypes;
}

function getAllUserTypes()
{

	$userTypes = getUserTypes();
	$channelPartners = getChannelPartners();
	$architects = getArchitects();
	$electricians = getElectricians();
	$customers = getCustomers();
	foreach ($channelPartners as $key => $value) {
		$userTypes[$key] = $value;
	}
	foreach ($architects as $key => $value) {
		$userTypes[$key] = $value;
	}
	foreach ($electricians as $key => $value) {
		$userTypes[$key] = $value;
	}
	foreach ($customers as $key => $value) {
		$userTypes[$key] = $value;
	}

	return $userTypes;
}

function getUserTypeName($userType)
{

	$userType = (int) $userType;
	$userTypeLable = "";
	if (isset(getUserTypes()[$userType]['short_name'])) {
		$userTypeLable = getUserTypes()[$userType]['short_name'];
	} else if (isset(getChannelPartners()[$userType]['short_name'])) {
		$userTypeLable = getChannelPartners()[$userType]['short_name'];
	} else if (isset(getArchitects()[$userType]['short_name'])) {
		$userTypeLable = getArchitects()[$userType]['short_name'];
	} else if (isset(getElectricians()[$userType]['short_name'])) {
		$userTypeLable = getElectricians()[$userType]['short_name'];
	} else if (isset(getCustomers()[$userType]['short_name'])) {
		$userTypeLable = getCustomers()[$userType]['short_name'];
	}

	return $userTypeLable;
}

function getUserTypeMainLabel($userType)
{

	$userType = (int) $userType;
	$userTypeLable = "";
	if (isset(getUserTypes()[$userType]['short_name'])) {
		$userTypeLable = getUserTypes()[$userType]['short_name'];
	} else if (isset(getChannelPartners()[$userType]['short_name'])) {
		$userTypeLable = getChannelPartners()[$userType]['short_name'];
	} else if (isset(getArchitects()[$userType]['short_name'])) {
		$userTypeLable = "ARCHITECT " . getArchitects()[$userType]['short_name'];
	} else if (isset(getElectricians()[$userType]['short_name'])) {
		$userTypeLable = "ELECTRICIAN " . getElectricians()[$userType]['short_name'];
	} else if (isset(getCustomers()[$userType]['short_name'])) {
		$userTypeLable = getCustomers()[$userType]['short_name'];
	}

	return $userTypeLable;
}
function getUserTypeNameForLeadTag($userType)
{

	$userType = (int) $userType;
	$userTypeLable = "";
	if (isset(getUserTypes()[$userType]['short_name'])) {
		$userTypeLable = getUserTypes()[$userType]['short_name'];
	} else if (isset(getChannelPartners()[$userType]['short_name'])) {
		$userTypeLable = getChannelPartners()[$userType]['short_name'];
	} else if (isset(getArchitects()[$userType]['short_name'])) {
		$userTypeLable = "ARCHITECT " . getArchitects()[$userType]['short_name'];
	} else if (isset(getElectricians()[$userType]['short_name'])) {
		$userTypeLable = "ELECTRICIAN " . getElectricians()[$userType]['short_name'];
	} else if (isset(getCustomers()[$userType]['short_name'])) {
		$userTypeLable = getCustomers()[$userType]['short_name'];
	}

	return $userTypeLable;
}

function getChannelPartnersForAccount()
{

	if (Auth::user()->parent_id != 0) {

		$ChannelPartner = ChannelPartner::where('user_id', Auth::user()->parent_id)->first();
		$viewAccountOFChannelPartner = array();
		if ($ChannelPartner) {
			$viewAccountOFChannelPartner[] = getChannelPartners()[$ChannelPartner->type];
		}
	} else {
		$viewAccountOFChannelPartner = getChannelPartners();
	}

	return $viewAccountOFChannelPartner;
}

function isChannelPartner($userType)
{

	$isChannelPartner = 0;
	if (isset(getChannelPartners()[$userType]['id'])) {
		$isChannelPartner = getChannelPartners()[$userType]['id'];
	}
	return $isChannelPartner;
}

function isAdminOrCompanyAdmin()
{
	return (Auth::user()->type == 0 || Auth::user()->type == 1) ? 1 : 0;
}
function isSalePerson()
{
	return (Auth::user()->type == 2) ? 1 : 0;
}

function isPurchasePerson()
{
	return (Auth::user()->type == 10) ? 1 : 0;
}
function isAccountUser()
{
	return (Auth::user()->type == 3) ? 1 : 0;
}

function isDispatcherUser()
{
	return (Auth::user()->type == 4) ? 1 : 0;
}
function isArchitect()
{
	return (Auth::user()->type == 202) ? 1 : 0;
}

function isElectrician()
{
	return (Auth::user()->type == 302) ? 1 : 0;
}

function isMarketingUser()
{
	return (Auth::user()->type == 6) ? 1 : 0;
}

function isMarketingDispatcherUser()
{
	return (Auth::user()->type == 7) ? 1 : 0;
}

function isThirdPartyUser()
{
	return (Auth::user()->type == 8) ? 1 : 0;
}

function isTaleSalesUser()
{
	return (Auth::user()->type == 9) ? 1 : 0;
}

function userHasAcccess($userType)
{

	$accessTypes = getUsersAccess(Auth::user()->type);

	$accessTypesList = array();
	foreach ($accessTypes as $key => $value) {
		$accessTypesList[] = $value['id'];
	}

	if (in_array($userType, $accessTypesList)) {

		return true;
	} else {

		return false;
	}
}

function TeleSalesCity($userId)
{
	$TeleSales = TeleSales::where('user_id', $userId)->first();
	$cities = array(0);
	if ($TeleSales) {

		if ($TeleSales->cities != "") {
			$cities = explode(",", $TeleSales->cities);
		}
	}
	return $cities;
}

function SalesCity($userId)
{
	$SalePerson = SalePerson::where('user_id', $userId)->first();
	$cities = array(0);
	if ($SalePerson) {

		if ($SalePerson->cities != "") {
			$cities = explode(",", $SalePerson->cities);
		}
	}
	return $cities;
}

// function getInquiryStatusTabs($inquiryStatus) {

// 	$list = array();
// 	if ($inquiryStatus == "all") {

// 		$list = getInquiryStatus();

// 	} else {
// 		$inquiryStatus = explode(",", $inquiryStatus);
// 		foreach ($inquiryStatus as $key => $value) {
// 			$list[$key] = getInquiryStatus()[$value];
// 		}
// 	}

// 	return $list;

// }

function getUsersAccess($userType)
{

	$accessArray = array();

	$AllUserTypes = getUserTypes();

	if ($userType == 0) {

		$accessIds = array(0, 1);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 1) {

		$accessIds = array(1);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 2) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 3) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 4) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 5) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 6) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 7) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 101) {

		$accessIds = array(3, 4);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 102) {

		$accessIds = array(3, 4);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 103) {

		$accessIds = array(3, 4);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 104) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 105) {

		$accessIds = array();

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 11) {

		$accessIds = array(0, 1, 11);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	}
	return $accessArray;
}

function getChannelPartnersAccess($userType)
{

	$accessArray = array();

	$AllUserTypes = getChannelPartners();

	if ($userType == 0) {

		$accessIds = array(101, 102, 103, 104, 105);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 1) {

		$accessIds = array(101, 102, 103, 104, 105);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 2) {

		$accessIds = array(104, 105);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 6) {

		$accessIds = array(101, 102, 103, 104, 105);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	} else if ($userType == 9) {

		$accessIds = array(101, 102, 103, 104, 105);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllUserTypes[$value];
		}
	}

	return $accessArray;
}

function getsubOrdersTabs($userType)
{

	$accessArray = array();

	$AllChannelPartners = getChannelPartners();

	if ($userType == 0) {

		$accessIds = array(101, 102, 103, 104, 105);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllChannelPartners[$value];
		}
	} else if ($userType == 1) {

		$accessIds = array(101, 102, 103, 104, 105);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllChannelPartners[$value];
		}
	} else if ($userType == 101) {

		$accessIds = array(102, 103, 104, 105);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllChannelPartners[$value];
		}
	} else if ($userType == 102) {

		$accessIds = array(103, 104, 105);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllChannelPartners[$value];
		}
	} else if ($userType == 103) {

		$accessIds = array(104, 105);

		foreach ($accessIds as $key => $value) {
			$accessArray[$key] = $AllChannelPartners[$value];
		}
	}

	return $accessArray;
}
function createThumbs($sourceFilePath, $destinationFilePath, $maxWidth)
{

	/////////// CREATE THUMB

	$quality = 100;
	$imgsize = getimagesize($sourceFilePath);
	$width = $imgsize[0];
	$height = $imgsize[1];
	$mime = $imgsize['mime'];

	switch ($mime) {
		case 'image/gif':
			$imageCreate = "imagecreatefromgif";
			$image = "imagegif";
			break;

		case 'image/png':
			$imageCreate = "imagecreatefrompng";
			$image = "imagepng";
			$quality = 7;
			break;

		case 'image/jpeg':
			$imageCreate = "imagecreatefromjpeg";
			$image = "imagejpeg";
			$quality = 80;
			break;
		default:
			return false;
			break;
	}

	$scalRatio = ($maxWidth / $width);
	$maxHeight = round($scalRatio * $height);
	$dstImg = imagecreatetruecolor($maxWidth, $maxHeight);
	///////////////
	imagealphablending($dstImg, false);
	imagesavealpha($dstImg, true);
	///IF IMAGE IS TRANSPERANT THEN THUMBNAI RESIZABLE IMAGE WILL TRANSPERANT ,,IF NOT USE THIS FUNCTION GET IMAGE BACKGROUD WHITE
	$transparent = imagecolorallocatealpha($dstImg, 255, 255, 255, 127);
	imagefilledrectangle($dstImg, 0, 0, $maxWidth, $maxHeight, $transparent);
	/////////////
	$srcImg = $imageCreate($sourceFilePath);
	imagecopyresampled($dstImg, $srcImg, 0, 0, 0, 0, $maxWidth, $maxHeight, $width, $height);

	$image($dstImg, $destinationFilePath, $quality);
	if ($dstImg) {
		imagedestroy($dstImg);
	}

	if ($srcImg) {
		imagedestroy($srcImg);
	}
}

function getSalesPersonReportingManager($userId)
{

	$SalePerson = SalePerson::select('reporting_manager_id')->where('user_id', $userId)->first();
	return $SalePerson;
}

function getChannelPartnerSalesPersonsIds($userId)
{

	$ChannelPartner = ChannelPartner::select('sale_persons')->where('user_id', $userId)->first();
	$salesPersons = array();
	if ($ChannelPartner) {
		$salePersons = $ChannelPartner->sale_persons;
		$salePersons = explode(",", $salePersons);
	}

	return $salePersons;
}

function getChildSalePersonsIds($userId)
{

	$SalePersons = SalePerson::select('user_id')->where('reporting_manager_id', $userId)->get();
	$SalePersonsIds = array();
	$SalePersonsIds[] = $userId;

	foreach ($SalePersons as $key => $value) {
		$SalePersonsIds[] = $value['user_id'];
		$getChildSalePersonsIds = getChildSalePersonsIds($value['user_id']);
		$SalePersonsIds = array_merge($SalePersonsIds, $getChildSalePersonsIds);
	}
	$SalePersonsIds = array_unique($SalePersonsIds);
	$SalePersonsIds = array_values($SalePersonsIds);
	return $SalePersonsIds;
}

function getParentSalePersonsIds($userId)
{
	$SalePersons = SalePerson::select('reporting_manager_id')->where('user_id', $userId)->first();
	$SalePersonsIds = array();
	if ($SalePersons) {

		if ($SalePersons->reporting_manager_id == 0) {
			return array(0);
		} else {
			$SalePersonsIds[] = $SalePersons->reporting_manager_id;

			$getParentsSalePersonsIds = getParentSalePersonsIds($SalePersons->reporting_manager_id);

			$SalePersonsIds = array_merge($SalePersonsIds, $getParentsSalePersonsIds);
		}
	} else {
		return array(0);
	}
	$SalePersonsIds = array_unique($SalePersonsIds);
	$SalePersonsIds = array_values($SalePersonsIds);
	return $SalePersonsIds;
}

function getParentSalePersonsIdsforLead($userId)
{
	$SalePersons = SalePerson::select('reporting_manager_id')->where('user_id', $userId)->first();
	$SalePersonsIds = array();
	$SalePersonsIds[] = $userId;
	if ($SalePersons) {

		if ($SalePersons->reporting_manager_id == 0) {
			return array(0);
		} else {
			$SalePersonsIds[] = $SalePersons->reporting_manager_id;

			$getParentsSalePersonsIds = getParentSalePersonsIds($SalePersons->reporting_manager_id);

			$SalePersonsIds = array_merge($SalePersonsIds, $getParentsSalePersonsIds);
		}
	} else {
		return array(0);
	}
	$SalePersonsIds = array_unique($SalePersonsIds);
	$SalePersonsIds = array_values($SalePersonsIds);
	return $SalePersonsIds;
}

function UsersNotificationTokens($userId)
{

	$notificationTokens = array();
	$Users = User::select('fcm_token')->whereIn('id', $userId)->orWhere('type', 0)->get();
	if (count($Users) > 0) {

		foreach ($Users as $keyPush => $valuePush) {
			$notificationTokens[] = $valuePush->fcm_token;
		}
	}

	return $notificationTokens;
}

function getServiceHierarchyStatusLable($serviceHierarchyStatus)
{

	$serviceHierarchyStatus = (int) $serviceHierarchyStatus;

	if ($serviceHierarchyStatus == 0) {
		$serviceHierarchyStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Inactive</span>';
	} else if ($serviceHierarchyStatus == 1) {
		$serviceHierarchyStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> Active</span>';
	} else if ($serviceHierarchyStatus == 2) {
		$serviceHierarchyStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Blocked</span>';
	}
	return $serviceHierarchyStatus;
}

function isServiceExecutiveUser()
{
	return (Auth::user()->type == 11) ? 1 : 0;
}

function getParentServiceExecutivesIds($userId)
{
	$ServiceExecutives = Wlmst_ServiceExecutive::select('reporting_manager_id')->where('user_id', $userId)->first();
	$ServiceExecutivessIds = array();
	if ($ServiceExecutives) {

		if ($ServiceExecutives->reporting_manager_id == 0) {
			return array(0);
		} else {
			$ServiceExecutivessIds[] = $ServiceExecutives->reporting_manager_id;

			$getParentsServiceExecutivessIds = getParentServiceExecutivesIds($ServiceExecutives->reporting_manager_id);

			$ServiceExecutivessIds = array_merge($ServiceExecutivessIds, $getParentsServiceExecutivessIds);
		}
	} else {
		return array(0);
	}
	$ServiceExecutivessIds = array_unique($ServiceExecutivessIds);
	$ServiceExecutivessIds = array_values($ServiceExecutivessIds);
	return $ServiceExecutivessIds;
}

function getChildChannelPartners($userId, $type)
{

	$childChannelPartnersId = array();

	if ($type == 0) {

		$ChannelPartners102 = ChannelPartner::select('user_id')->where('type', 102)->where('reporting_manager_id', $userId)->get();

		if (count($ChannelPartners102) > 0) {

			$ChannelPartners102Id = array();

			foreach ($ChannelPartners102 as $key => $value) {
				$ChannelPartners102Id[] = $value->user_id;
			}

			$childChannelPartnersId = array_merge($childChannelPartnersId, $ChannelPartners102Id);

			$ChannelPartners103 = ChannelPartner::select('user_id')->where('type', 103)->whereIn('reporting_manager_id', $ChannelPartners102Id)->get();

			if (count($ChannelPartners103) > 0) {

				$ChannelPartners103Id = array();

				foreach ($ChannelPartners103 as $key => $value) {
					$ChannelPartners103Id[] = $value->user_id;
				}

				$childChannelPartnersId = array_merge($childChannelPartnersId, $ChannelPartners103Id);

				$ChannelPartners104 = ChannelPartner::select('user_id')->where('type', 104)->whereIn('reporting_manager_id', $ChannelPartners103Id)->get();

				if (count($ChannelPartners104) > 0) {

					foreach ($ChannelPartners104 as $key => $value) {

						$childChannelPartnersId[] = $value->user_id;
					}
				}
			}
		}
	} else if ($type == 102) {

		$ChannelPartners102 = ChannelPartner::select('user_id')->where('type', 102)->where('reporting_manager_id', $userId)->get();

		if (count($ChannelPartners102) > 0) {

			foreach ($ChannelPartners102 as $key => $value) {

				$childChannelPartnersId[] = $value->user_id;
			}
		}
	} else if ($type == 103) {

		$ChannelPartners102 = ChannelPartner::select('user_id')->where('type', 102)->where('reporting_manager_id', $userId)->get();

		if (count($ChannelPartners102) > 0) {
			$ChannelPartners102Id = array();

			foreach ($ChannelPartners102 as $key => $value) {
				$ChannelPartners102Id[] = $value->user_id;
			}

			$ChannelPartners103 = ChannelPartner::select('user_id')->where('type', 103)->whereIn('reporting_manager_id', $ChannelPartners102Id)->get();

			if (count($ChannelPartners103) > 0) {

				foreach ($ChannelPartners103 as $key => $value) {

					$childChannelPartnersId[] = $value->user_id;
				}
			}
		}
	} else if ($type == 104) {

		$ChannelPartners102 = ChannelPartner::select('user_id')->where('type', 102)->where('reporting_manager_id', $userId)->get();

		if (count($ChannelPartners102) > 0) {

			$ChannelPartners102Id = array();

			foreach ($ChannelPartners102 as $key => $value) {
				$ChannelPartners102Id[] = $value->user_id;
			}

			$ChannelPartners103 = ChannelPartner::select('user_id')->where('type', 103)->whereIn('reporting_manager_id', $ChannelPartners102Id)->get();

			if (count($ChannelPartners103) > 0) {

				$ChannelPartners103Id = array();

				foreach ($ChannelPartners103 as $key => $value) {
					$ChannelPartners103Id[] = $value->user_id;
				}

				$ChannelPartners104 = ChannelPartner::select('user_id')->where('type', 104)->whereIn('reporting_manager_id', $ChannelPartners103Id)->get();

				if (count($ChannelPartners104) > 0) {

					foreach ($ChannelPartners104 as $key => $value) {

						$childChannelPartnersId[] = $value->user_id;
					}
				}
			}
		}
	} else if ($type == 105) {

		$ChannelPartners102 = ChannelPartner::select('user_id')->where('type', 102)->where('reporting_manager_id', $userId)->get();

		if (count($ChannelPartners102) > 0) {

			$ChannelPartners102Id = array();

			foreach ($ChannelPartners102 as $key => $value) {
				$ChannelPartners102Id[] = $value->user_id;
			}

			$ChannelPartners103 = ChannelPartner::select('user_id')->where('type', 103)->whereIn('reporting_manager_id', $ChannelPartners102Id)->get();

			if (count($ChannelPartners103) > 0) {

				$ChannelPartners103Id = array();

				foreach ($ChannelPartners103 as $key => $value) {
					$ChannelPartners103Id[] = $value->user_id;
				}

				$ChannelPartners104 = ChannelPartner::select('user_id')->where('type', 104)->whereIn('reporting_manager_id', $ChannelPartners103Id)->get();

				if (count($ChannelPartners104) > 0) {

					$ChannelPartners104Id = array();
					foreach ($ChannelPartners104 as $key => $value) {

						$ChannelPartners104Id[] = $value->user_id;
					}

					$ChannelPartners105 = ChannelPartner::select('user_id')->where('type', 105)->whereIn('reporting_manager_id', $ChannelPartners104Id)->get();

					if (count($ChannelPartners105) > 0) {

						foreach ($ChannelPartners105 as $key => $value) {

							$childChannelPartnersId[] = $value->user_id;
						}
					}
				}
			}
		}
	}

	return $childChannelPartnersId;
}

function GSTPercentage()
{
	return 18;
}

function calculationProcessOfOrder($orderItems, $GSTPercentage, $shippingCost)
{

	$order = array();

	$order_vat_per = 5; // You can set this variable to a fixed value, for example


	foreach ($orderItems as $key => $value) {

		if (count($orderItems) >= 1) {
			$total_item = count($orderItems);
			$total_qty = 0;
			$total_amount = 0;
			$grossAmount = 0;
			$total_item_vat = 0;
			$total_item_vat_gross_amt = 0;
			$total_item_bill_amt = 0;

			foreach ($orderItems as $value) {
				if (isset($value['qty']) && intval($value['qty']) != 0) {
					$SubTotal = floatval($value['mrp']) * floatval($value['qty']);
					$total_qty += $value['qty'];
					$total_amount += $SubTotal;
					$total_item_vat += $value['item_vat'];
					$total_item_vat_gross_amt += round($value['item_vat_gross_amt'], 2);

					$total_item_bill_amt = round($total_item_vat + $total_item_vat_gross_amt, 2);


					$Discount_Amount = floatval($SubTotal) * floatval($value['discount_percentage']) / 100;
					$GAmount = floatval($SubTotal) - floatval($Discount_Amount);

					$grossAmount += $GAmount;
				}
			}

			$GSTAmount = floatval($grossAmount) + (floatval($grossAmount) * floatval($order_vat_per) / 100);
			// $order_vat_amount = (floatval($grossAmount) * floatval($order_vat_per) / 100);
			$Roundup_Amount = floatval($GSTAmount) - floatval(round($GSTAmount));
			$Net_Amount = round($GSTAmount);
		}

		$order['total_qty'] = $total_qty;
		$order['gst_percentage'] = floatval($GSTPercentage);
		$order['gst_tax'] = 0;
		$order['shipping_cost'] = floatval($shippingCost);
		$order['delievery_charge'] = 0;
		$order['grossAmount'] = $grossAmount;
		$order['total_amount'] = $total_amount;
		$order['total_item'] = $total_item;
		$order['GSTAmount'] = $GSTAmount;
		$order['Roundup_Amount'] = $Roundup_Amount;
		$order['Net_Amount'] = $Net_Amount;
		$order['total_item_vat'] = round($total_item_vat, 2);
		$order['total_item_vat_gross_amt'] = $total_item_vat_gross_amt;
		$order['total_item_bill_amt'] = $total_item_bill_amt;
		$order['items'] = $orderItems;

		return $order;
	}
}

function calculationProcessOfMarketingRequest($orderItems)
{

	$order = array();
	$order['total_qty'] = 0;
	$order['total_weight'] = 0;
	$order['total_mrp'] = 0;
	$order['total_discount'] = 0;
	$order['total_mrp_minus_disocunt'] = 0;
	// $order['gst_percentage'] = floatval($GSTPercentage);
	$order['gst_tax'] = 0;
	$order['shipping_cost'] = 0;
	$order['delievery_charge'] = 0;
	$order['total_payable'] = 0;
	$order['created_dt'] = date('Y-m-d H:i:s');

	foreach ($orderItems as $key => $value) {

		$orderItems[$key]['id'] = $value['id'];
		if (isset($value['info'])) {
			$orderItems[$key]['info'] = $value['info'];
		}

		//
		$productPrice = floatval($value['mrp']);
		$orderItems[$key]['mrp'] = $productPrice;
		$GSTPercentage = floatval($value['gst_percentage']);

		$orderItems[$key]['gst_percentage'] = $GSTPercentage;
		//

		//
		$orderItemQTY = intval($value['qty']);
		$orderItems[$key]['qty'] = $orderItemQTY;
		$order['total_qty'] = $order['total_qty'] + $orderItemQTY;
		//

		//
		$OrderItemsMRP = ($orderItemQTY * $productPrice);
		$orderItems[$key]['total_mrp'] = $OrderItemsMRP;
		$order['total_mrp'] = $order['total_mrp'] + $OrderItemsMRP;
		//

		$orderItems[$key]['gst_percentage'] = $value['gst_percentage'];

		//
		$GSTTax = ($productPrice * $GSTPercentage) / 100;
		$orderItems[$key]['gst_tax'] = $GSTTax;
		$GSTTaxTotal = $orderItemQTY * $GSTTax;
		$orderItems[$key]['total_gst_tax'] = $GSTTaxTotal;
		$order['gst_tax'] = $order['gst_tax'] + $GSTTaxTotal;
		//

		//
		$discountPercentage = floatval($value['discount_percentage']);
		$orderItems[$key]['discount_percentage'] = $discountPercentage;

		$totalDiscount = 0;
		if ($discountPercentage > 0) {
			$totalDiscount = round(($discountPercentage / 100) * $OrderItemsMRP, 2);
		}

		$discount = 0;

		if ($discountPercentage > 0) {
			$discount = round(($discountPercentage / 100) * $productPrice, 2);
		}

		//
		$orderItems[$key]['discount'] = $discount;
		$orderItems[$key]['total_discount'] = $totalDiscount;
		$order['total_discount'] = round($order['total_discount'] + $totalDiscount, 2);
		//

		//
		$mrpMinusDiscount = round($OrderItemsMRP - $totalDiscount, 2);
		$orderItems[$key]['mrp_minus_disocunt'] = $mrpMinusDiscount;
		$order['total_mrp_minus_disocunt'] = $order['total_mrp_minus_disocunt'] + $mrpMinusDiscount;

		//	$order['total_mrp_minus_disocunt'] = $order['total_mrp_minus_disocunt'] + $mrpMinusDiscount;

		//
		$productWeight = floatval($value['weight']);
		$orderItemTotalWeight = $productWeight * $orderItemQTY;
		$orderItems[$key]['weight'] = $productWeight;
		$orderItems[$key]['total_weight'] = $orderItemTotalWeight;
		$order['total_weight'] = $order['total_weight'] + $orderItemTotalWeight;

		$orderItems[$key]['width'] = $value['width'];
		$orderItems[$key]['height'] = $value['height'];
		if ($value['box_image'] != "") {
			$orderItems[$key]['box_image'] = $value['box_image'];
		} else {
			$orderItems[$key]['box_image'] = '';
		}

		if ($value['sample_image'] != "") {
			$orderItems[$key]['sample_image'] = $value['sample_image'];
		} else {
			$orderItems[$key]['sample_image'] = '';
		}

		if (isset($value['is_custom'])) {
			$orderItems[$key]['is_custom'] = $value['is_custom'];
		}
	}

	$order['total_mrp_minus_disocunt'] = round($order['total_mrp_minus_disocunt'], 2);
	$order['gst_tax'] = round($order['gst_tax'], 2);

	// if ($order['gst_percentage'] != 0) {
	// 	$order['gst_tax'] = round(($order['gst_percentage'] / 100) * $order['total_mrp_minus_disocunt'], 2);
	// }

	// $order['weightInKG'] = $order['total_weight'] / 1000;
	// $order['delievery_charge'] = (round($order['weightInKG'] * $order['shipping_cost'], 2));

	$order['total_payable'] = round($order['total_mrp_minus_disocunt'] + $order['gst_tax'], 2);
	$order['items'] = $orderItems;

	// echo '<pre>';
	// print_r($order);
	// die;

	return $order;
}

function acceptFileTypes($type, $systemType)
{

	if ($type == "order.invoice") {

		if ($systemType == "client") {

			return [
				"application/pdf",
				"application/vnd.ms-excel",
				"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
				"application/msword",
				"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
				"image/*",
			];
		} else if ($systemType == "server") {
			return ['pdf', 'doc', 'xlsx', 'xls', 'png', 'jpeg', 'jpg'];
		}
	} else if ($type == "order.eway.bill") {

		if ($systemType == "client") {

			return [
				"application/pdf",
				"application/vnd.ms-excel",
				"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
				"application/msword",
				"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
				"image/*",
			];
		} else if ($systemType == "server") {
			return ['pdf', 'doc', 'xlsx', 'xls', 'png', 'jpeg', 'jpg'];
		}
	} else if ($type == "order.dispatch.detail") {

		if ($systemType == "client") {

			return [
				"application/pdf",
				"application/vnd.ms-excel",
				"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
				"application/msword",
				"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
				"image/*",
			];
		} else if ($systemType == "server") {
			return ['pdf', 'doc', 'xls', 'xls', 'png', 'jpeg', 'jpg'];
		}
	} else if ($type == "gift.order.dispatch.detail") {

		if ($systemType == "client") {

			return [
				"application/pdf",
				"application/vnd.ms-excel",
				"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
				"application/msword",
				"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
				"image/*",
			];
		} else if ($systemType == "server") {
			return ['pdf', 'doc', 'xls', 'xls', 'png', 'jpeg', 'jpg'];
		}
	} else if ($type == "marketing.challan") {

		if ($systemType == "client") {

			return [
				"application/pdf",
				"application/vnd.ms-excel",
				"application/vnd.openxmlformats-officedocument.spreadsheetml.sheet",
				"application/msword",
				"application/vnd.openxmlformats-officedocument.wordprocessingml.document",
				"image/*",
			];
		} else if ($systemType == "server") {
			return ['pdf', 'doc', 'xls', 'xls', 'png', 'jpeg', 'jpg'];
		}
	}
}

function getPreviousMonths($noOfMonth)
{

	$GMTDateTime = date('Y-m-d H:i:s');
	$TIMEZONE = websiteTimeZone();
	$dt = new DateTime('@' . strtotime($GMTDateTime));
	$dt->setTimeZone(new DateTimeZone($TIMEZONE));
	$myCurrentDate = $dt->format('Y-m-d H:i:s');

	$r = array();

	for ($i = 0; $i < $noOfMonth; $i++) {

		if ($i != 0) {

			$myCurrentDate = date('Y-m-d H:i:s', strtotime($myCurrentDate . " -1 month"));
		}

		$r[$i]['start'] = date('Y-m-1 00:00:00', strtotime($myCurrentDate));
		$r[$i]['end'] = date('Y-m-t 23:59:59', strtotime($myCurrentDate));
		$r[$i]['name'] = date('Y-F', strtotime($myCurrentDate));

		$start = new DateTime($r[$i]['start'], new DateTimeZone($TIMEZONE));
		$start->setTimeZone(new DateTimeZone("GMT"));

		$end = new DateTime($r[$i]['end'], new DateTimeZone($TIMEZONE));
		$end->setTimeZone(new DateTimeZone("GMT"));

		$r[$i]['start_gmt'] = $start->format('Y-m-d H:i:s');
		$r[$i]['end_gmt'] = $end->format('Y-m-d H:i:s');
	}

	return $r;
}

function displayStringLenth($string, $maxLength)
{

	$totalStringLenth = strlen($string);
	if ($totalStringLenth > $maxLength) {
		$stringCrop = substr($string, 0, ($maxLength - 3));
		$string = $stringCrop . "...";
	}
	return $string;
}

function getUserNotificationTypes()
{

	$userTypes = array();
	$userTypes[1]['id'] = 1;
	$userTypes[1]['description'] = "Inquiry Update";
	$userTypes[1]['assigned'] = 0;
	$userTypes[1]['mentioned'] = 0;

	$userTypes[2]['id'] = 2;
	$userTypes[2]['description'] = "Inquiry Update Reply";
	$userTypes[2]['assigned'] = 0;
	$userTypes[2]['mentioned'] = 0;

	$userTypes[3]['id'] = 3;
	$userTypes[3]['description'] = "Inquiry change assigned";
	$userTypes[3]['assigned'] = 1;
	$userTypes[3]['mentioned'] = 0;

	$userTypes[4]['id'] = 4;
	$userTypes[4]['description'] = "Inquiry mentioned ";
	$userTypes[4]['assigned'] = 0;
	$userTypes[4]['mentioned'] = 1;

	return $userTypes;
}

function saveUserNotification($params)
{

	if (!isset($params['inquiry_id'])) {
		$params['inquiry_id'] = 0;
	}

	$UserNotification = new UserNotification();
	$UserNotification->user_id = $params['user_id'];
	$UserNotification->type = $params['type'];
	$UserNotification->from_user_id = $params['from_user_id'];
	$UserNotification->title = $params['title'];
	$UserNotification->description = $params['description'];
	$UserNotification->inquiry_id = $params['inquiry_id'];
	$UserNotification->save();
}

function architectInquiryCalculation($userId)
{

	$query = Inquiry::query();
	$query->where(function ($query2) use ($userId) {

		$query2->where(function ($query3) use ($userId) {

			$query3->whereIn('inquiry.source_type', array("user-201", "user-202"));
			$query3->where('inquiry.source_type_value', $userId);
		});

		$query2->orWhere(function ($query3) use ($userId) {

			$query3->whereIn('inquiry.source_type_1', array("user-201", "user-202"));
			$query3->where('inquiry.source_type_value_1', $userId);
		});

		$query2->orWhere(function ($query3) use ($userId) {

			$query3->whereIn('inquiry.source_type_2', array("user-201", "user-202"));
			$query3->where('inquiry.source_type_value_2', $userId);
		});

		$query2->orWhere(function ($query3) use ($userId) {

			$query3->whereIn('inquiry.source_type_3', array("user-201", "user-202"));
			$query3->where('inquiry.source_type_value_3', $userId);
		});

		$query2->orWhere(function ($query3) use ($userId) {

			$query3->whereIn('inquiry.source_type_4', array("user-201", "user-202"));
			$query3->where('inquiry.source_type_value_4', $userId);
		});

		$query2->orWhere(function ($query3) use ($userId) {

			$query3->where('inquiry.architect', $userId);
		});
	});
	$recordsTotal = $query->count();
	$Architect = Architect::where('user_id', $userId)->first();
	if ($Architect) {
		$Architect->total_inquiry = $recordsTotal;
		$Architect->save();
	}
}
function elecricianInquiryCalculation($userId)
{

	$query = Inquiry::query();
	$query->where(function ($query2) use ($userId) {

		$query2->where(function ($query3) use ($userId) {

			$query3->whereIn('inquiry.source_type', array("user-301", "user-302"));
			$query3->where('inquiry.source_type_value', $userId);
		});

		$query2->orWhere(function ($query3) use ($userId) {

			$query3->whereIn('inquiry.source_type_1', array("user-301", "user-302"));
			$query3->where('inquiry.source_type_value_1', $userId);
		});

		$query2->orWhere(function ($query3) use ($userId) {

			$query3->whereIn('inquiry.source_type_2', array("user-301", "user-302"));
			$query3->where('inquiry.source_type_value_2', $userId);
		});

		$query2->orWhere(function ($query3) use ($userId) {

			$query3->whereIn('inquiry.source_type_3', array("user-301", "user-302"));
			$query3->where('inquiry.source_type_value_3', $userId);
		});

		$query2->orWhere(function ($query3) use ($userId) {

			$query3->whereIn('inquiry.source_type_4', array("user-301", "user-302"));
			$query3->where('inquiry.source_type_value_4', $userId);
		});

		$query2->orWhere(function ($query3) use ($userId) {

			$query3->where('inquiry.electrician', $userId);
		});
	});
	$recordsTotal = $query->count();

	$Electrician = Electrician::where('user_id', $userId)->first();
	if ($Electrician) {
		$Electrician->total_inquiry = $recordsTotal;
		$Electrician->save();
	}
}

function getMyPrivilege($code)
{

	$hasPrivilege = 0;
	if (Auth::user()->privilege != "") {

		$privilege = json_decode(Auth::user()->privilege, true);
		if (isset($privilege[$code]) && $privilege[$code] == 1) {
			$hasPrivilege = 1;
		}
	}
	return $hasPrivilege;
}

function configrationForNotify()
{
	$response = array();
	$response['from_email'] = "axone@admin.com";
	$response['from_name'] = "Axone Infotech";
	$response['to_name'] = "Axone Infotech";

	////TESTING
	$response['test_email'] = "ankit.in1184@gmail.com";
	// $response['test_phone_number'] = "9824717656";
	$response['test_phone_number'] = "9016202912";
	$response['test_email_bcc'] = array("ankit.in1184@gmail.com");
	$response['test_email_cc'] = array("ankit.in1184@gmail.com");
	return $response;
}

// function fromEmailDetail() {
// 	$fromEmailDetail = array();
// 	$fromEmailDetail['email'] = "developer@whitelion.in";
// 	$fromEmailDetail['name'] = "Whitelion";
// 	return $fromEmailDetail;
// }

function getMainMasterPrivilege($userType)
{

	$MainMasterPrivilege = array();

	if ($userType == 0) {
		$MainMasterPrivilege[] = "PRODUCT_BRAND";
		$MainMasterPrivilege[] = "PRODUCT_CODE";
		$MainMasterPrivilege[] = "INCENTIVE_QUARTER";
		$MainMasterPrivilege[] = "COURIER_SERVICE";
		$MainMasterPrivilege[] = "MARKETING_PRODUCT_CODE";
		$MainMasterPrivilege[] = "MARKETING_PRODUCT_GROUP";
	} else if ($userType == 1) {

		$MainMasterPrivilege[] = "PRODUCT_BRAND";
		$MainMasterPrivilege[] = "PRODUCT_CODE";
		$MainMasterPrivilege[] = "INCENTIVE_QUARTER";
		$MainMasterPrivilege[] = "COURIER_SERVICE";
		$MainMasterPrivilege[] = "MARKETING_PRODUCT_CODE";
		$MainMasterPrivilege[] = "MARKETING_PRODUCT_GROUP";
	} else if ($userType == 6) {
		$MainMasterPrivilege[] = "MARKETING_PRODUCT_CODE";
		$MainMasterPrivilege[] = "MARKETING_PRODUCT_GROUP";
	}
	return $MainMasterPrivilege;
}

function sendOTPToMobile($mobileNumber, $otp)
{

	$curl = curl_init();
	curl_setopt_array(
		$curl,
		array(
			// CURLOPT_URL => "https://api.msg91.com/api/v5/otp?template_id=624fe2f9427ab2782b2fae2b&mobile=" . $mobileNumber . "&authkey=124116Awe37ib8e57e66f9b&otp=" . $otp,
			CURLOPT_URL => "https://api.msg91.com/api/v5/otp?template_id=6486f14ed6fc0567113a2fa2&mobile=" . $mobileNumber . "&authkey=124116Awe37ib8e57e66f9b&otp=" . $otp,
			CURLOPT_RETURNTRANSFER => true,
			CURLOPT_ENCODING => "",
			CURLOPT_MAXREDIRS => 10,
			CURLOPT_TIMEOUT => 30,
			CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
			CURLOPT_CUSTOMREQUEST => "POST",
			CURLOPT_POSTFIELDS => "",
			CURLOPT_SSL_VERIFYHOST => 0,
			CURLOPT_SSL_VERIFYPEER => 0,
		)
	);

	$response = curl_exec($curl);
	$err = curl_error($curl);
	curl_close($curl);

	if ($err) {
		//echo "cURL Error #:" . $err;
		$return = errorRes("");
		$return['response'] = $err;
		return $return;
	} else {
		$return = successRes("");
		$return['response'] = $response;
		return $return;
	}
}

function sendNotificationTOAndroid($title, $message, $FcmToken, $screenName, $data_value)
{

	if (count($FcmToken) > 0) {

		$url = 'https://fcm.googleapis.com/fcm/send';

		$serverKey = 'AAAAjO_9mB8:APA91bFUg5s0ou4vzSmuf6EqTLNu3bLpOXJa-v8GwW9HHzC-27ZtEUFloHiMx0Itc6ZhuN3MOitsjG1eRaV5RjDInoSqT4veSXu-TqnyGL_bFkSIH0hIYUmxB6YA77vVenEWPraVR1ma';

		$data = [
			"registration_ids" => $FcmToken,
			"notification" => [
				"title" => $title,
				"body" => $message,
			],
			"data" => [
				"priority" => "high",
				"sound" => "default",
				"content_available" => true,
				"screen" => $screenName,
				"data_value" => json_encode($data_value)
			]
		];
		$encodedData = json_encode($data);

		$headers = [
			'Authorization:key=' . $serverKey,
			'Content-Type: application/json',
		];

		$ch = curl_init();
		curl_setopt($ch, CURLOPT_URL, $url);
		curl_setopt($ch, CURLOPT_POST, true);
		curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		// Disabling SSL Certificate support temporarly
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $encodedData);
		// Execute post
		$result = curl_exec($ch);
		if ($result === FALSE) {
			die('Curl failed: ' . curl_error($ch));
		}
		// Close connection
		curl_close($ch);
		// FCM response
		// dd($result);
		// return $result;
		$noti_responce = json_decode($result);
		$response = array();
		$response['status'] = $noti_responce->success;
		$response['status_code'] = $noti_responce->success == 1 ? 200 : 400;
		$response['msg'] = $noti_responce->success == 1 ? "Notification Send Successfully" : "Notification Failed";
		$response['noti_msg'] = $noti_responce;
	} else {
		$response = array();
		$response['status'] = 0;
		$response['status_code'] = 400;
		$response['msg'] = "No Token";
		$response['noti_msg'] = "";
	}

	return $response;
}

// -------------------- QUOTATION GLOBLE CREATED START --------------------
function getCheckAppVersion($appsource, $appversion)
{
	$alreadyName = wlmst_appversion::query();

	$alreadyName->where('source', $appsource);
	$alreadyName->where('version', $appversion);
	$alreadyName->where('isactive', 1);
	$alreadyName = $alreadyName->first();

	if ($alreadyName) {
		return true;
	} else {
		return false;
	}
}

function quoterrorRes($status = 0, $statusCode = 400, $msg = "Error")
{
	$return = array();
	$return['status'] = $status; // 1=Success; 0=error; 2=appupdate
	$return['status_code'] = $statusCode;
	$return['msg'] = $msg;
	return $return;
}
function quotsuccessRes($status = 1, $statusCode = 200, $msg = "Success")
{
	$return = array();
	$return['status'] = $status; // 1=Success; 0=error; 2=appupdate
	$return['status_code'] = $statusCode;
	$return['msg'] = $msg;
	return $return;
}

function saveBoardSaveLog($params)
{
	$BoardSaveLog = new wlmst_user_created_board_log();
	// $BoardSaveLog->user_id = Auth::user()->id;
	$BoardSaveLog->user_id = '1';
	$BoardSaveLog->quot_id = $params['quot_id'];
	$BoardSaveLog->quotgroup_id = $params['quotgroup_id'];
	$BoardSaveLog->room_no = $params['room_no'];
	$BoardSaveLog->board_no = $params['board_no'];
	$BoardSaveLog->description = $params['description'];
	$BoardSaveLog->source = $params['source'];
	$BoardSaveLog->entryby = '1';
	// $BoardSaveLog->entryby = Auth::user()->id;
	$BoardSaveLog->entryip = $params['entryip'];
	$BoardSaveLog->save();
}

function getQuotationMasterStatusLable($mainMasterStatus)
{
	$mainMasterStatus = (int) $mainMasterStatus;

	if ($mainMasterStatus == 0) {
		$mainMasterStatus = '<span class="badge badge-pill badge-soft-running font-size-11"> Running</span>';
	} else if ($mainMasterStatus == 1) {
		$mainMasterStatus = '<span class="badge badge-pill badge-soft-success font-size-11"> New Request</span>';
	} else if ($mainMasterStatus == 2) {
		$mainMasterStatus = '<span class="badge badge-pill badge-soft-change-request font-size-11"> Change Request</span>';
	} else if ($mainMasterStatus == 3) {
		$mainMasterStatus = '<span class="badge badge-pill badge-soft-confirm font-size-11"> Confirm Quotation</span>';
	} else if ($mainMasterStatus == 4) {
		$mainMasterStatus = '<span class="badge badge-pill badge-soft-danger font-size-11"> Rejected Quotation</span>';
	}
	return $mainMasterStatus;
}
function getQuotationMasterStatusLableText($mainMasterStatus)
{
	$mainMasterStatus = (int) $mainMasterStatus;

	if ($mainMasterStatus == 0) {
		$mainMasterStatus = 'Running';
	} else if ($mainMasterStatus == 1) {
		$mainMasterStatus = 'New Request';
	} else if ($mainMasterStatus == 2) {
		$mainMasterStatus = 'Change Request';
	} else if ($mainMasterStatus == 3) {
		$mainMasterStatus = 'Confirm';
	} else if ($mainMasterStatus == 4) {
		$mainMasterStatus = 'Rejected';
	}
	return $mainMasterStatus;
}

function getQuotationStatus()
{

	$QuotStatusTypes = array();
	$QuotStatusTypes[0]['id'] = 0;
	$QuotStatusTypes[0]['name'] = "Running";
	$QuotStatusTypes[0]['short_name'] = "RUNNING";
	$QuotStatusTypes[0]['sequence'] = 5;

	$QuotStatusTypes[1]['id'] = 1;
	$QuotStatusTypes[1]['name'] = "New Request";
	$QuotStatusTypes[1]['short_name'] = "NEW REQUEST";
	$QuotStatusTypes[1]['sequence'] = 1;

	$QuotStatusTypes[2]['id'] = 2;
	$QuotStatusTypes[2]['name'] = "Change Request";
	$QuotStatusTypes[2]['short_name'] = "CHANGE REQUEST";
	$QuotStatusTypes[2]['sequence'] = 2;

	$QuotStatusTypes[3]['id'] = 3;
	$QuotStatusTypes[3]['name'] = "Confirm";
	$QuotStatusTypes[3]['short_name'] = "CONFIRM";
	$QuotStatusTypes[3]['sequence'] = 3;

	$QuotStatusTypes[4]['id'] = 4;
	$QuotStatusTypes[4]['name'] = "Rejected";
	$QuotStatusTypes[4]['short_name'] = "REJECTED";
	$QuotStatusTypes[4]['sequence'] = 4;

	return $QuotStatusTypes;
}

function formatbBytes($bytes, $precision = 2)
{
	$units = array('B', 'KB', 'MB', 'GB');

	$bytes = max($bytes, 0);
	$pow = floor(($bytes ? log($bytes) : 0) / log(1000));
	$pow = min($pow, count($units) - 1);

	$bytes /= pow(1000, $pow);

	return round($bytes, $precision) . ' ' . $units[$pow];
}

// -------------------- QUOTATION GLOBLE API CREATED END --------------------
function getpercentage($base_amt, $new_amt)
{
	if ($base_amt == 0) {
		return 0.00;
	} else {
		return number_format((floatval($new_amt) * 100 / $base_amt), 2, '.', '');
	}
}
function getQuaterFromMonth($monthNumber)
{
	// START FROM JAN = Q1
	// return floor(($monthNumber - 1) / 3) + 1;

	// START FROM APRIL = Q1
	$quarter = floor(($monthNumber - 1) / 3);
	return ($quarter == 0) ? 4 : $quarter;
}
function getDateFromFinancialYear($financialyear)
{
	$start_year = explode("-", $financialyear)[0];
	$end_year = explode("-", $financialyear)[1];

	$start_date = $start_year . '-04-01' . ' 00:00:00';
	$end_date = $end_year . '-03-31' . ' 23:59:59';

	$start = date('Y-m-d 00:00:00', strtotime($start_date));
	$end = date('Y-m-d 23:59:59', strtotime($end_date));

	$return = array();
	$return['start'] = $start;
	$return['end'] = $end;
	return $return;
}

function getDatesFromQuarter($quarter, $financialyear)
{
	$start_year = explode("-", $financialyear)[0];
	$end_year = explode("-", $financialyear)[1];
	$start_year = $quarter == 4 ? $end_year : $start_year;
	$end_year = $quarter == 4 ? $end_year : $start_year;

	$start_date = $quarter == 4 ? "01" : (3 * $quarter + 1) . "-01 00:00:00";
	$start_date = $start_year . '-' . $start_date;
	$end_date = $quarter == 4 ? '03' : (3 * $quarter + 3) . '-' . ($quarter == 3 || $quarter == 4 ? 31 : 30) . ' 23:59:59';
	$end_date = $end_year . '-' . $end_date;

	$start = date('Y-m-d 00:00:00', strtotime($start_date));
	$end = date('Y-m-d 23:59:59', strtotime($end_date));

	$return = array();
	$return['start'] = $start;
	$return['end'] = $end;
	return $return;
}

function getDatesFromMonth($month, $financialyear)
{
	$quarter = getQuaterFromMonth($month);
	$start_year = explode("-", $financialyear)[0];
	$end_year = explode("-", $financialyear)[1];
	$start_year = $quarter == 4 ? $end_year : $start_year;
	$end_year = $quarter == 4 ? $end_year : $start_year;

	$expected_date = $start_year . '-' . $month . '-02';

	$start = date('Y-m-01 00:00:00', strtotime($expected_date));

	$end = date('Y-m-t 23:59:59', strtotime($expected_date));

	$return = array();
	$return['start'] = $start;
	$return['end'] = $end;
	return $return;
}

function numCommaFormat($number, $decimals = 0)
{

	// $number = 555;
	// $decimals=0;
	// $number = 555.000;
	// $number = 555.123456;

	if (strpos($number, '.') != null) {
		$decimalNumbers = substr($number, strpos($number, '.'));
		$decimalNumbers = substr($decimalNumbers, 1, $decimals);
	} else {
		$decimalNumbers = 0;
		for ($i = 2; $i <= $decimals; $i++) {
			$decimalNumbers = $decimalNumbers . '0';
		}
	}
	// return $decimalNumbers;



	$number = (int) $number;
	// reverse
	$number = strrev($number);

	$n = '';
	$stringlength = strlen($number);

	for ($i = 0; $i < $stringlength; $i++) {
		if ($i % 2 == 0 && $i != $stringlength - 1 && $i > 1) {
			$n = $n . $number[$i] . ',';
		} else {
			$n = $n . $number[$i];
		}
	}

	$number = $n;
	// reverse
	$number = strrev($number);

	($decimals != 0) ? $number = $number . '.' . $decimalNumbers : $number;

	return $number;
}


//  ADVANCE FILTER FOR LEAD & DEALS
function getFilterColumnCRM()
{

	$filter_column = array();
	$filter_column[1]['id'] = 1;
	$filter_column[1]['name'] = "#id";
	$filter_column[1]['column_name'] = "leads.id";
	$filter_column[1]['code'] = "leads_id";
	$filter_column[1]['type'] = "bigint";
	$filter_column[1]['value_type'] = "text";

	$filter_column[2]['id'] = 2;
	$filter_column[2]['name'] = "Client Name";
	$filter_column[2]['column_name'] = "leads.first_name";
	$filter_column[2]['code'] = "leads_first_name";
	$filter_column[2]['type'] = "varchar";
	$filter_column[2]['value_type'] = "text";

	$filter_column[3]['id'] = 3;
	$filter_column[3]['name'] = "Tag";
	$filter_column[3]['column_name'] = "leads.tag";
	$filter_column[3]['code'] = "leads_tag";
	$filter_column[3]['type'] = "varchar";
	$filter_column[3]['value_type'] = "select";

	// $filter_column[3]['id'] = 3;
	// $filter_column[3]['name'] = "Email";
	// $filter_column[3]['column_name'] = "leads.email";
	// $filter_column[4]['code'] = "leads.email";
	// $filter_column[3]['type'] = "varchar";
	// $filter_column[3]['value_type'] = "text";

	$filter_column[4]['id'] = 4;
	$filter_column[4]['name'] = "Phone Number";
	$filter_column[4]['column_name'] = "leads.phone_number";
	$filter_column[4]['code'] = "leads_phone_number";
	$filter_column[4]['type'] = "varchar";
	$filter_column[4]['value_type'] = "text";

	$filter_column[5]['id'] = 5;
	$filter_column[5]['name'] = "Status";
	$filter_column[5]['column_name'] = "leads.status";
	$filter_column[5]['code'] = "leads_status";
	$filter_column[5]['type'] = "tinyint";
	$filter_column[5]['value_type'] = "select";

	// SUB STATUS

	$filter_column[6]['id'] = 6;
	$filter_column[6]['name'] = "House No.";
	$filter_column[6]['column_name'] = "leads.house_no";
	$filter_column[6]['code'] = "leads_house_no";
	$filter_column[6]['type'] = "varchar";
	$filter_column[6]['value_type'] = "text";

	$filter_column[7]['id'] = 7;
	$filter_column[7]['name'] = "Building/Soc.";
	$filter_column[7]['column_name'] = "leads.addressline1";
	$filter_column[7]['code'] = "leads_addressline1";
	$filter_column[7]['type'] = "varchar";
	$filter_column[7]['value_type'] = "text";

	// $filter_column[9]['id'] = 9;
	// $filter_column[9]['name'] = "Landmark";
	// $filter_column[9]['column_name'] = "leads.addressline2";
	// $filter_column[9]['code'] = "leads_addressline2";
	// $filter_column[9]['type'] = "varchar";
	// $filter_column[9]['value_type'] = "text";

	$filter_column[10]['id'] = 10;
	$filter_column[10]['name'] = "Area";
	$filter_column[10]['column_name'] = "leads.area";
	$filter_column[10]['code'] = "leads_area";
	$filter_column[10]['type'] = "varchar";
	$filter_column[10]['value_type'] = "text";

	$filter_column[11]['id'] = 11;
	$filter_column[11]['name'] = "Pincode";
	$filter_column[11]['column_name'] = "leads.pincode";
	$filter_column[11]['code'] = "leads_pincode";
	$filter_column[11]['type'] = "varchar";
	$filter_column[11]['value_type'] = "text";

	// CITY

	// $filter_column[13]['id'] = 13;
	// $filter_column[13]['name'] = "Meeting House No.";
	// $filter_column[13]['column_name'] = "leads.meeting_house_no";
	// $filter_column[13]['code'] = "leads_meeting_house_no";
	// $filter_column[13]['type'] = "varchar";
	// $filter_column[13]['value_type'] = "text";

	// $filter_column[14]['id'] = 14;
	// $filter_column[14]['name'] = "Meeting Building/Soc.";
	// $filter_column[14]['column_name'] = "leads.meeting_addressline1";
	// $filter_column[14]['code'] = "leads_meeting_addressline1";
	// $filter_column[14]['type'] = "varchar";
	// $filter_column[14]['value_type'] = "text";

	// $filter_column[15]['id'] = 15;
	// $filter_column[15]['name'] = "Meeting Landmark";
	// $filter_column[15]['column_name'] = "leads.meeting_addressline2";
	// $filter_column[15]['code'] = "leads_meeting_addressline2";
	// $filter_column[15]['type'] = "varchar";
	// $filter_column[15]['value_type'] = "text";

	// $filter_column[16]['id'] = 16;
	// $filter_column[16]['name'] = "Meeting Area";
	// $filter_column[16]['column_name'] = "leads.meeting_area";
	// $filter_column[16]['code'] = "leads_meeting_area";
	// $filter_column[16]['type'] = "varchar";
	// $filter_column[16]['value_type'] = "text";

	// $filter_column[17]['id'] = 17;
	// $filter_column[17]['name'] = "Meeting Pincode";
	// $filter_column[17]['column_name'] = "leads.meeting_pincode";
	// $filter_column[17]['code'] = "leads_meeting_pincode";
	// $filter_column[17]['type'] = "varchar";
	// $filter_column[17]['value_type'] = "text";

	$filter_column[18]['id'] = 18;
	$filter_column[18]['name'] = "Closing Date";
	$filter_column[18]['column_name'] = "leads.closing_date_time";
	$filter_column[18]['code'] = "leads_closing_date_time";
	$filter_column[18]['type'] = "date";
	$filter_column[18]['value_type'] = "date";

	$filter_column[19]['id'] = 19;
	$filter_column[19]['name'] = "Budget";
	$filter_column[19]['column_name'] = "leads.budget";
	$filter_column[19]['code'] = "leads_budget";
	$filter_column[19]['type'] = "bigint";
	$filter_column[19]['value_type'] = "text";

	$filter_column[20]['id'] = 20;
	$filter_column[20]['name'] = "Lead Owner";
	$filter_column[20]['column_name'] = "leads.assigned_to";
	$filter_column[20]['code'] = "leads_assigned_to";
	$filter_column[20]['type'] = "bigint";
	$filter_column[20]['value_type'] = "select";

	$filter_column[21]['id'] = 21;
	$filter_column[21]['name'] = "Created By";
	$filter_column[21]['column_name'] = "leads.created_by";
	$filter_column[21]['code'] = "leads_created_by";
	$filter_column[21]['type'] = "bigint";
	$filter_column[21]['value_type'] = "select";

	$filter_column[22]['id'] = 22;
	$filter_column[22]['name'] = "Source";
	$filter_column[22]['column_name'] = "lead_sources.source";
	$filter_column[22]['code'] = "leads_source";
	$filter_column[22]['type'] = "varchar";
	$filter_column[22]['value_type'] = "select";

	$filter_column[23]['id'] = 23;
	$filter_column[23]['name'] = "Site Stage";
	$filter_column[23]['column_name'] = "leads.site_stage";
	$filter_column[23]['code'] = "leads_site_stage";
	$filter_column[23]['type'] = "bigint";
	$filter_column[23]['value_type'] = "select";

	$filter_column[24]['id'] = 24;
	$filter_column[24]['name'] = "Competitor";
	$filter_column[24]['column_name'] = "leads.competitor";
	$filter_column[24]['code'] = "leads_competitor";
	$filter_column[24]['type'] = "varchar";
	$filter_column[24]['value_type'] = "select";

	$filter_column[25]['id'] = 25;
	$filter_column[25]['name'] = "Want To Cover";
	$filter_column[25]['column_name'] = "leads.want_to_cover";
	$filter_column[25]['code'] = "leads_want_to_cover";
	$filter_column[25]['type'] = "bigint";
	$filter_column[25]['value_type'] = "select";

	$filter_column[26]['id'] = 26;
	$filter_column[26]['name'] = "Created Date";
	$filter_column[26]['column_name'] = "leads.created_at";
	$filter_column[26]['code'] = "leads_created_at";
	$filter_column[26]['type'] = "date";
	$filter_column[26]['value_type'] = "date";

	$filter_column[27]['id'] = 27;
	$filter_column[27]['name'] = "Reward Claimed";
	$filter_column[27]['column_name'] = "lead_files.hod_approved";
	$filter_column[27]['code'] = "lead_files_hod_approved";
	$filter_column[27]['type'] = "tinyint";
	$filter_column[27]['value_type'] = "reward_select";

	return $filter_column;
}
function getFilterCondtionCRM()
{

	$filter_condtion = array();
	$filter_condtion[1]['id'] = 1;
	$filter_condtion[1]['name'] = "IS";
	$filter_condtion[1]['code'] = "is";
	$filter_condtion[1]['condtion'] = "=";
	$filter_condtion[1]['value_type'] = "single_select";

	$filter_condtion[2]['id'] = 2;
	$filter_condtion[2]['name'] = "Is Not";
	$filter_condtion[2]['code'] = "is_not";
	$filter_condtion[2]['condtion'] = "!=";
	$filter_condtion[2]['value_type'] = "single_select";

	$filter_condtion[3]['id'] = 3;
	$filter_condtion[3]['name'] = "Contains";
	$filter_condtion[3]['code'] = "contains";
	$filter_condtion[3]['condtion'] = "IN";
	$filter_condtion[3]['value_type'] = "multi_select";

	$filter_condtion[4]['id'] = 4;
	$filter_condtion[4]['name'] = "Doesn't Contains";
	$filter_condtion[4]['code'] = "not_contains";
	$filter_condtion[4]['condtion'] = "NOTIN";
	$filter_condtion[4]['value_type'] = "multi_select";

	$filter_condtion[5]['id'] = 5;
	$filter_condtion[5]['name'] = "Between";
	$filter_condtion[5]['code'] = "between";
	$filter_condtion[5]['condtion'] = "BETWEEN";
	$filter_condtion[5]['value_type'] = "between";


	return $filter_condtion;
}

function getDateFilterValue()
{

	$filter_clause = array();
	// $filter_clause[1]['id'] = 1;
	// $filter_clause[1]['name'] = "Today";
	// $filter_clause[1]['code'] = "today";
	// $filter_clause[1]['value'] = date('Y-m-d').','.date('Y-m-d');

	// $filter_clause[2]['id'] = 2;
	// $filter_clause[2]['name'] = "This Week";
	// $filter_clause[2]['code'] = "this_week";
	// $filter_clause[2]['value'] = date("Y-m-d",strtotime('next Monday -1 week')).','.date("Y-m-d",strtotime(date("Y-m-d",date('w', strtotime('next Monday -1 week'))==date('w') ? strtotime(date("Y-m-d",strtotime('next Monday -1 week'))." +7 days") : strtotime('next Monday -1 week'))." +6 days"));

	// $filter_clause[3]['id'] = 3;
	// $filter_clause[3]['name'] = "Next Week";
	// $filter_clause[3]['code'] = "next_week";
	// $filter_clause[3]['value'] = date("Y-m-d",strtotime('next Monday 0 week')).','.date("Y-m-d",strtotime(date("Y-m-d",date('w', strtotime('next Monday 0 week'))==date('w') ? strtotime(date("Y-m-d",strtotime('next Monday 0 week'))." +7 days") : strtotime('next Monday 0 week'))." +6 days"));

	// $filter_clause[4]['id'] = 4;
	// $filter_clause[4]['name'] = "Previous Week";
	// $filter_clause[4]['code'] = "previous_week";
	// $filter_clause[4]['value'] = date("Y-m-d",strtotime('next Monday -2 week')).','.date("Y-m-d",strtotime(date("Y-m-d",date('w', strtotime('next Monday -2 week'))==date('w') ? strtotime(date("Y-m-d",strtotime('next Monday -2 week'))." +7 days") : strtotime('next Monday -2 week'))." +6 days"));
	$filter_clause[1]['id'] = 1;
	$filter_clause[1]['name'] = "All Closing";
	$filter_clause[1]['code'] = "all_closing";
	$filter_clause[1]['value'] = date('Y-m-d') . ',' . date('Y-m-d');

	$filter_clause[2]['id'] = 2;
	$filter_clause[2]['name'] = "In This Week";
	$filter_clause[2]['code'] = "in_this_week";
	$filter_clause[2]['value'] = date("Y-m-d", strtotime('next Monday -1 week')) . ',' . date("Y-m-d", strtotime(date("Y-m-d", date('w', strtotime('next Monday -1 week')) == date('w') ? strtotime(date("Y-m-d", strtotime('next Monday -1 week')) . " +7 days") : strtotime('next Monday -1 week')) . " +6 days"));

	$filter_clause[3]['id'] = 3;
	$filter_clause[3]['name'] = "In This Month";
	$filter_clause[3]['code'] = "in_this_month";
	$filter_clause[3]['value'] = date("Y-m-d", strtotime('next Monday 0 week')) . ',' . date("Y-m-d", strtotime(date("Y-m-d", date('w', strtotime('next Monday 0 week')) == date('w') ? strtotime(date("Y-m-d", strtotime('next Monday 0 week')) . " +7 days") : strtotime('next Monday 0 week')) . " +6 days"));

	$filter_clause[4]['id'] = 4;
	$filter_clause[4]['name'] = "In Next Month";
	$filter_clause[4]['code'] = "in_next_month";
	$filter_clause[4]['value'] = date("Y-m-d", strtotime('next Monday -2 week')) . ',' . date("Y-m-d", strtotime(date("Y-m-d", date('w', strtotime('next Monday -2 week')) == date('w') ? strtotime(date("Y-m-d", strtotime('next Monday -2 week')) . " +7 days") : strtotime('next Monday -2 week')) . " +6 days"));

	$filter_clause[5]['id'] = 5;
	$filter_clause[5]['name'] = "In Next Two Month";
	$filter_clause[5]['code'] = "in_next_two_month";
	$filter_clause[5]['value'] = date("Y-m-d", strtotime('next Monday -2 week')) . ',' . date("Y-m-d", strtotime(date("Y-m-d", date('w', strtotime('next Monday -2 week')) == date('w') ? strtotime(date("Y-m-d", strtotime('next Monday -2 week')) . " +7 days") : strtotime('next Monday -2 week')) . " +6 days"));

	$filter_clause[6]['id'] = 6;
	$filter_clause[6]['name'] = "In Next Three Month";
	$filter_clause[6]['code'] = "in_next_three_month";
	$filter_clause[6]['value'] = date("Y-m-d", strtotime('next Monday -2 week')) . ',' . date("Y-m-d", strtotime(date("Y-m-d", date('w', strtotime('next Monday -2 week')) == date('w') ? strtotime(date("Y-m-d", strtotime('next Monday -2 week')) . " +7 days") : strtotime('next Monday -2 week')) . " +6 days"));

	// $filter_clause[5]['id'] = 5;
	// $filter_clause[5]['name'] = "This Month";
	// $filter_clause[5]['value'] = date("Y-m-d",strtotime('next Monday -2 week')).','.date("Y-m-d",strtotime(date("Y-m-d",date('w', strtotime('next Monday -2 week'))==date('w') ? strtotime(date("Y-m-d",strtotime('next Monday -2 week'))." +7 days") : strtotime('next Monday -2 week'))." +6 days"));



	return $filter_clause;
}

function getFilterClauseCRM()
{

	$filter_clause = array();
	$filter_clause[1]['id'] = 1;
	$filter_clause[1]['name'] = "And";
	$filter_clause[1]['clause'] = "where";

	$filter_clause[2]['id'] = 2;
	$filter_clause[2]['name'] = "Or";
	$filter_clause[2]['clause'] = "orwhere";

	return $filter_clause;
}

function saveLeadAndDealStatus($lead_id, $lead_new_status)
{
	$Lead_status = Lead::find($lead_id);
	if ($Lead_status) {
		$isstatus_change = 0;
		if ($Lead_status->status != $lead_new_status) {
			$oldStatus = $Lead_status->status;
			$newStatus = $lead_new_status;
			$isstatus_change = 1;
		}

		$leadStatus = getLeadStatus();
		if ($isstatus_change == 1) {
			$timeline = array();
			$timeline['lead_id'] = $Lead_status->id;
			$timeline['type'] = "lead-status-change";
			$timeline['reffrance_id'] = $Lead_status->id;
			$timeline['description'] = "Lead status changed from  " . $leadStatus[$oldStatus]['name'] . " to " . $leadStatus[$newStatus]['name'];
			saveLeadTimeline($timeline);
		}


		$Lead_status->status = $lead_new_status;
		$Lead_status->save();

		if ($Lead_status->status == 2) {

			$noOfCall = LeadCall::where('lead_id', $Lead_status->id)->count();
			if ($noOfCall > 4) {
				$Lead_status->status = 5;
				$Lead_status->save();
				$newStatus = $Lead_status->status;

				if ($oldStatus != $newStatus) {

					$leadStatus = getLeadStatus();

					$timeline = array();
					$timeline['lead_id'] = $Lead_status->id;
					$timeline['type'] = "lead-status-auto-change";
					$timeline['reffrance_id'] = $Lead_status->id;
					$timeline['description'] = "Lead status auto changed from  " . $leadStatus[$oldStatus]['name'] . " to " . $leadStatus[$newStatus]['name'] . " due to same status change ";
					saveLeadTimeline($timeline);
				}
			}
		}
		$response = successRes("Succssfully changed status");
		$response['id'] = $Lead_status->id;
	} else {
		$response = errorRes("Something went wrong");
	}
	return $response;
}

function saveLeadAndDealStatusInAction($lead_id, $lead_new_status, $ip = '', $entry_source = 'WEB')
{
	$leadStatus = getLeadStatus();

	$Lead_status = Lead::find($lead_id);

	$oldStatus = $Lead_status->status;
	$newStatus = $lead_new_status;

	if ($oldStatus != $newStatus) {

		$Lead_status->status = $newStatus;
		$Lead_status->updateip = $ip;
		$Lead_status->update_source = $entry_source;
		$Lead_status->save();

		if ($Lead_status) {

			$timeline = array();
			$timeline['lead_id'] = $Lead_status->id;
			$timeline['type'] = "lead-status-change";
			$timeline['reffrance_id'] = $Lead_status->id;
			$timeline['description'] = "Lead status changed from  " . $leadStatus[$oldStatus]['name'] . " to " . $leadStatus[$newStatus]['name'];
			saveLeadTimeline($timeline);

			$LeadStatusUpdate = new LeadStatusUpdate();
			$LeadStatusUpdate->lead_id = $Lead_status->id;
			$LeadStatusUpdate->old_status = $oldStatus;
			$LeadStatusUpdate->new_status = $newStatus;
			$LeadStatusUpdate->remark = "Status Change";

			$LeadStatusUpdate->entryby = Auth::user()->id;
			$LeadStatusUpdate->entryip = $ip;

			$LeadStatusUpdate->updateby = Auth::user()->id;
			$LeadStatusUpdate->updateip = $ip;
			$LeadStatusUpdate->save();

			$whatsapp_controller = new WhatsappApiContoller;
			$perameater_request = new Request();
			$mobileNO = $Lead_status->phone_number;

			$perameater_request['q_whatsapp_massage_mobileno'] = $mobileNO;
			$perameater_request['q_broadcast_name'] = $Lead_status->first_name . ' ' . $Lead_status->last_name;
			$perameater_request['q_whatsapp_massage_parameters'] = [
				array(
					"name" => "name",
					"value" => $Lead_status->first_name . ' ' . $Lead_status->last_name
				)
			];
			if ($newStatus == 4) {
				// STATUS MOVE TO DEMO MEETING DONE
				$perameater_request['q_whatsapp_massage_parameters'] = [
					array(
						"name" => "name",
						"value" => $Lead_status->first_name . ' ' . $Lead_status->last_name
					)
				];
				$perameater_request['q_whatsapp_massage_template'] = 'lead_status_demodone';
				$whatsapp_controller->sendTemplateMessage($perameater_request);
			} elseif ($newStatus == 102) {
				// STATUS MOVE TO TOKEN RECEIVE / ORDER CONFIRMED
				$perameater_request['q_whatsapp_massage_parameters'] = [
					array(
						"name" => "name",
						"value" => $Lead_status->first_name . ' ' . $Lead_status->last_name
					)
				];
				$perameater_request['q_whatsapp_massage_template'] = 'lead_status_token_received';
				$whatsapp_controller->sendTemplateMessage($perameater_request);
			} elseif ($newStatus == 103) {
				// STATUS MOVE TO WON
				$perameater_request['q_whatsapp_massage_parameters'] = [
					array(
						"name" => "name",
						"value" => $Lead_status->first_name . ' ' . $Lead_status->last_name
					),
					array(
						"name" => "image_url",
						"value" => "https://erp.whitelion.in/watti/installation_step.jpeg"
					)
				];
				$perameater_request['q_whatsapp_massage_template'] = 'lead_status_material_sent';
				$whatsapp_controller->sendTemplateMessage($perameater_request);
			}
		}
	}
}

// FOR USER ACTION START
function getUserNoteList($user_id)
{
	$UserUpdateList = UserNotes::query();
	$UserUpdateList->select('user_notes.id', 'user_notes.note', 'user_notes.user_id', 'user_notes.note_type', 'user_notes.note_title', 'created.first_name', 'created.last_name', 'user_notes.created_at');
	$UserUpdateList->leftJoin('users as created', 'created.id', '=', 'user_notes.entryby');
	$UserUpdateList->where('user_notes.user_id', $user_id);
	$UserUpdateList->orderBy('user_notes.id', 'desc');
	$UserUpdateList->limit(5);
	$UserUpdateList = $UserUpdateList->get();
	$UserUpdateList = json_encode($UserUpdateList);
	$UserUpdateList = json_decode($UserUpdateList, true);

	foreach ($UserUpdateList as $key => $value) {
		$UserUpdateList[$key]['message'] = strip_tags($value['note']);

		$UserUpdateList[$key]['created_at'] = convertDateTime($value['created_at']);
		$UserUpdateList[$key]['date'] = convertDateAndTime($value['created_at'], "date");
		$UserUpdateList[$key]['time'] = convertDateAndTime($value['created_at'], "time");
	}
	$data = array();
	$data['updates'] = $UserUpdateList;
	$response['view'] = view('user_action/detail_tab/detail_notes_tab', compact('data'))->render();
	$response['data'] = $UserUpdateList;
	return $response;
}

function getUserContactList($user_id)
{
	$UserContact = UserContact::query();
	$UserContact->select('crm_setting_contact_tag.name as tag_name', 'user_contact.*');
	$UserContact->leftJoin('crm_setting_contact_tag', 'crm_setting_contact_tag.id', '=', 'user_contact.contact_tag_id');
	$UserContact->where('user_contact.user_id', $user_id);
	$UserContact->orderBy('user_contact.id', 'desc');
	$UserContact->limit(5);
	$UserContact = $UserContact->get();

	foreach ($UserContact as $key => $value) {
		$UserContact[$key]['message'] = strip_tags($value['note']);

		$UserContact[$key]['created_at'] = $value['created_at'];
		$UserContact[$key]['date'] = convertDateAndTime($value['created_at'], "date");
		$UserContact[$key]['time'] = convertDateAndTime($value['created_at'], "time");
	}
	$data = array();
	$data['contacts'] = $UserContact;
	$data['user']['id'] = $user_id;
	$response['view'] = view('user_action/detail_tab/detail_contact_tab', compact('data'))->render();
	$response['data'] = $UserContact;
	return $response;
}

function getUserFileList($user_id)
{
	$UserFile = UserFiles::query();
	$UserFile->select('crm_setting_file_tag.name as tag_name', 'user_files.*', 'users.first_name', 'users.last_name');
	$UserFile->leftJoin('crm_setting_file_tag', 'crm_setting_file_tag.id', '=', 'user_files.file_tag_id');
	$UserFile->leftJoin('users', 'users.id', '=', 'user_files.entryby');
	$UserFile->where('user_files.user_id', $user_id);
	$UserFile->limit(5);
	$UserFile->orderBy('user_files.id', 'desc');
	$UserFile = $UserFile->get();
	$UserFile = json_encode($UserFile);
	$UserFile = json_decode($UserFile, true);

	foreach ($UserFile as $key => $value) {
		$name = explode("/", $value['name']);

		$UserFile[$key]['name'] = end($name);
		$UserFile[$key]['download'] = getSpaceFilePath($value['name']);
		$UserFile[$key]['created_at'] = convertDateTime($value['created_at']);
	}
	$data = array();
	$data['user']['id'] = $user_id;
	$data['files'] = $UserFile;
	$response['view'] = view('user_action/detail_tab/detail_file_tab', compact('data'))->render();
	$response['data'] = $UserFile;
	return $response;
}

function getUserAllOpenList($user_id)
{

	// ACTION CALL START
	$UserCall = UserCallAction::query();
	$UserCall->select('user_call_action.*', 'users.first_name', 'users.last_name');
	$UserCall->where('user_call_action.user_id', $user_id);
	$UserCall->where('is_closed', 0);
	$UserCall->leftJoin('users', 'users.id', '=', 'user_call_action.user_id');
	$UserCall->orderBy('user_call_action.id', 'desc');
	$UserCall = $UserCall->get();
	$UserCall = json_encode($UserCall);
	$UserCall = json_decode($UserCall, true);
	foreach ($UserCall as $key => $value) {
		$UserCall[$key]['date'] = convertDateAndTime($value['call_schedule'], "date");
		$UserCall[$key]['time'] = convertDateAndTime($value['call_schedule'], "time");
		$ContactName = UserContact::select('user_contact.id', 'user_contact.first_name', 'user_contact.last_name', DB::raw("CONCAT(user_contact.first_name,' ',user_contact.last_name) AS text"));
		$ContactName->where('user_contact.id', $value['contact_person']);
		$ContactName = $ContactName->first();
		if ($ContactName) {
			$UserCall[$key]['contact_name'] = $ContactName->text;
		} else {
			$UserCall[$key]['contact_name'] = "";
		}
	}
	// ACTION CALL END

	//  ACTION MEETING START
	$UserMeeting = UserMeetingAction::query();
	$UserMeeting->select('user_meeting_action.*', 'users.first_name', 'users.last_name');
	$UserMeeting->where('user_meeting_action.user_id', $user_id);
	$UserMeeting->where('is_closed', 0);
	$UserMeeting->leftJoin('users', 'users.id', '=', 'user_meeting_action.user_id');
	$UserMeeting->orderBy('user_meeting_action.id', 'desc');
	$UserMeeting = $UserMeeting->get();
	$UserMeeting = json_encode($UserMeeting);
	$UserMeeting = json_decode($UserMeeting, true);
	foreach ($UserMeeting as $key => $value) {
		$UserMeeting[$key]['date'] = convertDateAndTime($value['meeting_date_time'], "date");
		$UserMeeting[$key]['time'] = convertDateAndTime($value['meeting_date_time'], "time");

		$UserMeetingTitle = CRMSettingMeetingTitle::select('name')->where('id', $value['title_id'])->first();

		if ($UserMeetingTitle) {
			$UserMeeting[$key]['title_name'] = $UserMeetingTitle->name;
		} else {
			$UserMeeting[$key]['title_name'] = $UserMeetingTitle->name;
		}


		$UserMeetingParticipant = UserMeetingParticipant::where('meeting_id', $value['id'])->orderby('id', 'asc')->get();
		$UserMeetingParticipant = json_decode(json_encode($UserMeetingParticipant), true);

		$UsersId = array();
		$ContactIds = array();
		foreach ($UserMeetingParticipant as $sales_key => $value) {
			if ($value['type'] == "users") {
				$UsersId[] = $value['participant_id'];
			} elseif ($value['type'] == "lead_contacts") {
				$ContactIds[] = $value['participant_id'];
			}
		}

		$UserResponse = "";
		if (count($ContactIds) > 0) {
			$LeadContact = UserContact::select('user_contact.id', 'user_contact.first_name', 'user_contact.last_name', DB::raw("CONCAT(user_contact.first_name,' ',user_contact.last_name) AS full_name"));
			$LeadContact->whereIn('user_contact.id', $ContactIds);
			$LeadContact = $LeadContact->get();
			if (count($LeadContact) > 0) {
				foreach ($LeadContact as $User_key => $User_value) {
					$UserResponse .= "Contact - " . $User_value['full_name'] . '<br>';
				}
			}
		}

		if (count($UsersId) > 0) {
			$User = User::select('users.id', 'users.type', 'users.first_name', 'users.last_name', DB::raw("CONCAT(users.first_name,' ',users.last_name) AS full_name"));
			$User->whereIn('users.id', $UsersId);
			$User = $User->get();
			$getAllUserTypes = getAllUserTypes();
			if (count($User) > 0) {
				foreach ($User as $User_key => $User_value) {
					$UserResponse .= $getAllUserTypes[$User_value['type']]['short_name'] . " - " . $User_value['full_name'] . '<br>';
				}
			}
		}



		if ($UserResponse) {
			$UserMeeting[$key]['meeting_participant'] = $UserResponse;
		} else {
			$UserMeeting[$key]['meeting_participant'] = "";
		}
	}
	//  ACTION MEETING END

	// ACTION TASK START
	$UserTask = UserTaskAction::query();
	$UserTask->select('user_task_action.*', 'users.first_name', 'users.last_name');
	$UserTask->where('user_task_action.user_id', $user_id);
	$UserTask->where('is_closed', 0);
	$UserTask->leftJoin('users', 'users.id', '=', 'user_task_action.user_id');
	$UserTask->orderBy('user_task_action.id', 'desc');
	$UserTask = $UserTask->get();
	$UserTask = json_encode($UserTask);
	$UserTask = json_decode($UserTask, true);
	foreach ($UserTask as $key => $value) {
		$UserTask[$key]['date'] = convertDateAndTime($value['due_date_time'], "date");
		$UserTask[$key]['time'] = convertDateAndTime($value['due_date_time'], "time");

		$Taskowner = User::select('users.id', DB::raw("CONCAT(users.first_name,' ',users.last_name) AS text"));
		$Taskowner->where('users.status', 1);
		$Taskowner->where('users.id', $value['assign_to']);
		$Taskowner = $Taskowner->first();

		if ($Taskowner) {
			$UserTask[$key]['task_owner'] = $Taskowner->text;
		} else {
			$UserTask[$key]['task_owner'] = " ";
		}
	}
	// ACTION TASK END

	$data = array();
	$data['calls'] = $UserCall;
	$data['meetings'] = $UserMeeting;
	$data['task'] = $UserTask;
	$data['max_open_actions'] = max(count($UserCall), count($UserMeeting), count($UserTask));
	$data['user']['id'] = $user_id;
	$response['view'] = view('user_action/detail_tab/detail_open_action_tab', compact('data'))->render();
	$response['max_open_actions'] = max(count($UserCall), count($UserMeeting), count($UserTask));
	$response['call_data'] = $UserCall;
	$response['meeting_data'] = $UserMeeting;
	$response['task_data'] = $UserTask;
	return $response;
}

function getUserAllCloseList($user_id)
{
	// ACTION CLOSE CALL START
	$UserCallClosed = UserCallAction::query();
	$UserCallClosed->select('user_call_action.*', 'users.first_name', 'users.last_name');
	$UserCallClosed->where('user_call_action.user_id', $user_id);
	$UserCallClosed->where('is_closed', 1);
	$UserCallClosed->leftJoin('users', 'users.id', '=', 'user_call_action.user_id');
	$UserCallClosed->orderBy('user_call_action.closed_date_time', 'desc');
	$UserCallClosed = $UserCallClosed->get();
	$UserCallClosed = json_encode($UserCallClosed);
	$UserCallClosed = json_decode($UserCallClosed, true);
	foreach ($UserCallClosed as $key => $value) {
		$UserCallClosed[$key]['date'] = convertDateAndTime($value['closed_date_time'], "date");
		$UserCallClosed[$key]['time'] = convertDateAndTime($value['closed_date_time'], "time");
		$ContactName = UserContact::select('user_contact.id', 'user_contact.first_name', 'user_contact.last_name', DB::raw("CONCAT(user_contact.first_name,' ',user_contact.last_name) AS text"));
		$ContactName->where('user_contact.id', $value['contact_person']);
		$ContactName = $ContactName->first();
		if ($ContactName) {
			$UserCallClosed[$key]['contact_name'] = $ContactName->text;
		} else {
			$UserCallClosed[$key]['contact_name'] = "";
		}
	}
	// ACTION CLOSE CALL END

	// ACTION CLOSE MEETING START
	$UserMeetingClosed = UserMeetingAction::query();
	$UserMeetingClosed->select('user_meeting_action.*', 'users.first_name', 'users.last_name');
	$UserMeetingClosed->where('user_meeting_action.user_id', $user_id);
	$UserMeetingClosed->where('is_closed', 1);
	$UserMeetingClosed->leftJoin('users', 'users.id', '=', 'user_meeting_action.user_id');
	$UserMeetingClosed->orderBy('user_meeting_action.closed_date_time', 'desc');
	$UserMeetingClosed = $UserMeetingClosed->get();
	$UserMeetingClosed = json_encode($UserMeetingClosed);
	$UserMeetingClosed = json_decode($UserMeetingClosed, true);
	foreach ($UserMeetingClosed as $key => $value) {
		$UserMeetingClosed[$key]['date'] = convertDateAndTime($value['closed_date_time'], "date");
		$UserMeetingClosed[$key]['time'] = convertDateAndTime($value['closed_date_time'], "time");

		$UserMeetingTitle = CRMSettingMeetingTitle::select('name')->where('id', $value['title_id'])->first();
		if ($UserMeetingTitle) {
			$UserMeetingClosed[$key]['title_name'] = $UserMeetingTitle->name;
		} else {
			$UserMeetingClosed[$key]['title_name'] = " ";
		}

		$UserMeetingParticipant = UserMeetingParticipant::where('meeting_id', $value['id'])->orderby('id', 'asc')->get();
		$UserMeetingParticipant = json_decode(json_encode($UserMeetingParticipant), true);

		$UsersId = array();
		$ContactIds = array();
		foreach ($UserMeetingParticipant as $sales_key => $value) {
			if ($value['type'] == "users") {
				$UsersId[] = $value['participant_id'];
			} elseif ($value['type'] == "lead_contacts") {
				$ContactIds[] = $value['participant_id'];
			}
		}

		$UserResponse = "";
		if (count($ContactIds) > 0) {
			$LeadContact = UserContact::select('user_contact.id', DB::raw("CONCAT(user_contact.first_name,' ',user_contact.last_name) AS full_name"));
			$LeadContact->whereIn('user_contact.id', $ContactIds);
			$LeadContact = $LeadContact->get();
			if (count($LeadContact) > 0) {
				foreach ($LeadContact as $User_key => $User_value) {
					$UserResponse .= "Contact - " . $User_value['full_name'] . '<br>';
				}
			}
		}

		if (count($UsersId) > 0) {
			$User = User::select('users.id', 'users.type', DB::raw("CONCAT(users.first_name,' ',users.last_name) AS full_name"));
			$User->whereIn('users.id', $UsersId);
			$User = $User->get();
			if (count($User) > 0) {
				foreach ($User as $User_key => $User_value) {
					$UserResponse .= getAllUserTypes()[$User_value['type']]['short_name'] . " - " . $User_value['full_name'] . '<br>';
				}
			}
		}

		if ($UserResponse) {
			$UserMeetingClosed[$key]['meeting_participant'] = $UserResponse;
		} else {
			$UserMeetingClosed[$key]['meeting_participant'] = "";
		}
	}
	// ACTION CLOSE MEETING END

	// ACTION CLOSE TASK START
	$UserTaskClosed = UserTaskAction::query();
	$UserTaskClosed->select('user_task_action.*', 'users.first_name', 'users.last_name');
	$UserTaskClosed->where('user_task_action.user_id', $user_id);
	$UserTaskClosed->where('is_closed', 1);
	$UserTaskClosed->leftJoin('users', 'users.id', '=', 'user_task_action.user_id');
	$UserTaskClosed->orderBy('user_task_action.closed_date_time', 'desc');
	$UserTaskClosed = $UserTaskClosed->get();
	$UserTaskClosed = json_encode($UserTaskClosed);
	$UserTaskClosed = json_decode($UserTaskClosed, true);
	foreach ($UserTaskClosed as $key => $value) {
		$UserTaskClosed[$key]['date'] = convertDateAndTime($value['closed_date_time'], "date");
		$UserTaskClosed[$key]['time'] = convertDateAndTime($value['closed_date_time'], "time");

		$Taskowner = User::select('users.id', DB::raw("CONCAT(users.first_name,' ',users.last_name) AS text"));
		$Taskowner->where('users.status', 1);
		$Taskowner->where('users.id', $value['assign_to']);
		$Taskowner = $Taskowner->first();

		if ($Taskowner) {
			$UserTaskClosed[$key]['task_owner'] = $Taskowner->text;
		} else {
			$UserTaskClosed[$key]['task_owner'] = " ";
		}
	}
	// ACTION CLOSE TASK END

	$data = array();
	$data['calls_closed'] = $UserCallClosed;
	$data['meetings_closed'] = $UserMeetingClosed;
	$data['task_closed'] = $UserTaskClosed;
	$data['max_close_actions'] = max(count($UserCallClosed), count($UserMeetingClosed), count($UserTaskClosed));
	$data['user']['id'] = $user_id;
	$response['view'] = view('user_action/detail_tab/detail_close_action_tab', compact('data'))->render();
	$response['max_close_actions'] = max(count($UserCallClosed), count($UserMeetingClosed), count($UserTaskClosed));
	$response['close_call_data'] = $UserCallClosed;
	$response['close_meeting_data'] = $UserMeetingClosed;
	$response['close_task_data'] = $UserTaskClosed;
	return $response;
}

function getUserTimelineList($user_id)
{
	$UserLog = UserLog::select('user_log.*', 'users.first_name', 'users.last_name')->leftJoin('users', 'users.id', '=', 'user_log.user_id')->where('user_log.user_id', $user_id)->orderBy('id', 'desc')->get();

	$UserLog = json_encode($UserLog);
	$UserLog = json_decode($UserLog, true);

	$repeated_date = '';
	foreach ($UserLog as $key => $value) {
		$date = convertDateAndTime($value['created_at'], "date");
		if ($repeated_date == $date) {
			$UserLog[$key]['date'] = 0;
		} else {
			$repeated_date = $date;
			$UserLog[$key]['date'] = convertDateAndTime($value['created_at'], "date");
		}
		$UserLog[$key]['created_date'] = convertDateAndTime($value['created_at'], "date");
		$UserLog[$key]['time'] = convertDateAndTime($value['created_at'], "time");
		$UserLog[$key]['created_at'] = convertDateTime($value['created_at']);
		$UserLog[$key]['updated_at'] = convertDateTime($value['updated_at']);
	}

	$data['timeline'] = $UserLog;

	$data = array();
	$data['user']['id'] = $user_id;
	$data['timeline'] = $UserLog;
	$response['view'] = view('user_action/detail_tab/detail_user_timeline_tab', compact('data'))->render();
	$response['data'] = $UserLog;
	return $response;
}

// FOR USER ACTION START

function saveUserLog($params)
{

	$UserLog = new UserLog();
	$UserLog->user_id = $params['user_id'];
	$UserLog->log_type = $params['log_type'];
	$UserLog->field_name = $params['field_name'];
	$UserLog->old_value = $params['old_value'];
	$UserLog->new_value = $params['new_value'];
	$UserLog->reference_type = $params['reference_type'];
	$UserLog->reference_id = $params['reference_id'];
	$UserLog->transaction_type = $params['transaction_type'];
	$UserLog->description = $params['description'];
	$UserLog->source = $params['source'];
	$UserLog->entryby = Auth::user()->id;
	$UserLog->entryip = $params['ip'];
	$UserLog->save();
}


function saveUserStatus($user_id, $user_new_status, $ip = '', $entry_source = 'WEB')
{
	$userStatus = getArchitectsStatus();

	$User_status = User::find($user_id);

	$Architect = Architect::select('*')->where("user_id", $user_id)->first();

	$Electrician = Electrician::select('*')->where("user_id", $user_id)->first();

	$oldStatus = $User_status->status;
	$newStatus = $user_new_status;

	if ($oldStatus != $newStatus) {
		if ($Architect) {
			if ($user_new_status == 3 || $user_new_status == 4) {
				$User_status->status = 2;
			} else {
				$User_status->status = $user_new_status;
			}
			$Architect->status = $user_new_status;
			$Architect->save();
		} else if ($Electrician) {
			if ($user_new_status == 3 || $user_new_status == 4) {
				$User_status->status = 2;
			} else {
				$User_status->status = $user_new_status;
			}
			$Electrician->status = $user_new_status;
			$Electrician->save();
		}
		$User_status->save();



		if ($User_status) {
			$timeline = array();
			$timeline['user_id'] = $User_status->id;
			$timeline['log_type'] = "user";
			$timeline['field_name'] = "status";
			$timeline['old_value'] = $oldStatus;
			$timeline['new_value'] = $newStatus;
			$timeline['reference_type'] = "user";
			$timeline['reference_id'] = "0";
			if ($oldStatus == 6) {
				$timeline['transaction_type'] = "Create";
				if ($Architect) {
					$timeline['description'] = "Architect Created by " . Auth::user()->first_name . " " . Auth::user()->last_name;
				} else if ($Electrician) {
					$timeline['description'] = "Electrician Created by " . Auth::user()->first_name . " " . Auth::user()->last_name;
				}
			} else {
				$timeline['transaction_type'] = "update";
				$timeline['description'] = "User status changed from  " . $userStatus[$oldStatus]['name'] . " to " . $userStatus[$newStatus]['name'] . " by " . Auth::user()->first_name . " " . Auth::user()->last_name;
			}
			$timeline['source'] = $entry_source;
			$timeline['ip'] = $ip;
			saveUserLog($timeline);
		}
	}
}

function getTimeSlot()
{
	$timeSlot = array();
	$strtotimeStart = strtotime(date('h:00:00'));
	$latestDateTime = date('h:00:00', $strtotimeStart);
	$i = 0;
	$timeSlot[$i] = date('h:i A', strtotime($latestDateTime));
	for ($i = 1; $i < 48; $i++) {
		$timeSlot[$i] = date('h:i A', strtotime($latestDateTime . " +30 minutes"));
		$latestDateTime = $timeSlot[$i];
	}
	return $timeSlot;
}

function getReminderTimeSlot($dateTime = '')
{

	if ($dateTime != 0 && $dateTime != '') {
		$dateTime = $dateTime;
	} else {
		$dateTime = date('Y-m-d H:i:s');
	}

	$reminderTimeSlot = array();
	$reminderTimeSlot[1]['id'] = 1;
	$reminderTimeSlot[1]['name'] = "15 Min Before";
	$reminderTimeSlot[1]['datetime'] = date('Y-m-d H:i:s', strtotime($dateTime . " -15 minutes"));
	$reminderTimeSlot[1]['minute'] = 15;

	$reminderTimeSlot[2]['id'] = 2;
	$reminderTimeSlot[2]['name'] = "30 Min Before";
	$reminderTimeSlot[2]['datetime'] = date('Y-m-d H:i:s', strtotime($dateTime . " -30 minutes"));
	$reminderTimeSlot[2]['minute'] = 30;

	$reminderTimeSlot[3]['id'] = 3;
	$reminderTimeSlot[3]['name'] = "1 Hour Before";
	$reminderTimeSlot[3]['datetime'] = date('Y-m-d H:i:s', strtotime($dateTime . " -1 hours"));
	$reminderTimeSlot[3]['minute'] = 60;

	$reminderTimeSlot[4]['id'] = 4;
	$reminderTimeSlot[4]['name'] = "1 Day Before";
	$reminderTimeSlot[4]['datetime'] = date('Y-m-d H:i:s', strtotime($dateTime . " -1 days"));
	$reminderTimeSlot[4]['minute'] = 1440; // (24*60)

	return $reminderTimeSlot;
}

function getArchitectFilterColumn()
{

	$filter_column = array();
	$filter_column[1]['id'] = 1;
	$filter_column[1]['name'] = "#id";
	$filter_column[1]['column_name'] = "users.id";
	$filter_column[1]['code'] = "user_id";
	$filter_column[1]['type'] = "bigint";
	$filter_column[1]['value_type'] = "text";

	$filter_column[2]['id'] = 2;
	$filter_column[2]['name'] = "User Type";
	$filter_column[2]['column_name'] = "architect.type";
	$filter_column[2]['code'] = "user_type";
	$filter_column[2]['type'] = "varchar";
	$filter_column[2]['value_type'] = "select";

	$filter_column[3]['id'] = 3;
	$filter_column[3]['name'] = "Total Point";
	$filter_column[3]['column_name'] = "architect.total_point";
	$filter_column[3]['code'] = "user_total_point";
	$filter_column[3]['type'] = "varchar";
	$filter_column[3]['value_type'] = "select_order_by";

	$filter_column[4]['id'] = 4;
	$filter_column[4]['name'] = "Account Owner";
	$filter_column[4]['column_name'] = "architect.sale_person_id";
	$filter_column[4]['code'] = "account_owner";
	$filter_column[4]['type'] = "varchar";
	$filter_column[4]['value_type'] = "select";

	$filter_column[5]['id'] = 5;
	$filter_column[5]['name'] = "Account Name";
	$filter_column[5]['column_name'] = "users.first_name";
	$filter_column[5]['code'] = "account_name";
	$filter_column[5]['type'] = "varchar";
	$filter_column[5]['value_type'] = "text";

	$filter_column[6]['id'] = 6;
	$filter_column[6]['name'] = "Mobile number";
	$filter_column[6]['column_name'] = "users.phone_number";
	$filter_column[6]['code'] = "user_phone_number";
	$filter_column[6]['type'] = "varchar";
	$filter_column[6]['value_type'] = "text";

	$filter_column[7]['id'] = 7;
	$filter_column[7]['name'] = "Email";
	$filter_column[7]['column_name'] = "users.email";
	$filter_column[7]['code'] = "user_email";
	$filter_column[7]['type'] = "varchar";
	$filter_column[7]['value_type'] = "text";

	$filter_column[8]['id'] = 8;
	$filter_column[8]['name'] = "City";
	$filter_column[8]['column_name'] = "users.city_id";
	$filter_column[8]['code'] = "user_city_id";
	$filter_column[8]['type'] = "varchar";
	$filter_column[8]['value_type'] = "select";

	$filter_column[9]['id'] = 9;
	$filter_column[9]['name'] = "Status";
	$filter_column[9]['column_name'] = "users.status";
	$filter_column[9]['code'] = "user_status";
	$filter_column[9]['type'] = "tinyint";
	$filter_column[9]['value_type'] = "select";


	$filter_column[10]['id'] = 10;
	$filter_column[10]['name'] = "Created By";
	$filter_column[10]['column_name'] = "users.created_by";
	$filter_column[10]['code'] = "user_created_by";
	$filter_column[10]['type'] = "bigint";
	$filter_column[10]['value_type'] = "select";

	$filter_column[11]['id'] = 11;
	$filter_column[11]['name'] = "Created Date";
	$filter_column[11]['column_name'] = "users.created_at";
	$filter_column[11]['code'] = "user_created_at";
	$filter_column[11]['type'] = "date";
	$filter_column[11]['value_type'] = "date";

	$filter_column[12]['id'] = 12;
	$filter_column[12]['name'] = "Tag";
	$filter_column[12]['column_name'] = "users.tag";
	$filter_column[12]['code'] = "user_tag";
	$filter_column[12]['type'] = "varchar";
	$filter_column[12]['value_type'] = "select";

	return $filter_column;
}

function getElectricianFilterColumn()
{

	$filter_column = array();
	$filter_column[1]['id'] = 1;
	$filter_column[1]['name'] = "#id";
	$filter_column[1]['column_name'] = "users.id";
	$filter_column[1]['code'] = "user_id";
	$filter_column[1]['type'] = "bigint";
	$filter_column[1]['value_type'] = "text";

	$filter_column[2]['id'] = 2;
	$filter_column[2]['name'] = "User Type";
	$filter_column[2]['column_name'] = "electrician.type";
	$filter_column[2]['code'] = "user_type";
	$filter_column[2]['type'] = "varchar";
	$filter_column[2]['value_type'] = "select";

	$filter_column[3]['id'] = 3;
	$filter_column[3]['name'] = "Total Point";
	$filter_column[3]['column_name'] = "electrician.total_point";
	$filter_column[3]['code'] = "user_total_point";
	$filter_column[3]['type'] = "varchar";
	$filter_column[3]['value_type'] = "select_order_by";

	$filter_column[4]['id'] = 4;
	$filter_column[4]['name'] = "Account Owner";
	$filter_column[4]['column_name'] = "electrician.sale_person_id";
	$filter_column[4]['code'] = "account_owner";
	$filter_column[4]['type'] = "varchar";
	$filter_column[4]['value_type'] = "select";

	$filter_column[5]['id'] = 5;
	$filter_column[5]['name'] = "Account Name";
	$filter_column[5]['column_name'] = "users.first_name";
	$filter_column[5]['code'] = "account_name";
	$filter_column[5]['type'] = "varchar";
	$filter_column[5]['value_type'] = "text";

	$filter_column[6]['id'] = 6;
	$filter_column[6]['name'] = "Mobile number";
	$filter_column[6]['column_name'] = "users.phone_number";
	$filter_column[6]['code'] = "user_phone_number";
	$filter_column[6]['type'] = "varchar";
	$filter_column[6]['value_type'] = "text";

	$filter_column[7]['id'] = 7;
	$filter_column[7]['name'] = "Email";
	$filter_column[7]['column_name'] = "users.email";
	$filter_column[7]['code'] = "user_email";
	$filter_column[7]['type'] = "varchar";
	$filter_column[7]['value_type'] = "text";

	$filter_column[8]['id'] = 8;
	$filter_column[8]['name'] = "City";
	$filter_column[8]['column_name'] = "users.city_id";
	$filter_column[8]['code'] = "user_city_id";
	$filter_column[8]['type'] = "varchar";
	$filter_column[8]['value_type'] = "select";

	$filter_column[9]['id'] = 9;
	$filter_column[9]['name'] = "Status";
	$filter_column[9]['column_name'] = "users.status";
	$filter_column[9]['code'] = "user_status";
	$filter_column[9]['type'] = "tinyint";
	$filter_column[9]['value_type'] = "select";

	$filter_column[10]['id'] = 10;
	$filter_column[10]['name'] = "Created By";
	$filter_column[10]['column_name'] = "users.created_by";
	$filter_column[10]['code'] = "user_created_by";
	$filter_column[10]['type'] = "bigint";
	$filter_column[10]['value_type'] = "select";

	$filter_column[11]['id'] = 11;
	$filter_column[11]['name'] = "Created Date";
	$filter_column[11]['column_name'] = "users.created_at";
	$filter_column[11]['code'] = "user_created_at";
	$filter_column[11]['type'] = "date";
	$filter_column[11]['value_type'] = "date";

	$filter_column[12]['id'] = 12;
	$filter_column[12]['name'] = "Tag";
	$filter_column[12]['column_name'] = "users.tag";
	$filter_column[12]['code'] = "user_tag";
	$filter_column[12]['type'] = "varchar";
	$filter_column[12]['value_type'] = "select";

	return $filter_column;
}

function getUserFilterCondtion()
{

	$filter_condtion = array();
	$filter_condtion[1]['id'] = 1;
	$filter_condtion[1]['name'] = "IS";
	$filter_condtion[1]['code'] = "is";
	$filter_condtion[1]['condtion'] = "=";
	$filter_condtion[1]['value_type'] = "single_select";

	$filter_condtion[2]['id'] = 2;
	$filter_condtion[2]['name'] = "Is Not";
	$filter_condtion[2]['code'] = "is_not";
	$filter_condtion[2]['condtion'] = "!=";
	$filter_condtion[2]['value_type'] = "single_select";

	$filter_condtion[3]['id'] = 3;
	$filter_condtion[3]['name'] = "Contains";
	$filter_condtion[3]['code'] = "contains";
	$filter_condtion[3]['condtion'] = "IN";
	$filter_condtion[3]['value_type'] = "multi_select";

	$filter_condtion[4]['id'] = 4;
	$filter_condtion[4]['name'] = "Doesn't Contains";
	$filter_condtion[4]['code'] = "not_contains";
	$filter_condtion[4]['condtion'] = "NOTIN";
	$filter_condtion[4]['value_type'] = "multi_select";

	$filter_condtion[5]['id'] = 5;
	$filter_condtion[5]['name'] = "Between";
	$filter_condtion[5]['code'] = "between";
	$filter_condtion[5]['condtion'] = "BETWEEN";
	$filter_condtion[5]['value_type'] = "between";

	return $filter_condtion;
}

function getUserFilterClause()
{

	$filter_clause = array();
	$filter_clause[1]['id'] = 1;
	$filter_clause[1]['name'] = "And";
	$filter_clause[1]['clause'] = "where";

	$filter_clause[2]['id'] = 2;
	$filter_clause[2]['name'] = "Or";
	$filter_clause[2]['clause'] = "orwhere";

	return $filter_clause;
}

function getPointValue()
{
	$point_clause = array();

	$point_clause[1]['id'] = 1;
	$point_clause[1]['name'] = "Sort By Max Point";
	$point_clause[1]['code'] = "short_by_max_point";

	$point_clause[2]['id'] = 2;
	$point_clause[2]['name'] = "Sort By Min Point";
	$point_clause[2]['code'] = "short_by_min_point";

	return $point_clause;
}

function getUserDateFilterValue()
{

	$filter_clause = array();
	$filter_clause[1]['id'] = 1;
	$filter_clause[1]['name'] = "All Date";
	$filter_clause[1]['code'] = "all_closing";
	$filter_clause[1]['value'] = date('Y-m-d') . ',' . date('Y-m-d');

	$filter_clause[2]['id'] = 2;
	$filter_clause[2]['name'] = "In This Week";
	$filter_clause[2]['code'] = "in_this_week";
	$filter_clause[2]['value'] = date("Y-m-d", strtotime('next Monday -1 week')) . ',' . date("Y-m-d", strtotime(date("Y-m-d", date('w', strtotime('next Monday -1 week')) == date('w') ? strtotime(date("Y-m-d", strtotime('next Monday -1 week')) . " +7 days") : strtotime('next Monday -1 week')) . " +6 days"));

	$filter_clause[3]['id'] = 3;
	$filter_clause[3]['name'] = "In This Month";
	$filter_clause[3]['code'] = "in_this_month";
	$filter_clause[3]['value'] = date("Y-m-d", strtotime('next Monday 0 week')) . ',' . date("Y-m-d", strtotime(date("Y-m-d", date('w', strtotime('next Monday 0 week')) == date('w') ? strtotime(date("Y-m-d", strtotime('next Monday 0 week')) . " +7 days") : strtotime('next Monday 0 week')) . " +6 days"));

	$filter_clause[4]['id'] = 4;
	$filter_clause[4]['name'] = "In Next Month";
	$filter_clause[4]['code'] = "in_next_month";
	$filter_clause[4]['value'] = date("Y-m-d", strtotime('next Monday -2 week')) . ',' . date("Y-m-d", strtotime(date("Y-m-d", date('w', strtotime('next Monday -2 week')) == date('w') ? strtotime(date("Y-m-d", strtotime('next Monday -2 week')) . " +7 days") : strtotime('next Monday -2 week')) . " +6 days"));

	$filter_clause[5]['id'] = 5;
	$filter_clause[5]['name'] = "In Next Two Month";
	$filter_clause[5]['code'] = "in_next_two_month";
	$filter_clause[5]['value'] = date("Y-m-d", strtotime('next Monday -2 week')) . ',' . date("Y-m-d", strtotime(date("Y-m-d", date('w', strtotime('next Monday -2 week')) == date('w') ? strtotime(date("Y-m-d", strtotime('next Monday -2 week')) . " +7 days") : strtotime('next Monday -2 week')) . " +6 days"));

	$filter_clause[6]['id'] = 6;
	$filter_clause[6]['name'] = "In Next Three Month";
	$filter_clause[6]['code'] = "in_next_three_month";
	$filter_clause[6]['value'] = date("Y-m-d", strtotime('next Monday -2 week')) . ',' . date("Y-m-d", strtotime(date("Y-m-d", date('w', strtotime('next Monday -2 week')) == date('w') ? strtotime(date("Y-m-d", strtotime('next Monday -2 week')) . " +7 days") : strtotime('next Monday -2 week')) . " +6 days"));

	return $filter_clause;
}

function getInquiryTransferToLeadUserList()
{
	// 5515 New User
	return [4190, 4, 4344, 37, 5262, 4425, 1233, 3352, 29, 36, 5515];
}

function getIntervalTime()
{

	$intervalTime = array();
	$intervalTime[1]['id'] = 1;
	$intervalTime[1]['name'] = "30 Min";
	$intervalTime[1]['code'] = " +30 minutes ";
	$intervalTime[1]['minute'] = 30;

	$intervalTime[2]['id'] = 2;
	$intervalTime[2]['name'] = "1 Hour";
	$intervalTime[2]['code'] = " +1 hours ";
	$intervalTime[2]['minute'] = 60;

	$intervalTime[3]['id'] = 3;
	$intervalTime[3]['name'] = "1.5 Hours";
	$intervalTime[3]['code'] = " +1 hours +30 minutes ";
	$intervalTime[3]['minute'] = 90;

	$intervalTime[4]['id'] = 4;
	$intervalTime[4]['name'] = "2 Hours";
	$intervalTime[4]['code'] = " +2 hours ";
	$intervalTime[4]['minute'] = 120;

	$intervalTime[5]['id'] = 5;
	$intervalTime[5]['name'] = "2.5 Hours";
	$intervalTime[5]['code'] = " +2 hours +30 minutes ";
	$intervalTime[5]['minute'] = 150;

	$intervalTime[6]['id'] = 6;
	$intervalTime[6]['name'] = "3 Hours";
	$intervalTime[6]['code'] = " +3 hours ";
	$intervalTime[6]['minute'] = 180;

	$intervalTime[7]['id'] = 7;
	$intervalTime[7]['name'] = "3.5 Hours";
	$intervalTime[7]['code'] = " +3 hours +30 minutes ";
	$intervalTime[7]['minute'] = 210;

	$intervalTime[8]['id'] = 8;
	$intervalTime[8]['name'] = "4 Hours";
	$intervalTime[8]['code'] = " +4 hours ";
	$intervalTime[8]['minute'] = 240;

	$intervalTime[9]['id'] = 9;
	$intervalTime[9]['name'] = "4.5 Hours";
	$intervalTime[9]['code'] = " +4 hours +30 minutes ";
	$intervalTime[8]['minute'] = 270;

	$intervalTime[10]['id'] = 10;
	$intervalTime[10]['name'] = "5 Hours";
	$intervalTime[10]['code'] = " +5 hours ";
	$intervalTime[10]['minute'] = 300;

	$intervalTime[11]['id'] = 11;
	$intervalTime[11]['name'] = "5.5 Hours";
	$intervalTime[11]['code'] = " +5 hours +30 minutes ";
	$intervalTime[11]['minute'] = 330;

	$intervalTime[12]['id'] = 12;
	$intervalTime[12]['name'] = "6 Hours";
	$intervalTime[12]['code'] = " +6 hours ";
	$intervalTime[12]['minute'] = 360;

	// $intervalTime[13]['id'] = 13;
	// $intervalTime[13]['name'] = "1.5 Hours";
	// $intervalTime[13]['code'] = " +1 hours +30 minute ";

	// $intervalTime[14]['id'] = 14;
	// $intervalTime[14]['name'] = "7 Hours";
	// $intervalTime[14]['code'] = " +1 hours +30 minute ";

	// $intervalTime[15]['id'] = 15;
	// $intervalTime[15]['name'] = "1.5 Hours";
	// $intervalTime[15]['code'] = " +1 hours +30 minute ";

	// $intervalTime[16]['id'] = 16;
	// $intervalTime[16]['name'] = "8 Hours";
	// $intervalTime[16]['code'] = " +1 hours +30 minute ";

	// $intervalTime[17]['id'] = 17;
	// $intervalTime[17]['name'] = "1.5 Hours";
	// $intervalTime[17]['code'] = " +1 hours +30 minute ";

	// $intervalTime[3]['id'] = 3;
	// $intervalTime[3]['name'] = "9 Hours";
	// $intervalTime[3]['code'] = " +1 hours +30 minute ";

	// $intervalTime[3]['id'] = 3;
	// $intervalTime[3]['name'] = "1.5 Hours";
	// $intervalTime[3]['code'] = " +1 hours +30 minute ";

	// $intervalTime[3]['id'] = 3;
	// $intervalTime[3]['name'] = "10 Hours";
	// $intervalTime[3]['code'] = " +1 hours +30 minute ";


	return $intervalTime;
}

function getRewardValue()
{

	$reward_value = array();

	$reward_value[1]['id'] = 1;
	$reward_value[1]['name'] = "HOD Pending";
	$reward_value[1]['code'] = "hod_pending";

	$reward_value[2]['id'] = 2;
	$reward_value[2]['name'] = "Hod Approved";
	$reward_value[2]['code'] = "hod_approved";

	return $reward_value;
}
