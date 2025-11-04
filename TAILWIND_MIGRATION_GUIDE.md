# Tailwind CSS Migration Guide

## ✅ Step 1: Setup Complete!

I've already completed the initial setup:

-   ✅ Removed all admin CSS file imports from `master2.blade.php`
-   ✅ Added `@vite(['resources/css/app.css', 'resources/js/app.js'])` directive
-   ✅ Added admin-specific Tailwind components to `resources/css/app.css`

## 📋 Step 2: Build Tailwind CSS

Run these commands in your terminal:

```bash
# Install dependencies if needed
npm install

# Build Tailwind CSS (development)
npm run dev

# Or build for production
npm run build
```

Keep `npm run dev` running in the background while developing.

## 🎨 Step 3: Convert Pages to Tailwind

### Replace CSS Classes with Tailwind Classes

Here's the conversion mapping for common classes:

#### Management Page Containers

**Old CSS:**

```html
<div class="doctor-management-content"></div>
```

**New Tailwind:**

```html
<div class="admin-page-container">
    <!-- OR directly use: -->
    <div
        class="w-full p-5 md:p-9 bg-gradient-to-br from-slate-50 to-gray-100 min-h-screen"
    ></div>
</div>
```

#### Page Headers

**Old CSS:**

```html
<div class="page-header">
    <h1 class="page-title">Title</h1>
    <p class="page-subtitle">Subtitle</p>
</div>
```

**New Tailwind (using custom components):**

```html
<div class="page-header">
    <h1 class="page-title">Title</h1>
    <p class="page-subtitle">Subtitle</p>
</div>
```

**Or use pure Tailwind:**

```html
<div
    class="bg-gradient-to-r from-slate-800 via-slate-700 to-slate-600 rounded-2xl p-6 md:p-10 mb-6 md:mb-8 text-white relative overflow-hidden"
>
    <h1 class="text-2xl md:text-4xl font-bold mb-2 text-white">Title</h1>
    <p class="text-sm md:text-base text-slate-200">Subtitle</p>
</div>
```

#### Statistics Grid

**Old CSS:**

```html
<div class="stats-grid">
    <div class="stat-card">
        <div class="stat-icon">...</div>
        <div class="stat-content">
            <h3>100</h3>
            <p>Total Items</p>
        </div>
    </div>
</div>
```

**New Tailwind:**

```html
<div class="stats-grid">
    <!-- OR: grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 md:gap-6 mb-6 md:mb-8 -->
    <div class="stat-card">
        <!-- OR: bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-all duration-300 flex items-center gap-4 -->
        <div class="stat-icon">
            <!-- OR: w-14 h-14 rounded-full flex items-center justify-center flex-shrink-0 bg-blue-100 text-blue-600 -->
            <svg>...</svg>
        </div>
        <div class="stat-content">
            <h3 class="text-2xl md:text-3xl font-bold text-slate-800 mb-1">
                100
            </h3>
            <p class="text-sm text-slate-600">Total Items</p>
        </div>
    </div>
</div>
```

#### Buttons

**Old CSS:**

```html
<a href="#" class="add-btn">Add New</a>
```

**New Tailwind:**

```html
<a href="#" class="add-btn">
    <!-- OR: flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white rounded-lg hover:from-blue-700 hover:to-blue-800 transition-all duration-200 shadow-md hover:shadow-lg -->
    <svg class="w-5 h-5">...</svg>
    Add New
</a>
```

#### Search Input

**Old CSS:**

```html
<div class="search-container">
    <svg class="search-icon">...</svg>
    <input type="text" class="search-input" placeholder="Search..." />
</div>
```

**New Tailwind:**

```html
<div class="search-container">
    <!-- OR: relative flex items-center -->
    <svg class="search-icon">
        <!-- OR: absolute left-3 w-5 h-5 text-slate-400 -->
    </svg>
    <input type="text" class="search-input" placeholder="Search..." />
    <!-- OR: w-full md:w-64 pl-10 pr-4 py-2 border border-slate-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all duration-200 -->
</div>
```

#### Tables

**Old CSS:**

```html
<div class="table-section">
    <table class="modern-table">
        <thead>
            <tr>
                <th>Header</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>Data</td>
            </tr>
        </tbody>
    </table>
</div>
```

**New Tailwind:**

```html
<div class="table-section">
    <!-- OR: bg-white rounded-2xl shadow-lg overflow-hidden -->
    <table class="modern-table">
        <!-- OR: w-full -->
        <thead class="bg-slate-100 text-slate-700">
            <tr>
                <th class="px-6 py-4 text-left text-sm font-semibold">
                    Header
                </th>
            </tr>
        </thead>
        <tbody>
            <tr
                class="border-b border-slate-100 hover:bg-slate-50 transition-colors duration-150"
            >
                <td class="px-6 py-4 text-sm text-slate-600">Data</td>
            </tr>
        </tbody>
    </table>
</div>
```

#### Action Buttons

**Old CSS:**

```html
<div class="action-buttons">
    <a href="#" class="action-btn view-btn">...</a>
    <a href="#" class="action-btn edit-btn">...</a>
    <button class="action-btn delete-btn">...</button>
</div>
```

**New Tailwind:**

```html
<div class="action-buttons">
    <!-- OR: flex items-center gap-2 -->
    <a href="#" class="action-btn view-btn">
        <!-- OR: w-9 h-9 rounded-lg flex items-center justify-center transition-all duration-200 bg-blue-50 text-blue-600 hover:bg-blue-100 -->
        <svg>...</svg>
    </a>
    <a href="#" class="action-btn edit-btn">
        <!-- OR: bg-amber-50 text-amber-600 hover:bg-amber-100 -->
        <svg>...</svg>
    </a>
    <button class="action-btn delete-btn">
        <!-- OR: bg-red-50 text-red-600 hover:bg-red-100 -->
        <svg>...</svg>
    </button>
</div>
```

## 📝 Step 4: Update Doctor Pages

### Example: doctor/index.blade.php

Replace:

```html
<div class="doctor-management-content"></div>
```

With:

```html
<div class="admin-page-container"></div>
```

## 🎯 Quick Conversion Reference

| Old Class                      | New Tailwind Class                         |
| ------------------------------ | ------------------------------------------ |
| `.doctor-management-content`   | `.admin-page-container` or direct Tailwind |
| `.patient-management-content`  | `.admin-page-container` or direct Tailwind |
| `.blog-management-content`     | `.admin-page-container` or direct Tailwind |
| `.therapy-management-content`  | `.admin-page-container` or direct Tailwind |
| `.feedback-management-content` | `.admin-page-container` or direct Tailwind |

## 🚀 Step 5: Test Your Changes

1. Start the development server:

    ```bash
    npm run dev
    ```

2. In another terminal, start Laravel:

    ```bash
    php artisan serve
    ```

3. Visit your admin pages and verify they look correct

## 💡 Pro Tips

1. **Use Custom Components**: The classes in `app.css` (like `.admin-page-container`, `.page-header`, etc.) are easier to maintain

2. **Use Pure Tailwind**: For unique styling, use Tailwind utility classes directly

3. **Responsive Design**: All custom components include responsive modifiers (`md:`, `lg:`, etc.)

4. **Hot Reload**: With `npm run dev` running, changes to your Blade files will auto-reload

## 🎨 Color Palette

Your Tailwind config has these custom colors:

-   Primary: `primary-500` (#0F4A6A)
-   Secondary: `secondary-500` (#2D6B69)
-   Accent: `accent-500` (#F59E0B)
-   Slate: `slate-50` to `slate-900`

Use them like:

```html
<div class="bg-primary-500 text-white">...</div>
<button class="bg-accent-500 hover:bg-accent-600">...</button>
```

## 📦 Custom Components Available

All these are defined in `resources/css/app.css`:

**Buttons:**

-   `.btn-primary` - Blue button
-   `.btn-secondary` - Emerald button
-   `.btn-outline` - Outline button
-   `.btn-danger` - Red button

**Forms:**

-   `.form-input` - Text input
-   `.form-label` - Label
-   `.form-error` - Error message
-   `.form-select` - Select dropdown

**Cards:**

-   `.card` - Basic card
-   `.card-header` - Card header
-   `.card-body` - Card body
-   `.card-footer` - Card footer

**Medical Specific:**

-   `.therapy-card` - Therapy session card
-   `.doctor-card` - Doctor profile card
-   `.booking-status` - Status badge
-   `.status-pending` - Yellow status
-   `.status-confirmed` - Green status
-   `.status-cancelled` - Red status
-   `.status-completed` - Blue status

**Admin Pages:**

-   `.admin-page-container` - Main container
-   `.page-header` - Page header
-   `.page-title` - Page title
-   `.page-subtitle` - Page subtitle
-   `.stats-grid` - Statistics grid
-   `.stat-card` - Stat card
-   `.table-section` - Table wrapper
-   `.modern-table` - Table styling
-   `.action-buttons` - Action button group
-   `.add-btn` - Add new button
-   `.search-container` - Search input wrapper

## 🔄 Next Steps

1. ✅ Run `npm run dev` in terminal
2. ✅ Update one page at a time (start with doctor pages)
3. ✅ Test each page after conversion
4. ✅ Remove old CSS files once conversion is complete

## 📂 Files to Delete Later

Once all pages are converted, you can delete these CSS files:

-   `public/assets/css/admin/admin-core.css`
-   `public/assets/css/admin/admin-components.css`
-   `public/assets/css/admin/admin-layout.css`
-   `public/assets/css/admin/admin-pages.css`
-   `public/assets/css/admin/admin-responsive.css`
-   `public/assets/css/admin/admin-pages-unified.css`
-   `public/assets/css/admin/patient-management.css`
-   `public/assets/css/admin/doctor-management-page.css`
-   `public/assets/css/admin/blog-management-page.css`
-   `public/assets/css/admin/therapy-management-page.css`
-   `public/assets/css/admin/feedback-management-page.css`
-   `public/assets/css/admin/feedback-list-page.css`
-   `public/assets/css/admin/appointment-management-page.css`

---

**Need Help?** The custom components in `app.css` match your old CSS exactly, so pages should look the same! Just swap the class names.
