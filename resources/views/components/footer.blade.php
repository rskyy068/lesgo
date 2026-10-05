<style>
    :root {
        --footer-bg: #333333;
        --footer-text: #e0e0e0;
        --footer-heading: #ffffff;
        --footer-link-hover: #f0f0f0;
        --footer-border: #4f4f4f;
    }

    .footer-local {
        background-color: var(--footer-bg);
        color: var(--footer-text);
        padding: 3rem 0;
        font-size: 0.95rem;
        line-height: 1.6;
    }

    .footer-local__main {
        display: grid;
        grid-template-columns: 1fr;
        gap: 2.5rem;
        padding-bottom: 2.5rem;
        border-bottom: 1px solid var(--footer-border);
    }

    .footer-local__details h3 {
        color: var(--footer-heading);
        font-size: 1.25rem;
        margin: 0 0 1.5rem 0;
    }

    .footer-local__details p {
        margin: 0 0 1rem 0;
    }
    .footer-local__details a {
        color: var(--footer-text);
        text-decoration: none;
        transition: color 0.2s;
    }
    .footer-local__details a:hover {
        color: var(--footer-link-hover);
        text-decoration: underline;
    }

    .footer-local__hours-list {
        margin: 0;
        padding: 0;
        list-style: none;
    }
    .footer-local__hours-list li {
        display: flex;
        justify-content: space-between;
        padding: 0.25rem 0;
    }
    .footer-local__hours-list li span:first-child {
        font-weight: 500;
    }

    .footer-local__map iframe {
        width: 100%;
        height: 100%;
        min-height: 250px;
        border: 0;
        border-radius: 8px;
    }

    .footer-local__bottom {
        padding-top: 1.5rem;
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
        text-align: center;
        font-size: 0.875rem;
    }

    .footer-local__copyright { margin: 0; }

    .footer-local__social ul {
        margin: 0;
        padding: 0;
        list-style: none;
        display: flex;
        gap: 1.5rem;
    }
    .footer-local__social a { color: var(--footer-text); transition: color 0.2s; }
    .footer-local__social a:hover { color: var(--footer-link-hover); }
    .footer-local__social svg { width: 22px; height: 22px; fill: currentColor; }

    @media (min-width: 992px) {
        .footer-local__main {
            grid-template-columns: 1fr 1.2fr;
            gap: 4rem;
        }
        .footer-local__bottom {
            flex-direction: row;
            justify-content: space-between;
        }
    }
</style>

<footer class="footer-local" role="contentinfo">
    <div class="container">
        <div class="footer-local__main">
            <div class="footer-local__details">
                <h3>LesGo</h3>
                <p>
                    Platform Pencarian Bimbel Terbaik<br>
                    Jakarta, Indonesia
                </p>
                <p>
                    <strong>Phone:</strong> <a href="tel:+6281234567890">+62 812-3456-7890</a><br>
                    <strong>Email:</strong> <a href="mailto:info@lesgo.id">info@lesgo.id</a>
                </p>
                <ul class="footer-local__hours-list">
                    <li><span>Senin - Jumat</span> <span>08:00 - 17:00</span></li>
                    <li><span>Sabtu</span> <span>09:00 - 15:00</span></li>
                </ul>
            </div>
            <div class="footer-local__map">
                <iframe
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d126920.27292723707!2d106.759478!3d-6.2297465!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e69f3e80d676d65%3A0x401e8f1fc28c690!2sJakarta!5e0!3m2!1sid!2sid!4v1620000000000!5m2!1sid!2sid"
                    loading="lazy"
                    aria-label="Lokasi LesGo">
                </iframe>
            </div>
        </div>
        <div class="footer-local__bottom">
            <p class="footer-local__copyright">&copy; {{ date('Y') }} LesGo. All Rights Reserved.</p>
        </div>
    </div>
</footer>
