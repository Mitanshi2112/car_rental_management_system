<?php
session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Help Center & FAQ - Ride on Rental</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@100..900&display=swap');
        body { font-family: 'Inter', sans-serif; }
        .faq-item { transition: all 0.3s ease; }
        .faq-item:hover { background-color: #f7fafc; }
        .back-button { top: 20px; left: 20px; z-index: 10; }
    </style>
</head>
<body class="bg-gray-100 min-h-screen">

    <!-- Back Button -->
    <a href="dashboard.php" class="fixed back-button text-gray-800 bg-white hover:bg-gray-200 p-2 px-4 border border-gray-300 rounded-full shadow-lg transition duration-300 flex items-center space-x-2">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
        </svg>
        <span>Dashboard</span>
    </a>

    <!-- Header -->
    <header class="bg-white shadow-md py-12">
        <div class="container mx-auto px-6 text-center">
            <h1 class="text-4xl font-bold text-indigo-700 mb-2">Help Center & FAQ</h1>
            <p class="text-lg text-gray-600">All your questions are answered here.</p>
        </div>
    </header>

    <!-- FAQ Section -->
    <section class="py-12 px-6">
        <div class="container mx-auto max-w-3xl">

            <div class="space-y-4">
                
                <!-- FAQ Item 1 -->
                <div class="faq-item bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 flex justify-between items-center cursor-pointer" onclick="toggleAnswer(this)">
                       How do I make a booking?

                        <span class="text-indigo-600 text-2xl">+</span>
                    </h3>
                    <p class="text-gray-600 mt-2 hidden">
Select your preferred car from the dashboard and click on **“View Details.”**
Choose the date, time, and location, then click on **“Confirm Booking.”** That’s it!
                    </p>
                </div>

                <!-- FAQ Item 2 -->
                <div class="faq-item bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 flex justify-between items-center cursor-pointer" onclick="toggleAnswer(this)">
Is payment by card safe?
                        <span class="text-indigo-600 text-2xl">+</span>
                    </h3>
                    <p class="text-gray-600 mt-2 hidden">
Yes! We use a dummy payment gateway for simulation, but in the real world, all transactions are encrypted and completely secure. We never store your card details.
                    </p>
                </div>
                
               

                <!-- FAQ Item 4 -->
                <div class="faq-item bg-white p-6 rounded-lg shadow-lg">
                    <h3 class="text-xl font-semibold text-gray-800 mb-2 flex justify-between items-center cursor-pointer" onclick="toggleAnswer(this)">
What happens if the car is delayed?
                        <span class="text-indigo-600 text-2xl">+</span>
                    </h3>
                    <p class="text-gray-600 mt-2 hidden">
Then, an extra charge will have to be paid as per the requirements.
                    </p>
                </div>
                
            </div>
            
            <div class="mt-10 text-center border-t pt-8">
                <h3 class="text-2xl font-semibold text-gray-700 mb-4">Still need assistance?</h3>
                <p class="text-gray-600 mb-4">You can contact us directly via email:</p>
                <a href="mailto:support@rideonrental.com" class="bg-indigo-600 text-white font-bold py-3 px-6 rounded-full hover:bg-indigo-700 transition duration-300">
                    Email Support
                </a>
            </div>

        </div>
    </section>
    
    <script>
        function toggleAnswer(element) {
            const answer = element.nextElementSibling;
            const icon = element.querySelector('span');
            
            document.querySelectorAll('.faq-item p').forEach(p => {
                if (p !== answer) {
                    p.classList.add('hidden');
                    p.previousElementSibling.querySelector('span').innerText = '+';
                }
            });
            
            answer.classList.toggle('hidden');
            if (answer.classList.contains('hidden')) {
                icon.innerText = '+';
            } else {
                icon.innerText = '-';
            }
        }
    </script>
</body>
</html>
