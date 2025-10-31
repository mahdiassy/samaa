# SAMAA Project - Architecture & Flow Review

## Overview
This is a **medical therapy platform** connecting doctors/therapists with patients for music therapy sessions and consultations.

---

## 1. Routes Flow (`routes/web.php`)

### A. Public Routes (No Authentication)
All routes wrapped in **LaravelLocalization** middleware for multi-language support (ar/en/fr):

#### Main Public Pages:
- `/` → `HomeController@home` - Homepage with latest 3 blogs
- `/contact-us` → `HomeController@contactUs` - Contact form page
- `/about-us` → `HomeController@aboutUs` - About page
- `/how-it-work` → `HomeController@howItWork` - How it works page
- `/therapists` → `HomeController@therapists` - Therapists listing
- `/doctor-search` → `DoctorController@search` - Doctor search functionality
- `/blog` → `BlogController@index` - Public blog listing
- `/blog/{blog}` → `BlogController@show` - Individual blog post

#### Authentication Routes:
- `/login` → `AuthController@showLoginForm` / `login()`
- `/register` → Patient/Doctor registration flows
- `/logout` → `AuthController@logout`

---

### B. Protected Routes (`/control` prefix + `auth:web` middleware)

#### Dashboard:
- `/control/dashboard` → `HomeController@index` - Main dashboard view

#### Patient Management (Admin/Doctor only):
- `/control/patient/*` → `PatientController` CRUD
- Profile editing for patients

#### Doctor Management (Admin/Patient/Doctor):
- `/control/doctor/*` → `DoctorController` CRUD
- Profile editing for doctors
- `/control/doctors/calendar` → Doctor availability calendar (Doctor role)
- `/control/doctors/booking` → View patient bookings (Doctor role)

#### Therapy Management (Admin/Doctor/Patient):
- `/control/therapy/*` → `TherapyController` CRUD
- Music therapy session creation and playback
- `/control/therapies/playlist` → Therapy playlist view

#### Booking System:
- **Doctors:** Manage availability slots, view/approve bookings
- **Patients:** Book appointments, view bookings, cancel appointments

#### Blog Management (Admin only):
- `/control/blogs/*` → Full CRUD operations

#### Feedback System:
- Create/view feedback (all authenticated users)
- Admin can view all feedback

---

## 2. Controllers & Logic

### `HomeController` - Main public pages
- `home()` → Returns `layouts.home` with 3 latest blogs
- `contactUs()` → Returns `layouts.contact-us`
- `storeContactUsForm()` → Saves feedback to database
- `aboutUs()` → Returns `layouts.about-us`
- `howItWork()` → Returns `layouts.how-it-work`
- `therapists()` → Returns `layouts.Therapists`
- `index()` → Authenticated dashboard at `layouts.dashboard`

### `AuthController` - Authentication
- Handles login/logout/registration for both Patients and Doctors
- Separate registration forms and flows for each user type
- Uses Spatie Laravel Permission for role assignment
- Creates `User` + `Patient`/`Doctor` records simultaneously

### `DoctorController` - Doctor Management
- CRUD operations with permission checks (via `Permissions` enum)
- **Calendar functionality:** Doctors add/delete availability time slots
- **Booking management:** View patient bookings, approve/reject appointments
- Profile editing separate from admin editing

### `PatientController` - Patient Management
- CRUD operations for patient records
- Disease/symptom/consultation tracking
- Profile editing functionality

### `TherapyController` - Music Therapy Core
- Upload encrypted audio therapy files (max 100MB)
- Album management (categorization)
- Real-time music control via WebSockets (`MusicControlEvent`)
- Waveform peaks generation for audio visualization
- Role-based therapy access

### `BlogController` - Blog System
- Multi-language support (JSON encoded titles/descriptions)
- Search functionality with locale support
- Image uploads for blog posts
- Statistics: total blogs, recent blogs, active authors

### `BookingController` - Patient Booking
- Patients book doctor availability slots
- Status management: Pending → Approved/Canceled
- Prevents double-booking of time slots

### `FeedbackController` - Feedback/Contact
- Collects user feedback from contact forms
- Stores CTA (Call To Action) tracking data

---

## 3. Views Structure

### `resources/views/layouts/` - Main layouts
- `base.blade.php` - Base template
- `home.blade.php` - Homepage
- `contact-us.blade.php` - Contact page
- `about-us.blade.php` - About page
- `how-it-work.blade.php` - How it works
- `Therapists.blade.php` - Therapists listing
- `dashboard.blade.php` - Authenticated dashboard
- `master2.blade.php` - Secondary master template

### `resources/views/auth/` - Authentication views
- Login, register forms for patients/doctors

### `resources/views/doctor/` - Doctor admin views
- CRUD forms, profile editing, calendar, bookings

### `resources/views/patient/` - Patient admin views
- CRUD forms, profile editing

### `resources/views/therapy/` - Therapy views
- Create therapy, playlist player, audio controls

### `resources/views/appointment/` - Booking views
- Calendar views, booking forms

### `resources/views/blog/` - Blog views
- Index, show, create, edit forms

### `resources/views/frontend/` - Additional frontend
- `listenToMusic.blade.php` - Music player interface
- `listener-statistics.blade.php` - Statistics view

---

## 4. Key Models

- **`User`** - Authentication, uses Spatie Roles (Admin/Doctor/Patient)
- **`Doctor`** - Therapist profiles, specializations
- **`Patient`** - Patient records with diseases/symptoms
- **`Therapy`** - Encrypted audio therapy files
- **`Booking`** - Appointment system
- **`Availability`** - Doctor time slots
- **`Blog`** - Multi-language blog posts
- **`Feedback`** - Contact form submissions
- **`Album`** - Therapy categorization
- **Disease/Symptom/Consultation** - Medical taxonomy

---

## 5. Key Features

✅ **Multi-language** (Arabic/English/French via LaravelLocalization)  
✅ **Role-based access** (Admin/Doctor/Patient via Spatie Permissions)  
✅ **Music therapy** with encrypted audio files + real-time controls  
✅ **Booking system** with availability management  
✅ **Blog system** with multi-language content  
✅ **Contact/Feedback** system  
✅ **File encryption** for sensitive therapy audio  
✅ **WebSocket events** for synchronized music playback

---

## 6. Request Flow Example

### Patient Booking a Doctor:
1. Patient visits `/therapists` (public)
2. Clicks doctor → `/doctor-search` 
3. Logs in → `/login` → `AuthController`
4. Views doctor calendar → `/control/patients/calendar/{id}` → `BookingController@calendar`
5. Selects time slot → POST `/control/patients/addAppointment` → Creates `Booking` (Pending status)
6. Doctor views → `/control/doctors/booking` → Approves/rejects
7. Patient sees status → `/control/patients/booking`

---

## 7. Technology Stack

- **Framework:** Laravel 10.x
- **Frontend:** Blade templates, Vite, Tailwind CSS
- **Authentication:** Laravel Auth + Spatie Laravel Permission
- **Localization:** mcamara/laravel-localization
- **Real-time:** Laravel Broadcasting (WebSockets)
- **File Storage:** Encrypted file storage
- **Database:** MySQL (migrations in `database/migrations/`)

---

## Architecture Summary

This architecture follows Laravel MVC patterns with clear separation between:
- **Public frontend** (marketing pages, blog)
- **Authenticated backend** (dashboard, CRUD operations)
- **Role-specific functionality** (Doctor calendars, Patient bookings, Admin management)

The project emphasizes security (encrypted therapy files), accessibility (multi-language), and real-time features (synchronized music playback).