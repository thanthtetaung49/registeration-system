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
        }

        .badge-header {
            text-align: center;
            /* margin-top: 12px; */
        }

        .badge-header h3 {
            color: black;
            font-size: 1.7rem;
        }

        .badge-qr-container {
            width: 100%;
            margin-left: 40%;
            height: 100px;
            margin-top: 15px;
            /* margin-bottom: 20px; */
        }
    </style>
</head>

<body style="width: 100%; height: 100vh; display: flex; justify-content: center; align-items: center;">
    <div class="badge-container">
        <div class="badge-header">
            @if (!empty($nameBadgeData['attendees_types']['name']))
                <div>
                    <h3 style="margin-bottom: 0px; margin-top: 25px;">{{ $nameBadgeData['register_attendees']['name'] }}
                    </h3>
                    <p style="font-size: 20px; margin-top: 15px; text-transform: uppercase">{{ $nameBadgeData['attendees_types']['name'] }}</p>
                </div>
            @else
                <h3 style="margin-top: 20px">{{ $nameBadgeData['register_attendees']['name'] }} (-)
        @endif

    </div>
    <div class="badge-qr-container">
        <div class="badge-qr">
            {!! $qrCode !!}
        </div>
    </div>

</div>
</body>

</html>
