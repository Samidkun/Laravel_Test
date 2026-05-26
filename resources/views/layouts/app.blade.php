<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Book Catalog Practice') Mini CRUD</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --bg-color: #0f172a;
            --text-color: #f8fafc;
            --primary: #6366f1;
            --primary-hover: #4f46e5;
            --secondary: #1e293b;
            --accent: #38bdf8;
            --card-bg: rgba(30, 41, 59, 0.7);
            --card-border: rgba(255, 255, 255, 0.08);
            --success: #10b981;
            --danger: #ef4444;
            --muted: #94a3b8;
        }

        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Outfit', sans-serif;
        }

        body {
            background-color: var(--bg-color);
            color: var(--text-color);
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            background-image: 
                radial-gradient(circle at 10% 20%, rgba(99, 102, 241, 0.15) 0%, transparent 40%),
                radial-gradient(circle at 90% 80%, rgba(56, 189, 248, 0.1) 0%, transparent 40%);
            background-attachment: fixed;
        }

        header {
            background: rgba(15, 23, 42, 0.8);
            backdrop-filter: blur(12px);
            border-bottom: 1px solid var(--card-border);
            padding: 1.25rem 2rem;
            position: sticky;
            top: 0;
            z-index: 100;
        }

        .nav-container {
            max-width: 1200px;
            margin: 0 auto;
            display: flex;
            justify-content: space-between;
            align-items: center;
        }

        .logo {
            font-size: 1.5rem;
            font-weight: 700;
            background: linear-gradient(135deg, #6366f1, #38bdf8);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .logo span {
            color: var(--text-color);
            -webkit-text-fill-color: var(--text-color);
        }

        .nav-links a {
            color: var(--muted);
            text-decoration: none;
            font-weight: 500;
            transition: color 0.2s ease;
            font-size: 0.95rem;
        }

        .nav-links a:hover {
            color: var(--text-color);
        }

        main {
            flex: 1;
            width: 100%;
            max-width: 1200px;
            margin: 2.5rem auto;
            padding: 0 2rem;
        }

        /* Common Elements styling */
        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.625rem 1.25rem;
            border-radius: 8px;
            font-size: 0.9rem;
            font-weight: 500;
            text-decoration: none;
            cursor: pointer;
            transition: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
            border: none;
            gap: 0.5rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
            box-shadow: 0 4px 12px rgba(99, 102, 241, 0.3);
        }

        .btn-primary:hover {
            background-color: var(--primary-hover);
            transform: translateY(-2px);
            box-shadow: 0 6px 16px rgba(99, 102, 241, 0.4);
        }

        .btn-secondary {
            background-color: var(--secondary);
            color: var(--text-color);
            border: 1px solid var(--card-border);
        }

        .btn-secondary:hover {
            background-color: rgba(30, 41, 59, 0.9);
            transform: translateY(-2px);
        }

        .btn-danger {
            background-color: rgba(239, 68, 68, 0.15);
            color: var(--danger);
            border: 1px solid rgba(239, 68, 68, 0.3);
        }

        .btn-danger:hover {
            background-color: var(--danger);
            color: white;
            transform: translateY(-2px);
            box-shadow: 0 4px 12px rgba(239, 68, 68, 0.3);
        }

        .btn-sm {
            padding: 0.4rem 0.8rem;
            font-size: 0.8rem;
            border-radius: 6px;
        }

        /* Alert Messages */
        .alert {
            padding: 1rem 1.25rem;
            border-radius: 8px;
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
            font-size: 0.95rem;
            animation: slideIn 0.3s ease;
        }

        .alert-success {
            background: rgba(16, 185, 129, 0.15);
            border: 1px solid rgba(16, 185, 129, 0.3);
            color: #34d399;
        }

        .card {
            background: var(--card-bg);
            backdrop-filter: blur(16px);
            border: 1px solid var(--card-border);
            border-radius: 12px;
            padding: 2rem;
            box-shadow: 0 8px 32px 0 rgba(0, 0, 0, 0.37);
        }

        footer {
            text-align: center;
            padding: 2rem;
            color: var(--muted);
            font-size: 0.85rem;
            border-top: 1px solid var(--card-border);
            margin-top: auto;
        }

        @keyframes slideIn {
            from { transform: translateY(-10px); opacity: 0; }
            to { transform: translateY(0); opacity: 1; }
        }
    </style>
    @yield('styles')
</head>
<body>

    <header>
        <div class="nav-container">
            <a href="{{ route('books.index') }}" class="logo">
                Mini CRUD<span>Library</span>
            </a>
            <nav class="nav-links">
                <a href="{{ route('books.index') }}">Home</a>
            </nav>
        </div>
    </header>

    <main>
        @if(session('success'))
            <div class="alert alert-success" id="alert-msg">
                <span>{{ session('success') }}</span>
                <span style="cursor:pointer; font-weight:bold;" onclick="document.getElementById('alert-msg').style.display='none'">&times;</span>
            </div>
        @endif

        @yield('content')
    </main>

    <footer>
        <p>&copy; Test</p>
    </footer>

</body>
</html>
