<?php
// Pastikan sesi login tetap dipertahankan
if (!isset($_SESSION['login'])) {
    header("Location: index.php?page=login");
    exit;
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<title>SIAKAD Modern - Sistem Informasi Akademik</title>

<!-- Tailwind CSS CDN -->
<script src="https://cdn.tailwindcss.com"></script>

<!-- Font Awesome for Icons -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

<!-- Google Fonts -->
<link rel="preconnect" href="https://fonts.googleapis.com">
<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
<link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

<style>
    body {
        font-family: 'Inter', sans-serif;
    }
    
    /* Custom Scrollbar */
    ::-webkit-scrollbar {
        width: 8px;
        height: 8px;
    }
    ::-webkit-scrollbar-track {
        background: #f1f5f9;
    }
    ::-webkit-scrollbar-thumb {
        background: #cbd5e1;
        border-radius: 4px;
    }
    ::-webkit-scrollbar-thumb:hover {
        background: #94a3b8;
    }

    /* Smooth Animations */
    * {
        transition: all 0.2s ease;
    }

    /* Gradient Background */
    .gradient-bg {
        background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
    }

    /* Card Hover Effect */
    .card-hover {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .card-hover:hover {
        transform: translateY(-4px);
        box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
    }

    /* Print Styles */
    @media print {
        .no-print {
            display: none !important;
        }
        .sidebar {
            display: none !important;
        }
        .main-content {
            margin-left: 0 !important;
        }
    }
</style>

<script>
    // Tailwind Configuration
    tailwind.config = {
        theme: {
            extend: {
                colors: {
                    primary: {
                        50: '#f5f7ff',
                        100: '#ebefff',
                        200: '#d6deff',
                        300: '#b3c2ff',
                        400: '#8da0ff',
                        500: '#667eea',
                        600: '#5568d3',
                        700: '#4553b8',
                        800: '#36418a',
                        900: '#2a3366',
                    },
                    secondary: {
                        50: '#faf5ff',
                        100: '#f3e8ff',
                        200: '#e9d5ff',
                        300: '#d8b4fe',
                        400: '#c084fc',
                        500: '#a855f7',
                        600: '#9333ea',
                        700: '#7e22ce',
                        800: '#6b21a8',
                        900: '#581c87',
                    }
                }
            }
        }
    }
</script>
</head>
<body class="bg-gray-50 antialiased">

<!-- Mobile Menu Toggle Button -->
<button id="mobileMenuBtn" class="no-print fixed top-4 left-4 z-50 lg:hidden bg-white rounded-xl shadow-xl p-3 text-gray-700 hover:bg-gray-100 transform hover:scale-110 transition duration-200">
    <i class="fas fa-bars text-xl"></i>
</button>

<div class="flex min-h-screen">