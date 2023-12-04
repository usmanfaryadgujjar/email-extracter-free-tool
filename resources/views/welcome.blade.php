<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Email Extractor Tool </title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,600&display=swap" rel="stylesheet" />

        <!-- Styles -->
        @include('scriptfile')
       
    </head>
    <body>
        
      <div id="container">
        <div class="headingtxt">
            <h1>Email Extractor</h1>
        <label> A free online tool to extract email addresses from the text content and download with Excel</label>
        </div>
      
          <div id="inputContainer">
             <br>   
            <label for="data">Enter Data (max 5000 lines):</label><br>
            <textarea id="data" rows="17" style="width: 100%;" placeholder="Enter Data OR Copy/Past here..."></textarea>
            <br><br>
            
            <label for="providers">Enter Email Providers (comma-separated):</label><br>
            <textarea rows="2" style="width: 100%;" id="providers" style="width: 100%; hight: 10px;" placeholder="Enter email providers..."></textarea>
           
          </div>

            <div id="output">
                
            <button class="button" style="vertical-align:middle" onclick="processEmails()"><span>Show Results</span></button>
            

            <div id="validEmails">
              <center > 
              <div class="blinking-button" > 👇 Check Download Email In Below given Button Show 👇</div>
              </center>
              
          
                <h3>Emails Valid:</h3>
                <textarea id="validEmailsOutput" readonly></textarea>
                <button class="button" style="vertical-align:middle" onclick="downloadValidEmails()"><span>Click Download Valid Emails</span> </button>
            </div>
            <div id="invalidEmails">
                <h3>Emails Not Valid:</h3>
                <textarea id="invalidEmailsOutput" readonly></textarea>
                <button class="button" style="vertical-align:middle" onclick="downloadInvalidEmails()"><span>Click Download Invalid Emails </span></button>
            </div>

            <!-- <div id="additionalValidEmails">
                <h3>All Entered Emails:</h3>
                <textarea id="additionalValidEmailsOutput" readonly></textarea>

                <button class="button" style="vertical-align:middle; background-color:#6df76f;"  onclick="downloadAllEnteredEmails()"><span>Click Download All Entered Data alid or Invalid</span> </button>
            </div> -->


            <div id="error"></div>
            
              <footer>
                <p>&copy; 2023 Email Extractor . All rights reserved.</p>
                <p>Develop by Netsear (M Usman) </p>
              </footer>
            </div>
        </div>

        

    </body>

    
    <!-- Content js -->
    <script>
    function processEmails() {
      var inputData = document.getElementById('data').value.trim();
      if (inputData === "") {
        document.getElementById('error').innerText = "Please enter data.";
        return;
      }


      var providersInput = document.getElementById('providers').value;
      var emailProviders = providersInput.split(',').map(provider => provider.trim());

      var validEmails = [];
      var invalidEmails = [];
      var allEnteredEmails = [];

      var emailRegex = {};

      emailProviders.forEach(provider => {
        emailRegex[provider] = new RegExp(`^[_a-z0-9-]+(\\.[_a-z0-9-]+)*@${provider}+(\\.com)$`, 'i');
      });

      var emails = inputData.split('\n').map(email => email.trim());

      emails.forEach(email => {
        var isValid = false;

        for (var provider in emailRegex) {
          if (emailRegex[provider].test(email)) {
            if (provider === 'more') {
              allEnteredEmails.push(email);
            } else {
              validEmails.push(email);
            }
            isValid = true;
            break;
          }
        }

        if (!isValid) {
          invalidEmails.push(email);
          allEnteredEmails.push(email);
        }
      });

      document.getElementById('validEmailsOutput').value = validEmails.join('\n');
      document.getElementById('invalidEmailsOutput').value = invalidEmails.join('\n');
      //document.getElementById('additionalValidEmailsOutput').value = allEnteredEmails.join('\n');
      

      document.getElementById('validEmails').style.display = 'block';
      document.getElementById('invalidEmails').style.display = 'block';
      //document.getElementById('additionalValidEmails').style.display = 'block';

      // Clear error message
      document.getElementById('error').innerText = "";
    }

    function downloadValidEmails() {
      var validEmails = document.getElementById('validEmailsOutput').value;
      download('valid_emails.csv', validEmails);
    }

    function downloadInvalidEmails() {
      var invalidEmails = document.getElementById('invalidEmailsOutput').value;
      download('invalid_emails.csv', invalidEmails);
    }

    // function downloadAllEnteredEmails() {
    //   var allEnteredEmails = document.getElementById('additionalValidEmailsOutput').value;
    //   download('all_entered_emails.csv', allEnteredEmails);
    // }

    function download(filename, text) {
      var element = document.createElement('a');
      element.setAttribute('href', 'data:text/csv;charset=utf-8,' + encodeURIComponent(text));
      element.setAttribute('download', filename);

      element.style.display = 'none';
      document.body.appendChild(element);

      element.click();

      document.body.removeChild(element);
    }
  </script>
    


</html>
