<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <style>
        @page { margin: 0; }
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            background-color: #ffffff;
        }
        .badge-table {
            width: 5in;
            height: 2.5in;
            border: 1px solid #e5e7eb;
            border-collapse: collapse;
            margin: 20px auto;
            table-layout: fixed;
        }
        .accent-bar {
            background-color: #4f46e5;
            height: 8px;
            font-size: 1px;
            line-height: 8px;
        }
        .event-name {
            font-size: 20px;
            font-weight: bold;
            color: #111827;
            text-transform: uppercase;
        }
        .event-details {
            font-size: 10px;
            color: #4b5563;
        }
        .qr-border {
            border: 1px solid #f3f4f6;
            background-color: #f9fafb;
            padding: 8px;
            border-radius: 4px;
        }
        .footer-text {
            font-size: 9px;
            text-transform: uppercase;
            color: #9ca3af;
            letter-spacing: 1px;
            border-top: 1px solid #eeeeee;
            padding-top: 5px;
        }
    </style>
</head>
<body>
    <table class="badge-table" cellpadding="0" cellspacing="0">
        <tr>
            <td class="accent-bar" colspan="3"></td>
        </tr>

        <tr>
            <td align="center" valign="middle" style="padding: 10px;">

                <table width="100%" cellpadding="0" cellspacing="0">
                    <tr>
                        <td align="center" class="event-name">
                            {{ $nameBadgeData['events']['event_name'] }}
                        </td>
                    </tr>
                    <tr>
                        <td align="center" class="event-details" style="padding-top: 5px;">
                            DATE: {{ $nameBadgeData['events']['start_date'] }} to {{ $nameBadgeData['events']['end_date'] }}
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding: 12px 0;">
                            <table cellpadding="0" cellspacing="0">
                                <tr>
                                    <td class="qr-border">
                                        <div style="width: 90px; height: 90px;">
                                            {!! $qrCode !!}
                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>

                    <tr>
                        <td align="center" class="event-details">
                            TIME: {{ $nameBadgeData['events']['start_time'] }} - {{ $nameBadgeData['events']['end_time'] }}
                        </td>
                    </tr>

                    <tr>
                        <td align="center" style="padding-top: 10px;">
                            <div class="footer-text">SCAN FOR VERIFICATION</div>
                        </td>
                    </tr>
                </table>

            </td>
        </tr>
    </table>
</body>
</html>
