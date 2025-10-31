---

## CLEANUP & OPTIMIZATION PLAN

### Date: October 31, 2025
### Status: Planning Phase

---

## 1. CODE ORGANIZATION & STRUCTURE

### 1.1 Request Validation
**Issue:** Controllers have no validation logic; all requests are accepted without validation.

**Tasks:**
- [ ] Create Form Request classes in `app/Http/Requests/`
  - [ ] `StorePatientRequest` / `UpdatePatientRequest`
  - [ ] `StoreDoctorRequest` / `UpdateDoctorRequest`
  - [ ] `StoreTherapyRequest` / `UpdateTherapyRequest`
  - [ ] `StoreBlogRequest` / `UpdateBlogRequest`
  - [ ] `LoginRequest` / `RegisterPatientRequest` / `RegisterDoctorRequest`
  - [ ] `StoreBookingRequest`
  - [ ] `StoreFeedbackRequest`
- [ ] Add validation rules for:
  - Email uniqueness
  - Required fields
  - File upload constraints (size, type, mime)
  - Date formats
  - Phone number formats
- [ ] Move validation logic OUT of controllers INTO dedicated Request classes

### 1.2 Service Layer Pattern
**Issue:** Controllers contain too much business logic (especially `AuthController`, `PatientController`).

**Tasks:**
- [ ] Create `app/Services/` directory
- [ ] Extract business logic to service classes:
  - [ ] `UserRegistrationService` - Handle Patient/Doctor registration
  - [ ] `FileUploadService` - Centralize file upload logic (replace `storeFile()` / `storeFileEncrypt()`)
  - [ ] `PatientDiseaseService` - Manage patient disease assignments
  - [ ] `BookingService` - Handle appointment logic
  - [ ] `TherapyAccessService` - Centralize role-based therapy access
- [ ] Controllers should only:
  - Validate input (via Form Requests)
  - Call service methods
  - Return responses

### 1.3 Repository Pattern (Optional but Recommended)
**Issue:** Direct model calls in controllers and complex queries in models.

**Tasks:**
- [ ] Create `app/Repositories/` directory
- [ ] Create repository classes:
  - [ ] `TherapyRepository` - Move `getTherapiesBasedRole()` logic
  - [ ] `PatientRepository`
  - [ ] `DoctorRepository`
  - [ ] `BookingRepository`
- [ ] Benefits: Easier testing, cleaner controllers, centralized query logic

### 1.4 Duplicate Code Elimination

**Found Duplications:**

1. **File Upload Logic:** `storeFile()` and `storeFileEncrypt()` called in 10+ places
   - [ ] Create dedicated `FileUploadService` with proper error handling
   - [ ] Add consistent file naming conventions
   - [ ] Add file type validation
   - [ ] Add virus scanning (optional)

2. **User + Patient/Doctor Creation:** Identical in `AuthController` and `PatientController`/`DoctorController`
   - [ ] Create `UserRegistrationService::registerPatient()` and `registerDoctor()`
   - [ ] Single source of truth for user creation logic

3. **Disease Assignment Logic:** Repeated in multiple places (registration, update)
   - [ ] Create `PatientDiseaseService::syncDiseases(Patient $patient, array $data)`

4. **Session Flash Messages:** Inconsistent patterns (`Session::flash()` vs `redirect()->with()`)
   - [ ] Standardize on `redirect()->with('status', [...])` pattern
   - [ ] Create helper method or macro for consistent flash messages

---

## 2. ROUTING & MIDDLEWARE OPTIMIZATION

### 2.1 Route Organization
**Issue:** Routes file is long and has mixed concerns.

**Tasks:**
- [ ] Split routes into separate files:
  - [ ] `routes/auth.php` - Authentication routes
  - [ ] `routes/admin.php` - Admin-only routes
  - [ ] `routes/doctor.php` - Doctor-specific routes
  - [ ] `routes/patient.php` - Patient-specific routes
  - [ ] `routes/public.php` - Public frontend routes
- [ ] Group by middleware instead of inline `->middleware()` calls
- [ ] Use route model binding consistently

### 2.2 Middleware Consolidation
**Issue:** Redundant middleware checks, mixed permission + role checks.

**Tasks:**
- [ ] Remove redundant middleware:
  - Routes under `auth:web` group have individual `->middleware('role:...')` calls
  - Consolidate into route groups
- [ ] Example refactor:
  ```php
  // BEFORE
  Route::resource('patient', PatientController::class)->middleware('role:Admin|Doctor');
  
  // AFTER
  Route::group(['middleware' => ['auth:web', 'role:Admin|Doctor']], function() {
      Route::resource('patient', PatientController::class);
  });