<?php
require_once './swiftmailer/lib/swift_required.php';

function insertlastLogin($userCode,$loginCount){
    $loginCount += 1;
    $lastLogin = date("Y-m-d H:i:s");
    $conn = connection();
    $stmt = $conn->prepare('UPDATE user SET lastLogin=?,loginCount=? WHERE userCode=?');
    $stmt->bind_param('sii',$lastLogin,$loginCount,$userCode);
    $stmt->execute();
    if(!$stmt->affected_rows == 0){
        return true;
    }else{
        return false;
    }
}

function updateLogin($email,$lastLogin){
    $conn = connection();
    $stmt = $conn->prepare('INSERT INTO activeusers(username,lastLogin) VALUES(?,?)');
    $stmt->bind_param('ss',$email, $lastLogin);
    $stmt->execute();
    if(!$stmt->affected_rows == 0){
        return true;
    }else{
        return false;
    }
}




/*
* This function is to separate the extension from a filE NAME.
* It takes the file $filename as a parameter and returns the
* file extension.
*/
function findexts ( $filename )
{
    $filename = strtolower( $filename ) ;
    $exts = preg_split( "[/\\.]", $filename ) ;
    $n = count( $exts )-1;
    $exts = $exts[ $n ];
    return $exts;
}

/*
* This function renames a file. It takes the $filename and $fileLocation
* as parameters. Its then calls findexts fuctions to seperate the file name
* from the extension. Finaly it will rename the file and assign it the
* $fileLocation variable as a returned value
*/
function renameFile( $filename, $schoolName, $fileLocation )
{
    //Get the file extension for renaming
    $filename = findexts( $filename );

    $allowed_extensions = array( 'png', 'gif', 'jpg', 'jpeg', 'JPEG', 'JPG', 'mp3', 'MP3', '' );
    $fileExtention = explode( '.', $filename );
    if( in_array( $fileExtention[count( $fileExtention ) -1], $allowed_extensions ) )
    {
        //Renaming the file
        $newName = $schoolName . substr( md5( 'codfish' ),0,2 ) . "_" . date( "Y" ) . "_" . time() . "." .$filename;
        $fileLocation = $fileLocation . $newName;
        return $fileLocation;
    }
    else { return FALSE; }
}

// Crop image function
function cropImage( $imageDestination, $imageLocation, $imageName, $thumb_width, $thumb_height )
{
    $filename = $imageDestination.$imageName;
    ini_set('memory_limit', '-1');

    // Grab the image dimensions
    $size = getimagesize( $filename );

    // Check if the height or with is less than expected
    if ( $size[0] > $thumb_width || $size[1] > $thumb_height )
    {
        $image = imagecreatefromjpeg( "$filename" );

        $width = imagesx( $image );
        $height = imagesy( $image );

        $original_aspect = $width / $height;
        $thumb_aspect = $thumb_width / $thumb_height;

        if ( $original_aspect >= $thumb_aspect )
        {
            // If image is wider than thumbnail (in aspect ratio sense)
            $new_height = $thumb_height;
            $new_width = $width / ( $height / $thumb_height );
        }

        else
        {
            // If the thumbnail is wider than the image
            $new_width = $thumb_width;
            $new_height = $height / ( $width / $thumb_width );
        }

        $thumb = imagecreatetruecolor( $thumb_width, $thumb_height );

        // Resize and crop
        imagecopyresampled(
            $thumb,
            $image,
            0 - ( $new_width - $thumb_width ) / 2, // Center the image horizontally
            0 - ( $new_height - $thumb_height ) / 2, // Center the image vertically
            0, 0,
            $new_width, $new_height,
            $width, $height);
        imagejpeg( $thumb, $filename, 80 );
    }
}


//The function returns the no. of business days between two dates and it skips the holidays
function getWorkingDays($startDate,$endDate,$holidays)
{
    // do strtotime calculations just once
    $endDate = strtotime($endDate);
    $startDate = strtotime($startDate);


    //The total number of days between the two dates. We compute the no. of seconds and divide it to 60*60*24
    //We add one to inlude both dates in the interval.
    $days = ($endDate - $startDate) / 86400 + 1;

    $no_full_weeks = floor($days / 7);
    $no_remaining_days = fmod($days, 7);

    //It will return 1 if it's Monday,.. ,7 for Sunday
    $the_first_day_of_week = date("N", $startDate);
    $the_last_day_of_week = date("N", $endDate);

    //---->The two can be equal in leap years when february has 29 days, the equal sign is added here
    //In the first case the whole interval is within a week, in the second case the interval falls in two weeks.
    if ($the_first_day_of_week <= $the_last_day_of_week) {
        if ($the_first_day_of_week <= 6 && 6 <= $the_last_day_of_week) $no_remaining_days--;
        if ($the_first_day_of_week <= 7 && 7 <= $the_last_day_of_week) $no_remaining_days--;
    }
    else {
        // (edit by Tokes to fix an edge case where the start day was a Sunday
        // and the end day was NOT a Saturday)

        // the day of the week for start is later than the day of the week for end
        if ($the_first_day_of_week == 7) {
            // if the start date is a Sunday, then we definitely subtract 1 day
            $no_remaining_days--;

            if ($the_last_day_of_week == 6) {
                // if the end date is a Saturday, then we subtract another day
                $no_remaining_days--;
            }
        }
        else {
            // the start date was a Saturday (or earlier), and the end date was (Mon..Fri)
            // so we skip an entire weekend and subtract 2 days
            $no_remaining_days -= 2;
        }
    }

    //The no. of business days is: (number of weeks between the two dates) * (5 working days) + the remainder
//---->february in none leap years gave a remainder of 0 but still calculated weekends between first and last day, this is one way to fix it
    $workingDays = $no_full_weeks * 5;
    if ($no_remaining_days > 0 )
    {
        $workingDays += $no_remaining_days;
    }

    //We subtract the holidays
    foreach($holidays as $holiday){
        $time_stamp=strtotime($holiday);
        //If the holiday doesn't fall in weekend
        if ($startDate <= $time_stamp && $time_stamp <= $endDate && date("N",$time_stamp) != 6 && date("N",$time_stamp) != 7)
            $workingDays--;
    }

    return $workingDays;
}

function createCycle ( $cycleStart, $cycleEnd )
{



    // Insert contents into the database
    $connection = connection();
    $stmt = $connection->prepare( "INSERT INTO cycles (cycleStart, cycleEnd) VALUES (?,?)");
    $stmt->bind_param('ss',$cycleStart,$cycleEnd);
    $stmt->execute();

    if( !$stmt->affected_rows == 0){
        $connection = connection();
        $stmt = $connection->prepare(" SELECT cycleID, cycleStart, cycleEnd FROM cycles ORDER BY cycleID DESC LIMIT 1" );
        $stmt -> execute();
        $stmt -> bind_result( $cycleNo, $startDate, $endDate );
        $stmt -> fetch();
        if (insertSubscribers($cycleNo, $startDate, $endDate)) {
            return TRUE;
        }else{
            return FALSE;
        }
    }else{
        return FALSE;
    }

}

function collectRole($role){
    $connection = connection();
    $stmt = $connection->prepare(" SELECT roleName FROM role WHERE roleID = ? ");
    $stmt->bind_param("s", $role);
    $stmt -> execute();
    $stmt -> bind_result( $roleName);
    $stmt->fetch();
    return $roleName;
}

function collectMstatus($marital_status){
    $connection = connection();
    $stmt = $connection->prepare(" SELECT maritalName FROM maritalstatus WHERE maritalID = ? ");
    $stmt->bind_param("s", $marital_status);
    $stmt -> execute();
    $stmt -> bind_result( $maritalName);
    $stmt->fetch();
    return $maritalName;
}

function collectDept($department){
    $connection = connection();
    $stmt = $connection->prepare(" SELECT deptName FROM department WHERE deptID = ? ");
    $stmt->bind_param("s", $department);
    $stmt -> execute();
    $stmt -> bind_result( $deptName);
    $stmt->fetch();
    return $deptName;

}

function collectClass($classification){
    $connection = connection();
    $stmt = $connection->prepare(" SELECT className FROM classification WHERE classID = ? ");
    $stmt->bind_param("s", $classification);
    $stmt -> execute();
    $stmt -> bind_result( $className);
    $stmt->fetch();
    return $className;
}

function collectGender($gender){

    $connection = connection();
    $stmt = $connection->prepare(" SELECT genderName FROM gender WHERE genderID = ? ");
    $stmt->bind_param("s", $gender);
    $stmt -> execute();
    $stmt -> bind_result( $genderName);
    $stmt->fetch();
    return $genderName;
}

function updateCycle ( $cycleID, $cycleStart, $cycleEnd )
{



    // Update contents into the database
    $connection = connection();
    $stmt = $connection->prepare(  "UPDATE cycles SET cycleStart=?, cycleEnd=? WHERE cycleID=?");
    $stmt->bind_param('ssi',$cycleStart,$cycleEnd,$cycleID);
    $stmt->execute();

    if( !$stmt->affected_rows == 0){
        if (updateSubscribers($cycleID, $cycleStart, $cycleEnd)) {
            return TRUE;
        }else{
            return FALSE;
        }
    }else{
        return FALSE;
    }

}

function updateSubscribers( $cycleNo, $startDate, $endDate)
{

    $holidays=array("2017-01-01","2017-01-02","2017-03-06","2017-04-14","2017-04-17","2017-05-01","2017-05-25","2017-06-26","2017-07-03","2017-09-01","2017-09-21","2017-12-01","2017-12-25","2017-12-26");

    $cycleDuration = getWorkingDays($startDate,$endDate,$holidays);
    $amountComputed = ($cycleDuration * 6);

    $connection = connection();
    $stmt = $connection->prepare("UPDATE subscribers SET startDate=?, endDate=?, cycleDuration=?, amountComputed=? WHERE cycleNo=?" );
    $stmt -> bind_param( 'ssiii',$startDate, $endDate, $cycleDuration, $amountComputed, $cycleNo );
    $stmt -> execute();

    if (updateCycleAccounts ($cycleNo, $cycleDuration)) {
        return TRUE;
    }else{
        return FALSE;
    }
}

function updateCycleAccounts ($cycleNo, $cycleDuration)
{
    $sub = grabnumsub($cycleNo);
    $nonSub = grabnonnumsub($cycleNo);
    $totalComputed = ($cycleDuration * 6 * $sub);

    $connection = connection();
    $stmt = $connection->prepare( "UPDATE cycleAccounts SET subs=?, nonSubs=?, noOfDays=?, totalComputed=? WHERE cycleNo=?");
    $stmt->bind_param('iiiii', $sub, $nonSub, $cycleDuration, $totalComputed, $cycleNo );
    $stmt->execute();
    if( !$stmt->affected_rows == 0 ) { return TRUE; }
    else{ return FALSE; }

}

function insertSubscribers( $cycleNo, $startDate, $endDate)
{

    $holidays=array("2017-01-01","2017-01-02","2017-03-06","2017-04-14","2017-04-17","2017-05-01","2017-05-25","2017-06-26","2017-07-03","2017-09-01","2017-09-21","2017-12-01","2017-12-25","2017-12-26");

    $cycleDuration = getWorkingDays($startDate,$endDate,$holidays);
    $amountComputed = ($cycleDuration * 6);
    $subStatus = 0;

    $connection = connection();
    $stmt = $connection->prepare(" SELECT memberID, firstName, middleName, lastName FROM members " );
    $stmt -> execute();
    $stmt -> bind_result( $memberID, $firstName, $middleName, $lastName );
    while( $row = $stmt->fetch() ) :
        $subscriberName = $lastName." ".$firstName." ".$middleName;
        $subscriberID = $memberID;
        inputSubscribers($cycleNo, $startDate, $endDate, $cycleDuration, $subscriberID, $subscriberName, $amountComputed, $subStatus);

    endwhile;
    cycleAccounts ($cycleNo, $cycleDuration);
    return TRUE;
}

function cycleAccounts ($cycleNo, $cycleDuration)
{
    $sub = grabnumsub($cycleNo);
    $nonSub = grabnonnumsub($cycleNo);
    $totalComputed = ($cycleDuration * 6 * $sub);

    $connection = connection();
    $stmt = $connection->prepare( "INSERT INTO cycleAccounts (cycleNo, subs, nonSubs, noOfDays, totalComputed) VALUES (?,?,?,?,?)");
    $stmt->bind_param('iiiii', $cycleNo, $sub, $nonSub, $cycleDuration, $totalComputed);
    $stmt->execute();

}

function cycleAccountChange($cycleID)
{

    $sub = grabnumsub($cycleID);
    $nonSub = grabnonnumsub($cycleID);
    $noOfDays = noOfDays($cycleID);
    $totalComputed = ($noOfDays * 6 * $sub);
    $accID = getAccID($cycleID);

    $connection = connection();
    $stmt = $connection->prepare( 'UPDATE cycleaccounts SET subs=?, nonSubs=?, totalComputed=? WHERE cycleNo=? AND accID=?');
    $stmt->bind_param('iiiii', $sub, $nonSub, $totalComputed, $cycleID, $accID);
    $stmt->execute();
//    if( !$stmt->affected_rows == 0 ) { return TRUE; }
//    else{ return FALSE; }
}

function noOfDays($cycleID)
{
    $connection = connection();
    $stmt = $connection->prepare(" SELECT noOfDays FROM cycleaccounts WHERE cycleNo=$cycleID" );
    $stmt -> execute();
    $stmt -> bind_result( $cycleDuration );
    $stmt->fetch();
    return $cycleDuration;
}

function getAccID($cycleID)
{
    $connection = connection();
    $stmt = $connection->prepare(" SELECT accID FROM cycleaccounts WHERE cycleNo=$cycleID" );
    $stmt -> execute();
    $stmt -> bind_result( $accID );
    $stmt->fetch();
    return $accID;
}

function grabnumsub ($cycleID)
{
    $connection = connection();
    $stmt = $connection->prepare(" SELECT COUNT(subStatus) FROM subscribers WHERE cycleNo=$cycleID AND subStatus=1" );
    $stmt -> execute();
    $stmt -> bind_result( $numSub );
    $stmt->fetch();
    return $numSub;
}

function grabnonnumsub ($cycleID)
{
    $connection = connection();
    $stmt = $connection->prepare(" SELECT COUNT(subStatus) FROM subscribers WHERE cycleNo=$cycleID AND subStatus=0" );
    $stmt -> execute();
    $stmt -> bind_result( $numnonSub );
    $stmt->fetch();
    return $numnonSub;
}

function inputSubscribers($cycleNo, $startDate, $endDate, $cycleDuration, $subscriberID, $subscriberName, $amountComputed, $subStatus)
{
    $connection = connection();
    $stmt = $connection->prepare( 'INSERT INTO subscribers( cycleNo, startDate, endDate, cycleDuration, subscriberID, subscriberName, amountComputed, subStatus ) VALUES (?,?,?,?,?,?,?,? )' );
    $stmt->bind_param( 'issiisii', $cycleNo, $startDate, $endDate, $cycleDuration, $subscriberID, $subscriberName, $amountComputed, $subStatus );
    $stmt->execute();

    if( !$stmt->affected_rows == 0 ) { return TRUE; }
    else{ return FALSE; }
}



function createMenu( $days, $choice1, $choice2 )
{

    // Insert contents into the database
    $connection = connection();
    $stmt = $connection->prepare( 'INSERT INTO weeklymenu ( days, choice1, choice2 ) VALUES (?,?,? )' );
    $stmt->bind_param( 'sss', $days, $choice1, $choice2 );
    $stmt->execute();

    if( !$stmt->affected_rows == 0 ) { return TRUE; }
    else{ return FALSE; }
}

function updateMember ( $memberID, $home_phone, $moblie_phone, $personal_email, $residential, $postal, $Image, $imageLocation, $imageDestination ){
    // Check if the file field is not empty
    if ( !empty( $Image ) ) {
        // Upload the image and call the cropImage function
        if (move_uploaded_file($imageLocation, $imageDestination . $Image)) {
            // Set imageCrop variables
            $thumb_width = 250;
            $thumb_height = 250;
            $imageName = $Image;

            // Call the imageCrop function and set the final destination for database insert
            cropImage($imageDestination, $imageLocation, $imageName, $thumb_width, $thumb_height);
            $finalDestination = substr($imageDestination . $Image, 6);


            // Update contents in the database
            $connection = connection();
            $stmt = $connection->prepare('UPDATE members SET home_phone=?, mobile_phone=?, personal_email=?, residential_address=?, postal_address=?, image=? WHERE memberID=?');
            $stmt->bind_param('ssssssi', $home_phone, $moblie_phone, $personal_email, $residential, $postal, $finalDestination, $memberID);
            $stmt->execute();

            if (!$stmt->affected_rows == 0) {
                return TRUE;
            } else {
                return FALSE;
            }
        }
    }
}

function updateMemberA ( $memberID, $home_phone, $moblie_phone, $personal_email, $residential, $postal ){
    $connection = connection();
    $stmt = $connection->prepare('UPDATE members SET home_phone=?, mobile_phone=?, personal_email=?, residential_address=?, postal_address=? WHERE memberID=?');
    $stmt->bind_param('sssssi', $home_phone, $moblie_phone, $personal_email, $residential, $postal, $memberID);
    $stmt->execute();

    if (!$stmt->affected_rows == 0) {
        return TRUE;
    } else {
        return FALSE;
    }

}

function updateMenu ( $menuID, $days, $choice1, $choice2 )
{
    $connection = connection();
    $stmt = $connection->prepare( 'UPDATE weeklymenu SET days=?, choice1=?, choice2=? WHERE menuID=?' );
    $stmt->bind_param( 'sssi', $days, $choice1, $choice2, $menuID );
    $stmt->execute();

    if( !$stmt->affected_rows == 0 ) { return TRUE; }
    else{ return FALSE; }


}

function transaction ($con, $Q){
    mysqli_query($con, "START TRANSACTION");

    for ($i = 0; $i < count ($Q); $i++){
        if (!mysqli_query ($con, $Q[$i])){
            echo 'Error! Info: <' . mysqli_error ($con) . '> Query: <' . $Q[$i] . '>';
            break;
        }
    }

    if ($i == count ($Q)){
        mysqli_query($con, "COMMIT");
        return TRUE;
    }
    else {
        mysqli_query($con, "ROLLBACK");
        return FALSE;
    }
}


/*
* This function add a new member to the database. If the member has
* image attachement, it calls for the image rename and resize functions.
*/
function createMember ( $firstName, $middleName, $lastName, $gender, $dob, $membership_date, $classification, $department, $marital_status, $role, $employment_date, $home_phone, $work_phone, $moblie_phone, $personal_email, $work_email, $residential, $postal, $Image, $imageLocation, $imageDestination )
{
    // Check if the file field is not empty
    if ( !empty( $Image ) )
    {
        // Upload the image and call the cropImage function
        if ( move_uploaded_file( $imageLocation, $imageDestination.$Image ) )
        {
            // Set imageCrop variables
            $thumb_width = 250;
            $thumb_height = 250;
            $imageName = $Image;

            // Call the imageCrop function and set the final destination for database insert
            cropImage( $imageDestination, $imageLocation, $imageName, $thumb_width, $thumb_height );
            $Image = $imageDestination.$Image;
        }
    }


    // Update contents in the database
    $connection = connection();
    $stmt = $connection->prepare( 'INSERT INTO members(firstName, middleName, lastName, gender, dob, membership_date, classification, department, marital_status, role, employment_date, 
                                  home_phone, work_phone, mobile_phone, personal_email, work_email, residential_address, postal_address, image) VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,?)' );
    $stmt->bind_param( 'sssissiiiisssssssss', $firstName, $middleName, $lastName, $gender, $dob, $membership_date, $classification, $department, $marital_status, $role, $employment_date, $home_phone, $work_phone, $moblie_phone, $personal_email, $work_email, $residential, $postal, $Image);
    $stmt->execute();

    if( !$stmt->affected_rows == 0 ) {
        $last_id = $connection->insert_id;



        $options = [
            'cost' => 12,
        ];
        $password = password_hash("Password@1", PASSWORD_BCRYPT, $options);
        $creationDate = date("Y-m-d H:i:s");
        $lastLogin = date("Y-m-d H:i:s",0);
        $loginCount = 0;
        if(registerUser($last_id,$work_email, $password,$creationDate,$lastLogin,$loginCount)){

            $connection = connection();
            $stmt = $connection->prepare(" SELECT cycleID, cycleStart, cycleEnd FROM cycles ORDER BY cycleID DESC LIMIT 1" );
            $stmt -> execute();
            $stmt -> bind_result( $cycleNo, $startDate, $endDate );
            $stmt -> fetch();

            $holidays=array("2017-01-01","2017-01-02","2017-03-06","2017-04-14","2017-04-17","2017-05-01","2017-05-25","2017-06-26","2017-07-03","2017-09-01","2017-09-21","2017-12-01","2017-12-25","2017-12-26");

            $cycleDuration = getWorkingDays($startDate,$endDate,$holidays);
            $amountComputed = ($cycleDuration * 6);
            $subStatus = 0;

            $subscriberName = $lastName." ".$firstName." ".$middleName;
            $subscriberID = $last_id;
            if (inputSubscribers($cycleNo, $startDate, $endDate, $cycleDuration, $subscriberID, $subscriberName, $amountComputed, $subStatus)){
                return TRUE;
            }else{
                return FALSE;
            }


        }else{
            return FALSE;
        }
    }
    else{ return FALSE; }
}
function registerUser($last_id,$work_email, $password,$creationDate,$lastLogin,$loginCount){
    $connection = connection();
    $stmt = $connection->prepare( 'INSERT INTO user(userCode, email, password, dateCreated, lastLogin, loginCount) VALUES (?,?,?,?,?,?)' );
    $stmt->bind_param( 'issssi', $last_id, $work_email, $password, $creationDate, $lastLogin, $loginCount);
    $stmt->execute();

    if( !$stmt->affected_rows == 0 ) {
        return TRUE;
    }else{
        return FALSE;
    }
}
function currentCycle(){
    $connection = connection();
    $stmt = $connection->prepare(" SELECT max(cycleID) FROM cycles " );
    $stmt -> execute();
    $stmt -> bind_result( $currentCycle );
    $stmt->fetch();
    return $currentCycle;
}

function checkPassword($password,$email){
    $conn = connection();
    $stmt = $conn->prepare('SELECT password FROM user WHERE email=?');
    $stmt->bind_param('s',$email);
    $stmt->execute();
    $stmt->bind_result($compPass);
    $stmt->fetch();
    if(password_verify($password,$compPass)){
        return true;
    }else{
        return false;
    }
}

function updatePassword($newpass,$email){
    $conn = connection();
    $stmt = $conn->prepare('UPDATE user SET password=?  WHERE email=?');
    $stmt->bind_param('ss',$newpass,$email);
    $stmt->execute();

    if(!$stmt->affected_rows == 0){
        return true;
    }else{
        return false;
    }
}

function passwordReset($email){
    $options = [
        'cost' => 12,
    ];

    $randString = generateRandomString(10);
    $password = password_hash($randString, PASSWORD_BCRYPT, $options);

    $conn = connection();
    $stmt = $conn->prepare('UPDATE user SET password=?  WHERE email=?');
    $stmt->bind_param('ss',$password,$email);
    $stmt->execute();

    if(!$stmt->affected_rows == 0){
        $subject ='RE: PASSWORD RESET FOR'.PRODUCTNAME;
        $message=' Kindly login with password= "'.$randString.'" and change your password afterwards';
        $mail_from= COMPANYEMAIL;
        $name='HRM MANAGER';

        $transport = Swift_SmtpTransport::newInstance('ssl://smtp.gmail.com', 465)
            ->setUsername(EMAIL)// Your Gmail Username
            ->setPassword(EMAILPASS); // Your Gmail Password

        // Mailer
        $mailer = Swift_Mailer::newInstance($transport);

        // Create a message
        $message = Swift_Message::newInstance($subject)
            ->setFrom(array($mail_from => 'HRM'))// can be $_POST['email'] etc...
            ->setTo(array($email => 'Undisclosed Party'))// your email / multiple supported.
            ->setBody($message,'text/html');

        if ($mailer->send($message)) {

            return True;

        }else{
            return false;
        }

    }else{
            return false;
        }
}

function generateRandomString($length)
{
    $char= '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charLength= strlen($char);
    $randomString= '';
    for ($i = 0; $i < $length; $i++)
    {
        $randomString.= $char[rand(0,$charLength- 1)];
    }
    return $randomString;
}






