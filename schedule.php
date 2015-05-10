<?php
$username = "bielick3";
$password = "SandyBA30";

	session_write_close();
$ch = curl_init();
	curl_setopt($ch, CURLOPT_COOKIESESSION, true);
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
	
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, FALSE);
    //curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
	
    curl_setopt($ch, CURLOPT_URL, "https://login.msu.edu/?App=RO_Schedule");
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$response = curl_exec($ch);
	
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header = substr($response, 0, $header_size);
	$body = substr($response, $header_size);
	
	//echo $header;
	
	curl_close($ch);
	unset($ch);
		
	$stamp = findStamp($body);
	$pwField = findPWField($body);
	
	$cookie = findSessionID($header);
	
$loginurl = "https://login.msu.edu/Login";
$query = "AlternateID=".$username."&".$pwField."=".$password."&EncryptedStamp=".$stamp."&App=RO_Schedule&submit=Login&AuthenticationMethod=MSUNet";
$header = array(
	"POST /Login HTTP/1.1",
	"Host: login.msu.edu",
	"Connection: keep-alive",
	"Cache-Control: max-age=0",
	"Accept: text/html,application/xhtml+xml,application/xml;q=0.9,image/webp,*/*;q=0.8",
	"Origin: https://login.msu.edu",
	"User-Agent: Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36",
	"Content-Type: application/x-www-form-urlencoded",
	"Referer: https://login.msu.edu/?App=RO_Schedule",
	"Accept-Encoding: gzip, deflate",
	"Accept-Language: en-US,en;q=0.8",
);

	session_write_close();

$ch = curl_init();
	curl_setopt($ch, CURLOPT_COOKIESESSION, false);
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
	
	curl_setopt($ch, CURLOPT_REFERER, "https://login.msu.edu/?App=RO_Schedule");
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36'); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, FALSE);
	//curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
	
	curl_setopt($ch, CURLOPT_POST, TRUE); 
	curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_HTTPGET, FALSE);
	
	curl_setopt($ch, CURLOPT_URL, $loginurl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$response = curl_exec($ch);

	
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header = substr($response, 0, $header_size);
	$body = substr($response, $header_size);
	
	curl_close($ch);
	unset($ch);
	
	//echo ($body);
	//echo ($header);
	
	
	////////////////////////////////////////////////////
	// Enrolment checking
	////////////////////////////////////////////////////
	
	//echo ($body);
	$enrolled = findEnrolled();
	//echo $enrolled;
	While($enrolled > 49) {
		sleep(5);
		echo $enrolled;
		
		$enrolled = findEnrolled();
	}
	
	////////////////////////////////////////////////////
	// Sign-Up
	////////////////////////////////////////////////////
	
	$signupurl = "https://schedule.msu.edu/enroll.asp";
	$query = "enrl_StuID=".$username."&enrl_Action_97FY2R=A&enrl_SctnID=97FY2R&enrl_TermCode=FS15&enrl_TermID=1154&enrl_SUBJ=CSE&enrl_CRSE=476&enrl_SCTN=001";
	
	session_write_close();
$ch = curl_init();
	curl_setopt($ch, CURLOPT_COOKIESESSION, false);
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
	
	curl_setopt($ch, CURLOPT_REFERER, "https://schedule.msu.edu/enrollConfirm.asp");
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36'); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, FALSE);
	//curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
	
	curl_setopt($ch, CURLOPT_POST, TRUE); 
	//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_HTTPGET, FALSE);
	
	curl_setopt($ch, CURLOPT_URL, $signupurl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$response = curl_exec($ch);

	
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header = substr($response, 0, $header_size);
	$body = substr($response, $header_size);
	
	curl_close($ch);
	unset($ch);
	
	echo $body;
	
	
	
	
	
	
	
function findEnrolled() {
	$searchurl = "https://schedule.msu.edu/searchResults.asp";
	$query = "Semester=FS151154fall+2015&POST=Y&Button=&Online=&Subject=CSE&CourseNumber=476&Instructor=ANY&StartTime=0600&EndTime=2350&OnBeforeDate=&OnAfterDate=&Sunday=Su&Monday=M&Tuesday=Tu&Wednesday=W&Thursday=Th&Friday=F&Saturday=Sa&OnCampus=Y&OffCampus=Y&OnlineCourses=Y&StudyAbroad=Y&MSUDubai=Y&OpenCourses=A&Submit=Search+for+Courses";
	
	session_write_close();
$ch = curl_init();
	curl_setopt($ch, CURLOPT_COOKIESESSION, false);
	curl_setopt($ch, CURLOPT_COOKIEJAR, "cookies.txt");
	curl_setopt($ch, CURLOPT_COOKIEFILE, "cookies.txt");
	
	curl_setopt($ch, CURLOPT_REFERER, "https://schedule.msu.edu/searchResults.asp");
	curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows NT 6.1; WOW64) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/42.0.2311.135 Safari/537.36'); 
	curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
	
	curl_setopt($ch, CURLOPT_HEADER, TRUE);
    curl_setopt($ch, CURLOPT_NOBODY, FALSE);
	//curl_setopt($ch, CURLOPT_VERBOSE, TRUE);
	
	curl_setopt($ch, CURLOPT_POST, TRUE); 
	//curl_setopt($ch, CURLOPT_HTTPHEADER, $header);
	curl_setopt($ch, CURLOPT_POSTFIELDS, $query);
    curl_setopt($ch, CURLOPT_HTTPGET, FALSE);
	
	curl_setopt($ch, CURLOPT_URL, $searchurl);
	curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
	
	$response = curl_exec($ch);

	
	$header_size = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
	$header = substr($response, 0, $header_size);
	$body = substr($response, $header_size);
	
	curl_close($ch);
	unset($ch);
	
	
	
	$begin = "<td headers=\"Enrolled";
	
	$enrolledStart = strpos($body, $begin);
	$enrolledSub = substr($body, $enrolledStart);
	
	$begin = "rowspan=\"1\">";
	$start = strpos($enrolledSub, $begin);
	$start += strlen($begin);
	
	$length = 2;
	$enrolled = substr($enrolledSub, $start, $length);
	return $enrolled;
}
	
function findStamp($body) {
	$begin = "EncryptedStamp\" value=\"";
	
	$starnr = strpos($body,$begin);
    $starnr += strlen($begin);
	
	$laenge = 12;
    $id= substr($body,$starnr,$laenge); 
    return $id;
}

function findPWField($body) {
	$begin = "<td id=\"D6501LoginBoxPwInput\">";
	
	$pwStart = strpos($body,$begin);
	$pwSub = substr($body,$pwStart);
	
	$begin = "<input name=\"";
	$starnr = strpos($pwSub,$begin);
    $starnr += strlen($begin);
	
	$laenge = 5;
    $id= substr($pwSub,$starnr,$laenge); 
    return $id;
}

function findSessionID($html){
    //extract session id value
    $begin = 'JSESSIONID=';

    $starnr = strpos($html,$begin);
    $starnr += strlen($begin);

    $laenge = 32;
    $id= substr($html,$starnr,$laenge); 
    return $id;
}

?>