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
            height: 2.5in;
            border: 1px solid #ccc;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            padding: 10px;
            margin: 0 auto;
            display: flex;
            align-items: center;
        }

        .badge-header h3 {
            color: black;
            font-size: 1.7rem;
        }

        .badge-qr-container {
            width: 100%;
            margin-left: 40%;
            height: 100px;
            margin-top: 70px;
        }
    </style>
</head>

<body style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center;">
    <div class="badge-container">

        <div class="badge-qr-container">
            <div class="badge-qr">
                {!! $qrCode !!}
            </div>
        </div>

    </div>
</body>

</html>
