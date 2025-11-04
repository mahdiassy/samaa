<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ __('site.Samaa Music Player') }}</title>
    <link rel="icon" href="{{ asset('assets/images/favicon.png') }}" type="image/x-icon">

    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="stylesheet" href="{{ asset('assets/css/music.css') }}">
    <link rel="stylesheet" href="{{ asset('assets/css/music2.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    
    <style>
        /* Custom gradient background */
        body {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 25%, #f093fb 50%, #4facfe 75%, #00f2fe 100%);
            background-size: 400% 400%;
            animation: gradientShift 15s ease infinite;
        }

        @keyframes gradientShift {
            0% { background-position: 0% 50%; }
            50% { background-position: 100% 50%; }
            100% { background-position: 0% 50%; }
        }

        /* Floating particles animation */
        .particle {
            position: fixed;
            width: 3px;
            height: 3px;
            background: rgba(255, 255, 255, 0.5);
            border-radius: 50%;
            pointer-events: none;
            animation: float 20s infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0) translateX(0); opacity: 0; }
            10% { opacity: 1; }
            90% { opacity: 1; }
            100% { transform: translateY(-100vh) translateX(100px); opacity: 0; }
        }
    </style>
</head>

<body class="min-h-screen overflow-hidden relative">

    <!-- Floating Particles -->
    <div id="particles"></div>

    <!-- Main Container -->
    <div class="relative z-10 h-screen flex flex-col">
        
        <!-- Elegant Header -->
        <header class="bg-white/10 backdrop-blur-xl border-b border-white/20 shadow-2xl">
            <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between h-20">
                    
                    <!-- Left: Branding -->
                    <div class="flex items-center gap-4">
                        <div class="relative">
                            <div class="w-14 h-14 bg-gradient-to-br from-pink-400 via-purple-400 to-indigo-400 rounded-2xl flex items-center justify-center shadow-xl transform hover:scale-110 transition-transform duration-300">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                                </svg>
                            </div>
                            <div class="absolute -top-1 -right-1 w-4 h-4 bg-green-400 rounded-full border-2 border-white animate-pulse"></div>
                        </div>
                        <div>
                            <h1 class="text-2xl font-bold text-white drop-shadow-lg">{{ __('site.Samaa Music Player') }}</h1>
                            <p class="text-sm text-white/80 font-medium">Therapeutic Music Experience</p>
                        </div>
                    </div>

                    <!-- Center: Session Info -->
                    <div class="hidden md:flex items-center gap-6">
                        <div class="bg-white/20 backdrop-blur-lg rounded-full px-6 py-2.5 flex items-center gap-3 border border-white/30 shadow-lg">
                            <div class="flex items-center gap-2">
                                <div class="w-2.5 h-2.5 bg-green-400 rounded-full animate-pulse shadow-lg shadow-green-400/50"></div>
                                <span class="text-white font-semibold text-sm">Live Session</span>
                            </div>
                            <div class="w-px h-5 bg-white/30"></div>
                            <div class="text-white/90 text-sm font-medium" id="sessionTimer">00:00</div>
                        </div>
                    </div>

                    <!-- Right: Controls -->
                    <div class="flex items-center gap-3">
                        
                        <!-- Volume Control -->
                        <button class="hidden lg:flex items-center justify-center w-11 h-11 bg-white/20 hover:bg-white/30 backdrop-blur-lg rounded-xl transition-all duration-200 border border-white/30 shadow-lg group">
                            <svg class="w-5 h-5 text-white group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M3 9v6h4l5 5V4L7 9H3zm13.5 3c0-1.77-1.02-3.29-2.5-4.03v8.05c1.48-.73 2.5-2.25 2.5-4.02z"/>
                            </svg>
                        </button>

                        <!-- Start Call Button -->
                        <button id="startCallButton" class="flex items-center gap-2.5 bg-gradient-to-r from-green-400 to-emerald-500 hover:from-green-500 hover:to-emerald-600 text-white px-6 py-3 rounded-xl font-bold transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 border border-green-300/50">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20.01 15.38c-1.23 0-2.42-.2-3.53-.56-.35-.12-.74-.03-1.01.24l-1.57 1.97c-2.83-1.35-5.48-3.9-6.89-6.83l1.95-1.66c.27-.28.35-.67.24-1.02-.37-1.11-.56-2.3-.56-3.53 0-.54-.45-.99-.99-.99H4.19C3.65 3 3 3.24 3 3.99 3 13.28 10.73 21 20.01 21c.71 0 .99-.63.99-1.18v-3.45c0-.54-.45-.99-.99-.99z"/>
                            </svg>
                            <span class="hidden sm:inline">Start Call</span>
                        </button>

                        <!-- End Call Button -->
                        <button id="endCallButton" onclick="endCall()" class="hidden items-center gap-2.5 bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white px-6 py-3 rounded-xl font-bold transition-all duration-300 shadow-xl hover:shadow-2xl border border-red-300/50 animate-pulse">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 9c-1.6 0-3.15.25-4.6.72v3.1c0 .39-.23.74-.56.9-.98.49-1.87 1.12-2.66 1.85-.18.18-.43.28-.7.28-.28 0-.53-.11-.71-.29L.29 13.08c-.18-.17-.29-.42-.29-.7 0-.28.11-.53.29-.71C3.34 8.78 7.46 7 12 7s8.66 1.78 11.71 4.67c.18.18.29.43.29.71 0 .28-.11.53-.29.71l-2.48 2.48c-.18.18-.43.29-.71.29-.27 0-.52-.11-.7-.28-.79-.74-1.69-1.36-2.67-1.85-.33-.16-.56-.5-.56-.9v-3.1C15.15 9.25 13.6 9 12 9z"/>
                            </svg>
                            <span class="hidden sm:inline">End Call</span>
                        </button>

                        <!-- Chat Toggle -->
                        <button id="chatToggleBtn" class="lg:hidden flex items-center justify-center w-11 h-11 bg-white/20 hover:bg-white/30 backdrop-blur-lg rounded-xl transition-all duration-200 border border-white/30 shadow-lg relative group">
                            <svg class="w-5 h-5 text-white group-hover:scale-110 transition-transform" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                            </svg>
                            <span id="unreadBadge" class="absolute -top-1 -right-1 w-5 h-5 bg-red-500 text-white text-xs font-bold rounded-full hidden items-center justify-center border-2 border-white">0</span>
                        </button>
                    </div>
                </div>
            </div>
        </header>

        <!-- Main Content -->
        <div class="flex-1 flex overflow-hidden">
            
            <!-- Music Player Section -->
            <div class="flex-1 relative overflow-hidden">
                <!-- Music Player Container -->
                <div id="smp_container" class="smp absolute inset-0"></div>
                
                <!-- Overlay Controls -->
                <div class="absolute bottom-8 left-8 right-8 lg:right-auto lg:w-96">
                    <div class="bg-white/10 backdrop-blur-2xl rounded-3xl p-6 border border-white/20 shadow-2xl">
                        <div class="flex items-center gap-4 mb-4">
                            <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-pink-400 rounded-2xl flex items-center justify-center shadow-xl">
                                <svg class="w-8 h-8 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M12 3v10.55c-.59-.34-1.27-.55-2-.55-2.21 0-4 1.79-4 4s1.79 4 4 4 4-1.79 4-4V7h4V3h-6z"/>
                                </svg>
                            </div>
                            <div class="flex-1">
                                <h3 class="text-white font-bold text-lg">Now Playing</h3>
                                <p class="text-white/70 text-sm">Therapy Session Mix</p>
                            </div>
                        </div>
                        <div class="space-y-2">
                            <div class="flex items-center gap-2 text-white/80 text-sm">
                                <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M19 3H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 3c1.93 0 3.5 1.57 3.5 3.5S13.93 13 12 13s-3.5-1.57-3.5-3.5S10.07 6 12 6zm7 13H5v-.23c0-.62.28-1.2.76-1.58C7.47 15.82 9.64 15 12 15s4.53.82 6.24 2.19c.48.38.76.97.76 1.58V19z"/>
                                </svg>
                                <span>Curated for your wellness</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Chat Sidebar -->
            <aside id="chatSidebar" class="w-full lg:w-[28rem] bg-white/95 backdrop-blur-xl flex flex-col shadow-2xl lg:relative fixed inset-0 z-50 lg:z-auto lg:translate-x-0 translate-x-full transition-transform duration-500 ease-out border-l border-white/20">
                
                <!-- Chat Header -->
                <div class="bg-gradient-to-r from-purple-500 via-pink-500 to-rose-500 p-6 relative overflow-hidden">
                    <!-- Decorative circles -->
                    <div class="absolute top-0 right-0 w-40 h-40 bg-white/10 rounded-full -mr-20 -mt-20"></div>
                    <div class="absolute bottom-0 left-0 w-32 h-32 bg-white/10 rounded-full -ml-16 -mb-16"></div>
                    
                    <div class="relative flex items-center justify-between">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 bg-white/20 backdrop-blur-lg rounded-2xl flex items-center justify-center border border-white/30">
                                <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                    <path d="M20 2H4c-1.1 0-2 .9-2 2v18l4-4h14c1.1 0 2-.9 2-2V4c0-1.1-.9-2-2-2zm0 14H6l-2 2V4h16v12z"/>
                                </svg>
                            </div>
                            <div class="text-white">
                                <h3 class="font-bold text-lg">{{ __('site.Session Chat') }}</h3>
                                <p class="text-white/80 text-sm flex items-center gap-2">
                                    <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                                    Therapist online
                                </p>
                            </div>
                        </div>
                        
                        <!-- Close Button (Mobile) -->
                        <button id="closeChatBtn" class="lg:hidden w-10 h-10 flex items-center justify-center bg-white/20 hover:bg-white/30 backdrop-blur-lg rounded-xl transition-all duration-200 border border-white/30">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/>
                            </svg>
                        </button>
                    </div>
                </div>

                <!-- Quick Actions Bar -->
                <div class="px-4 py-3 bg-gradient-to-r from-purple-50 to-pink-50 border-b border-purple-100 flex items-center gap-2">
                    <button class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-purple-50 rounded-xl text-purple-600 font-medium text-sm transition-all duration-200 shadow-sm hover:shadow-md border border-purple-100">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 11H7v2h2v-2zm4 0h-2v2h2v-2zm4 0h-2v2h2v-2zm2-7h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V9h14v11z"/>
                        </svg>
                        <span>Schedule</span>
                    </button>
                    <button class="flex items-center gap-2 px-4 py-2 bg-white hover:bg-purple-50 rounded-xl text-purple-600 font-medium text-sm transition-all duration-200 shadow-sm hover:shadow-md border border-purple-100">
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M9 2v2H7c-1.1 0-2 .9-2 2v16c0 1.1.9 2 2 2h10c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2h-2V2H9zm3 13c-1.66 0-3-1.34-3-3s1.34-3 3-3 3 1.34 3 3-1.34 3-3 3z"/>
                        </svg>
                        <span>Notes</span>
                    </button>
                </div>

                <!-- Chat Messages -->
                <div id="chat-box" class="flex-1 p-6 overflow-y-auto bg-gradient-to-b from-white via-purple-50/30 to-pink-50/30 space-y-6">
                    
                    <!-- Welcome Card -->
                    <div class="bg-gradient-to-br from-purple-100 to-pink-100 rounded-3xl p-6 text-center border border-purple-200 shadow-lg">
                        <div class="w-20 h-20 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center mx-auto mb-4 shadow-xl">
                            <svg class="w-10 h-10 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2C6.48 2 2 6.48 2 12s4.48 10 10 10 10-4.48 10-10S17.52 2 12 2zm0 18c-4.41 0-8-3.59-8-8s3.59-8 8-8 8 3.59 8 8-3.59 8-8 8zm-1-13h2v6h-2zm0 8h2v2h-2z"/>
                            </svg>
                        </div>
                        <h4 class="text-purple-900 font-bold text-lg mb-2">Welcome to Your Session</h4>
                        <p class="text-purple-700 text-sm leading-relaxed">Your therapist is here to support you. Feel free to share your thoughts and feelings in this safe space.</p>
                    </div>

                    <!-- Sample Messages (will be replaced by real messages) -->
                    
                </div>

                <!-- Typing Indicator -->
                <div id="typingIndicator" class="hidden px-6 py-3 bg-purple-50/50 border-t border-purple-100">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-gradient-to-br from-purple-400 to-pink-400 rounded-full flex items-center justify-center flex-shrink-0">
                            <svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
                            </svg>
                        </div>
                        <div class="flex-1">
                            <div class="flex gap-1.5">
                                <div class="w-2.5 h-2.5 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0s"></div>
                                <div class="w-2.5 h-2.5 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
                                <div class="w-2.5 h-2.5 bg-purple-400 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
                            </div>
                            <p class="text-purple-600 text-xs font-medium mt-1">Therapist is typing...</p>
                        </div>
                    </div>
                </div>

                <!-- Chat Input -->
                <div class="bg-white border-t border-purple-100 p-4 shadow-lg">
                    <!-- Emoji/Attachment Bar -->
                    <div class="flex items-center gap-2 mb-3 pb-3 border-b border-purple-100">
                        <button class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-purple-100 text-purple-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8zm3.5-9c.83 0 1.5-.67 1.5-1.5S16.33 8 15.5 8 14 8.67 14 9.5s.67 1.5 1.5 1.5zm-7 0c.83 0 1.5-.67 1.5-1.5S9.33 8 8.5 8 7 8.67 7 9.5 7.67 11 8.5 11zm3.5 6.5c2.33 0 4.31-1.46 5.11-3.5H6.89c.8 2.04 2.78 3.5 5.11 3.5z"/>
                            </svg>
                        </button>
                        <button class="w-9 h-9 flex items-center justify-center rounded-xl hover:bg-purple-100 text-purple-600 transition-colors">
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M16.5 6v11.5c0 2.21-1.79 4-4 4s-4-1.79-4-4V5c0-1.38 1.12-2.5 2.5-2.5s2.5 1.12 2.5 2.5v10.5c0 .55-.45 1-1 1s-1-.45-1-1V6H10v9.5c0 1.38 1.12 2.5 2.5 2.5s2.5-1.12 2.5-2.5V5c0-2.21-1.79-4-4-4S7 2.79 7 5v12.5c0 3.04 2.46 5.5 5.5 5.5s5.5-2.46 5.5-5.5V6h-1.5z"/>
                            </svg>
                        </button>
                        <div class="flex-1"></div>
                        <span class="text-xs text-purple-400 font-medium">Shift + Enter for new line</span>
                    </div>

                    <!-- Message Input -->
                    <div class="flex items-end gap-3">
                        <textarea 
                            id="chat-message" 
                            rows="1"
                            class="flex-1 px-5 py-3.5 border-2 border-purple-200 focus:border-purple-400 rounded-2xl outline-none focus:ring-4 focus:ring-purple-100 text-sm resize-none transition-all duration-200 placeholder:text-purple-300"
                            placeholder="Type your message..."
                            onkeydown="if(event.key === 'Enter' && !event.shiftKey) { event.preventDefault(); sendMessage(); }"
                        ></textarea>
                        <button 
                            onclick="sendMessage()" 
                            class="w-14 h-14 flex items-center justify-center bg-gradient-to-r from-purple-500 to-pink-500 hover:from-purple-600 hover:to-pink-600 text-white rounded-2xl transition-all duration-300 shadow-xl hover:shadow-2xl transform hover:scale-105 flex-shrink-0"
                        >
                            <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M2.01 21L23 12 2.01 3 2 10l15 2-15 2z"/>
                            </svg>
                        </button>
                    </div>
                </div>
            </aside>
        </div>
    </div>

    <!-- Enhanced UI Scripts -->
    <script>
        // Generate floating particles
        function createParticles() {
            const particlesContainer = document.getElementById('particles');
            for (let i = 0; i < 50; i++) {
                const particle = document.createElement('div');
                particle.className = 'particle';
                particle.style.left = Math.random() * 100 + '%';
                particle.style.animationDelay = Math.random() * 20 + 's';
                particle.style.animationDuration = (15 + Math.random() * 10) + 's';
                particlesContainer.appendChild(particle);
            }
        }
        createParticles();

        // Session timer
        let sessionStartTime = Date.now();
        function updateSessionTimer() {
            const elapsed = Date.now() - sessionStartTime;
            const minutes = Math.floor(elapsed / 60000);
            const seconds = Math.floor((elapsed % 60000) / 1000);
            document.getElementById('sessionTimer').textContent = 
                `${String(minutes).padStart(2, '0')}:${String(seconds).padStart(2, '0')}`;
        }
        setInterval(updateSessionTimer, 1000);

        // Chat toggle for mobile
        document.getElementById('chatToggleBtn')?.addEventListener('click', function() {
            document.getElementById('chatSidebar').classList.remove('translate-x-full');
            // Reset unread badge
            const badge = document.getElementById('unreadBadge');
            badge.classList.add('hidden');
            badge.classList.remove('flex');
            badge.textContent = '0';
        });
        
        document.getElementById('closeChatBtn')?.addEventListener('click', function() {
            document.getElementById('chatSidebar').classList.add('translate-x-full');
        });

        // Auto-resize textarea with smooth transition
        const textarea = document.getElementById('chat-message');
        if (textarea) {
            textarea.addEventListener('input', function() {
                this.style.height = 'auto';
                this.style.height = Math.min(this.scrollHeight, 120) + 'px';
            });
        }

        // Show unread message badge
        let unreadCount = 0;
        function incrementUnreadBadge() {
            if (window.innerWidth < 1024 && document.getElementById('chatSidebar').classList.contains('translate-x-full')) {
                unreadCount++;
                const badge = document.getElementById('unreadBadge');
                badge.textContent = unreadCount;
                badge.classList.remove('hidden');
                badge.classList.add('flex');
            }
        }

        // Reset unread when chat opened
        document.getElementById('chatToggleBtn')?.addEventListener('click', function() {
            unreadCount = 0;
        });
    </script>
</body>


<script>
    let fetchTherapiesUrl = "{{ route('fetch-therapies') }}";
    let getpeaksTherapiesUrl = "{{ route('get-peaks') }}";
    let savepeaksTherapiesUrl = "{{ route('save-peaks') }}";

    function controlMusic(action, track = 'new_track.mp3') {
        fetch('/control-music', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                action: action,
                track: track
            })
        });
    }
</script>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/laravel-echo/dist/echo.iife.min.js"></script>
<script src="https://cdn.socket.io/4.0.1/socket.io.min.js"></script>

<script src="{{ asset('assets/js/music.js') }}"></script>
<script src="{{ asset('assets/js/music2.js') }}"></script>

<script>
    const Control_patient = @json(__('site.Control_patient'));
    const Search = @json(__('site.Search'));
    const Songs = @json(__('site.Songs'));
    const Albums = @json(__('site.Albums'));
    const Play = @json(__('site.Play'));
    const Pause = @json(__('site.Pause'));
    const Change_track = @json(__('site.Change_track'));
    const INITIALIZING = @json(__('site.INITIALIZING MUSIC PLAYER'));
    const All_the_songs = @json(__('site.All the songs'));
</script>

<script>
    const echo = new Echo({
        broadcaster: 'socket.io',
        host: "https://test.clingroup.net"
    });


    function controlMusic(action, track = '') {
        echo.connector.socket.emit('music-control', {
            action: action,
            track: track
        });
    }

    echo.channel('music-channel')
        .listen('MusicControlEvent', (e) => {
            const musicPlayer = document.getElementById('musicPlayer');
            const trackSource = document.getElementById('trackSource');

            if (e.action === 'start') {
                musicPlayer.play();
            } else if (e.action === 'pause') {
                musicPlayer.pause();
            } else if (e.action === 'change') {
                trackSource.src = e.track;
                musicPlayer.load();
                musicPlayer.play();
            }
        });


    function sendMessage() {
        const message = document.getElementById('chat-message').value;
        if (message.trim() !== '') {
            socket.emit('chat-message', message);
            document.getElementById('chat-message').value = '';
        }
    }

    socket.on('chat-message', (data) => {
        const isUserMessage = data.sender === socket.id;
        appendMessage(data.message, isUserMessage ? 'user' : 'other');
        if (!isUserMessage) {
            incrementUnreadBadge();
        }
    });

    function appendMessage(message, type) {
        const chatBox = document.getElementById('chat-box');
        
        // Remove welcome card if it exists
        const welcomeCard = chatBox.querySelector('.bg-gradient-to-br');
        if (welcomeCard && welcomeCard.classList.contains('from-purple-100')) {
            welcomeCard.remove();
        }
        
        // Create message container
        const messageContainer = document.createElement('div');
        messageContainer.className = 'flex items-end gap-3 ' + (type === 'user' ? 'flex-row-reverse' : 'flex-row');
        
        // Avatar
        const avatar = document.createElement('div');
        avatar.className = 'w-10 h-10 rounded-full flex items-center justify-center flex-shrink-0 shadow-lg';
        
        if (type === 'user') {
            avatar.className += ' bg-gradient-to-br from-blue-400 to-cyan-400';
            avatar.innerHTML = '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/></svg>';
        } else {
            avatar.className += ' bg-gradient-to-br from-purple-400 to-pink-400';
            avatar.innerHTML = '<svg class="w-5 h-5 text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19 3h-4.18C14.4 1.84 13.3 1 12 1c-1.3 0-2.4.84-2.82 2H5c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2V5c0-1.1-.9-2-2-2zm-7 0c.55 0 1 .45 1 1s-.45 1-1 1-1-.45-1-1 .45-1 1-1zm0 4c1.66 0 3 1.34 3 3s-1.34 3-3 3-3-1.34-3-3 1.34-3 3-3zm6 12H6v-1.4c0-2 4-3.1 6-3.1s6 1.1 6 3.1V19z"/></svg>';
        }
        
        // Message bubble wrapper
        const bubbleWrapper = document.createElement('div');
        bubbleWrapper.className = 'flex-1 max-w-[75%]';
        
        // Message bubble
        const messageElement = document.createElement('div');
        messageElement.className = 'rounded-3xl px-5 py-3.5 shadow-lg transition-all duration-200 hover:shadow-xl';
        
        if (type === 'user') {
            messageElement.className += ' bg-gradient-to-r from-blue-500 to-cyan-500 text-white ml-auto rounded-br-md';
        } else {
            messageElement.className += ' bg-white text-gray-800 border-2 border-purple-100 rounded-bl-md';
        }
        
        // Message text
        const textElement = document.createElement('p');
        textElement.className = 'text-sm leading-relaxed break-words mb-1.5';
        textElement.textContent = message;
        messageElement.appendChild(textElement);
        
        // Timestamp
        const timeElement = document.createElement('div');
        timeElement.className = 'flex items-center gap-1.5 ' + (type === 'user' ? 'justify-end' : 'justify-start');
        const now = new Date();
        timeElement.innerHTML = `
            <svg class="w-3.5 h-3.5 ${type === 'user' ? 'text-blue-100' : 'text-gray-400'}" fill="currentColor" viewBox="0 0 24 24">
                <path d="M11.99 2C6.47 2 2 6.48 2 12s4.47 10 9.99 10C17.52 22 22 17.52 22 12S17.52 2 11.99 2zM12 20c-4.42 0-8-3.58-8-8s3.58-8 8-8 8 3.58 8 8-3.58 8-8 8z"/>
                <path d="M12.5 7H11v6l5.25 3.15.75-1.23-4.5-2.67z"/>
            </svg>
            <span class="text-xs font-medium ${type === 'user' ? 'text-blue-100' : 'text-gray-500'}">
                ${now.toLocaleTimeString('en-US', { hour: '2-digit', minute: '2-digit' })}
            </span>
        `;
        messageElement.appendChild(timeElement);
        
        bubbleWrapper.appendChild(messageElement);
        messageContainer.appendChild(avatar);
        messageContainer.appendChild(bubbleWrapper);
        
        // Add with animation
        messageContainer.style.opacity = '0';
        messageContainer.style.transform = type === 'user' ? 'translateX(20px)' : 'translateX(-20px)';
        chatBox.appendChild(messageContainer);
        
        // Trigger animation
        requestAnimationFrame(() => {
            messageContainer.style.transition = 'all 0.4s cubic-bezier(0.34, 1.56, 0.64, 1)';
            messageContainer.style.opacity = '1';
            messageContainer.style.transform = 'translateX(0)';
        });
        
        // Smooth scroll to bottom
        setTimeout(() => {
            chatBox.scrollTo({
                top: chatBox.scrollHeight,
                behavior: 'smooth'
            });
        }, 100);
    }

    function sendMessage() {
        const input = document.getElementById('chat-message');
        const message = input.value.trim();
        
        if (message !== '') {
            socket.emit('chat-message', message);
            input.value = '';
            input.style.height = 'auto';
            input.focus();
        }
    }
</script>

<script>
    let localStream;
    let peerConnection;
    let audioContext;
    let callActive = false;


    const iceServers = {
        iceServers: [{ urls: 'stun:stun.l.google.com:19302' }]
    };


    document.getElementById("startCallButton").addEventListener("click", () => {
        if (!audioContext) {
            audioContext = new (window.AudioContext || window.webkitAudioContext)();
        }
        if (audioContext.state === "suspended") {
            audioContext.resume().then(() => {
                console.log("AudioContext is resumed.");
                startCall();
            });
        } else {
            startCall();
        }
    });


    async function startCall() {
        try {

            localStream = await navigator.mediaDevices.getUserMedia({ audio: true });
            showEndCallButton();
            callActive = true;

            socket.emit('start-call');
            initializePeerConnection();
        } catch (error) {
            console.error("Failed to access audio stream:", error);
            alert("Could not access audio. Please check permissions.");
        }
    }


    function initializePeerConnection() {
        peerConnection = new RTCPeerConnection(iceServers);


        if (localStream) {
            localStream.getTracks().forEach(track => peerConnection.addTrack(track, localStream));
        } else {
            console.error("Local stream is not initialized.");
            return;
        }

        peerConnection.onicecandidate = (event) => {
            if (event.candidate) {
                socket.emit('ice-candidate', event.candidate);
            }
        };


        peerConnection.ontrack = (event) => {
            const remoteAudio = new Audio();
            remoteAudio.srcObject = event.streams[0];
            remoteAudio.play();
        };


        peerConnection.createOffer()
            .then(offer => peerConnection.setLocalDescription(offer))
            .then(() => socket.emit('offer', peerConnection.localDescription));
    }


    socket.on('offer', (offer) => {
        if (!peerConnection) initializePeerConnection();
        peerConnection.setRemoteDescription(new RTCSessionDescription(offer))
            .then(() => peerConnection.createAnswer())
            .then(answer => peerConnection.setLocalDescription(answer))
            .then(() => socket.emit('answer', peerConnection.localDescription));
    });

    socket.on('answer', (answer) => {
        peerConnection.setRemoteDescription(new RTCSessionDescription(answer));
    });


    socket.on('ice-candidate', (candidate) => {
        peerConnection.addIceCandidate(new RTCIceCandidate(candidate));
    });


    socket.on('end-call', () => {
        if (callActive) {
            alert("The call has been ended by the other user.");
            endCall();
        }
    });


    socket.on('resume-call', (data) => {
        if (data.isActive) {
            alert("A call is currently active. Rejoining the call...");
            startCall();
        }
    });


    function endCall() {
        hideEndCallButton();
        callActive = false;

        if (peerConnection) {
            peerConnection.close();
            peerConnection = null;
        }
        if (localStream) {
            localStream.getTracks().forEach(track => track.stop());
            localStream = null;
        }

        socket.emit('end-call');
    }


    function showEndCallButton() {
        const startBtn = document.getElementById('startCallButton');
        const endBtn = document.getElementById('endCallButton');
        
        startBtn.classList.add('hidden');
        startBtn.classList.remove('flex');
        
        endBtn.classList.remove('hidden');
        endBtn.classList.add('flex');
        
        // Update session status
        const statusIndicator = document.querySelector('.animate-pulse');
        if (statusIndicator) {
            statusIndicator.classList.remove('bg-emerald-500');
            statusIndicator.classList.add('bg-red-500');
        }
    }

    function hideEndCallButton() {
        const startBtn = document.getElementById('startCallButton');
        const endBtn = document.getElementById('endCallButton');
        
        endBtn.classList.add('hidden');
        endBtn.classList.remove('flex');
        
        startBtn.classList.remove('hidden');
        startBtn.classList.add('flex');
        
        // Update session status
        const statusIndicator = document.querySelector('.animate-pulse');
        if (statusIndicator) {
            statusIndicator.classList.remove('bg-red-500');
            statusIndicator.classList.add('bg-emerald-500');
        }
    }
</script>

</html>
