<?php

	/**
	 * Elgg Friendfeed widget plugin
	 * 
	 * @package ElggFriendfeed
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Ben Werdmuller <ben@elgg.com>
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.org/
	 */

		function friendfeed_init() {
    		
			add_widget_type('friendfeed',elgg_echo('friendfeed'),elgg_echo('friendfeed:description'));
			
		}
		
		register_elgg_event_handler('init','system','friendfeed_init');

?>