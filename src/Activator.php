<?php
namespace Rasta\UserFetcher;

class Activator
{
    // available url endpoint of fetch user page
    protected $endpoint;
    // DependencyHandler class
    protected $handler;
    // holds a array of js files to load
    public $js_dependendies;
    /***
    * page can have 3 states:
    *   null : not fetched yet
    *   array: containing the page information
    *   false: tried to fetch witch current endpoint, but no result found
    * to cache bust use setEndpoint first
    **/
    protected $page;
    // page title of fetch user page
    protected $page_title;
    // snippet to be included to start js functionalities
    protected $snippet;

    public function __construct($endpoint = null, $page_title = null, $snippet = null, $handler = null)
    {
        $this->setEndpoint($endpoint)
            ->setPageTitle($page_title)
            ->setSnippet($snippet)
            ->setHandler($handler);
    }

    /**
     * @return string
     */
    public function getEndpoint():string
    {
        if (!isset($this->endpoint)) {
            $this->endpoint = 'ras-user-fetcher';
        }

        return $this->endpoint;
    }

    public function setEndpoint(?string $endpoint_name):self
    {
        if ($this->endpoint !== $endpoint_name) {
            $this->endpoint = $endpoint_name;
            // reset cached page for new endpoint
            $this->page = null;
        }

        return $this;
    }

    public function getHandler():string
    {
        if (!isset($this->handler)) {
            $this->handler = 'Rasta\UserFetcher\Handler';
        }

        return $this->handler;
    }

    public function setHandler(?string $handler):self
    {
        $this->handler = $handler;

        return $this;
    }

    public function getPage()
    {
        // check if we fetched the page already
        if (!isset($this->page)) {
            // fetch page from wp via handler for code speparation
            $this->page = $this->getHandler()::getPageByPath($this->getEndpoint()) ?? false;
        }

        return $this->page;
    }

    public function setPage(?array $page):self
    {
        $this->page = $page;

        return $this;
    }

    public function getPageTitle():string
    {
        if (!isset($this->page_title)) {
            $this->page_title = 'Users Table';
        }

        return $this->page_title;
    }

    public function setPageTitle(?string $page_title):self
    {
        $this->page_title = $page_title;

        return $this;
    }

    public function getSnippet():string
    {
        if (!isset($this->snippet)) {
            $this->snippet = '<div id="ras-user-fetcher-details"></div><div id="ras-user-fetcher"></div>';
        }

        return $this->snippet;
    }

    public function setSnippet(?string $snippet):self
    {
        $this->snippet = $snippet;

        return $this;
    }

    /**
    * Exposed Activation step
    *
    **/
    public function activate():bool
    {
        return $this->createPage();
    }

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
    * Exposed deactivation step
    *
    **/
    public function deactivate():bool
    {
        return $this->deletePage();
    }

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

    public function pageExists():bool
    {
        return ($this->getPage() === false) ? false : true;
    }

    public function loadScripts():bool
    {
        // call handler to enqueue scipts
        // provide current endpoint and JS dependencies
        // returns true if something was enqueued, false otherwise
        return self::getHandler()::enqueueScripts($this->getEndpoint(), $this->getJSDependencies());
    }

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
