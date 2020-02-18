<?php
/*
* 2007-2016 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2016 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/
if (!defined('_PS_VERSION_')) {
    exit;
}
class Viatelease extends PaymentModule
{
    protected $_html = '';
    protected $_bossName;
    protected $_bossFirstName;
    protected $_mail;
    protected $_phoneNumber;
    protected  $_piVerso;
    protected $_piRecto;
    protected $_kBis;
    protected $_physicalAddress;
    protected $_balanceSheet;
    protected $_dateBusinessCreation;
    protected $_bankIdentityNumber;
    protected $_guaranteeDuration;
    protected $_productModel;
    protected $_locationDuration;
    protected $_sample;
    protected $fields_form;


    public function __construct()
    {
        $this->name = 'viatelease';
        $this->tab = 'payment';
        $this->version = '0.0.1';
        $this->author = 'CFM';
        $this->need_instance = 0;
        $this->context = Context::getContext();
        $this->ps_versions_compliancy = [
            'min' => '1.6',
            'max' => '1.7'
        ];
        $this->bootstrap = true;
        parent::__construct();
        $this->displayName = $this->l('Viatelease');
        $this->description = $this->l('Order With form location ');
        $this->confirmUninstall = $this->l('Are you sure you want to uninstall this module ?');
    }

    public function install()
    {
        return parent::install() && $this->registerHook('payment');
    }

    public function uninstall()
    {
        if (
            !parent::uninstall() ||
            !Configuration::deleteByName('viatelease')
        ) {
            return false;
        }

        return true;
    }

    public function hookDisplayPayment($params)
    {
        return $this->display(__FILE__, 'viatelease.tpl');
    }
    public function initContent()
    {
        parent::initContent();
        $this->setTemplate('viatelease.tpl');
        $this->renderForm();
    }
    public function renderForm()
    {

        $this->fields_form = array(
            'tinymce' => true,
            'legend' => array(
                'title' => $this->l('viatelease'),
                'image' => 'logo.png'
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('adresse email:'),
                    'desc' => $this->l('Entrez une adresse mail valide'),
                    'name' => 'mail',
                    'required' => true,
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Numéro de télephone'),
                    'name' => 'phoneNumber',
                    'size' => 10,
                    'required' => true,
                    'lang' => true,
                    'hint' => $this->l('Invalid characters:') . ' <>;=#{}ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'
                ),
                array(
                    'type' =>'text',
                    'label' => $this->l('nom du gérant'),
                    'desc' => $this->l('Entrez le nom du gérant de la société'),
                    'name' => ('bossName'),
                    'required' => true,
                ),
                array(
                    'type' =>'text',
                    'label' => $this->l('entrez le prénom du gérant de la société'),
                    'name' => ('bossFirstName'),
                    'required' => true,
                ),
                array(
                    'type' => 'file',
                    'label' => $this->l("piece d'identité gérant recto"),
                    'name' => 'piRecto',
                    'id' => 'uploadedfile',
                    'display_image' => false,
                    'required' => true,
                    'desc' => $this->l("téleversez le recto de la pièce d'identité du gérant de la société")
                ),

                array(
                    'type' => 'file',
                    'label' => $this->l("piece d'identité gérant verso"),
                    'name' => 'piVerso',
                    'id' => 'uploadedfile',
                    'display_image' => false,
                    'required' => true,
                    'desc' => $this->l("téleversez le verso de la pièce d'identité du gérant de la société")
                ),
                array(
                    'type' => 'file',
                    'label' => $this->l("piece d'identité gérant verso"),
                    'name' => 'piVerso',
                    'id' => 'uploadedfile',
                    'display_image' => false,
                    'required' => true,
                    'desc' => $this->l("téleversez le verso de la pièce d'identité du gérant de la société")
                ),
                array(
                    'type' => 'file',
                    'label' => $this->l("piece d'identité gérant recto"),
                    'name' => 'piRecto',
                    'id' => 'uploadedfile',
                    'display_image' => false,
                    'required' => true,
                    'desc' => $this->l("téleversez le recto de la pièce d'identité du gérant de la société")
                )
            ),
        );
        $this->fields_form['submit'] = array(
            'title' => $this->l('   Save   '),
            'class' => 'button'

        );

        return parent::renderForm();

    }
}