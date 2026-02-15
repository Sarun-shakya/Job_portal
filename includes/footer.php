<footer>
    <div class="footer-row">
        <div class="footer-col">
            <div class="nav-logo">
                <a href="#" class="logo">Job<span>Portal</span></a>
            </div>
            <p>JobPortal is your trusted platform to find the best career opportunities and connect with top employers worldwide. Start your journey with us today!</p>
        </div>
        <div class="footer-col">
            <h4>Quick Links</h4>
            <ul>
                <li><a href="./index.php">Home</a></li>
                <li><a href="./jobs.php">Jobs</a></li>
                <li><a href="./about.php">About</a></li>
                <li><a href="./services.php">Services</a></li>
                <li><a href="./contact.php">Contacts</a></li>
                <li><a href="./login.php">Login</a></li>
                <li><a href="./employers-zone/emp-login.php">Employers Zone</a></li>
                <li><a href="./admin/login.php">Admin</a></li>
            </ul>
        </div>
        <div class="footer-col">
            <h4>Resources</h4>
            <p>Terms and Conditions</p>
            <p>Blogs</p>
            <p>Privacy Policy</p>
            <p>Sitemap</p>
        </div>
        <div class="footer-col">
            <h4>Newsletter</h4>
            <p>Stay updated with the latest job openings, career tips, and portal updates. Subscribe now and never miss an opportunity!</p>
            <h5>Follow Us</h5>
            <div class="social-links">
                <a href="#" target="_blank"><i class="ri-facebook-circle-line"></i></a>
                <a href="#" target="_blank"><i class="ri-twitter-x-line"></i></a>
                <a href="#" target="_blank"><i class="ri-instagram-line"></i></a>
                <a href="#" target="_blank"><i class="ri-whatsapp-line"></i></a>
                <a href="#" target="_blank"><i class="ri-pinterest-fill"></i></a>
            </div>
        </div>

    </div>
    <hr>
    <p class="copyright">Copyright | JobPortal @ 2026 | All Rights Reserved</p>
</footer>

<style>
    

/* footer page  */

footer{
    width: 100%;
    bottom: 0;
    background-color: #f9f9f9;
    padding: 100px 0 30px;
    border-top-left-radius: 125px;
    font-size: 1rem;
    line-height: 20px;
    box-shadow: 0 -2px 8px rgba(0, 0, 0, 0.1);
}

.footer-row{
    width: 85%;
    margin: auto;
    display: flex;
    flex-wrap: wrap;
    align-items: flex-start;
    justify-content: space-between;
}

.footer-col{
    flex-basis: 25%;
    padding: 10px;
}

.footer-col:nth-child(2), .footer-col:nth-child(3){
    flex-basis: 15%;
}

.footer-col .nav-logo{
    width: 80px;
    margin-bottom: 40px;
}

.footer-col h4{
    width: fit-content;
    margin-bottom: 30px;
    position: relative;

}

.email-id{
    width: fit-content;
    border-bottom: 1px solid #333131;
    margin: 20px 0;
}

ul{
    margin: 0;
    padding: 0;
}

ul li{
    list-style: none;
    margin-bottom: 12px;
}

ul li a{
    text-decoration: none;
    color: black;
}


.social-links {
  display: flex;
  gap: 16px;
  padding-left: 0 !important;
}

.social-links a i {
  display: flex;
  width: 40px;
  height: 40px;
  background-color: white;
  border-radius: 50%;
  align-items: center;
  justify-content: center;
  font-size: 20px;
  transition: all 0.3s ease;
  box-shadow: 0 2px 8px rgba(0, 0, 0, 0.1);
}

.social-links a {
    text-decoration: none;
    color: black;
}



.social-links i:hover {
  transform: translateY(-4px);
  box-shadow: 0 4px 12px rgba(0, 0, 0, 0.15);
}

hr{
    width: 90%;
    border: 0;
    border-bottom: 1px solid #000;
    margin: 20px auto;
}

.copyright{
    text-align: center;
}

@media (max-width: 992px) {
    .footer-row {
        width: 90%;
    }
    .footer-col {
        flex-basis: 45%;
        margin-bottom: 30px;
    }
    .footer-col:nth-child(2),
    .footer-col:nth-child(3) {
        flex-basis: 45%;
    }
}


</style>