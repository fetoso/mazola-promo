<?
date_default_timezone_set("America/Puerto_Rico");

require_once('../include/db.class.php');
include_once('../include/fxns.inc.php');

$db = new DBConnection();

$query_rsCheckUser = "SELECT * FROM entries";

	$rsCheckUser = $db->sendQuery($query_rsCheckUser);
	// $row_rsCheckUser = $db->fetchMysqlObject($rsCheckUser);
	$rsCheckUser_numRows = $db->numRows($rsCheckUser);

    // $name = $_POST['name'];
    // $email = $_POST['email'];
    // $tel = $_POST['tel'];
    // $address = $_POST['address'];
    // $store = $_POST['store'];
    // $text = $_POST['text'];
    // $image = $_POST['image'];

if ($rsCheckUser_numRows != 0){
  $x = 0;
  $users = array();
  while($row_User = $db->fetchMysqlObject($rsCheckUser)) {
    array_push($users, array(
      'id' => $row_User->id,
      'name' => $row_User->name,
      'email' => $row_User->email,
      'phone' => $row_User->phone,
      'submit_date' => $row_User->submit_date
    ));
    $x++;
  }
  download_send_headers("data_export_" . date("Y-m-d") . ".csv");
  echo array2csv($users);
  die();
}

function array2csv(array &$array)
{
   if (count($array) == 0) {
     return null;
   }
   ob_start();
   $df = fopen("php://output", 'w');
   fputcsv($df, array_keys(reset($array)));
   foreach ($array as $row) {
      fputcsv($df, $row);
   }
   fclose($df);
   return ob_get_clean();
}

function download_send_headers($filename) {
    // disable caching
    $now = gmdate("D, d M Y H:i:s");
    header("Expires: Tue, 03 Jul 2001 06:00:00 GMT");
    header("Cache-Control: max-age=0, no-cache, must-revalidate, proxy-revalidate");
    header("Last-Modified: {$now} GMT");

    // force download
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");

    // disposition / encoding on response body
    header("Content-Disposition: attachment;filename={$filename}");
    header("Content-Transfer-Encoding: binary");
}


?>
