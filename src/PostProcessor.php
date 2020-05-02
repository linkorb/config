<?php

namespace LinkORB\Config;

use Symfony\Component\ExpressionLanguage\ExpressionLanguage;
use RuntimeException;

class PostProcessor
{
    
    public function process(&$config, $parameters)
    {
        foreach ($config as $key => $value) {
            if (is_string($value)) {
                $config[$key] = $this->processString($value, $parameters);
            }
            if (is_array($value)) {
                $config[$key] = $this->process($value, $parameters);
            }
        }
        return $config;
    }

    private function processString($string, $parameters)
    {
        $language = new ExpressionLanguage();
        $language->register(
            'env',
            function ($str) {
                // This implementation is only needed if you want to compile
                // not needed when simply using the evaluator
                throw new RuntimeException("The 'env' method is not yet compilable.");
            },
            function ($arguments, $str, $required = false) {
                $res = getenv($str);
                if (!$res && $required) {
                    throw new RuntimeException("Required environment variable '$str' is not defined");
                }
                return $res;
            }
        );
        // Inject parameters for strings between % characters
        if ((substr($string, 0, 1) == '%') && (substr($string, -1, 1) == '%')) {
            // echo "Evaluating $string\n";
            $data = [];
            foreach ($parameters as $k=>$v) {
                $data[$k] = json_decode(json_encode($v), FALSE);
            }
            $string = trim($string, '%');
            $string = $language->evaluate($string, $data);
        }
        return $string;
    }
}
