<?php
//黑名单域名，即直接封杀主域名，效果就是只要是使用该域名及其下级所有域名的请求全部被阻挡，慎重使用

return array( 	'cnzz.com' => array('.cnzz.com'), 
				'mediav.com' => array('.mediav.com'),
				'msn.com' => array('.msn.com'),
				'baihe.com' => array('.baihe.com'),
				'jiayuan.com' => array('.jiayuan.com'),//世纪佳缘，嗯！没这需求
				'qbao.com'	=> array('.qbao.com'), //钱宝网
				'dftoutiao.com' => array('.dftoutiao.com'),
				'miaozhen.com' => array('miaozhen.com', '.miaozhen.com'),
				'rubiconproject.com' => array('.rubiconproject.com'),
				'adsame.com' => array('.adsame.com', 'adsame.com'),
				'hexun.com' => array('.hexun.com'),
				'2345.com' => array('.2345.com'),
				'51.la' => array('.51.la'),
				'778669.com' => array('.778669.com', '778669.com'), //恶意网站
				'ddns.name' => array('.ddns.name'),
				'7clink.com' => array('.7clink.com'),
				'88shu.cn' => array('.88shu.cn'),
				'51yes.com' => array('51yes.com', '.51yes.com'),
				'3393.com' => array('3393.com', '.3393.com'),
				'zedo.com' => array('zedo.com', '.zedo.com'),
				'admaster.com.cn' => array('admaster.com.cn', '.admaster.com.cn'),
				'adpush.cn' => array('adpush.cn', '.adpush.cn'),
				'adsage.com' => array('adsage.com', '.adsage.com'),
				'allyes.cn' => array('allyes.cn', '.allyes.cn'),
				'allyes.com' => array('allyes.com', '.allyes.com'),
				'baifendian.com' => array('.baifendian.com'),
				'banmamedia.com' => array('.banmamedia.com'),
				'behe.com' => array('.behe.com'),
				'dnset.com' => array('.dnset.com'),
				

				//'kankan.com' => array('.cpm.cm.kankan.com', '.float.kankan.com', '.stat.kankan.com'),
			);