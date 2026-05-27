<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Maintenance</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: linear-gradient(135deg, #e0f7ff 0%, #f7fcff 55%, #ffffff 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 24px;
            color: #0f172a;
        }

        .container {
            text-align: center;
            max-width: 560px;
            width: 100%;
            background: rgba(255,255,255,0.88);
            border: 1px solid #d9efff;
            border-radius: 24px;
            box-shadow: 0 18px 40px rgba(14,165,255,0.10);
            padding: 2rem 1.5rem;
        }

        .image-wrap {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 140px;
            height: 140px;
            border-radius: 28px;
            background: linear-gradient(135deg, #0ea5ff, #38bdf8);
            padding: 14px;
            margin-bottom: 1.25rem;
            box-shadow: 0 14px 30px rgba(14,165,255,0.20);
        }

        img {
            width: 100%;
            height: auto;
            display: block;
        }

        h1 {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            font-size: 2rem;
            color: #0369a1;
            margin-bottom: 0.75rem;
            font-weight: 800;
        }

        p {
            font-size: 0.98rem;
            color: #475569;
            line-height: 1.7;
        }

        .status-pill {
            display: inline-flex;
            align-items: center;
            gap: 0.4rem;
            padding: 0.4rem 0.85rem;
            border-radius: 999px;
            background: #e0f7ff;
            color: #0369a1;
            font-size: 0.78rem;
            font-weight: 700;
            letter-spacing: 0.4px;
            text-transform: uppercase;
            margin-bottom: 1rem;
        }

        .note {
            margin-top: 1rem;
            font-size: 0.84rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="status-pill"><span>●</span> Maintenance Mode</div>
        <div class="image-wrap">
            <img src="/downmain.png" alt="Maintenance">
        </div>
        <h1>Down for maintenance.</h1>
        <p>Please check back later.</p>
        <div class="note">We’re making a few updates to improve the site.</div>
    </div>
</body>
</html>
