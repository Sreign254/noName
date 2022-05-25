<?php
require_once 'db.php';

$fullname         = "";
$dateofleave       = "";
$username          = "";
$supervisroemail   = "";
$supervisormobilenumber = "";
$timeoff           = "";
$occupation        = "";
$idtype            = "";
$idnumber          = "";
$email             = "";
$issuedauthority   = "";
$issueddate        = "";
$expirydate        = "";
$password          = "";
$confirm_password  = "";
$errors = [];

// check if username has emoji
function isStringHasEmojis($string)
{
    $emojis_regex =
        '/[\x{0080}-\x{02AF}'
        . '\x{0300}-\x{03FF}'
        . '\x{0600}-\x{06FF}'
        . '\x{0C00}-\x{0C7F}'
        . '\x{1DC0}-\x{1DFF}'
        . '\x{1E00}-\x{1EFF}'
        . '\x{2000}-\x{209F}'
        . '\x{20D0}-\x{214F}'
        . '\x{2190}-\x{23FF}'
        . '\x{2460}-\x{25FF}'
        . '\x{2600}-\x{27EF}'
        . '\x{2900}-\x{29FF}'
        . '\x{2B00}-\x{2BFF}'
        . '\x{2C60}-\x{2C7F}'
        . '\x{2E00}-\x{2E7F}'
        . '\x{3000}-\x{303F}'
        . '\x{A490}-\x{A4CF}'
        . '\x{E000}-\x{F8FF}'
        . '\x{FE00}-\x{FE0F}'
        . '\x{FE30}-\x{FE4F}'
        . '\x{1F000}-\x{1F02F}'
        . '\x{1F0A0}-\x{1F0FF}'
        . '\x{1F100}-\x{1F64F}'
        . '\x{1F680}-\x{1F6FF}'
        . '\x{1F910}-\x{1F96B}'
        . '\x{1F980}-\x{1F9E0}]/u';
    preg_match($emojis_regex, $string, $matches);
    return !empty($matches);
}


// escape string
function escape($string)
{
    global $conn;
    return mysqli_real_escape_string($conn, $string);
}

//remove html entities from post request
function clean($string)
{
    return htmlentities($string);
}

//remove html entities from username solo,retain emoji request
function cleanusername($string)
{
    return htmlentities($string, ENT_HTML5);
}
//redirect funtion
function redirect($location)
{
    return header("Location: {$location}");
}

function set_message($message)
{


    if (!empty($message)) {


        $_SESSION['message'] = $message;
    } else {

        $message = "";
    }
}

function display_message()
{

    if (isset($_SESSION['message'])) {


        echo $_SESSION['message'];

        unset($_SESSION['message']);
    }
}

function validation_errors($error_message)
{

    $error_message = <<<DELIMITER
<div class="alert alert-danger border-0 bg-danger alert-dismissible fade show">
									<div class="text-white">$error_message</div>
									<button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
								</div>
DELIMITER;
    return $error_message;
}



function row_count($result)
{
    return mysqli_num_rows($result);
}

function email_exists($supervisroemail)
{
    global $conn;
    $sql = "SELECT email FROM users WHERE email = '$supervisroemail' LIMIT 1";
    $result = mysqli_query($conn, $sql);
    if (row_count($result) > 0) {
        return true;
    } else {
        return false;
    }
}

function username_exists($username)
{
    global $conn;
    $sql = "SELECT id FROM users WHERE username = '$username' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (row_count($result) == 1) {
        return true;
    } else {
        return false;
    }
}

function phonenumber_exists($supervisormobilenumber)
{
    global $conn;
    $supervisormobilenumberke = preg_replace("/^0/", "254", $supervisormobilenumber);
    $sql = "SELECT id FROM users WHERE phonenumber = '$supervisormobilenumberke' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if (row_count($result) == 1) {
        return true;
    } else {
        return false;
    }
}


function confirm($result)
{
    global $conn;

    if (!$result) {

        die("QUERY FAILED" . mysqli_error($conn));
    }
}
// run query
function query($query)
{

    global $conn;
    $result =  mysqli_query($conn, $query);
    confirm($result);
    return $result;
}

// fetch asociative array
function fetch_array($result)
{
    global $conn;
    return mysqli_fetch_array($result);
}


// register user function 
function add_leave_request(
    $fullname,
    $dateofleave,
    $supervisroemail,
    $supervisormobilenumber,
    $timeoff,
    $occuption,
    $idtype,
    $idnumber,
    $youremail,
    $issuedauthority,
    $issueddate,
    $expirydate
) {
    global $conn;

    $fullname  = $fullname;
    $dateofleave    = $dateofleave;
    $supervisroemail       = $supervisroemail;
    $supervisormobilenumber = $supervisormobilenumber;
    $timeoff    = $timeoff;
    $occuption    = $occuption;
    $idtype    = $idtype;
    $idnumber    = $idnumber;
    $youremail    = $youremail;
    $issuedauthority    = $issuedauthority;
    $issueddate    = $issueddate;
    $expirydate    = $expirydate;

    $supervisormobilenumberke = preg_replace("/^0/", "254", $supervisormobilenumber);


    $sql = "INSERT INTO leave_applications(fullname, dateofleave,supervisoremail,supervisormobilenumber,timeoff, occuption,idtype,idnumber, youremail, issuedauthority, issueddate, expirydate)";
    $sql .= " VALUES('$fullname','$dateofleave','$supervisroemail','$supervisormobilenumberke','$timeoff', '$occuption',' $idtype','$idnumber', '$youremail', '$issuedauthority', '$issueddate', '$expirydate')";

    // query('SET NAMES utf8mb4');
    $result = query($sql);
    confirm($result);
    return true;
}





function validateEmail($supervisroemail)
{
    // SET INITIAL RETURN VARIABLES

    $supervisroemailIsValid = FALSE;

    // MAKE SURE AN EMPTY STRING WASN'T PASSED

    if (!empty($supervisroemail)) {
        // GET EMAIL PARTS

        $domain = ltrim(stristr($supervisroemail, '@'), '@') . '.';
        $user   = stristr($supervisroemail, '@', TRUE);

        // VALIDATE EMAIL ADDRESS

        if (
            !empty($user) &&
            !empty($domain) &&
            checkdnsrr($domain)
        ) {
            $supervisroemailIsValid = TRUE;
        }
    }

    // RETURN RESULT

    return $supervisroemailIsValid;
};

// Add leave request
if (isset($_POST['signup-btn'])) {

    $searcharray  = array("+", " ");
    $replacearray = array(" ", "");
    $searchunamearray  = array(" ");
    $replaceunamrearray = array("_");
    $fullname             = $_POST['fullname'];
    if (isStringHasEmojis($fullname)) {
        $errors[] = "Name cannot contain emojis";
    };
    // $fullname             = clean($_POST['fullname']);
    $dateofleave             = clean($_POST['dateofleave']);

    $supervisroemail                  = clean(strtolower($_POST['supervisroemail']));
    $supervisormobilenumber            = clean($_POST['supervisormobilenumber']);
    $supervisormobilenumber            = str_replace($searcharray, $replacearray, $supervisormobilenumber);
    $supervisormobilenumber            = trim($supervisormobilenumber, " \n\r\t\v\0#");
    $timeoff               = clean(strtolower($_POST['timeoff']));
    $occuption               = clean(strtolower($_POST['occuption']));
    $idtype               = clean(strtolower($_POST['idtype']));
    $idnumber               = clean(strtolower($_POST['idnumber']));
    $youremail               = clean(strtolower($_POST['youremail']));
    $issuedauthority               = clean(strtolower($_POST['issuedauthority']));
    $issueddate               = clean(strtolower($_POST['issueddate']));
    $expirydate               = clean(strtolower($_POST['expirydate']));


    $min = 3;
    $max = 100;
    $maxmail = 100;
    $phone = 15;

    if (empty($fullname)) {
        $errors['fullname'] = 'First name cannot be empty';
    }
    if (strlen($fullname) < $min) {

        $errors[] = "Your first name cannot be less than {$min} characters";
    }
    if (strlen($fullname) > $max) {
        $errors[] = "Your first name cannot be more than {$max} characters";
    }

    if (empty($supervisroemail)) {
        $errors['email'] = 'Email required';
    }
    if (!empty($supervisroemail) && !filter_var($supervisroemail, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email address";
    }
    if (strlen($supervisroemail) > $maxmail) {
        $errors[] = "Your email cannot be more than {$maxmail} characters";
    }

    if (validateEmail($supervisroemail) == FALSE) {
        $errors['email'] = "Invalid email address.Check your email and try again";
    }

    // // Check if email already exists
    if (email_exists($supervisroemail)) {
        $errors['email'] = "Email already exists";
    }
    if (empty($supervisormobilenumber)) {

        $errors[] = "Your phone number cannot be empty";
    }

    if (phonenumber_exists($supervisormobilenumber)) {

        $errors[] = "Sorry that phone number already exists in our database";
    }

    if (strlen($supervisormobilenumber) > $phone) {

        $errors[] = "Your phone number cannot be more than {$phone} numbers";
    }


    if (count($errors) === 0) {
        // register  user in db
        if (add_leave_request(
            $fullname,
            $dateofleave,
            $supervisroemail,
            $supervisormobilenumber,
            $timeoff,
            $occuption,
            $idtype,
            $idnumber,
            $youremail,
            $issuedauthority,
            $issueddate,
            $expirydate
        )) {

            set_message('<div class="alert alert-success border-0 bg-success alert-dismissible fade show">
                            <div class="text-white">
                            Leave request sent successfully.
                            Or click <a href="login.php">here to login</a>
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>');

            redirect("pending.php");
        } else {


            // set_message('<div class="alert alert-danger bg-danger border-0 alert-dismissible text-center fade show">
            // <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            // Sorry we could not register the user
            // </div>');
            set_message('<div class="alert alert-info border-0 bg-info alert-dismissible fade show">
                            <div class="text-white">
                                Sorry we could not register the user
                            </div>
                            <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                            </div>');

            redirect("register.php");
        }



        //old register start
        /* $query = "INSERT INTO users SET username=?, email=?, password=?";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('sss', $username, $supervisroemail, $password);
        $result = $stmt->execute();

        if ($result) {
            $user_id = $stmt->insert_id;
            $stmt->close();

            //sendVerificationEmail($supervisroemail, $token);

            $_SESSION['username'] = $username;
            $_SESSION['email'] = $supervisroemail;
            $_SESSION['verified'] = false;
            $_SESSION['message'] = 'You are logged in!';
            $_SESSION['type'] = 'alert-success';
            redirect('index.php');
        } else {
            $_SESSION['error_msg'] = "Database error: Could not register user";
        } */ //old register end
    } else {
        foreach ($errors as $error) {

            echo validation_errors($error);
        }
    }
}

/* // LOGIN user using email or username 
if (isset($_POST['login-btn'])) {
    if (empty($_POST['username'])) {
        $errors['username'] = 'Username or email required';
    }
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password required';
    }
    $username = $_POST['username'];
    $password = $_POST['password'];

    if (count($errors) === 0) {
        $query = "SELECT * FROM users WHERE username=? OR email=? LIMIT 1";
        $stmt = $conn->prepare($query);
        $stmt->bind_param('ss', $username, $username);

        if ($stmt->execute()) {
            $result = $stmt->get_result();
            $user = $result->fetch_assoc();
            if (password_verify($password, $user['password'])) { // if password matches
                $stmt->close();

                $_SESSION['username'] = $user['username'];
                $_SESSION['email'] = $user['email'];
                $_SESSION['verified'] = $user['verified'];
                $_SESSION['message'] = 'You are logged in!';
                $_SESSION['type'] = 'alert-success';
                header('location: index.php');
                exit(0);
            } else { // if password does not match
                $errors['login_fail'] = "Wrong username / password";
            }
        } else {
            $_SESSION['message'] = "Database error. Login failed!";
            $_SESSION['type'] = "alert-danger";
        }
    }
} */

//multiauth login
$msg = [];

if (isset($_POST['login-submit'])) {
    if (!empty($_SERVER['HTTP_CLIENT_IP']))   //check ip from share internet
    {
        $ip = $_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR']))   //to check if ip is pass from proxy
    {
        $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip = $_SERVER['REMOTE_ADDR'];
    }

    $user_agent = $_SERVER['HTTP_USER_AGENT'];
    $dtime = date("Y-m-d H:i:s");

    $username = strtolower($_POST['username']);
    $password = $_POST['password'];

    $sql = "SELECT id,username,password,role,active,disabled,createdat FROM users WHERE username=? AND password=?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();

    if ($row['role'] == "admin" || $row['role'] == "client") {
        //session_start();
        session_regenerate_id();
        $_SESSION['username'] = $row['username'];
        $_SESSION['role'] = $row['role'];
        $_SESSION['userid'] = $row['id'];
        $_SESSION['disabled'] = $row['disabled'];
        $_SESSION['active'] = $row['active'];
        // if ($row['createdat'] < '2022-03-02 20:00:00') {
        if ($row['createdat'] < '2022-12-12 20:00:00') {
            $_SESSION['active'] = 1;
        }
        session_write_close();
        //$msg[] = "Incorrect username or password";
    }


    $queryua = "INSERT INTO ua(username,role,ip,useragent,dtime)VALUES(?,?,?,?,?)";
    $stmtua = $conn->prepare($queryua);
    $stmtua->bind_param("sssss", $_SESSION['username'], $_SESSION['role'], $ip, $user_agent, $dtime);
    $stmtua->execute();

    if ($result->num_rows == 1 && $_SESSION['role'] == "client" && $_SESSION['disabled'] == 0 && $_SESSION['active'] == 1) {
        header("location:dashboard.php");
    } else if ($result->num_rows == 1 && $_SESSION['role'] == "client" && $_SESSION['disabled'] == 0 && $_SESSION['active'] == 0) {
        $msg[] = "Clink the link sent your email account to activate your account";
    } else if ($result->num_rows == 1 && $_SESSION['role'] == "admin" && $_SESSION['disabled'] == 0 && $_SESSION['active'] == 0) {
        header("location:dashboard_admin.php");
    } else if ($result->num_rows == 1 && $_SESSION['role'] == "admin" && $_SESSION['disabled'] == 0 && $_SESSION['active'] == 1) {
        header("location:dashboard_admin.php");
    } else if ($result->num_rows == 1 && $_SESSION['role'] == "client" && $_SESSION['disabled'] == 1 && $_SESSION['active'] == 0) {
        $msg[] = "Account Disabled Contact Administrator For Assistance";
    } else if ($result->num_rows == 1 && $_SESSION['role'] == "client" && $_SESSION['disabled'] == 1 && $_SESSION['active'] == 1) {
        $msg[] = "Account Disabled Contact Administrator For Assistance";
    } else {
        //validation_errors($msg);
        $msg[] = "Incorrect username or password";
    }
}

if (isset($_GET['logout'])) {
    session_destroy();
    unset($_SESSION['username']);
    unset($_SESSION['email']);
    unset($_SESSION['verify']);
    header("location: login.php");
    exit(0);
}
