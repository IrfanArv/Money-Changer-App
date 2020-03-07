<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?php echo base_url().'uploads/favicon.png'?>" rel="shortcut icon">
    <link href="<?php echo base_url().'uploads/favicon.png'?>" rel="apple-touch-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Login Bafageh Money Changer</title>
    <!-- External CSS -->
    <link type="text/css" rel="stylesheet" href="<?php echo base_url().'assets/login/assets/css/bootstrap.min.css'?>">
    <link type="text/css" rel="stylesheet" href="<?php echo base_url().'assets/login/assets/fonts/font-awesome/css/font-awesome.min.css'?>">
 
    <!-- Custom Stylesheet -->
    

    <link type="text/css" rel="stylesheet" href="<?php echo base_url().'assets/login/css/login-nine.css'?>">

</head>
<body>

<!-- Loader -->
<div class="loader"><div class="loader_div"></div></div>

<!-- Login page -->
<div class="login_wrapper">
    <div class="row no-gutters">

        <div class="col-md-6 mobile-hidden">
            <div class="login_left">
                <div class="login_left_img"><img src="<?php echo base_url().'assets/login/images/login-bg.jpg'?>" alt="login background"></div>
            </div>
        </div>
        <div class="col-md-6 bg-white">
            <div class="login_box">
                        <a href="#" class="logo_text">
                            <img alt="" src="<?php echo base_url().'uploads/logo.png'?>" style="height: 65px;width: 250px;">
                            
                        </a>
                        <a href="#" class="logo_text">
                           
                            <span>Bafageh</span> Money Changer
                        </a>
                    <div class="login_form">
                        <div class="login_form_inner">
                            <!-- <h3>Login to <span>your account</span></h3> -->
                            <form class="user" action="<?php echo site_url('login');?>" method="post" id="form-login">
                                <?php echo $this->session->flashdata('error'); ?>
                                <?php echo $this->session->flashdata('message'); ?>
                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
                                <div class="form-group">
                                    <input type="text" class="input-text" value="<?php echo set_value('email') ?>" name="email" id="email" aria-describedby="emailHelp" placeholder="Email">
                                    <i class="fa fa-envelope"></i>
                                    <span class="focus-border"></span>
                                    <div class="invalid-feedback"></div>
                                </div>

                                
                                <div class="form-group">
                                    <input type="password" class="input-text" name="password" id="password" placeholder="Password">
                                    <i class="fa fa-lock"></i>
                                    
                                    <span class="focus-border"></span>
                                    <div class="invalid-feedback"></div>
                                </div>
                                <div class="form-group">
                                    <button type="submit" class="btn-md btn-theme btn-block">Masuk</button>
                                </div>
                                <?php echo"<span class='text-danger'>".form_error('email')."</span>"; ?>
                                <?php echo"<span class='text-danger'>".$this->session->flashdata('error_email')."</span>"; ?><br>
                                <?php echo"<span class='text-danger'>".form_error('password')."</span>"; ?>
                                <?php echo"<span class='text-danger'>".$this->session->flashdata('error_password')."</span>"; ?>
                                
                            </form>
                            <ul class="login_tab">
                                <li><a class="active" href="<?php echo base_url().''?>"> Login</a></li>
                                <li><a href="<?php echo base_url().'registrasi'?>"> Daftar</a></li>
                            </ul>
                        </div>
                    </div>
            </div>
        </div>
    </div>

</div>
<!-- /. Login page -->


<!-- External JS libraries -->
<script src="<?php echo base_url().'assets/login/assets/js/jquery-2.2.0.min.js'?>"></script>
<script src="<?php echo base_url().'assets/login/assets/js/popper.min.js'?>"></script>
<script src="<?php echo base_url().'assets/login/assets/js/bootstrap.min.js'?>"></script>
<!-- Custom JS Script -->
<script type="text/javascript">
    $(window).load(function() {
        $(".loader").fadeOut("slow");;
    });
</script>

<script type="text/javascript">
    $(function(){
      if($('.alert').show()){
        hilang();
        }
    });
      
    function hilang(){
      window.setTimeout(function() {
          $(".alert").fadeTo(500, 0).slideUp(500, function(){
              $(this).remove(); 
          });
      }, 4000);
    }


</script>
</html>