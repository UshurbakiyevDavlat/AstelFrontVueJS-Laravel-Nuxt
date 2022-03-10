<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use Spatie\Sitemap\Sitemap;
use Spatie\Sitemap\Tags\Url;

use App\Services\Page\Models\Page;

use App\Models\Post;
use App\Models\Project;
use App\Models\Service;

use Localization;

class GenerateSitemap extends Command
{
    protected $signature = 'sitemap:generate';

    protected $description = 'Generates sitemap.xml';

    protected $sitemap;

    protected $pages = [];

    public function __construct()
    {
        parent::__construct();

        $this->sitemap = Sitemap::create();
    }

    public function handle()
    {
        $this->addPages();
        $this->addPosts();
        $this->addProjects();
        $this->addServices();

        $this->sitemap->writeToFile(public_path('sitemap.xml'));

        return 0;
    }

    private function addPages()
    {
        $pages = Page::active()->get();
        foreach($pages as $page) {
            $this->pages[$page->template] = $page;
            $this->addUrl($page);
        }

    }

    private function addPosts()
    {
        if (!isset($this->pages['blog'])) {
            return;
        }
        $page = $this->pages['blog'];

        $posts = Post::published()->get();

        foreach($posts as $post) {
            $this->addUrl($page, $post, 0.9);
        }
    }

    private function addProjects()
    {
        if (!isset($this->pages['projects'])) {
            return;
        }
        $page = $this->pages['projects'];

        $projects = Project::published()->get();

        foreach($projects as $project) {
            $this->addUrl($page, $project, 0.9);
        }
    }

    public function addServices()
    {
        if (!isset($this->pages['services'])) {
            return;
        }

        $services = Service::main()->get();
        foreach($services as $service) {
            $this->addService($service);
        }
    }

    public function addService($service, $pref = null)
    {
        $service->full_slug = implode('/', array_filter([$pref, $service->slug]));
        $this->addUrl($this->pages['services'], $service);
        foreach($service->childServices as $child) {
            $this->addService($child, $service->full_slug);
        }
    }


    private function addUrl(Page $page, $inner = null, $priority = 1)
    {
        $locales = Localization::getLocales();
        unset($locales[\App::getLocale()]); // Unset current locale (current = default)
        $url = Url::create($this->pageUrl($page, $inner));

        $url->setChangeFrequency(Url::CHANGE_FREQUENCY_DAILY)
            ->setPriority($priority)
            ->setPriority($priority)
            ->setLastModificationDate(($inner && $inner->updated_at) ? $inner->updated_at : $page->updated_at);

        foreach($locales as $key => $locale) {
            $url->addAlternate($this->pageUrl($page, $inner, $key), $key);
        }

        $this->sitemap->add($url);
    }

    private function pageUrl($page, $inner, $locale = null) : string
    {
        return implode(
            '/',
            array_filter(
                [
                    config('app.frontend_url'),
                    $locale,
                    $page->template == 'home' ? null : $page->getFullSlug(),
                    $inner ? $inner->getFullSlug() : null
                ]
            )
        );
    }

}
