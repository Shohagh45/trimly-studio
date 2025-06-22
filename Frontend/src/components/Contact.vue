<template>
  <section class="contact-section">
    <h2>Contact Us</h2>
    <div class="contact-grid">
      <div class="contact-info">
        <div class="support-profile">
          <img src="/Donald Trump.webp" alt="Trimly Studio" class="logo" />
          <div>
            <p><strong>Support Team</strong></p>
            <p>Email: <a href="mailto:support@trimlystudio.com">support@trimlystudio.com</a></p>
            <p>Phone: <a href="tel:+31123456789">+31 123 456 789</a></p>
          </div>
        </div>

        <p><strong>Address:</strong><br />
          Haarlemmerstraat 123,<br />
          Amsterdam, Netherlands</p>

        <p><strong>Opening Hours:</strong></p>
        <ul>
          <li>Mon–Fri: 09:00 – 18:00</li>
          <li>Sat: 10:00 – 16:00</li>
          <li>Sun: Closed</li>
        </ul>

        <div class="social-links">
          <a href="https://instagram.com" target="_blank">
            <i class="fab fa-instagram"></i> Instagram
          </a>
          <a href="https://facebook.com" target="_blank">
            <i class="fab fa-facebook"></i> Facebook
          </a>
        </div>

        <div class="map-container">
          <iframe src="https://www.google.com/maps/embed?pb=!1m18..." allowfullscreen loading="lazy">
          </iframe>
        </div>

      </div>


      <form class="contact-form">
        <input type="text" placeholder="Your Name" required />
        <input type="email" placeholder="Your Email" required />
        <textarea placeholder="Your Message" rows="5" required></textarea>
        <button type="submit">Send Message</button>
      </form>
    </div>
  </section>
</template>

<style scoped>
.social-links i {
  margin-right: 6px;
}

.contact-section {
  padding: 2rem;
  max-width: 1000px;
  margin: auto;
}

h2 {
  text-align: center;
  margin-bottom: 2rem;
}

.contact-grid {
  display: flex;
  flex-wrap: wrap;
  gap: 2rem;
  justify-content: space-between;
}

.contact-info {
  flex: 1;
  min-width: 300px;
}

.support-profile {
  display: flex;
  align-items: center;
  gap: 1rem;
  margin-bottom: 1rem;
}

.support-profile img {
  width: 60px;
  height: 60px;
  border-radius: 50%;
  object-fit: cover;
}

.contact-form {
  flex: 1;
  min-width: 300px;
  display: flex;
  flex-direction: column;
  gap: 1rem;
}

.contact-form input,
.contact-form textarea {
  padding: 0.75rem;
  border: 1px solid #ccc;
  border-radius: 6px;
  width: 100%;
}

.contact-form button {
  padding: 0.75rem;
  background-color: #2b7fb8;
  color: white;
  border: none;
  border-radius: 6px;
  cursor: pointer;
}

.social-links {
  margin-top: 1rem;
}

.social-links a {
  margin-right: 1rem;
  color: #2b7fb8;
  text-decoration: none;
}

.map-container {
  margin-bottom: 10rem;
}

.map-container iframe {
  width: 100%;
  height: 250px;
  border: none;
  display: block;
}
</style>
