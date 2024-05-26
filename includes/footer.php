<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Footer Example</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.3/css/all.min.css">


    <style>

body {
    margin: 0;
    padding: 0;
    min-height: 100vh;
    display: flex;
    flex-direction: column;
}

footer {
    background-image: url('images/footer.webp'); 
    background-size: cover; 
    background-repeat: no-repeat; 
    background-position: center; 
    background-color: rgb(255 255 255 / 26%); 
    backdrop-filter: blur(10px);
    color: #000;
    padding: 20px;
    margin-top: auto;
}
footer a {
    color: #000 !important;
}

footer a:hover {
    color: #008817 !important;
}

.footer-container {
    display: flex;
    flex-wrap: wrap;
    justify-content: center ;
}

.box-container-footer {
    flex: 1;
    max-width: 250px;
}

.in-box-footer a {
    color: #fff;
    text-decoration: none;
    display: block;
    margin-bottom: 5px;
    transition: color 0.3s ease;
}

.in-box-footer a:hover {
    color: #f1c40f; /* Change to your desired hover color */
}

.line-footer {
    border-top: 1px solid #fff;
    margin-top: 10px;
}

p {
    margin: 10px 0;
    font-size: 14px;
    text-align: center;
    color: #161616;
}


    </style>
</head>
<body>
    <!-- Your content goes here -->

    <footer>
    <div class="footer-container">
        <div class="box-container-footer">
            <h3>Contact Us</h3>
            <div class="in-box-footer">
                <a href="#"><img src="./images/icons8-phone.svg" alt="Phone" class="icon"> +947777123</a>
                <a href="#"><img src="./images/icons8-email-48.png" alt="Email" class="icon"> CodeMobile@Web.com</a>
            </div>
        </div>
        <div class="box-container-footer">
            <h3>Useful Links</h3>
            <div class="in-box-footer">
                <a href="#home">Home</a>
                <a href="#products">Product</a>
                <a href="#csup">Contact Us</a>
            </div>
        </div>
        <div class="box-container-footer">
            <h3>Follow Us</h3>
            <div class="in-box-footer">
                <a href="#"><img src="./images/icons8-twitter-48.png" alt="Twitter" class="icon"> Twitter</a>
                <a href="#"><img src="./images/icons8-facebook-48.png" alt="Facebook" class="icon"> Facebook</a>
                <a href="#"><img src="./images/icons8-instagram-48.png" alt="Instagram" class="icon"> Instagram</a>
                <a href="#"><img src="./images/icons8-tiktok-48.png" alt="TikTok" class="icon"> TikTok</a>
            </div>
        </div>
    </div>
    <p>Copyright © 2024 CodeMobiles All rights reserved.</p>
</footer>
</body>
</html>
