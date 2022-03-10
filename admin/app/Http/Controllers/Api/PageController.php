<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Services\Page\Models\Page;

use App\Repositories\PageRepository;
use App\Repositories\SettingsRepository;
use Localization;

class PageController extends Controller
{

    protected $pageRepository;
    protected $settingsRepository;

    public function __construct(PageRepository $pageRepository, SettingsRepository $settingsRepository)
    {
        $this->pageRepository = $pageRepository;
        $this->settingsRepository = $settingsRepository;
    }

    public function index()
    {
        return [
            'settings' => $this->settingsRepository->getMap(),
            'pages' => $this->pageRepository->getMap(),
            'menu' => $this->pageRepository->getMenu(),
            'menuServices' => $this->pageRepository->getMenuServices()
        ];
    }

    public function process(string $slug, $related = null)
    {
        $page = Page::active()->findBySlugOrFail($slug);
        return $related ? $page->prepareRelated($related) : $page->prepare();
    }

    public function storeTranslation(Request $request, string $slug, $related = null)
    {
        $page = Page::active()->findBySlugOrFail($slug);

        $translation = Localization::findOrCreateTranslation($request->text);

        if (!$page->translations()->wherePivot('level', $related ? 1 : 0)->where('id', $translation->id)->exists()) {
            $page->translations()->attach([
                $translation->id => [
                    'level' => $related ? 1 : 0
                ]
            ]);
        }

        return [
            $translation->hash => $translation->translation
        ];
    }

}
