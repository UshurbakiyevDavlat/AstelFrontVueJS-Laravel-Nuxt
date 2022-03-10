<?php

const PUBLISHED = 1;
const DRAFT = 0;

function json_decode_recursive($str, bool $toArray = false, bool $deepArray = false)
{
    $decoded = is_string($str) ? json_decode($str, $toArray) : $str;

    if (is_object($decoded)) {
        foreach($decoded as $key => $value) {
            $decoded->{$key} = json_decode_recursive($value, $deepArray && $toArray);
        }
    } else if (is_array($decoded)) {
        for($i = 0; $i < count($decoded); ++$i) {
            $decoded[$i] = json_decode_recursive($decoded[$i], $deepArray && $toArray);
        }
    }

    return $decoded ?? $str;
}

function implodeToString($input)
{
    if (is_string($input)) {
        return mb_strtolower($input);
    }

    if (is_array($input)) {
        return implode(' | ', array_filter(array_map('implodeToString', array_values($input))));
    }

    return $input ? $input : '';
}

function stripAndLimit(string $text, $limit = 100)
{
    return \Str::limit(
        preg_replace(
            '/\s+/S', " ",
            trim(
                str_replace(
                    '&nbsp;', '',
                    strip_tags($text)
                )
            )
        ),
        $limit
    );
}

function elfinder($str = null)
{
    if (!$str) {
        return null;
    }

    if (is_array($str)) {
        return array_map('elfinder', $str);
    }

    return Storage::disk('elfinder')->url($str);
}
