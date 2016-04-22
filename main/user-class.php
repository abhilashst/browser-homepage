<?php
/** Include the database file */



include_once BASE_PATH.'/db/db.php';
/**
 * The main class of login
 * All the necesary system functions are prefixed with _
 * examples, _login_action - to be used in the login-action.php file
 * _authenticate - to be used in every file where admin restriction is to be inherited etc...
 * @author Swashata <swashata@intechgrity.com>
 */
class sh_user {

    /**
     * Holds the script directory absolute path
     * @staticvar
     */
    static $abs_path;

    /**
     * Store the sanitized and slash escaped value of post variables
     * @var array
     */
    var $post = array();

	var $userId;
	
    /**
     * Stores the sanitized and decoded value of get variables
     * @var array
     */
    var $get = array();

    /**
     * The constructor function of admin class
     * We do just the session start
     * It is necessary to start the session before actually storing any value
     * to the super global $_SESSION variable
     */
    public function __construct() {
        session_start();

        //store the absolute script directory
        //note that this is not the admin directory
        self::$abs_path = dirname(dirname(__FILE__));

        //initialize the post variable
        if($_SERVER['REQUEST_METHOD'] == 'POST') {
            $this->post = $_POST;
            if(get_magic_quotes_gpc ()) {
                //get rid of magic quotes and slashes if present
                array_walk_recursive($this->post, array($this, 'stripslash_gpc'));
            }
        }

        //initialize the get variable
        $this->get = $_GET;
        //decode the url
        array_walk_recursive($this->get, array($this, 'urldecode'));
    }

    /**
     * Sample function to return the nicename of currently logged in admin
     * @global ezSQL_mysql $db
     * @return string The nice name of the user
     */
    public function get_nicename() {
        $username = $_SESSION['admin_login'];
        global $db;
        $info = $db->get_row("SELECT `username` FROM `sh_user` WHERE `username` = '" . $db->escape($username) . "'");
        if(is_object($info))
            return $info->nicename;
        else
            return '';
    }

    /**
     * Sample function to return the email of currently logged in admin user
     * @global ezSQL_mysql $db
     * @return string The email of the user
     */
    public function get_email() {
        $username = $_SESSION['admin_login'];
        global $db;
        $info = $db->get_row("SELECT `email` FROM `sh_user` WHERE `username` = '" . $db->escape($username) . "'");
        if(is_object($info))
            return $info->email;
        else
            return '';
    }

    /**
     * Checks whether the user is authenticated
     * to access the admin page or not.
     *
     * Redirects to the login.php page, if not authenticates
     * otherwise continues to the page
     *
     * @access public
     * @return void
     */
    public function _authenticate() {
        //first check whether session is set or not
        if(!isset($_SESSION['admin_login'])) {
            //check the cookie
			
            if(isset($_COOKIE['username']) && isset($_COOKIE['password'])) {
                //cookie found, is it really someone from the
                if($this->_check_db($_COOKIE['username'], $_COOKIE['password'])) {
                    $_SESSION['admin_login'] = $_COOKIE['username'];
                    return true;
                    die();
                }
                else {
                    return false;
                    die();
                }
            }
            else {
                return false;
                die();
            }
        }
    }


    /**
     * Check for login in the action file
     */
    public function _login_action() {

        //insufficient data provided
        if(!isset($this->post['username']) || $this->post['username'] == '' || !isset($this->post['password']) || $this->post['password'] == '') {
            return "Username or password is missing"; //header ("location: login.php");
        }

        //get the username and password
        $username = $this->post['username'];
        $password = md5($this->post['password']);

        //check the database for username
        if($this->_check_db($username, $password)) {
            //ready to login
            $_SESSION['admin_login'] = $username;

            //check to see if remember, ie if cookie
            if(isset($this->post['remember'])) {
                //set the cookies for 1 day, ie, 1*24*60*60 secs
                //change it to something like 30*24*60*60 to remember user for 30 days
                setcookie('username', $username, time() + 1*24*60*60);
                setcookie('password', $password, time() + 1*24*60*60);
            } else {
                //destroy any previously set cookie
                setcookie('username', '', time() - 1*24*60*60);
                setcookie('password', '', time() - 1*24*60*60);
            }

            return "sucess";//header("location: index.php");
        }
        else {
		
            return "Username or password is incorrect";//header ("location: login.php");
			
        }

        die();
    }



    /**
     * Check the database for login user
     * Get the password for the user
     * compare md5 hash over sha1
     * @param string $username Raw username
     * @param string $password expected to be md5 over sha1
     * @return bool TRUE on success FALSE otherwise
     */
    private function _check_db($username, $password) {
        global $db;
        $user_row = $db->get_row("SELECT * FROM `sh_user` WHERE `username`='" . $db->escape($username) . "'");
		/*print "<pre>";
		print_r($user_row);
		print "</pre>";*/
        //general return
        if(is_object($user_row) && $user_row->password == $password && $user_row->status == "deactive")
            return true;
        else
            return false;
    }
	
	private function _check_username($username) {
        global $db;
        $user_row = $db->get_row("SELECT * FROM `sh_user` WHERE `username`='" . $db->escape($username) . "'");
		/*print "<pre>";
		print_r($user_row);
		print "</pre>";*/
        //general return
        if(is_object($user_row))
            return true;
        else
            return false;
    }

    /**
     * stripslash gpc
     * Strip the slashes from a string added by the magic quote gpc thingy
     * @access protected
     * @param string $value
     */
    private function stripslash_gpc(&$value) {
        $value = stripslashes($value);
    }

    /**
     * htmlspecialcarfy
     * Encodes string's special html characters
     * @access protected
     * @param string $value
     */
    private function htmlspecialcarfy(&$value) {
        $value = htmlspecialchars($value);
    }

    /**
     * URL Decode
     * Decodes a URL Encoded string
     * @access protected
     * @param string $value
     */
    protected function urldecode(&$value) {
        $value = urldecode($value);
    }
	
	public function insertIcon($iconId,$status) {
		
		global $db;
		
		$db_data = array('user_id'=> $this->userId,'icon_id'=>$iconId, 'status' => "'".$status."'", );

		$db->query("INSERT INTO sh_user SET ".$db->get_set($db_data));
		
	}
	
	public function insertDefaultIcons() {
		
		global $db;
		$iconIdes = $db->get_col("SELECT * FROM sh_mainiconlist WHERE status = 'public' ",0);
		
		foreach ( $iconIdes as $iconId ){
		
		$this->insertIcon($iconId,"landscape");
		
		}
		
	}
	
	public function _register_action() {
		
		global $db;
		
        //insufficient data provided
		
		if(!isset($this->post['username']) || $this->post['username'] == '' )
			return "username is missing."; //header ("location: login.php");
		
		$username = $this->post['username'];
		
		if($this->_check_username($username))
			return "This username is already exist.";//header ("location: login.php");
		
		if(!isset($this->post['email']) || $this->post['email'] == '' )
			return "email is missing."; //header ("location: login.php");
		
		$email = $this->post['email'];
		
        if(!isset($this->post['password']) || $this->post['password'] == '')
            return "Please enter your password."; //header ("location: login.php");
			
		if(!isset($this->post['repassword']) || $this->post['repassword'] == '')
            return "Please re enter your password."; //header ("location: login.php");
        
		$password = md5($this->post['password']);
		
		if($this->post['password'] != $this->post['repassword'] )
			return "Passwod and re password not same."; //header ("location: login.php");
		
		$db_data = array('username'=> $username,'email'=>$email, 'password' => $password, 'createdtime' => time() ,'updatedtime' => time() ,'status' => 'active' );
		
		//echo"<pre>";
		//print_r($db_data );
		//echo"<\pre> ///////////////////////";
		
		//echo($db->get_set($db_data));

		$db->query("INSERT INTO sh_user SET ".$db->get_set($db_data));
		
		//echo "INSERT INTO sh_user (username, email, password ,createdtime, updatedtime, status)VALUES ('".$username."', '".$email."','".$password."','".time()."','".time()."','active')";
		
		//$db->query("INSERT INTO sh_user (username, email, password ,createdtime, updatedtime, status)VALUES ('".$username."', '".$email."','".$password."','".time()."','".time()."','active')");
		
		//$this->userId = $db->insert_id();
		
		//$this->insertDefaultIcons();
		
		$_SESSION['admin_login'] = $username;
			
         if(isset($this->post['remember'])) {
             
            setcookie('username', $username, time() + 1*24*60*60);
            setcookie('password', $password, time() + 1*24*60*60);
			
        } else {
                //destroy any previously set cookie
            setcookie('username', '', time() - 1*24*60*60);
            setcookie('password', '', time() - 1*24*60*60);
				
        }
			
        return "sucess";
		
        die();
		
    }

    
	
}
