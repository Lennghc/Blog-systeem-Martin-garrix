<?php

/**
 * Routing
 *
 * Simple routing with callback.
 * (c) 2022, Robbie
 */

namespace Classes;

class Router {
    protected $routes = Array();
    protected $pathNotFound = null;
    protected $methodNotAllowed = null;
    protected $path = null;

    public function __construct($basepath = '/') {
        $this->path = $basepath;
    }

    public function post($expression, $function){
        $this->add($expression, $function, 'post');
    }

    public function get($expression, $function){
        $this->add($expression, $function);
    }

    public function patch($expression, $function){
        $this->add($expression, $function, 'patch');
    }

    public function delete($expression, $function){
        $this->add($expression, $function, 'delete');
    }

    public function put($expression, $function){
        $this->add($expression, $function, 'put');
    }

    private function add($expression, $function, $method = 'get'){
        array_push($this->routes,Array(
            'expression' => $expression,
            'function' => $function,
            'method' => $method
        ));
    }

    public function pathNotFound($function) {
        $this->pathNotFound = $function;
    }

    public function methodNotAllowed($function) {
        $this->methodNotAllowed = $function;
    }

    public function run() {
        // Parse current url
        $parsed_url = parse_url(filter_var($_SERVER['REQUEST_URI'], FILTER_SANITIZE_URL));

        if(isset($parsed_url['path'])) {
            $path = $parsed_url['path'];
        } else {
            $path = '/';
        }

        /**
         * Add check for uppercase characters
         *
         * if(ctype_upper(preg_replace('/[^\da-z]/i', '', $path))){}
         *
         */

        // Get current request method
        $method = $_SERVER['REQUEST_METHOD'];

        $path_match_found = false;

        $route_match_found = false;

        foreach ($this->routes as $route) {
            // Add subpath to matching string
            if ($this->path != '' && $this->path != '/'){
                $route['expression'] = $this->path . $route['expression'];
            }

            $expression = $this->routeRegex($route['expression']);

            // Check path match
            if ($expression) {

                if( preg_match($expression, $path, $matches) ) {
                    $path_match_found = true;

                    // Check method match
                    if (strtolower($method) == strtolower($route['method'])) {

                        $params = array_intersect_key(
                            $matches,
                            array_flip(array_filter(array_keys($matches), 'is_string'))
                        );

                        if (is_array($route['function'])) {
                            call_user_func_array(array(new $route['function'][0], $route['function'][1]), $params);
                        } else {
                            call_user_func_array($route['function'], $params);
                        }

                        $route_match_found = true;

                        // Do not check other routes
                        break;
                    }
                }
            }
        }

        // No matching route was found
        if (!$route_match_found) {
            if ($path_match_found) {
                http_response_code(405);

                if ($this->methodNotAllowed) {
                    call_user_func_array($this->methodNotAllowed, Array($path, $method));
                } else {
                    include('views/errors/405.php');
                }
            } else {
                http_response_code(404);

                if ($this->pathNotFound) {
                    call_user_func_array($this->pathNotFound, Array($path));
                } else {
                    include('views/errors/404.php');
                }
            }
        }
    }

    public function routeRegex($pattern) {
        if (preg_match('/[^-:\/_{}()a-zA-Z\d]/', $pattern))
            return false; // Invalid pattern

        // Turn "(/)" into "/?"
        $pattern = preg_replace('#\(/\)#', '/?', $pattern);

        // Create capture group for ":parameter"
        $allowedParamChars = '[a-zA-Z0-9\_\-]+';
        $pattern = preg_replace(
            '/:(' . $allowedParamChars . ')/',   # Replace ":parameter"
            '(?<$1>' . $allowedParamChars . ')', # with "(?<parameter>[a-zA-Z0-9\_\-]+)"
            $pattern
        );

        // Create capture group for '{parameter}'
        $pattern = preg_replace(
            '/{('. $allowedParamChars .')}/',    # Replace "{parameter}"
            '(?<$1>' . $allowedParamChars . ')', # with "(?<parameter>[a-zA-Z0-9\_\-]+)"
            $pattern
        );

        // Add start and end matching
        $patternAsRegex = "@^" . $pattern . "$@D";

        return $patternAsRegex;
    }

    public static function set_csrf() {
        if( !isset($_SESSION["csrf"]) ) { $_SESSION["csrf"] = bin2hex(random_bytes(50)); }
        echo '<input type="hidden" name="csrf" value="'.$_SESSION["csrf"].'">';
    }

    public static function is_csrf_valid() {
        if( !isset($_SESSION['csrf']) || !isset($_POST['csrf']) ) { return false; }
        if( $_SESSION['csrf'] != $_POST['csrf'] ) { return false; }
        return true;
    }

}