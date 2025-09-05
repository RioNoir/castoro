<?php

return [
    'url' => 'http://localhost:8097',
    'external_url' => 'http://localhost:8096',
    'library_path' => cstr_data_path('library'),
    'movies_path' => cstr_data_path('library/movies'),
    'series_path' => cstr_data_path('library/tvSeries'),
    'tv_path' => cstr_data_path('library/liveTvs'),
    'discover_path' => cstr_data_path('jellyfin/metadata/views/'.md5("_discover")),
    'virtual_folders' => [
        'Movies' => [
            'name' => 'Movies',
            'path' => cstr_data_path('library/movies'),
            'type' => 'movies',
        ],
        'TV Series' => [
            'name' => 'TV Series',
            'path' => cstr_data_path('library/tvSeries'),
            'type' => 'tvshows',
        ],
        'Live TV' => [
            'name' => 'Live TV',
            'path' => cstr_data_path('library/liveTvs'),
            'type' => 'movies',
        ]
    ],
    'menu_links' => [
        [
            'name' => 'Castoro',
            'icon' => 'settings',
            'url' => '#/configurationpage?name=CSTR_CONF',
        ],
        [
            'name' => 'GitHub',
            'icon' => 'code',
            'url' => 'https://github.com/RioNoir/castoro',
        ],
        [
            'name' => 'Buy Me a Coffee',
            'icon' => 'coffee',
            'url' => 'https://buymeacoffee.com/rionoir',
        ]
    ],
    'delete_unused_items_after' => 1, //days
    'update_series_after' => 24, //hours
    'delete_streams_after' => 3, //hours
    'update_playback_limit' => 10,
    'supported_extensions' => [
        'mp4',
        'mkv',
        'webm',
        'ts',
        'm2t',
        'm3u',
        'm3u8'
    ]
];
