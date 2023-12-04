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
        <STYle>
        body {
            font-family: Arial, sans-serif;
            background-color: #f4f4f4;
            margin: 0;
            padding: 0;
            display: flex;
            align-items: center;
            justify-content: center;
            height: auto;
          }

          #container {
            background-color: #fff;
            padding: 20px;
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            width: 100%;
            display: flex;
            flex-direction: column;
          }

          #inputContainer {
            margin-bottom: 20px;
          }

          #output {
            display: flex;
            flex-direction: column;
            align-items: center;
          }

          #output textarea {
            width: 100%;
            height: 200px;
            margin-top: 10px;
          }

          button {
            margin-top: 10px;
            padding: 10px;
            cursor: pointer;
          }

          #validEmails, #invalidEmails, #additionalValidEmails {
            display: none;
            width: 100%;
          }

          #error {
            color: red;
            margin-top: 10px;
          }


          .button {
        display: inline-block;
        border-radius: 4px;
        background-color: #36b1f7;
        border: none;
        color: #FFFFFF;
        text-align: center;
        font-size: 18px;
        padding: 20px;
        width: 200px;
        transition: all 0.5s;
        cursor: pointer;
        margin: 5px;
        }

        .button span {
        cursor: pointer;
        display: inline-block;
        position: relative;
        transition: 0.5s;
        }

        .button span:after {
        content: '\00bb';
        position: absolute;
        opacity: 0;
        top: 0;
        right: -20px;
        transition: 0.5s;
        }

        .button:hover span {
        padding-right: 25px;
        }

        .button:hover span:after {
        opacity: 1;
        right: 0;
        }

        .headingtxt{
          background-color: #04AA6D; /* Green */
        border: none;
        color: white;
        padding: 15px 32px;
        text-align: center;
        text-decoration: none;
        display: inline-block;
        margin: 4px 2px;
        cursor: pointer;
        }

        @keyframes blink {
            0%, 100% {
              background-color: red;
              color: white;
            }
            50% {
              background-color: blue;
              color: white;
            }
          }

          .blinking-button {
            animation: blink 1s infinite;
            border: none;
            padding: 10px 20px;
            cursor: pointer;
            font-size: 16px;
            border-radius: 5px;
          }


          footer {
            background-color: #333;
            color: white;
            padding: 10px;
            text-align: center;
            width: 100%;
          }


      </STYle>
       
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
