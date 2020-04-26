<div class="page-login-main animation-slide-right animation-duration-1">
    <div class="brand hidden-md-up">
        <img class="brand-img" src="<?php echo base_url();?>assets/images/logo-colored@2x.png" alt="...">
        <h3 class="brand-text font-size-40">PT LEITER INDONESIA</h3>
    </div>
    <h3 class="font-size-24">Sign In</h3>

    <form method="post" action="<?php echo base_url();?>login/welcome/auth">
        <div class="form-group">
        <label class="sr-only" for="inputEmail">Email</label>
        <input type="email" class="form-control" id="inputEmail" name="email" placeholder="Email">
        </div>
        <div class="form-group">
        <label class="sr-only" for="inputPassword">Password</label>
        <input type="password" class="form-control" id="inputPassword" name="password"
            placeholder="Password">
        </div>
        <div class="form-group clearfix">
        <div class="checkbox-custom checkbox-inline checkbox-primary float-left">
            <input type="checkbox" id="rememberMe" name="rememberMe">
        </div>
        <a class="float-right" href="forgot-password.html">Forgot password?</a>
        </div>
        <button type="submit" class="btn btn-primary btn-block">Sign in</button>
    </form>
</div>