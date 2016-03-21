<?php
/**
 * Plugin class
 */
namespace Phile\Plugin\StephenKeable\jsonExport;

/**
 * JSON Export
 */
class Plugin extends \Phile\Plugin\AbstractPlugin implements \Phile\Gateway\EventObserverInterface {

	public function __construct() {
		\Phile\Event::registerEvent('plugins_loaded', $this);
	}

	public function on($eventKey, $data = null) {
		// check $eventKey for which you have registered
		if ($eventKey == 'plugins_loaded') {
			$uri = $_SERVER['REQUEST_URI'];
			$uri = str_replace('/' . \Phile\Utility::getInstallPath(), '', $uri);
			
			
			// Change this to something else if you want
			if ($uri == '/pages.json') {
			
				$pageRespository = new \Phile\Repository\Page();
				$pages = $pageRespository->findAll();

				// set the json headers
				header($_SERVER['SERVER_PROTOCOL'] . ' 200 OK');
				header('Content-Type: application/json; charset=UTF-8');
				
				// create empty array for the json objects
				$json_obj = array();
				
				foreach( $pages as $page ){
				
					// create empty page object
					$the_page = new \stdClass();
					
					// Add items to the object that you want
					$the_page->page_url = \Phile\Utility::getBaseUrl() . '/' . preg_replace('/(^|\/)index$/', '', $page->getUrl());
					$the_page->page_modified = strftime('%Y-%m-%d', filemtime($page->getFilePath()));
					$the_page->page_title = $page->getTitle();
					$the_page->page_content = $page->getContent();
					
					//get meta info for page example
					// $page_meta = $page->getMeta();
					// $the_page->page_seo_title = $page_meta->get('seotitle');
					// $the_page->page_description = $page_meta->get('description');
					
					// push the page to the json object
					$json_obj[] = $the_page;
					
					// free the memory for the page object
					unset($the_page);
 					unset($page_meta);
					
				}
				
				// encode the json object and spit it out
				echo json_encode($json_obj);
				
				exit;
			}
		}
	}
}
