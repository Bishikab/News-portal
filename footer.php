<style>
.footer {
    background-color: #783595;
    color: white;
    padding: 40px 20px 20px 20px;
    margin-top: 50px;
}

.footer-container {
    max-width: 1200px;
    margin: auto;
    display: flex;
    justify-content: space-between;
    flex-wrap: wrap;
    gap: 30px;
}

.footer-section {
    flex: 1;
    min-width: 220px;
    justify-content: flex-end;
}

.footer-section h3 {
    margin-bottom: 15px;
    font-size: 18px;
}



.footer-bottom {
    text-align: center;
    margin-top: 30px;
    border-top: 1px solid rgba(255,255,255,0.3);
    padding-top: 15px;
    font-size: 14px;
}
</style>

<footer class="footer">
    <div class="footer-container">

 
        <div class="footer-section">
            <h3>About NewsVerse</h3>
            <p>Your trusted source for latest news in World, Politics, Sports, Science, and more.</p>
        </div>

 

       
        <div class="footer-section">
            <h3>Contact</h3>
            <p>Email: info@newsverse.com</p>
            <p>Phone: +977-9887788</p>
            <p>Location: Nepal</p>
        </div>

    </div>

    <div class="footer-bottom">
        © <?php echo date("Y"); ?> NewsVerse. All rights reserved.
    </div>
</footer>