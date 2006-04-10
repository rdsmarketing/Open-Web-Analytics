<?php

//
// Open Web Analytics - An Open Source Web Analytics Framework
//
// Copyright 2006 Peter Adams. All rights reserved.
//
// Licensed under GPL v2.0 http://www.gnu.org/copyleft/gpl.html
//
// Unless required by applicable law or agreed to in writing, software
// distributed under the License is distributed on an "AS IS" BASIS,
// WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
// See the License for the specific language governing permissions and
// limitations under the License.
//
// $Id$
//

require_once (WA_BASE_DIR.'/wa_settings_class.php');

/**
 * Email Announcement Event handler
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    wa
 * @package     wa
 * @version		$Revision$	      
 * @since		wa 1.0.0
 */

class Log_observer_announce extends wa_observer {

	/**
	 * Email that mail should go to
	 *
	 * @var string
	 */
    var $_to;
    
    /**
     * Subject of email
     *
     * @var string
     */
    var $_subject;
    
    /**
	 * Database Access Object
	 *
	 * @var object
	 */
	var $db;
	
	/**
	 * Configuration
	 *
	 * @var array
	 */
	var $config;
	
	/**
	 * Event Message
	 *
	 * @var object
	 */
	var $m;
    
	/**
	 * Constructor
	 *
	 * @param 	string $priority
	 * @param 	array $conf
	 * @return 	Log_observer_announce
	 */
    function Log_observer_announce($priority, $conf) {
        
    	// Call the base class constructor.
        $this->Log_observer($priority);

        // Configure the observer to listen for event types
		$this->_event_type = array('session_update');

		// Fetch config
		$this->config = &wa_settings::get_settings();
		
		return;
    }
	
    /**
     * Notify Event Handler
     *
     * @param 	unknown_type $event
     * @access 	public
     */
    function notify($event) {
		
    	$this->m = $event['message'];

    	switch ($event['event_type']) {
    		case "session_update":
    			$this->announce_session_update();
    			break;

    	}
		
		return;
    }
    
    /**
     * Announces Session update via email
     *
     */
    function announce_session_update() {
    	$this->_subject = 'WA Session Update';
    	$this->_to = $this->config['error_email_address'];
    	mail($this->_to, 
    		 $this->_subject, 
    		 $this->m->properties['visitor_id'] . ": " . $this->m->properties['last_page_uri']
    		 );
    	return;
    }
}

?>