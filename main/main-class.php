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
class main {

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
        
    }

    public function getAllIcons() {
	
        global $db;
        $info = $db->get_results(" SELECT a. * , b. * FROM sh_mainiconlist a, sh_mainiconimages b WHERE a.image_id = b.id AND a.status = 'public' ORDER BY a.popularity_count ASC",ARRAY_N);
		if(is_array($info))
            return $info;
        else
            return '';
    }
	
	public function getAllIconsWithCatId($catId) {
		
        global $db;
		$query = " SELECT a. * , b. * FROM sh_mainiconlist a, sh_mainiconimages b WHERE a.image_id = b.id AND a.status = 'public' and a.category_id = ".$catId." ORDER BY a.popularity_count ASC";
		
        $info = $db->get_results($query,ARRAY_N);
		if(is_array($info))
            return $info;
        else
            return '';
    }
	
	public function getAllLaunchPadIcons() {
	
        global $db;
        $info = $db->get_results(" SELECT a.name, a.url, a.category_id,  b.very_small, b.small, b.large, b.launchpad_url FROM sh_mainiconlist a, sh_mainiconimages b WHERE a.image_id = b.id AND a.status = 'public' ORDER BY a.popularity_count ASC",ARRAY_N);
		if(is_array($info))
            return $info;
        else
            return '';
    }
	public function getAllCategory() {
	
        global $db;
        $info = $db->get_results(" SELECT id, name FROM sh_iconurlcategory WHERE status = 'active' ",ARRAY_N);
		if(is_array($info))
            return $info;
        else
            return '';
    }
}
