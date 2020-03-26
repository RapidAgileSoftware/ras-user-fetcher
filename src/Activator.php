<?php
namespace Rasta\UserFetcher;

/**
 * Activator class is responsible for all steps required to get the plugin upp and running
 * and to clean up while deactivation
 */
class Activator
{
    /**
     * available url endpoint of UserFetcher page
     * @var string
     */
    protected $endpoint;
    /**
     * Dependency Handler class name
     * Dependency handlers offer an abstraction level for
     * direct interactions with the host system (wp) or other dependencies (curl)
     * using this approach allows us two main benefits:
     * - we just need to mock this static class for testing, the rest is supposed to be system agnostic
     * - we can replace even critical modules if the environment requires (no curl available)
     * @var string
     */
    protected $handler;
    /**
     * list of needed js files
     * @var array
     */
    public $js_dependendies;

    /**
    * page can have 3 states:
    *   null : not fetched yet
    *   array: containing the page information
    *   false: tried to fetch witch current endpoint, but no result found
    * to cache bust use setEndpoint first
    * @var array
    **/
    protected $page;
    /**
     * visible page title of UserFetcher page
     * @var string
     */
    protected $page_title;
    /**
     * hrml snippet to start JavaScript app
     * needs to deliver root point for jTable
     * @var string
     */
    protected $snippet;

    /**
     * constructor
     * @param string $endpoint   uri of UserFetcher page
     * @param string $page_title visible title of UserFetcher page
     * @param string $snippet html snippet to be included to setup jTable app
     * @param string $handler dependency abstration layer, name of static class
     */
    public function __construct($endpoint = null, $page_title = null, $snippet = null, $handler = null)
    {
        $this->setEndpoint($endpoint)
            ->setPageTitle($page_title)
            ->setSnippet($snippet)
            ->setHandler($handler);
    }

    /**
     * getter for endpoint property
     * @return string enpoint property
     * default: ras-user-fetcher
     */
    public function getEndpoint():string
    {
        if (!isset($this->endpoint)) {
            $this->endpoint = 'ras-user-fetcher';
        }

        return $this->endpoint;
    }

    /**
     * setter endpoint property
     * @param ?string $endpoint_name
     * can be null
     * unsets cached page property
     */
    public function setEndpoint(?string $endpoint_name):self
    {
        if ($this->endpoint !== $endpoint_name) {
            $this->endpoint = $endpoint_name;
            // reset cached page for new endpoint
            $this->page = null;
        }

        return $this;
    }

    /**
     * getter handler property
     * @return string name of dependency abstraction layer
     * default: 'Rasta\UserFetcher\Handler'
     */
    public function getHandler():string
    {
        if (!isset($this->handler)) {
            $this->handler = 'Rasta\UserFetcher\Handler';
        }

        return $this->handler;
    }

    /**
     * setter handler property
     * @param string $handler name of dependency abstraction layer
     */
    public function setHandler(?string $handler):self
    {
        $this->handler = $handler;

        return $this;
    }

    /**
     * caches and fetches our UserFetcher page from wp
     * contains all needed info to work with it
     * @return array UserFetcher page
     */
    public function getPage()
    {
        // check if we fetched the page already
        if (!isset($this->page)) {
            // fetch page from wp via handler for code speparation
            $this->page = $this->getHandler()::getPageByPath($this->getEndpoint()) ?? false;
        }

        return $this->page;
    }

    /**
     * setter page property
     * @param array $page UserFetcher page
     */
    public function setPage(?array $page):self
    {
        $this->page = $page;

        return $this;
    }

    /**
     * getter page_title property
     * @return string visible title of UserFetcher page
     * default: Users Table
     */
    public function getPageTitle():string
    {
        if (!isset($this->page_title)) {
            $this->page_title = 'Users Table';
        }

        return $this->page_title;
    }

    /**
     * setter page_title property
     * @param string $page_title visible title of UserFetcher page
     */
    public function setPageTitle(?string $page_title):self
    {
        $this->page_title = $page_title;

        return $this;
    }

    /**
     * getter ssnippet property
     * needs to contain #ras-user-fetcher and #ras-user-fetcher-details to work
     * @return string html-snippet needed to start jTable extension
     */
    public function getSnippet():string
    {
        if (!isset($this->snippet)) {
            $this->snippet = '<div id="ras-user-fetcher-details"></div><div id="ras-user-fetcher"></div>';
        }

        return $this->snippet;
    }

    /**
     * setter snippet property
     * @param string $snippet html-snippet needed to start jTable extension
     */
    public function setSnippet(?string $snippet):self
    {
        $this->snippet = $snippet;

        return $this;
    }

    /**
     * Exposed Plugin Activation step
     * triggers creation of UserFetcher page
     * can be extended to contain more steps
     * @return bool success status
     */
    public function activate():bool
    {
        return $this->createPage();
    }

    /**
     * creates UserFetcher page according its configuration
     * @return bool success status of creating the page
     */
    protected function createPage():bool
    {
        if (!$this->pageExists()) {
            // create page for the user fetcher
            $page = [
                'post_title'  => $this->getPageTitle(),
                'post_name'   => $this->getEndpoint(),
                'post_content' => $this->getSnippet(),
                'post_status' => 'publish',
                'post_type'   => 'page'
            ];
            // get new page id from Handler
            $page_id = $this->getHandler()::insertPost($page);
            if ($page_id > 0) {
                $page['ID'] = $page_id;
                $this->setPage($page);

                return true;
            }
        }

        return false;
    }

     /**
     * Exposed Plugin Decctivation step
     * triggers deletion of UserFetcher page
     * can be extended to contain more steps
     * @return bool success status
     */
    public function deactivate():bool
    {
        return $this->deletePage();
    }

    /**
     * deletes UserFetcher page if found
     *  @return bool success status]
     */
    protected function deletePage():bool
    {
        $page = $this->getPage();
        // nothing to clean up, early finish
        if ($page === false) {
            return false;
        }

        $pageID = intval($page['ID']) ?? 0;
        if ($pageID > 0) {
            $this->getHandler()::deletePost($pageID);
            $this->page = false;
            $this->getHandler()::resetPostData();

            return true;
        }

        return false;
    }

    /**
     * do we find the UserFetcher page?
     * @return bool success
     */
    public function pageExists():bool
    {
        return ($this->getPage() === false) ? false : true;
    }

    /**
     * calls handler to enqueue scipts
     * provide current endpoint and JS dependencies
     * @return [type] [description]
     * returns true if something was enqueued, false otherwise
     */
    public function loadScripts():bool
    {
        
        return self::getHandler()::enqueueScripts($this->getEndpoint(), $this->getJSDependencies());
    }

    /**
     * getter js_dependency property
     * @return array list of needed js files to be included
     */
    public function getJSDependencies():array
    {
        if (!isset($this->js_dependendies)) {
            $this->js_dependendies = [
                ['handle' => 'rasta-user-fetcher-ui', 'src' => '../public/js/jquery-ui.min.js'],
                ['handle' => 'rasta-user-fetcher-jtable', 'src' => '../public/js/jquery.jtable.min.js'],
                ['handle' => 'rasta-user-fetcher-core', 'src' => '../public/js/rasta-user-fetcher.min.js']
            ];
        }

        return $this->js_dependendies;
    }
}
