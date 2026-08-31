<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Candidate Agreement</title>
    <style>
        body {
            font-family: 'Helvetica Neue', Helvetica, Arial, sans-serif;
            color: #333;
            line-height: 1.5;
            margin: 30px;
            position: relative;
        }
        
        /* Watermark Styles */
        .watermark {
            position: fixed;
            top: 35%;
            left: 20%;
            width: 60%;
            opacity: 0.1;
            z-index: -1000;
        }

        .header {
            text-align: center;
            border-bottom: 2px solid #004d99;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .header img.logo {
            max-height: 120px;
            margin-bottom: 10px;
        }
        .header h1 {
            color: #004d99;
            margin: 0;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0;
            color: #666;
            font-size: 14px;
        }
        .content h3 {
            color: #004d99;
            font-size: 16px;
            margin-top: 25px;
            margin-bottom: 10px;
        }
        .content p {
            font-size: 14px;
            margin-bottom: 15px;
            text-align: justify;
        }
        .candidate-details {
            background-color: #f9f9f9;
            padding: 15px;
            border: 1px solid #ddd;
            margin-bottom: 20px;
        }
        .candidate-details table {
            width: 100%;
        }
        .candidate-details td {
            padding: 5px 0;
            font-size: 14px;
        }
        .signature-section {
            margin-top: 30px;
            page-break-inside: avoid;
        }
        .signature-box {
            border-top: 1px solid #333;
            width: 250px;
            padding-top: 5px;
            text-align: center;
            font-size: 14px;
        }
        .signature-img {
            max-width: 250px;
            max-height: 100px;
            margin-bottom: 10px;
        }
        .date {
            margin-top: 30px;
            font-size: 14px;
        }
    </style>
</head>
<body>
    
    <!-- Watermark Image -->
    <img src="{{ public_path('WhatsApp Image 2026-08-05 at 12.56.09 PM.jpeg') }}" class="watermark" alt="Watermark">

    <div class="header">
        <!-- Main Logo -->
        <img src="{{ public_path('WhatsApp Image 2026-08-05 at 12.56.09 PM.jpeg') }}" class="logo" alt="Warriors Educare Logo">
        <h1>Warriors Educare</h1>
        <p>Candidate Placement Agreement</p>
    </div>

    <div class="candidate-details">
        <table style="width: 100%;">
            <tr>
                <td style="width: 80%; vertical-align: top;">
                    <table style="width: 100%;">
                        <tr>
                            <td><strong>Candidate Name:</strong> {{ $user->name }}</td>
                            <td><strong>Date:</strong> {{ $date }}</td>
                        </tr>
                        <tr>
                            <td><strong>Email:</strong> {{ $user->email }}</td>
                            <td><strong>Phone:</strong> {{ $user->phone }}</td>
                        </tr>
                        <tr>
                            <td colspan="2"><strong>Address:</strong> {{ $profile->address }}</td>
                        </tr>
                    </table>
                </td>
                <td style="width: 20%; text-align: right; vertical-align: top;">
                    @if(isset($photo) && !empty($photo))
                        <img src="{{ $photo }}" alt="Candidate Photo" style="width: 80px; max-height: 100px; border: 1px solid #ccc; object-fit: cover;">
                    @endif
                </td>
            </tr>
        </table>
    </div>

    <div class="content">
        <div style="text-align: center; margin-bottom: 20px;">
            <h2 style="margin: 0; color: #031b4e; font-size: 18px;">WARRIORS EDUCARE</h2>
            <h3 style="margin: 5px 0 0 0; color: #004de6; font-size: 15px;">TEACHER PLACEMENT SERVICE AGREEMENT</h3>
            <p style="font-size: 12px; color: #555; margin-top: 5px;">This Agreement is entered into voluntarily between Warriors Educare ("Agency") and the undersigned Candidate ("Teacher").</p>
        </div>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">1. Purpose of Agreement</h4>
        <p>This Agreement confirms that the Candidate willingly authorizes Warriors Educare to begin the recruitment and placement process for suitable teaching opportunities.</p>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">2. Candidate Declaration</h4>
        <p>The Candidate declares that:</p>
        <ul>
            <li>All information and documents submitted are true and genuine.</li>
            <li>Any false information or forged document may result in immediate cancellation of registration and placement without any refund.</li>
            <li>The Candidate agrees to cooperate throughout the recruitment process.</li>
        </ul>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">3. Document Verification</h4>
        <p>The Candidate shall provide all required documents, including but not limited to:</p>
        <ul>
            <li>Aadhaar Card</li>
            <li>Salary slip / Account statement</li>
            <li>Passport-size Photograph</li>
            <li>Any other document required by the school/institution or Warriors Educare.</li>
        </ul>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">4. Registration Charges</h4>
        <p>The Candidate agrees to pay a non-refundable Registration Fee of Rs. 1,000, payable as follows:</p>
        <ul>
            <li><strong>Rs. 500</strong> at the time of registration to initiate the recruitment process.</li>
            <li><strong>Rs. 500</strong> immediately after selection by the school/Institution and before joining.</li>
        </ul>
        <p>Registration fees are charged for profile verification, documentation, screening, interview coordination and placement services. These charges are non-refundable.</p>
        <p><strong>Registration Validity:</strong> The registration shall remain valid for 8 (Eight) months from the date of registration. During this period, Warriors Educare will make reasonable efforts to arrange up to 4–5 suitable interviews, subject to the Candidate's qualifications, preferred location, salary expectations and the availability of vacancies. The registration is non-transferable and non-refundable. After the expiry of the validity period, a fresh registration and the applicable registration fee may be required to continue placement services.</p>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">5. Placement Service Charge</h4>
        <p>After joining the school/Institution and receiving the first month's salary/payment, the Candidate agrees to pay <strong>50% of the first month's gross salary (equivalent to 15 days' salary)</strong> to Warriors Educare as the Placement Service Charge.</p>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">6. Payment Timeline & Delay Charges</h4>
        <ul>
            <li>The Placement Service Charge must be paid <strong>within 12 hours</strong> of receiving the first salary/payment from the school/Institution.</li>
            <li>If payment is not made within the prescribed time, a <strong>Late Payment Penalty of Rs. 300 per day</strong> shall be applicable until full payment is received.</li>
            <li>Warriors Educare reserves the right to suspend future placement services until all dues are cleared.</li>
        </ul>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">7. Job Placement</h4>
        <p>Warriors Educare provides recruitment and placement assistance only. Final selection, salary, benefits, probation, working conditions and employment terms shall be decided solely by the respective school/Institution.</p>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">8. Joining Commitment</h4>
        <p>If the Candidate accepts the offer and confirms joining, they shall not refuse or leave before joining without a genuine reason and prior written/intimated notice to Warriors Educare.</p>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">9. Professional Conduct</h4>
        <p>The Candidate shall maintain professionalism, honesty, discipline and comply with all school policies. Any misconduct, indiscipline or fraudulent activity may result in blacklisting from Warriors Educare.</p>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">10. Confidentiality</h4>
        <p>The Candidate shall not disclose confidential information relating to Warriors Educare, the recruiting school or students to any third party.</p>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">11. No Job Guarantee</h4>
        <p>Registration with Warriors Educare does not guarantee job placement. Selection depends entirely on the school's/Institution's requirements, interview performance and candidate eligibility.</p>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">12. Employment Relationship</h4>
        <p>The Candidate understands that employment shall be with the respective school only. Warriors Educare acts solely as a recruitment and placement agency and shall not be responsible for salary, PF, ESI, leave, incentives or any employment benefits unless otherwise agreed in writing.</p>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">13. Default & Legal Action</h4>
        <p>In case the Candidate intentionally avoids payment of the agreed Placement Service Charge or violates this Agreement, Warriors Educare reserves the right to recover the outstanding amount along with applicable late charges and to initiate appropriate legal proceedings under the applicable laws of India. Any dispute arising out of this Agreement shall be subject to the jurisdiction of the competent courts at Patna, Bihar.</p>

        <h4 style="color: #031b4e; margin-top: 15px; margin-bottom: 5px;">14. Acceptance of Terms</h4>
        <p>By signing this Agreement physically or digitally, the Candidate confirms that:</p>
        <ul>
            <li>They have carefully read and understood all the terms and conditions.</li>
            <li>They voluntarily accept all clauses of this Agreement without any pressure.</li>
            <li>They agree to comply with all payment obligations and conditions mentioned herein.</li>
        </ul>

        <h3 style="text-align: center; font-size: 16px; margin-top: 25px; color: #031b4e;">DECLARATION & ACCEPTANCE</h3>
        
        <p>I, <strong>{{ $user->name }}</strong>, hereby solemnly declare that I have thoroughly read, understood, and willingly accepted all the terms and conditions stated in this document of Warriors Educare.</p>
        <p>I confirm that all personal, academic, and professional details provided by me are true, accurate, and complete. I understand that any false or misleading information may result in immediate cancellation of my registration without any refund.</p>
        <p>I clearly acknowledge and accept that the Registration Fee is non-refundable under any circumstances once paid, irrespective of selection, joining, delay, or personal decision.</p>
        <p>This declaration shall be deemed to constitute a lawful and binding agreement, enforceable in accordance with applicable laws, and subject exclusively to the jurisdiction of Patna, Bihar.</p>
    </div>

    <div class="signature-section" style="margin-top: 60px;">
        <table style="width: 100%;">
            <tr>
                <td style="width: 50%; vertical-align: bottom;">
                    <div class="date" style="margin-bottom: 20px;">
                        <strong>Date of Execution:</strong> {{ $date }}
                    </div>
                </td>
                <td style="width: 50%; text-align: left; padding-left: 25%; padding-top: 30px;">
                    @if(!empty($profile->signature_data))
                        <div style="margin-bottom: 8px;">
                            @if(str_starts_with($profile->signature_data, 'data:image'))
                                <img src="{{ $profile->signature_data }}" alt="Signature" style="max-height: 45px; max-width: 160px; object-fit: contain;">
                            @elseif(Storage::disk('public')->exists($profile->signature_data))
                                <img src="{{ public_path('storage/' . $profile->signature_data) }}" alt="Signature" style="max-height: 45px; max-width: 160px; object-fit: contain;">
                            @elseif($profile->signature_type === 'type')
                                <span style="font-family: 'Brush Script MT', 'Dancing Script', cursive, sans-serif; font-size: 20px; color: #1e3a8a; font-weight: bold;">
                                    {{ $profile->signature_data }}
                                </span>
                            @endif
                        </div>
                    @endif
                    <div style="font-family: 'Times New Roman', Times, serif; font-size: 13px; color: #000; line-height: 1.35;">
                        <div style="font-family: Arial, sans-serif; font-size: 11px; font-weight: bold; color: #059669; margin-bottom: 4px;">
                            DIGITALLY SIGNED & VERIFIED
                        </div>
                        <i>Digitally Signed by</i><br>
                        <i>Name : {{ $user->name }}</i><br>
                        <i>Phone No : ******{{ substr($user->phone ?? '0000', -4) }}</i><br>
                        @if(!empty($profile->signature_location_name))
                            <i>GPS Location : 📍 {{ $profile->signature_location_name }}</i><br>
                        @elseif($profile->latitude && $profile->longitude)
                            <i>GPS Coordinates : 📍 {{ number_format($profile->latitude, 4) }}° N, {{ number_format($profile->longitude, 4) }}° E</i><br>
                        @endif
                        @if(!empty($profile->signature_ip_address))
                            <i>IP Address : 💻 {{ $profile->signature_ip_address }}</i><br>
                        @endif
                        <i>Reason: Candidate Teacher Placement Agreement</i><br>
                        <i>Date : {{ \Carbon\Carbon::parse($profile->signature_date_time ?? now())->format('D M d H:i:s T Y') }}</i><br>
                        <i>Identity Verification : {{ $profile->live_photo_path ? 'Live Camera Snapshot Verified ✅' : 'Verified Digital Signature ✅' }}</i>
                    </div>
                </td>
            </tr>
        </table>
    </div>

</body>
</html>
