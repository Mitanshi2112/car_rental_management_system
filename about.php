<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About Us - Ride on Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .hero-gradient { background: linear-gradient(135deg, #1f2937, #374151); }
        .back-button { top: 20px; left: 20px; z-index: 10; }
    </style>
</head>
<body class="bg-gray-50 min-h-screen">

    <!-- Back Button -->
    <a href="dashboard.php" class="fixed back-button text-white bg-indigo-600 hover:bg-indigo-700 p-2 px-4 rounded-full shadow-lg transition duration-300 flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        <span>Dashboard</span>
    </a>

    <!-- Hero Section -->
    <header class="hero-gradient text-white py-20 shadow-xl">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-5xl font-extrabold mb-4">Ride on Rental: Driving Your Freedom</h1>
            <p class="text-xl font-light mb-8 max-w-3xl mx-auto">
           Our mission is to make car rentals simple, transparent, and lightning-fast.
                        Every journey is yours.          </p>
            <div class="inline-block px-8 py-3 bg-yellow-400 text-gray-900 font-bold text-lg rounded-full shadow-xl hover:bg-yellow-300 transition duration-300">
                #YourJourneyStartsHere
            </div>
        </div>
    </header>

    <!-- Content Section: Our Vision -->
    <section class="py-16 px-6">
        <div class="container mx-auto">
            <h2 class="text-4xl font-bold text-gray-800 text-center mb-12">The Visionaries of Vehicle Rentals</h2>
            
            <div class="grid md:grid-cols-3 gap-10">
                
                <!-- Card 1: Simplicity -->
                <div class="bg-white p-8 rounded-xl shadow-2xl hover:shadow-indigo-300 transition duration-500 transform hover:-translate-y-1 border-t-4 border-indigo-500">
                    <div class="text-5xl text-indigo-600 mb-4">🛣️</div>
                    <h3 class="text-2xl font-semibold mb-3">Seamless Simplicity</h3>
                    <p class="text-gray-600">
                           The entire booking process happens in just 3 simple steps: Select, Book, Ride!
                             Our website is designed to be user-friendly and hassle-free — no unnecessary paperwork, no hidden costs.                    </p>
                </div>
                
                <!-- Card 2: Transparency -->
                <div class="bg-white p-8 rounded-xl shadow-2xl hover:shadow-indigo-300 transition duration-500 transform hover:-translate-y-1 border-t-4 border-yellow-500">
                    <div class="text-5xl text-yellow-600 mb-4">💰</div>
                    <h3 class="text-2xl font-semibold mb-3">Honest & Transparent Pricing</h3>
                    <p class="text-gray-600">
                         Our promise: you’ll get exactly what you see. No hidden charges — all prices are displayed clearly and transparently.                    </p>
                </div>

                <!-- Card 3: Quality -->
                <div class="bg-white p-8 rounded-xl shadow-2xl hover:shadow-indigo-300 transition duration-500 transform hover:-translate-y-1 border-t-4 border-green-500">
                    <div class="text-5xl text-green-600 mb-4">🛡️</div>
                    <h3 class="text-2xl font-semibold mb-3">Safety First, Always</h3>
                    <p class="text-gray-600">
                          Every car undergoes a thorough inspection before every trip. Your safety is our top priority — only clean and well-maintained cars are provided for your service.
                    </p>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer CTA -->
    <footer class="bg-gray-800 py-10 mt-10">
        <div class="container mx-auto text-center text-gray-300">
            <p class="text-xl mb-4">Ready to hit the road?</p>
            <a href="index.php" class="bg-red-500 text-white font-semibold py-3 px-8 rounded-full hover:bg-red-600 transition duration-300 shadow-lg">
                Book Your Dream Car Now!
            </a>
            <p class="mt-4 text-sm">&copy; 2025 Ride on Rental. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>
