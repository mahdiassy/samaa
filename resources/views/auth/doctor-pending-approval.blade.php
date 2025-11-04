<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}" dir="{{ app()->getLocale() == 'ar' ? 'rtl' : 'ltr' }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('site.Pending Approval') }} - {{ config('app.name') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gradient-to-br from-slate-900 via-blue-900 to-slate-900 min-h-screen flex items-center justify-center p-4">
    <div class="max-w-2xl w-full">
        <!-- Card -->
        <div class="bg-white/10 backdrop-blur-lg rounded-2xl shadow-2xl border border-white/20 overflow-hidden">
            <!-- Header Section -->
            <div class="bg-gradient-to-r from-blue-600 to-cyan-500 p-8 text-center">
                <div class="inline-flex items-center justify-center w-20 h-20 bg-white/20 rounded-full mb-4 backdrop-blur-sm">
                    <i class="fas fa-clock text-4xl text-white"></i>
                </div>
                <h1 class="text-3xl font-bold text-white mb-2">
                    {{ __('site.Registration Successful') }}
                </h1>
                <p class="text-blue-100 text-lg">
                    {{ __('site.Your application is under review') }}
                </p>
            </div>

            <!-- Content Section -->
            <div class="p-8">
                @if(session('status'))
                    <div class="mb-6 p-4 rounded-lg {{ session('status')['type'] === 'success' ? 'bg-green-500/20 border border-green-500/30' : 'bg-red-500/20 border border-red-500/30' }}">
                        <div class="flex items-start gap-3">
                            <i class="fas {{ session('status')['type'] === 'success' ? 'fa-check-circle text-green-400' : 'fa-exclamation-circle text-red-400' }} text-xl mt-0.5"></i>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-1">
                                    {{ session('status')['title'] }}
                                </h3>
                                <p class="text-slate-200">
                                    {{ session('status')['msg'] }}
                                </p>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Information Cards -->
                <div class="space-y-4 mb-8">
                    <div class="bg-white/5 rounded-lg p-6 border border-white/10">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-blue-500/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-user-check text-blue-400 text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-2">
                                    {{ __('site.What happens next?') }}
                                </h3>
                                <p class="text-slate-300 leading-relaxed">
                                    {{ __('site.Our admin team will review your application and verify your credentials. This process typically takes 24-48 hours.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/5 rounded-lg p-6 border border-white/10">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-cyan-500/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-envelope text-cyan-400 text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-2">
                                    {{ __('site.Email Notification') }}
                                </h3>
                                <p class="text-slate-300 leading-relaxed">
                                    {{ __('site.You will receive an email notification once your account has been approved. Please check your inbox regularly.') }}
                                </p>
                            </div>
                        </div>
                    </div>

                    <div class="bg-white/5 rounded-lg p-6 border border-white/10">
                        <div class="flex items-start gap-4">
                            <div class="flex-shrink-0">
                                <div class="w-12 h-12 bg-purple-500/20 rounded-lg flex items-center justify-center">
                                    <i class="fas fa-lock text-purple-400 text-xl"></i>
                                </div>
                            </div>
                            <div>
                                <h3 class="text-lg font-semibold text-white mb-2">
                                    {{ __('site.Account Security') }}
                                </h3>
                                <p class="text-slate-300 leading-relaxed">
                                    {{ __('site.Your account credentials are secure. You will be able to login once your application is approved.') }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="flex flex-col sm:flex-row gap-4">
                    <a href="{{ route('home') }}" 
                       class="flex-1 px-6 py-3 bg-gradient-to-r from-blue-600 to-cyan-500 text-white rounded-lg font-semibold hover:from-blue-700 hover:to-cyan-600 transition-all duration-300 text-center shadow-lg hover:shadow-xl">
                        <i class="fas fa-home {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                        {{ __('site.Return to Home') }}
                    </a>
                    <a href="{{ route('login') }}" 
                       class="flex-1 px-6 py-3 bg-white/10 text-white rounded-lg font-semibold hover:bg-white/20 transition-all duration-300 text-center border border-white/20">
                        <i class="fas fa-sign-in-alt {{ app()->getLocale() == 'ar' ? 'ml-2' : 'mr-2' }}"></i>
                        {{ __('site.Go to Login') }}
                    </a>
                </div>

                <!-- Support Text -->
                <div class="mt-8 text-center">
                    <p class="text-slate-400 text-sm">
                        {{ __('site.Need help? Contact us at') }} 
                        <a href="mailto:support@example.com" class="text-blue-400 hover:text-blue-300 underline">
                            support@example.com
                        </a>
                    </p>
                </div>
            </div>
        </div>

        <!-- Footer Note -->
        <div class="text-center mt-6">
            <p class="text-slate-400 text-sm">
                <i class="fas fa-shield-alt {{ app()->getLocale() == 'ar' ? 'ml-1' : 'mr-1' }}"></i>
                {{ __('site.Your information is secure and will be handled according to our privacy policy') }}
            </p>
        </div>
    </div>
</body>
</html>
