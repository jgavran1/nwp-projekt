<style>
    /* Glavni kontejner za cijelu stranicu */
    .about-blog-container {
        max-width: 800px;
        margin: 40px auto;
        padding: 30px;
        background: #ffffff;
        border-radius: 12px;
        box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        color: #333333;
    }

    /* Naslov stranice */
    .about-blog-container h1 {
        color: #2b358a;
        font-size: 2.5rem;
        border-bottom: 3px solid #2b358a;
        padding-bottom: 10px;
        margin-top: 0;
        margin-bottom: 25px;
    }

    /* Tekstualni odlomci */
    .about-blog-container p {
        font-size: 1.1rem;
        line-height: 1.8;
        margin-bottom: 20px;
        text-align: justify;
    }

    /* Sekcija s fotoaparatom */
    .camera-section {
        display: flex;
        align-items: center;
        background: #f8f9fa;
        padding: 15px 20px;
        border-left: 5px solid #2b358a;
        border-radius: 4px;
        margin: 30px 0;
    }

    .camera-text {
        flex: 1;
        font-weight: 500;
        margin: 0 !important;
    }

    .camera-img {
        width: 80px;
        height: auto;
        transition: transform 0.3s ease;
    }

    .camera-img:hover {
        transform: scale(1.1);
    }

    /* Donja sekcija s društvenim mrežama */
    .social-section {
        margin-top: 50px;
        padding-top: 30px;
        border-top: 1px solid #eeeeee;
        text-align: center;
    }

    .social-section h3 {
        color: #555555;
        font-size: 1.2rem;
        margin-bottom: 20px;
        text-transform: uppercase;
        letter-spacing: 1px;
    }

    /* Linkovi i ikone u dnu */
    .social-links {
        display: flex;
        justify-content: center;
        align-items: center;
        gap: 25px;
    }

    .social-icon {
        height: auto;
        transition: transform 0.3s ease, filter 0.3s ease;
    }

    .icon-small {
        width: 45px;
    }

    .icon-logo {
        width: 140px;
    }

    .social-icon:hover {
        transform: translateY(-5px);
        filter: drop-shadow(0 4px 8px rgba(43, 53, 138, 0.3));
    }
</style>

<div class="about-blog-container">
    <h1>Torte i kolači</h1>
    
    <p>Preciznost u izvedbi na stol ti donose tortu kojoj se dive svi. Osim torti, na društvenim mrežama pronaći ćete razne slastice od dizanog tijesta, kolače i kekse.</p>
    
    <p>Ideja je nastala prije gotovo šest godine, kada sam krenuo s pripremom slanih jela.</p>
    
    <p>Na društvenim mrežama danas brojim gotovo 25.000 pratitelja, brojka o kojoj sam u početku mogao samo sanjati.</p>

    <div class="camera-section">
        <p class="camera-text">Kod fotografiranja slastica koristim provjereni <strong>Nikon D850</strong> <a href="https://www.nikonusa.com/p/d850/1585/overview?srsltid=AfmBOoqGUxIcMljxIAYVP3lC-qmMw4kdGthWyAdSFRzy1fenHvkvqkql" target="_blank">
            <img src="img/nikon.jpg" alt="Nikon" title="Pogledaj Nikon D5300" class="camera-img">
        </a> koji hvata svaki detalj.</p>
    </div>

    <div class="social-section">
        <h3>Pratite Woodie Foodie</h3>
        <div class="social-links">
            <a href="https://www.instagram.com/woodie._foodie/" target="_blank">
                <img src="img/instagram.jpg" alt="Instagram" title="Instagram" class="social-icon icon-small">
            </a>
            
            <a href="https://www.facebook.com/woodie.foodie/" target="_blank">
                <img src="img/facebook.png" alt="Facebook" title="Facebook" class="social-icon icon-small">
            </a>
        </div>
    </div>
</div>