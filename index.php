<!DOCTYPE html>
<html lang="uk">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ласкаво просимо до нашого зоомагазину</title>
    <link rel="stylesheet" href="/myshop/assets/css/styles.css">
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f5f5f5;
            margin: 0;
            padding: 0;
        }
        .container {
            width: 80%;
            margin: 0 auto;
            padding: 20px;
        }
        .block {
            background-color: #fff;
            border-radius: 8px;
            padding: 20px;
            margin-bottom: 20px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
        }
        .block h2 {
            text-align: center;
            color: #2c3e50;
        }
        .block p {
            font-size: 16px;
            line-height: 1.6;
            color: #34495e;
            text-align: justify;
        }
        .btn {
            display: block;
            width: 200px;
            margin: 20px auto;
            padding: 10px 20px;
            text-align: center;
            background-color: #3498db;
            color: #fff;
            text-decoration: none;
            border-radius: 5px;
            transition: background-color 0.3s;
        }
        .btn:hover {
            background-color: #2980b9;
        }
        .slider {
            position: relative;
            width: 100%;
            overflow: hidden;
            border-radius: 10px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
        }
        .slides {
            display: flex;
            transition: transform 0.5s ease-in-out;
        }
        .slide {
            min-width: 100%;
            box-sizing: border-box;
        }
        .slide img {
            width: 100%;
            display: block;
        }
        .nav {
            position: absolute;
            top: 50%;
            width: 100%;
            display: flex;
            justify-content: space-between;
            transform: translateY(-50%);
        }
        .nav button {
            background: none;
            border: none;
            font-size: 2em;
            color: white;
            cursor: pointer;
        }
    </style>
</head>
<body>
    <?php
    session_start();
    // Логіка для включення відповідного заголовку залежно від ролі користувача
    if (isset($_SESSION['user_role']) && $_SESSION['user_role'] == 'admin') {
        include __DIR__ . '/views/layout/adminheader.php';
    } else {
        include __DIR__ . '/views/layout/header.php';
    }
    ?>

    <div class="container">
        <div class="slider">
            <div class="slides">
                <div class="slide"><img src="/myshop/assets/images/slider1.webp" alt="Slide 1"></div>
                <div class="slide"><img src="/myshop/assets/images/slider2.webp" alt="Slide 2"></div>
                <div class="slide"><img src="/myshop/assets/images/slider3.webp" alt="Slide 3"></div>
            </div>
            <div class="nav">
                <button id="prev">&#10094;</button>
                <button id="next">&#10095;</button>
            </div>
        </div>

        <div class="block">
            <h2>Наша історія</h2>
            <p>Зоомагазин "Пухнасті друзі" відкрито у 2010 році з метою забезпечити всіма необхідними товарами для ваших домашніх улюбленців. Ми прагнемо забезпечити здоров'я та щастя ваших тварин.</p>
            <p>Ми почали з маленького магазину в центрі міста, де пропонували лише базові товари для тварин. З часом ми розширили наш асортимент та послуги, включивши спеціалізовані корми, іграшки, аксесуари та ветеринарні послуги.</p>
            <p>У 2015 році ми відкрили наш перший інтернет-магазин, що дозволило нам обслуговувати клієнтів по всій країні. Сьогодні ми маємо кілька магазинів у різних містах та постійно працюємо над покращенням нашого сервісу.</p>
        </div>

        <div class="block">
            <h2>Наші цінності</h2>
            <p>Ми пропонуємо якісні товари, професійні консультації та турботливе обслуговування. Наші цінності базуються на любові до тварин, професіоналізмі та відповідальності перед нашими клієнтами.</p>
            <p>Ми завжди ставимо потреби наших клієнтів і їхніх тварин на перше місце. Наші співробітники постійно проходять навчання, щоб бути в курсі нових тенденцій та найкращих практик у догляді за тваринами.</p>
            <p>Ми підтримуємо місцеві притулки для тварин та організовуємо благодійні акції, щоб допомогти тваринам, які потребують допомоги. Ми віримо, що кожна тварина заслуговує на любов та турботу.</p>
        </div>

        <div class="block">
            <h2>Наші товари</h2>
            <p>У нас ви знайдете все необхідне для собак, котів, птахів, гризунів та рибок: корми, іграшки, аксесуари та багато іншого.</p>
            <p>Ми співпрацюємо з провідними виробниками зоотоварів, щоб забезпечити нашим клієнтам тільки найкращі та перевірені продукти. Кожен товар проходить ретельну перевірку якості перед тим, як потрапити на наші полиці.</p>
            <p>Наші консультанти завжди готові допомогти вам з вибором товарів, враховуючи індивідуальні потреби вашого улюбленця. Ми прагнемо, щоб кожен клієнт залишився задоволений покупкою.</p>
            <a href="/myshop/views/product/index.php" class="btn">Переглянути каталог</a>
        </div>
    </div>
    
    <?php include __DIR__ . '/views/layout/footer.php'; ?>

    <script>
        let currentIndex = 0;
        const slides = document.querySelector('.slides');
        const totalSlides = slides.children.length;

        document.getElementById('next').addEventListener('click', () => {
            currentIndex = (currentIndex + 1) % totalSlides;
            updateSlidePosition();
        });

        document.getElementById('prev').addEventListener('click', () => {
            currentIndex = (currentIndex - 1 + totalSlides) % totalSlides;
            updateSlidePosition();
        });

        function updateSlidePosition() {
            slides.style.transform = 'translateX(' + (-currentIndex * 100) + '%)';
        }
    </script>
</body>
</html>
