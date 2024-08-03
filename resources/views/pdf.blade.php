<!DOCTYPE html>
<html>

<head>
    <title>{{ $nameBadgeData['events']['event_name'] }}</title>
    <style>
        body {
            font-family: sans-serif;
        }

        .badge-container {
            width: 5in;
            height: 4in;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            margin: 0 auto;
        }

        .badge-header {
            text-align: center;
            margin-top: 20px;
        }

        .badge-header h3 {
            color: #1e40af;
            font-size: 1.5rem;
        }

        .badge-qr-container {
            width: 100%;
            margin-left: 40%;
            height: 100px;
            margin-top: 20px;
            margin-bottom: 20px;
        }

        .badge-footer {
            width: 100%;
            height: 1.5in;
            background-color: #1e40af;
            margin-top: 10px;
        }

        .badge-footer ul {
            margin-left: 20px;
            padding-top: 25px;
            list-style-type: none;
        }

        .badge-footer li {
            color: white;
            margin-top: 2px;
            padding: 5px 0 5px 0;
            font-size: 15px;
            text-decoration: underline;
        }

        .badge-footer li span {
            font-size: 0.875rem;
        }
    </style>
</head>

<body style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center;">
    <div class="badge-container">
        <div class="badge-header">
            <h3>{{ $nameBadgeData['events']['event_name'] }}</h3>
        </div>
        <div class="badge-qr-container">
            <div class="badge-qr">
                {!! $qrCode !!}
            </div>
        </div>
        <div style="text-align: center; letter-spacing: 2px; color: #1e40af;">
            <h3>{{ $nameBadgeData['attendees_types']['name'] }}</h3>
        </div>
        <div class="badge-footer">
            <ul>
                <li>{{ $nameBadgeData['register_attendees']['name'] }}</li>
                <li><span>{{ $nameBadgeData['register_attendees']['department'] }}</span></li>
                <li><span>{{ $nameBadgeData['register_attendees']['position'] }}</span></li>
            </ul>
        </div>
    </div>
</body>

</html>
