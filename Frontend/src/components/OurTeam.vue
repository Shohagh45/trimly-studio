<template>
  <section class="page-section">
    <h2>Our Team</h2>
    <p>Meet the talented barbers behind Trimly Studio:</p>
    <div class="team-grid">
      <div class="team-member">
       <img src="/Donald Trump.webp" alt="Trimly Studio" class="logo" />
        <p><strong>Donald j stupid</strong><br />Master Barber with 10+ years experience</p>
      </div>
    <div class="team-member">
         <img src="/Greet.webp" alt="Trimly Studio" class="logo" />
        <p><strong>Greet the wildflower</strong><br />Fade specialist and grooming expert</p>
      </div>
      <div class="team-member">
         <img src="/Macron.webp" alt="Trimly Studio" class="logo" />
        <p><strong>Macron Mommmy's Boy</strong><br />Creative stylist and beard artist</p>
      </div>
      <div class="team-member">
         <img src="/Meloni.webp" alt="Trimly Studio" class="logo" />
        <p><strong>Sad Meloni</strong><br />Creative Pedicure specialist</p>
      </div>
      
    </div>
  </section>
</template>

<style scoped>
.page-section {
  text-align: center;
  padding: 2rem;
}

.team-grid {
  display: flex;
  justify-content: center;
  gap: 2rem;
  flex-wrap: wrap;
  margin-top: 2rem;
}

.team-member {
  max-width: 180px;
  text-align: center;
}

.team-member img {
  width: 100%;
  height: auto;
  border-radius: 50%;
  box-shadow: 0 4px 8px rgba(0,0,0,0.1);
}

.team-member p {
  margin-top: 0.5rem;
  font-size: 0.95rem;
}
</style>
