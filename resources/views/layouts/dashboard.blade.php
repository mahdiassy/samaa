@extends('layouts.master2')
@section('content')
    <div class="main-content">
        <div class="dashboard-container">
            <div class="dashboard-card">
                <h2 class="dashboard-card-title">{{ __('site.Sama\'a') }}</h2>
                <p class="dashboard-card-description">{{ __('site.This is the Dashboard of the Samaa.') }}</p>
            </div>
        </div>
    </div>

    <style>
        /* Modern Dashboard Styles */
        .main-content {
            padding: 2rem;
            background: linear-gradient(135deg, #f8fafc 0%, #e2e8f0 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .dashboard-container {
            width: 100%;
            max-width: 1200px;
            margin: 0 auto;
        }

        .dashboard-card {
            background: linear-gradient(135deg, #ffffff 0%, #f8fafc 100%);
            border-radius: 32px;
            padding: 4rem 3rem;
            text-align: center;
            box-shadow: 
                0 25px 50px -12px rgba(0, 0, 0, 0.1),
                0 0 0 1px rgba(255, 255, 255, 0.8);
            border: 1px solid rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            backdrop-filter: blur(20px);
            transition: all 0.4s ease;
        }

        .dashboard-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, 
                rgba(59, 130, 246, 0.05) 0%, 
                rgba(16, 185, 129, 0.05) 50%, 
                rgba(139, 92, 246, 0.05) 100%);
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .dashboard-card:hover::before {
            opacity: 1;
        }

        .dashboard-card:hover {
            transform: translateY(-8px);
            box-shadow: 
                0 32px 64px -12px rgba(0, 0, 0, 0.15),
                0 0 0 1px rgba(255, 255, 255, 0.9);
        }

        .dashboard-card-title {
            font-size: 3.5rem;
            font-weight: 800;
            margin-bottom: 1.5rem;
            background: linear-gradient(135deg, 
                #1e293b 0%, 
                #475569 25%, 
                #3b82f6 50%, 
                #10b981 75%, 
                #8b5cf6 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            position: relative;
            z-index: 1;
            animation: shimmer 3s ease-in-out infinite;
        }

        @keyframes shimmer {
            0%, 100% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
        }

        .dashboard-card-description {
            font-size: 1.25rem;
            color: #64748b;
            line-height: 1.7;
            max-width: 600px;
            margin: 0 auto;
            position: relative;
            z-index: 1;
            font-weight: 400;
        }

        /* Floating Elements */
        .dashboard-card::after {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, 
                rgba(59, 130, 246, 0.1) 0%, 
                transparent 50%);
            animation: float 6s ease-in-out infinite;
            pointer-events: none;
        }

        @keyframes float {
            0%, 100% {
                transform: translate(0, 0) rotate(0deg);
            }
            33% {
                transform: translate(30px, -30px) rotate(120deg);
            }
            66% {
                transform: translate(-20px, 20px) rotate(240deg);
            }
        }

        /* Responsive Design */
        @media(max-width: 768px) {
            .main-content {
                padding: 1rem;
            }

            .dashboard-card {
                padding: 2.5rem 1.5rem;
                border-radius: 24px;
            }

            .dashboard-card-title {
                font-size: 2.5rem;
                margin-bottom: 1rem;
            }

            .dashboard-card-description {
                font-size: 1.1rem;
            }
        }

        @media(max-width: 480px) {
            .dashboard-card {
                padding: 2rem 1rem;
            }

            .dashboard-card-title {
                font-size: 2rem;
            }

            .dashboard-card-description {
                font-size: 1rem;
            }
        }

        /* Accessibility */
        @media(prefers-reduced-motion: reduce) {
            .dashboard-card::before,
            .dashboard-card::after,
            .dashboard-card-title {
                animation: none;
            }
            
            .dashboard-card:hover {
                transform: none;
            }
        }

        /* High contrast mode */
        @media(prefers-contrast: high) {
            .dashboard-card {
                border: 2px solid #000;
            }
            
            .dashboard-card-title {
                color: #000;
                -webkit-text-fill-color: #000;
            }
            
            .dashboard-card-description {
                color: #333;
            }
        }
    </style>
@endsection
