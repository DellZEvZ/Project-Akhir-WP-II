@echo off
echo ===================================
echo  Barber Flow - Dev Server Launcher
echo ===================================
echo.

echo [1/2] Setting up ADB reverse tunnel...
adb reverse tcp:8000 tcp:8000
if %errorlevel% neq 0 (
    echo WARNING: ADB reverse gagal. Pastikan HP terhubung via USB dan USB Debugging aktif.
) else (
    echo OK: adb reverse tcp:8000 tcp:8000 aktif.
)
echo.

echo [2/2] Menjalankan Laravel server...
echo Server akan berjalan di http://127.0.0.1:8000
echo Tekan Ctrl+C untuk stop.
echo.
cd /d "C:\laragon\www\Project Akhir WP II"
php artisan serve
