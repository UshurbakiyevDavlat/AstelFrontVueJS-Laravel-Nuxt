<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\TranslationRequest;
use Backpack\CRUD\app\Library\CrudPanel\CrudPanelFacade as CRUD;

use App\Services\Localization\Models\Translation;
use Localization;
use App;

class TranslationCrudController extends CrudController
{
    use \Backpack\CRUD\app\Http\Controllers\Operations\ListOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\CreateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\UpdateOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\DeleteOperation;
    use \Backpack\CRUD\app\Http\Controllers\Operations\ShowOperation;

    public function setup()
    {
        CRUD::setModel(Translation::class);
        CRUD::setRoute(config('backpack.base.route_prefix') . '/translation');
        CRUD::setEntityNameStrings(trans_choice('admin.translations', 1), trans_choice('admin.translations', 2));

        CRUD::denyAccess(['create']);
        CRUD::enableExportButtons();

        $this->locales = Localization::getLocales();
    }

    protected function setupListOperation()
    {
        CRUD::removeAllButtonsFromStack('line');

        $this->addTranslationColumn(App::getLocale());
        foreach($this->locales as $key => $locale) {
            if ($key != App::getLocale()) {
                $this->addTranslationColumn($key);
            }
        }
    }

    private function addTranslationColumn(string $locale)
    {
        CRUD::addColumn([
            'name' => "translation->{$locale}",
            'label' => $this->locales[$locale],
            'type' => 'translation',
            'locale' => $locale,
            'limit' => 80,
            'searchLogic' => function ($query, $column, $searchTerm) use ($locale) {
                $searchTerm = strtolower($searchTerm);
                $query->orWhereRaw("LOWER(JSON_EXTRACT(translation, \"$.{$locale}\")) LIKE \"%{$searchTerm}%\"")
                      ->orWhere(function($query) use ($column, $searchTerm, $locale) {
                          $query->whereNull("translation->{$locale}")
                                ->whereRaw("LOWER(JSON_EXTRACT(translation, \"$.{$locale}\")) LIKE \"%{$searchTerm}%\"");
                      });
            },
        ]);
    }

    protected function setupCreateOperation()
    {
        CRUD::setValidation(TranslationRequest::class);

    }

    protected function setupUpdateOperation()
    {
        $this->setupCreateOperation();

        $entry = CRUD::getCurrentEntry();
        $locale = request()->locale;

        CRUD::addFields([
            [
                'name' => 'translation_original',
                'type' => 'custom_html',
                'value' => $entry->getTranslation('translation', App::getLocale()),
            ],
            [
                'name' => 'translation',
                'label' => $this->locales[$locale],
                'type' => 'textarea',
                'hint' => trans('admin.translation_hint')
            ],
        ]);

    }
}
