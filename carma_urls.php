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

    public function addPath($_path) {
        $this->url_construct->path->add($_path);
        return $this;
    }

    public function addQuery($_query, $_value) {
        if(!is_null($_value) && !is_null($_query)) {
            $this->url_construct->query->set($_query, $_value);
        }
        return $this;
    }

    public function stringify() {
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