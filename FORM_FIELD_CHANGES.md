# Field Name Changes - Testing Reference

## 🔄 IMPORTANT: Form Field Names Changed

When testing the updated controllers, be aware that some field names have changed to match the Form Request validation rules:

### Patient Forms (Create/Update)

**OLD NAME** → **NEW NAME**

-   `last_name` → `surname` ✅
-   `country` → `country_id` ✅
-   `language` → `language_id` ✅

### Doctor Forms (Create/Update)

**OLD NAME** → **NEW NAME**

-   `last_name` → `surname` ✅

### Fields That Stayed The Same

-   `first_name` ✅
-   `email` ✅
-   `password` ✅
-   `phone` ✅
-   `age` ✅
-   `gender` ✅
-   `address` ✅
-   `image` ✅ (file upload)
-   `specialization` (doctors) ✅
-   `therapeutic_areas` (patients) ✅
-   `diseases` (patients) ✅
-   `symptoms` (patients) ✅
-   `addiction` (patients) ✅
-   `consultations` (patients) ✅

---

## 🛠️ ACTION REQUIRED: Update Blade Forms

You need to update the following Blade template files to match the new field names:

### Patient Forms

1. **`resources/views/patient/create.blade.php`**

    - Change `<input name="last_name">` to `<input name="surname">`
    - Change `<select name="country">` to `<select name="country_id">`
    - Change `<select name="language">` to `<select name="language_id">`

2. **`resources/views/patient/edit.blade.php`**

    - Same changes as create.blade.php

3. **`resources/views/auth/register-patient.blade.php`** (if exists)
    - Change `last_name` → `surname`
    - Change `country` → `country_id`
    - Change `language` → `language_id`

### Doctor Forms

1. **`resources/views/doctor/create.blade.php`**

    - Change `<input name="last_name">` to `<input name="surname">`

2. **`resources/views/doctor/edit.blade.php`**

    - Change `<input name="last_name">` to `<input name="surname">`

3. **`resources/views/doctor/profile.blade.php`** (if exists)

    - Change `<input name="last_name">` to `<input name="surname">`

4. **`resources/views/auth/register-doctor.blade.php`** (if exists)
    - Change `last_name` → `surname`

---

## 📝 Example Blade Form Update

### BEFORE:

```html
<input type="text" name="last_name" value="{{ old('last_name') }}" required />
<select name="country">
    <option value="1">USA</option>
</select>
```

### AFTER:

```html
<input type="text" name="surname" value="{{ old('surname') }}" required />
<select name="country_id">
    <option value="1">USA</option>
</select>
```

---

## ⚠️ TESTING WITHOUT FORM UPDATES

If you want to test the backend immediately without updating forms, you can use **Postman** or **curl** with the correct field names:

```bash
# Test Patient Creation (Postman/curl)
POST /patient
Content-Type: multipart/form-data

first_name: John
surname: Doe  # Changed from last_name
email: john@example.com
password: SecurePass123!
password_confirmation: SecurePass123!
phone: +1234567890
age: 30
gender: male
country_id: 1  # Changed from country
language_id: 1  # Changed from language
image: [file upload]
therapeutic_areas: 1
addiction: 1
consultation: 1
```

---

## 🎯 Next Steps

1. **Option A: Update Blade Forms Now** (Recommended)

    - Update all forms with new field names
    - Then test the entire flow

2. **Option B: Test Backend First**

    - Use Postman/API testing
    - Update forms later

3. **Option C: Revert Field Names** (Not Recommended)
    - Change Form Requests back to old field names
    - Keeps old blade forms working
    - Less secure naming convention
