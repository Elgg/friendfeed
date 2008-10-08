<?php

	/**
	 * Elgg Friendfeed widget plugin view page
	 * 
	 * @package ElggFriendfeed
	 * @license http://www.gnu.org/licenses/old-licenses/gpl-2.0.html GNU Public License version 2
	 * @author Ben Werdmuller <ben@elgg.com>
	 * @copyright Curverider Ltd 2008
	 * @link http://elgg.org/
	 */

?>

	<style type="text/css">
	<?php echo elgg_view('widgets/friendfeed/css'); ?>
	</style>
 
<?php

		$username = $vars['entity']->username;
		$apikey = $vars['entity']->apikey;
		
		if (!empty($username) && !empty($apikey)) {
			
			require_once(dirname(dirname(dirname(dirname(dirname(__FILE__))))) . '/vendors/friendfeed.php');
			if ($friendfeed = new FriendFeed($username, $apikey)) {
				
				try {
					$feed = $friendfeed->fetch_user_feed($username, null, 0, $vars['entity']->num_display);
				} catch (Exception $e) {
					echo $e->getMessage();
				}
				if (!empty($feed)) {
					$entries = $feed->entries;
					if (is_array($entries) && !empty($entries)) {
						foreach($entries as $entry) {
							
							$updated = friendly_time($entry->updated);
							$title = $entry->title;
							$service = $entry->service->name;
							$service_icon = $entry->service->iconUrl;
							$link = $entry->link;
							$url = $entry->service->profileUrl;
							
							foreach ($entry->media as $media) {
	                            foreach ($media->thumbnails as $thumb) {
                                    $data .= '<a href="' . $link . '"><img src="'.$thumb->url.'" /></a>';
                                }
                            }

							
							if (isset($entry->service->entryType)) {
								$entrytype = $entry->service->entryType;
								if ($entrytype == 'favorite') {
									$entrytype = elgg_echo('friendfeed:favorited');
								} else {
									$entrytype = '';
								}
							} else {
								$entrytype = '';
							}
							
?>

	<div class="friendfeed_item">
		<p>
			<span class="friendfeed_title"><img src="<?php echo $service_icon; ?>" /><?php echo $entrytype; ?> <a href="<?php echo $link; ?>"><?php echo $title; ?></a></span>:
			<span class="friendfeed_stamp"><a href="<?php echo $url; ?>"><?php echo $service; ?></a>, <?php echo $updated . "<br /><div class=\"ff_media\">" . $data; ?></div></span>
		</p>
	</div>

<?php
							$data = ''; //clear data
							
						}
					} else {
						echo "<p>" . elgg_echo('friendfeed:nonefound') . "</p>";						
					}
					
				} else {
					echo "<p>" . elgg_echo('friendfeed:nonefound') . "</p>";
				}
				
			} else {
				
				echo '<p>' . elgg_echo('friendfeed:epicfail') . '</p>';
				
			}
			
		} else {
			
			echo "<p>" . elgg_echo('friendfeed:nouser') . "</p>";
			
		}

?>