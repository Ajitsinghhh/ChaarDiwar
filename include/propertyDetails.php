<html>
<head>
    <title>Property Details</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0;
            padding: 0;
            background-color: #f5f5f5;
        }
        .container {
            display: flex;
            min-height: 100vh;
        }
        .sidebar {
            width: 250px;
            margin: 6px;
            background-color: #fff;
            border-right: 1px solid #ddd;
            padding: 20px;
        }
        .sidebar button {
            display: flex;
            align-items: center;
            margin-top: 22px;
            margin-bottom: 22px;
            padding: 10px 0;
            color: #333;
            background:#f5f5f5;
            border:1px solid #f5f5f5  ;
            font-size: 16px;
            width: 100%;
            text-align: left;
            cursor: pointer;
        }
        .sidebar button i {
            margin-right: 10px;
            font-size: 20px;
        }
        .sidebar a{
            text-decoration: none;
        }
        .sidebar button.active,
        .sidebar button:hover {
            color: #009688;
            font-weight: bold;
        }
        .content {
            flex: 1;
            padding: 20px;
            margin: 6px;
            background-color: #fff;
        }
        .content h2 {
            color: #009688;
            margin-bottom: 20px;
        }
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            margin-bottom: 5px;
            font-weight: bold;
        }
        .form-group select,
        .form-group input {
            width: 100%;
            padding: 10px;
            border: 1px solid #ddd;
            border-radius: 4px;
        }
        .form-group .input-group {
            display: flex;
            align-items: center;
        }
        .form-group .input-group input {
            flex: 1;
        }
        .form-group .input-group span {
            padding: 10px;
            background-color: #f5f5f5;
            border: 1px solid #ddd;
            border-left: 0;
            border-radius: 0 4px 4px 0;
        }
        .form-row {
            display: flex;
            gap: 20px;
        }
        .form-row .form-group {
            flex: 1;
        }
        .form-actions {
            text-align: right;
            margin-top: 20px;
        }
        .form-actions button {
            padding: 10px 20px;
            background-color: #009688;
            color: #fff;
            border: none;
            border-radius: 4px;
            cursor: pointer;
            font-size: 16px;
        }
        .form-actions button:hover {
            background-color: #00796b;
        }
        @media (max-width: 768px) {
            .container {
                flex-direction: column;
            }
            .sidebar {
                width: 100%;
                border-right: none;
                border-bottom: 1px solid #ddd;
            }
            .form-row {
                flex-direction: column;
            }
        }
    </style>
</head>
<body>
    <?php
    include("header_nav.php");
        ?>
    <div class="container">
        <div class="sidebar">
            <button class="active" onclick="activateButton(this)"><i class="fas fa-home"></i> Property Details</button>
            <a href="locationform.html"><button onclick="activateButton(this)"><i class="fas fa-map-marker-alt"></i> Locality Details</button></a>
            <a href="rentailDetails.html"><button onclick="activateButton(this)"><i class="fas fa-building"></i> Rental Details</button></a>
            <a href="Amenities.html"><button onclick="activateButton(this)"><i class="fas fa-concierge-bell"></i> Amenities</button></a>
            <a href="uploadimg.html"> <button onclick="activateButton(this)"><i class="fas fa-camera"></i> Gallery</button>
            <a href="schedule.html"><button onclick="activateButton(this)"><i class="fas fa-calendar-alt"></i> Schedule</button></a>
        </div>
        <div class="content">
            <h2>Property Details</h2>
            <div class="form-group">
                <label for="apartment-type">Apartment Type*</label>
                <div class="input-group">
                    <select id="apartment-type">
                            <option>Select City</option>
                            <option>Mumbai</option>
                            <option>Delhi</option>
                            <option>Bangalore</option>
                            <option>Chennai</option>
                            <option>Pune</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="bhk-type">BHK Type*</label>
                    <select id="bhk-type">
                        <option>Select City</option>
                        <option>Mumbai</option>
                        <option>Delhi</option>
                        <option>Bangalore</option>
                        <option>Chennai</option>
                        <option>Pune</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="floor">Floor*</label>
                    <select id="floor">
                        <option>Select City</option>
                        <option>Mumbai</option>
                        <option>Delhi</option>
                        <option>Bangalore</option>
                        <option>Chennai</option>
                        <option>Pune</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="total-floor">Total Floor*</label>
                    <select id="total-floor">
                        <option>Select City</option>
                            <option>Mumbai</option>
                            <option>Delhi</option>
                            <option>Bangalore</option>
                            <option>Chennai</option>
                            <option>Pune</option>
                    </select>
                </div>
            </div>
            <div class="form-row">
                <div class="form-group">
                    <label for="property-age">Property Age*</label>
                    <select id="property-age">
                        <option>Select City</option>
                            <option>Mumbai</option>
                            <option>Delhi</option>
                            <option>Bangalore</option>
                            <option>Chennai</option>
                            <option>Pune</option>
                    </select>
                </div>
                <div class="form-group">
                    <label for="facing">Facing</label>
                    <select id="facing">
                        <option>Select City</option>
                        <option>Mumbai</option>
                        <option>Delhi</option>
                        <option>Bangalore</option>
                        <option>Chennai</option>
                        <option>Pune</option>
                    </select>
                </div>
            </div>
            <div class="form-group">
                <label for="built-up-area">Built Up Area*</label>
                <div class="input-group">
                    <input type="text" id="built-up-area" placeholder="Built Up Area">
                    <span>Sq.ft</span>
                </div>
            </div>
            <div class="form-actions">
                <button>Save and Continue</button>
            </div>
        </div>
    </div>
    <script>
        function activateButton(button) {
            var buttons = document.querySelectorAll('.sidebar button');
            buttons.forEach(function(btn) {
                btn.classList.remove('active');
            });
            button.classList.add('active');
        }
    </script>
</body>
</html>