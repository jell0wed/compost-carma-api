<?php namespace CarmaAPI\urls;

class CarmaAPIUrl {
    public static function createInstance($_base, $_initial_path) {
        return new CarmaAPIUrl($_base . "/" . $_initial_path);
    }

    /**
     * @var \Purl\Url;
     */
    private $url_construct;

    protected function __construct($_path)
    {
        $this->url_construct = new \Purl\Url($_path);
    }


    public function stringify($_query_params_func, $_path_params_func) {
        $this->url_construct->setQuery($_query_params_func($this->url_construct->query));
        $this->url_construct->setPath($_path_params_func($this->url_construct->path));

        return $this->url_construct->getUrl();
    }
}

/*class CarmaRESTAPIUrl {
    private $url;

    public function __construct($_base = null)
    {
        if(is_null($_base)) {
            $_base = new \Purl\Purl();
        }

        $this->url = $_base;
    }
}*/