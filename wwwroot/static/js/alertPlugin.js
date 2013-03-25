var the9 = {
	alert: function(msg, type) {
		var template = '';
		if(type == 1) {
			template = '<div class="common_change pop-uplayer1-fix">'+
			'<p class="common_p3"><strong>完成了</strong></p>'+
			'<div class="common_div">'+
				'<div>'+
					'<div class="common_div1"><span class="common_span2"></span></div>'+
					'<p class="pop-alert-msg">'+msg+'</p>'+
				'</div>'+
				'<div style="clear:both;"></div>'+
				'<div class="pop-btn">'+
					'<a href="javascript:the9.close();" class="btn_a">'+
						'<span class="l_span_g">'+
							'<span class="r_span_g alertmsg_span">关闭</span>'+
						'</span>'+
					'</a>'+
				'</div>'+
			'</div>'+
			'<a class="off-fix n_close_btn" href="javascript:the9.close();"></a>'+
			'<div style="clear:both;"></div>'+
		'</div>';
		} else {
			template = '<div class="common_change pop-uplayer1-fix">'+
				'<p class="common_p1"><strong>出错啦</strong></p>'+
				'<div class="common_div">'+
					'<div>'+
						'<div class="common_div1"><span class="common_span1"></span></div>'+
						'<p class="pop-alert-msg">'+msg+'</p>'+
					'</div>'+
					'<div style="clear:both;"></div>'+
					'<div class="pop-btn">'+
						'<a href="javascript:the9.close();" class="btn_a">'+
							'<span class="l_span">'+
								'<span class="r_span alertmsg_span">关闭</span>'+
							'</span>'+
						'</a>'+
					'</div>'+
				'</div>'+
				'<a class="off-fix n_close_btn" href="javascript:the9.close();"></a>'+
				'<div style="clear:both;"></div>'+
			'</div>';
		}
		$.blockUI({
			message: template,
			css: {
				top: '28%',
				width: '350px',
				border: 'none',
				backgroundColor: '#000',
				'border-radius': '10px',
				'-webkit-border-radius': '10px',
				'-moz-border-radius': '10px',
				border: '0px',
				cursor: 'default'
			},
			overlayCSS: {
				cursor: 'default'
			},
			fadeIn:  150,
			fadeOut: 150
		});
	},
	close: function() {
		$.unblockUI({fadeOut: 150});
	}
};