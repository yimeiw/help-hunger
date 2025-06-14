<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate of Appreciation</title>
    <style>
        body {
            font-family: 'Arial', sans-serif;
            margin: 0;
            padding: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            min-height: 100vh;
            background-color: #f0f0f0;
            position: relative;
            background-image: url('{{ public_path("images/certificate_background.jpg") }}'); /* Ganti dengan path gambar latar belakang Anda */
            background-size: cover;
            background-position: center;
            background-repeat: no-repeat;
            page-break-after: always; /* Pastikan sertifikat berada di halaman terpisah jika ada banyak */
        }
        .certificate-container {
            width: 21cm; /* A4 width */
            height: 29.7cm; /* A4 height */
            /* width: 29.7cm; /* A4 landscape width */
            /* height: 21cm; /* A4 landscape height */
            padding: 2cm;
            box-sizing: border-box;
            text-align: center;
            color: #333;
            position: relative;
            z-index: 1; /* Pastikan konten di atas latar belakang */
        }
        .certificate-title {
            font-size: 2.5em;
            color: #b22222; /* Merah Marun */
            margin-bottom: 20px;
            text-transform: uppercase;
            letter-spacing: 2px;
        }
        .certificate-subtitle {
            font-size: 1.2em;
            color: #555;
            margin-bottom: 40px;
        }
        .name {
            font-size: 2.8em;
            font-weight: bold;
            color: #b22222; /* Merah Marun */
            margin: 30px 0;
            border-bottom: 2px solid #b22222;
            padding-bottom: 10px;
            display: inline-block;
        }
        .event-details {
            font-size: 1.3em;
            margin: 30px 0;
            line-height: 1.5;
        }
        .date {
            font-size: 1.1em;
            margin-top: 50px;
            color: #666;
        }
        .signature-line {
            margin-top: 80px;
            display: flex;
            justify-content: space-around;
            width: 80%;
            margin-left: auto;
            margin-right: auto;
        }
        .signature-block {
            text-align: center;
            margin-top: 20px;
        }
        .signature-name {
            border-top: 1px solid #333;
            padding-top: 5px;
            font-weight: bold;
        }
        .signature-title {
            font-size: 0.9em;
            color: #555;
        }
        .qr-code {
            position: absolute;
            bottom: 2cm;
            right: 2cm;
            width: 100px;
            height: 100px;
        }
    </style>
</head>
<body>
    <div class="certificate-container">
        <div class="certificate-title">Certificate of Appreciation</div>
        <div class="certificate-subtitle">Proudly presented to</div>

        <div class="name">{{ $volunteerName }}</div>

        <div class="event-details">
            for their invaluable contribution as a volunteer in the<br>
            <strong>"{{ $eventName }}"</strong> event, held from {{ $startDate }} to {{ $endDate }}.<br>
            Their dedication and commitment have been instrumental to the success of this initiative.
        </div>

        <div class="date">Issued on: {{ $issueDate }}</div>

        <div class="signature-line">
            <div class="signature-block">
                <img src="{{ public_path('images/signature_placeholder.png') }}" alt="Signature" style="height: 60px; margin-bottom: 5px;"><br>
                <div class="signature-name">John Doe</div>
                <div class="signature-title">Event Organizer</div>
            </div>
            <div class="signature-block">
                <img src="{{ public_path('images/signature_placeholder.png') }}" alt="Signature" style="height: 60px; margin-bottom: 5px;"><br>
                <div class="signature-name">Jane Smith</div>
                <div class="signature-title">Program Coordinator</div>
            </div>
        </div>

    </div>
</body>
</html>