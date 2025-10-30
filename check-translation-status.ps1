# Script to show translation completion status

Write-Host ""
Write-Host "=== Translation Status Report ===" -ForegroundColor Cyan
Write-Host ""

$enFiles = Get-ChildItem -Path "lang/en" -Recurse -File -Filter "*.php" | 
    ForEach-Object { $_.FullName -replace [regex]::Escape((Get-Location).Path + "\lang\en\"), "" }

$arFiles = Get-ChildItem -Path "lang/ar" -Recurse -File -Filter "*.php" | 
    ForEach-Object { $_.FullName -replace [regex]::Escape((Get-Location).Path + "\lang\ar\"), "" }

$frFiles = Get-ChildItem -Path "lang/fr" -Recurse -File -Filter "*.php" | 
    ForEach-Object { $_.FullName -replace [regex]::Escape((Get-Location).Path + "\lang\fr\"), "" }

Write-Host "English Files: $($enFiles.Count)" -ForegroundColor Green
Write-Host "Arabic Files: $($arFiles.Count)" -ForegroundColor Yellow
Write-Host "French Files: $($frFiles.Count)" -ForegroundColor Yellow

Write-Host ""
Write-Host "Missing in Arabic:" -ForegroundColor Red
foreach ($file in $enFiles) {
    if ($arFiles -notcontains $file) {
        Write-Host "  - $file" -ForegroundColor DarkRed
    }
}

Write-Host ""
Write-Host "Missing in French:" -ForegroundColor Red
foreach ($file in $enFiles) {
    if ($frFiles -notcontains $file) {
        Write-Host "  - $file" -ForegroundColor DarkRed
    }
}

Write-Host ""
Write-Host "Script completed!" -ForegroundColor Green
Write-Host ""
