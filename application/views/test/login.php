<form id="form1" name="form1" method="post" action="<?php echo site_url('auth/login');?>" target="_top">
    <div class="userlogin2">
        <ul>
            <li>
            <input name="username" type="text" class="input_s" id="s_name" value="帐号" maxlength="20"/>
            </li>
            <li style="position:relative">
            <div class="PwdStr">密码</div>
            <input name="password" type="password" class="input_s" id="s_password" value="" maxlength="20"/>
            </li>
            <!--
            <li>
            <input name="captcha" type="text" class="input_c" id="s_code" value="验证码" maxlength="5"/>
            <img src="/captcha/create?v=<?php echo time();?>" name="vcode_img" align="absmiddle" class="" id="vcode_img">&nbsp;&nbsp;<a href="#" onClick="$('#vcode_img').attr('src','/captcha/create?t='+(new Date().getTime()));return false;">换一个</a>
            </li>
-->
            <li>
            <input name="http_login" type="hidden" id="type" value="user">
            <input name="submit" type="submit">
            </li>
        </ul>
    </div>
</form>
