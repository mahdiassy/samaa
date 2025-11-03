@extends('layouts.base')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-slate-50 via-blue-50 to-emerald-50">
    <div class="container mx-auto px-6 py-12">
        <!-- Page Header -->
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-serif font-bold text-gradient mb-4">
                Medical Dashboard
            </h1>
            <p class="text-xl text-gray-600">
                Complete medical platform interface using Tailwind components
            </p>
        </div>

        <!-- Medical Stats -->
        @include('components.medical', [
            'stats' => [
                [
                    'label' => 'Total Patients',
                    'value' => '1,234',
                    'change' => '+12%',
                    'color' => 'primary',
                    'icon' => 'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'
                ],
                [
                    'label' => 'Active Therapies',
                    'value' => '89',
                    'change' => '+8%',
                    'color' => 'emerald',
                    'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z'
                ],
                [
                    'label' => 'Appointments',
                    'value' => '45',
                    'change' => '+5%',
                    'color' => 'blue',
                    'icon' => 'M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z'
                ],
                [
                    'label' => 'Success Rate',
                    'value' => '94%',
                    'change' => '+2%',
                    'color' => 'green',
                    'icon' => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z'
                ]
            ]
        ])

        <!-- Navigation Menu -->
        @include('components.medical', [
            'navigation' => [
                ['label' => 'Dashboard', 'url' => '#', 'active' => true, 'icon' => 'M3 13h8V3H3v10zm0 8h8v-6H3v6zm10 0h8V11h-8v10zm0-18v6h8V3h-8z'],
                ['label' => 'Patients', 'url' => '#', 'icon' => 'M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z'],
                ['label' => 'Therapies', 'url' => '#', 'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z'],
                ['label' => 'Appointments', 'url' => '#', 'icon' => 'M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z'],
                ['label' => 'Reports', 'url' => '#', 'icon' => 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z']
            ]
        ])

        <!-- Content Grid -->
        <div class="grid lg:grid-cols-3 gap-8">
            <!-- Main Content -->
            <div class="lg:col-span-2 space-y-8">
                <!-- Recent Therapy Sessions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-800">Recent Therapy Sessions</h3>
                    </div>
                    <div class="card-body">
                        <div class="grid md:grid-cols-2 gap-6">
                            @include('components.medical', [
                                'therapy' => [
                                    'name' => 'Relaxation Therapy',
                                    'description' => 'Calming sounds for stress relief and meditation',
                                    'image' => asset('assets/images/therapy-placeholder.jpg'),
                                    'therapist' => 'Dr. Sarah Wilson',
                                    'duration' => '45 min',
                                    'status' => 'confirmed',
                                    'info' => '24 sessions completed',
                                    'actions' => [
                                        ['label' => 'Start Session', 'url' => '#', 'style' => 'btn-primary'],
                                        ['label' => 'Details', 'url' => '#', 'style' => 'btn-outline']
                                    ]
                                ]
                            ])

                            @include('components.medical', [
                                'therapy' => [
                                    'name' => 'Anxiety Relief',
                                    'description' => 'Specialized audio therapy for anxiety management',
                                    'image' => asset('assets/images/therapy-placeholder.jpg'),
                                    'therapist' => 'Dr. Michael Chen',
                                    'duration' => '30 min',
                                    'status' => 'pending',
                                    'info' => '12 sessions completed',
                                    'actions' => [
                                        ['label' => 'Continue', 'url' => '#', 'style' => 'btn-secondary']
                                    ]
                                ]
                            ])
                        </div>
                    </div>
                </div>

                <!-- Recent Appointments -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-800">Upcoming Appointments</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            @for($i = 1; $i <= 3; $i++)
                            <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg">
                                <div class="flex items-center gap-4">
                                    <div class="w-12 h-12 bg-primary-100 rounded-full flex items-center justify-center">
                                        <svg class="w-6 h-6 text-primary-600" fill="currentColor" viewBox="0 0 24 24">
                                            <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                                        </svg>
                                    </div>
                                    <div>
                                        <h4 class="font-medium text-gray-800">Patient Session {{ $i }}</h4>
                                        <p class="text-sm text-gray-600">{{ now()->addDays($i)->format('M d, Y') }} at {{ now()->addHours($i * 2)->format('h:i A') }}</p>
                                    </div>
                                </div>
                                <div class="flex items-center gap-2">
                                    @include('components.medical', ['status' => $i === 1 ? 'confirmed' : 'pending'])
                                    <button class="btn-outline">View</button>
                                </div>
                            </div>
                            @endfor
                        </div>
                    </div>
                </div>
            </div>

            <!-- Sidebar -->
            <div class="space-y-8">
                <!-- Doctor Profile -->
                @include('components.medical', [
                    'profile' => [
                        'name' => 'Dr. Sarah Wilson',
                        'role' => 'Clinical Psychologist',
                        'image' => asset('assets/images/doctor-placeholder.jpg'),
                        'rating' => 5,
                        'details' => [
                            ['text' => '15+ years experience', 'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z'],
                            ['text' => '127 reviews', 'icon' => 'M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z'],
                            ['text' => 'Available today', 'icon' => 'M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm-2 15l-5-5 1.41-1.41L10 14.17l7.59-7.59L19 8l-9 9z']
                        ],
                        'actions' => [
                            ['label' => 'Book Appointment', 'url' => '#', 'style' => 'btn-primary'],
                            ['label' => 'View Profile', 'url' => '#', 'style' => 'btn-outline']
                        ]
                    ]
                ])

                <!-- Quick Actions -->
                <div class="card">
                    <div class="card-header">
                        <h3 class="text-lg font-semibold text-gray-800">Quick Actions</h3>
                    </div>
                    <div class="card-body">
                        @include('components.medical', [
                            'actions' => [
                                ['label' => 'New Patient', 'url' => '#', 'style' => 'btn-primary w-full mb-3', 'icon' => 'M19 13h-6v6h-2v-6H5v-2h6V5h2v6h6v2z'],
                                ['label' => 'Schedule Appointment', 'url' => '#', 'style' => 'btn-secondary w-full mb-3', 'icon' => 'M19 3h-1V1h-2v2H8V1H6v2H5c-1.11 0-1.99.9-1.99 2L3 19c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm0 16H5V8h14v11zM7 10h5v5H7z'],
                                ['label' => 'Generate Report', 'url' => '#', 'style' => 'btn-outline w-full', 'icon' => 'M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zM9 17H7v-7h2v7zm4 0h-2V7h2v10zm4 0h-2v-4h2v4z']
                            ],
                            'actionsAlign' => 'justify-start'
                        ])
                    </div>
                </div>

                <!-- Progress Card -->
                <div class="card border-gradient">
                    <div class="card-header bg-gradient-samaa text-white">
                        <h3 class="text-lg font-semibold">Treatment Progress</h3>
                    </div>
                    <div class="card-body">
                        <div class="space-y-4">
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Stress Reduction</span>
                                <span class="text-2xl font-bold text-emerald-600">85%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-emerald-500 h-2 rounded-full" style="width: 85%"></div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Session Completion</span>
                                <span class="text-2xl font-bold text-blue-600">92%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-500 h-2 rounded-full" style="width: 92%"></div>
                            </div>
                            
                            <div class="flex items-center justify-between">
                                <span class="text-gray-600">Overall Wellness</span>
                                <span class="text-2xl font-bold text-primary-600">78%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-primary-500 h-2 rounded-full" style="width: 78%"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Sample Medical Form -->
        <div class="mt-12">
            @include('components.medical', [
                'formSteps' => [
                    ['label' => 'Personal Info', 'completed' => true],
                    ['label' => 'Medical History', 'active' => true],
                    ['label' => 'Treatment Plan', 'completed' => false],
                    ['label' => 'Review', 'completed' => false]
                ]
            ])
            
            <div class="mt-6 grid md:grid-cols-2 gap-6">
                @include('components.medical', [
                    'inputType' => 'text',
                    'name' => 'patient_name',
                    'label' => 'Patient Name',
                    'placeholder' => 'Enter patient full name',
                    'required' => true
                ])

                @include('components.medical', [
                    'inputType' => 'select',
                    'name' => 'condition',
                    'label' => 'Primary Condition',
                    'placeholder' => 'Select condition',
                    'options' => [
                        'anxiety' => 'Anxiety Disorder',
                        'depression' => 'Depression',
                        'stress' => 'Chronic Stress',
                        'insomnia' => 'Sleep Disorders'
                    ],
                    'required' => true
                ])
            </div>
        </div>

        <!-- Footer -->
        <div class="text-center mt-12 pt-8 border-t border-gray-200">
            <p class="text-gray-600">
                ✅ <strong>Phase 13 Complete:</strong> Medical Platform with Complete Tailwind Components
            </p>
            <p class="text-sm text-gray-500 mt-2">
                All components are responsive, accessible, and optimized for medical workflows
            </p>
        </div>
    </div>
</div>
@endsection