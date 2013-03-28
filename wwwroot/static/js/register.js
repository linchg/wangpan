function getCookie(c_name) {
    if (document.cookie.length > 0) {
        c_start = document.cookie.indexOf(c_name + "=");
        if (c_start != -1) {
            c_start = c_start + c_name.length + 1;
            c_end = document.cookie.indexOf(";", c_start);
            if (c_end == -1) c_end = document.cookie.length;
            return unescape(document.cookie.substring(c_start, c_end));
        }
    }
    return "";
}
var hosturl = location.hostname.split('.');
var domain = "";
for (var i = 1; i < hosturl.length; i++) {
    domain += '.' + hosturl[i];
}
try {
    var LocString = new String(window.document.location.href);
    function GetQueryString(str) {
        var rs = new RegExp("(^|)" + str + "=([^\&]*)(\&|$)", "gi").exec(LocString),
        tmp;
        if (tmp = rs) return tmp[2];
        return null;
    }
    var spname = GetQueryString("sp");
    if (spname != null) {
        document.cookie = "spname = " + spname + "; path = /; domain = " + domain.slice(1) + ";";
    }
} catch(e) {}
function getCookies(sName) {
    var aCookie = document.cookie.split("; ");
    for (var i = 0; i < aCookie.length; i++) {
        var aCrumb = aCookie[i].split("=");
        if (sName == aCrumb[0]) return unescape(aCrumb[1]);
    }
    return "";
}
var checkemail = false;
var checkuser = false;
var checkname = false;
function chkUsername() {
    var username = $.trim($("#username").val());
    if (username == "") {
        return 0;
    } else if (fLen(username) < 5 || fLen(username) > 15) {
        return - 1;
    } else if (!/^\w+$/.test(username)) {
        return - 2;
    }
    return 1;
}
$(function() {
    $("#username").blur(function() {
        var ret = chkUsername();
        var username = $.trim($("#username").val());
        $("#username").attr("class", "inp ipt-focus");
        if (ret == 0) {
            $("#uname_ico_err").hide();
            $("#uname_ico_ok").hide();
            $("#div_uname_err").show();
            $("#div_uname_err_info").html("·5~15个字符，包括字母、数字、下划线<br />·字母和数字开头，字母和数字结尾，不区分大小写");
        } else if (ret == -1) {
            $("#uname_ico_err").show();
            $("#uname_ico_ok").hide();
            $("#div_uname_err").show();
            $("#div_uname_err_info").html("合法长度为5-15个字符");
        } else if (ret == -2) {
            $("#uname_ico_err").show();
            $("#uname_ico_ok").hide();
            $("#div_uname_err").show();
            $("#div_uname_err_info").html("用户名只能包含_,英文字母,数字");
        } else {
            $.ajax({
                url: 'n_post.php',
                type: 'post',
                data: {
                    username: username,
                    type: 'username'
                },
                dataType: 'text',
                error: function() {
                    alert('查询用户名出错!');
                },
                success: function(result) {
                    if (result == '0') {
                        $("#username").attr("class", "inp ipt-normal");
                        $("#uname_ico_err").hide();
                        $("#uname_ico_ok").show();
                        $("#div_uname_err").hide();
                        $("#div_uname_err_info").html("");
                        checkuser = true;
                    } else {
                        $("#uname_ico_err").show();
                        $("#uname_ico_ok").hide();
                        $("#div_uname_err").show();
                        $("#div_uname_err_info").html("用户名已经存在");
                        $("#username").select();
                    }
                }
            });
        }
    });
    $("#petname").blur(function() {
        var petname = $.trim($("#petname").val());
        $("#petname").attr("class", "inp ipt-focus");
        if (petname == "") {
            $("#pname_ico_err").show();
            $("#pname_ico_ok").hide();
            $("#div_pname_err").show();
            $("#div_pname_err_info").html("昵称不能为空");
        } else {
            $.ajax({
                url: 'n_post.php',
                type: 'post',
                data: {
                    petname: petname,
                    type: 'petname'
                },
                dataType: 'text',
                error: function() {
                    alert('查询用户名出错!');
                },
                success: function(result) {
                    if (result == 'true') {
                        $("#petname").attr("class", "inp ipt-normal");
                        $("#pname_ico_err").hide();
                        $("#pname_ico_ok").show();
                        $("#div_pname_err").hide();
                        $("#div_pname_err_info").html("");
                        checkname = true;
                    } else {
                        $("#pname_ico_err").show();
                        $("#pname_ico_ok").hide();
                        $("#div_pname_err").show();
                        $("#div_pname_err_info").html("网盘名称已经存在");
                        $("#petname").select();
                    }
                }
            });
        }
    });
    $("#password").bind("focus",
    function() {
        ret = chkPassword();
        $("#password").attr("class", "inp ipt-focus");
        if (ret == 0) {
            if ($("#password_ico_err").is(":visible")) {
                $("#div_password_err").hide();
                $("#password_ico_err").hide();
            }
            $("#div_password_rule").show();
            $("#div_passwordconfirm_err").hide();
            $("#passwordconfirm").attr("class", "inp ipt-normal");
            $("#passwordconfirm").attr("value", "");
            $("#passwordconfirm_ico_ok").hide();
            $("#passwordconfirm_ico_err").hide();
        } else if (ret > 0) {
            chkPasswordStrong($("#password").val());
        }
        return false;
    });
    $("#password").bind("blur",
    function() {
        ret = chkPassword();
        if (ret > 0) {
            $("#password").attr("class", "inp ipt-normal");
            $("#password_ico_ok").show();
            $("#password_ico_err").hide();
            $("#div_password_rule").hide();
            $("#div_password_err").hide();
            $("#div_password_err_info").html("");
        } else {
            if (ret == 0) {
                $("#password").attr("class", "inp ipt-normal");
                $("#password_ico_ok").hide();
                $("#password_ico_err").hide();
                $("#div_password_rule").hide();
                $("#div_password_err").hide();
                $("#div_password_err_info").html("");
            } else if (ret == -1) {
                $("#password").attr("class", "inp ipt-error");
                $("#password_ico_ok").hide();
                $("#password_ico_err").show();
                $("#div_password_rule").hide();
                $("#div_password_err").show();
                $("#div_password_err_info").html("请输入6～16位字符的密码");
            }
        }
        return false;
    });
    $("#password").bind("keyup",
    function() {
        $("#passwordconfirm").attr("value", "");
        chkPasswordStrong($("#password").val());
        return false;
    });
    $("#passwordconfirm").bind("blur",
    function() {
        $("#passwordconfirm").attr("class", "inp ipt-normal");
        return chkPasswordconfirm();
    });
    $("#email").blur(function() {
        checkEmail();
    });
    $("#authcode").bind("blur",
    function() {
        ret = chkAuthcode();
        if (ret < 0) {
            $("#authcode_ico_ok").hide();
            $("#authcode_ico_err").show();
            $("#div_authcode_err").show();
            $("#div_authcode_err_info").html("验证码不能为空");
        } else if (ret == 0) {
            $("#authcode_ico_ok").hide();
            $("#authcode_ico_err").show();
            $("#div_authcode_err").show();
            $("#div_authcode_err_info").html("请正确填写验证码");
        } else {
            $("#authcode_ico_ok").show();
            $("#authcode_ico_err").hide();
            $("#div_authcode_err").hide();
        }
    });
});
function checkEmail() {
    $("#secanswer").attr("class", "inp ipt-normal");
    var email = $("#email").val();
    var myreg = /^([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+@([a-zA-Z0-9]+[_|\_|\.]?)*[a-zA-Z0-9]+\.[a-zA-Z]{2,3}$/;
    if (!myreg.test($("#email").val())) {
        $("#email_ico_ok").hide();
        $("#email_ico_err").show();
        $("#div_email_err").show();
        $("#div_email_err_info").html("邮箱格式不对");
        return false;
    }
    $.ajax({
        url: 'n_post.php',
        type: 'post',
        data: {
            email: email,
            type: 'email'
        },
        dataType: 'text',
        error: function() {
            alert('查询邮箱出错!');
        },
        success: function(result) {
            if (result == "0") {
                $("#email_ico_ok").show();
                $("#email_ico_err").hide();
                $("#div_email_err").hide();
                checkemail = true;
            } else {
                $("#email_ico_ok").hide();
                $("#email_ico_err").show();
                $("#div_email_err").show();
                $("#div_email_err_info").html("该邮箱已经存在，请使用另外的邮箱.");
            }
        }
    });
}
function doRegFormSubmit() {
    if ($("#servItems").attr("checked") != true) {
        alert("您还没有阅读服务条款!");
        return false;
    }
    ret = chkUsername();
    if (ret < 1) {
        $("#username").attr("class", "inp ipt-error");
        $("#uname_ico_err").show();
        $("#div_uname_rule").hide();
        $("#div_uname_err").show();
        if (ret == 0) {
            $("#div_uname_err_info").html("用户名不能为空");
            return false;
        } else if (ret == -1) {
            $("#div_uname_err_info").html("合法长度为5-15个字符");
            return false;
        } else if (ret == -2) {
            $("#div_uname_err_info").html("用户名只能包含_,英文字母,数字");
            return false;
        }
    }
    if (checkuser == false) {
        $("#username").attr("class", "inp ipt-error");
        $("#uname_ico_err").show();
        $("#div_uname_rule").hide();
        $("#div_uname_err").show();
        $("#div_uname_err_info").html("用户名已经存在");
        return false;
    }
    if (checkname == false) {
        $("#petname").attr("class", "inp ipt-error");
        $("#pname_ico_err").show();
        $("#div_pname_rule").hide();
        $("#div_pname_err").show();
        $("#div_pname_err_info").html("昵称不能为空");
        return false;
    }
    ret = chkPassword();
    if (ret < 1) {
        $("#password").attr("class", "inp ipt-error");
        $("#password_ico_ok").hide();
        $("#password_ico_err").show();
        $("#div_password_rule").hide();
        $("#div_password_err").show();
        $("#div_password_err_info").html("请输入6～20位字符的密码");
        return false;
    } else {
        if (!chkPasswordconfirm()) {
            $("#div_passwordconfirm_err").show();
            $("#passwordconfirm").attr("class", "inp ipt-error");
            $("#passwordconfirm_ico_ok").hide();
            $("#passwordconfirm_ico_err").show();
            return false;
        } else if ($.trim($("#password").val()) == $.trim($("#username").val())) {
            $("#password").attr("class", "inp ipt-error");
            $("#password_ico_ok").hide();
            $("#password_ico_err").show();
            $("#div_password_rule").hide();
            $("#div_password_err").show();
            $("#div_password_err_info").html("输入的密码不能与用户名一样");
            return false;
        }
    }
    ret = chkAuthcode();
    if (ret < 0) {
        $("#authcode").attr("class", "inp ipt-error");
        $("#authcode_ico_err").show();
        $("#div_authcode_err").show();
        $("#div_authcode_err_info").html("验证码不能为空");
        return false;
    } else if (ret == 0) {
        $("#authcode").attr("class", "inp ipt-error");
        $("#authcode_ico_err").show();
        $("#div_authcode_err").show();
        $("#div_authcode_err_info").html("请正确填写验证码");
        return false;
    } else {
        $.ajax({
            url: 'n_post.php',
            type: 'post',
            data: {
                code: $.trim($("#authcode").val()),
                type: 'code'
            },
            dataType: 'text',
            error: function() {
                alert('查询验证码出错!');
                return false;
            },
            success: function(result) {
                if (result == "0") {
                    $("#authcode").attr("class", "inp ipt-error");
                    $("#authcode_ico_err").show();
                    $("#div_authcode_err").show();
                    $("#div_authcode_err_info").html("验证码输入错误");
                    return false;
                } else {
                    $("#authcode_ico_ok").show();
                    $("#authcode_ico_err").hide();
                    $("#div_authcode_err").hide();
                    doRegokFormSubmit();
                }
            }
        });
    }
}
function doRegokFormSubmit() {
    var spname = "";
    var regip = "";
    var m_submit = "reg";
    spname = getCookie('spname');
    regip = getCookie('regip');
    if (checkemail == true) {
        $.ajax({
            url: 'n_post.php',
            type: 'post',
            data: {
                username: $.trim($("#username").val()),
                petname: $("#petname").val(),
                password1: $("#password").val(),
                password2: $("#passwordconfirm").val(),
                email: $("#email").val(),
                validate: $("#authcode").val(),
                spreadname: spname,
                newregip: regip,
                type: m_submit
            },
            dataType: 'text',
            error: function() {
                alert('用户注册失败,请稍候再试!');
            },
            success: function(result) {
                if (result == "true") {
                    location.href = 'http://' + location.hostname + '/n_member/';
                } else if (result == "err") {
                    alert('非法提交!');
                } else if (result == "rereg") {
                    alert('请不要重复注册!');
                } else if (result == "false") {
                    alert('注册失败!');
                } else {
                    $("#authcode").attr("class", "inp ipt-error");
                    $("#authcode_ico_err").show();
                    $("#div_authcode_err").show();
                    $("#div_authcode_err_info").html("请正确填写验证码");
                    $("#vcode_img").attr("src", "http://" + location.hostname + "/n_code.php?temp=" + (new Date().getTime().toString(36)));
                }
            }
        });
    } else {
        $("#email_ico_ok").hide();
        $("#email_ico_err").show();
        $("#div_email_err").show();
        $("#div_email_err_info").html("该邮箱已经存在，请使用另外的邮箱.");
        return false;
    }
}
function chkPassword() {
    password = $("#password").val();
    if (password == "") return 0;
    var len;
    var i;
    var isPassword = true;
    len = 0;
    for (i = 0; i < password.length; i++) {
        if (password.charCodeAt(i) > 255) isPassword = false;
    }
    if (!isPassword || password.length > 16 || password.length < 6) return - 1;
    return 1;
}
function chkPasswordStrong(me) {
    $("#div_passwordconfirm_err").hide();
    $("#passwordconfirm").attr("class", "inp ipt-normal");
    $("#passwordconfirm_ico_ok").hide();
    $("#passwordconfirm_ico_err").hide();
    $("#password_ico_ok").hide();
    $("#password_ico_err").hide();
    $("#div_password_err").hide();
    $("#div_password_err_info").html("");
    $("#password").attr("class", "inp ipt-normal");
    $("#div_password_rule").show();
    var csint = checkStrong(me);
    $("#div_passowrd_Strong").attr("class", "bar state" + csint);
}
function CharMode(iN) {
    if (iN >= 48 && iN <= 57) return 1;
    if (iN >= 65 && iN <= 90) return 2;
    if (iN >= 97 && iN <= 122) return 4;
    else return 8;
}
function chkPasswordconfirm() {
    var password = $("#password").val();
    var passwordconfirm = $("#passwordconfirm").val();
    if (password != passwordconfirm) {
        $("#div_passwordconfirm_err").show();
        $("#passwordconfirm").attr("class", "inp ipt-error");
        $("#passwordconfirm_ico_ok").hide();
        $("#passwordconfirm_ico_err").show();
        return false;
    } else if (passwordconfirm == '') {
        $("#div_passwordconfirm_err").hide();
        $("#passwordconfirm").attr("class", "inp ipt-normal");
        $("#passwordconfirm_ico_ok").hide();
        $("#passwordconfirm_ico_err").hide();
    } else {
        $("#div_passwordconfirm_err").hide();
        $("#passwordconfirm").attr("class", "inp ipt-normal");
        $("#passwordconfirm_ico_err").hide();
        if ($("#password_ico_err").is(":visible")) {
            $("#passwordconfirm_ico_ok").hide();
        } else $("#passwordconfirm_ico_ok").show();
    }
    return true;
}
function bitTotal(num) {
    modes = 0;
    for (i = 0; i < 4; i++) {
        if (num & 1) modes++;
        num >>>= 1;
    }
    return modes;
}
function checkStrong(sPW) {
    Modes = 0;
    for (i = 0; i < sPW.length; i++) {
        Modes |= CharMode(sPW.charCodeAt(i));
    }
    return bitTotal(Modes);
}
function fGetEvent(e) {
    var ev = e || window.event;
    if (!ev) {
        var aCaller = [];
        var c = fGetEvent.caller;
        while (c) {
            ev = c.arguments[0];
            if (ev && Event == ev.constructor) {
                break;
            }
            var b = false;
            for (var i = 0; i < aCaller.length; i++) {
                if (c == aCaller[i]) {
                    b = true;
                    break;
                }
            }
            if (b) {
                break;
            } else {
                aCaller.push(c);
            }
            c = c.caller;
        }
    }
    return ev;
}
function changeQuestion(me) {
    if (me.value == "cusproblem") {
        $("#tr_cusproblem").show();
    } else {
        $("#tr_cusproblem").hide();
        if (me.value != 0) $("#div_secproblem_err").hide();
    }
}
function chkCustomProblem() {
    var val = $.trim($("#cusproblem").val());
    if (fLen(val) == 0) {
        return 0;
    } else if (fLen(val) < 6) {
        return - 1;
    } else if (fLen(val) > 36) {
        return - 2;
    } else return 1;
}
function fLen(Obj) {
    var nCNLenth = 0;
    var nLenth = Obj.length;
    for (var i = 0; i < nLenth; i++) {
        if (Obj.charCodeAt(i) > 255) {
            nCNLenth += 2;
        } else {
            nCNLenth++;
        }
    }
    return nCNLenth;
}
function chkAuthcode() {
    authcode = $.trim($("#authcode").val());
    if (authcode == "") return - 1;
    if (authcode.length != 5) return 0;
    return 1;
}
