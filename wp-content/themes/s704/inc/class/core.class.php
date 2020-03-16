<?php
//******
?>
<?php
add_action("csf__caozhuti_options_save_after", "ripro_options_save_after");
add_action("wp_ajax_ripro_ajax_check", "ripro_ajax_check");
add_action("wp_ajax_nopriv_ripro_ajax_check", "ripro_ajax_check");
class setupDb 
{
	public function setupRefLog() 
	{
		global $wpdb;
		global $ref_log_table_name;
		if ($wpdb->get_var("SHOW TABLES LIKE '" . $ref_log_table_name . "'") != $ref_log_table_name) 
		{
			$sql = " CREATE TABLE `" . $ref_log_table_name . ("` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `money` double(10,2) DEFAULT NULL COMMENT '提现金额',\r\n                  `create_time` int(11) DEFAULT '0' COMMENT '申请时间',\r\n                  `up_time` int(11) DEFAULT '0' COMMENT '审核时间',\r\n                  `status` tinyint(3) DEFAULT '0' COMMENT '状态；0 审核中；1已打款；-1失效',\r\n                  `note` varchar(255) DEFAULT NULL COMMENT '说明备注',\r\n                  PRIMARY KEY (`id`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=") . DB_CHARSET . (" COMMENT='提现记录表';");
			require_once (ABSPATH . ("wp-admin/includes/upgrade.php"));
			dbDelta($sql);
		}
	}
	public function setupOrder() 
	{
		global $wpdb;
		global $order_table_name;
		if ($wpdb->get_var("SHOW TABLES LIKE '" . $order_table_name . "'") != $order_table_name) 
		{
			$sql = " CREATE TABLE `" . $order_table_name . ("` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `order_trade_no` varchar(50) DEFAULT NULL COMMENT '本地订单号',\r\n                  `order_price` double(10,2) DEFAULT NULL COMMENT '订单价格',\r\n                  `order_type` enum('charge','other') NOT NULL DEFAULT 'charge' COMMENT '充值 其他',\r\n                  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',\r\n                  `pay_type` tinyint(3) DEFAULT '0' COMMENT '支付类型；0无；1支付宝；2微信',\r\n                  `pay_time` int(11) DEFAULT '0' COMMENT '支付时间',\r\n                  `pay_trade_no` varchar(50) DEFAULT NULL COMMENT '商户订单号',\r\n                  `status` tinyint(3) DEFAULT '0' COMMENT '状态；0 未支付；1已支付；-1失效',\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `order_trade_no_index` (`order_trade_no`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=") . DB_CHARSET . (" COMMENT='在线充值订单表';");
			require_once (ABSPATH . ("wp-admin/includes/upgrade.php"));
			dbDelta($sql);
		}
	}
	public function setupPaylog() 
	{
		global $wpdb;
		global $paylog_table_name;
		if ($wpdb->get_var("SHOW TABLES LIKE '" . $paylog_table_name . "'") != $paylog_table_name) 
		{
			$sql = " CREATE TABLE `" . $paylog_table_name . ("` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `post_id` int(11) DEFAULT NULL COMMENT '关联文章ID',\r\n                  `order_trade_no` varchar(50) DEFAULT NULL COMMENT '本地订单号',\r\n                  `order_price` double(10,2) DEFAULT NULL COMMENT '文章价格',\r\n                  `order_amount` double(10,2) DEFAULT NULL COMMENT '实际扣除金额',\r\n                  `order_type` enum('post','other') NOT NULL DEFAULT 'post' COMMENT '文章资源 其他',\r\n                  `order_sale` float(2,1) DEFAULT '0.0' COMMENT 'VIP折扣',\r\n                  `create_time` int(11) DEFAULT '0' COMMENT '创建时间',\r\n                  `pay_type` tinyint(3) DEFAULT '0' COMMENT '支付类型；0无；1余额；2其他',\r\n                  `pay_time` int(11) DEFAULT '0' COMMENT '支付时间',\r\n                  `status` tinyint(3) DEFAULT '0' COMMENT '状态；0 无；1已购买；-1失效',\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `post_id_index` (`post_id`),\r\n                  KEY `user_id_index` (`user_id`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=") . DB_CHARSET . (" COMMENT='文章资源购买表';");
			require_once (ABSPATH . ("wp-admin/includes/upgrade.php"));
			dbDelta($sql);
		}
	}
	public function setupCoupon() 
	{
		global $wpdb;
		global $coupon_table_name;
		if ($wpdb->get_var("SHOW TABLES LIKE '" . $coupon_table_name . "'") != $coupon_table_name) 
		{
			$sql = " CREATE TABLE `" . $coupon_table_name . ("` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `code` varchar(32) CHARACTER SET utf8mb4 DEFAULT NULL COMMENT '优惠码',\r\n                  `code_type` tinyint(3) NOT NULL DEFAULT '0' COMMENT '0 无 1 直减 2折扣',\r\n                  `create_time` int(11) NOT NULL DEFAULT '0' COMMENT '创建时间',\r\n                  `end_time` int(11) DEFAULT '0' COMMENT '到期时间',\r\n                  `apply_time` int(11) DEFAULT '0' COMMENT '使用时间',\r\n                  `status` tinyint(3) NOT NULL DEFAULT '0' COMMENT '状态：0未使用 1已使用',\r\n                  `sale_money` double(10,2) DEFAULT '0.00' COMMENT '优惠金额',\r\n                  `sale_float` float(2,1) DEFAULT '0.0' COMMENT '折扣',\r\n                  PRIMARY KEY (`id`),\r\n                  KEY `code_index` (`code`) COMMENT '优惠码索引'\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=") . DB_CHARSET . (" COMMENT='优惠券';");
			require_once (ABSPATH . ("wp-admin/includes/upgrade.php"));
			dbDelta($sql);
		}
	}
	public function setupBalanceLog() 
	{
		global $wpdb;
		global $balance_log_table_name;
		if ($wpdb->get_var("SHOW TABLES LIKE '" . $balance_log_table_name . "'") != $balance_log_table_name) 
		{
			$sql = " CREATE TABLE `" . $balance_log_table_name . ("` (\r\n                  `id` int(11) NOT NULL AUTO_INCREMENT,\r\n                  `user_id` int(11) DEFAULT NULL COMMENT '用户id',\r\n                  `old` double(10,2) DEFAULT NULL COMMENT '原始余额',\r\n                  `apply` double(10,2) DEFAULT NULL COMMENT '操作金额',\r\n                  `new` double(10,2) DEFAULT NULL COMMENT '新余额',\r\n                  `type` enum('charge','post','cdk','other') NOT NULL DEFAULT 'charge' COMMENT '类型：充值 资源 卡密 其他',\r\n                  `time` int(11) DEFAULT '0' COMMENT '操作时间',\r\n                  `note` varchar(255) DEFAULT NULL COMMENT '说明备注',\r\n                  PRIMARY KEY (`id`)\r\n                ) ENGINE=MyISAM DEFAULT CHARSET=") . DB_CHARSET . (" COMMENT='消费记录表';");
			require_once (ABSPATH . ("wp-admin/includes/upgrade.php"));
			dbDelta($sql);
		}
	}
	public function install() 
	{
		$this->setupOrder();
		$this->setupCoupon();
		$this->setupPaylog();
		$this->setupBalanceLog();
		$this->setupRefLog();
	}
}
class ShopOrder 
{
	public function __construct() 
	{
	}
	public function add($user_id, $trade_no, $type, $price, $payMethod) 
	{
		global $wpdb;
		global $order_table_name;
		$params = array("user_id" => $user_id, "order_trade_no" => $trade_no, "order_type" => $type, "order_price" => $price, "create_time" => time(), "pay_type" => $payMethod);
		$insert = $wpdb->insert($order_table_name, $params, array("%d", "%s", "%s", "%s", "%s", "%d"));
		return $insert ? true : false;
	}
	public function get($out_trade_no) 
	{
		global $wpdb;
		global $order_table_name;
		$data = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $order_table_name . " WHERE order_trade_no = %s AND status = 0 ", $out_trade_no));
		return $data;
	}
	public function check($orderNum) 
	{
		global $wpdb;
		global $order_table_name;
		$isPay = 0;
		if (isset($orderNum)) 
		{
			$isPay = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $order_table_name . " WHERE order_trade_no = %s AND status = 1 ", $orderNum));
			return $isPay && (0 < $isPay);
		}
		return $isPay && (0 < $isPay);
	}
	public function update($orderNum, $payNum) 
	{
		global $wpdb;
		global $order_table_name;
		$time = time();
		$update = $wpdb->update($order_table_name, array("pay_trade_no" => $payNum, "pay_time" => $time, "status" => 1), array("order_trade_no" => $orderNum), array("%s", "%s", "%d"), array("%s"));
		return $update ? true : false;
	}
}
class PostPay 
{
	public $user_id;
	public $post_id;
	public function __construct($user_id, $post_id) 
	{
		$this->user_id = $user_id;
		$this->post_id = $post_id;
	}
	public function add($price, $sale) 
	{
		global $wpdb;
		global $paylog_table_name;
		$out_trade_no = date("ymdhis") . mt_rand(100, 999) . mt_rand(100, 999) . mt_rand(100, 999);
		if ($sale == 0) 
		{
			$amount = 0;
		}
		else if ($sale == 1) 
		{
			$amount = $price;
		}
		else 
		{
			if ((0 < $sale) && ($sale < 1)) 
			{
				$amount = sprintf("%0.2f", $price * $sale);
			}
			else 
			{
				$amount = $price;
			}
		}
		$params = array("user_id" => $this->user_id, "post_id" => $this->post_id, "order_trade_no" => $out_trade_no, "order_price" => $price, "order_amount" => $amount, "order_type" => "post", "order_sale" => $sale, "create_time" => time(), "pay_type" => 1);
		$insert = $wpdb->insert($paylog_table_name, $params, array("%d", "%d", "%s", "%s", "%s", "%s", "%s", "%s", "%d"));
		if ($insert) 
		{
			return $params;
		}
		else 
		{
			return false;
		}
	}
	public function update($orderNum) 
	{
		global $wpdb;
		global $paylog_table_name;
		$time = time();
		$update = $wpdb->update($paylog_table_name, array("pay_time" => $time, "status" => 1), array("order_trade_no" => $orderNum), array("%s", "%d"), array("%s"));
		return $update ? true : false;
	}
	public function isPayPost() 
	{
		global $wpdb;
		global $paylog_table_name;
		$isPay = 0;
		$isPay = $wpdb->get_var($wpdb->prepare("SELECT id FROM " . $paylog_table_name . " WHERE user_id = %d AND post_id = %d AND status = 1 ", $this->user_id, $this->post_id));
		return $isPay && (0 < $isPay);
	}
	public function get_pay_ids($user_id) 
	{
		global $wpdb;
		global $paylog_table_name;
		$sql = "SELECT post_id FROM " . $paylog_table_name . " WHERE 1=1 ";
		$sql .= ("AND user_id='" . $user_id . "' AND status =1 ");
		$sql .= "ORDER BY id DESC";
		$results = $wpdb->get_results($sql, "ARRAY_A");
		$_post_id = array();
		foreach ($results as $item ) 
		{
			array_push($_post_id, $item["post_id"]);
		}
		return $_post_id;
	}
}
class CaoCdk 
{
	public function addCdk($sale_money, $day, $num) 
	{
		global $wpdb;
		global $coupon_table_name;
		$i = 0;
		while ($i < $num) 
		{
			$create_time = time();
			$end_time = $create_time + ($day * 24 * 60 * 60);
			$params = array("code" => $this->str_code_rand($length = 12), "code_type" => 1, "create_time" => $create_time, "end_time" => $end_time, "apply_time" => 0, "status" => 0, "sale_money" => sprintf("%0.2f", $sale_money), "sale_float" => 1);
			$insCoupon = $wpdb->insert($coupon_table_name, $params, array("%s", "%d", "%s", "%s", "%s", "%s", "%s", "%s"));
			$i++;
		}
		return $i ? true : false;
	}
	public function checkCdk($code) 
	{
		global $wpdb;
		global $coupon_table_name;
		$sale_money = 0;
		if (isset($code)) 
		{
			$coupon = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $coupon_table_name . " WHERE code = %s ", $code));
			if ($coupon && ($coupon->status == 0) && (time() < ($coupon->end_time)) && ($coupon->apply_time == 0)) 
			{
				return $coupon->sale_money;
			}
		}
		return $sale_money;
	}
	public function updataCdk($code) 
	{
		global $wpdb;
		global $coupon_table_name;
		$update = $wpdb->update($coupon_table_name, array("apply_time" => time(), "status" => 1), array("code" => $code), array("%s", "%d"), array("%s"));
		return $update ? true : false;
	}
	public function str_code_rand($length = 12, $char = "0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ") 
	{
		if (!is_int($length) || ($length < 0)) 
		{
			return false;
		}
		$string = "";
		$i = $length;
		while (0 < $i) 
		{
			$string .= ($char[mt_rand(0, strlen($char) - 1)]);
			$i--;
		}
		return $string;
	}
}
class CaoUser 
{
	private $uid;
	public function __construct($uid) 
	{
		$this->uid = $uid;
	}
	public function user_status() 
	{
		$ban = get_user_meta($this->uid, "cao_banned", true);
		if ($ban) 
		{
			$reason = get_user_meta($this->uid, "cao_banned_reason", true);
			return array("banned" => true, "banned_reason" => strval($reason));
		}
		return array("banned" => false);
	}
	public function vip_end_time() 
	{
		$end_date = get_user_meta($this->uid, "cao_vip_end_time", true);
		if ($end_date) 
		{
			switch ($end_date) 
			{
				case "9999-09-09": return "终身";
				break;
				default: $time = strtotime($end_date);
				return date("Y-m-d", $time);
				break;
			}
		}
		return "未开通";
	}
	public function vip_status() 
	{
		$vip_type = get_user_meta($this->uid, "cao_user_type", true);
		$vip_end_date = get_user_meta($this->uid, "cao_vip_end_time", true);
		$this_time = time();
		$end_time = strtotime($vip_end_date);
		if (($vip_type == "vip") && ($vip_end_date == ("9999-09-09"))) 
		{
			return true;
		}
		if (($vip_type == "vip") && ($this_time < $end_time)) 
		{
			return true;
		}
		return false;
	}
	public function update_vip_pay($days) 
	{
		if (empty($days) && ($days < 0)) 
		{
			return false;
		}
		$days = (int) $days;
		$vip_end_date = get_user_meta($this->uid, "cao_vip_end_time", true);
		$the_time = time();
		$end_time = strtotime($vip_end_date);
		if ($the_time < $end_time) 
		{
			$new_end_time = $end_time + ($days * 24 * 3600);
		}
		else 
		{
			$new_end_time = $the_time + ($days * 24 * 3600);
		}
		$new_user_type = "vip";
		if ($days == 9999) 
		{
			$nwe_end_data = "9999-09-09";
		}
		else 
		{
			$nwe_end_data = date("Y-m-d", $new_end_time);
		}
		update_user_meta($this->uid, "cao_vip_end_time", $nwe_end_data);
		update_user_meta($this->uid, "cao_user_type", $new_user_type);
		return true;
	}
	public function vip_name() 
	{
		$site_no_vip_name = _cao("site_no_vip_name");
		$site_vip_name = _cao("site_vip_name");
		$vip_type = get_user_meta($this->uid, "cao_user_type", true);
		if ($vip_type && ($vip_type == "vip")) 
		{
			return $site_vip_name;
		}
		return $site_no_vip_name;
	}
	public function get_balance() 
	{
		return sprintf("%0.2f", get_user_meta($this->uid, "cao_balance", true));
	}
	public function get_consumed_balance() 
	{
		return sprintf("%0.2f", get_user_meta($this->uid, "cao_consumed_balance", true));
	}
	public function update_balance($amount = 0) 
	{
		$before_balances = $this->get_balance();
		if (0 < $amount) 
		{
			update_user_meta($this->uid, "cao_balance", sprintf("%0.2f", $before_balances + $amount));
		}
		else 
		{
			if ($amount < 0) 
			{
				if (($before_balances + $amount) < 0) 
				{
					return false;
				}
				$before_consumed = get_user_meta($this->uid, "cao_consumed_balance", true);
				update_user_meta($this->uid, "cao_consumed_balance", sprintf("%0.2f", $before_consumed - $amount));
				update_user_meta($this->uid, "cao_balance", sprintf("%0.2f", $before_balances + $amount));
			}
		}
		return true;
	}
}
class Caolog 
{
	public function addlog($user_id, $old, $apply, $new, $type, $note) 
	{
		global $wpdb;
		global $balance_log_table_name;
		$create_time = time();
		$params = array("user_id" => $user_id, "old" => $old, "apply" => $apply, "new" => $new, "type" => $type, "time" => $create_time, "note" => $note);
		$ins = $wpdb->insert($balance_log_table_name, $params, array("%d", "%s", "%s", "%s", "%s", "%s", "%s"));
		return $ins ? true : false;
	}
}
class Reflog 
{
	private $uid;
	public function __construct($uid) 
	{
		$this->uid = $uid;
	}
	public function addlog($money, $note) 
	{
		global $wpdb;
		global $ref_log_table_name;
		$money = (int) $money;
		$create_time = time();
		$params = array("user_id" => $this->uid, "money" => $money, "create_time" => $create_time, "note" => $note);
		$ins = $wpdb->insert($ref_log_table_name, $params, array("%d", "%s", "%s", "%s"));
		return $ins ? true : false;
	}
	public function updatelog($id, $status = 0) 
	{
		global $wpdb;
		global $ref_log_table_name;
		$this_log = $wpdb->get_row($wpdb->prepare("SELECT * FROM " . $ref_log_table_name . " WHERE id = %d ", $id));
		if (!$this_log) 
		{
			return false;
		}
		$update = $wpdb->update($ref_log_table_name, array("up_time" => time(), "status" => $status), array("id" => $id), array("%s", "%d"), array("%d"));
		return $update ? true : false;
	}
	public function get_ref_num() 
	{
		global $wpdb;
		global $ref_log_table_name;
		$ref_num = $wpdb->get_var($wpdb->prepare("SELECT COUNT(user_id) FROM " . $wpdb->usermeta . " WHERE meta_key=%s AND meta_value=%s", "cao_ref_from", $this->uid));
		return $_num = ($ref_num ? (int) $ref_num : 0);
	}
	public function get_total_bonus() 
	{
		return sprintf("%0.2f", get_user_meta($this->uid, "cao_total_bonus", true));
	}
	public function get_ke_bonus() 
	{
		global $wpdb;
		global $ref_log_table_name;
		$get_total_bonus = $this->get_total_bonus();
		$get_ing_bonus = $this->get_ing_bonus();
		$get_yi_bonus = $this->get_yi_bonus();
		return sprintf("%0.2f", $get_total_bonus - $get_ing_bonus - $get_yi_bonus);
	}
	public function get_ing_bonus() 
	{
		global $wpdb;
		global $ref_log_table_name;
		$sqls = $wpdb->get_var($wpdb->prepare("SELECT SUM(money) FROM " . $ref_log_table_name . " WHERE user_id=%d AND status=0", $this->uid));
		return sprintf("%0.2f", $sqls);
	}
	public function get_yi_bonus() 
	{
		global $wpdb;
		global $ref_log_table_name;
		$sqls = $wpdb->get_var($wpdb->prepare("SELECT SUM(money) FROM " . $ref_log_table_name . " WHERE user_id=%d AND status=1", $this->uid));
		return sprintf("%0.2f", $sqls);
	}
	public function add_total_bonus($amount) 
	{
		$amount = sprintf("%0.2f", $amount);
		$get_total_bonus = $this->get_total_bonus();
		if (0 < $amount) 
		{
			update_user_meta($this->uid, "cao_total_bonus", sprintf("%0.2f", $get_total_bonus + $amount));
		}
		else 
		{
			return false;
		}
		return true;
	}
}
function ripro_options_save_after() 
{
	$token = _the_theme_name() . _cao("ripro_vip_id", "");
	update_option($token, $token);
}

?>