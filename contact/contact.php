
<?php
$isPosting = $_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST);
$hasErrors = false;

function sanitize_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
}

if($isPosting)
{
    // Get data from form  
    $name = sanitize_input($_POST['name']);
    $email= sanitize_input($_POST['email']);
    $message= sanitize_input($_POST['message']);
 
    if(strlen($name < 1)){
        $nameErr  = "Name is required";
    }
    else if (!preg_match("/^[a-zA-Z-' ]*$/",$name)) {
        $nameErr = "Only letters and white space allowed";
    }

    if (empty($email)) {
        $emailErr = "Email is required";
    }
    else {
        // check if e-mail address is well-formed
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
          $emailErr = "Invalid email format";
        }
    }

    if (empty($message)) {
        $msgErr = "Message is required";
    }

    $hasErrors = isset($nameErr) || isset($emailErr) || isset($msgErr);

    if(!$hasErrors){

        $to = "daphillips@mail.pima.edu";
        $subject = "New message from pimaamateurradioclub.com";
 
        // The following text will be sent
        // Name = user entered name
        // Email = user entered email
        // Message = user entered message 
        $txt ="Name = ". $name . "\r\n  Email = "
            . $email . "\r\n Message =" . $message;
 
        $headers = "From: noreply@pimaamateurradioclub.com" . "\r\n" .
                    "CC: drew@unepic.com";
        if($email != NULL) {
            mail($to, $subject, $txt, $headers);
        }
 
        // Redirect to
        //header("Location: index.html");

    }
}
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8" />
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
        <meta name="description" content="" />
        <meta name="author" content="" />
        <title>Pima Amateur Radio Club - Contact</title>
        <link rel="icon" type="image/x-icon" href="assets/images/ham-radio-icon.jpg" />
        <!-- Font Awesome icons (free version)-->
        <script src="https://use.fontawesome.com/releases/v6.3.0/js/all.js" crossorigin="anonymous"></script>
        <!-- Google fonts-->
        <link href="https://fonts.googleapis.com/css?family=Lora:400,700,400italic,700italic" rel="stylesheet" type="text/css" />
        <link href="https://fonts.googleapis.com/css?family=Open+Sans:300italic,400italic,600italic,700italic,800italic,400,300,600,700,800" rel="stylesheet" type="text/css" />
        <!-- Core theme CSS (includes Bootstrap)-->
        <link href="../css/styles.css" rel="stylesheet" />
    </head>
    <body>
        <!-- Navigation-->
        <nav class="navbar navbar-expand-lg navbar-light" id="mainNav">
            <div class="container px-4 px-lg-5">
                <a class="navbar-brand" href="../">Pima Amateur Radio Club</a>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarResponsive" aria-controls="navbarResponsive" aria-expanded="false" aria-label="Toggle navigation">
                    Menu
                    <i class="fas fa-bars"></i>
                </button>
                <div class="collapse navbar-collapse" id="navbarResponsive">
                    <ul class="navbar-nav ms-auto py-4 py-lg-0">
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="../">Home</a></li>
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="../license/">License</a></li>
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" href="../links/">Links</a></li>
                        <li class="nav-item"><a class="nav-link px-lg-3 py-3 py-lg-4" style="cursor:pointer;opacity:0.7;">Contact</a></li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page Header-->
        <header class="masthead" style="background-image: url('../assets/images/pima-ham-radio-club-about.jpg')">
            <div class="container position-relative px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <div class="page-heading">
                            <h1>Contact The Club</h1>
                            <span class="subheading">Have questions? We have answers.</span>
                        </div>
                    </div>
                </div>
            </div>
        </header>
        <!-- Main Content-->
        <main class="mb-4">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
<?php
if($isPosting && !$hasErrors)
{
?>
                        <p>Thanks for your message!</p>
<?php
}
else
{
?>
                        <p>Want to get in touch? Fill out the form below to send us a message and we will get back to you as soon as possible!</p>

                            <section id="last">
                                <!-- heading -->
                                <div class="full">
                                    <h3>Drop a Message</h3>

                                    <div class="lt">

                                        <!-- form starting  -->
                                        <form class="form-horizontal" method="post" action="contact.php">
                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <!-- name  -->
                                                    <input type="text" class="form-control"
                                                           id="name" placeholder="NAME"
                                                           name="name" value="<?php echo $name; ?>" />
                                                           <?php if(isset($nameErr)){?><div class="error"><?php echo $nameErr; ?></div><?php }?>
                                                </div>
                                            </div>

                                            <div class="form-group">
                                                <div class="col-sm-12">
                                                    <!-- email  -->
                                                    <input type="email" class="form-control"
                                                           id="email" placeholder="EMAIL"
                                                           name="email" value="<?php echo $email; ?>" />
                                                           <?php if(isset($emailErr)){?><div class="error"><?php echo $emailErr; ?></div><?php }?>
                                                </div>
                                            </div>

                                            <!-- message  -->
                                            <textarea class="form-control" rows="10" placeholder="MESSAGE" name="message"><?php echo $message ?></textarea>
                                            <?php if(isset($msgErr)){?><div class="error"><?php echo $msgErr; ?></div><?php }?>

                                            <button class="btn btn-primary send-button"
                                                    id="submit" type="submit" value="SEND">
                                                <i class="fa fa-paper-plane"></i>
                                                <span class="send-text">SEND</span>
                                            </button>
                                        </form>
                                        <!-- end of form -->
                                    </div>

                                    <!-- Contact information -->
                                    <div class="rt">
                                       
                                    </div>
                                    <br>
                                </div>
                            </section>
<?php
}
?>                 

                    </div>
                </div>
            </div>
        </main>
        <!-- Footer-->
        <footer class="border-top">
            <div class="container px-4 px-lg-5">
                <div class="row gx-4 gx-lg-5 justify-content-center">
                    <div class="col-md-10 col-lg-8 col-xl-7">
                        <ul class="list-inline text-center">
                            <li class="list-inline-item">
                                <a href="https://github.com/drewphillips/pimaamateurradioclub">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-github fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>

                            <li class="list-inline-item">
                                <a href="https://discord.gg/pJPcaBAr">
                                    <span class="fa-stack fa-lg">
                                        <i class="fas fa-circle fa-stack-2x"></i>
                                        <i class="fab fa-discord fa-stack-1x fa-inverse"></i>
                                    </span>
                                </a>
                            </li>

                        </ul>
                        <div class="small text-center text-muted fst-italic">Pima Amateur Radio Club 2024</div>
                    </div>
                </div>
            </div>
        </footer>
    </body>
</html>
