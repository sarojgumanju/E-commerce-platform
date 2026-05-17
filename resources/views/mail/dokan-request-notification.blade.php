<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Dokan Registration</title>
</head>
<body style="margin:0; padding:20px; background:#f1f5f9; font-family:Segoe UI, system-ui, sans-serif;">
    
    <div style="max-width:600px; margin:0 auto; background:#ffffff; border-radius:20px; overflow:hidden; box-shadow:0 10px 30px rgba(0,0,0,0.08);">
        
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #0b1e33, #13294b); color:white; padding:35px 40px; text-align:center;">
            <h1 style="margin:0; font-size:28px; font-weight:800; letter-spacing:-0.5px;">
                SAROJ<span style="color:#f97316;">HUB</span>
            </h1>
            <p style="margin:8px 0 0 0; opacity:0.9; font-size:17px;">New Dokan Registration Request</p>
        </div>

        <!-- Content -->
        <div style="padding:40px;">
            <h2 style="margin:0 0 25px 0; font-size:24px; color:#0b1e33;">New Vendor Application Received</h2>
            
            <p style="margin-bottom:25px; color:#475569; font-size:16px;">
                A new seller has requested to join your platform.
            </p>

            <!-- Info Card -->
            <div style="background:#f8fafc; border:1px solid #e2e8f0; border-radius:16px; padding:25px; margin-bottom:30px;">
                
                <div style="display:flex; margin-bottom:18px;">
                    <div style="width:140px; font-weight:600; color:#475569;">Name</div>
                    <div style="flex:1; font-weight:500; color:#0f172a;">{{ $dokan->name }}</div>
                </div>
                
                <div style="display:flex; margin-bottom:18px;">
                    <div style="width:140px; font-weight:600; color:#475569;">Email</div>
                    <div style="flex:1; font-weight:500; color:#0f172a;">{{ $dokan->email }}</div>
                </div>
                
                <div style="display:flex; margin-bottom:18px;">
                    <div style="width:140px; font-weight:600; color:#475569;">Contact</div>
                    <div style="flex:1; font-weight:500; color:#0f172a;">{{ $dokan->contact_no }}</div>
                </div>
            </div>

            <!-- Message -->
            @if($dokan->message)
            <div style="margin-bottom:30px;">
                <strong style="color:#475569;">Message from Dokan:</strong>
                <div style="margin-top:12px; background:white; border-left:5px solid #f97316; padding:20px; border-radius:8px; font-style:italic; color:#334155;">
                    "{{ $dokan->message }}"
                </div>
            </div>
            @endif

            <!-- Button -->
            <div style="text-align:center; margin-top:35px;">
                <a href="{{ url('/admin/dokans') }}" 
                   style="display:inline-block; background:#f97316; color:white; padding:16px 36px; 
                          border-radius:12px; text-decoration:none; font-weight:600; font-size:16px;">
                    Review Application →
                </a>
            </div>
        </div>

        <!-- Footer -->
        <div style="text-align:center; padding:30px; background:#f8fafc; color:#64748b; font-size:14px;">
            <p style="margin:0;">Saroj Hub • E-commerce Platform</p>
            <p style="margin:8px 0 0 0; font-size:13px;">
                This is an automated notification.
            </p>
        </div>
    </div>
</body>
</html>