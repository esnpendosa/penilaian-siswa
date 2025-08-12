<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Prestasi Siswa - Quantum Idea</title>
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

        /* Animated Background */
        .animated-bg {
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            z-index: -2;
        }

        .animated-bg::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>');
            animation: float 20s infinite linear;
            z-index: -1;
        }

        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); }
            100% { transform: translateY(-100vh) rotate(360deg); }
        }

        .logo-background {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 80vh;
            height: 80vh;
            max-width: 600px;
            max-height: 600px;
            opacity: 0.08;
            z-index: -1;
            background-image: url(img/LOGO-QUANTUM.png);
            background-size: contain;
            background-repeat: no-repeat;
            background-position: center;
            animation: logoFloat 6s ease-in-out infinite;
        }

        @keyframes logoFloat {
            0%, 100% { 
                transform: translate(-50%, -50%) scale(1);
                opacity: 0.08;
            }
            50% { 
                transform: translate(-50%, -50%) scale(1.02);
                opacity: 0.12;
            }
        }

        @keyframes float {
            0% { transform: translateY(100vh) rotate(0deg); }
            100% { transform: translateY(-100vh) rotate(360deg); }
        }

        /* Header */
        header {
            position: fixed;
            top: 0;
            width: 100%;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            z-index: 1000;
            padding: 1rem 0;
            box-shadow: 0 2px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        nav {
            display: flex;
            justify-content: space-between;
            align-items: center;
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 2rem;
        }

        .logo {
            display: flex;
            align-items: center;
            gap: 1rem;
            font-size: 1.5rem;
            font-weight: bold;
            color: #764ba2;
        }

        .logo-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            box-shadow: 0 4px 15px rgba(118, 75, 162, 0.3);
            transition: transform 0.3s ease;
        }

        .logo-img:hover {
            transform: scale(1.1) rotate(5deg);
        }

        .login-btn {
            background: linear-gradient(45deg, #667eea, #764ba2);
            color: white;
            padding: 0.8rem 2rem;
            border: none;
            border-radius: 50px;
            font-size: 1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(118, 75, 162, 0.3);
        }

        .login-btn:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(118, 75, 162, 0.4);
        }

        /* Hero Section */
        .hero {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            text-align: center;
            color: white;
            position: relative;
            padding: 2rem;
        }

        .hero-content {
            max-width: 800px;
            animation: fadeInUp 1s ease-out;
        }

        .hero h1 {
            font-size: 3.5rem;
            margin-bottom: 1rem;
            background: linear-gradient(45deg, #fff, #f0f0f0);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.3);
        }

        .hero p {
            font-size: 1.3rem;
            margin-bottom: 2rem;
            opacity: 0.9;
        }

        .cta-buttons {
            display: flex;
            gap: 1rem;
            justify-content: center;
            flex-wrap: wrap;
        }

        .cta-btn {
            padding: 1rem 2.5rem;
            border: none;
            border-radius: 50px;
            font-size: 1.1rem;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            display: inline-block;
        }

        .cta-primary {
            background: linear-gradient(45deg, #ff6b6b, #ee5a52);
            color: white;
            box-shadow: 0 4px 15px rgba(255, 107, 107, 0.4);
        }

        .cta-secondary {
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border: 2px solid rgba(255, 255, 255, 0.3);
            backdrop-filter: blur(10px);
        }

        .cta-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 8px 25px rgba(0, 0, 0, 0.3);
        }

        /* Features Section */
        .features {
            padding: 5rem 2rem;
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }

        .container {
            max-width: 1200px;
            margin: 0 auto;
        }

        .section-title {
            text-align: center;
            font-size: 2.5rem;
            margin-bottom: 3rem;
            color: #333;
            position: relative;
        }

        .section-title::after {
            content: '';
            position: absolute;
            bottom: -10px;
            left: 50%;
            transform: translateX(-50%);
            width: 80px;
            height: 4px;
            background: linear-gradient(45deg, #667eea, #764ba2);
            border-radius: 2px;
        }

        .features-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(300px, 1fr));
            gap: 2rem;
            margin-top: 3rem;
        }

       
        /* Footer */
        footer {
            background: #333;
            color: white;
            text-align: center;
            padding: 2rem;
        }

        /* Animations */
        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(30px);
            }
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .fade-in {
            animation: fadeInUp 0.8s ease-out;
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero h1 {
                font-size: 2.5rem;
            }
            
            .hero p {
                font-size: 1.1rem;
            }
            
            .cta-buttons {
                flex-direction: column;
                align-items: center;
            }
            
            .features-grid {
                grid-template-columns: 1fr;
            }
            
            .stats-grid {
                grid-template-columns: repeat(2, 1fr);
            }
        }

        /* Floating Animation */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }
    </style>
</head>
<body>
    <div class="animated-bg"></div>
     <div class="logo-background"></div>
    
    <header>
        <nav>
            <div class="logo">
                <img src="data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iMTAwIiBoZWlnaHQ9IjEwMCIgdmlld0JveD0iMCAwIDEwMCAxMDAiIGZpbGw9Im5vbmUiIHhtbG5zPSJodHRwOi8vd3d3LnczLm9yZy8yMDAwL3N2ZyI+CjxjaXJjbGUgY3g9IjUwIiBjeT0iNTAiIHI9IjQ4IiBmaWxsPSIjNzY0YmEyIiBzdHJva2U9IiM2NjdlZWEiIHN0cm9rZS13aWR0aD0iNCIvPgo8dGV4dCB4PSI1MCIgeT0iNTUiIHRleHQtYW5jaG9yPSJtaWRkbGUiIGZpbGw9IndoaXRlIiBmb250LXNpemU9IjEyIiBmb250LWZhbWlseT0iQXJpYWwiPkxPR088L3RleHQ+Cjwvc3ZnPgo=" alt="Logo" class="logo-img">
                <span>Prestasi Siswa</span>
            </div>
            <button class="login-btn" onclick="login()">Login</button>
        </nav>
    </header>

    <main>
        <section class="hero">
            <div class="hero-content">
                <h1 class="floating">Sistem Prestasi Siswa</h1>
                <p>Platform digital terdepan untuk mengelola dan memantau prestasi akademik siswa dengan teknologi modern dan interface yang user-friendly.</p>
                <div class="cta-buttons">
                    <button class="cta-btn cta-primary" onclick="demoApp()">Coba Demo</button>
                    <button class="cta-btn cta-secondary" onclick="learnMore()">Pelajari Lebih Lanjut</button>
                </div>
            </div>
        </section>
    </main>

    <footer>
        <div class="container">
            <p>&copy; 2025 Prestasi Siswa - Quantum Idea. Semua hak dilindungi.</p>
        </div>
    </footer>

    <script>
        // Smooth scrolling for navigation
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                document.querySelector(this.getAttribute('href')).scrollIntoView({
                    behavior: 'smooth'
                });
            });
        });

        // Header scroll effect
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 50) {
                header.style.background = 'rgba(255, 255, 255, 0.98)';
                header.style.boxShadow = '0 2px 30px rgba(0, 0, 0, 0.15)';
            } else {
                header.style.background = 'rgba(255, 255, 255, 0.95)';
                header.style.boxShadow = '0 2px 20px rgba(0, 0, 0, 0.1)';
            }
        });

        // Animated counters
        function animateCounter(element, target, duration = 2000) {
            const start = 0;
            const increment = target / (duration / 16);
            let current = start;
            
            const timer = setInterval(() => {
                current += increment;
                if (current >= target) {
                    current = target;
                    clearInterval(timer);
                }
                
                if (element.id === 'satisfaction') {
                    element.textContent = Math.floor(current) + '%';
                } else {
                    element.textContent = Math.floor(current).toLocaleString();
                }
            }, 16);
        }

        // Intersection Observer for animations
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver((entries) => {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.style.opacity = '1';
                    entry.target.style.transform = 'translateY(0)';
                    
                    // Animate counters when stats section is visible
                    if (entry.target.classList.contains('stats')) {
                        animateCounter(document.getElementById('students'), 15420);
                        animateCounter(document.getElementById('schools'), 342);
                        animateCounter(document.getElementById('achievements'), 28750);
                        animateCounter(document.getElementById('satisfaction'), 96);
                    }
                }
            });
        }, observerOptions);

        // Observe elements for animation
        document.querySelectorAll('.fade-in, .stats').forEach(el => {
            el.style.opacity = '0';
            el.style.transform = 'translateY(30px)';
            el.style.transition = 'all 0.8s ease-out';
            observer.observe(el);
        });

        // Button interactions
        function login() {
            // Simulate login process
            const btn = document.querySelector('.login-btn');
            const originalText = btn.textContent;
            
            btn.textContent = 'Tunggu Sebentar';
            btn.style.background = 'linear-gradient(45deg, #28a745, #20c997)';
            
            setTimeout(() => {
                window.location.href = '/login'
            }, 1500);
        }

        function demoApp() {
            // Create demo modal effect
            const modal = document.createElement('div');
            modal.style.cssText = `
                position: fixed;
                top: 0;
                left: 0;
                width: 100%;
                height: 100%;
                background: rgba(0, 0, 0, 0.8);
                display: flex;
                justify-content: center;
                align-items: center;
                z-index: 10000;
                opacity: 0;
                transition: opacity 0.3s ease;
            `;
            
            const content = document.createElement('div');
            content.style.cssText = `
                background: white;
                padding: 3rem;
                border-radius: 20px;
                text-align: center;
                max-width: 500px;
                margin: 2rem;
                transform: scale(0.8);
                transition: transform 0.3s ease;
            `;
            
            content.innerHTML = `
                <h3 style="color: #764ba2; margin-bottom: 1rem;">Demo Aplikasi</h3>
                <p style="margin-bottom: 2rem; color: #666;">Demo interaktif akan segera tersedia. Silakan hubungi tim kami untuk presentasi langsung.</p>
                <button onclick="this.parentElement.parentElement.remove()" style="
                    background: linear-gradient(45deg, #667eea, #764ba2);
                    color: white;
                    border: none;
                    padding: 1rem 2rem;
                    border-radius: 50px;
                    cursor: pointer;
                    font-weight: 600;
                ">Tutup</button>
            `;
            
            modal.appendChild(content);
            document.body.appendChild(modal);
            
            setTimeout(() => {
                modal.style.opacity = '1';
                content.style.transform = 'scale(1)';
            }, 10);
        }

        function learnMore() {
            // Smooth scroll to features section
            document.querySelector('.features').scrollIntoView({
                behavior: 'smooth'
            });
        }

        // Add some interactive particles
        function createParticle() {
            const particle = document.createElement('div');
            particle.style.cssText = `
                position: fixed;
                width: 4px;
                height: 4px;
                background: rgba(255, 255, 255, 0.6);
                border-radius: 50%;
                pointer-events: none;
                z-index: -1;
                animation: particle-float 15s linear infinite;
            `;
            
            particle.style.left = Math.random() * 100 + 'vw';
            particle.style.animationDelay = Math.random() * 15 + 's';
            
            document.body.appendChild(particle);
            
            setTimeout(() => {
                particle.remove();
            }, 15000);
        }

        // Create particles periodically
        setInterval(createParticle, 3000);

        // Add particle animation CSS
        const style = document.createElement('style');
        style.textContent = `
            @keyframes particle-float {
                0% {
                    transform: translateY(100vh) rotate(0deg);
                    opacity: 0;
                }
                10% {
                    opacity: 1;
                }
                90% {
                    opacity: 1;
                }
                100% {
                    transform: translateY(-100vh) rotate(360deg);
                    opacity: 0;
                }
            }
        `;
        document.head.appendChild(style);
    </script>
</body>
</html>