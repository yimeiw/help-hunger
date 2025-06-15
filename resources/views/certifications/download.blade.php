<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Certificate</title>
    <style>
        @page {
            size: A4 landscape;
            margin: 0;
        }

        html, body {
            width: 297mm;
            height: 210mm;
            margin: 0;
            padding: 0;
            overflow: hidden;
            font-family: 'DejaVu Sans', sans-serif;
            background-color: #3F8044; /* greenbg */
            color: #1e1e1e;
        }

        .certificate-inner {
            background-color: #FFF7D9; /* creamcard inner content */
            margin: 30px;
            padding: 30px;
            border: 10px solid #3F8044;
            position: relative;
            width: calc(100% - 60px);
            height: calc(100% - 60px);
            box-sizing: border-box;
            text-align: center;
        }

        .logo {
            position: absolute;
            top: 30px;
            left: 30px;
            width: 100px;
        }

        .svg-border {
            position: absolute;
            width: 100px;
            height: 100px;
        }

        .svg-top-left { top: 0; left: 0; }
        .svg-top-right { top: 0; right: 0; }
        .svg-bottom-left { bottom: 0; left: 0; }
        .svg-bottom-right { bottom: 0; right: 0; }

        .title-svg {
            width: 300px;
            margin: 20px auto;
        }

        .participant-name {
            font-size: 32px;
            font-weight: bold;
            margin: 25px 0 10px 0;
            color: #902B29;
        }

        .event-details {
            font-size: 16px;
            margin-top: 20px;
        }

        .signatures {
            margin-top: 40px;
            display: flex;
            justify-content: space-between;
            padding: 0 80px;
        }

        .signature {
            text-align: center;
        }

        .signature-name {
            border-top: 1px solid #000;
            margin-top: 10px;
            font-size: 13px;
        }

        .signature-title {
            font-size: 11px;
            color: #555;
        }
    </style>
</head>
<body>
    {{-- Border SVG --}}
    <img src="file://{{ public_path($tl_border_path) }}" class="svg-border svg-top-left" alt="">
    <img src="file://{{ public_path($tr_border_path) }}" class="svg-border svg-top-right" alt="">
    <img src="file://{{ public_path($bl_border_path) }}" class="svg-border svg-bottom-left" alt="">
    <img src="file://{{ public_path($br_border_path) }}" class="svg-border svg-bottom-right" alt="">

    <div class="certificate-inner">
        {{-- Logo --}}
        <img src="file://{{ public_path($helphungerLogoPath) }}" class="logo" alt="Logo">

        {{-- Judul (SVG Title) --}}
        <img src="file://{{ public_path('assets/sertif/title-cert.svg') }}" class="title-svg" alt="Certificate Title">

        {{-- Participant Name --}}
        <div class="participant-name">{{ $participantName }}</div>

        {{-- Decorative Line --}}
        <img src="file://{{ public_path($decorativeLinePath) }}" alt="Line" style="width: 250px; margin-top: 5px;">

        {{-- Event Details --}}
        <div class="event-details">
            For your role as a
            <strong style="color:#3F8044">{{ strtoupper($is_volunteer ? 'Volunteer' : 'Donor') }}</strong>
            in the event<br>
            <strong>"{{ $eventName }}"</strong><br>
            held from {{ $startDate }} to {{ $endDate }}.
        </div>

        {{-- Signatures --}}
        <div class="signatures">
            <div class="signature">
                <img src="file://{{ public_path('assets/sertif/sign-organizer.png') }}" width="100">
                <div class="signature-name">Organizer Name</div>
                <div class="signature-title">Event Organizer</div>
            </div>
            <div class="signature">
                <img src="file://{{ public_path('assets/sertif/sign-advisor.png') }}" width="100">
                <div class="signature-name">Advisor Name</div>
                <div class="signature-title">Advisor</div>
            </div>
        </div>
    </div>
</body>
</html>