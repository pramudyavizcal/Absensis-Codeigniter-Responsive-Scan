 <?= $this->extend('templates/starting_page_layout'); ?>

 <?= $this->section('navaction') ?>

 <?= $this->endSection() ?>

 <?= $this->section('content'); ?>
 <style>
 body {
   margin: 0;
   padding: 0;
   font-family: 'Roboto', sans-serif;
   background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
   min-height: 100vh;
   display: flex;
   align-items: center;
   justify-content: center;
   position: relative;
   overflow: hidden;
 }

 .particles {
   position: absolute;
   top: 0;
   left: 0;
   width: 100%;
   height: 100%;
   overflow: hidden;
   z-index: 1;
 }

 .particle {
   position: absolute;
   border-radius: 50%;
   background: rgba(255,255,255,0.1);
   animation: float 6s infinite linear;
 }

 @keyframes float {
   0% { transform: translateY(100vh) rotate(0deg); }
   100% { transform: translateY(-100vh) rotate(360deg); }
 }

 .login-container {
   background: rgba(255, 255, 255, 0.1);
   backdrop-filter: blur(20px);
   border-radius: 20px;
   padding: 40px;
   box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
   max-width: 400px;
   width: 100%;
   position: relative;
   z-index: 2;
   border: 1px solid rgba(255, 255, 255, 0.2);
 }

 .logo-section {
   text-align: center;
   margin-bottom: 30px;
 }

 .logo {
   width: 80px;
   height: 80px;
   margin-bottom: 20px;
   border-radius: 50%;
   background: rgba(255, 255, 255, 0.2);
   display: flex;
   align-items: center;
   justify-content: center;
   margin: 0 auto 20px;
 }

 .logo i {
   font-size: 40px;
   color: white;
 }

 .app-title {
   color: white;
   font-size: 28px;
   font-weight: 300;
   margin: 0;
   text-shadow: 0 2px 4px rgba(0, 0, 0, 0.3);
 }

 .form-group {
   margin-bottom: 20px;
 }

 .form-group label {
   color: white;
   font-weight: 400;
   margin-bottom: 8px;
   display: block;
 }

 .form-control {
   width: 100%;
   padding: 15px;
   border: none;
   border-radius: 10px;
   background: rgba(255, 255, 255, 0.2);
   color: white;
   font-size: 16px;
   transition: all 0.3s ease;
 }

 .form-control::placeholder {
   color: rgba(255, 255, 255, 0.7);
 }

 .form-control:focus {
   background: rgba(255, 255, 255, 0.3);
   box-shadow: 0 0 0 3px rgba(255, 255, 255, 0.1);
   outline: none;
 }

 .form-check {
   margin-bottom: 20px;
 }

 .form-check-label {
   color: white;
   font-weight: 400;
 }

 .btn-login {
   width: 100%;
   padding: 15px;
   border: none;
   border-radius: 10px;
   background: linear-gradient(135deg, #2196f3 0%, #21cbf3 100%);
   color: white;
   font-size: 16px;
   font-weight: 600;
   cursor: pointer;
   transition: all 0.3s ease;
   margin-bottom: 20px;
 }

 .btn-login:hover {
   transform: translateY(-2px);
   box-shadow: 0 10px 20px rgba(33, 150, 243, 0.3);
 }

 .forgot-link {
   text-align: center;
 }

 .forgot-link a {
   color: white;
   text-decoration: none;
   font-weight: 400;
 }

 .forgot-link a:hover {
   text-decoration: underline;
 }
 </style>
 <div class="particles">
   <?php for($i=0; $i<50; $i++): ?>
   <div class="particle" style="left: <?= rand(0,100) ?>%; width: <?= rand(2,5) ?>px; height: <?= rand(2,5) ?>px; animation-delay: <?= rand(0,6) ?>s;"></div>
   <?php endfor; ?>
 </div>
 <div class="login-container">
   <div class="logo-section">
     <div class="logo">
       <i class="material-icons">school</i>
     </div>
     <h1 class="app-title">ABSENSIS V.1</h1>
   </div>
   <?= view('\App\Views\admin\_message_block') ?>
   <form action="<?= url_to('login') ?>" method="post">
     <?= csrf_field() ?>
     <div class="form-group">
       <label for="login">Email / Username</label>
       <?php if ($config->validFields === ['email']) : ?>
         <input type="email" class="form-control" name="login" id="login" placeholder="Enter your email" autofocus>
       <?php else : ?>
         <input type="text" class="form-control" name="login" id="login" placeholder="Enter username" autofocus>
       <?php endif; ?>
       <div class="invalid-feedback">
         <?= session('errors.login') ?>
       </div>
     </div>
     <div class="form-group">
       <label for="password">Password</label>
       <input type="password" class="form-control" name="password" id="password" placeholder="Enter your password">
       <div class="invalid-feedback">
         <?= session('errors.password') ?>
       </div>
     </div>
     <?php if ($config->allowRemembering) : ?>
       <div class="form-check">
         <input type="checkbox" name="remember" class="form-check-input" id="remember" <?php if (old('remember')) : ?> checked <?php endif ?>>
         <label class="form-check-label" for="remember">
           <?= lang('Auth.rememberMe') ?>
         </label>
       </div>
     <?php endif; ?>
     <button type="submit" class="btn-login"><?= lang('Auth.loginAction') ?></button>
     <?php if ($config->activeResetter) : ?>
       <div class="forgot-link">
         <a href="<?= url_to('forgot') ?>"><?= lang('Auth.forgotYourPassword') ?></a>
       </div>
     <?php endif; ?>
   </form>
 </div>
 <?= $this->endSection(); ?>
