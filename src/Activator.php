<?php
namespace Rasta\UserFetcher;

class Activator
{
    // available url endpoint of fetch user page
    protected $endpoint;
    // DependencyHandler class
    protected $handler;
    // reference to fetch user page
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

    public function getEndpoint():string
    {
        if (!isset($this->endpoint)) {
            $this->endpoint = defined('RAS_USER_FETCHER_ENDPOINT')? RAS_USER_FETCHER_ENDPOINT:'ras-user-fetcher';
        }

        return $this->endpoint;
    }

    public function setEndpoint(?string $endpoint_name):self
    {
        $this->endpoint = $endpoint_name;

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
          // set the page or false if non-existent
            // ToDo: use handler
            $this->page = get_page_by_path($this->endpoint) ?? false;
        }

        return $this->page;
    }

    public function setPage($page):self
    {
        $this->page = $page;

        return $this;
    }

    public function getPageTitle():string
    {
        if (!isset($this->page_title)) {
            $this->page_title = defined('RAS_USER_FETCHER_PAGETITLE')? RAS_USER_FETCHER_PAGETITLE: 'Users Table';
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
            $this->snippet = defined('RAS_USER_FETCHER_SNIPPET')? RAS_USER_FETCHER_SNIPPET :
            '<div id="ras-user-fetcher-details" /><div id="ras-user-fetcher" />';
        }

        return $this->snippet;
    }

    public function setSnippet(?string $snippet):self
    {
        $this->snippet = $snippet;

        return $this;
    }
}
