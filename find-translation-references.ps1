# Script to find translation keys that need to be updated in Blade templates
# After reorganizing language files

Write-Host ""
Write-Host "=== Finding Translation References to Update ===" -ForegroundColor Cyan
Write-Host ""

$viewsPath = "resources/views"

# Frontend pages that were moved
$frontendPages = @('about', 'home', 'hIT', 'therapists', 'contact')

# Dashboard management pages
$dashboardPages = @(
    'patient_management',
    'doctor_management', 
    'booking_appointment',
    'therapy_music',
    'feedback_management',
    'blog_management'
)

Write-Host "Searching for references that need updating..." -ForegroundColor Yellow
Write-Host ""

# Search for old frontend page references
Write-Host "1. Frontend Pages (moved to frontend/ folder):" -ForegroundColor Cyan
foreach ($page in $frontendPages) {
    Write-Host ""
    Write-Host "  Searching for __('$page." -ForegroundColor Gray
    
    $results = Get-ChildItem -Path $viewsPath -Recurse -Filter "*.blade.php" | 
        Select-String -Pattern "__\('$page\." -CaseSensitive
    
    if ($results) {
        $fileCount = ($results | Group-Object Path).Count
        $matchCount = $results.Count
        Write-Host "    Found $matchCount references in $fileCount files" -ForegroundColor Yellow
        
        $results | ForEach-Object {
            $relativePath = $_.Path -replace [regex]::Escape((Get-Location).Path + "\"), ""
            Write-Host "      $relativePath : Line $($_.LineNumber)" -ForegroundColor DarkGray
        }
    } else {
        Write-Host "    No references found" -ForegroundColor Green
    }
}

# Search for dashboard/site.php references that should use new dashboard files
Write-Host ""
Write-Host "2. Dashboard Management (should use dashboard.* namespace):" -ForegroundColor Cyan

$dashboardPatterns = @(
    @{Pattern = "__\('site\.patient"; NewPath = "dashboard.patient_management"; Description = "Patient management"},
    @{Pattern = "__\('site\.doctor"; NewPath = "dashboard.doctor_management"; Description = "Doctor management"},
    @{Pattern = "__\('site\.(booking|appointment|schedule)"; NewPath = "dashboard.booking_appointment"; Description = "Booking/Appointments"},
    @{Pattern = "__\('site\.(therapy|music|playlist|album|song)"; NewPath = "dashboard.therapy_music"; Description = "Therapy/Music"},
    @{Pattern = "__\('site\.feedback"; NewPath = "dashboard.feedback_management"; Description = "Feedback"},
    @{Pattern = "__\('site\.blog"; NewPath = "dashboard.blog_management"; Description = "Blog"}
)

foreach ($item in $dashboardPatterns) {
    Write-Host ""
    Write-Host "  $($item.Description)" -ForegroundColor Gray
    Write-Host "    Pattern: $($item.Pattern)" -ForegroundColor DarkGray
    Write-Host "    Should use: $($item.NewPath)" -ForegroundColor DarkGray
    
    $results = Get-ChildItem -Path $viewsPath -Recurse -Filter "*.blade.php" | 
        Select-String -Pattern $item.Pattern -CaseSensitive
    
    if ($results) {
        $fileCount = ($results | Group-Object Path).Count
        $matchCount = $results.Count
        Write-Host "    Found $matchCount references in $fileCount files" -ForegroundColor Yellow
        
        # Show unique files only
        $uniqueFiles = $results | Group-Object Path | Select-Object -ExpandProperty Name
        $uniqueFiles | ForEach-Object {
            $relativePath = $_ -replace [regex]::Escape((Get-Location).Path + "\"), ""
            Write-Host "      $relativePath" -ForegroundColor DarkYellow
        }
    } else {
        Write-Host "    No references found" -ForegroundColor Green
    }
}

Write-Host ""
Write-Host "=== Summary ===" -ForegroundColor Cyan
Write-Host ""
Write-Host "Translation Reference Updates Needed:" -ForegroundColor White
Write-Host ""
Write-Host "Frontend Pages (OLD -> NEW):" -ForegroundColor Yellow
Write-Host "  __('about.key')        -> __('frontend.about.key')" -ForegroundColor Gray
Write-Host "  __('home.key')         -> __('frontend.home.key')" -ForegroundColor Gray
Write-Host "  __('hIT.key')          -> __('frontend.hIT.key')" -ForegroundColor Gray
Write-Host "  __('therapists.key')   -> __('frontend.therapists.key')" -ForegroundColor Gray
Write-Host "  __('contact.key')      -> __('frontend.contact.key')" -ForegroundColor Gray
Write-Host ""
Write-Host "Dashboard Pages (OLD -> NEW):" -ForegroundColor Yellow
Write-Host "  __('site.patient_*)    -> __('dashboard.patient_management.*')" -ForegroundColor Gray
Write-Host "  __('site.doctor_*)     -> __('dashboard.doctor_management.*')" -ForegroundColor Gray
Write-Host "  __('site.booking_*)    -> __('dashboard.booking_appointment.*')" -ForegroundColor Gray
Write-Host "  __('site.therapy_*)    -> __('dashboard.therapy_music.*')" -ForegroundColor Gray
Write-Host "  __('site.feedback_*)   -> __('dashboard.feedback_management.*')" -ForegroundColor Gray
Write-Host "  __('site.blog_*)       -> __('dashboard.blog_management.*')" -ForegroundColor Gray

Write-Host ""
Write-Host "Script completed!" -ForegroundColor Green
Write-Host ""
