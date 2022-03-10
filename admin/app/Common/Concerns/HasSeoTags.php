<?php

namespace App\Common\Concerns;

trait HasSeoTags
{

    public function getSeoTags() : array
    {
        $seo = $this->decoded('seo');

        return [
            'seo_title' => $seo->seo_title ?? $this->name,
            'seo_keywords' => $seo->seo_keywords ?? null,
            'seo_description' => $seo->seo_description ?? null,
            'seo_image' => elfinder($seo->seo_image ?? $this->image),
        ];
    }

}
