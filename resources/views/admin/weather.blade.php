<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Weather Card</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background: #f7f9fc;
            display: flex;
            justify-content: center;
            margin-top: 50px;
        }

        .weather-card {
            border: 1px solid #ccc;
            padding: 20px;
            border-radius: 12px;
            width: 400px;
            background: #fff;
            box-shadow: 0 4px 8px rgba(0,0,0,0.1);
        }

        .weather-main {
            display: flex;
            align-items: center;
            justify-content: space-between;
        }

        .weather-icon {
            font-size: 48px;
            color: #f39c12;
        }

        .weather-info {
            font-size: 20px;
        }

        .weather-details {
            display: flex;
            flex-wrap: wrap;
            margin-top: 15px;
        }

        .weather-details div {
            width: 50%;
            margin-bottom: 10px;
            font-size: 14px;
        }

        .dot-red {
            color: red;
            font-weight: bold;
        }
    </style>
</head>
<body>

<div class="weather-card">
    <div class="weather-main">
        <div class="weather-icon">🌫️</div>
        <div class="weather-info">
            <div><strong>39°C</strong> - Haze</div>
            <div>Feels like: 41°</div>
            <div style="margin-top: 10px;">Mostly sunny. High: 40°</div>
        </div>
    </div>

    <div class="weather-details">
        <div><strong class="dot-red">Air Quality:</strong> 180</div>
        <div><strong>Wind:</strong> 6 km/h</div>
        <div><strong>Humidity:</strong> 14%</div>
        <div><strong>Visibility:</strong> 5 km</div>
        <div><strong>Pressure:</strong> 1004 mb</div>
        <div><strong>Dew Point:</strong> 7°</div>
    </div>
</div>

</body>
</html>
