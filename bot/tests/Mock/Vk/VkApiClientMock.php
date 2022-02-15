<?php

declare(strict_types=1);

namespace Test\Mock\Vk;

use VK\Actions\Account;
use VK\Actions\Ads;
use VK\Actions\Apps;
use VK\Actions\Auth;
use VK\Actions\Board;
use VK\Actions\Database;
use VK\Actions\Docs;
use VK\Actions\Fave;
use VK\Actions\Friends;
use VK\Actions\Gifts;
use VK\Actions\Groups;
use VK\Actions\Leads;
use VK\Actions\Likes;
use VK\Actions\Market;
use VK\Actions\Messages;
use VK\Actions\Newsfeed;
use VK\Actions\Notes;
use VK\Actions\Notifications;
use VK\Actions\Orders;
use VK\Actions\Pages;
use VK\Actions\Photos;
use VK\Actions\Polls;
use VK\Actions\Search;
use VK\Actions\Secure;
use VK\Actions\Stats;
use VK\Actions\Status;
use VK\Actions\Storage;
use VK\Actions\Stories;
use VK\Actions\Streaming;
use VK\Actions\Users;
use VK\Actions\Utils;
use VK\Actions\Video;
use VK\Actions\Wall;
use VK\Actions\Widgets;
use VK\Client\VKApiClient;

/**
 * @psalm-suppress
 */
class VkApiClientMock extends VKApiClient
{
    /**
     * @var Account
     */
    private $account;

    /**
     * @var Ads
     */
    private $ads;

    /**
     * @var Apps
     */
    private $apps;

    /**
     * @var Auth
     */
    private $auth;

    /**
     * @var Board
     */
    private $board;

    /**
     * @var Database
     */
    private $database;

    /**
     * @var Docs
     */
    private $docs;

    /**
     * @var Fave
     */
    private $fave;

    /**
     * @var Friends
     */
    private $friends;

    /**
     * @var Gifts
     */
    private $gifts;

    /**
     * @var Groups
     */
    private $groups;

    /**
     * @var Leads
     */
    private $leads;

    /**
     * @var Likes
     */
    private $likes;

    /**
     * @var Market
     */
    private $market;

    /**
     * @var Messages
     */
    private $messages;

    /**
     * @var Newsfeed
     */
    private $newsfeed;

    /**
     * @var Notes
     */
    private $notes;

    /**
     * @var Notifications
     */
    private $notifications;

    /**
     * @var Orders
     */
    private $orders;

    /**
     * @var Pages
     */
    private $pages;

    /**
     * @var Photos
     */
    private $photos;

    /**
     * @var Polls
     */
    private $polls;

    /**
     * @var Search
     */
    private $search;

    /**
     * @var Secure
     */
    private $secure;

    /**
     * @var Stats
     */
    private $stats;

    /**
     * @var Status
     */
    private $status;

    /**
     * @var Storage
     */
    private $storage;

    /**
     * @var Stories
     */
    private $stories;

    /**
     * @var Streaming
     */
    private $streaming;

    /**
     * @var Users
     */
    private $users;

    /**
     * @var Utils
     */
    private $utils;

    /**
     * @var Video
     */
    private $video;

    /**
     * @var Wall
     */
    private $wall;

    /**
     * @var Widgets
     */
    private $widgets;

    public function __construct(private VkApiRequestMock $request)
    {
    }

    public function getRequest(): VkApiRequestMock
    {
        return $this->request;
    }

    public function account(): Account
    {
        if (!$this->account) {
            $this->account = new Account($this->request);
        }

        return $this->account;
    }

    public function ads(): Ads
    {
        if (!$this->ads) {
            $this->ads = new Ads($this->request);
        }

        return $this->ads;
    }

    public function apps(): Apps
    {
        if (!$this->apps) {
            $this->apps = new Apps($this->request);
        }

        return $this->apps;
    }

    public function auth(): Auth
    {
        if (!$this->auth) {
            $this->auth = new Auth($this->request);
        }

        return $this->auth;
    }

    public function board(): Board
    {
        if (!$this->board) {
            $this->board = new Board($this->request);
        }

        return $this->board;
    }

    public function database(): Database
    {
        if (!$this->database) {
            $this->database = new Database($this->request);
        }

        return $this->database;
    }

    public function docs(): Docs
    {
        if (!$this->docs) {
            $this->docs = new Docs($this->request);
        }

        return $this->docs;
    }

    public function fave(): Fave
    {
        if (!$this->fave) {
            $this->fave = new Fave($this->request);
        }

        return $this->fave;
    }

    public function friends(): Friends
    {
        if (!$this->friends) {
            $this->friends = new Friends($this->request);
        }

        return $this->friends;
    }

    public function gifts(): Gifts
    {
        if (!$this->gifts) {
            $this->gifts = new Gifts($this->request);
        }

        return $this->gifts;
    }

    public function groups(): Groups
    {
        if (!$this->groups) {
            $this->groups = new Groups($this->request);
        }

        return $this->groups;
    }

    public function leads(): Leads
    {
        if (!$this->leads) {
            $this->leads = new Leads($this->request);
        }

        return $this->leads;
    }

    public function likes(): Likes
    {
        if (!$this->likes) {
            $this->likes = new Likes($this->request);
        }

        return $this->likes;
    }

    public function market(): Market
    {
        if (!$this->market) {
            $this->market = new Market($this->request);
        }

        return $this->market;
    }

    public function messages(): Messages
    {
        if (!$this->messages) {
            $this->messages = new Messages($this->request);
        }

        return $this->messages;
    }

    public function newsfeed(): Newsfeed
    {
        if (!$this->newsfeed) {
            $this->newsfeed = new Newsfeed($this->request);
        }

        return $this->newsfeed;
    }

    public function notes(): Notes
    {
        if (!$this->notes) {
            $this->notes = new Notes($this->request);
        }

        return $this->notes;
    }

    public function notifications(): Notifications
    {
        if (!$this->notifications) {
            $this->notifications = new Notifications($this->request);
        }

        return $this->notifications;
    }

    public function orders(): Orders
    {
        if (!$this->orders) {
            $this->orders = new Orders($this->request);
        }

        return $this->orders;
    }

    public function pages(): Pages
    {
        if (!$this->pages) {
            $this->pages = new Pages($this->request);
        }

        return $this->pages;
    }

    public function photos(): Photos
    {
        if (!$this->photos) {
            $this->photos = new Photos($this->request);
        }

        return $this->photos;
    }

    public function polls(): Polls
    {
        if (!$this->polls) {
            $this->polls = new Polls($this->request);
        }

        return $this->polls;
    }

    public function search(): Search
    {
        if (!$this->search) {
            $this->search = new Search($this->request);
        }

        return $this->search;
    }

    public function secure(): Secure
    {
        if (!$this->secure) {
            $this->secure = new Secure($this->request);
        }

        return $this->secure;
    }

    public function stats(): Stats
    {
        if (!$this->stats) {
            $this->stats = new Stats($this->request);
        }

        return $this->stats;
    }

    public function status(): Status
    {
        if (!$this->status) {
            $this->status = new Status($this->request);
        }

        return $this->status;
    }

    public function storage(): Storage
    {
        if (!$this->storage) {
            $this->storage = new Storage($this->request);
        }

        return $this->storage;
    }

    public function stories(): Stories
    {
        if (!$this->stories) {
            $this->stories = new Stories($this->request);
        }

        return $this->stories;
    }

    public function streaming(): Streaming
    {
        if (!$this->streaming) {
            $this->streaming = new Streaming($this->request);
        }

        return $this->streaming;
    }

    public function users(): Users
    {
        if (!$this->users) {
            $this->users = new Users($this->request);
        }

        return $this->users;
    }

    public function utils(): Utils
    {
        if (!$this->utils) {
            $this->utils = new Utils($this->request);
        }

        return $this->utils;
    }

    public function video(): Video
    {
        if (!$this->video) {
            $this->video = new Video($this->request);
        }

        return $this->video;
    }

    public function wall(): Wall
    {
        if (!$this->wall) {
            $this->wall = new Wall($this->request);
        }

        return $this->wall;
    }

    public function widgets(): Widgets
    {
        if (!$this->widgets) {
            $this->widgets = new Widgets($this->request);
        }

        return $this->widgets;
    }
}
