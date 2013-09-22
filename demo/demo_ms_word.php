<?php

// Include classes
include_once('tbs_class.php'); // Load the TinyButStrong template engine
include_once('../tbs_plugin_opentbs.php'); // Load the OpenTBS plugin

// Initalize the TBS instance
$TBS = new clsTinyButStrong; // new instance of TBS
$TBS->Plugin(TBS_INSTALL, OPENTBS_PLUGIN); // load the OpenTBS plugin

// ------------------------------
// Prepare some data for the demo
// ------------------------------

// Retrieve the user name to display

$course_name = "PHYSICS";
$unit_name = "ASTROPHYSICS";
$session_num = "3";
$year = "2013";
$session_pts = "0.5";
$class_num = "626_3";
$teacher_name = "Rae Pottenger";


$assessment = array();
$assessment[] = array('name'=>'Test', 'weight'=>'60%', 'due'=>'Test Week');
$assessment[] = array('name'=>'Practical Work', 'weight'=>'40%', 'due'=>'Ongoing');

$unit_goals = array();
$unit_goals[] = array('text'=>"Outline the general structure of the solar system and distinguish between a stellar cluster and a constellation;");
$unit_goals[] = array('text'=>"Define the luminosity of a star and apparent brightness, understand how it is measured and apply the Stefan–Boltzmann law to compare the luminosities of different stars.");
$unit_goals[] = array('text'=>"Describe quantitatively the different types of star and identify the characteristics of spectroscopic and eclipsing binary stars");
$unit_goals[] = array('text'=>"Identify the general regions of star types on a Hertzsprung–Russell (HR) diagram and understand the evolutionary paths of stars on an HR diagram;");
$unit_goals[] = array('text'=>"Identify the main features of the Big Bang and the expansion of the universe and explain how cosmic radiation in the microwave region is consistent with the Big Bang model");


// A recordset for merging tables
/*$data = array();
$data[] = array('rank'=> 'A', 'firstname'=>'Sandra' , 'name'=>'Hill'      , 'number'=>'1523d', 'score'=>200, 'email_1'=>'sh@tbs.com',  'email_2'=>'sandra@tbs.com',  'email_3'=>'s.hill@tbs.com');
$data[] = array('rank'=> 'A', 'firstname'=>'Roger'  , 'name'=>'Smith'     , 'number'=>'1234f', 'score'=>800, 'email_1'=>'rs@tbs.com',  'email_2'=>'robert@tbs.com',  'email_3'=>'r.smith@tbs.com' );
$data[] = array('rank'=> 'B', 'firstname'=>'William', 'name'=>'Mac Dowell', 'number'=>'5491y', 'score'=>130, 'email_1'=>'wmc@tbs.com', 'email_2'=>'william@tbs.com', 'email_3'=>'w.m.dowell@tbs.com' );
*/

// Other single data items
/*
$x_num = 3152.456;
$x_pc = 0.2567;
$x_dt = mktime(13,0,0,2,15,2010);
$x_bt = true;
$x_bf = false;
$x_delete = 1;
*/		
// -----------------
// Load the template
// -----------------

$template = 'test_template.docx';
$TBS->LoadTemplate($template); // Also merge some [onload] automatic fields (depends of the type of document).

// ----------------------
// Debug mode of the demo
// ----------------------
/*if (isset($_POST['debug']) && ($_POST['debug']=='current')) $TBS->Plugin(OPENTBS_DEBUG_XML_CURRENT, true); // Display the intented XML of the current sub-file, and exit.
if (isset($_POST['debug']) && ($_POST['debug']=='info'))    $TBS->Plugin(OPENTBS_DEBUG_INFO, true); // Display information about the document, and exit.
if (isset($_POST['debug']) && ($_POST['debug']=='show'))    $TBS->Plugin(OPENTBS_DEBUG_XML_SHOW); // Tells TBS to display information when the document is merged. No exit.
*/
// --------------------------------------------
// Merging and other operations on the template
// --------------------------------------------

// Merge data in the body of the document
//$TBS->MergeBlock('a,b', $data);
$TBS->MergeBlock('unit_goals', $unit_goals);
$TBS->MergeBlock('assessment', $assessment);


/*
// Change chart series
$ChartNameOrNum = 'a nice chart'; // Title of the shape that embeds the chart
$SeriesNameOrNum = 'Series 2';
$NewValues = array( array('Category A','Category B','Category C','Category D'), array(3, 1.1, 4.0, 3.3) );
$NewLegend = "Updated series 2";
$TBS->PlugIn(OPENTBS_CHART, $ChartNameOrNum, $SeriesNameOrNum, $NewValues, $NewLegend);
*/
// Delete comments
//$TBS->PlugIn(OPENTBS_DELETE_COMMENTS);


// -----------------
// Output the result
// -----------------

// Define the name of the output file
$save_as = (isset($_POST['save_as']) && (trim($_POST['save_as'])!=='') && ($_SERVER['SERVER_NAME']=='localhost')) ? trim($_POST['save_as']) : '';
$output_file_name = str_replace('.', '_'.date('Y-m-d').$save_as.'.', $template);
if ($save_as==='') {
	// Output the result as a downloadable file (only streaming, no data saved in the server)
	$TBS->Show(OPENTBS_DOWNLOAD, $output_file_name); // Also merges all [onshow] automatic fields.
} else {
	// Output the result as a file on the server
	$TBS->Show(OPENTBS_FILE+TBS_EXIT, $output_file_name); // Also merges all [onshow] automatic fields.
}
