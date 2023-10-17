<?php include __DIR__ . '/../header.php'?>    
    <section class="Testimonials">
        <div class="container">
            <h2 class="heading">Redact</h2>
            <?php if(!empty($error)): ?>
                <div style="background-color: red;padding: 5px;margin: 15px"><?= $error ?></div>
            <?php endif; ?>
            <form class="contact-info" method="POST">
                        <div class="field">
                            <label for="name">First Name*</label>
                            <input type="text" placeholder="FirstName" id="firstName" 
                                   name="clientFirstName" value="<?= $_POST['clientFirstName'] ?? $client->getFirstName() ?>">
                        </div>
                        <div class="field">
                            <label for="name">Last Name*</label>
                            <input type="text" placeholder="LastName" id="lastName" 
                                   name="clientLastName" value="<?= $_POST['clientLastName'] ?? $client->getLastName() ?>">
                        </div>

                        <div class="field">
                            <label for="email">Email*</label>
                            <input type="email" placeholder="ClientEmail" id="clientEmail"
                             name="clientEmail" value="<?= $_POST['clientEmail'] ?? $client->getEmail() ?>">
                        </div>

                        <div class="field">
                            <label for="position">Position</label>
                            <input type="text" placeholder="Profession name" id="clientPosition" 
                            name="clientPosition" value="<?= $_POST['clientPosition'] ?? $clientProfile->getPosition() ?>">
                        </div>

                        
                        <div class="field">
                            <label for="name">Company Name</label>
                            <input type="text" placeholder="CompanyName" id="companyName" 
                            name="companyName" value="<?= isset($company) ? $company->getName() : (isset($_POST['companyName']) ? $_POST['companyName'] : null)  ?>">
                        </div>
                        <div class="field">
                            <label for="phoneWork">Work Phone Number</label>
                            <input type="text" placeholder="WorkPhoneNumber" id="phone" 
                            name="phoneWork" value="<?= $_POST['phoneWork'] ?? $clientProfile->getWorkPhoneNumber() ?>">
                        </div>
                        <div class="field">
                            <label for="phoneHome">Home Phone Number</label>
                            <input type="text" placeholder="HomePhoneNumber" id="phone" 
                            name="phoneHome" value="<?= $_POST['phoneHome'] ?? $clientProfile->getHomePhoneNumber() ?>">
                        </div>
                        <div class="field">
                            <label for="phoneAdditional">Additional Phone Number</label>
                            <input type="text" placeholder="AdditionalPhoneNumber" id="phone" 
                            name="phoneAdditional" value="<?= $_POST['phoneAdditional'] ?? $clientProfile->getAdditionalPhoneNumber() ?>">
                        </div>
                        
                    
                    <div class="submit">
                        <input type="submit" value="UPDATE">
                    </div>
            </form>
        </div>
    </section>
<?php include __DIR__ . '/../footer.php'?>