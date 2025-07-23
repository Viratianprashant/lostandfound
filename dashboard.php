<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Campus Lost & Found - Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary-color: #4a6fa5;
            --secondary-color: #6b8cae;
            --accent-color: #ff6b6b;
            --light-color: #f8f9fa;
            --dark-color: #343a40;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        body {
            background: linear-gradient(135deg, #f5f7fa 0%, #c3cfe2 100%);
            min-height: 100vh;
            padding: 20px;
        }

        .navbar {
            background: rgba(255, 255, 255, 0.95);
            padding: 1rem 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 2rem;
            backdrop-filter: blur(10px);
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .logo img {
            height: 45px;
            width: auto;
        }

        .logo h1 {
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
        }

        .welcome-section {
            text-align: center;
            margin: 3rem 0;
            animation: fadeIn 1s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(20px); }
            to { opacity: 1; transform: translateY(0); }
        }

        .welcome-section h2 {
            color: var(--dark-color);
            margin-bottom: 0.5rem;
            font-size: 2.2rem;
            font-weight: 700;
        }

        .welcome-section p {
            color: #6c757d;
            font-size: 1.2rem;
            max-width: 600px;
            margin: 0 auto;
            line-height: 1.6;
        }

        .dashboard-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            max-width: 1200px;
            margin: 0 auto;
            padding: 1rem;
        }

        .card {
            background: rgba(255, 255, 255, 0.95);
            border-radius: 15px;
            padding: 2.5rem 2rem;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            min-height: 300px;
            border: 1px solid rgba(0, 0, 0, 0.05);
            position: relative;
            overflow: hidden;
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(90deg, var(--primary-color), var(--secondary-color));
        }

        .card:hover {
            transform: translateY(-8px);
            box-shadow: 0 15px 35px rgba(0, 0, 0, 0.12);
        }

        .card i {
            font-size: 3rem;
            margin-bottom: 1.5rem;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .card h3 {
            color: var(--dark-color);
            margin-bottom: 1rem;
            font-size: 1.6rem;
            font-weight: 700;
        }

        .card p {
            color: #6c757d;
            margin-bottom: 1.5rem;
            line-height: 1.6;
        }

        .btn {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 0.9rem 2rem;
            border-radius: 50px;
            text-decoration: none;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            font-size: 1rem;
            position: relative;
            overflow: hidden;
            z-index: 1;
        }

        .btn::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, var(--primary-color), var(--secondary-color));
            z-index: -1;
            transition: opacity 0.3s ease;
            opacity: 1;
            border-radius: 50px;
        }

        .btn:hover::before {
            opacity: 0.9;
        }

        .btn span {
            position: relative;
            z-index: 2;
            color: white;
        }

        .btn i {
            margin-right: 8px;
            font-size: 1.1rem;
        }

        .btn-logout {
            background: linear-gradient(45deg, #ff6b6b, #ff8e8e);
            padding: 0.6rem 1.5rem;
            color: white;
            font-weight: 600;
            border-radius: 50px;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
        }

        .btn-logout:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(255, 107, 107, 0.4);
        }

        .btn-logout i {
            margin-right: 8px;
        }

        @media (max-width: 768px) {
            .dashboard-cards {
                grid-template-columns: 1fr;
                padding: 0.5rem;
            }
            
            .navbar {
                flex-direction: column;
                gap: 1rem;
                text-align: center;
                padding: 1rem;
            }

            .logo h1 {
                font-size: 1.5rem;
            }

            .welcome-section h2 {
                font-size: 1.8rem;
            }

            .welcome-section p {
                font-size: 1rem;
                padding: 0 1rem;
            }

            .card {
                padding: 2rem 1.5rem;
            }
        }

        /* Animation for cards */
        .card:nth-child(1) { animation: slideIn 0.6s ease-out; }
        .card:nth-child(2) { animation: slideIn 0.8s ease-out; }
        .card:nth-child(3) { animation: slideIn 1s ease-out; }

        @keyframes slideIn {
            from { 
                opacity: 0;
                transform: translateY(30px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <div class="logo">
            <img src="https://cdn-icons-png.flaticon.com/512/616/616490.png" alt="College Logo" style="height: 40px;">
            <h1>Campus Lost & Found</h1>
        </div>
        <div>
            <span style="margin-right: 20px; color: var(--primary-color); font-weight: 600;">
                <i class="fas fa-user"></i> <?php echo htmlspecialchars($_SESSION['name']); ?>
            </span>
            <a href="logout.php" class="btn-logout">
                <i class="fas fa-sign-out-alt"></i> Logout
            </a>
        </div>
    </nav>

    <main>
        <section class="welcome-section">
            <h2>Welcome back, <?php echo htmlspecialchars($_SESSION['name']); ?>!</h2>
            <p>Manage lost and found items across the campus with our easy-to-use platform.</p>
        </section>

        <div class="dashboard-cards">
            <div class="card">
                <i class="fas fa-plus-circle"></i>
                <h3>Post Lost/Found Item</h3>
                <p>Report a lost item or post something you've found on campus. Help others reunite with their belongings.</p>
                <a href="post_item.php" class="btn">
                    <i class="fas fa-plus"></i>
                    <span>Post Item</span>
                </a>
            </div>

            <div class="card">
                <i class="fas fa-search"></i>
                <h3>Browse Items</h3>
                <p>Search through all reported lost and found items. Filter by category, date, or location.</p>
                <a href="view_items.php" class="btn">
                    <i class="fas fa-search"></i>
                    <span>View Items</span>
                </a>
            </div>

            <div class="card">
                <i class="fas fa-user-circle"></i>
                <h3>My Account</h3>
                <p>Manage your profile, view your posted items, and update your notification preferences.</p>
                <a href="#" class="btn" onclick="alert('Profile page coming soon!')">
                    <i class="fas fa-user"></i>
                    <span>View Profile</span>
                </a>
            </div>
        </div>
    </main>
</body>
</html>
