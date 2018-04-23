<?php
namespace Market\Form;
use Zend\Form\{Form, Element};
use Zend\Captcha\Image as ImageCaptcha;

class PostForm extends Form
{
    public function __construct($categories, $expireDays, $captchaOptions)
    {
		parent::__construct('post-form');
        $this->setAttribute('method', 'post');

        $category = new Element\Select('category');
        $category->setLabel('Category ')
            ->setAttribute('title', 'Please select a category')
            ->setValueOptions(array_combine($categories,$categories))
            ->setLabelAttributes(['style' => 'display: block']);

        $title = new Element\Text('title');
        $title->setLabel('Title ')
            ->setAttribute('placeholder', 'Enter posting title')
            ->setLabelAttributes(['style'=>'display:block']);

        $email = new Element\Email('contact_email');
        $email->setLabel('Contact Email ')
            ->setAttribute('title', 'Enter the email address of the person to contact for this item')
            ->setAttribute('size', 40)
            ->setAttribute('maxlength', 255)
            ->setLabelAttributes(['style'=>'display:block']);

        $captcha = new Element\Captcha('captcha');
        $captchaAdapter = new ImageCaptcha();
        $captchaAdapter->setWordlen(4)
            ->setOptions($captchaOptions);
        $captcha->setCaptcha($captchaAdapter)
            ->setLabel('Help us to prevent SPAM!')
            ->setAttribute('class', 'captchaStyle')
            ->setAttribute('title', 'Help to prevent SPAM');

        $submit = new Element\Submit('submit');
        $submit->setAttribute('value', 'Post');

        $this->add($category)
            ->add($title)
            ->add($email)
            ->add($captcha)
            ->add($submit);
        return $this;
    }

}
