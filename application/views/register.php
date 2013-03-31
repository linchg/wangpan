<div id="maincontent2" style="margin:40px auto">
    <div class="sharp color1" style="width:100%;">
        <b class="b1"></b>
        <b class="b2"></b>
        <b class="b3"></b>
        <b class="b4"></b> 
        <div class="content" style="padding:0px 0px 0px 0px; height:100%; overflow:visible;position:relative;">
            <div style="position:absolute; right:20px; top:10px;">兴趣网盘，网赚新选择。</div>
            <br />

            <div class="title_child" style="margin-left:20px;">用户注册</div>
            <div id="reg"> 
                <form id="regform" action="<?php echo site_url('auth/do_register');?>" method="post">
                    <table width="100%" align="center" cellpadding="4" cellspacing="0">
                        <tr>
                            <td width="302" align="right">登陆帐号：</td>
                            <td width="243" align="left">
                                <input name="username" id="username" type="text" value="" size="35" maxlength="20"> 
                                *</td>
                            <td width="427" align="left"><div class="info">
                                    <b id="uname_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
                                    <b id="uname_ico_err" class="ico-error" title="错误" style="display:none"></b>
                                    <div id="div_uname_err" class="info-pop">
                                        <div class="arr"></div>
                                        <div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
                                        <div class="info-pop-c"><div class="cont" id="div_uname_err_info">·5~15个字符，包括字母、数字、下划线<br />·字母和数字开头，字母和数字结尾，不区分大小写<br /></div></div>
                                        <div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
                                    </div>
                            </div></td>  
                        </tr>

                        <tr>
                            <td width="302" align="right">帐号昵称：</td>
                            <td width="243" align="left">
                                <input name="nickname" id="nickname" type="text" value="" size="35" maxlength="20"> </td>
                            <td width="427" align="left"><div class="info">
                                    <b id="uname_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
                                    <b id="uname_ico_err" class="ico-error" title="错误" style="display:none"></b>
                                    <div id="div_uname_err" class="info-pop" style="display:none">
                                        <div class="arr"></div>
                                        <div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
                                        <div class="info-pop-c"><div class="cont" id="div_uname_err_info"><br /></div></div>
                                        <div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
                                    </div>
                            </div></td>  
                        </tr>


                        <tr>
                            <td align="right" >网盘名称：</td>
                            <td align="left"><input name="petname" type="text" id="petname" value="" size="35" maxlength="20" />
                                * </td>
                            <td align="left"><div class="info">
                                    <b id="pname_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
                                    <b id="pname_ico_err" class="ico-error" title="错误" style="display:none"></b>
                                    <div id="div_pname_err" class="info-pop"  style="display:none">
                                        <div class="arr"></div>
                                        <div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
                                        <div class="info-pop-c"><div class="cont" id="div_pname_err_info">·网盘的名称</div></div>
                                        <div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
                                    </div>
                            </div></td>
                        </tr>
                        <tr>
                            <td align="right" >登陆密码：</td>
                            <td align="left"><input name="password" type="password" id="password" value="" size="35" maxlength="20" />
                                * </td>
                            <td align="left"><div class="info">
                                    <b id="password_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
                                    <b id="password_ico_err" class="ico-error" title="错误" style="display:none"></b>
                                    <div id="div_password_rule" class="info-pop" style="display:none">
                                        <div class="arr"></div>
                                        <div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
                                        <div class="info-pop-c">
                                            <div class="cont">6～16个字符（字母、数字、特殊符号）,区分大小写<br />
                                                <div class="fle">密码强度：<span class="Cred">弱</span></div>
                                                <div class="psw-sinfo"><div id="div_passowrd_Strong" class="bar state0"></div></div>
                                                <span class="fle Cblue">强</span>
                                                <div class="clear"></div>
                                            </div>
                                        </div>
                                        <div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
                                    </div>
                                    <div id="div_password_err" class="info-pop I-error" style="display:none">
                                        <div class="arr"></div>
                                        <div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
                                        <div class="info-pop-c"><div class="cont" id="div_password_err_info"></div></div>
                                        <div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
                                    </div>
                            </div></td>
                        </tr>
                        <tr>
                            <td align="right" >确认密码：</td>
                            <td align="left"><input name="passwordconfirm" type="password" id="passwordconfirm" value="" size="35" maxlength="20" />
                                *</td>
                            <td align="left"><div class="info">
                                    <b id="passwordconfirm_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
                                    <b id="passwordconfirm_ico_err" class="ico-error" title="错误" style="display:none"></b>
                                    <div id="div_passwordconfirm_err" class="info-pop I-error" style="display:none">
                                        <div class="arr"></div>
                                        <div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
                                        <div class="info-pop-c"><div class="cont" id="div_passwordconfirm_err_info">两次输入密码不一致</div></div>
                                        <div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
                                    </div>
                            </div></td>
                        </tr>
                        <tr>
                            <td align="right" >邮箱地址：</td>
                            <td align="left"><input name="email" autocomplete="off" type="text" id="email" value="" size="35" />
                                *
                                <div id="initEmails" style="display:none;">
                                    <span class="emailTitle">请选择邮箱类型</span>
                                    <ul id="emailList">
                                    </ul>
                                </div>
                            </td>
                            <td align="left"><div class="info">
                                    <b id="email_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
                                    <b id="email_ico_err" class="ico-error" title="错误" style="display:none"></b>
                                    <div id="div_email_err" class="info-pop I-error">
                                        <div class="arr"></div>
                                        <div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
                                        <div class="info-pop-c"><div class="cont" id="div_email_err_info">邮箱地址，需邮件认证！请认真填写。</div></div>
                                        <div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
                                    </div>
                            </div></td>
                        </tr>
                        <tr>
                            <td align="right" >&nbsp;</td>
                            <td align="left"><img src="/captcha/create?time=<?php echo time()?>" name="vcode_img" class="" id="vcode_img">&nbsp;&nbsp;<a href="#" onClick="$('#vcode_img').attr('src','/captcha/create?time='+(new Date().getTime()));return false;">看不清楚，换一张</a></td>
                            <td align="left">&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="right" >验证码：</td>
                            <td align="left"><input name="authcode" type="text" id="authcode" value="" size="10" /> 
                                *</td>
                            <td align="left"><div class="info">
                                    <b id="authcode_ico_ok" class="ico-ok" title="正确" style="display:none"></b>
                                    <b id="authcode_ico_err" class="ico-error" title="错误" style="display:none"></b> 
                                    <div id="div_authcode_err" class="info-pop I-error" style="display:none">
                                        <div class="arr"></div>
                                        <div class="info-pop-t"><b class="cr-l"></b><b class="cr-r"></b></div>
                                        <div class="info-pop-c"><div id="div_authcode_err_info" class="cont"></div></div>
                                        <div class="info-pop-b"><b class="cr-l"></b><b class="cr-r"></b></div>
                                    </div>
                            </div></td>
                        </tr>
                        <tr>
                            <td align="right" ><input name="servitems" type="checkbox" id="servitems" style="border:0px;" checked /></td>
                            <td>
                                我已阅读并完全同意 <b><a href="/index/argreement" target=_blank>注册协议</a></b>
                            </td>
                            <td>&nbsp;</td>
                        </tr>
                        <tr>
                            <td align="center" >&nbsp;</td>
                            <td class="Cred">注：支付信息在第一次提现时设置。</td>
                            <td align="center" >&nbsp;</td>
                        </tr>
                        <tr>
                            <td height="100" align="center" >&nbsp;</td>
                            <td height="100" ><input type="button" onClick="this.blur();doRegFormSubmit();" name="button" id="button" value="确定注册" class="loginbutton" style="border:0px; width:184px; height:53px; font-size:22px; color:#FFF;background-image: url(<?php echo static_url('static/images/menu_reg.jpg')?>);"/></td>
                            <td height="100" align="center" >&nbsp;</td>
                        </tr>
                    </table>
            </form></div>
        </div>
        <b class="b5"></b><b class="b6"></b><b class="b7"></b><b class="b8"></b>    
    </div>
    <div class="clear"></div>
</div>

