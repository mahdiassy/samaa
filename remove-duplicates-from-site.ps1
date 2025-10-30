# Script to remove duplicate keys from site.php
# This removes keys that exist in other language files

Write-Host "`n=== Removing Duplicate Keys from site.php ===" -ForegroundColor Cyan

$siteFile = "lang/en/site.php"
$backupFile = "lang/en/site.php.backup"

# Create backup
Write-Host "Creating backup: $backupFile" -ForegroundColor Yellow
Copy-Item $siteFile $backupFile -Force

# List of duplicate keys to remove (from our analysis)
$duplicateKeys = @(
    # from about.php
    'therapy',
    
    # from auth.php
    'Password',
    
    # from components/common.php
    'Done',
    'No',
    'Submit',
    'Update',
    'update',
    'Yes',
    
    # from components/footer.php
    'About',
    'Address',
    'Contact',
    'Dashboard',
    'Description',
    'Home',
    'Name',
    'Phone',
    'SUBSCRIBE',
    'Therapists',
    'Title',
    
    # from components/header.php
    'Default',
    'Kids',
    'Language',
    'Library',
    'Login',
    'Logout',
    'Menu',
    'Register',
    'Therapeutic_area',
    
    # from components/home.php
    # Description, therapy, Title already listed
    
    # from dashboard/general.php
    'Feedback',
    'Filter',
    'Schedule',
    # Update, update already listed
    
    # from frontend/auth.php
    'Birthday',
    'Country',
    'Email',
    'Female',
    'Gender',
    'Male',
    'Next',
    'next',
    'Previous',
    'Surname',
    
    # from frontend/contact.php
    # Contact already listed
    'general_inquiry',
    'institutional_partnership',
    'Message',
    'Subject',
    # Submit already listed
    'technical_support',
    'therapist_registration',
    
    # from frontend/medical.php
    'Diseases',
    'more_description',
    # No already listed
    'open_description',
    'Psychological_diseases',
    # Yes already listed
    
    # from hIT.php
    'Clinical',
    'Global Recognition',
    'Month Trial Results',
    'Partners',
    'Proof',
    'Proven Impact on Autism & Beyond',
    
    # from home.php
    # Email already listed
    'First Name',
    # general_inquiry, institutional_partnership, Message already listed
    'music therapy',
    # Submit, Surname already listed
    # technical_support, therapist_registration, therapy already listed
    'Welcome to SAMAA'
    
    # therapists.php - Therapists already listed
)

# Remove duplicates from array
$uniqueKeys = $duplicateKeys | Select-Object -Unique
Write-Host "Found $($uniqueKeys.Count) unique duplicate keys to remove" -ForegroundColor Yellow

# Read the file content
$content = Get-Content $siteFile -Raw

# Count removals
$removedCount = 0
$notFoundCount = 0

Write-Host "`nRemoving duplicate keys..." -ForegroundColor Gray

foreach ($key in $uniqueKeys) {
    # Escape special regex characters in the key
    $escapedKey = [regex]::Escape($key)
    
    # Pattern to match the entire line with this key (including the => and value)
    # Handles both single-line and potential multi-line values
    $pattern = "^\s*'$escapedKey'\s*=>\s*'[^'\\]*(?:\\.[^'\\]*)*',?\s*$"
    
    if ($content -match $pattern) {
        # Remove the line
        $content = $content -replace "(?m)$pattern\r?\n?", ""
        $removedCount++
        Write-Host "  ✓ Removed: $key" -ForegroundColor Green
    } else {
        $notFoundCount++
        Write-Host "  ✗ Not found: $key" -ForegroundColor Red
    }
}

# Clean up any double empty lines that might have been created
$content = $content -replace "(\r?\n){3,}", "`r`n`r`n"

# Save the cleaned content
Set-Content $siteFile $content -NoNewline

Write-Host "`n=== SUMMARY ===" -ForegroundColor Cyan
Write-Host "Keys removed: $removedCount" -ForegroundColor Green
Write-Host "Keys not found: $notFoundCount" -ForegroundColor Yellow
Write-Host "Backup saved to: $backupFile" -ForegroundColor Gray

Write-Host "`n=== NEXT STEPS ===" -ForegroundColor Cyan
Write-Host "1. Review the cleaned site.php file" -ForegroundColor White
Write-Host "2. Test your application to ensure translations still work" -ForegroundColor White
Write-Host "3. If issues occur, restore from backup: $backupFile" -ForegroundColor White
Write-Host "4. Apply same cleanup to Arabic and French language files" -ForegroundColor White
Write-Host "5. Organize remaining 229 keys into new page-specific files" -ForegroundColor White

Write-Host "`nScript completed!`n" -ForegroundColor Green
