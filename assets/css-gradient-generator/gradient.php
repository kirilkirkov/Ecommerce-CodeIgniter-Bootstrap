<?php

class GradientParser {

    const GRADIENT_TYPE = 'gradient_type';
    const GRADIENT_DIRECTION = 'gradient_direction';
    const GRADIENT_SIZE = 'gradient_size';
    const GRADIENT_SIZE_VALUE = 'gradient_size_value';
    const GRADIENT_SIZE_UNIT = 'gradient_size_unit';
    const GRADIENT_SIZE_MAJOR_VALUE = 'gradient_size_major_value';
    const GRADIENT_SIZE_MAJOR_UNIT = 'gradient_size_major_unit';
    const GRADIENT_REPEAT = 'gradient_repeat';
    const GRADIENT_SHAPE = 'gradient_shape';
    const LINEAR_GRADIENT_ANGLE = 'linear_gradient_angle';
    const GRADIENT_POSITION_HORIZONTAL = 'gradient_position_horizontal';
    const GRADIENT_POSITION_HORIZONTAL_VALUE = 'gradient_position_horizontal_value';
    const GRADIENT_POSITION_HORIZONTAL_UNIT = 'gradient_position_horizontal_unit';
    const GRADIENT_POSITION_VERTICAL = 'gradient_position_vertical';
    const GRADIENT_POSITION_VERTICAL_VALUE = 'gradient_position_vertical_value';
    const GRADIENT_POSITION_VERTICAL_UNIT = 'gradient_position_vertical_unit';

    protected static $_shorteningdata = array(
            'gradient_type' =>  "t",
            'gradient_direction' =>  "d",
            'gradient_size' =>  "s",
            'gradient_size_value' =>  "sv",
            'gradient_size_unit' =>  "su",
            'gradient_size_major_value' =>  "smv",
            'gradient_size_major_unit' =>  "smu",
            'gradient_repeat' =>  "r",
            'gradient_shape' =>  "sh",
            'linear_gradient_angle' =>  "a",
            'gradient_position_horizontal' =>  "h",
            'gradient_position_horizontal_value' =>  "hv",
            'gradient_position_horizontal_unit' =>  "hu",
            'gradient_position_vertical' =>  "v",
            'gradient_position_vertical_value' =>  "vv",
            'gradient_position_vertical_unit' =>  "vu"
        );

    protected $_gradientdata = array(
            'gradient_type' => "linear",
            'gradient_direction' => "bottom right",
            'gradient_size' => "farthest-corner",
            'gradient_size_value' => "10",
            'gradient_size_unit' => "px",
            'gradient_size_major_value' => "10",
            'gradient_size_major_unit' => "px",
            'gradient_repeat' => "off",
            'gradient_shape' => "ellipse",
            'linear_gradient_angle' => "0",
            'gradient_position_horizontal' => "left",
            'gradient_position_horizontal_value' => "0",
            'gradient_position_horizontal_unit' => "%",
            'gradient_position_vertical' => "top",
            'gradient_position_vertical_value' => "0",
            'gradient_position_vertical_unit' => "%",
    );

    protected $_stoppoints = array();

    protected function _initData() {
        if ($this->_querystring == "") {
            $this->_querystring = "t=linear&d=bottom&r=on&sp=c5e3ef_0_%25_4badd2_50_%25_278fba_51_%25_8ed4f1_100_%25";
        }

        $parsed = self::parseGradientPermalink($this->_querystring);

        foreach($parsed['data'] as $key => $value) {
            $this->_gradientdata[$key] = $value;
        }

        $this->_stoppoints = $parsed['colorStops'];
    }

    public static function parseGradientPermalink($querystring) {
        $oldurl = explode("|", $querystring);

        if (count($oldurl) === 2) {
            $querystring = str_replace(array(","), array("&"), $oldurl[0]) . "&sp=";
            $querystring .= str_replace(array("/", ",", "%"), array("_", "__", "%"), $oldurl[1]);
        }

        parse_str($querystring, $parsed);

        $extracteddata = array();
        $colorStops = array();

        $stoppointsdata = explode("__", $parsed['sp']);

        foreach ($parsed as $key => $value) {
            $name = self::getOriginalPreferenceName($key);

            if ($name) {
                $extracteddata[$name] = urldecode($value);
            }
        }

        foreach($stoppointsdata as $value){
            $d = explode("_", $value);
            if (count($d) !== 3) {
                continue;
            }

            $colorStops[] = array(
                "color" => urldecode($d[0]),
                "position" => (float)urldecode($d[1]),
                "unit" => urldecode($d[2]),
            );
        }

        $cmp = function($a, $b) {
            if ($a['position'] == $b['position']) {
                return 0;
            }
            return ($a['position'] < $b['position']) ? -1 : 1;
        };

        usort($colorStops, $cmp);

        return array(
            "data" => $extracteddata,
            "colorStops" => $colorStops
        );
    }

    public static function getOriginalPreferenceName($s) {
        foreach (self::$_shorteningdata as $key => $short) {
            if ($short === $s) {
                return $key;
            }
        }
    }

}

class GradientGenerator extends GradientParser {
    const VERSION = "1";
    const WIDTH = 504;
    const HEIGHT = 504;

    protected $_image;

    public function __construct($querystring, $autoredirect = false) {
        $this->_querystring = $querystring;
        $this->_autoredirect = $autoredirect;
        $this->_md5 = md5(self::VERSION . self::WIDTH . self::HEIGHT . $querystring);
        $this->_cachefilename = 'virtuosoft-gradient-generator-' . $this->_md5 . '.png';
    }

    public function renderGradient() {
        if (isset($_SERVER['HTTP_IF_MODIFIED_SINCE'])) {
            header('HTTP/1.1 304 Not Modified');
            exit;
        }

        $this->makeGradientImage();

        header('Cache-control: public, max-age='.(60*60*24*30));
        header('Expires: '.gmdate(DATE_RFC1123,time()+60*60*24*30));
        header("Content-Type: image/png");
        header("Content-Length: " . strlen($this->_image));
        header('Content-Disposition: inline; filename="' . $this->_cachefilename . '"');

        echo $this->_image;
    }

    public function makeGradientImage($throw = false) {
        $this->_initData();

        $svg = $this->getSvg();

        $im = new Imagick();

        $im->setBackgroundColor(new ImagickPixel('transparent'));

        if (count($this->_stoppoints) < 2) {
            if ($throw) {
                throw new Exception("Invalid gradient, not enough stop points");
            }
            else {
                return "//cdn.virtuosoft.eu/virtuosoft.eu/resources/css3-gradient-generator.png";
            }
        }

        $im->setBackgroundColor(new ImagickPixel('transparent'));

        $im->readImageBlob('<?xml version="1.0" encoding="UTF-8" standalone="no"?>' . $svg);

        $im->setImageFormat("png32");

        $this->_image = $im->getImageBlob();

        $im->clear();
        $im->destroy();
    }

    public function getSvg() {
        switch ($this->_gradientdata[self::GRADIENT_TYPE]) {
            case 'linear':
                return $this->_getLinearSvg();
            case 'radial':
                return $this->_getRadialSvg();
            default:
                throw new Exception("Unknown gradient type: " . $this->_gradientdata[self::GRADIENT_TYPE]);
        }
    }

    private function _getSvgStyle($stoppoint) {
        $color = $stoppoint['color'];
        $opacity = 1;

        $len = strlen($color);

        if ($len == 7) {
            $color = "0" . $color;
            $len = 8;
        }

        if ($len == 8) {
            $opacity = round(hexdec(substr($color, 0, 2)) / 255, 2);
            $color = "#" . substr($color, 2, 6);
        }
        elseif ($len == 6) {
            $color = "#" . $color;
        }
        else {
            throw new Exception("Invalid color: " . $color);
        }

        return "stop-color=\"{$color}\" stop-opacity=\"{$opacity}\"";
    }

    private function _recalculatePosition($position, $min, $max) {
        $length = $max - $min;

        if ($length > 0)
            $percent = ($position - $min) / $length;
        else
            $percent = 0;

        return round($percent, 3);
    }

    private static function _getRgb($hex) {
        return array(
            'red' => base_convert(substr($hex, 0, 2), 16, 10),
            'green' => base_convert(substr($hex, 2, 2), 16, 10),
            'blue' => base_convert(substr($hex, 4, 2), 16, 10),
        );
    }

    private static function _getHex($rgb) {
        $red = str_pad(base_convert($rgb['red'], 10, 16),2,"0",STR_PAD_LEFT);
        $green = str_pad(base_convert($rgb['green'], 10, 16),2,"0",STR_PAD_LEFT);
        $blue = str_pad(base_convert($rgb['blue'], 10, 16),2,"0",STR_PAD_LEFT);

        return $red . $green . $blue;
    }

    private static function _fixEndpoints(&$points) {
        if (count($points) < 2) {
            return $points;
        }

        if ($points[0]['position'] < 0) {
            $p_modify = $points[0];
            $p_other = $points[1];

            $length = $p_other['position'] - $p_modify['position'];

            $weight_modify = 1 - $p_other['position'] / $length;

            $p_modify_rgb = self::_getRgb($p_modify['color']);
            $p_other_rgb = self::_getRgb($p_other['color']);

            $reddiff = $p_other_rgb['red'] - $p_modify_rgb['red'];
            $greendiff = $p_other_rgb['green'] - $p_modify_rgb['green'];
            $bluediff = $p_other_rgb['blue'] - $p_modify_rgb['blue'];

            $newrgb = array(
                'red' => round($p_modify_rgb['red'] + $weight_modify * $reddiff),
                'green' => round($p_modify_rgb['green'] + $weight_modify * $greendiff),
                'blue' => round($p_modify_rgb['blue'] + $weight_modify * $bluediff),
            );

            $points[0]['color'] = self::_getHex($newrgb);
            $points[0]['position'] = 0;

        }

        if ($points[count($points) - 1]['position'] > 100) {
            $p_modify = $points[count($points) - 1];
            $p_other = $points[count($points) - 2];

            $length = abs($p_other['position'] - $p_modify['position']);

            $weight_modify = 1 - ($p_modify['position'] - 100) / $length;

            $p_modify_rgb = self::_getRgb($p_modify['color']);
            $p_other_rgb = self::_getRgb($p_other['color']);

            $reddiff = $p_other_rgb['red'] - $p_modify_rgb['red'];
            $greendiff = $p_other_rgb['green'] - $p_modify_rgb['green'];
            $bluediff = $p_other_rgb['blue'] - $p_modify_rgb['blue'];

            $newrgb = array(
                'red' => round($p_modify_rgb['red'] + $weight_modify * $reddiff),
                'green' => round($p_modify_rgb['green'] + $weight_modify * $greendiff),
                'blue' => round($p_modify_rgb['blue'] + $weight_modify * $bluediff),
            );

            $points[count($points)-1]['color'] = self::_getHex($newrgb);
            $points[count($points)-1]['position'] = 100;
        }
    }

    private function _getSvgStopPointsData() {
        $colorStops = $this->_stoppoints;

        if (count($colorStops) < 2) {
            return false;
        }

        $min = $colorStops[0]['position'];
        $max = $colorStops[count($colorStops) - 1]['position'];
        $length = max(array($max - $min, 1));

        $offsetmultiplier = 0;

        $lastposition = 0;
        $repeat = $this->_gradientdata['gradient_repeat'];

        if ($repeat === 'on') {
            $offsetmultiplier = -ceil($min / $length);
        }

        $stoppoints = "";

        $points = array();

        do {
            foreach($colorStops as $stop) {

                if ($stop['unit'] !== "%") {
                    $stop['unit'] = "%";
                    $stop['position'] = $this->_recalculatePosition($stop['position'], $min, $max);
                }
                else {
                    $stop['position'] = round($stop['position'], 1);
                }

                $stop['position'] += $offsetmultiplier * $length;
                $lastposition = $stop['position'];
                //console.log(length, i, offsetmultiplier, position);

                $points[] = $stop;
            }
            ++$offsetmultiplier;
        } while ($repeat === "on" && $lastposition < 100);

        $splice_start = 0;
        $splice_end = count($points);

        foreach ($points as $key => $stop) {
            if ($stop['position'] < 0 ) {
                $splice_start = $key;
            }

            elseif ($stop['position'] > 100) {
                $splice_end = $key;
                break;
            }
        }

        $points = array_splice($points, $splice_start, $splice_end - $splice_start + 1);

        self::_fixEndpoints($points);

        foreach($points as $stop) {
            $stoppoints .= '<stop ' . $this->_getSvgStyle($stop) . ' offset="' . $stop['position']/100 . '"/>' . "\n";
        }

        return $stoppoints;
    }

    public static function getCoordsForAngle($angle) {
            $tan = round(tan($angle % 45 * pi() / 180) * 50);

            $sin = sin(($angle - 45) * 4 * pi() / 180);
            $maxi = 6 * sqrt(2);
            $modifier = abs($sin * $maxi);

        if ($angle >=0 && $angle < 45) {
            $xs = $tan + $modifier;
            $ys = -50 - $modifier;
        }
        if ($angle >=45 && $angle < 90) {
            $xs = 50 + $modifier;
            $ys = -50 + $tan - $modifier;
        }
        if ($angle >=90 && $angle < 135) {
            $xs = 50 + $modifier;
            $ys = $tan + $modifier;
        }
        if ($angle >=135 && $angle < 180) {
            $xs = 50 - $tan + $modifier;
            $ys = 50 + $modifier;
        }
        if ($angle >=180 && $angle < 225) {
            $xs = -$tan - $modifier;
            $ys = 50 + $modifier;
        }
        if ($angle >=225 && $angle < 270) {
            $xs = -50 - $modifier;
            $ys = 50 - $tan + $modifier;
        }
        if ($angle >=270 && $angle < 315) {
            $xs = -50 - $modifier;
            $ys = -$tan - $modifier;
        }
        if ($angle >=315 && $angle < 360) {
            $xs = -50 + $tan - $modifier;
            $ys = -50 - $modifier;
        }

        return array(
            'xs' => $xs,
            'ys' => $ys,
            'x1' => 50 - $xs . "%",
            'y1' => 50 - $ys . "%",
            'x2' => 50 + $xs . "%",
            'y2' => 50 + $ys . "%"
        );
    }

    private function _getLinearSvg() {
        $svg = "";
        $svgstoppoints = $this->_getSvgStopPointsData();
        $from = "0%";
        $to = "100%";
        $x1 = "";
        $y1 = "";
        $x2 = "";
        $y2 = "";

        $gradient_direction = $this->_gradientdata[self::GRADIENT_DIRECTION];
        if ( $gradient_direction === "angle") {
            $angle = $this->_gradientdata[self::LINEAR_GRADIENT_ANGLE];

            $coords = self::getCoordsForAngle($angle);

            $x1 = $coords['x1'];
            $y1 = $coords['y1'];
            $x2 = $coords['x2'];
            $y2 = $coords['y2'];
        }
        else {
            switch($gradient_direction) {
                case "top":
                    $x1 = "0%";
                    $y1 = $to;
                    $x2 = "0%";
                    $y2 = $from;
                    break;
                case "top left":
                    $x1 = "100%";
                    $y1 = "100%";
                    $x2 = "0%";
                    $y2 = "0%";
                    break;
                case "top right":
                    $x1 = "0%";
                    $y1 = "100%";
                    $x2 = "100%";
                    $y2 = "0%";
                    break;
                case "left":
                    $x1 = $to;
                    $y1 = "0%";
                    $x2 = $from;
                    $y2 = "0%";
                    break;
                case "bottom":
                    $x1 = "0%";
                    $y1 = $from;
                    $x2 = "0%";
                    $y2 = $to;
                    break;
                case "bottom left":
                    $x1 = "100%";
                    $y1 = "0%";
                    $x2 = "0%";
                    $y2 = "100%";
                    break;
                case "bottom right":
                    $x1 = "0%";
                    $y1 = "0%";
                    $x2 = "100%";
                    $y2 = "100%";
                    break;
                case "right":
                    $x1 = $from;
                    $y1 = "0%";
                    $x2 = $to;
                    $y2 = "0%";
                    break;
            }
        }

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="' . self::WIDTH . '" height="' . self::HEIGHT . '" viewBox="0 0 1 1" preserveAspectRatio="none"><linearGradient id="vsgg" gradientUnits="userSpaceOnUse" x1="' . $x1 . '" y1="' . $y1 . '" x2="' . $x2 . '" y2="' . $y2 . '">' . "\n";

        $svg .= $svgstoppoints;

        $svg .= '</linearGradient><rect x="0" y="0" width="1" height="1" fill="url(#vsgg)" /></svg>';

        return $svg;
    }

    private function _getRadialSvg() {
        $svgstoppoints = $this->_getSvgStopPointsData();

        $x = $this->_gradientdata[self::GRADIENT_POSITION_HORIZONTAL];

        switch ($x) {
            case "explicit":
                if ($this->_gradientdata[self::GRADIENT_POSITION_HORIZONTAL_UNIT] === "%") {
                    $x = $this->_gradientdata[self::GRADIENT_POSITION_HORIZONTAL_VALUE];
                }
                else {
                    $x = round($this->_gradientdata[self::GRADIENT_POSITION_HORIZONTAL_VALUE] / self::WIDTH * 100, 1);
                }
                break;
            case "left":
                $x = 0;
                break;
            case "center":
                $x = 50;
                break;
            case "right":
                $x = 100;
                break;
        }

        $y = $this->_gradientdata[self::GRADIENT_POSITION_VERTICAL];

        switch ($y) {
            case "explicit":
                if ($this->_gradientdata[self::GRADIENT_POSITION_VERTICAL_UNIT] === "%") {
                    $y = $this->_gradientdata[self::GRADIENT_POSITION_VERTICAL_VALUE];
                }
                else {
                    $y = round($this->_gradientdata[self::GRADIENT_POSITION_VERTICAL_VALUE] / self::HEIGHT * 100, 1);
                }
                break;
            case "top":
                $y = 0;
                break;
            case "center":
                $y = 50;
                break;
            case "bottom":
                $y = 100;
                break;
        }

        if ($x > 50) {
            $xpos = $x;
        }
        else {
            $xpos = 100 - $x;
        }

        if ($y>50) {
            $ypos = $y;
        }
        else {
            $ypos = 100 - $y;
        }

        switch($this->_gradientdata["gradient_size"]) {
            case "closest-side":
                if ($xpos < 50) {
                    $xs = $xpos;
                }
                else {
                    $xs = 100 - $xpos;
                }
                if ($ypos < 50) {
                    $ys = $ypos;
                }
                else {
                    $ys = 100 - $ypos;
                }

                $r = min($xs, $ys);
                break;
            case "closest-corner":
                if ($xpos < 50) {
                    $xs = $xpos;
                }
                else {
                    $xs = 100 - $xpos;
                }
                if ($ypos < 50) {
                    $ys = $ypos;
                }
                else {
                    $ys = 100 - $ypos;
                }

                $r = sqrt($xs*$xs + $ys*$ys);
                break;
            case "farthest-side":
                if ($xpos < 50) {
                    $xs = 100;
                }
                else {
                    $xs = $xpos;
                }
                if ($ypos < 50) {
                    $ys = 100 - $ypos;
                }
                else {
                    $ys = $ypos;
                }

                $r = max($xs, $ys);
                break;

            case "farthest-corner":
                if ($xpos < 50) {
                    $xs = 100;
                }
                else {
                    $xs = $xpos;
                }
                if ($ypos < 50) {
                    $ys = 100 - $ypos;
                }
                else {
                    $ys = $ypos;
                }

                $r = sqrt($xs*$xs + $ys*$ys);
                break;

            default:
                if ($this->_gradientdata[self::GRADIENT_SIZE_UNIT] === "%") {
                    if ($this->_gradientdata[self::GRADIENT_SHAPE] === "circle") {
                        $r = $this->_gradientdata[self::GRADIENT_SIZE_VALUE];
                    }
                    else {
                        $r = ($this->_gradientdata[self::GRADIENT_SIZE_VALUE] + $this->_gradientdata[self::GRADIENT_SIZE_MAJOR_VALUE]) / 2;
                    }
                }
                else {
                    $r = round($this->_gradientdata[self::GRADIENT_SIZE_VALUE] / ((self::WIDTH + self::HEIGHT) / 2) * 100, 1);
                    if ($this->_gradientdata[self::GRADIENT_SHAPE] === "circle") {
                        $r = round($this->_gradientdata[self::GRADIENT_SIZE_VALUE] / ((self::WIDTH + self::HEIGHT) / 2) * 100, 1);
                    }
                    else {
                        $avgsize = ($this->_gradientdata[self::GRADIENT_SIZE_VALUE] + $this->_gradientdata[self::GRADIENT_SIZE_MAJOR_VALUE]) / 2;
                        $r = round($avgsize / ((self::WIDTH + self::HEIGHT) / 2) * 100, 1);
                    }
                }
                break;
        }

        $svg = '<svg xmlns="http://www.w3.org/2000/svg" width="'. self::WIDTH . '" height="' . self::HEIGHT . '" viewBox="0 0 1 1" preserveAspectRatio="none"><radialGradient id="vsgg" gradientUnits="userSpaceOnUse" cx="' . $x . '%" cy="' . $y . '%" r="' . $r . '%">' . "\n";

        $svg .= $svgstoppoints;

        $svg .= '</radialGradient><rect x="-50" y="-50" width="101" height="101" fill="url(#vsgg)" /></svg>';

        return $svg;
    }
}

function badrequest($message) {
    $protocol = (isset($_SERVER['SERVER_PROTOCOL']) ? $_SERVER['SERVER_PROTOCOL'] : 'HTTP/1.0');
    header($protocol . ' ' . 400 . ' Bad Request');
    echo '<h1>Bad request</h1>';
    echo '<p>', $message, '</p>';
    exit;
}

$url = parse_url($_SERVER['REQUEST_URI']);
if (basename($url['path']) === "gradient.php") {
    try {
        $gradient = new GradientGenerator($_SERVER["QUERY_STRING"], true);
        // will redirect if cache image is succesfully generated
        $gradient->makeGradientImage(true);

        //fallback to live generation if cache file is not writable
        $gradient->renderGradient();
    }
    catch(Exception $e) {
        badrequest($e->getMessage());
    }
}
