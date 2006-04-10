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

/**
 * PIe Graph of New Vs. Repeat Visitors
 * 
 * @author      Peter Adams <peter@openwebanalytics.com>
 * @copyright   Copyright &copy; 2006 Peter Adams <peter@openwebanalytics.com>
 * @license     http://www.gnu.org/copyleft/gpl.html GPL v2.0
 * @category    wa
 * @package     wa
 * @version		$Revision$	      
 * @since		wa 1.0.0
 */
class wa_graph_visitors_pie extends wa_graph {	

	/**
	 * Constructor
	 *
	 * @access 	public
	 * @return 	wa_graph_visitors_pie
	 */
	function wa_graph_visitors_pie() {
		
		$this->wa_graph();
		$this->api_calls = array('visitors_pie');
		
		return;
	}

	/**
	 * Generate Graph
	 *
	 * @param 	array $params
	 * @access 	public
	 * @return 	unknown
	 */
	function generate($params) {
			
		$this->params = $params;
	
		switch ($params['api_call']) {
		
			case "visitors_pie":
				
				return $this->graph_visitors_pie();
				
			}
		
		return;
	}
	
	/**
	 * Assembles Graph
	 *
	 * @access 	private
	 */
	function graph_visitors_pie() {
	
		$result = $this->metrics->get(array(
		
		'api_call' 		=> 'new_v_repeat',
		'period'			=> $this->params['period'],
		'result_format'		=> 'assoc_array',
		'constraints'		=> array(
			
			'is_browser' => 1,
			'is_robot' 	=> 0
			
			)
	
		));
		
		$result_pie = array($result[0]['new_visitor'], $result[0]['repeat_visitor']);
		
		$this->data = array(
		
			'data_pie'		=> $result_pie
			
			);
			
			//print_r($this->data);
		
		$this->params['graph_title'] = "New Vs. Repeat Visitors for \n" . $this->get_period_label($this->params['period']);
		$this->params['legends'] = array('New', 'Repeat');
		$this->params['height']	= 200;
		$this->params['width']	= 260;
		
		$this->pie_graph();
		
		return;
	}
	
}

?>