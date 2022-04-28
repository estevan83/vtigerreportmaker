<?php
/*****************************************************************************
       _                                                 
      | |                                                
  __ _| | __ _  ___  _ __ ___   __ _  ___ _ __ _ __ ___  
/ _` | |/ _` |/ _ \| '_ ` _ \ / _` |/ __| '__| '_ ` _ \
| (_| | | (_| | (_) | | | | | | (_| | (__| |  | | | | | |
\__,_|_|\__, |\___/|_| |_| |_|\__,_|\___|_|  |_| |_| |_|
          __/ |                                          
         |___/  
Ing. Estefan Civera
info@algoma.it
www.algoma.it    

*****************************************************************************/

//  per debug da web attivo questo e lancio dal browser
$id = is_numeric($_GET['id']) ? intval($_GET['id']) : 0;

if($id <= 0)
die("no valid param $id");

// https://$SITE_URL/cron/modules/AlgomaReportScheduler/AlgomaReportScheduler.php
chdir("..");
chdir("..");
chdir("..");


require_once("include/utils/utils.php");
require_once("modules/Emails/class.phpmailer.php");
require_once("modules/Emails/mail.php");
require_once("include/logging.php");
require_once("cron/modules/AlgomaReportScheduler/htmltable.php");
require_once("cron/modules/AlgomaReportScheduler/emojis.php");
require_once("config.php");
require_once("config.inc.php");



error_reporting(E_ERROR);
ini_set('display_errors', 1);

$current_user = Users::getActiveAdminUser();

$log =&LoggerManager::getLogger('AlgomaReportScheduler');

global $dbconfig;

$dbConn = mysqli_connect($dbconfig["host"],$dbconfig["db_username"],$dbconfig["db_password"],$dbconfig["db_name"]);

if($dbConn == null){
	echo  mysqli_connect_error();
	$log->error(mysqli_connect_error());
}

//  per debug da web attivo questo e lancio dal browser
$result = mysqli_query($dbConn , "select * from algoma_reportscheduler where id=$id");



$reports = array();


while($row = mysqli_fetch_array($result,MYSQLI_ASSOC)){ // RAW DATA  IL NUCLEO - SOCIETA' COOPERATIVA SOCIALE - ONLUS
   $reports[] = $row;
}

// Free result set
mysqli_free_result($result);


foreach($reports as $r){
	
	$repmsg = '<title>' . $r['name'] . '</title>';
	$repmsg .= '<p>' . $r['description'] . '</p>';
	
	$single = array();
	$rows = array();
	
	mysqli_multi_query($dbConn, $r['code']);
	
	do {
		$rows = array();
		$titles = array();
		
    	// store the result set in PHP 
		if ($result = mysqli_store_result($dbConn)) {
						
			while ($row = mysqli_fetch_assoc($result)) {
				
				$titles = array_keys($row);
				
				if($titles[0] == '_comment'){
					$single['comment'] = $row['_comment'];
				}
				
				else if($titles[0] == '_header'){
					$single['header'] = $row['_header'];
				}
				
				else{
					
					// Per la mail
					$rows[] = $row;
						
				
				}
				
			} // fine del while

            if($titles[0] != '_comment' && $titles[0] != '_header'){

                $repmsg .=  TableHelper::createTable(nl2br($single['header']), $rows, $titles, '', nl2br($single['comment']));

            }
		}
		//print divider 
		if (mysqli_more_results($dbConn)) {
			//printf("-----------------\n");
		}

    	// Free result set
    	mysqli_free_result($result);
    
	} while (mysqli_next_result($dbConn));

	echo  $repmsg;

	
} // foreach($reports as $r)

// Free result set
//mysqli_free_result($result);
mysqli_close($dbConn);

$log->debug("*** END AlgomaReportScheduler ***");