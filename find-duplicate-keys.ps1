# Script to find duplicate translation keys between site.php and other language files
# This helps identify which keys can be removed from site.php

Write-Host "`n=== Finding Duplicate Translation Keys ===" -ForegroundColor Cyan
Write-Host "Checking lang/en/site.php against other language files...`n" -ForegroundColor Yellow

$langPath = "lang/en"
$siteFile = "$langPath/site.php"

# Function to extract keys from a PHP language file
function Get-TranslationKeys {
    param([string]$filePath)
    
    if (-not (Test-Path $filePath)) {
        return @()
    }
    
    $content = Get-Content $filePath -Raw
    $keys = @()
    
    # Match pattern: 'key' => 'value',
    $matches = [regex]::Matches($content, "'([^'\\]*(?:\\.[^'\\]*)*)'\s*=>")
    
    foreach ($match in $matches) {
        $key = $match.Groups[1].Value
        $keys += $key
    }
    
    return $keys
}

# Get all keys from site.php
Write-Host "Loading keys from site.php..." -ForegroundColor Gray
$siteKeys = Get-TranslationKeys $siteFile
Write-Host "Found $($siteKeys.Count) keys in site.php`n" -ForegroundColor Green

# Get all other language files
$otherFiles = @(
    "$langPath/about.php",
    "$langPath/auth.php",
    "$langPath/contact.php",
    "$langPath/home.php",
    "$langPath/therapists.php",
    "$langPath/hIT.php",
    "$langPath/components/common.php",
    "$langPath/components/footer.php",
    "$langPath/components/header.php",
    "$langPath/components/home.php",
    "$langPath/dashboard/general.php",
    "$langPath/frontend/auth.php",
    "$langPath/frontend/contact.php",
    "$langPath/frontend/medical.php"
)

# Track duplicates by file
$duplicatesByFile = @{}
$allDuplicates = @()

foreach ($file in $otherFiles) {
    if (Test-Path $file) {
        $relPath = $file -replace [regex]::Escape("$langPath/"), ""
        Write-Host "Checking $relPath..." -ForegroundColor Gray
        
        $fileKeys = Get-TranslationKeys $file
        $duplicates = $siteKeys | Where-Object { $fileKeys -contains $_ }
        
        if ($duplicates.Count -gt 0) {
            $duplicatesByFile[$relPath] = $duplicates
            $allDuplicates += $duplicates
            Write-Host "  Found $($duplicates.Count) duplicate keys" -ForegroundColor Yellow
        } else {
            Write-Host "  No duplicates found" -ForegroundColor Green
        }
    }
}

# Remove duplicate entries from allDuplicates array
$uniqueDuplicates = $allDuplicates | Select-Object -Unique

Write-Host "`n=== SUMMARY ===" -ForegroundColor Cyan
Write-Host "Total unique duplicate keys found: $($uniqueDuplicates.Count)" -ForegroundColor Yellow
Write-Host "Keys that can potentially be removed from site.php`n" -ForegroundColor Yellow

# Show detailed breakdown
Write-Host "`n=== DUPLICATE KEYS BY FILE ===" -ForegroundColor Cyan
foreach ($file in $duplicatesByFile.Keys | Sort-Object) {
    $dupes = $duplicatesByFile[$file]
    Write-Host "`n$file ($($dupes.Count) duplicates):" -ForegroundColor Magenta
    $dupes | Sort-Object | ForEach-Object {
        Write-Host "  - $_" -ForegroundColor Gray
    }
}

# Calculate what's left
$remainingKeys = $siteKeys | Where-Object { $uniqueDuplicates -notcontains $_ }
Write-Host "`n=== REMAINING KEYS IN SITE.PHP ===" -ForegroundColor Cyan
Write-Host "After removing duplicates, $($remainingKeys.Count) keys would remain in site.php`n" -ForegroundColor Green

# Export results to CSV for easier review
$csvData = @()
foreach ($file in $duplicatesByFile.Keys) {
    foreach ($key in $duplicatesByFile[$file]) {
        $csvData += [PSCustomObject]@{
            File = $file
            Key = $key
            Action = "Can be removed from site.php"
        }
    }
}

if ($csvData.Count -gt 0) {
    $csvPath = "duplicate-keys-report.csv"
    $csvData | Export-Csv $csvPath -NoTypeInformation
    Write-Host "Detailed report exported to: $csvPath" -ForegroundColor Green
}

# Create a list of remaining keys
$remainingCsv = $remainingKeys | ForEach-Object {
    [PSCustomObject]@{
        Key = $_
        Status = "Needs categorization"
    }
}

if ($remainingCsv.Count -gt 0) {
    $remainingPath = "remaining-keys-in-site.csv"
    $remainingCsv | Export-Csv $remainingPath -NoTypeInformation
    Write-Host "Remaining keys exported to: $remainingPath" -ForegroundColor Green
}

Write-Host "`n=== NEXT STEPS ===" -ForegroundColor Cyan
Write-Host "1. Review duplicate-keys-report.csv to see which keys are duplicated" -ForegroundColor White
Write-Host "2. Review remaining-keys-in-site.csv to categorize remaining keys" -ForegroundColor White
Write-Host "3. Consider creating new organized files for remaining keys" -ForegroundColor White
Write-Host "4. Remove duplicate keys from site.php once verified" -ForegroundColor White

Write-Host "`nScript completed!`n" -ForegroundColor Green
