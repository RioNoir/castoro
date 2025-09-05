<?php

namespace App\Providers;

use CodeBugLab\Tmdb\Repository\AbstractRepository;
use CodeBugLab\Tmdb\Tmdb;
use CodeBugLab\Tmdb\Url\ApiGenerator;
use Illuminate\Support\ServiceProvider;

class TMDBServiceProvider extends ServiceProvider
{
    public function boot(){}

    public function register()
    {
        $this->app->bind(ApiGenerator::class, function () {
            $apiKey = (!empty(cstr_config('tmdb.api_key')) ? cstr_config('tmdb.api_key') : "");
            $apiLanguage = (!empty(cstr_config('tmdb.api_language')) ? cstr_config('tmdb.api_language') : "en");
            return new ApiGenerator(AbstractRepository::$apiUrl, $apiKey, $apiLanguage);
        });

        $this->app->bind('Tmdb', Tmdb::class);
    }
}
