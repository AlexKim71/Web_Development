<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Новини сайту')</title>
    <style>
        :root {
            --bg: #f5f3ef;
            --panel: #ffffff;
            --text: #1f2937;
            --muted: #6b7280;
            --accent: #0f766e;
            --accent-soft: #d9f0ed;
            --border: #e5e7eb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            margin: 0;
            font-family: Georgia, 'Times New Roman', serif;
            color: var(--text);
            background: radial-gradient(circle at top, #fffaf1 0%, var(--bg) 55%, #ede8df 100%);
        }

        .page {
            max-width: 1100px;
            margin: 0 auto;
            padding: 24px;
        }

        .card {
            background: rgba(255, 255, 255, 0.92);
            border: 1px solid var(--border);
            border-radius: 20px;
            box-shadow: 0 18px 40px rgba(31, 41, 55, 0.08);
            overflow: hidden;
        }

        .content {
            padding: 28px;
        }

        a {
            color: var(--accent);
            text-decoration: none;
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            gap: 16px;
            padding: 18px 28px;
            border-bottom: 1px solid var(--border);
            background: linear-gradient(135deg, #ffffff 0%, #f7fbfa 100%);
        }

        .brand {
            margin: 0;
            font-size: 28px;
            letter-spacing: 0.5px;
        }

        .tagline {
            margin: 6px 0 0;
            color: var(--muted);
            font-size: 14px;
        }

        .badge {
            display: inline-flex;
            align-items: center;
            padding: 8px 12px;
            border-radius: 999px;
            background: var(--accent-soft);
            color: var(--accent);
            font-size: 13px;
            font-weight: 700;
        }

        .grid {
            display: grid;
            gap: 20px;
        }

        .news-list {
            grid-template-columns: repeat(auto-fit, minmax(260px, 1fr));
        }

        .news-card, .article {
            border: 1px solid var(--border);
            border-radius: 18px;
            background: var(--panel);
            padding: 22px;
        }

        .meta {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
            margin-bottom: 14px;
            color: var(--muted);
            font-size: 14px;
        }

        .news-card h2, .article h1 {
            margin: 0 0 12px;
        }

        .news-card p, .article p {
            margin: 0 0 16px;
            line-height: 1.7;
        }

        .button {
            display: inline-block;
            padding: 10px 16px;
            border-radius: 10px;
            background: var(--accent);
            color: #fff;
            font-weight: 700;
        }

        .footer {
            padding: 18px 28px 28px;
            color: var(--muted);
            font-size: 14px;
        }
    </style>
</head>
<body>
    <div class="page">
        <div class="card">
            @include('partials.header')

            <main class="content">
                @yield('content')
            </main>

            @include('partials.footer')
        </div>
    </div>
</body>
</html>
