<?php

// --

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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

// -- //

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
    if (($strUsers == "") && false) { 
      $isValid = true; 
    } 
  } 
  return $isValid; 
}

// --

function firstWords($string, $nmbr)
{
    $arr = explode(" ", $string);
    $ret = "";
    if(count($arr) < $nmbr){
        return $string;
    }else{
       for($i = 0; $i < $nmbr; $i++){
            $ret .= " " . $arr[$i];
        }
    }
    $ret .= "...";
    return $ret;
}

// -- Special Characters -- //

function specialChars($string)
{
	$str_clean1 = str_replace("á", "&aacute;", $string);
	$str_clean2 = str_replace("é", "&eacute;", $str_clean1);
	$str_clean3 = str_replace("í", "&iacute;", $str_clean2);
	$str_clean4 = str_replace("ó", "&oacute;", $str_clean3);
	$str_clean5 = str_replace("ú", "&uacute;", $str_clean4);
	$str_clean6 = str_replace("ñ", "&ntilde;", $str_clean5);
	$str_clean7 = str_replace("Ñ", "&Ntilde;", $str_clean6);
	$str_clean8 = str_replace("Á", "&Aacute;", $str_clean7);
	$str_clean9 = str_replace("É", "&Eacute;", $str_clean8);
	$str_clean10 = str_replace("Í", "&Iacute;", $str_clean9);
	$str_clean11 = str_replace("Ó", "&Oacute;", $str_clean10);
	$str_clean12 = str_replace("Ú", "&Uacute;", $str_clean11);
	$str_clean13 = str_replace("¿", "&iquest;", $str_clean12);
	$str_clean14 = str_replace("¡", "&iexcl;", $str_clean13);
	$str_clean15 = str_replace('"', '&quot;', $str_clean14);
	$str_clean16 = str_replace('"', '&quot;', $str_clean15);
	$str_clean17 = str_replace('`', '&lsquo;', $str_clean16);
	$str_clean18 = str_replace('`', '&rsquo;', $str_clean17);
	$str_clean19 = str_replace("–", "&minus;", $str_clean18);
	$str_clean20 = str_replace("Ü", "&Uuml;", $str_clean19);
	$str_clean21 = str_replace("ü", "&uuml;", $str_clean20);	
	
    return $str_clean21;
}


// -- -- //


#get_date_spanish(time(), true, 'month'); # return Enero
#get_date_spanish(time(), true, 'month_mini'); # return ENE
#get_date_spanish(time(), true, 'Y'); # return 2007
#get_date_spanish(time());#return 06 de septiempre, 12:31 hs
#Power by nicolaspar 2007 - especific proyect

function get_date_spanish( $time, $part = false, $formatDate = '' ){

#Declare n compatible arrays

$month = array("","enero", "febrero", "marzo", "abril", "mayo", "junio", "julio", "agosto", "septiempre", "octubre", "noviembre", "diciembre");#n
$month_execute = "n"; #format for array month
$month_mini = array("","ENE", "FEB", "MAR", "ABR", "MAY", "JUN", "JUL", "AGO", "SEP", "OCT", "NOV", "DIC");#n
$month_mini_execute = "n"; #format for array month
$day = array("domingo","lunes","martes","miércoles","jueves","viernes","sábado"); #w
$day_execute = "w";
$day_mini = array("DOM","LUN","MAR","MIE","JUE","VIE","SAB"); #w
$day_mini_execute = "w";

/*
Other examples:
Whether it's a leap year
$leapyear = array("Este año febrero tendrá 28 días"."Si, estamos en un año bisiesto, un día más para trabajar!"); #l
$leapyear_execute = "L";
*/

#Content array exception print "HOY", position content the name array. Duplicate value and key for optimization in comparative
$print_hoy = array("month"=>"month", "month_mini"=>"month_mini");

	if( $part === false ){

		return date("d", $time) . "-" . $month_mini[date("n",$time)] . "-". date("Y",$time) ;

	}elseif( $part === true ){

#if( ! empty( $print_hoy[$formatDate] ) && date("d-m-Y", $time ) == date("d-m-Y") ) return "HOY"; #Exception HOY

		if( ! empty( ${$formatDate} ) && !empty( ${$formatDate}[date(${$formatDate.'_execute'},$time)] ) ) return ${$formatDate}[date(${$formatDate.'_execute'},$time)];

			else return date($formatDate, $time);

		}else{

			return date("d-m-Y H:i", $time);
			
	    }
	}

/**
 * Create a new password that is randomly chose.
 * @param $length The length of the new password, defaults to 10
 * @return The new password
 */
function newPassword($length = 6){
    $in = array("a", "A", "b", "B", "c", "C", "d", "D", "e", "E", "f", "F", "g", "G", "h", "H", "i", "I", "j", "J", "k", "K", "l", "L", "m", "M", "n", "N", "o", "O", "p", "P", "q", "Q", "r", "R", "s", "S", "t", "T", "u", "U", "v", "W", "x", "X", "y", "Y", "z", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    for($i = 0; $i < $length; $i++){
        srand ((double) microtime() * 1000000);
        $val .= $in[rand(0, count($in)-1)];
    }
    return $val;
}


/**
 * Check if the email supplied is well formatted
 * @param $email The email to check
 * @return true if the email is well formatted, if not: false
 */
function checkEmail($email){
    $regExp = "/^[\w]+@[\w\-]+[\w\-\.]+(\.[\w]{2,4})$/";
    if(preg_match($regExp, $email)){
        return true;
    }else{
        return false;
    }
}



/**
 * Get all URL's and put them into <a></a> tags
 * @param $string The string to change
 * @return The changed $string with <a></a> applied to all URL's
 */
function text2url($string){
    $regExpWWW = "/\swww\.([\w_]+)\.([\w]{2,4})([\w\/\-_\.\?&\=]+)\s/";
    $regExpHTTP = "/\shttp:\/\/([\w_\.]+)\.([\w]{2,4})([\w\/-_\.?&=]+)\s/";
    $exchangeWWW = " <a href=\"http://www.\\1.\\2\\3\">www.\\1.\\2\\3</a> ";
    $exchangeHTTP = " <a href=\"http://\\1.\\2\\3\">http://\\1.\\2\\3</a> ";
    $string = preg_replace($regExpWWW, $exchangeWWW, $string);
    $string = preg_replace($regExpHTTP, $exchangeHTTP, $string);
    return $string;
}

/**
 * Reverse text2url() so that we only see the URL's without <a></a> tags
 * surronding them
 * @param $string The string to work on.
 * @return The changed $string with all <a></a> tags stripped out.
 */
function url2text($string){
    $regExp = "/\s<a href=\"([\w_\.\/:]+)\.([\w]{2,4})([\w\/-_\.?&=]+)\">(.*)<\/a>\s/";
    $exchange =  " \\1.\\2\\3 ";
    $string = preg_replace($regExp, $exchange, $string);
    return $string;
}

// GET VOUCHER

function getVoucher($length = 8){
    $in = array("a", "A", "b", "B", "c", "C", "d", "D", "e", "E", "f", "F", "g", "G", "h", "H", "i", "I", "j", "J", "k", "K", "l", "L", "m", "M", "n", "N", "o", "O", "p", "P", "q", "Q", "r", "R", "s", "S", "t", "T", "u", "U", "v", "W", "x", "X", "y", "Y", "z", "Z", "1", "2", "3", "4", "5", "6", "7", "8", "9", "0");
    for($i = 0; $i < $length; $i++){
        srand ((double) microtime() * 1000000);
        $val .= $in[rand(0, count($in)-1)];
    }
    return $val;
}

// UPLOAD IMAGE

function uploadImg($image, $type) {
	
	$originalFile = $image;
	$shortname = substr($originalFile['name'], 0, -4);
	$timestamp = substr(date('mdy'), -4, 4);		
	
	if($type == "full") {
	
		$imageNewName = $shortname.$timestamp;
		
	} else {
	
		
		$imageNewName = $shortname.$timestamp."-thumb";
	}
	
	$dimensions = getimagesize($originalFile['tmp_name']);
	
	if($type == "full") {
	
		$desiredW = 550;//change the width!!!
	
	} else {
	
		$desiredW = 175;//change the width!!!
	
	}
	
	if($dimensions[0] > 0) {

		$desiredH = number_format($dimensions[1] /$dimensions[0] *$desiredW);

		$dest = imagecreatetruecolor($desiredW, $desiredH);

		imageantialias($dest, TRUE);

		switch($dimensions[2])
		{
			case 1:       //GIF
				$src = imagecreatefromgif($originalFile['tmp_name']);
				break;
			
			case 2:    //JPEG
				$src = imagecreatefromjpeg($originalFile['tmp_name']);
				break;
			
			case 3:       //PNG
				$src = imagecreatefrompng($originalFile['tmp_name']);
				break;
		
			default:
			return false;
			break;
		}

		imagecopyresampled($dest, $src, 0, 0, 0, 0, $desiredW, $desiredH, $dimensions[0], $dimensions[1]);

		$imageNewName = strtolower($imageNewName);

		$imageNewName = str_replace(" ", "_",$imageNewName);
		$imageNewName = $imageNewName.".jpg";
		
		if($type == "full") {
	
			$destURL = "../images/cms/".$imageNewName;
		
		} else {
		
			$destURL = "../images/cms/thumbs/".$imageNewName;
		
		}
	
		imagejpeg($dest,$destURL, 80);

	} else {
		
		$imageNewName = "noimg.jpg";
	}
	
	return $imageNewName;
}


?>