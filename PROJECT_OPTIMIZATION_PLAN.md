# SAMAA Project - Cleanup & Optimization Plan

**Date Created:** October 31, 2025  
**Status:** Planning Phase  
**Branch:** `refactor/cleanup-phase-1`

---

## Table of Contents

1. [Code Organization & Structure](#1-code-organization--structure)
2. [Routing & Middleware Optimization](#2-routing--middleware-optimization)
3. [Styling Consistency](#3-styling-consistency)
4. [Laravel Best Practices](#4-laravel-best-practices)
5. [Security Improvements](#5-security-improvements)
6. [Performance Optimization](#6-performance-optimization)
7. [Code Quality & Testing](#7-code-quality--testing)
8. [Documentation](#8-documentation)
9. [Deployment & CI/CD](#9-deployment--cicd)
10. [Priority Roadmap](#10-priority-roadmap)

---

## 1. Code Organization & Structure

### 1.1 Request Validation

**Issue:** Controllers have no validation logic; all requests are accepted without validation.

**Priority:** 🔴 CRITICAL

**Tasks:**

-   [ ] Create Form Request classes in `app/Http/Requests/`

    -   [ ] `Auth/LoginRequest`
    -   [ ] `Auth/RegisterPatientRequest`
    -   [ ] `Auth/RegisterDoctorRequest`
    -   [ ] `Patient/StorePatientRequest`
    -   [ ] `Patient/UpdatePatientRequest`
    -   [ ] `Doctor/StoreDoctorRequest`
    -   [ ] `Doctor/UpdateDoctorRequest`
    -   [ ] `Therapy/StoreTherapyRequest`
    -   [ ] `Therapy/UpdateTherapyRequest`
    -   [ ] `Blog/StoreBlogRequest`
    -   [ ] `Blog/UpdateBlogRequest`
    -   [ ] `Booking/StoreBookingRequest`
    -   [ ] `Feedback/StoreFeedbackRequest`

-   [ ] Add validation rules for:

    -   [ ] Email uniqueness and format validation
    -   [ ] Required fields (first_name, last_name, email, password)
    -   [ ] File upload constraints (size, type, mime)
    -   [ ] Date formats (birthday, availability dates)
    -   [ ] Phone number formats (international)
    -   [ ] Password complexity (min 8 chars, uppercase, lowercase, number)
    -   [ ] Text length limits (descriptions, messages)

-   [ ] Implement custom validation rules:
    -   [ ] `app/Rules/ValidPhoneNumber`
    -   [ ] `app/Rules/ValidAudioFile`
    -   [ ] `app/Rules/ValidImageFile`
    -   [ ] `app/Rules/UniqueEmailExceptUser`

---

### 1.2 Service Layer Pattern

**Issue:** Controllers contain too much business logic (especially `AuthController`, `PatientController`).

**Priority:** 🟡 HIGH

**Tasks:**

-   [ ] Create `app/Services/` directory structure

    ```
    app/Services/
    ├── Auth/
    │   └── UserRegistrationService.php
    ├── File/
    │   └── FileUploadService.php
    ├── Patient/
    │   └── PatientDiseaseService.php
    ├── Booking/
    │   └── BookingService.php
    └── Therapy/
        └── TherapyAccessService.php
    ```

-   [ ] **Create `UserRegistrationService`:**

    -   [ ] `registerPatient(array $data): Patient`
    -   [ ] `registerDoctor(array $data): Doctor`
    -   [ ] Handle User creation
    -   [ ] Handle role assignment
    -   [ ] Handle profile image upload
    -   [ ] Send welcome email

-   [ ] **Create `FileUploadService`:**

    -   [ ] `uploadImage(UploadedFile $file, string $directory): string`
    -   [ ] `uploadAudio(UploadedFile $file, string $directory): string`
    -   [ ] `uploadEncryptedAudio(UploadedFile $file, string $directory): string`
    -   [ ] Centralize file validation
    -   [ ] Generate secure random filenames
    -   [ ] Store files outside public directory
    -   [ ] Create thumbnails for images

-   [ ] **Create `PatientDiseaseService`:**

    -   [ ] `syncDiseases(Patient $patient, array $data): void`
    -   [ ] `attachDisease(Patient $patient, $disease, string $type): void`
    -   [ ] `detachDiseases(Patient $patient): void`
    -   [ ] Handle all disease types (therapeutic areas, addictions, symptoms, etc.)

-   [ ] **Create `BookingService`:**

    -   [ ] `createBooking(Patient $patient, Availability $slot, array $data): Booking`
    -   [ ] `approveBooking(Booking $booking): void`
    -   [ ] `cancelBooking(Booking $booking, string $reason): void`
    -   [ ] `rescheduleBooking(Booking $booking, Availability $newSlot): Booking`
    -   [ ] Send notification emails

-   [ ] **Create `TherapyAccessService`:**

    -   [ ] `getTherapiesForUser(User $user): Collection`
    -   [ ] `canAccessTherapy(User $user, Therapy $therapy): bool`
    -   [ ] `assignTherapyToPatient(Therapy $therapy, Patient $patient): void`

-   [ ] **Refactor Controllers to use Services:**
    -   [ ] Update `AuthController`
    -   [ ] Update `PatientController`
    -   [ ] Update `DoctorController`
    -   [ ] Update `TherapyController`
    -   [ ] Update `BookingController`

---

### 1.3 Repository Pattern (Optional but Recommended)

**Issue:** Direct model calls in controllers and complex queries in models.

**Priority:** 🟢 MEDIUM

**Tasks:**

-   [ ] Create `app/Repositories/` directory
-   [ ] Create repository interfaces in `app/Repositories/Contracts/`

    -   [ ] `TherapyRepositoryInterface`
    -   [ ] `PatientRepositoryInterface`
    -   [ ] `DoctorRepositoryInterface`
    -   [ ] `BookingRepositoryInterface`
    -   [ ] `BlogRepositoryInterface`

-   [ ] Implement repositories:

    -   [ ] `TherapyRepository` - Move `getTherapiesBasedRole()` logic
    -   [ ] `PatientRepository` - Patient queries and filtering
    -   [ ] `DoctorRepository` - Doctor queries and search
    -   [ ] `BookingRepository` - Booking queries with status filters
    -   [ ] `BlogRepository` - Blog queries with localization

-   [ ] Register repositories in `AppServiceProvider`
-   [ ] Benefits: Easier testing, cleaner controllers, centralized query logic

---

### 1.4 Duplicate Code Elimination

**Priority:** 🟡 HIGH

#### 1.4.1 File Upload Logic

**Found:** `storeFile()` and `storeFileEncrypt()` called in 10+ places

**Tasks:**

-   [ ] Remove `storeFile()` and `storeFileEncrypt()` from `Controller.php`
-   [ ] Replace all calls with `FileUploadService` methods
-   [ ] Add consistent error handling
-   [ ] Add file type validation at service level
-   [ ] Add virus scanning (optional - ClamAV integration)
-   [ ] Implement rollback on failure

#### 1.4.2 User + Patient/Doctor Creation

**Found:** Identical code in `AuthController` and `PatientController`/`DoctorController`

**Tasks:**

-   [ ] Create `UserRegistrationService::registerPatient()`
-   [ ] Create `UserRegistrationService::registerDoctor()`
-   [ ] Single source of truth for user creation
-   [ ] Handle database transactions
-   [ ] Rollback on failure
-   [ ] Update all registration flows to use service

#### 1.4.3 Disease Assignment Logic

**Found:** Repeated in multiple places (registration, update, profile edit)

**Tasks:**

-   [ ] Create `PatientDiseaseService::syncDiseases()`
-   [ ] Support all disease types (therapeutic areas, diseases, symptoms, addictions, etc.)
-   [ ] Handle medications field
-   [ ] Use database transactions

#### 1.4.4 Session Flash Messages

**Found:** Inconsistent patterns (`Session::flash()` vs `redirect()->with()`)

**Tasks:**

-   [ ] Standardize on `redirect()->with('status', [...])` pattern
-   [ ] Create helper method or Response macro for consistent flash messages
-   [ ] Replace all flash message calls throughout the application

---

## 2. Routing & Middleware Optimization

### 2.1 Route Organization

**Issue:** Routes file is long (150+ lines) and has mixed concerns.

**Priority:** 🟢 MEDIUM

**Tasks:**

-   [ ] Create route files structure:

    -   [ ] `routes/auth.php` - Authentication routes
    -   [ ] `routes/admin.php` - Admin-only routes
    -   [ ] `routes/doctor.php` - Doctor-specific routes
    -   [ ] `routes/patient.php` - Patient-specific routes
    -   [ ] `routes/public.php` - Public frontend routes

-   [ ] Split `routes/web.php` into separate files
-   [ ] Load route files in `RouteServiceProvider`
-   [ ] Group by middleware instead of inline calls
-   [ ] Use route model binding consistently

---

### 2.2 Middleware Consolidation

**Issue:** Redundant middleware checks, mixed permission + role checks.

**Priority:** 🟡 HIGH

**Tasks:**

-   [ ] Create custom middleware:

    -   [ ] `app/Http/Middleware/EnsureUserIsDoctor.php`
    -   [ ] `app/Http/Middleware/EnsureUserIsPatient.php`
    -   [ ] `app/Http/Middleware/EnsureUserIsAdmin.php`

-   [ ] Register middleware in `Kernel.php`
-   [ ] Consolidate route groups by role
-   [ ] Remove redundant middleware calls
-   [ ] Test all route access control

---

### 2.3 API vs Web Routes Consistency

**Issue:** API routes use JWT auth, Web routes use session auth. Similar CRUD operations.

**Priority:** 🟢 MEDIUM

**Tasks:**

-   [ ] Audit API routes and compare with web routes
-   [ ] Ensure API controllers have proper validation
-   [ ] Add API versioning (`/api/v1/`)
-   [ ] Document API endpoints (Scribe or Swagger)
-   [ ] Add example requests/responses

---

### 2.4 Route Naming Inconsistencies

**Issue:** Mixed naming conventions (kebab-case, snake_case, inconsistent prefixes).

**Priority:** 🟢 LOW

**Tasks:**

-   [ ] Standardize route naming (use resource conventions, dot notation)
-   [ ] Fix specific inconsistencies:
    -   [ ] `contactUs.store` → `contact.store`
    -   [ ] `admin_therapy_create` → `admin.therapy.create`
    -   [ ] `therapy-create` → `therapy.create`
-   [ ] Update all route references in controllers, views, and tests
-   [ ] Create route name documentation

---

## 3. Styling Consistency

### 3.1 CSS Architecture Issues

**Found:**

-   ✅ Tailwind CSS configured
-   ❌ 15+ separate CSS files in `public/assets/css/admin/`
-   ❌ Bootstrap loaded in some views
-   ❌ Inline `<style>` tags in multiple Blade templates
-   ❌ Multiple font imports

**Priority:** 🟡 HIGH

**Tasks:**

#### 3.1.1 CSS Audit

-   [ ] List all CSS files and their locations
-   [ ] Find which views use which CSS files
-   [ ] Identify unused CSS files
-   [ ] Analyze inline styles in Blade files
-   [ ] Check for Bootstrap vs Tailwind conflicts

#### 3.1.2 Choose CSS Strategy

**Option A: Full Tailwind (Recommended)**

-   [ ] Remove Bootstrap completely
-   [ ] Convert custom CSS to Tailwind utilities
-   [ ] Use Tailwind's `@layer` directive for custom styles
-   [ ] Benefits: Smaller bundle size, consistent design system

**Option B: Keep Bootstrap + Tailwind (Only if necessary)**

-   [ ] Namespace Bootstrap to avoid conflicts
-   [ ] Document when to use each framework

#### 3.1.3 CSS Consolidation

-   [ ] Remove unused CSS files
-   [ ] Consolidate into Tailwind configuration
-   [ ] Create component CSS files structure:
    ```
    resources/css/
    ├── app.css
    ├── components/
    │   ├── buttons.css
    │   ├── forms.css
    │   └── cards.css
    └── pages/
        ├── dashboard.css
        └── therapy.css
    ```
-   [ ] Eliminate inline styles
-   [ ] Use CSS variables for theming

#### 3.1.4 Tailwind Configuration

-   [ ] Optimize `tailwind.config.js` (colors, fonts, spacing, breakpoints)
-   [ ] Setup PurgeCSS properly for production
-   [ ] Configure dark mode (if needed)

---

### 3.2 Frontend Asset Management

**Priority:** 🟡 HIGH

**Tasks:**

#### 3.2.1 Vite Configuration

-   [ ] Verify Vite setup and configuration
-   [ ] Import all CSS in `resources/css/app.css`
-   [ ] Use `@vite` directive in layouts
-   [ ] Remove direct CSS links (use Vite's manifest)

#### 3.2.2 Remove CDN Dependencies

-   [ ] Self-host libraries:

    -   [ ] Font Awesome → Install via npm
    -   [ ] Google Fonts → Download and self-host
    -   [ ] Select2 → Install via npm
    -   [ ] SweetAlert2 → Install via npm
    -   [ ] Bootstrap (if keeping) → Install via npm

-   [ ] Update imports in `resources/js/app.js`
-   [ ] Font optimization (variable fonts, font-display: swap)

#### 3.2.3 Asset Optimization

-   [ ] JavaScript: Minify, code splitting, tree shaking, async/defer
-   [ ] CSS: Minify, remove unused Tailwind classes, critical CSS extraction

---

### 3.3 Component-Based Architecture

**Priority:** 🟢 MEDIUM

**Tasks:**

-   [ ] Create Blade components:

    -   [ ] `button.blade.php`
    -   [ ] `card.blade.php`
    -   [ ] `modal.blade.php`
    -   [ ] Form components (input, select, textarea, file-upload)
    -   [ ] `alert.blade.php`

-   [ ] Consider Alpine.js for interactivity (replace jQuery where appropriate)

---

## 4. Laravel Best Practices

### 4.1 Model Improvements

**Priority:** 🟡 HIGH

#### 4.1.1 Mass Assignment Security

-   [ ] Audit all models for `$fillable`/`$guarded` arrays
-   [ ] Add sensitive fields to `$hidden` (password, tokens)
-   [ ] Review and secure mass assignment

#### 4.1.2 Accessors & Mutators

-   [ ] Add to `User` model: `getFullNameAttribute()`
-   [ ] Add to `Doctor` model: `getFullNameAttribute()`, `getProfileImageUrlAttribute()`
-   [ ] Add to `Patient` model: `getFullNameAttribute()`, `getAgeAttribute()`
-   [ ] Add to `Blog` model: `getTitleAttribute()`, `getDescriptionAttribute()` (JSON decode + localize)
-   [ ] Add to `Therapy` model: `getDecryptedFilePathAttribute()`

#### 4.1.3 Model Observers

-   [ ] Create observers:

    -   [ ] `UserObserver` - Auto-assign role, send welcome email
    -   [ ] `TherapyObserver` - Validate audio, generate waveform, delete files
    -   [ ] `PatientObserver` - Clean up relations on delete
    -   [ ] `BookingObserver` - Send notifications on status changes

-   [ ] Register observers in `EventServiceProvider`

#### 4.1.4 Query Scopes

-   [ ] Add to `Therapy`: `scopeForUser()`, `scopeByAlbum()`, `scopeRecent()`
-   [ ] Add to `Blog`: `scopeRecent()`, `scopePublished()`, `scopeSearch()`
-   [ ] Add to `Booking`: `scopePending()`, `scopeApproved()`, `scopeCancelled()`
-   [ ] Add to `Doctor`: `scopeActive()`, `scopeBySpecialization()`, `scopeSearch()`
-   [ ] Replace direct queries with scopes

#### 4.1.5 Type Hints

-   [ ] Add return types to all methods
-   [ ] Add parameter types
-   [ ] Add property types (PHP 8.x)
-   [ ] Use strict types declaration

---

### 4.2 Controller Best Practices

**Priority:** 🔴 CRITICAL

#### 4.2.1 Slim Down Controllers

-   [ ] Move business logic to Services
-   [ ] Use Form Requests for validation
-   [ ] Use API Resources for responses
-   [ ] Target: <200 lines per controller

#### 4.2.2 Authorization with Policies

-   [ ] Create policies:

    -   [ ] `PatientPolicy`
    -   [ ] `DoctorPolicy`
    -   [ ] `TherapyPolicy`
    -   [ ] `BlogPolicy`
    -   [ ] `BookingPolicy`

-   [ ] Implement policy methods (viewAny, view, create, update, delete)
-   [ ] Register policies in `AuthServiceProvider`
-   [ ] Use `authorize()` in controllers
-   [ ] Replace middleware with policy checks

#### 4.2.3 Error Handling

-   [ ] Create custom exceptions:

    -   [ ] `Auth/InvalidCredentialsException`
    -   [ ] `Booking/SlotNotAvailableException`
    -   [ ] `File/FileUploadException`
    -   [ ] `Therapy/UnauthorizedAccessException`

-   [ ] Throw specific exceptions in Services
-   [ ] Handle exceptions in `Handler.php`
-   [ ] Remove try-catch from controllers
-   [ ] Return appropriate HTTP status codes

#### 4.2.4 Response Formatting

-   [ ] Create API Resource collections
-   [ ] Standardize JSON responses
-   [ ] Use correct HTTP status codes (200, 201, 204, 400, 401, 403, 404, 422, 500)

#### 4.2.5 Remove Dead Code

-   [ ] Remove `protected $dir` pattern
-   [ ] Remove unused variables
-   [ ] Remove commented code
-   [ ] Remove unused imports and methods

---

### 4.3 Database & Migrations

**Priority:** 🟡 HIGH

**Tasks:**

#### 4.3.1 Migration Review

-   [ ] Check foreign key constraints (`onDelete` behavior)
-   [ ] Add indexes where needed
-   [ ] Add soft deletes to appropriate tables

#### 4.3.2 Add Database Indexes

-   [ ] Users: `unique('email')`, index on `created_at`
-   [ ] Patients/Doctors: index on `user_id`, `created_at`, `(first_name, last_name)`
-   [ ] Therapies: index on `user_id`, `album_id`, `created_at`
-   [ ] Bookings: index on `patient_id`, `available_id`, `status`, `(status, created_at)`
-   [ ] Blogs: index on `user_id`, `created_at`, full-text on title/description

#### 4.3.3 Query Optimization

-   [ ] Install Laravel Debugbar for development
-   [ ] Identify N+1 queries
-   [ ] Add eager loading (`with()` method)
-   [ ] Use `select()` for specific columns
-   [ ] Use `chunk()` for large datasets
-   [ ] Use `exists()` instead of `count() > 0`

---

## 5. Security Improvements

### 5.1 Critical Security Issues

**Priority:** 🔴 CRITICAL

#### 5.1.1 Input Validation

**Status:** ⚠️ CRITICAL - No validation currently exists

-   [ ] Implement Form Requests for all controllers (see 1.1)
-   [ ] Sanitize user input (HTML, SQL, XSS protection)
-   [ ] Validate all file uploads (MIME, size, extension)

#### 5.1.2 File Upload Security

**Status:** ⚠️ HIGH RISK

-   [ ] Server-side MIME type validation
-   [ ] Validate file size limits
-   [ ] Store uploads outside `public/` directory
-   [ ] Generate random filenames (don't trust client input)
-   [ ] Serve files through controller with authorization checks
-   [ ] Add rate limiting to file downloads
-   [ ] Optional: Add virus scanning (ClamAV)

#### 5.1.3 Authentication Security

-   [ ] Implement password complexity requirements (min 8 chars, mixed case, numbers)
-   [ ] Add rate limiting:
    -   [ ] Login: 5 attempts per minute
    -   [ ] Registration: 3 per minute
    -   [ ] Password reset: 3 per hour
-   [ ] Implement email verification
-   [ ] Optional: Two-Factor Authentication

#### 5.1.4 Authorization Security

-   [ ] Implement Policies (see 4.2.2)
-   [ ] Never trust user input for authorization
-   [ ] Check ownership before edits/deletes
-   [ ] Use route model binding with policies

#### 5.1.5 Data Encryption

-   [ ] Verify therapy file encryption implementation
-   [ ] Encrypt sensitive patient data (medical history, phone numbers)
-   [ ] Use Laravel's encrypted casts
-   [ ] Force HTTPS in production

#### 5.1.6 XSS Protection

-   [ ] Audit Blade templates (replace `{!! !!}` with `{{ }}`)
-   [ ] Install HTMLPurifier for rich text content
-   [ ] Use `@json()` directive for passing data to JavaScript

#### 5.1.7 CSRF Protection

-   [ ] Ensure all POST forms have `@csrf`
-   [ ] Configure AJAX CSRF token headers
-   [ ] Verify exception list in `VerifyCsrfToken` middleware

#### 5.1.8 SQL Injection Protection

-   [ ] Use Eloquent ORM (already doing ✅)
-   [ ] Avoid raw queries (use parameter binding if needed)
-   [ ] Audit for `DB::raw()` and `->whereRaw()`

---

### 5.2 Rate Limiting

**Priority:** 🟡 HIGH

**Tasks:**

-   [ ] Define rate limits for:

    -   [ ] Login endpoint (5 per minute)
    -   [ ] Registration endpoint (3 per minute)
    -   [ ] API endpoints (60 per minute)
    -   [ ] Contact form (5 per hour)

-   [ ] Apply rate limiters to routes
-   [ ] Customize rate limit response messages

---

### 5.3 Security Headers

**Priority:** 🟢 MEDIUM

**Tasks:**

-   [ ] Create SecurityHeaders middleware
-   [ ] Add headers: X-Frame-Options, X-Content-Type-Options, X-XSS-Protection, Referrer-Policy
-   [ ] Register middleware globally
-   [ ] Optional: Implement Content Security Policy (CSP)

---

## 6. Performance Optimization

### 6.1 Database Optimization

**Priority:** 🟡 HIGH

#### 6.1.1 Identify N+1 Queries

-   [ ] Install Laravel Debugbar
-   [ ] Navigate through application and document N+1 issues
-   [ ] Fix with eager loading

#### 6.1.2 Query Optimization

-   [ ] Use `select()` for specific columns (avoid SELECT \*)
-   [ ] Use `chunk()` for large datasets
-   [ ] Use `exists()` instead of `count() > 0`
-   [ ] Add pagination to all list views

#### 6.1.3 Database Indexes

-   [ ] Add indexes on foreign keys
-   [ ] Add indexes on frequently filtered columns
-   [ ] Add composite indexes for common query patterns
-   [ ] Monitor slow query log

---

### 6.2 Caching Strategy

**Priority:** 🟡 HIGH

#### 6.2.1 Application Caching

-   [ ] Configure cache driver (Redis for production, file for development)
-   [ ] Install Redis: `composer require predis/predis`

#### 6.2.2 Query Result Caching

-   [ ] Cache blog list (15 minutes)
-   [ ] Cache doctor list (30 minutes)
-   [ ] Cache therapy list per user role (10 minutes)
-   [ ] Cache disease/symptom lists (60 minutes)

#### 6.2.3 Cache Invalidation

-   [ ] Use cache tags (Redis only) for organized invalidation
-   [ ] Invalidate caches in model observers
-   [ ] Create CacheService for centralized cache management

#### 6.2.4 Route & Config Caching (Production)

-   [ ] Cache routes: `php artisan route:cache`
-   [ ] Cache config: `php artisan config:cache`
-   [ ] Cache views: `php artisan view:cache`
-   [ ] Add to deployment script: `php artisan optimize`

#### 6.2.5 Language File Caching

-   [ ] Cache translations: `php artisan lang:publish`
-   [ ] Consider Laravel Translation Loader for database caching

---

### 6.3 Asset Optimization

**Priority:** 🟡 HIGH

#### 6.3.1 Image Optimization

-   [ ] Install Spatie Image Optimizer
-   [ ] Optimize images on upload
-   [ ] Generate thumbnails (Intervention Image)
-   [ ] Use WebP format
-   [ ] Implement lazy loading
-   [ ] Serve responsive images

#### 6.3.2 JavaScript Optimization

-   [ ] Minify in production (Vite config)
-   [ ] Code splitting for large components
-   [ ] Tree shaking unused code
-   [ ] Defer non-critical scripts

#### 6.3.3 CSS Optimization

-   [ ] Purge unused Tailwind classes (automatic in production)
-   [ ] Minify CSS in production
-   [ ] Extract critical CSS
-   [ ] Remove unused CSS files

#### 6.3.4 Font Optimization

-   [ ] Self-host fonts (no external CDN)
-   [ ] Use `font-display: swap`
-   [ ] Subset fonts (only needed characters)
-   [ ] Use variable fonts where possible

---

### 6.4 Audio File Handling

**Priority:** 🟡 HIGH

#### 6.4.1 Audio Streaming

-   [ ] Implement streaming instead of full file download
-   [ ] Support HTTP range requests (seek in audio player)
-   [ ] Use Laravel Storage streaming

#### 6.4.2 Audio Processing

-   [ ] Install Laravel FFmpeg: `composer require pbmedia/laravel-ffmpeg`
-   [ ] Compress audio on upload
-   [ ] Generate preview clips (30 seconds)
-   [ ] Generate multiple quality versions (high/medium/low bitrate)

#### 6.4.3 CDN Integration (Optional)

-   [ ] Setup CDN for audio files (AWS CloudFront, Cloudflare)
-   [ ] Use signed URLs for private content
-   [ ] Benefits: Faster delivery, reduced server load, geographic distribution

---

### 6.5 Session & Queue Optimization

**Priority:** 🟢 MEDIUM

**Tasks:**

-   [ ] Use Redis for sessions in production
-   [ ] Configure session lifetime appropriately
-   [ ] Setup queue workers for:
    -   [ ] Email sending
    -   [ ] Audio processing
    -   [ ] Image optimization
    -   [ ] Notification sending

---

## 7. Code Quality & Testing

### 7.1 Code Standards

**Priority:** 🟢 MEDIUM

#### 7.1.1 PSR Standards

-   [ ] Install PHP CS Fixer: `composer require friendsofphp/php-cs-fixer --dev`
-   [ ] Create `.php-cs-fixer.php` configuration
-   [ ] Run: `./vendor/bin/php-cs-fixer fix`
-   [ ] Add to pre-commit hook

#### 7.1.2 Static Analysis

-   [ ] Install Larastan: `composer require nunomaduro/larastan --dev`
-   [ ] Create `phpstan.neon` configuration
-   [ ] Run: `./vendor/bin/phpstan analyse`
-   [ ] Fix reported issues (target level 5+)

#### 7.1.3 Code Comments

-   [ ] Add PHPDoc blocks to all methods
-   [ ] Document complex logic
-   [ ] Remove commented-out code

---

### 7.2 Testing

**Priority:** 🟡 HIGH

#### 7.2.1 Unit Tests

-   [ ] Test Services (business logic)
-   [ ] Test Models (accessors, scopes, relationships)
-   [ ] Test Helpers
-   [ ] Target: 70%+ code coverage

#### 7.2.2 Feature Tests

-   [ ] Test authentication flows (login, registration, logout)
-   [ ] Test booking system (create, approve, cancel)
-   [ ] Test therapy access control
-   [ ] Test file uploads (images, audio)
-   [ ] Test API endpoints

#### 7.2.3 Browser Tests (Laravel Dusk)

-   [ ] Test user registration flows
-   [ ] Test appointment booking process
-   [ ] Test music player functionality
-   [ ] Test admin CRUD operations

#### 7.2.4 Test Organization

-   [ ] Organize tests by feature
-   [ ] Use factories for test data
-   [ ] Use database transactions for cleanup
-   [ ] Mock external services

---

## 8. Documentation

### 8.1 Code Documentation

**Priority:** 🟢 MEDIUM

#### 8.1.1 README.md Updates

-   [ ] Installation instructions
-   [ ] Environment setup guide
-   [ ] Database seeding instructions
-   [ ] Running tests
-   [ ] Deployment guide

#### 8.1.2 API Documentation

-   [ ] Generate API docs (Scribe or Swagger)
-   [ ] Document all endpoints
-   [ ] Add example requests/responses
-   [ ] Document authentication flow

#### 8.1.3 Architecture Documentation

-   [ ] Create Entity-Relationship Diagram
-   [ ] Service layer diagram
-   [ ] Authentication flow diagram
-   [ ] Booking system workflow diagram

---

### 8.2 Inline Documentation

**Priority:** 🟢 LOW

**Tasks:**

-   [ ] Add PHPDoc comments for:
    -   [ ] Complex business logic
    -   [ ] Security-critical code
    -   [ ] Temporary workarounds
    -   [ ] Performance optimizations

---

## 9. Deployment & CI/CD

### 9.1 Environment Configuration

**Priority:** 🟡 HIGH

**Tasks:**

-   [ ] Document required environment variables
-   [ ] Update `.env.example` with all keys
-   [ ] Separate staging/production configs
-   [ ] Rotate `APP_KEY` in production
-   [ ] Use strong `JWT_SECRET`
-   [ ] Configure CORS properly
-   [ ] Enable HTTPS redirect

---

### 9.2 CI/CD Pipeline

**Priority:** 🟢 MEDIUM

**Tasks:**

#### 9.2.1 Automated Testing

-   [ ] Run tests on every push (GitHub Actions / GitLab CI)
-   [ ] Run static analysis (PHPStan)
-   [ ] Check code style (PHP CS Fixer)
-   [ ] Run security checks

#### 9.2.2 Deployment Automation

-   [ ] Automated deployment to staging
-   [ ] Manual approval for production deployment
-   [ ] Database migration automation
-   [ ] Asset compilation (Vite build)
-   [ ] Cache clearing and optimization

#### 9.2.3 Sample GitHub Actions Workflow

```yaml
name: Laravel CI/CD

on: [push, pull_request]

jobs:
    test:
        runs-on: ubuntu-latest
        steps:
            - uses: actions/checkout@v2
            - name: Setup PHP
              uses: shivammathur/setup-php@v2
              with:
                  php-version: 8.1
            - name: Install Dependencies
              run: composer install
            - name: Run Tests
              run: php artisan test
            - name: Run PHPStan
              run: ./vendor/bin/phpstan analyse
```

---

## 10. Priority Roadmap

### Phase 1: Critical Security & Validation (Week 1-2)

**Priority:** 🔴 CRITICAL

-   [ ] Create Form Request classes for all controllers
-   [ ] Add file upload validation and security
-   [ ] Implement rate limiting on sensitive endpoints
-   [ ] Review and fix XSS vulnerabilities
-   [ ] Add password complexity requirements
-   [ ] Implement email verification

**Success Criteria:** No critical security vulnerabilities, all inputs validated

---

### Phase 2: Code Organization (Week 2-3)

**Priority:** 🟡 HIGH

-   [ ] Create Service Layer (UserRegistrationService, FileUploadService, etc.)
-   [ ] Extract file upload logic to dedicated service
-   [ ] Consolidate duplicate code (disease assignment, flash messages)
-   [ ] Optional: Implement Repository pattern

**Success Criteria:** Controllers <200 lines, business logic in services

---

### Phase 3: Laravel Best Practices (Week 4-5)

**Priority:** 🟡 HIGH

-   [ ] Create Policies for authorization
-   [ ] Add Model Observers for automated tasks
-   [ ] Optimize database queries (eager loading, indexes)
-   [ ] Add query scopes to models
-   [ ] Create custom exceptions

**Success Criteria:** No N+1 queries, proper authorization, clean models

---

### Phase 4: Frontend Consistency (Week 5-6)

**Priority:** 🟡 HIGH

-   [ ] Choose CSS framework strategy (Full Tailwind recommended)
-   [ ] Consolidate CSS files (remove unused)
-   [ ] Remove inline styles
-   [ ] Optimize assets (Vite configuration)
-   [ ] Self-host external dependencies
-   [ ] Create reusable Blade components

**Success Criteria:** <5 CSS files, consistent styling, optimized assets

---

### Phase 5: Performance Optimization (Week 6-7)

**Priority:** 🟡 HIGH

-   [ ] Add database indexes
-   [ ] Implement caching strategy (Redis)
-   [ ] Optimize images (compression, WebP, thumbnails)
-   [ ] Implement audio streaming
-   [ ] Cache routes, config, views in production

**Success Criteria:** Page load <2s, API response <500ms

---

### Phase 6: Testing & Documentation (Week 7-8)

**Priority:** 🟢 MEDIUM

-   [ ] Write unit tests (Services, Models)
-   [ ] Write feature tests (Auth, Booking, Therapy)
-   [ ] Update README.md
-   [ ] Generate API documentation
-   [ ] Create architecture diagrams

**Success Criteria:** >70% test coverage, comprehensive documentation

---

### Phase 7: CI/CD & Polish (Week 8-9)

**Priority:** 🟢 MEDIUM

-   [ ] Setup GitHub Actions / GitLab CI
-   [ ] Automated testing pipeline
-   [ ] Deployment automation
-   [ ] Final security audit
-   [ ] Performance monitoring setup

**Success Criteria:** Automated deployments, no critical issues

---

## Metrics & Success Criteria

### Code Quality Metrics

-   [ ] PSR-12 Compliance: 100%
-   [ ] Test Coverage: >70%
-   [ ] PHPStan Level: 5+
-   [ ] No critical security issues (verified by security scanner)

### Performance Metrics

-   [ ] Page Load Time: <2s (95th percentile)
-   [ ] API Response Time: <500ms (95th percentile)
-   [ ] Database Query Time: <100ms (average)
-   [ ] Lighthouse Score: >90

### Maintainability Metrics

-   [ ] Lines per Controller: <300
-   [ ] Cyclomatic Complexity: <10 per method
-   [ ] CSS File Count: <5 total
-   [ ] JS File Count: <10 total

---

## Notes

-   **Team Size:** Assumes 2-3 developers
-   **Timeline:** 8-9 weeks for full implementation
-   **Priority:** Phase 1 (Security) MUST be completed before anything else
-   **Testing:** Test thoroughly after each phase
-   **Code Freeze:** Consider code freeze during major refactoring
-   **Communication:** Regular standups to track progress
-   **Documentation:** Update this plan as tasks are completed

---

## Progress Tracking

**Current Phase:** Planning  
**Completed Phases:** None  
**Next Milestone:** Phase 1 - Security & Validation  
**Estimated Completion:** January 2026

---

_Plan created: October 31, 2025_  
_Last updated: October 31, 2025_  
_Document owner: Development Team_
