<?php

use Barryvdh\DomPDF\Facade\Pdf;

return [
    'show_warnings' => false,
    'public_path' => null,
    'chroot' => realpath(base_path()),
    'default_paper_size' => 'a4',
    'default_font' => 'sans-serif',
    'dpi' => 96,
    'enable_php' => false,
    'enable_javascript' => true,
    'enable_remote' => true,
    'font_dir' => storage_path('fonts/'),
    'font_cache' => storage_path('fonts/'),
    'temp_dir' => storage_path('app/dompdf/'),
    'log_output_file' => storage_path('logs/dompdf.log'),
];