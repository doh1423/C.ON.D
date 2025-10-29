
<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title> D0H-store </title>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            margin: 0;
            padding: 0;
            background: url('images/back3.png') no-repeat center center fixed;
            background-size: cover;
            color: #333;
            line-height: 1.6;
        }
        .card-container {
    display: flex; /* جعل الكاردين بجانب بعض */
    justify-content: center; /* محاذاة الكاردين في المنتصف */
    margin-top: 50px; /* مسافة فوق الكاردين */
}

.card {
    background: white;
    border-radius: 20px; /* زوايا أكثر احترافية */
    box-shadow: 0 4px 15px rgba(0, 0, 0, 0.2); /* ظلال أكثر وضوحاً */
    padding: 20px;
    width: 300px;
    text-align: center;
    opacity: 0.95; /* لجعل الكارد شفاف قليلاً */
    margin: 0 10px; /* مسافة بين الكاردين */
    border: 1px solid #0c0141; /* لون بوردار */
}

.card img {
    width: 100%;
    border-radius: 15px; /* زوايا مائلة للصورة */
    margin-bottom: 15px; /* مسافة أسفل الصورة */
}

.price {
    color: rgb(172, 0, 0);
    font-size: 24px;
    margin: 10px 0;
}

.size-selector {
    margin: 10px 0;
}

.size-selector select {
    padding: 5px;
}

.add-to-cart {
    background-color: #ffde20;
    color: white;
    border: none;
    padding: 20px;
    border-radius: 5px;
    cursor: pointer;
    width: 100%;
    font-size: 16px;
    transition: background-color 0.3s; /* تأثير انتقال عند تغيير اللون */
    text-align: center;
}

.add-to-cart:hover {
    background-color: #fddc22; /* تغيير اللون عند التحويم */
    text-align: center;
}

        /* شريط التنقل */
        .navbar {
            position: fixed;
            top: 0;
            width: 100%;
            display: flex;
            align-items: center;
            padding: 15px 30px;
            background: #000046;
            color: white;
            z-index: 1000;
        }

        .navbar h1 {
            font-size: 24px;
            margin: 0;
            color: #ffcc00;
            position: absolute;
            left: 30px;
        }

        .navbar .nav-links {
            display: flex;
            align-items: center;
            margin-left: auto;
            margin-right: auto;
        }

        .navbar a {
            color: white;
            text-decoration: none;
            margin: 0 15px;
            transition: color 0.3s;
            position: relative;
        }

        .navbar a:hover {
            color: #ffcc00;
        }

        /* أيقونة المستخدم */
        .user-icon {
            font-size: 28px;
            cursor: pointer;
            margin-left: 20px;
        }

        /* قائمة منسدلة */
        .dropdown {
            position: relative;
        }

        .dropdown-content {
            display: none;
            position: absolute;
            background-color: #f9f9f9;
            min-width: 160px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.2);
            z-index: 1;
        }

        .dropdown-content a {
            color: black;
            padding: 12px 16px;
            text-decoration: none;
            display: block;
            text-align: left;
        }

        .dropdown-content a:hover {
            background-color: #f1f1f1;
        }

        .dropdown:hover .dropdown-content {
            display: block;
        }

        /* الهيدر */
        .header {
            color: white;
            text-align: center;
            height: 100vh;
            display: flex;
            flex-direction: column;
            justify-content: center;
            align-items: center;
            padding: 20px;
            background: rgba(0, 0, 0, 0.5);
        }

        .header h1 {
            font-size: 3.5em;
            margin-bottom: 20px;
            text-shadow: 2px 2px 8px rgba(0, 0, 0, 0.5);
        }

        .header p {
            font-size: 1.2em;
            max-width: 600px;
            margin: 20px auto;
        }

        /* الأقسام */
        .section {
            padding: 80px 20px;
            text-align: center;
        }

        .section-title {
            font-size: 2.5em;
            color: #1e1e2f;
            margin-bottom: 40px;
        }

        /* الخدمات */
        .services {
            background: #f8f9fa;
        }

        .service-cards {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .service-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.1);
            padding: 30px;
            transition: transform 0.3s, box-shadow 0.3s;
        }

        .service-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.2);
            background-color: #ffcc00;
        }

        .service-card h3 {
            font-size: 1.5em;
            color: #0f3460;
            margin-bottom: 15px;
        }

        .service-card p {
            font-size: 1em;
            color: #555;
            margin-bottom: 20px;
        }

        .service-card a {
            display: inline-block;
            background: #ffcc00;
            color: black;
            padding: 10px 20px;
            border-radius: 5px;
            text-decoration: none;
            font-size: 1em;
            transition: background-color 0.3s;
        }

        .service-card a:hover {
            background-color: #e6b800;
        }

        /* الفوتر */
        footer {
            background: #1e1e2f;
            color: white;
            text-align: center;
            padding: 20px;
            margin-top: 40px;
        }

        footer a {
            color: #ffcc00;
            text-decoration: none;
            margin: 0 10px;
            transition: color 0.3s;
        }

        footer a:hover {
            color: white;
        }

        /* القسم السفلي */
        .bottom-section {
            background-color: #222;
            color: white;
            padding: 40px 20px;
        }

        .bottom-section .container {
            display: flex;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .bottom-section .column {
            width: 30%;
            margin-bottom: 20px;
        }

        .bottom-section h3 {
            margin-bottom: 15px;
        }

        .bottom-section a {
            color: #ffcc00;
            text-decoration: none;
        }

        .bottom-section a:hover {
            text-decoration: underline;
        }

        /* أيقونات وسائل التواصل الاجتماعي */
        .bottom-section a {
            margin-right: 10px;
            font-size: 24px;
            color: #ffcc00;
            transition: color 0.3s;
        }

        .bottom-section a:hover {
            color: white;
        }

        /* نافذة منبثقة */
        .modal {
            display: none;
            position: fixed;
            z-index: 1001;
            left: 0;
            top: 0;
            width: 100%;
            height: 100%;
            overflow: auto;
            background-color: rgba(0, 0, 0, 0.7);
        }

        .modal-content {
            background-color: #fefefe;
            margin: 15% auto;
            padding: 20px;
            border: 1px solid #888;
            width: 80%;
            max-width: 600px;
            border-radius: 10px;
            position: relative;
        }

        .close {
            color: #aaa;
            float: right;
            font-size: 28px;
            font-weight: bold;
        }

        .close:hover,
        .close:focus {
            color: black;
            text-decoration: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

<!-- شريط التنقل -->
<div class="navbar">
    <h1 id="navbar-title">DOH-SPOORT </h1>
    <div class="nav-links">
        <a href="#"></a>

   
 
        <a href="logout.php">تسجيل الخروج</a> <!-- رابط تسجيل الخروج -->
        <a href="userpage.php"> <!-- رابط يوجه إلى صفحة الملف الشخصي -->
    <i class="fas fa-user user-icon" id="userIcon"></i> <!-- أيقونة المستخدم -->
</a>

    </div>
</div>



<!-- نافذة منبثقة -->
<div id="aboutModal" class="modal">
    <div class="modal-content">
        <span class="close" id="closeModal">&times;</span>
        <h2>معلومات عن موقع سكن الطلاب</h2>
        <p>نظام السكن يقدم خدمات متعددة للطلاب، بما في ذلك حجز الغرف، طلبات الصيانة، وتقديم الشكاوى. هدفنا هو توفير بيئة مريحة وآمنة للطلاب، حيث يمكنهم التركيز على دراستهم وتطوير مهاراتهم.</p>
    </div>
</div>

<!-- الهيدر -->
<header class="header">
    <h1 id="header-title"
>The best sports stores in the world
    </h1>
    <p id="header-description">Provide the best products for sports in an easy and fast way.</p>
</header>

<!-- قسم الخدمات -->
 


  



<section class="section services">
    <div class="card-container">
    <div class="card">
        <img src="images/cap.png" alt="Nike Epic React Flyknit">
       
        <p>قبعة George Russell من فريق Mercedes - AMG Petronas Formula One</p>
         <p class="price">$200</p>
        <div class="size-selector">
         
        </div>
        <button class="add-to-cart">add to bag</button>
    </div>

    <div class="card">
        <img src="images/tot2.png" alt="Nike Epic React Flyknit">
        <h2>Nike</h2>
        <p>Backpack</p>
         <p class="price">$120</p>
        <div class="size-selector">
      
        
        </div>
        <button class="add-to-cart">add to bag</button>
    </div>

    <div class="card">
        <img src="images\nike.png" alt="Nike Epic React Flyknit">
        <h2>Nike</h2>
        <p>Backpack</p>
        <p class="price">$120</p>
      
        <div class="size-selector">
       
           
        </div>
        <button class="add-to-cart">add to bag</button>
    </div>
</div>

<div class="card-container"> 
    <div class="row">
      <div class="col-16">
  <div class="card">
        <img src="images/tot2.png" alt="Nike Epic React Flyknit">
        <h2>Nike</h2>
         <p>Backpack</p>
        <p class="price">$120</p>
       
        <div class="size-selector">
         
        
        </div>
        <button class="add-to-cart">add to bag</button>
    </div>
    
      </div>
      </div>
            <div class="col-16">
  <div class="card">
        <img src="images/tot2.png" alt="Nike Epic React Flyknit">
        <h2>Nike</h2>
        <p class="price">$120</p>
        <p>Nike Heritage</p>
        <p>Backpack</p>
        <div class="size-selector">
         
        
        </div>
        <button class="add-to-cart">add to bag</button>
    </div>
      </div>
                <div class="col-16">
   <div class="card">
        <img src="images/tot2.png" alt="Nike Epic React Flyknit">
        <h2>Nike</h2>
        <p class="price">$120</p>
        <p>Nike Heritage</p>
        <p>Backpack</p>
        <div class="size-selector">
         
        
        </div>
        <button class="add-to-cart">add to bag</button>
    </div>
      <div class="col-16">
   <div class="card">
        <img src="images/tot2.png" alt="Nike Epic React Flyknit">
        <h2>Nike</h2>
        <p class="price">$120</p>
        <p>Nike Heritage</p>
        <p>Backpack</p>
        <div class="size-selector">
        
        
        </div>
        <button class="add-to-cart">add to bag</button>
    </div>
    
      </div>
      </div>





</div>

   
</section>

<!-- القسم السفلي -->
<div class="bottom-section">
    <div class="container">
        
       
    <div class="column">
    <h3>SOCIAL MEDIA</h3>
    <a href="https://wa.me/00966148137272"><i class="fab fa-whatsapp"></i></a>
    <a href="https://twitter.com/iu_edu_sa"><i class="fab fa-twitter"></i></a>
    <a href="https://www.instagram.com/IslamicUniversity/"><i class="fab fa-instagram"></i></a>
</div>


        <div class="column">
            <h3>SUPPORT</h3>
            <a href="#">FAQ</a><br>
            <a href="team.html">IT Team</a><br> 
        </div>
    </div>
</div>

<!-- الفوتر -->
<footer>
    <p id="footer-text">© 2025 DOH-store</p>
</footer>

<script>
    // فتح وإغلاق نافذة معلومات المستخدم
    var userModal = document.getElementById("userModal");
    var userIcon = document.getElementById("userIcon");
    var closeUserModal = document.getElementById("closeUserModal");

    userIcon.onclick = function() {
        userModal.style.display = "block";
    }

    closeUserModal.onclick = function() {
        userModal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == userModal) {
            userModal.style.display = "none";
        }
    }

    // فتح وإغلاق النافذة المنبثقة
    var modal = document.getElementById("aboutModal");
    var btn = document.getElementById("aboutBtn");
    var span = document.getElementById("closeModal");

    btn.onclick = function() {
        modal.style.display = "block";
    }

    span.onclick = function() {
        modal.style.display = "none";
    }

    window.onclick = function(event) {
        if (event.target == modal) {
            modal.style.display = "none";
        }
    }

    // دالة للتمرير إلى الخدمة المحددة
    document.querySelectorAll('.dropdown-content a').forEach(anchor => {
        anchor.addEventListener('click', function(e) {
            e.preventDefault();
            const targetId = this.getAttribute('href');
            const targetElement = document.querySelector(targetId);
            
            targetElement.scrollIntoView({
                behavior: 'smooth'
            });
        });
    });
</script>
<script>  
(function(){if(!window.chatbase||window.chatbase("getState")!=="initialized"){window.chatbase=(...arguments)=>{if(!window.chatbase.q){window.chatbase.q=[]}window.chatbase.q.push(arguments)};window.chatbase=new Proxy(window.chatbase,{get(target,prop){if(prop==="q"){return target.q}return(...args)=>target(prop,...args)}})}const onLoad=function(){const script=document.createElement("script");script.src="https://www.chatbase.co/embed.min.js";script.id="O9AyqrK5ZZbG-NUeH0dxG";script.domain="www.chatbase.co";document.body.appendChild(script)};if(document.readyState==="complete"){onLoad()}else{window.addEventListener("load",onLoad)}})();
</script>
</body>
</html>
