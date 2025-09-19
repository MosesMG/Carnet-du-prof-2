{{-- resources/views/emails/modern-template.blade.php --}}
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>{{ $subject ?? 'Email' }}</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, sans-serif;
            line-height: 1.6;
            color: #333333;
            background-color: #f8fafc;
        }
        
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background-color: #ffffff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }
        
        .email-header {
            background: linear-gradient(135deg, #667eea 75%, #764ba2 100%);
            color: white;
            padding: 30px;
            text-align: center;
        }
        
        .email-header h1 {
            font-size: 25px;
            font-weight: 600;
            margin-bottom: 8px;
            text-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .email-header p {
            font-size: 15px;
            opacity: 0.9;
            font-weight: 400;
        }
        
        .email-body {
            padding: 30px 25px 15px;
        }
        
        .email-body h2 {
            color: #2d3748;
            font-size: 20px;
            font-weight: 600;
            margin-bottom: 20px;
            border-bottom: 3px solid #667eea;
            padding-bottom: 10px;
        }
        
        .email-body p {
            font-size: 15px;
            line-height: 1.7;
            margin-bottom: 15px;
            color: #4a5568;
        }
     
        .info-box {
            background-color: #f7fafc;
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 20px 20px 10px;
            margin: 25px 0;
            border-left: 3px solid #667eea;
        }
        
        .info-box p {
            margin-bottom: 10px;
            font-size: 14px;
        }
        
        .email-footer {
            background-color: #2d3748;
            color: #a0aec0;
            padding: 20px;
            text-align: center;
            font-size: 14px;
        }
        
        .email-footer p {
            margin-bottom: 10px;
        }
        
        .email-footer a {
            color: #667eea;
            text-decoration: none;
        }
        
        .social-links {
            margin-top: 20px;
        }
        
        .social-links a {
            display: inline-block;
            margin: 0 10px;
            color: #a0aec0;
            text-decoration: none;
            font-size: 15px;
        }
        
        .divider {
            height: 1px;
            background: linear-gradient(to right, transparent, #e2e8f0, transparent);
            margin: 30px 0;
        }
        
        @media only screen and (max-width: 600px) {
            .email-container {
                margin: 10px;
                border-radius: 8px;
            }
            
            .email-header {
                padding: 20px 15px;
            }
            
            .email-header h1 {
                font-size: 22px;
            }
            
            .email-body {
                padding: 20px 15px;
            }
            
            .email-footer {
                padding: 15px;
            }
        }
    </style>
</head>
<body>
    <div class="email-container">
        <!-- Header -->
        <div class="email-header">
            <h1>{{ $title ?? 'Bienvenue' }}</h1>
            <p>{{ $subtitle ?? 'Nous sommes ravis de vous compter parmi nous' }}</p>
        </div>
        
        <!-- Body -->
        <div class="email-body">
            <h2>Bonjour {{ $name ?? 'cher utilisateur' }} !</h2>
            
            <p>Nous tenons à vous rappeler que vous avez une séance de cours dans une heure.</p>

            @if(isset($additionalInfo))
                <div class="info-box">
                    @foreach($additionalInfo as $key => $value)
                        <p><strong>{{ $key }}:</strong> {{ $value }}</p>
                    @endforeach
                </div>
            @endif

            <div class="divider"></div>
            
            <p>Si vous avez des questions, n'hésitez pas à nous contacter. Nous sommes là pour vous aider !</p>
            
            <p style="margin-top: 30px;">
                Cordialement,<br>
                <strong>{{ config('app.name') ?? "L'équipe" }}</strong>
            </p>
        </div>
        
        <!-- Footer -->
        <div class="email-footer">
            <p>Tél: {{ $contactPhone ?? '+228 90919293' }}</p>

            <div class="social-links">
                Email: <a href="mailto:contact@newbrainfactory.com">{{ $contact ?? 'contact@newbrainfactory.com' }}</a> |
                <a href="{{ $website ?? '#' }}">Site web</a>
            </div>
        </div>
    </div>
</body>
</html>
