<?php

namespace App\Classes;

class SeoManager
{
    private static array $seos = [];

    private static array $socials = [];

    public function __construct(?array $seos = null)
    {
        if ($seos) {
            $this->set($seos);
        }
    }

    public function set(string|array $key, string|int|null $value = null)
    {
        static::setSeo($key, $value);

        return $this;
    }

    public function get(?string $key = null)
    {
        return static::getSeo($key);
    }

    public function html(): string
    {
        return static::getHtml();
    }

    public function title(string $value)
    {
        return $this->set('title', $value);
    }

    public function description(string $value)
    {
        return $this->set('description', $value);
    }

    public function keywords(string $value)
    {
        return $this->set('keywords', $value);
    }

    public function robots(string $value)
    {
        return $this->set('robots', $value);
    }

    public function canonical(string $value)
    {
        return $this->set('canonical', $value);
    }

    public function siteName(string $value)
    {
        return $this->set('site_name', $value);
    }

    public function type(string $value)
    {
        return $this->set('type', $value);
    }

    public function image(string $value)
    {
        return $this->set('image', $value);
    }

    public function logo(string $value)
    {
        return $this->set('logo', $value);
    }

    public function social(string|array $url)
    {
        static::setSocial($url);

        return $this;
    }

    public static function setSeo(string|array $key, string|int|null $value = null): void
    {
        if (is_array($key)) {
            static::$seos = array_merge(static::$seos, $key);
        } else {
            static::$seos[$key] = $value;
        }
    }

    public static function getSeo(?string $key = null)
    {
        return $key ? static::$seos[$key] : static::$seos;
    }

    public static function getHtml(): string
    {
        return view('layout.seo', [
            'seo' => static::getSeo(),
            'socials' => static::getSocials(),
        ])->render();
    }

    public static function setSocial(string|array $url): void
    {
        if (is_array($url)) {
            static::$socials = array_merge(static::$socials, $url);
        } else {
            static::$socials[] = $url;
        }
    }

    public static function getSocials(): array
    {
        return static::$socials;
    }
}
