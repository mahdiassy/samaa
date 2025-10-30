# Script to identify unused language files in lang/en directory

Write-Host ""
Write-Host "=== Scanning for Unused Language Files ===" -ForegroundColor Cyan
Write-Host ""

$langPath = "lang/en"

# Files to check (excluding directories and site.php which is known to be used)
$filesToCheck = @(
    @{File = "auth.php"; Type = "Laravel Default"; UsedBy = "Laravel Auth System"},
    @{File = "passwords.php"; Type = "Laravel Default"; UsedBy = "Laravel Password Reset"},
    @{File = "pagination.php"; Type = "Laravel Default"; UsedBy = "Laravel Paginator"},
    @{File = "validation.php"; Type = "Laravel Default"; UsedBy = "Laravel Validator"}
)

Write-Host "Checking usage in codebase..." -ForegroundColor Yellow
Write-Host ""

$unusedFiles = @()
$usedFiles = @()

foreach ($item in $filesToCheck) {
    $file = $item.File
    $fileName = $file -replace '\.php$', ''
    
    Write-Host "Checking: $file" -ForegroundColor Gray
    
    # Search in views
    $viewMatches = Get-ChildItem -Path "resources/views" -Recurse -Filter "*.blade.php" -ErrorAction SilentlyContinue | 
        Select-String -Pattern "__\('$fileName\.|trans\('$fileName\." -CaseSensitive
    
    # Search in controllers
    $controllerMatches = Get-ChildItem -Path "app" -Recurse -Filter "*.php" -ErrorAction SilentlyContinue | 
        Select-String -Pattern "__\('$fileName\.|trans\('$fileName\.|Lang::get\('$fileName\." -CaseSensitive
    
    # Search for routes/api files
    $routeMatches = Get-ChildItem -Path "routes" -Recurse -Filter "*.php" -ErrorAction SilentlyContinue | 
        Select-String -Pattern "__\('$fileName\.|trans\('$fileName\." -CaseSensitive
    
    $totalMatches = 0
    if ($viewMatches) { $totalMatches += $viewMatches.Count }
    if ($controllerMatches) { $totalMatches += $controllerMatches.Count }
    if ($routeMatches) { $totalMatches += $routeMatches.Count }
    
    if ($totalMatches -eq 0) {
        Write-Host "  Status: NOT USED (0 references found)" -ForegroundColor Red
        $unusedFiles += $item
    } else {
        Write-Host "  Status: IN USE ($totalMatches references found)" -ForegroundColor Green
        $usedFiles += $item
    }
    
    Write-Host ""
}

Write-Host ""
Write-Host "=== ANALYSIS SUMMARY ===" -ForegroundColor Cyan
Write-Host ""

if ($unusedFiles.Count -gt 0) {
    Write-Host "UNUSED FILES (Safe to remove):" -ForegroundColor Yellow
    Write-Host ""
    foreach ($item in $unusedFiles) {
        Write-Host "  - $($item.File)" -ForegroundColor Red
        Write-Host "    Type: $($item.Type)" -ForegroundColor Gray
        Write-Host "    Original Purpose: $($item.UsedBy)" -ForegroundColor Gray
        Write-Host ""
    }
    
    Write-Host "These files are Laravel defaults but are not being used in your project." -ForegroundColor Gray
    Write-Host "They can be safely removed." -ForegroundColor Gray
} else {
    Write-Host "All checked files are in use!" -ForegroundColor Green
}

if ($usedFiles.Count -gt 0) {
    Write-Host ""
    Write-Host "USED FILES (Keep these):" -ForegroundColor Green
    Write-Host ""
    foreach ($item in $usedFiles) {
        Write-Host "  - $($item.File)" -ForegroundColor Green
    }
}

Write-Host ""
Write-Host "NOTE: The following are known to be in use and weren't checked:" -ForegroundColor Cyan
Write-Host "  - site.php (main translations)" -ForegroundColor White
Write-Host "  - frontend/ directory (frontend pages)" -ForegroundColor White
Write-Host "  - dashboard/ directory (dashboard management)" -ForegroundColor White
Write-Host "  - components/ directory (reusable components)" -ForegroundColor White

Write-Host ""
Write-Host "Script completed!" -ForegroundColor Green
Write-Host ""
