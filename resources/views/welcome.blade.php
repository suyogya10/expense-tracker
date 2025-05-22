<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Expense Tracker</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@400;600&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css"
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="icon" type="image/png" href="/icon.png">
    <meta name="theme-color" content="#4e73df" />

    <style>
        body {
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(to right, #4e73df, #224abe);
            color: white;
            min-height: 100vh;
            margin: 0;
            display: flex;
            flex-direction: column;
        }

        .hero-section {
            flex: 1;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            text-align: center;
            padding: 40px 20px;
        }

        .hero-title {
            font-size: 3rem;
            font-weight: 600;
        }

        .hero-subtitle {
            font-size: 1.25rem;
            margin: 20px 0;
        }

        .btn-primary {
            background-color: #ffffff;
            color: #4e73df;
            border: none;
            padding: 12px 25px;
            font-weight: bold;
            border-radius: 30px;
            transition: background-color 0.3s;
        }

        .btn-primary:hover {
            background-color: #e2e2e2;
        }

        .btn-outline-light {
            border-radius: 30px;
            padding: 12px 25px;
            font-weight: bold;
        }

        footer {
            background-color: rgba(0, 0, 0, 0.2);
            padding: 20px 0;
            text-align: center;
            color: #e4e4e4;
            font-size: 0.95rem;
        }

        .btn-success {
            background-color: #1cc88a;
            color: white;
            border: none;
            padding: 12px 25px;
            font-weight: bold;
            border-radius: 30px;
            transition: background-color 0.3s;
        }

        .btn-success:hover {
            background-color: #17a673;
            color: white;
        }
    </style>
</head>

<body>
    <div class="container hero-section">
        <h1 class="hero-title">Track Your Expenses Easily</h1>
        <p class="hero-subtitle">Manage your finances effortlessly with our modern and user-friendly Expense Tracker.
        </p>
        <div class="d-flex gap-3 justify-content-center flex-wrap mt-3">
            <a href="{{ route('login') }}" class="btn btn-primary">Login</a>
            <a href="{{ route('register') }}" class="btn btn-outline-light">Get Started</a>
            <a href="{{ route('download.apk') }}" class="btn btn-success" download>
                <i class="fas fa-download me-2"></i>Download APK
            </a>
        </div>

    </div>

    <footer>
        Developed with ❤️ by Suyogya Gautam
    </footer>
</body>

</html>
