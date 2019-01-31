<!-- Contact Section -->
  <div class="w3-container w3-padding-32" id="contact">
    <h3 class="w3-border-bottom w3-border-light-grey w3-padding-16">Contact</h3>
    <p>Lets get in touch and talk about your next project.</p>
    <form action="/action_page.php" target="#" method="POST">
      <input class="w3-input w3-border" type="text" maxlength="30" placeholder="Name" required name="name">
      <input class="w3-input w3-section w3-border" type="email" placeholder="Email" required name="email">
      <input class="w3-input w3-section w3-border" type="text" placeholder="Subject" required name="subject">
      <textarea class="w3-input w3-section w3-border" placeholder="Message" rows="6" required name="message"></textarea>
<div>
	  <button class="w3-button w3-black w3-section" type="button" onclick="ggForm(this, '/contact')">
		<i class="fa fa-paper-plane"></i> SEND MESSAGE
	  </button>
  </div>
    </form>
  </div>
