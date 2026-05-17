<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Dokan Account Credentials - Saroj Hub</title>
</head>
<body style="margin:0; padding:20px; background:#f1f5f9; font-family:Segoe UI, system-ui, sans-serif;">
    
    <div style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08);">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0b1e33, #13294b); color:white; padding:35px 40px; text-align:center;">
            <h1 style="margin:0; font-size:28px; font-weight:800; letter-spacing:-0.5px;">
                SAROJ<span style="color:#f97316;">HUB</span>
            </h1>
            <p style="margin:10px 0 0 0; opacity:0.9; font-size:18px;">🎉 Your Dokan is Approved!</p>
        </div>

        <!-- Content -->
        <div style="padding:40px;">
            <h2 style="margin:0 0 25px 0; font-size:24px; color:#0b1e33;">
                Welcome aboard!
            </h2>
            
            <p style="font-size:16px; color:#334155; line-height:1.7; margin-bottom:30px;">
                Your dokan registration has been approved. Here are your login credentials:
            </p>

            <!-- Credentials Box -->
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:16px; padding:28px; margin-bottom:30px;">
                
                <div style="margin-bottom:22px;">
                    <div style="color:#475569; font-size:14px; font-weight:600; margin-bottom:6px;">EMAIL ADDRESS</div>
                    <div style="font-size:17px; font-weight:600; color:#0f172a;">
                        {{ $data['email'] ?? $data->email ?? 'N/A' }}
                    </div>
                </div>

                <div>
                    <div style="color:#475569; font-size:14px; font-weight:600; margin-bottom:6px;">TEMPORARY PASSWORD</div>
                    <div style="background:#ffffff; padding:14px 18px; border-radius:10px; border:1px solid #e2e8f0; font-size:18px; font-weight:700; letter-spacing:2px; color:#0f172a;">
                        {{ $password }}
                    </div>
                </div>

                <div style="margin-top:20px; padding:14px; background:#fef3c7; border-radius:10px; font-size:14.5px; color:#92400e;">
                    <strong>⚠️ Important:</strong> Please change your password after your first login for security.
                </div>
            </div>

            <!-- Login Button -->
            <div style="text-align:center; margin:35px 0 25px 0;">
                <a href="{{ url('/dokan/login') }}" 
                   style="display:inline-block; background:#f97316; color:white; padding:16px 42px; 
                          border-radius:12px; text-decoration:none; font-weight:600; font-size:17px;">
                    Login to My Dashboard →
                </a>
            </div>

            <p style="text-align:center; color:#64748b; font-size:15px;">
                Or visit: <a href="{{ url('/dokan/login') }}" style="color:#f97316;">{{ url('/dokan/login') }}</a>
            </p>
        </div>

        <!-- Footer -->
        <div style="text-align:center; padding:30px; background:#f8fafc; color:#64748b; font-size:14px; border-top:1px solid #e2e8f0;">
            <p style="margin:0;">Saroj Hub E-commerce Platform</p>
            <p style="margin:8px 0 0 0; font-size:13px;">
                This is an automated email. Do not share your password with anyone.
            </p>
        </div>
    </div>
</body>
</html>