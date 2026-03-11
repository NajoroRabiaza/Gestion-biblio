<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">

        <title>{{ config('app.name', 'Biblio') }}</title>

        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Nunito:wght@400;600;700&display=swap">
        <link rel="stylesheet" href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@600;700&family=DM+Sans:wght@400;500&display=swap">

        <link rel="stylesheet" href="{{ mix('css/app.css') }}">
        <script src="{{ mix('js/app.js') }}" defer></script>

        <style>
            /* modal de confirmation global */
            .confirm-overlay {
                position: fixed;
                inset: 0;
                background: rgba(26, 35, 50, 0.45);
                z-index: 99999;
                display: flex;
                align-items: center;
                justify-content: center;
                opacity: 0;
                pointer-events: none;
                transition: opacity 0.22s ease;
            }

            .confirm-overlay.show {
                opacity: 1;
                pointer-events: all;
            }

            .confirm-box {
                background: #fff;
                border-radius: 14px;
                border: 1.5px solid #e5ddd4;
                padding: 32px 36px;
                max-width: 380px;
                width: 90%;
                box-shadow: 0 20px 60px rgba(26, 35, 50, 0.18);
                transform: scale(0.95) translateY(10px);
                transition: transform 0.25s cubic-bezier(0.34, 1.56, 0.64, 1);
                font-family: 'DM Sans', sans-serif;
            }

            .confirm-overlay.show .confirm-box {
                transform: scale(1) translateY(0);
            }

            .confirm-icon {
                width: 44px;
                height: 44px;
                background-color: #fef2f2;
                border-radius: 50%;
                display: flex;
                align-items: center;
                justify-content: center;
                margin-bottom: 16px;
                color: #ef4444;
            }

            .confirm-title {
                font-family: 'Playfair Display', serif;
                font-size: 1.15rem;
                color: #1a2332;
                margin-bottom: 8px;
            }

            .confirm-message {
                color: #6b7280;
                font-size: 0.9rem;
                line-height: 1.6;
                margin-bottom: 26px;
            }

            .confirm-actions {
                display: flex;
                gap: 10px;
                justify-content: flex-end;
            }

            .confirm-btn-cancel {
                background: transparent;
                color: #6b7280;
                border: 1.5px solid #e5ddd4;
                border-radius: 8px;
                padding: 9px 20px;
                font-size: 0.88rem;
                font-family: 'DM Sans', sans-serif;
                cursor: pointer;
                transition: border-color 0.2s, color 0.2s;
            }

            .confirm-btn-cancel:hover {
                border-color: #9ca3af;
                color: #374151;
            }

            .confirm-btn-ok {
                background: #1a2332;
                color: #fff;
                border: none;
                border-radius: 8px;
                padding: 9px 20px;
                font-size: 0.88rem;
                font-family: 'DM Sans', sans-serif;
                cursor: pointer;
                transition: background 0.2s;
            }

            .confirm-btn-ok:hover { background: #ef4444; }
        </style>
    </head>
    <body class="font-sans antialiased">
        <div class="min-h-screen bg-gray-100">
            @include('layouts.navigation')

            <header class="bg-white shadow">
                <div class="max-w-7xl mx-auto py-6 px-4 sm:px-6 lg:px-8">
                    {{ $header }}
                </div>
            </header>

            <main>
                {{ $slot }}
            </main>
        </div>

        {{-- modal de confirmation global --}}
        <div id="confirm-overlay" class="confirm-overlay">
            <div class="confirm-box">
                <div class="confirm-icon">
                    <svg width="20" height="20" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round">
                        <polyline points="3 6 5 6 21 6"/>
                        <path d="M19 6l-1 14a2 2 0 0 1-2 2H8a2 2 0 0 1-2-2L5 6"/>
                        <path d="M10 11v6"/><path d="M14 11v6"/>
                        <path d="M9 6V4a1 1 0 0 1 1-1h4a1 1 0 0 1 1 1v2"/>
                    </svg>
                </div>
                <div class="confirm-title" id="confirm-title">Confirmer</div>
                <p class="confirm-message" id="confirm-message"></p>
                <div class="confirm-actions">
                    <button class="confirm-btn-cancel" onclick="confirmRepondre(false)">Annuler</button>
                    <button class="confirm-btn-ok" id="confirm-btn-ok" onclick="confirmRepondre(true)">Confirmer</button>
                </div>
            </div>
        </div>

        <script>
            // système de confirmation global — remplace window.confirm()
            let confirmCallback = null;

            function demanderConfirmation(message, labelOk, callback) {
                document.getElementById('confirm-message').textContent = message;
                document.getElementById('confirm-btn-ok').textContent  = labelOk || 'Confirmer';
                confirmCallback = callback;
                document.getElementById('confirm-overlay').classList.add('show');
            }

            function confirmRepondre(reponse) {
                document.getElementById('confirm-overlay').classList.remove('show');
                if (confirmCallback) {
                    const cb = confirmCallback;
                    confirmCallback = null;
                    if (reponse) cb();
                }
            }

            // fermer en cliquant sur le fond
            document.addEventListener('DOMContentLoaded', function () {
                document.getElementById('confirm-overlay').addEventListener('click', function (e) {
                    if (e.target === this) confirmRepondre(false);
                });
            });
        </script>
    </body>
</html>