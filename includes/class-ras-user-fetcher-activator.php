<?php
/**
 * Fired during plugin activation
 *
 * @link       rasta.online
 * @since      1.0.0
 *
 * @package    Ras_User_Fetcher
 * @subpackage Ras_User_Fetcher/includes
 */


class Ras_User_Fetcher_Activator {

	protected $endpoint = 'ras-user-fetcher';
	protected $page_title ='User Fetcher';
	protected $page;
	protected $js_snippet = '<script>console.log("Welcome Rasta");</script>';
	protected $uf_exist;

	/**
	 * runs once while plugin activation
	 * adds required page if not already existent
	 *
	 * @since    1.0.0
	 */
	public function activate():bool {

		return $this->create_userfetcher_page();
	}

	protected function create_userfetcher_page():bool
    {
    	if(!$this->userfetcher_exists()){
    		// create page for the user fetcher
    		$page_userfetcher = [
				  'post_title'    => $this->page_title,
				  'post_name'		=> $this->endpoint,
  				'post_content'  => $this->get_snippet(),
  				'post_status'   => 'publish',
  				'post_author'   => get_current_user_id(),
  				'post_type' => 'page'
    		];
   			wp_insert_post( $page_userfetcher );
   			return true;
    	}
    	return false;
    }

	/**
	 * runs on plugin deactivation
	 * to remove rewrite endpoint flush rewrite rules
	 *
	 * @since    1.0.0
	 */
	public function deactivate():bool {
		return $this->delete_userfetcher_page();
	}


  protected function delete_userfetcher_page():bool
  {
    $page = get_page_by_path( $this->endpoint );
    // nothing to clean up, early finish
    if($page === NULL){
        return false;
    }
    else{
      //delete our custom page
      wp_delete_post($page->ID);
      // refresh post data
      wp_reset_postdata ();
      return true;
    }
  }

  protected function userfetcher_exists():bool
  {
    $page = get_page_by_path( $this->endpoint );
    return ($page === NULL)? false: true;
  }

  public function get_page(){

  }

  protected function get_snippet():string {
    return $this->js_snippet;
  }

}
