<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=yes">
  <meta http-equiv="X-UA-Compatible" content="ie=edge">
  <title>Saroj Hub • Vendor Registration</title>
  <!-- Vite assets (Tailwind + JS) -->
  @vite(['resources/css/app.css', 'resources/js/app.js'])
  <!-- Font Awesome 7 -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

  <!-- Custom Style: root variables, container, sections -->
  <style>
    :root {
      /* Saroj Hub palette */
      --color-primary: #0b1e33;      /* deep navy */
      --color-primary-soft: #13294b;
      --color-accent: #f97316;       /* vibrant orange */
      --color-accent-hover: #ea580c;
      --color-surface: #ffffff;
      --color-muted: #f8fafc;
      --color-border: #e2e8f0;
      --color-text: #0f172a;
      --color-text-light: #475569;
      --color-success: #10b981;
      --color-warning: #f59e0b;
      --radius-card: 1.25rem;
      --radius-btn: 0.75rem;
      --shadow-sm: 0 10px 20px -8px rgba(0,0,0,0.04);
      --shadow-card: 0 20px 35px -10px rgba(0,0,0,0.05), 0 8px 15px -6px rgba(0,0,0,0.02);
      --transition: all 0.25s ease;
    }

    body {
      margin: 0;
      font-family: 'Inter', system-ui, -apple-system, 'Segoe UI', Roboto, sans-serif;
      background: #f9fafc;
      color: var(--color-text);
      line-height: 1.5;
      -webkit-font-smoothing: antialiased;
    }

    /* ----- container: 86% width, auto margin ----- */
    .container {
      width: 86%;
      max-width: 1400px;
      margin-left: auto;
      margin-right: auto;
    }

    /* HEADER / NAVBAR */
    .navbar {
      background: var(--color-surface);
      border-bottom: 1px solid rgba(226, 232, 240, 0.7);
      padding: 1rem 0;
      position: sticky;
      top: 0;
      z-index: 50;
      backdrop-filter: blur(12px);
      background: rgba(255,255,255,0.9);
      box-shadow: var(--shadow-sm);
    }

    .nav-container {
      display: flex;
      align-items: center;
      justify-content: space-between;
      flex-wrap: wrap;
    }

    .logo {
      font-size: 1.8rem;
      font-weight: 800;
      color: var(--color-primary);
      letter-spacing: -0.5px;
      display: flex;
      align-items: center;
      gap: 0.3rem;
      text-decoration: none;
    }
    .logo i {
      color: var(--color-accent);
      font-size: 2rem;
    }

    .nav-links {
      display: flex;
      align-items: center;
      gap: 2rem;
      list-style: none;
      margin: 0;
      padding: 0;
      flex-wrap: wrap;
    }

    .nav-links a {
      text-decoration: none;
      font-weight: 500;
      color: var(--color-text);
      transition: var(--transition);
      display: flex;
      align-items: center;
      gap: 0.3rem;
      font-size: 0.95rem;
    }

    .nav-links a:hover {
      color: var(--color-accent);
    }

    .nav-actions {
      display: flex;
      align-items: center;
      gap: 1.2rem;
    }

    .icon-btn {
      background: none;
      border: none;
      font-size: 1.3rem;
      color: var(--color-text);
      cursor: pointer;
      transition: var(--transition);
      position: relative;
    }
    .icon-btn:hover {
      color: var(--color-accent);
    }
    .badge {
      position: absolute;
      top: -6px;
      right: -10px;
      background: var(--color-accent);
      color: white;
      border-radius: 50%;
      width: 18px;
      height: 18px;
      font-size: 0.7rem;
      display: flex;
      align-items: center;
      justify-content: center;
      font-weight: bold;
    }

    /* MAIN SECTIONS */
    .section-gap {
      padding-top: 4rem;
      padding-bottom: 4rem;
    }

    .register-card {
      background: var(--color-surface);
      border-radius: var(--radius-card);
      box-shadow: var(--shadow-card);
      border: 1px solid rgba(226, 232, 240, 0.5);
      transition: var(--transition);
    }

    .input-field {
      width: 100%;
      padding: 0.9rem 1.2rem;
      background: var(--color-muted);
      border: 1.5px solid var(--color-border);
      border-radius: 0.9rem;
      font-size: 0.95rem;
      color: var(--color-text);
      transition: var(--transition);
      outline: none;
    }
    .input-field:focus {
      border-color: var(--color-accent);
      box-shadow: 0 0 0 4px rgba(249, 115, 22, 0.15);
      background: white;
    }

    .btn-primary {
      background: var(--color-accent);
      color: white;
      font-weight: 600;
      padding: 0.9rem 2rem;
      border-radius: var(--radius-btn);
      border: none;
      cursor: pointer;
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      gap: 0.5rem;
      box-shadow: 0 8px 18px -6px rgba(249, 115, 22, 0.35);
    }
    .btn-primary:hover {
      background: var(--color-accent-hover);
      transform: translateY(-2px);
    }

    .btn-outline {
      background: transparent;
      border: 1.5px solid var(--color-primary-soft);
      color: var(--color-primary);
      font-weight: 600;
      padding: 0.75rem 1.8rem;
      border-radius: var(--radius-btn);
      transition: var(--transition);
      display: inline-flex;
      align-items: center;
      gap: 0.4rem;
    }
    .btn-outline:hover {
      background: var(--color-primary);
      color: white;
    }

    .decorative-line {
      height: 4px;
      width: 65px;
      background: var(--color-accent);
      border-radius: 5px;
      margin: 0.6rem 0 1.2rem 0;
    }

    /* FOOTER */
    .footer {
      background: var(--color-primary);
      color: #e2e8f0;
      padding: 2.5rem 0 1.5rem;
      margin-top: 2rem;
    }
    .footer a {
      color: #cbd5e1;
      text-decoration: none;
      transition: var(--transition);
    }
    .footer a:hover {
      color: var(--color-accent);
    }

    @media (max-width: 768px) {
      .container {
        width: 92%;
      }
      .nav-container {
        flex-direction: column;
        gap: 1rem;
      }
      .nav-links {
        gap: 1.2rem;
        justify-content: center;
      }
    }
  </style>
</head>
<body>
  @include('sweetalert::alert')

  <!-- ========== HEADER SECTION ========== -->
  <x-frontend-header/>

  <!-- ========== MAIN SECTION ========== -->
  {{ $slot }}

  <!-- ========== FOOTER SECTION ========== -->
  <x-frontend-footer/>

  
</body>
</html>