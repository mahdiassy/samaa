# Language File Organization Plan for SAMAA

## Current Situation

The `site.php` language file has become too large with **290 keys** in English (and 454 in AR/FR). Many keys are duplicated across other specialized language files, making maintenance difficult.

## Analysis Results

### Duplicate Keys Found: **60 unique keys**

These keys exist in both `site.php` and other language files:

#### By Category:

-   **Components** (31 keys): Defined in `components/header.php`, `components/footer.php`, `components/common.php`

    -   Navigation: Home, Dashboard, Menu, Login, Logout, Register, Therapists, Library, Language, Default, Kids
    -   Common actions: Submit, Update, Done, Yes, No
    -   Footer elements: About, Address, Contact, Phone, Name, Title, Description, SUBSCRIBE

-   **Frontend Pages** (25 keys): Defined in `frontend/auth.php`, `frontend/contact.php`, `frontend/medical.php`

    -   Auth fields: Email, Birthday, Country, Gender, Male, Female, Surname, First Name, Next, Previous
    -   Contact: general_inquiry, institutional_partnership, technical_support, therapist_registration, Message, Subject
    -   Medical: Diseases, Psychological_diseases, open_description, more_description

-   **Dashboard** (5 keys): Defined in `dashboard/general.php`

    -   Feedback, Filter, Schedule, Update, update

-   **Other Pages** (4 keys): Defined in `home.php`, `about.php`, `therapists.php`, `hIT.php`
    -   Welcome to SAMAA, therapy, music therapy, Clinical, Global Recognition, Proof, etc.

### Remaining Keys After Cleanup: **229 keys**

These keys need to be reorganized into logical page-specific files:

#### Proposed New Structure:

```
lang/en/pages/
├── auth_login_register.php (11 keys)
│   ├── Login/registration flows
│   ├── Success/error messages
│   └── Account prompts
│
├── user_profile.php (10 keys)
│   ├── Personal information fields
│   ├── Profile settings
│   └── User details
│
├── password_management.php (10 keys)
│   ├── Change password flow
│   ├── Password validation
│   └── Reset password
│
├── medical_forms.php (17 keys)
│   ├── Health questionnaires
│   ├── Medical history
│   ├── Medication tracking
│   └── Symptom reporting
│
├── dashboard_general.php (22 keys)
│   ├── CRUD operations (Create, Edit, Delete, View)
│   ├── Common dashboard actions
│   ├── Status messages (Success, Error, OK)
│   └── Date/time fields
│
├── patient_management.php (9 keys)
│   ├── Patient CRUD operations
│   ├── Patient list/profile
│   └── Success messages
│
├── doctor_management.php (15 keys)
│   ├── Doctor CRUD operations
│   ├── Doctor profile/specialization
│   ├── Search functionality
│   └── Success messages
│
├── booking_appointment.php (29 keys)
│   ├── Appointment scheduling
│   ├── Booking status (Pending, Approved, Canceled)
│   ├── Calendar views (Week, Month, Day)
│   ├── Time selection
│   └── Booking notifications
│
├── availability_schedule.php (14 keys)
│   ├── Time periods (AM/PM, week, month, day)
│   ├── Date navigation (today, prev, 1_day_ago)
│   └── Availability status
│
├── therapy_music.php (23 keys)
│   ├── Music player controls (Play, Pause, Change_track)
│   ├── Playlist management
│   ├── Session features (Chat, Call)
│   ├── Therapy CRUD
│   └── Albums and songs
│
├── feedback_management.php (9 keys)
│   ├── Feedback CRUD operations
│   ├── User information
│   └── Success messages
│
├── blog_management.php (9 keys)
│   ├── Blog CRUD operations
│   ├── Blog list/posts
│   └── Publication dates
│
├── contact_page.php (15 keys)
│   ├── Contact form fields
│   ├── Social media links
│   ├── Newsletter signup
│   └── Contact messaging
│
├── homepage_content.php (15 keys)
│   ├── Hero sections
│   ├── Statistics (80% better sleep, 65% reduced anxiety, etc.)
│   ├── Community info
│   └── Theme settings
│
├── navigation.php (6 keys)
│   ├── Main menu items
│   ├── Help Center
│   └── How It Works
│
├── file_upload.php (6 keys)
│   ├── Upload functionality
│   ├── File validation messages
│   └── Edit media
│
├── validation_messages.php (4 keys)
│   ├── Email validation
│   ├── Account conflict messages
│   └── Error notifications
│
└── misc_content.php (5 keys)
    ├── Copyright notice
    ├── Terms & Conditions
    └── Placeholder content
```

## Implementation Steps

### Phase 1: Remove Duplicates (Quick Win)

1. **Run the duplicate removal script**:

    ```powershell
    powershell -ExecutionPolicy Bypass -File remove-duplicates-from-site.ps1
    ```

    - This creates a backup: `site.php.backup`
    - Removes 60 duplicate keys
    - Reduces site.php from 290 to 229 keys

2. **Test the application**:

    - Ensure all pages still display translations correctly
    - Check that references use correct translation files

3. **Apply to all languages**:
    - Run same cleanup for `lang/ar/site.php`
    - Run same cleanup for `lang/fr/site.php`

### Phase 2: Create New Organized Structure

1. **Create the pages directory**:

    ```powershell
    New-Item -Path "lang/en/pages" -ItemType Directory
    New-Item -Path "lang/ar/pages" -ItemType Directory
    New-Item -Path "lang/fr/pages" -ItemType Directory
    ```

2. **Create individual page files**:

    - Start with high-priority pages (dashboard, patient, doctor, booking)
    - Move relevant keys from `site.php` to new files
    - Maintain same structure across EN, AR, FR

3. **Example file structure** (`lang/en/pages/patient_management.php`):

    ```php
    <?php

    return [
        'patient_list' => 'Patient list',
        'add_new_patient' => 'Add New Patient',
        'patient_name' => 'Patient Name',
        'patient' => 'Patient',

        // Success messages
        'patient_created_successfully' => 'Patient created successfully',
        'patient_updated_successfully' => 'Patient updated successfully',
        'patient_profile_updated_successfully' => 'Patient Profile updated successfully',
        'patient_deleted_successfully' => 'Patient deleted successfully',
        'patient_canceled_successfully' => 'Patient Canceled successfully',
    ];
    ```

### Phase 3: Update Blade Templates

1. **Find and replace translation calls**:

    ```php
    # Old way:
    __('site.patient_list')

    # New way:
    __('pages.patient_management.patient_list')
    ```

2. **Update systematically**:

    - Use VS Code find/replace with regex
    - Update one category at a time
    - Test after each category

3. **Example patterns to find**:
    ```regex
    __\('site\.(patient_list|add_new_patient|patient_name)'\)
    ```
    Replace with:
    ```php
    __('pages.patient_management.$1')
    ```

### Phase 4: Final Cleanup

1. **Review remaining `site.php`**:

    - Should only contain truly global keys
    - Consider renaming to `global.php` or `common.php`

2. **Documentation**:

    - Update translation guidelines
    - Document new file structure
    - Create examples for developers

3. **Clear caches**:
    ```bash
    php artisan config:clear
    php artisan cache:clear
    php artisan view:clear
    ```

## Benefits of This Organization

### 1. **Better Maintainability**

-   Each file focused on specific feature/page
-   Easy to find translations
-   No more scrolling through 290+ keys

### 2. **Reduced Duplication**

-   Clear separation between global and page-specific
-   Easier to identify redundant translations
-   Consistent naming across languages

### 3. **Improved Developer Experience**

-   Logical grouping makes it obvious where to add new keys
-   Clear naming convention: `pages.{category}.{key}`
-   Better IDE autocomplete support

### 4. **Easier Translation Management**

-   Translators can work on specific pages
-   Reduced file size = less overwhelming
-   Version control diffs are more meaningful

### 5. **Performance Benefits**

-   Laravel only loads needed translation files
-   Smaller files = faster parsing
-   Better caching efficiency

## Quick Reference Commands

```powershell
# 1. Find duplicates
powershell -ExecutionPolicy Bypass -File find-duplicate-keys.ps1

# 2. Analyze remaining keys
powershell -ExecutionPolicy Bypass -File organize-site-keys.ps1

# 3. Remove duplicates from site.php
powershell -ExecutionPolicy Bypass -File remove-duplicates-from-site.ps1

# 4. Restore from backup if needed
Copy-Item lang/en/site.php.backup lang/en/site.php -Force

# 5. Clear Laravel caches
php artisan config:clear && php artisan cache:clear && php artisan view:clear
```

## Files Created by Analysis

1. **find-duplicate-keys.ps1** - Identifies duplicate translations
2. **organize-site-keys.ps1** - Categorizes remaining keys
3. **remove-duplicates-from-site.ps1** - Removes duplicates from site.php
4. **duplicate-keys-report.csv** - Detailed duplicate key report
5. **remaining-keys-in-site.csv** - List of keys to organize
6. **LANGUAGE_ORGANIZATION_PLAN.md** - This document

## Timeline Estimate

-   **Phase 1** (Remove Duplicates): 30 minutes
-   **Phase 2** (Create New Files): 2-3 hours
-   **Phase 3** (Update Templates): 3-4 hours
-   **Phase 4** (Testing & Cleanup): 1-2 hours

**Total**: 6-10 hours for complete organization

## Risk Mitigation

1. **Always backup before changes**

    - Scripts create automatic backups
    - Keep site.php.backup until testing complete

2. **Test incrementally**

    - Don't change everything at once
    - Test each category after moving keys

3. **Use version control**

    - Commit after each phase
    - Easy rollback if issues arise

4. **Update documentation**
    - Keep LANGUAGE_MANAGEMENT.md current
    - Document new structure for team

---

**Last Updated**: October 30, 2025  
**Status**: Ready for Implementation  
**Priority**: High (Improves maintainability significantly)
