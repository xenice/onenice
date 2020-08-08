<?php
/**
 * @name        xenice mail
 * @author      xenice <xenice@qq.com>
 * @version     1.0.0 2019-10-14
 * @link        http://www.xenice.com/
 * @package     xenice
 */
 
namespace xenice\mail;

use xenice\theme\Base;
use xenice\theme\Theme;

class Mail extends Base
{
    public function __construct()
    {
        take('enable_mail_service') && add_action('phpmailer_init', [$this, 'smtp']);
        if(is_admin()){
            Theme::bind('xenice_options_init', [$this,'set']);
            take('enable_mail_service') && Send::instance();
        }
    }
    
    public function set($options)
    {
        $defaults   = [];
        $defaults[] = [
            'id'=>'mail',
            'name'=> _t('Mail'),
            'title'=> _t('Mail Settings'),
            'fields'=>[
                [
                    'id'   => 'enable_mail_service',
                    'name' => _t('Mail Service'),
                    'label' => _t('Enable mail service'),
                    'type'  => 'checkbox',
                    'value' => true
                ],
                [
                    'id'   => 'mail_from_name',
                    'name' => _t('From Name'),
                    'type'  => 'text',
                    'value' => ''
                ],
                [
                    'id'   => 'mail_host',
                    'name' => _t('STMP Host'),
                    'type'  => 'text',
                    'value' => ''
                ],
                [
                    'id'   => 'mail_post',
                    'name' => _t('STMP Post'),
                    'type'  => 'number',
                    'value' => 465
                ],
                [
                    'id'   => 'mail_username',
                    'name' => _t('Mail Account'),
                    'type'  => 'text',
                    'value' => ''
                ],
                [
                    'id'   => 'mail_password',
                    'name' => _t('Mail Password'),
                    'type'  => 'text',
                    'value' => ''
                ],
                [
                    'id'   => 'mail_smtp_auth',
                    'name' => _t('SMTP Auth'),
                    'label' => _t('Enable SMTP Auth service'),
                    'type'  => 'checkbox',
                    'value' => true
                ],
                [
                    'id'   => 'mail_smtp_secure',
                    'name' => _t('SMTP Secure'),
                    'desc' => _t('Fill in ssl if SMTP Auth service is enabled, leave blank if not'),
                    'type'  => 'text',
                    'value' => 'ssl'
                ],
            ]
        ];
        return array_merge($options, $defaults);
    }
    
    /**
	 * Mail Smtp Settings
	 */
	public function smtp($phpmailer)
	{
		$phpmailer->IsSMTP();
		$mail_name = take('mail_from_name');
		$mail_host = take('mail_host');
		$mail_port = take('mail_port');
		$mail_smtpsecure = take('mail_smtp_secure');
		
		$phpmailer->FromName = $mail_name ?: 'xenice'; 
		$phpmailer->Host = $mail_host ?:'smtp.qq.com';
		$phpmailer->Port = $mail_port ?: '465';
		$phpmailer->Username = take('mail_username');
		$phpmailer->Password = take('mail_password');
		$phpmailer->From = take('mail_username');
		$phpmailer->SMTPAuth = take('mail_smtp_auth');
		$phpmailer->SMTPSecure = $mail_smtpsecure ?: 'ssl';
		add_filter('wp_mail_from_name', function ($old) {return $mail_name;});
	}
}