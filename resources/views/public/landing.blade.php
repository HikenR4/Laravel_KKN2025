<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Nagari Mungo - Portal Digital Masyarakat</title>
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: #333;
            overflow-x: hidden;
        }

        /* Hero Section - WHITE & RED GRADIENT THEME */
        .hero {
            min-height: 100vh;
            background: linear-gradient(135deg, #FFFFFF 0%, #FFF5F5 20%, #FFE4E1 40%, #FFCCCB 60%, #FF9999 80%, #FF6B6B 100%);
            display: flex;
            align-items: center;
            position: relative;
            overflow: hidden;
        }

        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 800"><defs><linearGradient id="grad1" x1="0%" y1="0%" x2="100%" y2="100%"><stop offset="0%" style="stop-color:%23FFFFFF;stop-opacity:0.7" /><stop offset="25%" style="stop-color:%23FFE4E1;stop-opacity:0.5" /><stop offset="50%" style="stop-color:%23FFCCCB;stop-opacity:0.6" /><stop offset="75%" style="stop-color:%23FF9999;stop-opacity:0.5" /><stop offset="100%" style="stop-color:%23FF6B6B;stop-opacity:0.7" /></linearGradient></defs><rect width="1200" height="800" fill="url(%23grad1)"/><circle cx="200" cy="200" r="120" fill="%23DC143C" opacity="0.08"/><circle cx="800" cy="600" r="180" fill="%23FF6B6B" opacity="0.04"/><circle cx="1000" cy="300" r="100" fill="%23B22222" opacity="0.06"/><polygon points="100,100 200,50 250,150 150,200" fill="%23DC143C" opacity="0.03"/></svg>');
            animation: gentleFloat 25s infinite linear;
        }

        @keyframes gentleFloat {
            0% { transform: translateX(-50px) translateY(-30px); }
            50% { transform: translateX(30px) translateY(20px); }
            100% { transform: translateX(-50px) translateY(-30px); }
        }

        .hero-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: center;
            position: relative;
            z-index: 2;
        }

        .hero-content {
            color: #333;
            animation: slideInLeft 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        @keyframes slideInLeft {
            0% { opacity: 0; transform: translateX(-50px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        .hero-badge {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(15px);
            color: #DC143C;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            margin-bottom: 1.5rem;
            display: inline-block;
            border: 1px solid rgba(220, 20, 60, 0.2);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.1);
        }

        @keyframes fadeInUp {
            0% { opacity: 0; transform: translateY(30px); }
            100% { opacity: 1; transform: translateY(0); }
        }

        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            line-height: 1.2;
            color: #333;
            text-shadow: 0 2px 10px rgba(0,0,0,0.1);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.4s both;
        }

        .hero-highlight {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: none;
        }

        .hero p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            color: #555;
            line-height: 1.6;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.6s both;
        }

        .hero-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.8s both;
        }

        .btn {
            padding: 1rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            position: relative;
            overflow: hidden;
        }

        .btn-primary {
            background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
            color: white;
            box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
        }

        .btn-primary::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255,255,255,0.3), transparent);
            transition: all 0.6s ease;
        }

        .btn-secondary {
            background: white;
            color: #DC143C;
            border: 2px solid #DC143C;
            backdrop-filter: blur(10px);
        }

        .btn:hover {
            transform: translateY(-4px) scale(1.05);
        }

        .btn-primary:hover {
            box-shadow: 0 15px 40px rgba(220, 20, 60, 0.4);
        }

        .btn-primary:hover::before {
            left: 100%;
        }

        .btn-secondary:hover {
            background: #DC143C;
            color: white;
            box-shadow: 0 10px 30px rgba(220, 20, 60, 0.3);
        }

        .hero-visual {
            display: flex;
            justify-content: center;
            align-items: center;
            position: relative;
            animation: slideInRight 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.3s both;
        }

        @keyframes slideInRight {
            0% { opacity: 0; transform: translateX(50px); }
            100% { opacity: 1; transform: translateX(0); }
        }

        .video-container {
            background: white;
            border-radius: 25px;
            padding: 1.2rem;
            box-shadow: 0 25px 80px rgba(220, 20, 60, 0.2);
            max-width: 500px;
            width: 100%;
            animation: floatCard 8s ease-in-out infinite;
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(220, 20, 60, 0.1);
        }

        @keyframes floatCard {
            0%, 100% { transform: translateY(0) rotate(0deg); }
            25% { transform: translateY(-15px) rotate(1deg); }
            50% { transform: translateY(-25px) rotate(0deg); }
            75% { transform: translateY(-15px) rotate(-1deg); }
        }

        .video-player {
            width: 100%;
            height: 280px;
            background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 50%, #B22222 100%);
            border-radius: 20px;
            position: relative;
            overflow: hidden;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .video-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(45deg, rgba(0,0,0,0.1), rgba(0,0,0,0.05));
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .video-player:hover .video-overlay {
            background: linear-gradient(45deg, rgba(0,0,0,0.05), rgba(0,0,0,0.02));
        }

        .play-button {
            width: 80px;
            height: 80px;
            background: rgba(255,255,255,0.95);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #DC143C;
            font-size: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            backdrop-filter: blur(15px);
            border: 3px solid rgba(255,255,255,0.3);
            position: relative;
        }

        .play-button::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: radial-gradient(circle, rgba(220,20,60,0.3) 0%, transparent 70%);
            animation: pulse 2s infinite;
            border-radius: 50%;
        }

        @keyframes pulse {
            0%, 100% { transform: scale(0.8); opacity: 0.7; }
            50% { transform: scale(1.2); opacity: 0.3; }
        }

        .video-player:hover .play-button {
            background: white;
            transform: scale(1.15);
            box-shadow: 0 15px 40px rgba(220, 20, 60, 0.3);
        }

        .video-info {
            padding: 1.5rem;
            text-align: center;
        }

        .video-title {
            color: #DC143C;
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0.5rem;
            transition: color 0.3s ease;
        }

        .video-subtitle {
            color: #666;
            font-size: 0.9rem;
            margin-bottom: 1rem;
        }

        .video-stats {
            display: flex;
            justify-content: space-around;
            padding-top: 1rem;
            border-top: 1px solid rgba(220, 20, 60, 0.1);
        }

        .video-stat {
            text-align: center;
            transition: transform 0.3s ease;
        }

        .video-stat:hover {
            transform: translateY(-2px);
        }

        .video-stat-number {
            font-size: 1.2rem;
            font-weight: 700;
            color: #DC143C;
            margin-bottom: 0.2rem;
        }

        .video-stat-label {
            font-size: 0.8rem;
            color: #666;
        }

        /* Features Section - WHITE & RED THEME */
        .features {
            padding: 5rem 0;
            background: linear-gradient(135deg, #FFFFFF 0%, #FFFAFA 50%, #FFF5F5 100%);
            position: relative;
        }

        .features::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 600"><circle cx="100" cy="100" r="50" fill="%23FF6B6B" opacity="0.03"/><circle cx="1100" cy="500" r="80" fill="%23DC143C" opacity="0.02"/><polygon points="800,50 850,100 800,150 750,100" fill="%23FFCCCB" opacity="0.02"/></svg>');
            animation: gentleFloat 30s infinite linear;
        }

        .features-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }

        .section-header {
            text-align: center;
            margin-bottom: 4rem;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .section-badge {
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 50px;
            font-size: 0.9rem;
            margin-bottom: 1rem;
            display: inline-block;
            box-shadow: 0 4px 15px rgba(220, 20, 60, 0.3);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
        }

        .section-title {
            font-size: 2.5rem;
            color: #333;
            margin-bottom: 1rem;
            font-weight: 700;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.4s both;
        }

        .section-subtitle {
            font-size: 1.1rem;
            color: #666;
            max-width: 600px;
            margin: 0 auto;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.6s both;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
        }

        .feature-card {
            background: white;
            padding: 2.5rem;
            border-radius: 25px;
            text-align: center;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 30px rgba(220, 20, 60, 0.08);
            position: relative;
            overflow: hidden;
            border: 1px solid rgba(220, 20, 60, 0.05);
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
            transform: scaleX(0);
            transition: transform 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            transform-origin: left;
        }

        .feature-card::after {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.02), rgba(220, 20, 60, 0.02));
            opacity: 0;
            transition: opacity 0.4s ease;
        }

        .feature-card:hover::before {
            transform: scaleX(1);
        }

        .feature-card:hover::after {
            opacity: 1;
        }

        .feature-card:hover {
            transform: translateY(-15px) scale(1.02);
            box-shadow: 0 25px 50px rgba(220, 20, 60, 0.15);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
            border-radius: 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            color: white;
            font-size: 2rem;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .feature-icon::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255,255,255,0.2), transparent);
            transform: rotate(45deg);
            transition: all 0.6s ease;
            opacity: 0;
        }

        .feature-card:hover .feature-icon {
            transform: scale(1.1) rotate(5deg);
        }

        .feature-card:hover .feature-icon::before {
            animation: shine 0.6s ease-in-out;
        }

        @keyframes shine {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); opacity: 0; }
            50% { opacity: 1; }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); opacity: 0; }
        }

        .feature-card h3 {
            font-size: 1.3rem;
            color: #333;
            margin-bottom: 1rem;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .feature-card:hover h3 {
            color: #DC143C;
        }

        .feature-card p {
            color: #666;
            line-height: 1.6;
        }

        /* Process Section */
        .process {
            padding: 5rem 0;
            background: white;
            position: relative;
        }

        .process::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.02) 0%, rgba(255, 204, 203, 0.01) 50%, rgba(220, 20, 60, 0.02) 100%);
        }

        .process-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }

        .process-steps {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            margin-top: 4rem;
        }

        .process-step {
            text-align: center;
            position: relative;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .step-number {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, #FF6B6B, #DC143C, #B22222);
            color: white;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 700;
            margin: 0 auto 1.5rem;
            position: relative;
            z-index: 2;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            box-shadow: 0 8px 25px rgba(220, 20, 60, 0.3);
        }

        .step-number::before {
            content: '';
            position: absolute;
            top: -10px;
            left: -10px;
            right: -10px;
            bottom: -10px;
            background: linear-gradient(135deg, rgba(255, 107, 107, 0.2), rgba(220, 20, 60, 0.2));
            border-radius: 50%;
            animation: pulse 2s infinite;
            z-index: -1;
        }

        .process-step:hover .step-number {
            transform: scale(1.1) rotate(360deg);
        }

        .process-step:not(:last-child) .step-number::after {
            content: '';
            position: absolute;
            top: 50%;
            left: 100%;
            width: 100px;
            height: 3px;
            background: linear-gradient(to right, #FF6B6B, #FFCCCB, #FFE4E1);
            transform: translateY(-50%);
            z-index: -1;
            border-radius: 2px;
        }

        .process-step h3 {
            color: #333;
            margin-bottom: 1rem;
            font-size: 1.3rem;
            font-weight: 600;
            transition: color 0.3s ease;
        }

        .process-step:hover h3 {
            color: #DC143C;
        }

        .process-step p {
            color: #666;
            line-height: 1.6;
        }

        /* CTA Section */
        .cta-section {
            padding: 5rem 0;
            background: linear-gradient(135deg, #FF6B6B 0%, #DC143C 25%, #B22222 50%, #8B0000 75%, #660000 100%);
            color: white;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .cta-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 400"><circle cx="100" cy="100" r="80" fill="white" opacity="0.05"/><circle cx="1100" cy="300" r="120" fill="white" opacity="0.03"/><polygon points="600,50 650,100 600,150 550,100" fill="white" opacity="0.04"/></svg>');
            animation: gentleFloat 20s infinite linear;
        }

        .cta-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 0 2rem;
            position: relative;
            z-index: 2;
        }

        .cta-section h2 {
            font-size: 2.5rem;
            margin-bottom: 1rem;
            font-weight: 700;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .cta-section p {
            font-size: 1.2rem;
            margin-bottom: 2rem;
            opacity: 0.95;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.2s both;
        }

        .cta-button {
            background: white;
            color: #DC143C;
            padding: 1.2rem 3rem;
            border: none;
            border-radius: 50px;
            font-size: 1.2rem;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            box-shadow: 0 10px 30px rgba(255, 255, 255, 0.2);
            position: relative;
            overflow: hidden;
            animation: fadeInUp 0.8s cubic-bezier(0.4, 0, 0.2, 1) 0.4s both;
        }

        .cta-button::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(220,20,60,0.1), transparent);
            transition: all 0.6s ease;
        }

        .cta-button:hover {
            transform: translateY(-5px) scale(1.05);
            box-shadow: 0 20px 50px rgba(255, 255, 255, 0.3);
            background: #DC143C;
            color: white;
        }

        .cta-button:hover::before {
            left: 100%;
        }

        /* Footer */
        .footer {
            background: linear-gradient(135deg, #333 0%, #444 50%, #555 100%);
            color: #F5F5F5;
            padding: 3rem 0 1rem;
            position: relative;
        }

        .footer::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1200 300"><circle cx="200" cy="100" r="60" fill="%23FF6B6B" opacity="0.03"/><circle cx="1000" cy="200" r="80" fill="%23DC143C" opacity="0.02"/></svg>');
        }

        .footer-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 2rem;
            position: relative;
            z-index: 2;
        }

        .footer-section h3 {
            color: #FF6B6B;
            margin-bottom: 1rem;
            font-size: 1.2rem;
            font-weight: 600;
        }

        .footer-section p {
            line-height: 1.6;
            margin-bottom: 1rem;
            color: #DDD;
        }

        .footer-links {
            list-style: none;
        }

        .footer-links li {
            margin-bottom: 0.5rem;
        }

        .footer-links a {
            color: #F5F5F5;
            text-decoration: none;
            transition: all 0.3s ease;
            position: relative;
        }

        .footer-links a::before {
            content: '';
            position: absolute;
            bottom: -2px;
            left: 0;
            width: 0;
            height: 1px;
            background: #FF6B6B;
            transition: width 0.3s ease;
        }

        .footer-links a:hover {
            color: #FF6B6B;
            transform: translateX(5px);
        }

        .footer-links a:hover::before {
            width: 100%;
        }

        .social-links {
            display: flex;
            gap: 1rem;
            margin-top: 1rem;
        }

        .social-links a {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, #666, #555);
            color: #F5F5F5;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: all 0.4s cubic-bezier(0.4, 0, 0.2, 1);
            position: relative;
            overflow: hidden;
        }

        .social-links a::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, #FF6B6B, #DC143C);
            border-radius: 50%;
            transform: scale(0);
            transition: transform 0.3s ease;
        }

        .social-links a:hover {
            transform: translateY(-5px) scale(1.1);
        }

        .social-links a:hover::before {
            transform: scale(1);
        }

        .social-links a i {
            position: relative;
            z-index: 2;
            transition: color 0.3s ease;
        }

        .social-links a:hover i {
            color: white;
        }

        .footer-bottom {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(255, 107, 107, 0.3);
            text-align: center;
            color: #CCC;
            position: relative;
            z-index: 2;
        }

        /* Scroll animations */
        .fade-in {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.8s cubic-bezier(0.4, 0, 0.2, 1);
        }

        .fade-in.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive Design */
        @media (max-width: 768px) {
            .hero-container {
                grid-template-columns: 1fr;
                gap: 2rem;
                text-align: center;
            }

            .hero h1 {
                font-size: 2.5rem;
            }

            .hero-buttons {
                justify-content: center;
            }

            .section-title {
                font-size: 2rem;
            }

            .process-step:not(:last-child) .step-number::after {
                display: none;
            }

            .cta-section h2 {
                font-size: 2rem;
            }
        }

        @media (max-width: 480px) {
            .hero h1 {
                font-size: 2rem;
            }

            .section-title {
                font-size: 1.8rem;
            }

            .features-grid {
                grid-template-columns: 1fr;
            }

            .feature-card {
                padding: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Include Header -->
    @include('layouts.header')

    <!-- Hero Section -->
    <section id="beranda" class="hero">
        <div class="hero-container">
            <div class="hero-content">
                <div class="hero-badge">
                    <i class="fas fa-star"></i> Portal Digital Terpercaya
                </div>
                <h1>
                    Layanan Digital <span class="hero-highlight">Nagari Mungo</span> untuk Masa Depan
                </h1>
                <p>
                    Akses semua layanan administrasi, informasi terkini, dan berpartisipasi dalam pembangunan nagari melalui platform digital yang mudah dan cepat.
                </p>
                <div class="hero-buttons">
                    <a href="#login" class="btn btn-primary">
                        <i class="fas fa-sign-in-alt"></i>
                        Login
                    </a>
                    <a href="{{ route('berita') }}" class="btn btn-secondary">
                        <i class="fas fa-newspaper"></i>
                        Lihat Berita
                    </a>
                </div>
            </div>
            <div class="hero-visual">
                <div class="video-container">
                    <div class="video-player" onclick="playVideo()">
                        <div class="video-overlay">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                    </div>
                    <div class="video-info">
                        <h3 class="video-title">Profil Nagari Mungo</h3>
                        <p class="video-subtitle">Kenali lebih dekat Nagari Mungo dan layanan digitalnya</p>
                        <div class="video-stats">
                            <div class="video-stat">
                                <div class="video-stat-number">1.9K</div>
                                <div class="video-stat-label">Views</div>
                            </div>
                            <div class="video-stat">
                                <div class="video-stat-number">5:42</div>
                                <div class="video-stat-label">Duration</div>
                            </div>
                            <div class="video-stat">
                                <div class="video-stat-number">HD</div>
                                <div class="video-stat-label">Quality</div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Features Section -->
    <section id="layanan" class="features">
        <div class="features-container">
            <div class="section-header fade-in">
                <div class="section-badge">
                    <i class="fas fa-gem"></i> Layanan Unggulan
                </div>
                <h2 class="section-title">Semua yang Anda Butuhkan dalam Satu Platform</h2>
                <p class="section-subtitle">
                    Platform digital terintegrasi untuk memudahkan akses layanan publik dan informasi nagari
                </p>
            </div>
            <div class="features-grid">
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-file-contract"></i>
                    </div>
                    <h3>Permohonan Surat Online</h3>
                    <p>Ajukan surat keterangan, domisili, dan dokumen lainnya secara online tanpa perlu datang ke kantor nagari</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-chart-line"></i>
                    </div>
                    <h3>Data Kependudukan Real-time</h3>
                    <p>Akses informasi statistik dan data kependudukan nagari yang selalu update dan akurat</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-calendar-check"></i>
                    </div>
                    <h3>Agenda & Kegiatan</h3>
                    <p>Pantau jadwal kegiatan, rapat, dan acara nagari agar tidak ketinggalan informasi penting</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-bullhorn"></i>
                    </div>
                    <h3>Pengumuman Resmi</h3>
                    <p>Dapatkan informasi dan pengumuman resmi dari pemerintah nagari secara langsung</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-building"></i>
                    </div>
                    <h3>Profil Nagari Lengkap</h3>
                    <p>Informasi komprehensif tentang sejarah, visi misi, dan struktur pemerintahan nagari</p>
                </div>
                <div class="feature-card fade-in">
                    <div class="feature-icon">
                        <i class="fas fa-headset"></i>
                    </div>
                    <h3>Layanan Bantuan 24/7</h3>
                    <p>Tim support siap membantu Anda kapan saja untuk pertanyaan dan kendala teknis</p>
                </div>
            </div>
        </div>
    </section>

    <!-- Process Section -->
    <section id="tentang" class="process">
        <div class="process-container">
            <div class="section-header fade-in">
                <div class="section-badge">
                    <i class="fas fa-cogs"></i> Cara Kerja
                </div>
                <h2 class="section-title">Mudah Digunakan dalam 3 Langkah</h2>
                <p class="section-subtitle">
                    Sistem yang dirancang untuk kemudahan masyarakat dengan proses yang simple dan efisien
                </p>
            </div>
            <div class="process-steps">
                <div class="process-step fade-in">
                    <div class="step-number">1</div>
                    <h3>Daftar & Verifikasi</h3>
                    <p>Daftarkan diri dengan NIK dan data personal untuk verifikasi identitas sebagai warga nagari</p>
                </div>
                <div class="process-step fade-in">
                    <div class="step-number">2</div>
                    <h3>Pilih Layanan</h3>
                    <p>Pilih layanan yang dibutuhkan dari dashboard dan lengkapi formulir sesuai persyaratan</p>
                </div>
                <div class="process-step fade-in">
                    <div class="step-number">3</div>
                    <h3>Terima Hasil</h3>
                    <p>Pantau status permohonan dan terima hasil layanan melalui email atau download langsung</p>
                </div>
            </div>
        </div>
    </section>

    <!-- CTA Section -->
    <section id="login" class="cta-section">
        <div class="cta-container">
            <h2>Siap Merasakan Kemudahan Layanan Digital?</h2>
            <p>Bergabunglah dengan ribuan warga Nagari Mungo yang sudah merasakan kemudahan layanan digital kami</p>
            <a href="#login-form" class="cta-button">
                <i class="fas fa-sign-in-alt"></i>
                Login Sekarang
            </a>
        </div>
    </section>

    <!-- Footer -->
    <footer id="kontak" class="footer">
        <div class="footer-container">
            <div class="footer-section">
                <h3>Nagari Mungo</h3>
                <p>Portal digital resmi Nagari Mungo yang menghadirkan layanan publik modern dan terintegrasi untuk kemudahan masyarakat.</p>
                <div class="social-links">
                    <a href="#"><i class="fab fa-facebook-f"></i></a>
                    <a href="#"><i class="fab fa-instagram"></i></a>
                    <a href="#"><i class="fab fa-twitter"></i></a>
                    <a href="#"><i class="fab fa-youtube"></i></a>
                </div>
            </div>
            <div class="footer-section">
                <h3>Layanan</h3>
                <ul class="footer-links">
                    <li><a href="#">Permohonan Surat</a></li>
                    <li><a href="#">Data Kependudukan</a></li>
                    <li><a href="#">Agenda Kegiatan</a></li>
                    <li><a href="#">Pengumuman</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Informasi</h3>
                <ul class="footer-links">
                    <li><a href="#">Profil Nagari</a></li>
                    <li><a href="#">Perangkat Nagari</a></li>
                    <li><a href="#">Visi & Misi</a></li>
                    <li><a href="#">Sejarah</a></li>
                </ul>
            </div>
            <div class="footer-section">
                <h3>Kontak</h3>
                <p><i class="fas fa-map-marker-alt"></i> Jl. Nagari Mungo No. 123<br>Padang, Sumatera Barat</p>
                <p><i class="fas fa-phone"></i> (0751) 123-4567</p>
                <p><i class="fas fa-envelope"></i> info@nagarimungo.id</p>
            </div>
        </div>
        <div class="footer-bottom">
            <p>&copy; 2025 Nagari Mungo. Semua hak cipta dilindungi undang-undang.</p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });

        // Scroll animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        document.querySelectorAll('.fade-in').forEach(el => {
            observer.observe(el);
        });

        // Video player function
        function playVideo() {
            const videoPlayer = document.querySelector('.video-player');
            const playButton = document.querySelector('.play-button');

            playButton.style.transform = 'scale(0.9)';
            setTimeout(() => {
                playButton.style.transform = 'scale(1.1)';
                alert('Video akan dimulai!\n\nCatatan: Ini simulasi. Bisa diganti dengan:\n- Modal popup video\n- Redirect ke halaman video\n- Embed YouTube/Vimeo player');
            }, 150);
        }

        // Dynamic counter animation untuk video stats
        function animateVideoStats() {
            const counters = document.querySelectorAll('.video-stat-number');
            counters.forEach(counter => {
                if (counter.innerText.includes('K')) {
                    const target = parseFloat(counter.innerText) * 1000;
                    const increment = target / 100;
                    let current = 0;

                    const timer = setInterval(() => {
                        current += increment;
                        if (current >= target) {
                            counter.innerText = (target / 1000).toFixed(1) + 'K';
                            clearInterval(timer);
                        } else {
                            counter.innerText = (current / 1000).toFixed(1) + 'K';
                        }
                    }, 30);
                }
            });
        }

        // Trigger animation when video container is visible
        const videoContainer = document.querySelector('.video-container');
        if (videoContainer) {
            const videoObserver = new IntersectionObserver((entries) => {
                entries.forEach(entry => {
                    if (entry.isIntersecting) {
                        setTimeout(animateVideoStats, 500);
                        videoObserver.unobserve(entry.target);
                    }
                });
            });
            videoObserver.observe(videoContainer);
        }
    </script>
</body>
</html>
