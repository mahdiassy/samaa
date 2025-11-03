{{-- 
    SAMAA Medical Platform - Tailwind Components Library
    Reusable Tailwind components for consistent medical UI
--}}

{{-- Medical Card Component --}}
@php
    $cardClasses = match($type ?? 'default') {
        'therapy' => 'therapy-card',
        'doctor' => 'doctor-card', 
        'patient' => 'bg-white rounded-xl shadow-lg border border-gray-100 p-6 hover:shadow-xl transition-shadow duration-300',
        'appointment' => 'bg-white rounded-xl shadow-lg border border-emerald-100 p-6 hover:shadow-xl transition-shadow duration-300',
        'stats' => 'bg-gradient-to-br from-primary-500 to-primary-600 text-white rounded-xl shadow-lg p-6',
        default => 'card'
    };
@endphp

{{-- Booking Status Badge --}}
@if(isset($status))
    @php
        $statusClasses = match($status) {
            'pending' => 'booking-status status-pending',
            'confirmed' => 'booking-status status-confirmed',
            'completed' => 'booking-status status-completed', 
            'cancelled' => 'booking-status status-cancelled',
            default => 'booking-status'
        };
    @endphp
    <span class="{{ $statusClasses }}">{{ ucfirst($status) }}</span>
@endif

{{-- Medical Form Input --}}
@if(isset($inputType))
    <div class="mb-4">
        <label class="form-label">{{ $label ?? '' }}</label>
        @if($inputType === 'select')
            <select name="{{ $name ?? '' }}" class="form-select {{ $required ?? false ? 'required' : '' }}">
                <option value="">{{ $placeholder ?? 'Select option' }}</option>
                @if(isset($options))
                    @foreach($options as $value => $text)
                        <option value="{{ $value }}">{{ $text }}</option>
                    @endforeach
                @endif
            </select>
        @elseif($inputType === 'textarea')
            <textarea name="{{ $name ?? '' }}" 
                      class="form-input {{ $required ?? false ? 'required' : '' }}" 
                      placeholder="{{ $placeholder ?? '' }}"
                      rows="{{ $rows ?? 4 }}"></textarea>
        @else
            <input type="{{ $inputType }}" 
                   name="{{ $name ?? '' }}" 
                   class="form-input {{ $required ?? false ? 'required' : '' }}" 
                   placeholder="{{ $placeholder ?? '' }}"
                   {{ $required ?? false ? 'required' : '' }}>
        @endif
        @if(isset($error))
            <div class="form-error">{{ $error }}</div>
        @endif
    </div>
@endif

{{-- Medical Navigation Menu --}}
@if(isset($navigation))
    <nav class="bg-white shadow-lg rounded-xl p-4 mb-6">
        <div class="flex flex-wrap gap-2">
            @foreach($navigation as $item)
                <a href="{{ $item['url'] }}" 
                   class="{{ $item['active'] ?? false ? 'nav-link-active' : 'nav-link' }}">
                    @if(isset($item['icon']))
                        <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                            <path d="{{ $item['icon'] }}"/>
                        </svg>
                    @endif
                    {{ $item['label'] }}
                </a>
            @endforeach
        </div>
    </nav>
@endif

{{-- Medical Stats Card --}}
@if(isset($stats))
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
        @foreach($stats as $stat)
            <div class="bg-gradient-to-br from-{{ $stat['color'] ?? 'primary' }}-500 to-{{ $stat['color'] ?? 'primary' }}-600 text-white rounded-xl shadow-lg p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <p class="text-{{ $stat['color'] ?? 'primary' }}-100 text-sm">{{ $stat['label'] }}</p>
                        <p class="text-3xl font-bold">{{ $stat['value'] }}</p>
                        @if(isset($stat['change']))
                            <p class="text-{{ $stat['color'] ?? 'primary' }}-100 text-xs">
                                {{ $stat['change'] }} from last month
                            </p>
                        @endif
                    </div>
                    @if(isset($stat['icon']))
                        <div class="w-12 h-12 bg-white/20 rounded-lg flex items-center justify-center">
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="{{ $stat['icon'] }}"/>
                            </svg>
                        </div>
                    @endif
                </div>
            </div>
        @endforeach
    </div>
@endif

{{-- Medical Action Buttons --}}
@if(isset($actions))
    <div class="flex flex-wrap gap-3 {{ $actionsAlign ?? 'justify-start' }}">
        @foreach($actions as $action)
            <a href="{{ $action['url'] }}" 
               class="{{ $action['style'] ?? 'btn-primary' }} {{ $action['size'] ?? '' }}">
                @if(isset($action['icon']))
                    <svg class="w-4 h-4 mr-2" fill="currentColor" viewBox="0 0 24 24">
                        <path d="{{ $action['icon'] }}"/>
                    </svg>
                @endif
                {{ $action['label'] }}
            </a>
        @endforeach
    </div>
@endif

{{-- Patient/Doctor Profile Card --}}
@if(isset($profile))
    <div class="doctor-card">
        <div class="flex items-center gap-4 mb-4">
            <img src="{{ $profile['image'] ?? asset('assets/images/default-avatar.jpg') }}" 
                 alt="{{ $profile['name'] }}" 
                 class="w-16 h-16 rounded-full object-cover">
            <div class="flex-1">
                <h3 class="text-lg font-semibold text-gray-800">{{ $profile['name'] }}</h3>
                <p class="text-primary-600">{{ $profile['role'] ?? $profile['specialization'] ?? '' }}</p>
                @if(isset($profile['rating']))
                    <div class="flex items-center gap-1 mt-1">
                        @for($i = 1; $i <= 5; $i++)
                            <svg class="w-4 h-4 {{ $i <= $profile['rating'] ? 'text-yellow-400' : 'text-gray-300' }}" 
                                 fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/>
                            </svg>
                        @endfor
                        <span class="text-sm text-gray-600 ml-1">{{ $profile['rating'] }}/5</span>
                    </div>
                @endif
            </div>
        </div>
        
        @if(isset($profile['details']))
            <div class="space-y-2 mb-4">
                @foreach($profile['details'] as $detail)
                    <div class="flex items-center gap-2 text-sm text-gray-600">
                        @if(isset($detail['icon']))
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="{{ $detail['icon'] }}"/>
                            </svg>
                        @endif
                        <span>{{ $detail['text'] }}</span>
                    </div>
                @endforeach
            </div>
        @endif
        
        @if(isset($profile['actions']))
            <div class="flex gap-2">
                @foreach($profile['actions'] as $action)
                    <a href="{{ $action['url'] }}" class="{{ $action['style'] ?? 'btn-primary' }}">
                        {{ $action['label'] }}
                    </a>
                @endforeach
            </div>
        @endif
    </div>
@endif

{{-- Therapy Session Card --}}
@if(isset($therapy))
    <div class="therapy-card">
        @if(isset($therapy['image']))
            <div class="relative">
                <img src="{{ $therapy['image'] }}" alt="{{ $therapy['name'] }}" class="w-full h-48 object-cover">
                @if(isset($therapy['status']))
                    <div class="absolute top-4 right-4">
                        @include('components.medical', ['status' => $therapy['status']])
                    </div>
                @endif
                @if(isset($therapy['duration']))
                    <div class="absolute bottom-4 left-4 bg-black/50 text-white px-3 py-1 rounded-full text-sm">
                        {{ $therapy['duration'] }}
                    </div>
                @endif
            </div>
        @endif
        
        <div class="p-6">
            <h3 class="text-xl font-semibold text-gray-800 mb-2">{{ $therapy['name'] }}</h3>
            @if(isset($therapy['description']))
                <p class="text-gray-600 mb-4">{{ $therapy['description'] }}</p>
            @endif
            
            @if(isset($therapy['therapist']))
                <div class="flex items-center gap-2 mb-4 text-sm text-gray-600">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                    </svg>
                    <span>{{ $therapy['therapist'] }}</span>
                </div>
            @endif
            
            @if(isset($therapy['actions']))
                <div class="flex items-center justify-between">
                    @if(isset($therapy['info']))
                        <span class="text-sm text-gray-500">{{ $therapy['info'] }}</span>
                    @endif
                    <div class="flex gap-2">
                        @foreach($therapy['actions'] as $action)
                            <a href="{{ $action['url'] }}" class="{{ $action['style'] ?? 'btn-primary' }}">
                                {{ $action['label'] }}
                            </a>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
@endif

{{-- Medical Form with Steps --}}
@if(isset($formSteps))
    <div class="bg-white rounded-xl shadow-lg p-6">
        {{-- Step Indicator --}}
        <div class="flex items-center justify-between mb-8">
            @foreach($formSteps as $index => $step)
                <div class="flex items-center {{ $index < count($formSteps) - 1 ? 'flex-1' : '' }}">
                    <div class="flex items-center justify-center w-8 h-8 rounded-full 
                                {{ ($step['active'] ?? false) ? 'bg-primary-500 text-white' : 
                                   ($step['completed'] ?? false) ? 'bg-green-500 text-white' : 'bg-gray-200 text-gray-600' }}">
                        @if($step['completed'] ?? false)
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M9 16.17L4.83 12l-1.42 1.41L9 19 21 7l-1.41-1.41z"/>
                            </svg>
                        @else
                            {{ $index + 1 }}
                        @endif
                    </div>
                    <span class="ml-2 text-sm font-medium {{ ($step['active'] ?? false) ? 'text-primary-600' : 'text-gray-600' }}">
                        {{ $step['label'] }}
                    </span>
                    @if($index < count($formSteps) - 1)
                        <div class="flex-1 h-0.5 bg-gray-200 mx-4"></div>
                    @endif
                </div>
            @endforeach
        </div>
        
        {{-- Form Content --}}
        {{ $slot ?? '' }}
    </div>
@endif