var cacheEmails=['@sina.com','@sina.com.cn','@vip.sina.com','@163.com','@qq.com','@126.com','@yahoo.com','@yahoo.com.cn','@yahoo.cn','@hotmail.com','@gmail.com','@189.cn'];
var emailPre = '';
textSingleUtil = {
    showType: 3,
    prompterUser:[],
    handleKey:'this',
	effectId:'',
	overClass:'ys',
	outClass:'xs',
	popDomId:'initEmails',
	popInnerDomId:'emailList',
	regTag : false,
	add: function(obj)
	{
		var val = $(obj).html();
		$('#'+this.effectId).val(val);
		if(textSingleUtil.regTag)
		{
			//regCheck.checkAccount($('#mail').val());
			//regCheck.setInitialHint();
		}
		$("#"+this.popDomId).hide();
	},
    handleEvent : function(key, event) {
        if(key != '') {
            if(event.keyCode == 188 || event.keyCode == 13 || event.keyCode == 59) {
                if(this.showType == 3) {
                    if(event.keyCode == 13) {
                        var currentnum = this.getCurrentPrompterUser();
                        if(currentnum != -1) {
                            key = cacheEmails[this.prompterUser[currentnum]];
							if(this.parentKeyCode != 229) {
								textSingleUtil.add($('#'+this.effectId+currentnum));
								$("#"+this.popDomId).hide();
							}
                        }else{
                            $("#"+this.popDomId).hide();
                            var result = false;
                            this.prompterUser = [];
							key = this.trim(key);
							var keyLen = (key.split('@')).length-1;
							if((key.charAt(key.length-1) == '@' && keyLen == 1) || keyLen == 0)
							{
								if(keyLen == 1)
								{
									key = key.Substring(0,key.Length-1)
								}
								this.prompterUser = cacheEmails;
								this.append();
								if(textSingleUtil.regTag)
								{
									$("#"+this.popDomId).show();
									emailPre = key;
									this.initLi();
									result = true;
								}
								
							} else {
								$("#"+this.popDomId).hide();
								$("#"+this.popInnerDomId).empty();
							}
							
                            if(!result)
                            {
                                $("#"+this.popDomId).hide();
                            }
                        }
                    }
                }
            } else if(event.keyCode == 38 || event.keyCode == 40) {
            } else {
                if(this.showType == 3) {
                    var result = false;
					this.prompterUser = [];
					key = this.trim(key);
					var keyLen = (key.split('@')).length-1;
					if((key.charAt(key.length-1) == '@' && keyLen == 1) || keyLen == 0)
					{
						if(keyLen == 1)
						{
							key = key.substring(0,key.length-1)
						}
						this.prompterUser = cacheEmails;
						this.append();
						if(textSingleUtil.regTag)
						{
							$("#"+this.popDomId).show();
							$("#"+this.popInnerDomId).scrollTop(0);
							emailPre = key;
							this.initLi();
							result = true;
						}
						
					} else {
						$("#"+this.popDomId).hide();
						$("#"+this.popInnerDomId).empty();
					}
                }
            }
        } else if(this.showType != 3) {
            $("#"+this.popDomId).hide();
        } else {
            $("#"+this.popDomId).hide();
        }
    },
    trim:function(str) {
		if(str != undefined)
		{
			return str.replace(/\s|,|;/g, '');
		}
    },
    getCurrentPrompterUser:function() {
        var len = this.prompterUser.length;
        var selectnum = -1;
        if(len) {
            for(var i = 0; i < len; i++) {
                var obj = document.getElementById(this.effectId + i);
                if(obj != null && obj.className == this.overClass) {
                    selectnum = i;
                }
            }
        }
        return selectnum;
    },
    mouseOverPrompter:function(obj) {
        var len = this.prompterUser.length;
        if(len) {
            for(var i = 0; i < len; i++) {
                $('#'+this.effectId + i).attr('class',this.outClass);
            }
            obj.className = this.overClass;
        }
    },
	initLi : function()
	{
		var len = this.prompterUser.length;
        if(len) {
            for(var i = 0; i < len; i++) {
               $('#'+this.effectId+i).html(emailPre+this.prompterUser[i]);
            }
        }
	},
	append : function() {
        var liHTML = '';
		var _HTML = [];
        var len = this.prompterUser.length;
        if(len) {
            for(var i = 0; i < len; i++) {
               _HTML[i+1]  = '<li id="'+this.effectId+i+'" onclick="'+'textSingleUtil.add(this);" onmouseover="'+'textSingleUtil.mouseOverPrompter(this);">'+this.prompterUser[i]+'</li>';
            }
        }
		liHTML = _HTML.join('');
		$("#"+this.popInnerDomId).html(liHTML);
		var currentnum = this.getCurrentPrompterUser();
		if(currentnum != -1)
		{
			$('#'+this.effectId+currentnum).addClass(this.overClass);
		} else {
			$('#'+this.effectId+'0').attr('class',this.overClass);
		}
    },
    _init:function(obj){
		this.popDomId = obj.popDomId;
		this.popInnerDomId = obj.popInnerDomId;
		this.effectId = obj.effectId;
		this.overClass = obj.overClass;
		this.outClass = obj.outClass;
        var handle = $('#'+this.effectId) ;
		
		var pos = handle.position();
		pos.left = parseInt(pos.left , 10);
		var height = parseInt(handle.height() , 10);
		$('#'+this.popDomId).css({left:pos.left  , top:pos.top+height+10});		
        handle.change = function(event) {
            textSingleUtil.handleEvent(this.value, event);
        };
        handle.keyup(function(event){
            textSingleUtil.handleEvent(this.value, event);
        });
		
		$(document.body).bind('click',function(e) {
            if ( $(e.currentTarget).attr('id') != obj.popDomId ) {
                $("#"+obj.popDomId).hide();
            }
        });
			
        if(this.showType == 3) {
            handle.keydown(function(event){
                event = event ? event : window.event;
                textSingleUtil.parentKeyCode = event.keyCode;
				
                if(event.keyCode == 32)
                {
                    $("#"+obj.popDomId).hide();
                }
                else if(event.keyCode == 38 && $(this)[0].value != '' ){
                    if(!textSingleUtil.prompterUser.length) {
                        //doane(event);
                    }
                    var currentnum = textSingleUtil.getCurrentPrompterUser();
                    if(currentnum != -1) {
                        var nextnum = (currentnum == 0) ? (textSingleUtil.prompterUser.length-1) : currentnum - 1;	
                        var offset = 0;
                        offset = currentnum * obj.domHeight ;
                        //alert(offset);
                        if(offset > $("#"+obj.popInnerDomId).outerHeight())
                        {
                            $("#"+obj.popInnerDomId).scrollTop(offset -180);
                        }else
                        {
                            $("#"+obj.popInnerDomId).scrollTop(0)
                        }
                        if(currentnum == 0 )
                        {
                            $("#"+obj.popInnerDomId).scrollTop(textSingleUtil.prompterUser.length*obj.domHeight -180) ;
                        }
                        $('#'+obj.effectId + currentnum).attr('class',obj.outClass)
                        $('#'+obj.effectId + nextnum).attr('class',obj.overClass);
                    } else {
                        $('#'+obj.effectId+'0').attr('class',obj.overClass);
                    }
                }
                else if(event.keyCode == 40) {
                    if(!textSingleUtil.prompterUser.length) {
                        
                    }
                    var currentnum = textSingleUtil.getCurrentPrompterUser();
                    if(currentnum != -1) {
                        var nextnum = (currentnum == (textSingleUtil.prompterUser.length - 1)) ? 0 : currentnum + 1;
                        var offsetd = 0;
                        offsetd = (currentnum+2) * obj.domHeight ;
                        if(offsetd > $("#"+obj.popInnerDomId).outerHeight())
                        {
                            $("#"+obj.popInnerDomId).scrollTop(offsetd -180);
                        }else
                        {
                            $("#"+obj.popInnerDomId).scrollTop(0)
                        }if(currentnum ==textSingleUtil.prompterUser.length-1 )
                        {
                            $("#"+obj.popInnerDomId).scrollTop(0)
                        }
                        $('#'+obj.effectId + currentnum).attr('class',obj.outClass)
                        $('#'+obj.effectId + nextnum).attr('class',obj.overClass);
                    } else {
                        $('#'+obj.effectId+'0').attr('class',obj.overClass);
                    }
                } else if(event.keyCode == 13) {
					
                }
            });
        }
    }
}
