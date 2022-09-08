<?php

namespace Classes;

class Validation
{
    public $patterns = array(
        'uri'           => '[A-Za-z0-9-\/_?&=]+',
        'url'           => '[A-Za-z0-9-:.\/_?&=#]+',
        'alpha'         => '[\p{L}]+',
        'words'         => '[\p{L}\s]+',
        'alphanum'      => '[\p{L}0-9]+',
        'int'           => '[0-9]+',
        'float'         => '[0-9\.,]+',
        'tel'           => '[0-9+\s()-]+',
        'text'          => '[\p{L}0-9\s-.,;:!"%&()?+\'°#\/@]+',
        'file'          => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+\.[A-Za-z0-9]{2,4}',
        'folder'        => '[\p{L}\s0-9-_!%&()=\[\]#@,.;+]+',
        'address'       => '[\p{L}0-9\s.,()°-]+',
        'date_dmy'      => '[0-9]{1,2}\-[0-9]{1,2}\-[0-9]{4}',
        'date_ymd'      => '[0-9]{4}\-[0-9]{1,2}\-[0-9]{1,2}',
        'email'         => '[a-zA-Z0-9_.-]+@[a-zA-Z0-9-]+.[a-zA-Z0-9-.]+[.][a-z-A-Z]+'
    );

    protected $value = null;
    protected $name = null;
    protected $file = null;

    public $errors = array();
    public $object = array();

    public function name($name) {
        $this->name = $name;

        if(!empty($_POST[$name])) {
            $this->value = $_POST[$name];
            $this->object[$this->name] = $this->value;
        } else {
            $this->value = '';
            $this->object[$this->name] = $this->value;
        }

        return $this;
    }

    public function value($value) {
        $this->value = $value;
        $this->object[$this->name] = $this->value;

        return $this;
    }

    public function file($value) {
        $this->file = $value;
        return $this;
    }

    public function return() {
        return $this->value;
    }

    public function pattern($name) {
        if($name == 'array') {
            if(!is_array($this->value)) {
                $this->errors[$this->name][] = 'Field format '.str_replace('_', ' ', $this->name).' invalid.';
            }
        } else {
            $regex = '/^('.$this->patterns[$name].')$/u';
            if($this->value != '' && !preg_match($regex, $this->value)) {
                $this->errors[$this->name][] = 'Field format '.str_replace('_', ' ', $this->name).' invalid.';
            }
        }

        return $this;
    }

    public function customPattern($pattern) {
        $regex = '/^('.$pattern.')$/u';
        if($this->value != '' && !preg_match($regex, $this->value)) {
            $this->errors[$this->name][] = 'Field format '.str_replace('_', ' ', $this->name).' invalid.';
        }
        return $this;
    }

    public function required() {
        if((isset($this->file) && $this->file['error'] == 4) || ($this->value == '' || $this->value == null)) {
            $this->errors[$this->name][] = 'The '.str_replace('_', ' ', $this->name).' field is required.';
        }
        return $this;
    }

    public function min($length) {
        if(is_string($this->value)) {
            if(strlen($this->value) < $length) {
                $this->errors[$this->name][] = 'Field value '.str_replace('_', ' ', $this->name).' less than the minimum value';
            }
        } else {
            if($this->value < $length) {
                $this->errors[$this->name][] = 'Field value '.str_replace('_', ' ', $this->name).' less than the minimum value';
            }
        }
        return $this;
    }

    public function max($length) {
        if(is_string($this->value)) {
            if(strlen($this->value) > $length) {
                $this->errors[$this->name][] = 'Field value '.str_replace('_', ' ', $this->name).' higher than the maximum value';
            }
        } else {
            if($this->value > $length) {
                $this->errors[$this->name][] = 'Field value '.str_replace('_', ' ', $this->name).' higher than the maximum value';
            }
        }
        return $this;
    }

    public function equal($value) {
        if($this->value != $value) {
            $this->errors[$this->name][] = 'Field value '.str_replace('_', ' ', $this->name).' not matching.';
        }
        return $this;
    }

    public function maxSize($size) {
        if($this->file['error'] != 4 && $this->file['size'] > $size) {
            $this->errors[$this->name][] = 'The file '.str_replace('_', ' ', $this->name).' exceeds the maximum size of '.number_format($size / 1048576, 2).' MB.';
        }
        return $this;
    }

    public function ext($extension) {
        if($this->file['error'] != 4 && pathinfo($this->file['name'], PATHINFO_EXTENSION) != $extension && strtoupper(pathinfo($this->file['name'], PATHINFO_EXTENSION)) != $extension) {
            $this->errors[$this->name][] = 'The file '.str_replace('_', ' ', $this->name).' is not a '.$extension.'.';
        }
        return $this;
    }

    public function purify($string) {
        return htmlspecialchars($string, ENT_QUOTES, 'UTF-8');
    }

    public function isSuccess() {
        if(empty($this->errors)) {
            return (object) $this->object;
        } else {
            http_response_code(400);
        }
    }

    public function getErrors() {
        if(!$this->isSuccess()) return $this->errors;
    }

    public function displayErrors() {
        $html = '<ul>';
            foreach ($this->getErrors() as $key => $value) {
                $html .= '<li>'.$key.'</li>';
            }
        $html .= '</ul>';

        return $html;
    }

    public function result($full = false) {
        if(!$this->isSuccess()) {
            if($full) {
                return $this->getErrors();
            } else {
                $result = array();
                foreach ($this->errors as $error => $values) {
                    foreach ($values as $value ) {
                        $result[] = $value;
                    }
                }

                return $result;
            }

            exit;
        } else {
            return true;
        }
    }

    public static function is_int($value) {
        if(filter_var($value, FILTER_VALIDATE_INT)) return true;
    }

    public static function is_float($value) {
        if(filter_var($value, FILTER_VALIDATE_FLOAT)) return true;
    }

    public static function is_alpha($value) {
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z]+$/")))) return true;
    }

    public static function is_alphanum($value) {
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[a-zA-Z0-9]+$/")))) return true;
    }

    public static function is_url($value) {
        if(filter_var($value, FILTER_VALIDATE_URL)) return true;
    }

    public static function is_uri($value) {
        if(filter_var($value, FILTER_VALIDATE_REGEXP, array('options' => array('regexp' => "/^[A-Za-z0-9-\/_]+$/")))) return true;
    }

    public static function is_bool($value) {
        if(is_bool(filter_var($value, FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE))) return true;
    }

    public static function is_email($value) {
        if(filter_var($value, FILTER_VALIDATE_EMAIL)) return true;
    }
}