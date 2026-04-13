<!DOCTYPE html>
<html lang="fr">
<head>
<meta charset="UTF-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0">
<title>Page non trouvée</title>

<style>
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
        font-family: 'Segoe UI', sans-serif;
    }

    body {
        height: 100vh;
        background: linear-gradient(135deg, #4f46e5, #06b6d4);
        display: flex;
        align-items: center;
        justify-content: center;
        color: #0c0909;
    }

    .container {
        text-align: center;
        max-width: 500px;
        margin: 50px auto;
    }

    h1 {
        font-size: 120px;
        font-weight: bold;
        letter-spacing: 5px;
        animation: float 3s ease-in-out infinite;
        color: #30619f;
    }

    @keyframes float {
        0%, 100% { transform: translateY(0); }
        50% { transform: translateY(-10px); }
    }

    h2 {
        font-size: 24px;
        margin-bottom: 10px;
        color: #30619f;
    }

    p {
        opacity: 0.9;
        margin-bottom: 25px;
        color: #30619f;
    }

    .btn {
        display: inline-block;
        padding: 12px 25px;
        background: #fff;
        color: #4f46e5;
        text-decoration: none;
        border-radius: 30px;
        font-weight: 600;
        transition: 0.3s;
    }

    .btn:hover {
        background: #e0e7ff;
        transform: scale(1.05);
    }

    .icon {
        font-size: 50px;
        margin-bottom: 15px;
        margin: 50px auto;
    }
</style>
</head>

<body>

<div class="container">
    <div class="icon">🚫</div>
    <h1>404</h1>
    <h2>Page non trouvée</h2>
    <p>La page que vous recherchez n'existe pas ou a été déplacée.</p>
    
    <a href="/" class="btn">Retour à l'accueil</a>
</div>

</body>
</html>