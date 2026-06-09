<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Sembunyikan booking yang belum dibayar melewati batas waktu (default 45 menit).
Schedule::command('bookings:expire')->everyFiveMinutes();
