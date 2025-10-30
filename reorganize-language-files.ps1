# Script to reorganize language files
# Moves frontend pages to frontend/ folder
# Creates dashboard management files in dashboard/ folder

Write-Host ""
Write-Host "=== Reorganizing Language Files ===" -ForegroundColor Cyan
Write-Host ""

$languages = @('en', 'ar', 'fr')

foreach ($lang in $languages) {
    Write-Host ""
    Write-Host "Processing language: $lang" -ForegroundColor Yellow
    Write-Host ""
    
    $basePath = "lang/$lang"
    
    # 1. Move frontend pages to frontend/ folder
    Write-Host "1. Moving frontend pages to frontend/ folder..." -ForegroundColor Gray
    Write-Host ""
    
    $frontendFiles = @('about.php', 'home.php', 'hIT.php', 'therapists.php')
    
    foreach ($file in $frontendFiles) {
        $sourcePath = "$basePath/$file"
        $destPath = "$basePath/frontend/$file"
        
        if (Test-Path $sourcePath) {
            Move-Item $sourcePath $destPath -Force
            Write-Host "  Moved: $file -> frontend/$file" -ForegroundColor Green
        } else {
            Write-Host "  Not found: $file" -ForegroundColor Red
        }
    }
    
    # Note: contact.php is already in frontend/ folder
    if (Test-Path "$basePath/contact.php") {
        Move-Item "$basePath/contact.php" "$basePath/frontend/contact.php" -Force
        Write-Host "  Moved: contact.php -> frontend/contact.php" -ForegroundColor Green
    }
    
    # 2. Create dashboard management files
    Write-Host ""
    Write-Host "2. Creating dashboard management file structure..." -ForegroundColor Gray
    
    # Ensure dashboard directory exists
    if (-not (Test-Path "$basePath/dashboard")) {
        New-Item -Path "$basePath/dashboard" -ItemType Directory | Out-Null
    }
    
    Write-Host "  Dashboard directory ready" -ForegroundColor Green
}

Write-Host ""
Write-Host "=== Files Reorganized Successfully! ===" -ForegroundColor Green
Write-Host ""

Write-Host "New structure:" -ForegroundColor Cyan
Write-Host "lang/locale/" -ForegroundColor White
Write-Host "  frontend/" -ForegroundColor Yellow
Write-Host "    - about.php (moved)" -ForegroundColor Gray
Write-Host "    - home.php (moved)" -ForegroundColor Gray
Write-Host "    - hIT.php (moved)" -ForegroundColor Gray
Write-Host "    - therapists.php (moved)" -ForegroundColor Gray
Write-Host "    - contact.php (moved)" -ForegroundColor Gray
Write-Host "    - auth.php (existing)" -ForegroundColor Gray
Write-Host "    - medical.php (existing)" -ForegroundColor Gray
Write-Host "  dashboard/" -ForegroundColor Yellow
Write-Host "    - general.php (existing)" -ForegroundColor Gray
Write-Host "    - patient_management.php (to be created)" -ForegroundColor DarkGray
Write-Host "    - doctor_management.php (to be created)" -ForegroundColor DarkGray
Write-Host "    - booking_appointment.php (to be created)" -ForegroundColor DarkGray
Write-Host "    - therapy_music.php (to be created)" -ForegroundColor DarkGray
Write-Host "    - feedback_management.php (to be created)" -ForegroundColor DarkGray
Write-Host "    - blog_management.php (to be created)" -ForegroundColor DarkGray

Write-Host ""
Write-Host "Next Steps:" -ForegroundColor Cyan
Write-Host "1. Update Blade templates to use new paths:" -ForegroundColor White
Write-Host "   __('about.key') -> __('frontend.about.key')" -ForegroundColor Gray
Write-Host "   __('home.key') -> __('frontend.home.key')" -ForegroundColor Gray
Write-Host "2. Create dashboard management files by extracting keys from site.php" -ForegroundColor White
Write-Host "3. Test the application to ensure all translations work" -ForegroundColor White

Write-Host ""
Write-Host "Script completed!" -ForegroundColor Green
Write-Host ""
