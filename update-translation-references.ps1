# Script to automatically update translation references in Blade templates
# Updates frontend and dashboard translation paths

Write-Host ""
Write-Host "=== Updating Translation References in Blade Templates ===" -ForegroundColor Cyan
Write-Host ""

$viewsPath = "resources/views"
$updatedFiles = 0
$totalReplacements = 0

# Backup views directory
Write-Host "Creating backup..." -ForegroundColor Yellow
$backupPath = "resources/views_backup_" + (Get-Date -Format "yyyyMMdd_HHmmss")
Copy-Item -Path $viewsPath -Destination $backupPath -Recurse -Force
Write-Host "Backup created: $backupPath" -ForegroundColor Green
Write-Host ""

# Frontend page updates
$frontendPages = @('about', 'home', 'hIT', 'therapists', 'contact')

Write-Host "Updating frontend page references..." -ForegroundColor Yellow

foreach ($page in $frontendPages) {
    Write-Host "  Processing: $page" -ForegroundColor Gray
    
    $files = Get-ChildItem -Path $viewsPath -Recurse -Filter "*.blade.php" | 
        Where-Object { (Get-Content $_.FullName -Raw) -match "__\('$page\." }
    
    foreach ($file in $files) {
        $content = Get-Content $file.FullName -Raw
        $originalContent = $content
        
        # Replace __('page. with __('frontend.page.
        $content = $content -replace "__\('$page\.", "__('frontend.$page."
        
        if ($content -ne $originalContent) {
            Set-Content -Path $file.FullName -Value $content -NoNewline
            $updatedFiles++
            $count = ([regex]::Matches($originalContent, "__\('$page\.")).Count
            $totalReplacements += $count
            
            $relativePath = $file.FullName -replace [regex]::Escape((Get-Location).Path + "\"), ""
            Write-Host "    Updated: $relativePath ($count replacements)" -ForegroundColor Green
        }
    }
}

Write-Host ""
Write-Host "Updating dashboard/therapy references..." -ForegroundColor Yellow

# Update therapy references - most common dashboard pattern found
$files = Get-ChildItem -Path $viewsPath -Recurse -Filter "*.blade.php" | 
    Where-Object { (Get-Content $_.FullName -Raw) -match "__\('site\.(therapy|music|playlist)" }

foreach ($file in $files) {
    $content = Get-Content $file.FullName -Raw
    $originalContent = $content
    
    # Replace __('site.therapy_ with __('dashboard.therapy_music.
    # Replace __('site.music_ with __('dashboard.therapy_music.
    # Replace __('site.playlist with __('dashboard.therapy_music.playlist
    $content = $content -replace "__\('site\.therapy_", "__('dashboard.therapy_music.therapy_"
    $content = $content -replace "__\('site\.music_", "__('dashboard.therapy_music.music_"
    $content = $content -replace "__\('site\.playlist", "__('dashboard.therapy_music.playlist"
    $content = $content -replace "__\('site\.album", "__('dashboard.therapy_music.album"
    $content = $content -replace "__\('site\.song", "__('dashboard.therapy_music.song"
    
    if ($content -ne $originalContent) {
        Set-Content -Path $file.FullName -Value $content -NoNewline
        $updatedFiles++
        
        $relativePath = $file.FullName -replace [regex]::Escape((Get-Location).Path + "\"), ""
        Write-Host "    Updated: $relativePath" -ForegroundColor Green
    }
}

Write-Host ""
Write-Host "=== Update Complete ===" -ForegroundColor Green
Write-Host ""
Write-Host "Files updated: $updatedFiles" -ForegroundColor Cyan
Write-Host "Total replacements: $totalReplacements" -ForegroundColor Cyan
Write-Host "Backup location: $backupPath" -ForegroundColor Gray
Write-Host ""
Write-Host "Next Steps:" -ForegroundColor Yellow
Write-Host "1. Clear Laravel caches: php artisan config:clear && php artisan cache:clear && php artisan view:clear" -ForegroundColor White
Write-Host "2. Test all pages to ensure translations display correctly" -ForegroundColor White
Write-Host "3. If issues occur, restore from backup: $backupPath" -ForegroundColor White
Write-Host ""
Write-Host "Script completed!" -ForegroundColor Green
Write-Host ""
