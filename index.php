<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>RENTACAR • Official Car Rental Platform</title>
    <!-- Font Awesome 6 (free) -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <!-- html2canvas for screenshot -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/html2canvas/1.4.1/html2canvas.min.js"></script>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Inter', system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #1e3c5c 0%, #0a1e2f 100%);
            color: #1e2f40;
            line-height: 1.5;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }

        /* main app container */
        .app-container {
            max-width: 1500px;
            width: 100%;
            background: white;
            border-radius: 48px 48px 40px 40px;
            box-shadow: 0 30px 70px rgba(0,0,0,0.4);
            overflow: hidden;
            border: 1px solid rgba(255,255,255,0.2);
            animation: containerAppear 0.6s ease-out;
        }

        @keyframes containerAppear {
            0% { opacity: 0; transform: scale(0.98) translateY(20px); }
            100% { opacity: 1; transform: scale(1) translateY(0); }
        }

        /* header */
        .navbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1.2rem 2.5rem;
            background: linear-gradient(135deg, #0a4b7a 0%, #06335c 100%);
            color: white;
            border-bottom: 3px solid #f5a623;
            flex-wrap: wrap;
        }

        .logo {
            font-size: 2rem;
            font-weight: 750;
            color: white;
            letter-spacing: -0.02em;
            text-shadow: 2px 2px 0 rgba(0,0,0,0.2);
        }
        .logo i { 
            color: #f5a623; 
            margin-right: 8px;
            animation: pulse 2s infinite;
        }

        .nav-links {
            display: flex;
            gap: 2.2rem;
            font-weight: 600;
        }
        .nav-links .nav-item {
            cursor: pointer;
            padding: 0.3rem 0;
            border-bottom: 3px solid transparent;
            transition: all 0.3s ease;
            color: rgba(255,255,255,0.9);
        }
        .nav-links .nav-item:hover {
            border-bottom-color: #f5a623;
            color: white;
        }
        .nav-links .nav-item.active {
            border-bottom-color: #f5a623;
            color: white;
        }

        .user-profile {
            display: flex;
            align-items: center;
            gap: 1.2rem;
            background: rgba(255,255,255,0.15);
            padding: 0.4rem 1.2rem 0.4rem 1.8rem;
            border-radius: 60px;
            backdrop-filter: blur(8px);
            border: 1px solid rgba(245,166,35,0.3);
        }
        .user-name {
            font-weight: 600;
            color: white;
        }
        .avatar {
            background: #f5a623;
            width: 42px;
            height: 42px;
            border-radius: 60px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #0a4b7a;
            font-weight: bold;
            font-size: 1.2rem;
        }
        .logout-btn {
            background: rgba(255,255,255,0.2);
            border: 1px solid #f5a623;
            padding: 0.4rem 1rem;
            border-radius: 40px;
            color: white;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .logout-btn:hover { 
            background: #f5a623;
            color: #0a4b7a;
        }

        /* auth section */
        .auth-section {
            max-width: 420px;
            margin: 3rem auto;
            background: white;
            border-radius: 48px;
            padding: 2.5rem 2rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.2);
            border: 2px solid #f5a623;
            animation: slideUpFade 0.5s ease-out;
        }

        @keyframes slideUpFade {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .auth-tabs {
            display: flex;
            gap: 1rem;
            margin-bottom: 2rem;
        }
        .auth-tab {
            flex: 1;
            text-align: center;
            padding: 1rem;
            font-weight: 700;
            background: #f0f0f0;
            border-radius: 100px;
            cursor: pointer;
            transition: all 0.3s ease;
            color: #333;
        }
        .auth-tab.active {
            background: #0a4b7a;
            color: white;
            box-shadow: 0 8px 16px #0a4b7a40;
        }
        .auth-form input {
            width: 100%;
            padding: 1rem 1.5rem;
            margin: 0.8rem 0 1.2rem;
            border: 2px solid #ddd;
            border-radius: 60px;
            font-size: 1rem;
            transition: all 0.3s ease;
        }
        .auth-form input:focus {
            border-color: #0a4b7a;
            outline: none;
            box-shadow: 0 0 0 4px rgba(10,75,122,0.1);
        }
        .auth-form button {
            background: #0a4b7a;
            color: white;
            border: none;
            width: 100%;
            padding: 1rem;
            font-weight: 700;
            border-radius: 60px;
            font-size: 1.1rem;
            cursor: pointer;
            box-shadow: 0 10px 20px #0a4b7a60;
            transition: all 0.3s ease;
        }
        .auth-form button:hover {
            background: #0c5f97;
            transform: translateY(-3px);
        }
        .demo-creds {
            background: #fff3cd;
            border-radius: 40px;
            padding: 1rem;
            font-size: 0.9rem;
            margin-top: 2rem;
            color: #856404;
            border-left: 6px solid #f5a623;
        }

        /* main app views */
        .app-views {
            padding: 0 2.5rem 2rem;
            background: #f8f9fa;
        }

        .view {
            animation: viewChange 0.4s ease-out;
        }

        @keyframes viewChange {
            0% { opacity: 0; transform: translateX(10px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        /* hero search */
        .hero-search {
            background: linear-gradient(135deg, #fff5e6 0%, #fff 100%);
            border-radius: 32px;
            padding: 2rem 2rem 2.2rem;
            margin: 2rem 0 2rem;
            box-shadow: 0 20px 35px -8px rgba(0,0,0,0.15);
            display: flex;
            flex-wrap: wrap;
            align-items: flex-end;
            gap: 1rem;
            border: 2px solid #f5a623;
        }
        .search-field {
            flex: 2 1 200px;
        }
        .search-field label {
            display: block;
            font-size: 0.8rem;
            text-transform: uppercase;
            font-weight: 600;
            color: #0a4b7a;
            margin-bottom: 0.3rem;
        }
        .search-field input, .search-field select {
            width: 100%;
            padding: 0.9rem 1.3rem;
            border: 2px solid #f5a623;
            border-radius: 60px;
            font-size: 1rem;
            background: white;
        }
        .search-btn {
            background: #0a4b7a;
            color: white;
            padding: 0.9rem 2.5rem;
            border-radius: 60px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: flex;
            align-items: center;
            gap: 10px;
            box-shadow: 0 8px 18px #0a4b7a70;
            transition: all 0.3s ease;
        }
        .search-btn:hover {
            background: #0c5f97;
            transform: translateY(-3px);
        }

        /* filter bar */
        .filter-section {
            background: white;
            padding: 1.2rem 2rem;
            border-radius: 60px;
            margin: 1.5rem 0 2rem;
            display: flex;
            flex-wrap: wrap;
            gap: 1.2rem 2rem;
            border: 2px solid #f5a623;
        }
        .filter-select {
            padding: 0.5rem 1.8rem 0.5rem 1rem;
            border-radius: 30px;
            border: 2px solid #f5a623;
            background: white;
            cursor: pointer;
        }

        /* car grid */
        .section-title {
            font-size: 1.8rem;
            font-weight: 700;
            margin: 2rem 0 1.2rem;
            color: #0a4b7a;
            border-left: 6px solid #f5a623;
            padding-left: 1rem;
        }
        .car-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem 1.5rem;
            margin: 2rem 0;
        }
        .car-card {
            background: white;
            border-radius: 28px;
            padding: 1.6rem 1.4rem;
            box-shadow: 0 20px 30px -10px rgba(0,0,0,0.1);
            transition: all 0.4s ease;
            border: 2px solid #f5a623;
            animation: cardAppear 0.5s ease-out;
            animation-fill-mode: both;
        }
        .car-card:hover {
            transform: translateY(-12px);
            box-shadow: 0 35px 50px -15px #0a4b7a80;
        }
        .car-img {
            background: #f0f0f0;
            border-radius: 18px;
            height: 150px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-bottom: 1rem;
            overflow: hidden;
        }
        .car-img img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        .car-title {
            font-size: 1.4rem;
            font-weight: 700;
            display: flex;
            justify-content: space-between;
        }
        .car-price {
            background: #0a4b7a;
            color: white;
            padding: 0.3rem 1rem;
            border-radius: 40px;
            font-size: 1rem;
        }
        .car-specs {
            display: flex;
            gap: 1rem;
            margin: 0.8rem 0;
            color: #666;
        }
        .rating {
            color: #f5a623;
            margin-bottom: 0.8rem;
        }
        .btn-book {
            background: transparent;
            border: 2px solid #0a4b7a;
            color: #0a4b7a;
            font-weight: 700;
            padding: 0.7rem;
            border-radius: 50px;
            cursor: pointer;
            transition: all 0.3s ease;
        }
        .btn-book:hover {
            background: #0a4b7a;
            color: white;
        }

        /* booking panel */
        .booking-panel {
            background: linear-gradient(135deg, #fff5e6 0%, #fff 100%);
            border-radius: 40px;
            padding: 2rem;
            margin: 3rem 0;
            box-shadow: 0 20px 35px rgba(0,0,0,0.15);
            border: 3px solid #f5a623;
        }
        .booking-form {
            display: flex;
            flex-wrap: wrap;
            gap: 1.5rem;
            align-items: flex-end;
        }
        .form-group {
            flex: 1 1 180px;
        }
        .form-group input, .form-group select {
            width: 100%;
            padding: 0.8rem 1.2rem;
            border-radius: 40px;
            border: 2px solid #f5a623;
            background: white;
        }
        .book-confirm-btn {
            background: #1f8b4c;
            color: white;
            padding: 0.9rem 2.5rem;
            border-radius: 60px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            box-shadow: 0 8px 18px #1f8b4c90;
            transition: all 0.3s ease;
        }
        .book-confirm-btn:hover {
            background: #2aa75a;
            transform: translateY(-4px);
        }
        .confirmation-message {
            background: #d4edda;
            border-radius: 60px;
            padding: 1rem 2rem;
            color: #0b5e2e;
            margin-top: 1.5rem;
            border-left: 6px solid #28a745;
        }

        /* email log section */
        .email-log-section {
            background: white;
            border-radius: 40px;
            padding: 1.5rem;
            margin: 2rem 0;
            border: 2px solid #f5a623;
        }
        .email-log {
            background: #f0f0f0;
            border-radius: 30px;
            padding: 1rem;
            font-family: monospace;
            max-height: 200px;
            overflow-y: auto;
        }
        .email-entry {
            padding: 0.5rem;
            border-bottom: 1px solid #ccc;
            color: #333;
        }

        /* screenshot button */
        .screenshot-btn {
            background: #f5a623;
            color: #0a4b7a;
            padding: 0.9rem 2rem;
            border-radius: 60px;
            font-weight: 700;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin: 1rem 0;
            transition: all 0.3s ease;
        }
        .screenshot-btn:hover {
            background: #e6c200;
            transform: scale(1.05);
        }

        /* bookings list */
        .bookings-list {
            background: #f7fcff;
            border-radius: 40px;
            padding: 2rem;
        }
        .booking-item {
            background: white;
            border-radius: 30px;
            padding: 1.2rem 1.8rem;
            margin-bottom: 1rem;
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            align-items: center;
            border: 1px solid #bfdcf5;
            transition: all 0.3s ease;
        }
        .booking-item:hover {
            transform: translateX(8px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.05);
            border-color: #0a4b7a;
        }

        .footer {
            background: #0a4b7a;
            color: white;
            border-radius: 40px 40px 0 0;
            padding: 2.5rem 2.5rem 1.5rem;
            margin-top: 3rem;
            border-top: 3px solid #f5a623;
        }
        .footer-bottom {
            text-align: center;
            padding-top: 2rem;
            border-top: 1px solid #f5a623;
        }

        .hidden { display: none; }
    </style>
</head>
<body>
<div class="app-container" id="appContainer">

    <!-- logged out / login view -->
    <div id="authView">
        <div class="navbar">
            <div class="logo"><i class="fas fa-car"></i> RENTACAR</div>
            <div></div>
        </div>
        <div class="auth-section">
            <div class="auth-tabs">
                <div class="auth-tab active" id="loginTabBtn">LOG IN</div>
                <div class="auth-tab" id="signupTabBtn">SIGN UP</div>
            </div>
            <div id="loginForm" class="auth-form">
                <input type="email" id="loginEmail" placeholder="Email" value="user@rentacar.com">
                <input type="password" id="loginPassword" placeholder="Password" value="rentacar123">
                <button id="loginBtn"><i class="fas fa-sign-in-alt"></i> Login</button>
            </div>
            <div id="signupForm" class="auth-form hidden">
                <input type="text" id="signupName" placeholder="Full name">
                <input type="email" id="signupEmail" placeholder="Email">
                <input type="password" id="signupPassword" placeholder="Password">
                <button id="signupBtn">Create Account</button>
            </div>
            <div class="demo-creds">
                <i class="fas fa-info-circle"></i> Demo: any credentials work
            </div>
        </div>
    </div>

    <!-- main app (logged in) -->
    <div id="appView" class="hidden">
        <!-- header -->
        <div class="navbar">
            <div class="logo"><i class="fas fa-car"></i> RENTACAR</div>
            <div class="nav-links">
                <span class="nav-item active" data-view="home"><i class="fas fa-home"></i> HOME</span>
                <span class="nav-item" data-view="cars"><i class="fas fa-list"></i> CARS</span>
                <span class="nav-item" data-view="bookings"><i class="fas fa-bookmark"></i> MY BOOKINGS</span>
            </div>
            <div class="user-profile">
                <span class="user-name" id="displayUserName">Alex Rivera</span>
                <div class="avatar" id="userAvatar">A</div>
                <button class="logout-btn" id="logoutBtn">LOGOUT</button>
            </div>
        </div>

        <!-- main views container -->
        <div class="app-views">
            <!-- screenshot button -->
            <button class="screenshot-btn" id="screenshotBtn"><i class="fas fa-camera"></i> DOWNLOAD SCREENSHOT</button>

            <!-- home view -->
            <div id="homeView" class="view">
                <div class="hero-search">
                    <div class="search-field">
                        <label><i class="fas fa-map-pin"></i> PICK-UP LOCATION</label>
                        <select id="locationSelect">
                            <option value="newyork">New York</option>
                            <option value="losangeles">Los Angeles</option>
                            <option value="chicago">Chicago</option>
                            <option value="miami">Miami</option>
                            <option value="lasvegas">Las Vegas</option>
                        </select>
                    </div>
                    <div class="search-field">
                        <label><i class="fas fa-calendar"></i> FROM</label>
                        <input type="date" id="startDateInput" value="2025-08-01">
                    </div>
                    <div class="search-field">
                        <label><i class="fas fa-calendar-check"></i> UNTIL</label>
                        <input type="date" id="endDateInput" value="2025-08-07">
                    </div>
                    <button class="search-btn" id="homeSearchBtn"><i class="fas fa-search"></i> SEARCH</button>
                </div>

                <div class="filter-section">
                    <span><i class="fas fa-filter"></i> FILTERS:</span>
                    <select class="filter-select" id="filterType">
                        <option value="all">All Types</option>
                        <option value="sedan">Sedan</option>
                        <option value="suv">SUV</option>
                        <option value="convertible">Convertible</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                    <select class="filter-select" id="filterFuel">
                        <option value="all">All Fuel</option>
                        <option value="petrol">Petrol</option>
                        <option value="diesel">Diesel</option>
                        <option value="electric">Electric</option>
                        <option value="hybrid">Hybrid</option>
                    </select>
                    <select class="filter-select" id="filterBrand">
                        <option value="all">All Brands</option>
                        <option value="toyota">Toyota</option>
                        <option value="honda">Honda</option>
                        <option value="ford">Ford</option>
                        <option value="bmw">BMW</option>
                        <option value="tesla">Tesla</option>
                    </select>
                </div>

                <div class="section-title"><i class="fas fa-star" style="color:#f5a623;"></i> FEATURED DEALS</div>
                <div id="carListContainer" class="car-grid"></div>
            </div>

            <!-- cars view -->
            <div id="carsView" class="view hidden">
                <div class="section-title"><i class="fas fa-car"></i> ALL AVAILABLE CARS</div>
                <div id="carsListContainer" class="car-grid"></div>
            </div>

            <!-- bookings view -->
            <div id="bookingsView" class="view hidden">
                <div class="section-title"><i class="fas fa-calendar-check"></i> YOUR BOOKINGS</div>
                <div id="bookingsListContainer" class="bookings-list"></div>
            </div>

            <!-- email log section -->
            <div class="email-log-section">
                <h3><i class="fas fa-envelope"></i> EMAIL CONFIRMATION LOG</h3>
                <div id="emailLog" class="email-log">
                    <div class="email-entry">System ready</div>
                </div>
            </div>

            <!-- booking panel -->
            <div class="booking-panel">
                <h3><i class="fas fa-pen"></i> QUICK RESERVE</h3>
                <div class="booking-form">
                    <div class="form-group"><label>Car</label><select id="bookCarSelect" class="filter-select"></select></div>
                    <div class="form-group"><label>Your name</label><input type="text" id="bookName" value="Alex Rivera"></div>
                    <div class="form-group"><label>Email</label><input type="email" id="bookEmail" value="alex@example.com"></div>
                    <div class="form-group"><label>Start date</label><input type="date" id="bookStart" value="2025-08-01"></div>
                    <div class="form-group"><label>Return date</label><input type="date" id="bookEnd" value="2025-08-07"></div>
                    <button class="book-confirm-btn" id="confirmBookingBtn">CONFIRM BOOKING</button>
                </div>
                <div id="bookingConfirmMsg" class="confirmation-message hidden"></div>
            </div>
        </div>

        <!-- footer -->
        <footer class="footer">
            <div class="footer-grid">
                <div class="footer-col">
                    <h4><i class="fas fa-car"></i> RENTACAR</h4>
                    <p>Premium car rental since 2010. Best prices, unlimited miles, 24/7 support.</p>
                </div>
            </div>
            <div class="footer-bottom">
                <i class="fas fa-copyright"></i> 2025 RENTACAR. All rights reserved.
            </div>
        </footer>
    </div>
</div>

<script>
    (function() {
        // ---------- SIMULATED DB ----------
        const STORAGE_CARS = 'rentacarsDB';
        const STORAGE_BOOKINGS = 'rentacarsBookings';
        const STORAGE_USER = 'rentacarsUser';
        const STORAGE_EMAILS = 'rentacarsEmails';

        // Email log array
        let emailLogs = JSON.parse(localStorage.getItem(STORAGE_EMAILS)) || ['System ready'];

        function addEmailLog(message) {
            const timestamp = new Date().toLocaleString('en-US');
            const logEntry = `[${timestamp}] ${message}`;
            emailLogs.unshift(logEntry);
            if (emailLogs.length > 10) emailLogs.pop();
            localStorage.setItem(STORAGE_EMAILS, JSON.stringify(emailLogs));
            updateEmailLogDisplay();
        }

        function updateEmailLogDisplay() {
            const logDiv = document.getElementById('emailLog');
            if (logDiv) {
                logDiv.innerHTML = emailLogs.map(msg => `<div class="email-entry">📧 ${msg}</div>`).join('');
            }
        }

        // Car images
        function getCarImage(brand, model, index) {
            const carImages = [
                'https://images.unsplash.com/photo-1549317661-bd32c8ce0db2?w=400&h=300&fit=crop',
                'https://images.unsplash.com/photo-1568605117036-5fe5e7fa0ab7?w=400&h=300&fit=crop',
                'https://images.unsplash.com/photo-1580273916550-e323be2ae537?w=400&h=300&fit=crop',
                'https://images.unsplash.com/photo-1560958089-b8a1929cea89?w=400&h=300&fit=crop',
                'https://images.unsplash.com/photo-1555215695-3004980ad54e?w=400&h=300&fit=crop'
            ];
            return carImages[index % carImages.length];
        }

        const defaultCars = [
            { id: 1, brand: 'Toyota', model: 'Camry', type: 'sedan', fuel: 'petrol', price: 65, rating: 4.8, seats: 5, deals: true },
            { id: 2, brand: 'Honda', model: 'CR-V', type: 'suv', fuel: 'diesel', price: 85, rating: 4.7, seats: 5 },
            { id: 3, brand: 'Ford', model: 'Mustang', type: 'convertible', fuel: 'petrol', price: 150, rating: 4.9, seats: 4, deals: true },
            { id: 4, brand: 'Tesla', model: 'Model 3', type: 'sedan', fuel: 'electric', price: 120, rating: 4.9, seats: 5, deals: true },
            { id: 5, brand: 'BMW', model: 'X5', type: 'suv', fuel: 'diesel', price: 190, rating: 4.8, seats: 7 },
            { id: 6, brand: 'Toyota', model: 'RAV4', type: 'suv', fuel: 'hybrid', price: 95, rating: 4.8, seats: 5 },
            { id: 7, brand: 'Honda', model: 'Civic', type: 'sedan', fuel: 'petrol', price: 55, rating: 4.6, seats: 5 },
            { id: 8, brand: 'Chevrolet', model: 'Corvette', type: 'convertible', fuel: 'petrol', price: 220, rating: 4.9, seats: 2, deals: true }
        ];

        const carsWithImages = defaultCars.map((car, idx) => ({
            ...car,
            imageUrl: getCarImage(car.brand, car.model, idx),
            price: car.price
        }));

        if (!localStorage.getItem(STORAGE_CARS)) {
            localStorage.setItem(STORAGE_CARS, JSON.stringify(carsWithImages));
        }
        if (!localStorage.getItem(STORAGE_BOOKINGS)) {
            localStorage.setItem(STORAGE_BOOKINGS, JSON.stringify([]));
        }

        function getCars() { return JSON.parse(localStorage.getItem(STORAGE_CARS)) || carsWithImages; }
        function getBookings() { return JSON.parse(localStorage.getItem(STORAGE_BOOKINGS)) || []; }

        function saveBooking(booking) {
            const bookings = getBookings();
            bookings.push({ id: Date.now(), ...booking });
            localStorage.setItem(STORAGE_BOOKINGS, JSON.stringify(bookings));
            
            const emailMsg = `BOOKING CONFIRMATION: ${booking.carName} | Name: ${booking.renterName} | Email: ${booking.email} | Period: ${booking.start} - ${booking.end} | Total: $${booking.total}`;
            addEmailLog(emailMsg);
            
            return emailMsg;
        }

        // DOM elements
        const authView = document.getElementById('authView');
        const appView = document.getElementById('appView');
        const loginBtn = document.getElementById('loginBtn');
        const signupBtn = document.getElementById('signupBtn');
        const logoutBtn = document.getElementById('logoutBtn');
        const displayUserName = document.getElementById('displayUserName');
        const userAvatar = document.getElementById('userAvatar');
        const loginTab = document.getElementById('loginTabBtn');
        const signupTab = document.getElementById('signupTabBtn');
        const loginFormDiv = document.getElementById('loginForm');
        const signupFormDiv = document.getElementById('signupForm');

        const homeView = document.getElementById('homeView');
        const carsView = document.getElementById('carsView');
        const bookingsView = document.getElementById('bookingsView');
        const navItems = document.querySelectorAll('.nav-item');

        const bookCarSelect = document.getElementById('bookCarSelect');
        const bookName = document.getElementById('bookName');
        const bookEmail = document.getElementById('bookEmail');
        const bookStart = document.getElementById('bookStart');
        const bookEnd = document.getElementById('bookEnd');
        const confirmBookingBtn = document.getElementById('confirmBookingBtn');
        const bookingConfirmMsg = document.getElementById('bookingConfirmMsg');

        const carListContainer = document.getElementById('carListContainer');
        const carsListContainer = document.getElementById('carsListContainer');
        const bookingsListContainer = document.getElementById('bookingsListContainer');

        const filterType = document.getElementById('filterType');
        const filterFuel = document.getElementById('filterFuel');
        const filterBrand = document.getElementById('filterBrand');
        const homeSearchBtn = document.getElementById('homeSearchBtn');

        // Screenshot functionality
        document.getElementById('screenshotBtn').addEventListener('click', function() {
            html2canvas(document.querySelector('.app-container')).then(canvas => {
                const link = document.createElement('a');
                link.download = 'rentacar-screenshot.png';
                link.href = canvas.toDataURL();
                link.click();
            });
        });

        // Auth
        function setLoggedIn(userName = 'Alex Rivera') {
            authView.classList.add('hidden');
            appView.classList.remove('hidden');
            displayUserName.textContent = userName;
            userAvatar.textContent = userName.charAt(0);
            localStorage.setItem(STORAGE_USER, JSON.stringify({ name: userName }));
            renderAllCars('home');
            renderAllCars('cars');
            renderBookingsList();
            updateBookingDropdown();
            updateEmailLogDisplay();
            switchView('home');
        }

        function setLoggedOut() {
            authView.classList.remove('hidden');
            appView.classList.add('hidden');
            localStorage.removeItem(STORAGE_USER);
        }

        const savedUser = JSON.parse(localStorage.getItem(STORAGE_USER));
        if (savedUser) setLoggedIn(savedUser.name);

        loginBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const email = document.getElementById('loginEmail').value.trim();
            setLoggedIn(email ? email.split('@')[0] : 'User');
        });

        signupBtn.addEventListener('click', (e) => {
            e.preventDefault();
            const name = document.getElementById('signupName').value.trim();
            setLoggedIn(name || 'NewUser');
        });

        logoutBtn.addEventListener('click', setLoggedOut);

        loginTab.addEventListener('click', () => {
            loginTab.classList.add('active');
            signupTab.classList.remove('active');
            loginFormDiv.classList.remove('hidden');
            signupFormDiv.classList.add('hidden');
        });
        signupTab.addEventListener('click', () => {
            signupTab.classList.add('active');
            loginTab.classList.remove('active');
            signupFormDiv.classList.remove('hidden');
            loginFormDiv.classList.add('hidden');
        });

        // Routing
        function switchView(viewId) {
            homeView.classList.add('hidden');
            carsView.classList.add('hidden');
            bookingsView.classList.add('hidden');
            navItems.forEach(item => item.classList.remove('active'));
            
            if (viewId === 'home') {
                homeView.classList.remove('hidden');
                document.querySelector('[data-view="home"]').classList.add('active');
                renderAllCars('home');
            } else if (viewId === 'cars') {
                carsView.classList.remove('hidden');
                document.querySelector('[data-view="cars"]').classList.add('active');
                renderAllCars('cars');
            } else if (viewId === 'bookings') {
                bookingsView.classList.remove('hidden');
                document.querySelector('[data-view="bookings"]').classList.add('active');
                renderBookingsList();
            }
        }

        navItems.forEach(item => {
            item.addEventListener('click', () => switchView(item.dataset.view));
        });

        // Filter function
        function filterCars() {
            const cars = getCars();
            const type = filterType.value;
            const fuel = filterFuel.value;
            const brand = filterBrand.value;
            return cars.filter(c => {
                if (type !== 'all' && c.type !== type) return false;
                if (fuel !== 'all' && c.fuel !== fuel) return false;
                if (brand !== 'all' && c.brand.toLowerCase() !== brand) return false;
                return true;
            });
        }

        function renderAllCars(target = 'home') {
            const filtered = filterCars();
            const container = target === 'home' ? carListContainer : carsListContainer;
            if (!container) return;
            
            if (filtered.length === 0) {
                container.innerHTML = '<div style="grid-column:1/-1; text-align:center;padding:2rem;">🚫 No cars match filters</div>';
                return;
            }
            
            let html = '';
            filtered.forEach(car => {
                const stars = '★'.repeat(Math.floor(car.rating)) + '☆'.repeat(5-Math.floor(car.rating));
                html += `<div class="car-card">
                    <div class="car-img"><img src="${car.imageUrl}" alt="${car.brand} ${car.model}" loading="lazy" onerror="this.src='https://images.unsplash.com/photo-1550355291-bbee04a92027?w=400&h=300&fit=crop'"></div>
                    <div class="car-title">${car.brand} ${car.model} <span class="car-price">$${car.price}/day</span></div>
                    <div class="car-specs"><span><i class="fas fa-chair"></i> ${car.seats} seats</span><span><i class="fas fa-gas-pump"></i> ${car.fuel}</span></div>
                    <div class="rating">${stars}</div>
                    <button class="btn-book book-now-btn" data-id="${car.id}">Book now</button>
                </div>`;
            });
            container.innerHTML = html;

            document.querySelectorAll('.book-now-btn').forEach(btn => {
                btn.addEventListener('click', (e) => {
                    const id = e.target.dataset.id;
                    bookCarSelect.value = id;
                    document.querySelector('.booking-panel').scrollIntoView({ behavior: 'smooth' });
                });
            });
        }

        function updateBookingDropdown() {
            const cars = getCars();
            let opts = '<option value="">--select car--</option>';
            cars.forEach(c => opts += `<option value="${c.id}">${c.brand} ${c.model} ($${c.price}/day)</option>`);
            bookCarSelect.innerHTML = opts;
        }

        confirmBookingBtn.addEventListener('click', () => {
            const carId = bookCarSelect.value;
            if (!carId) { alert('Select a car'); return; }
            const name = bookName.value.trim();
            if (!name) { alert('Enter name'); return; }
            const email = bookEmail.value.trim();
            if (!email) { alert('Enter email'); return; }
            const start = bookStart.value;
            const end = bookEnd.value;
            if (!start || !end) { alert('Pick dates'); return; }
            
            const cars = getCars();
            const car = cars.find(c => c.id == carId);
            if (!car) return;
            
            const days = Math.max(1, (new Date(end) - new Date(start)) / (1000*60*60*24));
            const total = (days * car.price).toFixed(2);
            
            const booking = { 
                carId: car.id, 
                carName: `${car.brand} ${car.model}`, 
                renterName: name, 
                email: email,
                start, 
                end, 
                total,
                date: new Date().toISOString() 
            };
            
            saveBooking(booking);
            
            bookingConfirmMsg.classList.remove('hidden');
            bookingConfirmMsg.innerHTML = `<i class="fas fa-check-circle"></i> Booked ${car.brand} ${car.model} for ${name} | total $${total} | Confirmation email sent to ${email}`;
            setTimeout(() => bookingConfirmMsg.classList.add('hidden'), 8000);
            renderBookingsList();
        });

        function renderBookingsList() {
            const bookings = getBookings();
            if (!bookingsListContainer) return;
            if (bookings.length === 0) {
                bookingsListContainer.innerHTML = '<div style="text-align:center;padding:2rem;">No bookings yet.</div>';
                return;
            }
            let html = '';
            bookings.slice().reverse().forEach(b => {
                html += `<div class="booking-item">
                    <span><i class="fas fa-car"></i> ${b.carName || 'Car'}</span>
                    <span>${b.renterName}</span>
                    <span>${b.start} → ${b.end}</span>
                    <span>$${b.total}</span>
                </div>`;
            });
            bookingsListContainer.innerHTML = html;
        }

        filterType.addEventListener('change', () => { 
            if (!homeView.classList.contains('hidden')) renderAllCars('home'); 
            if (!carsView.classList.contains('hidden')) renderAllCars('cars'); 
        });
        
        filterFuel.addEventListener('change', () => { 
            if (!homeView.classList.contains('hidden')) renderAllCars('home'); 
            if (!carsView.classList.contains('hidden')) renderAllCars('cars'); 
        });
        
        filterBrand.addEventListener('change', () => { 
            if (!homeView.classList.contains('hidden')) renderAllCars('home'); 
            if (!carsView.classList.contains('hidden')) renderAllCars('cars'); 
        });
        
        homeSearchBtn.addEventListener('click', () => { renderAllCars('home'); });

        if (!authView.classList.contains('hidden')) {
            // nothing
        } else {
            updateBookingDropdown();
        }
    })();
</script>
</body>
</html>
