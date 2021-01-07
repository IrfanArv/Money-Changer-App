<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link href="<?php echo base_url().'uploads/favicon.png'?>" rel="shortcut icon">
    <link href="<?php echo base_url().'uploads/favicon.png'?>" rel="apple-touch-icon">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Daftar Bafageh Money Changer Apps</title>
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
                            <form class="user" action="<?php echo site_url('setting/registrasi');?>" method="post" id="form-daftar">
                                
                                    <div class="form-group">
                                        <input type="text" class="input-text" name="username" id="username"  value="<?php echo set_value('username'); ?>" placeholder="Nama (Diawali Huruf Besar)" autofocus>
                                        <?php echo "<span class='text-danger'>".form_error('username')."</span>"; ?>
                                        <?php echo "<span class='text-danger'>".$this->session->flashdata('error_username')."</span>"; ?>
                                        <i class="fa fa-user"></i>
                                        <span class="focus-border"></span>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    
                                    <div class="form-group">
                                        <input type="email" class="input-text" name="email" id="email"  value="<?php echo set_value('email'); ?>" placeholder="Email Bafageh Ex: irfan@bafageh.com">
                                        <?php echo "<span class='text-danger'>".form_error('email')."</span>"; ?>
                                        <?php echo "<span class='text-danger'>".$this->session->flashdata('error_email')."</span>"; ?>
                                        <i class="fa fa-envelope"></i>
                                        <span class="focus-border"></span>
                                        <div class="invalid-feedback"></div>
                                    </div>
                                    
                                    <div class="form-group row">
                                        <div class="col-sm-6 mb-3 mb-sm0">
                                            <input type="password" class="input-text" name="password" id="password" placeholder="Password">
                                                <?php echo "<span class='text-danger'>".form_error('password')."</span>"; ?>
                                                <i class="fa fa-lock"></i>
                                                <span class="focus-border"></span>
                                                <div class="invalid-feedback"></div>
                                        </div>
                                        
                                        <div class="col-sm-6">
                                            <input type="password" class="input-text" name="confirm_password" id="confirm_password" placeholder="Ulang Password">
                                                <?php echo "<span class='text-danger'>".form_error('confirm_password')."</span>"; ?>
                                                <i class="fa fa-lock"></i>
                                                <span class="focus-border"></span>
                                                <div class="invalid-feedback"></div>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                    <select class="input-text" name="role" id="role" required>
                                        <option value="">Pilih Role Anda</option>
                                        <option value="3">Teller</option>
                                        <option value="2">Valas Backoffice</option>
                                    </select>
                                    </div>
                                    <div class="form-group">
                                        <button type="submit" class="btn-md btn-theme btn-block">Daftar</button>
                                    </div>
                            </form>
                            <?php echo $this->session->flashdata('message'); ?>
                            <ul class="login_tab">
                                <li><a href="<?php echo base_url().''?>"> Login</a></li>
                                <li><a class="active" href="<?php echo base_url().'setting/registrasi'?>"> Daftar</a></li>
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
    var url = "<?php echo site_url() ?>";
    jQuery.validator.setDefaults({
        highlight: function(element) {
            jQuery(element).closest('.form-control').addClass('is-invalid');
            
        },
        unhighlight: function(element) {
            jQuery(element).closest('.form-control').removeClass('is-invalid');
        },
        errorElement: 'div',
        errorClass: 'invalid-feedback',
        errorPlacement: function(error, element) {
            if(element.parent('.input-group').length) {
                error.insertAfter(element.parent());
                
            } else {
                error.insertAfter(element);
                
            }
        }
    });

        $( "#form-daftar" ).validate({
            rules: {
                            username: {
                                required: true,
                                minlength: 2
                            },
                            email: {
                                required: true,
                                email: true
                                
                            },
                            password: {
                                required: true,
                                minlength: 5
                            },
                            confirm_password: {
                                required: true,
                                minlength: 5,
                                equalTo: "#password"
                            },
                            role{
                                required: true
                            }
                },
                messages: {
                            username: {
                                required: "Tidak Boleh Kosong",
                                minlength: "minimal 2 characters"
                            },
                            password: {
                                required: "Tidak Boleh Kosong",
                                minlength: "minimal 5 characters"
                            },
                            confirm_password: {
                                required: "Tidak Boleh Kosong",
                                minlength: "minimal 5 characters",
                                equalTo: "Password Harus Sama"
                            },
                            email:{
                            email: "Email Salah",
                            required: "Tidak Boleh Kosong",
                            remote:"Email Sudah Terdaftar"
                            },
                            role{
                                required: "Pilih salah satu"
                            }
                    },
                    

        });

        $(function(){
            if($('.alert').show()){
                hilang();
                }
            })
            
        function hilang(){
        window.setTimeout(function() {
            $(".alert").fadeTo(500, 0).slideUp(500, function(){
                $(this).remove(); 
            });
        }, 4000);
        }


</script>
</html>