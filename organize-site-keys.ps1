# Script to analyze remaining keys in site.php and suggest organization structure
# This helps categorize the 229 remaining keys into logical groups

Write-Host "`n=== Analyzing Remaining Keys in site.php ===" -ForegroundColor Cyan

# Categories for organization
$categories = @{
    'navigation' = @('About Us', 'Contact Us', 'Login/Sign-up', 'Therapeutic Area', 'Help Center', 'How It Works')
    
    'auth_login_register' = @('Enter Your Password', 'Don???t have an account?', 'Already have an account?', 
                               'Choose Registration Type', 'Register as Patient', 'Register as Doctor',
                               'Successfully Logged-in', 'The email address is incorrect', 'Password is incorrect',
                               'Login failed due to unknown reason', 'This email is already registered.')
    
    'user_profile' = @('Personal Information', 'Full Name', 'Last Name', 'Language Spoken', 
                       'Please enter your First Name', 'Enter Your Name', 'Blood Type',
                       'Patient Gender', 'Smoker', 'Are You A Regular Smoker?')
    
    'medical_forms' = @('Medical History', 'Have you been diagnosed with any of the following mental health conditions?',
                        'Are you currently taking any medications for mental health conditions?',
                        'Please list the medications you are taking', 'Enter medication names', 'medication names',
                        'Have you experienced any of the following symptoms in the past 6 months?',
                        'Have you ever received therapy or counseling before?',
                        'Have you ever been diagnosed with any neurological conditions?',
                        'Do you have a history of substance use or addiction?',
                        'Have you experienced any major life events or traumas that may impact your mental health?',
                        'Do you have any chronic physical health conditions?',
                        'Select one or more diseases', 'Select all that apply', 'Please select',
                        'Psychological_diseases', 'Diseases')
    
    'password_management' = @('change password', 'Old Password', 'New Password', 'Confirm Password',
                              'Please enter your old password.', 'Please enter a new password.',
                              'Passwords do not match.', 'The old password is incorrect',
                              'Password updated successfully', 'Enter Your Registered Email Address')
    
    'homepage_content' = @('theme-message', 'Therapy With', 'Sama???a', 'Sama???a for kids',
                           'BECOME SPONSOR', 'Community Members', 'Patients', 'Participating Doctors',
                           'What our listeners say', 'Their experience throughout every platform',
                           'Our Doctors', 'NAAM Women???s Empowerment',
                           '80% better sleep quality reported by parents.',
                           '65% reduced anxiety/emotional outbursts.',
                           '70% improved sensory processing.')
    
    'contact_page' = @('Get In Touch', 'We???re Here to Help You Heal', 'contact-description',
                       'Let???s Start Your Journey', 'Phone Number', 'Email Address',
                       'Choose Subject', 'Your Message', 'How can we support your healing journey?',
                       'Follow SAMAA', 'Join Our Newsletter', 'Get free sound therapy tips and updates',
                       'Facebook link', 'Twitter link', 'Instagram link')
    
    'dashboard_general' = @('This is the Dashboard of the Samaa.', 'Actions', 'View', 'Edit', 'Go Back',
                            'Create', 'ID', 'date', 'Date', 'Created', 'Updated', 'Search',
                            'Add', 'Close', 'Save', 'Cancel', 'Delete', 'Note',
                            'Success', 'Error', 'OK', 'Successfully Added!')
    
    'patient_management' = @('Patient list', 'Add New Patient', 'Patient Name', 'Patient',
                             'Patient created successfully', 'Patient updated successfully',
                             'Patient Profile updated successfully', 'Patient deleted successfully',
                             'Patient Canceled successfully')
    
    'doctor_management' = @('Doctor list', 'Add New Doctor', 'doctor', 'Doctor Name', 'Specialization',
                            'Doctor Specialization', 'Host', 'follow me',
                            'Doctor created successfully', 'Doctor Profile updated successfully',
                            'Doctor updated successfully', 'Doctor deleted successfully',
                            'Doctor updated status successfully', 'Search doctors...', 'No results found')
    
    'booking_appointment' = @('Patients Booking', 'My Bookings', 'Book an appointment', 'Schedule Appointment',
                              'Booking Date', 'Booking Reason', 'Booking status', 'Booking with a doctor',
                              'Canceled', 'Reschedule appointment', 'Select Appointment - Week View',
                              'Select Appointment - Month View', 'Select Time', 'Select a time',
                              'Reason', 'Appointment Event', 'Delete Event',
                              'Are you sure you want to delete this event?',
                              'Pending', 'Approved', 'Canceled By Patient', 'reserved',
                              'Change Status', 'be Approved before',
                              'This time has been added successfully', 'This time has been predetermined',
                              'The appointment has been successfully deleted',
                              'You cannot delete it. It has already been booked',
                              'The appointment has been booked successfully, If you want to check your reservation, click (go back)')
    
    'availability_schedule' = @('Available (Preview)', 'Available', 'From', 'To',
                                'prev', 'today', '1_day_ago', 'x_days_ago',
                                'week', 'month', 'day', 'list', 'AM', 'PM')
    
    'therapy_music' = @('therapy list', 'My Playlist', 'start your music therapy', 'start your',
                        'All Therapies', 'Add Therapy', 'Therapy Created successfully',
                        'Therapy deleted successfully', 'Therapy Updated successfully',
                        'Control_patient', 'Songs', 'Albums', 'Play', 'Pause', 'Change_track',
                        'INITIALIZING MUSIC PLAYER', 'All the songs', 'Search or Create Album',
                        'Samaa Music Player', 'Session Chat', 'Start Call', 'End Call',
                        'Type your message here')
    
    'file_upload' = @('Set the Therapy thumbnail image. Only *.png, *.jpg, and *.jpeg image files are accepted',
                      'File Name', 'Upload File', 'Edit Audio (optional)', 'Old Audio',
                      'Set the Blog thumbnail image. Only *.png, *.jpg, and *.jpeg image files are accepted')
    
    'feedback_management' = @('Feedback list', 'Add Feedback', 'Improvement', 'Submit Feedback',
                              'Feedback created successfully', 'Feedback deleted successfully',
                              'User', 'User Name', 'User not found')
    
    'blog_management' = @('Blog created successfully', 'Blog updated successfully', 'Blog deleted successfully',
                          'Blog list', 'Add New Blog', 'posted Date', 'Posted on',
                          'related Post', 'blogs')
    
    'validation_messages' = @('The email address is already in use by another user',
                              'This email is associated with another account.',
                              'The email already exists. Please log in to submit feedback.',
                              'Please enter your Email Address')
    
    'misc_content' = @('Lorem ipsum dolor sit amet, consectetur adipiscing elit, eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam???quis.',
                       'K', 'Terms & Conditions',
                       'Copyright ?? 2022 Pharma Co. All rights reserved.',
                       'Create by Admin, No Patient Available')
}

# Count keys by category
Write-Host "`n=== SUGGESTED ORGANIZATION STRUCTURE ===" -ForegroundColor Cyan
$totalCategorized = 0

foreach ($category in $categories.Keys | Sort-Object) {
    $count = $categories[$category].Count
    $totalCategorized += $count
    Write-Host "`n$category.php ($count keys):" -ForegroundColor Magenta
    $categories[$category] | Sort-Object | ForEach-Object {
        Write-Host "  - $_" -ForegroundColor Gray
    }
}

Write-Host "`n=== SUMMARY ===" -ForegroundColor Cyan
Write-Host "Total keys categorized: $totalCategorized" -ForegroundColor Green
Write-Host "Original remaining keys: 229" -ForegroundColor Yellow
Write-Host "`nSuggested new file structure under lang/en/:" -ForegroundColor Cyan

$categories.Keys | Sort-Object | ForEach-Object {
    Write-Host "  - pages/$_.php" -ForegroundColor White
}

Write-Host "`n=== RECOMMENDED ACTIONS ===" -ForegroundColor Cyan
Write-Host "1. Create new organized files in lang/en/pages/ directory" -ForegroundColor White
Write-Host "2. Move keys from site.php to appropriate files" -ForegroundColor White
Write-Host "3. Update Blade templates to use new translation paths" -ForegroundColor White
Write-Host "   Example: __('site.patient_list') -> __('pages.patient_management.patient_list')" -ForegroundColor Gray
Write-Host "4. Remove duplicate keys from site.php (60 keys)" -ForegroundColor White
Write-Host "5. Keep site.php for truly global/common translations only" -ForegroundColor White

Write-Host "`nScript completed!`n" -ForegroundColor Green
