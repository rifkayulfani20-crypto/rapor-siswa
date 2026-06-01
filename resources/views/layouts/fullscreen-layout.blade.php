<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistem Pengolahan Rapor Siswa</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        brand: {
                            50:  '#eff6ff',
                            100: '#dbeafe',
                            200: '#bfdbfe',
                            300: '#93c5fd',
                            400: '#60a5fa',
                            500: '#3b82f6',
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                        'blue-light': {
                            50:  '#f0f9ff',
                            100: '#e0f2fe',
                        }
                    },
                    fontSize: {
                        'title-xl': ['2.75rem', { lineHeight: '1.2' }],
                    },
                    boxShadow: {
                        'theme-sm': '0 1px 3px rgba(0,0,0,0.08)',
                        'theme-md': '0 4px 12px rgba(0,0,0,0.08)',
                    }
                }
            }
        }
    </script>
</head>
<body>
    @yield('content')
</body>
</html>
