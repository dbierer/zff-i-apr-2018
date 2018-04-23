<?php
namespace Market\Form;

use Zend\InputFilter\ {InputFilter,Input};
use Zend\Filter\ {Digits, StripTags, StringTrim, StringToLower, StringToUpper, Callback};
use Zend\Validator\ {InArray, StringLength, Regex};
use Zend\I18n\Validator\ {Alnum, ToFloat};

class PostFilter extends InputFilter
{

    public function __construct($categories, $expireDays)
    {

		// filter & validate by fields
		$category = new Input('category');
		$category->getFilterChain()
				 ->attachByName('StringToLower');
		$category->getValidatorChain()
				 ->attachByName('InArray', array('haystack' => $categories));

		$title = new Input('title');
		$titleRegex = new Regex(array('pattern' => '/^[a-zA-Z0-9 ]*$/'));
		$titleRegex->setMessage('Title should only contain numbers, letters or spaces!');
		$title->getValidatorChain()
			  ->attach($titleRegex)
			  ->attachByName('StringLength', array('min' => 1, 'max' => 128));

		$email = new Input('contact_email');
		$email->setAllowEmpty(TRUE);
		$email->getValidatorChain()
			  ->attachByName('EmailAddress');

		$this->add($category)
			 ->add($title)
			 ->add($email);

        // add StripTags + StringTrim to all
        $stripTags = new StripTags();
        $stringTrim = new StringTrim();
        foreach ($this->getInputs() as $input) {
            $input->getFilterChain()
                  ->attach($stripTags)
                  ->attach($stringTrim);
        }
    }
}
