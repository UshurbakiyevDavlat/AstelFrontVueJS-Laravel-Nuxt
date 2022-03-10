<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

use App\Services\Settings\Models\Settings;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Settings::firstOrCreate([
            'key' => 'callback_mail'
        ], [
            'name' => 'Email для обратных звонков',
            'value' => null,
            'field' => $this->field([
                'type' => 'text'
            ])
        ]);

        Settings::firstOrCreate([
            'key' => 'servicecallback_mail'
        ], [
            'name' => 'Email для запросов на консультацию',
            'value' => null,
            'field' => $this->field([
                'type' => 'text'
            ])
        ]);


        Settings::firstOrCreate([
            'key' => 'partnership_mail'
        ], [
            'name' => 'Email для запросов на сотрудничество',
            'value' => null,
            'field' => $this->field([
                'type' => 'text'
            ])
        ]);

        Settings::firstOrCreate([
            'key' => 'jobapplication_mail'
        ], [
            'name' => 'Email HR менеджера',
            'value' => null,
            'field' => $this->field([
                'type' => 'text'
            ])
        ]);

        Settings::firstOrCreate([
            'key' => 'linkedin',
        ], [
            'name' => 'LinkedIn',
            'value' => 'https://linkedin.com',
            'field' => $this->field([
                'type' => 'url'
            ])
        ]);

        Settings::firstOrCreate([
            'key' => 'instagram',
        ], [
            'name' => 'Instagram',
            'value' => 'https://instagram.com',
            'field' => $this->field([
                'type' => 'url'
            ])
        ]);

        Settings::firstOrCreate([
            'key' => 'facebook',
        ], [
            'name' => 'Facebook',
            'value' => 'https://facebook.com',
            'field' => $this->field([
                'type' => 'url'
            ])
        ]);

        Settings::firstOrCreate([
            'key' => 'privacy_policy',
        ], [
            'name' => 'Политика конфиденциальности',
            'value' => null,
            'field' => $this->field([
                'type' => 'browse'
            ])
        ]);

        Settings::firstOrCreate([
            'key' => 'offer_agreement',
        ], [
            'name' => 'Договор оферта',
            'value' => null,
            'field' => $this->field([
                'type' => 'browse'
            ])
        ]);

    }

    protected function field(array $field) : array
    {
        return array_merge([
            'name' => 'value',
            'label' => trans('admin.value'),
            'type' => 'text',
        ], $field);
    }
}
