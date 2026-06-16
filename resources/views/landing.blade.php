<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'Chama Ledger') }} - Automated Financial Management for Kenyan Chamas</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800,900" rel="stylesheet" />

    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        [x-cloak] { display: none !important; }

        /* Gradient Hero */
        .hero-gradient {
            background: linear-gradient(135deg, #0f172a 0%, #1e3a5f 50%, #0f172a 100%);
        }

        /* Floating animation */
        .float-animation {
            animation: float 6s ease-in-out infinite;
        }

        @keyframes float {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-20px); }
        }

        /* Feature card hover */
        .feature-card {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .feature-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 20px 60px rgba(0,0,0,0.12);
        }

        /* Stat counter */
        .stat-number {
            font-size: 2.5rem;
            font-weight: 900;
            background: linear-gradient(135deg, #2563eb, #7c3aed);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
        }
    </style>
</head>
<body class="antialiased bg-gray-50">
    <!-- Navigation -->
    <nav class="bg-white/80 backdrop-blur-md border-b border-gray-100 fixed w-full z-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="flex justify-between items-center h-16">
                <!-- Logo -->
                <div class="flex items-center">
                    <div class="flex-shrink-0">
                        <a href="/" class="flex items-center gap-2">
                            <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                                C
                            </div>
                            <span class="text-xl font-bold bg-gradient-to-r from-blue-600 to-purple-600 bg-clip-text text-transparent">
                                Chama Ledger
                            </span>
                        </a>
                    </div>
                </div>

                <!-- Navigation Links -->
                <div class="hidden md:flex items-center gap-6">
                    <a href="#features" class="text-gray-600 hover:text-blue-600 transition font-medium">Features</a>
                    <a href="#benefits" class="text-gray-600 hover:text-blue-600 transition font-medium">Benefits</a>
                    <a href="#stats" class="text-gray-600 hover:text-blue-600 transition font-medium">Impact</a>
                </div>

                <!-- Auth Buttons -->
                <div class="flex items-center gap-3">
                    @if (Route::has('login'))
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition font-medium shadow-md hover:shadow-lg">
                                Dashboard
                            </a>
                        @else
                            <a href="{{ route('login') }}" class="text-gray-600 hover:text-blue-600 transition font-medium">
                                Log in
                            </a>
                            @if (Route::has('register'))
                                <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white px-4 py-2 rounded-lg transition font-medium shadow-md hover:shadow-lg">
                                    Get Started
                                </a>
                            @endif
                        @endauth
                    @endif
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section class="hero-gradient min-h-screen flex items-center pt-16 overflow-hidden">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-20">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 items-center">
                <!-- Left Content -->
                <div>
                    <div class="inline-flex items-center gap-2 bg-blue-900/50 backdrop-blur-sm text-blue-300 px-4 py-2 rounded-full text-sm border border-blue-700/30 mb-6">
                        <span class="w-2 h-2 bg-green-400 rounded-full animate-pulse"></span>
                        Trusted by Chamas across Kenya
                    </div>

                    <h1 class="text-4xl md:text-6xl font-extrabold text-white leading-tight mb-6">
                        <span class="bg-gradient-to-r from-blue-400 to-purple-400 bg-clip-text text-transparent">
                            Financial Management
                        </span>
                        <br/>
                        Made Simple for Chamas
                    </h1>

                    <p class="text-xl text-gray-300 mb-8 leading-relaxed">
                        Automate your Chama's ledger, loan management, and compliance tracking.
                        <span class="text-blue-400 font-medium">No bank account required.</span>
                    </p>

                    <div class="flex flex-wrap gap-4">
                        @auth
                            <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-bold py-3 px-8 rounded-xl transition shadow-xl hover:shadow-2xl transform hover:scale-105">
                                Go to Dashboard →
                            </a>
                        @else
                            <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-500 to-purple-500 hover:from-blue-600 hover:to-purple-600 text-white font-bold py-3 px-8 rounded-xl transition shadow-xl hover:shadow-2xl transform hover:scale-105">
                                Start Free Today
                            </a>
                            <a href="#features" class="border border-white/20 hover:border-white/40 text-white font-medium py-3 px-8 rounded-xl transition">
                                Learn More
                            </a>
                        @endauth
                    </div>

                    <!-- Trust Badges -->
                    <div class="flex items-center gap-6 mt-8">
                        <div class="flex -space-x-2">
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-blue-400 to-blue-600 flex items-center justify-center text-white text-xs font-bold border-2 border-white/20">J</div>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-purple-400 to-purple-600 flex items-center justify-center text-white text-xs font-bold border-2 border-white/20">M</div>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-green-400 to-green-600 flex items-center justify-center text-white text-xs font-bold border-2 border-white/20">A</div>
                            <div class="w-8 h-8 rounded-full bg-gradient-to-br from-red-400 to-red-600 flex items-center justify-center text-white text-xs font-bold border-2 border-white/20">S</div>
                            <div class="w-8 h-8 rounded-full bg-gray-700 border-2 border-white/20 flex items-center justify-center text-white text-xs font-bold">+50</div>
                        </div>
                        <span class="text-gray-400 text-sm">Join 50+ Chamas already using the system</span>
                    </div>
                </div>

                <!-- Right Content - Dashboard Mockup -->
                <div class="relative">
                    <div class="float-animation">
                        <div class="bg-white/10 backdrop-blur-lg rounded-2xl p-6 border border-white/10 shadow-2xl">
                            <div class="bg-gray-900/50 rounded-xl p-4">
                                <!-- Mock Dashboard -->
                                <div class="flex items-center justify-between mb-4">
                                    <span class="text-white text-sm font-medium">📊 Dashboard</span>
                                    <span class="text-gray-400 text-xs">Chama: Nairobi United</span>
                                </div>
                                <div class="grid grid-cols-2 gap-3 mb-4">
                                    <div class="bg-blue-500/20 rounded-lg p-3">
                                        <div class="text-gray-400 text-xs">Total Savings</div>
                                        <div class="text-white font-bold">Ksh 1,245,000</div>
                                    </div>
                                    <div class="bg-green-500/20 rounded-lg p-3">
                                        <div class="text-gray-400 text-xs">Active Loans</div>
                                        <div class="text-white font-bold">Ksh 780,000</div>
                                    </div>
                                    <div class="bg-yellow-500/20 rounded-lg p-3">
                                        <div class="text-gray-400 text-xs">Pending</div>
                                        <div class="text-white font-bold">12</div>
                                    </div>
                                    <div class="bg-red-500/20 rounded-lg p-3">
                                        <div class="text-gray-400 text-xs">Fines</div>
                                        <div class="text-white font-bold">Ksh 24,500</div>
                                    </div>
                                </div>
                                <div class="bg-gray-800/50 rounded-lg p-3">
                                    <div class="text-gray-400 text-xs mb-2">Recent Transactions</div>
                                    <div class="space-y-1">
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-300">John M.</span>
                                            <span class="text-green-400">+Ksh 5,000</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-300">Mary A.</span>
                                            <span class="text-green-400">+Ksh 10,000</span>
                                        </div>
                                        <div class="flex justify-between text-sm">
                                            <span class="text-gray-300">Peter O.</span>
                                            <span class="text-red-400">-Ksh 2,500</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Floating Badges -->
                        <div class="absolute -top-6 -right-6 bg-green-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg animate-bounce">
                            🚀 M-Pesa Ready
                        </div>
                        <div class="absolute -bottom-6 -left-6 bg-purple-500 text-white text-xs font-bold px-3 py-1 rounded-full shadow-lg">
                            🔒 Secure
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="features" class="py-20 bg-white">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-semibold text-sm tracking-wider uppercase">Features</span>
                <h2 class="text-4xl font-extrabold text-gray-900 mt-2">
                    Everything You Need to Run Your Chama
                </h2>
                <p class="text-xl text-gray-500 mt-4 max-w-2xl mx-auto">
                    Purpose-built for Kenyan Chamas, with features that automate and simplify your operations.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature 1 -->
                <div class="feature-card bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 bg-gradient-to-br from-blue-500 to-blue-600 rounded-xl flex items-center justify-center text-2xl mb-4">
                        📱
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">M-Pesa SMS Parser</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Automatically log contributions by pasting M-Pesa confirmation messages. No manual data entry required.
                    </p>
                    <div class="mt-4 flex items-center gap-2 text-sm text-green-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>98% accuracy</span>
                    </div>
                </div>

                <!-- Feature 2 -->
                <div class="feature-card bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 bg-gradient-to-br from-purple-500 to-purple-600 rounded-xl flex items-center justify-center text-2xl mb-4">
                        📊
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Credit Scoring Engine</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Fair, data-driven loan eligibility scoring using a weighted 1-10 point system. No more manual guesswork.
                    </p>
                    <div class="mt-4 flex items-center gap-2 text-sm text-purple-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Fair & transparent</span>
                    </div>
                </div>

                <!-- Feature 3 -->
                <div class="feature-card bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 bg-gradient-to-br from-green-500 to-green-600 rounded-xl flex items-center justify-center text-2xl mb-4">
                        ⚠️
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Automated Penalty Engine</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Automatic fine calculation for late contributions and loan repayments. Enforce your Chama rules consistently.
                    </p>
                    <div class="mt-4 flex items-center gap-2 text-sm text-green-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>No manual calculations</span>
                    </div>
                </div>

                <!-- Feature 4 -->
                <div class="feature-card bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 bg-gradient-to-br from-orange-500 to-orange-600 rounded-xl flex items-center justify-center text-2xl mb-4">
                        📄
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">PDF Reports</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Generate professional member statements and group financial reports with one click. Perfect for meetings.
                    </p>
                    <div class="mt-4 flex items-center gap-2 text-sm text-orange-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>Meeting ready</span>
                    </div>
                </div>

                <!-- Feature 5 -->
                <div class="feature-card bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 bg-gradient-to-br from-red-500 to-red-600 rounded-xl flex items-center justify-center text-2xl mb-4">
                        👥
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">Member Self-Service</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Members can view their balances, transaction history, and apply for loans without needing a treasurer.
                    </p>
                    <div class="mt-4 flex items-center gap-2 text-sm text-red-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>24/7 access</span>
                    </div>
                </div>

                <!-- Feature 6 -->
                <div class="feature-card bg-white p-8 rounded-2xl border border-gray-100 shadow-sm">
                    <div class="w-14 h-14 bg-gradient-to-br from-teal-500 to-teal-600 rounded-xl flex items-center justify-center text-2xl mb-4">
                        🔒
                    </div>
                    <h3 class="text-xl font-bold text-gray-900 mb-2">No Bank Account Required</h3>
                    <p class="text-gray-500 leading-relaxed">
                        Works with any Chama setup. No mandatory bank integration. Your funds stay in your control.
                    </p>
                    <div class="mt-4 flex items-center gap-2 text-sm text-teal-600">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                        <span>100% flexible</span>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Benefits Section -->
    <section id="benefits" class="py-20 bg-gray-50">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-16">
                <span class="text-blue-600 font-semibold text-sm tracking-wider uppercase">Why Choose Us</span>
                <h2 class="text-4xl font-extrabold text-gray-900 mt-2">
                    Built for Kenyan Chamas, by Kenyans
                </h2>
                <p class="text-xl text-gray-500 mt-4 max-w-2xl mx-auto">
                    Designed specifically to address the challenges faced by informal savings groups.
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex gap-4">
                    <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-2xl flex-shrink-0">💰</div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-1">Reduce Errors by 95%</h3>
                        <p class="text-gray-500 text-sm">Eliminate manual arithmetic mistakes. Every transaction is recorded accurately.</p>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex gap-4">
                    <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-2xl flex-shrink-0">👁️</div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-1">Full Transparency</h3>
                        <p class="text-gray-500 text-sm">Every member sees their own records. Trust is built through visibility.</p>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex gap-4">
                    <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-2xl flex-shrink-0">⏰</div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-1">Save Hours of Work</h3>
                        <p class="text-gray-500 text-sm">Treasurers spend less time reconciling and more time on strategic decisions.</p>
                    </div>
                </div>
                <div class="bg-white p-8 rounded-2xl shadow-sm border border-gray-100 flex gap-4">
                    <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center text-2xl flex-shrink-0">📈</div>
                    <div>
                        <h3 class="font-bold text-gray-900 mb-1">Better Loan Decisions</h3>
                        <p class="text-gray-500 text-sm">Data-driven credit scoring ensures fair and objective loan approvals.</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Stats Section -->
    <section id="stats" class="py-20 hero-gradient">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-2 md:grid-cols-4 gap-8">
                <div class="text-center">
                    <div class="stat-number">60%</div>
                    <p class="text-gray-300 text-sm mt-1">Kenyan adults in Chamas</p>
                </div>
                <div class="text-center">
                    <div class="stat-number">78%</div>
                    <p class="text-gray-300 text-sm mt-1">Used manual ledgers</p>
                </div>
                <div class="text-center">
                    <div class="stat-number">Ksh 10B+</div>
                    <p class="text-gray-300 text-sm mt-1">Managed in Chamas annually</p>
                </div>
                <div class="text-center">
                    <div class="stat-number">97%</div>
                    <p class="text-gray-300 text-sm mt-1">Accuracy improvement</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section class="py-20 bg-white">
        <div class="max-w-4xl mx-auto px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-4xl font-extrabold text-gray-900 mb-4">
                Ready to Digitize Your Chama?
            </h2>
            <p class="text-xl text-gray-500 mb-8">
                Join the revolution. Automate your Chama's financial management today.
            </p>
            @auth
                <a href="{{ route('dashboard') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-12 rounded-xl transition shadow-xl hover:shadow-2xl transform hover:scale-105 inline-block">
                    Go to Dashboard →
                </a>
            @else
                <div class="flex flex-wrap justify-center gap-4">
                    <a href="{{ route('register') }}" class="bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-bold py-4 px-12 rounded-xl transition shadow-xl hover:shadow-2xl transform hover:scale-105 inline-block">
                        Get Started Free
                    </a>
                    <a href="#features" class="border-2 border-gray-300 hover:border-blue-500 text-gray-700 hover:text-blue-600 font-bold py-4 px-12 rounded-xl transition inline-block">
                        Learn More
                    </a>
                </div>
            @endauth
        </div>
    </section>

    <!-- Footer -->
    <footer class="bg-gray-900 text-gray-400 py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <div class="w-10 h-10 bg-gradient-to-br from-blue-600 to-purple-600 rounded-xl flex items-center justify-center text-white font-bold text-xl">
                            C
                        </div>
                        <span class="text-xl font-bold text-white">Chama Ledger</span>
                    </div>
                    <p class="text-sm">Automated financial management for Kenyan Chamas. Built with ❤️ in Kenya.</p>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Quick Links</h4>
                    <ul class="space-y-2 text-sm">
                        <li><a href="#features" class="hover:text-white transition">Features</a></li>
                        <li><a href="#benefits" class="hover:text-white transition">Benefits</a></li>
                        @auth
                            <li><a href="{{ route('dashboard') }}" class="hover:text-white transition">Dashboard</a></li>
                        @else
                            <li><a href="{{ route('login') }}" class="hover:text-white transition">Login</a></li>
                            <li><a href="{{ route('register') }}" class="hover:text-white transition">Register</a></li>
                        @endauth
                    </ul>
                </div>
                <div>
                    <h4 class="text-white font-semibold mb-4">Contact</h4>
                    <p class="text-sm">Have questions? Reach out to your Chama administrator or support.</p>
                    <div class="mt-4 flex gap-4">
                        <a href="#" class="hover:text-white transition">📧</a>
                        <a href="#" class="hover:text-white transition">🐦</a>
                        <a href="#" class="hover:text-white transition">💬</a>
                    </div>
                </div>
            </div>
            <div class="border-t border-gray-800 mt-8 pt-8 text-sm text-center">
                © {{ date('Y') }} Chama Ledger. All rights reserved. Made in Kenya 🇰🇪
            </div>
        </div>
    </footer>
</body>
</html>