<section class = "accountpage">

      <h1> Hello <?= $collection[0]?>!</h1>
      <h3> User Account Settings:</h3>
      <div id = "phone"></div>
      <button id = "phoneButton" onclick="document.location = '<?php echo base_url(); ?>account/settings/Phone_Number'"></button>
      <div id = "verifyphone"></div>
      <button id = "verifyphoneButton" onclick="document.location = '<?php echo base_url(); ?>account/verify_phone'"></button>
      <div id = "address"></div>
      <button id = "addressButton" onclick="document.location = '<?php echo base_url(); ?>account/settings/address'"></button>
      <div id = "email"></div>
      <button id = "emailButton" onclick="document.location = '<?php echo base_url(); ?>account/settings/email'"></button>
      <div id = "verify"></div>
      <button id = "verifyButton" onclick="document.location = '<?php echo base_url(); ?>account/verify'"></button>
      <div id = "anom">Current View Status: </div>
      <button id = "anomButton" onclick="document.location = '<?php echo base_url(); ?>account/hidden/<?php echo $collection[8];?>'"></button>
      <div id = "secret">Current Secret Question Status:</div>
      <button id = "secretButton" onclick="document.location = '<?php echo base_url(); ?>account/question'"></button>
   </div>
</section>
</html>

<script>
set_info();

   function set_info() {
      var info = <?php echo json_encode($collection); ?>;

      if (info[2] != 0) {
         document.getElementById("phone").innerHTML = "Current Phone Number: " + info[2];
         document.getElementById("phoneButton").innerHTML = "Change Phone Number";
         if (info[9] == 0) {
            document.getElementById("verifyphone").innerHTML = "Current Phone Verification Status: Unverified";
            document.getElementById("verifyphoneButton").innerHTML = "Set Verification Status";
         } else {
            document.getElementById("verifyphone").innerHTML = "Current Phone Verification Status: Verified";
            document.getElementById("verifyphoneButton").style.display = "none";
         }
      } else {
         document.getElementById("verifyphoneButton").style.display = "none";
         document.getElementById("phone").innerHTML = "No phone number is currently set";
         document.getElementById("phoneButton").innerHTML = "Set Phone Number";
      }

      if (info[3] != '') {
         document.getElementById("address").innerHTML = "Current Address: " + info[3];
         document.getElementById("addressButton").innerHTML = "Change Address";
      } else {
         document.getElementById("address").innerHTML = "No address is currently set.";
         document.getElementById("addressButton").innerHTML = "Set Address";
      }

      if (info[4] != '') {
         document.getElementById("email").innerHTML = "Current Email: " + info[4];
         document.getElementById("emailButton").innerHTML = "Change Email";
         if (info[5] == 1) {
            document.getElementById("verify").innerHTML = "Current Verification Status: Verified";
            document.getElementById("verifyButton").style.display = "none";
         } else {
            document.getElementById("verify").innerHTML = "Current Verification Status: Unverified";
            document.getElementById("verifyButton").innerHTML = "Set Verification Status";
         }
      } else {
         document.getElementById("email").innerHTML = "No email is currently set. Set one to enable email verification.";
         document.getElementById("emailButton").innerHTML = "Set Email";
         document.getElementById("verifyButton").style.display = "none";
      }
      if (info[6] != '') {
         document.getElementById("secret").innerHTML = "Current Secret Question: " + info[6];
         document.getElementById("secretButton").innerHTML = "Change Secret Question";
      } else {
         document.getElementById("secret").innerHTML = "No secret question is currently set. Set one to add a way to log in if you forget your password.";
         document.getElementById("secretButton").innerHTML = "Set Secret Question";
      }

      if (info[8] == 0) {
         document.getElementById("anom").innerHTML = "Current View Status: Public";
      } else {
         document.getElementById("anom").innerHTML = "Current View Status: Hidden";
      }
      document.getElementById("anomButton").innerHTML = "Change View Status";
}

</script>

<style>
.accountpage {
   text-align: center;
}

</style>