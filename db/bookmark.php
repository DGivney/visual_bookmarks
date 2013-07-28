<?php
namespace OCA\Visual_Bookmarks\Db;

use \OCA\AppFramework\Db\Entity;

class Bookmark extends Entity
{

    /**
     * Database fields
     */
    public $id;
    public $url;
    public $title;
    public $userId;
    public $description;
    public $public;
    public $added;
    public $lastmodified;
    public $clickcount;
    public $image;
    public $lastindexed;

    /**
     * Additional fields
     */
    public $hostname;
    public $domain;
    public $domainWithoutExt;
    public $color;

    /**
     * Maps the keys of the row array to the attributes
     * @param array $row the row to map onto the entity
     */
    public function fromRow(array $row)
    {
        if (!empty($row['url'])) {
            $this->hostname = $this->getHostname($row['url']);
            $this->domain = $this->getDomain($this->hostname);
            $this->domainWithoutExt = $this->getDomainWithoutExt($this->hostname);
            $this->color = $this->genColorCodeFromText(
                $this->domain ? $this->domain : $this->hostname,
                80
            );
        }

        return parent::fromRow($row);
    }

    /**
     * set method
     *
     * @param array $data
     */
    public function set($data, $whiteList = array())
    {
        foreach ($data as $key => $value) {
            if (in_array($key, $whiteList)) {
                $method = 'set' . ucfirst($key);
                $this->$method($value);
            }
        }

        return true;
    }

    /**
     * getHostname method
     *
     * @param string $url
     * @return string
     */
    public function getHostname($url)
    {
        return parse_url($url, PHP_URL_HOST);
    }

    /**
     * getDomain method
     *
     * @param string $hostname
     * @return string
     */
    public function getDomain($hostname = '')
    {
        if (preg_match('/(?P<domain>[a-z0-9][a-z0-9\-]{1,63}\.[a-z\.]{2,6})$/i', $hostname, $regs)) {
            return $regs['domain'];
        }

        return false;
    }

    /**
     * getDomainWithoutExt method
     *
     * @param string $hostname
     * @return string
     */
    function getDomainWithoutExt($name)
    {
        $pos = strripos($name, '.');
        if($pos === false) {
            return $name;
        } else {
            return substr($name, 0, $pos);
        }
    }

    /**
     * genColorCodeFromText method
     *
     * Outputs a color (#000000) based Text input
     *
     * (https://gist.github.com/mrkmg/1607621/raw/241f0a93e9d25c3dd963eba6d606089acfa63521/genColorCodeFromText.php)
     *
     * @param String $text of text
     * @param Integer $min_brightness: between 0 and 100
     * @param Integer $spec: between 2-10, determines how unique each color will be
     * @return string $output
     */
    function genColorCodeFromText($text, $min_brightness = 100, $spec = 10)
    {
        // Check inputs
        if(!is_int($min_brightness)) throw new Exception("$min_brightness is not an integer");
        if(!is_int($spec)) throw new Exception("$spec is not an integer");
        if($spec < 2 or $spec > 10) throw new Exception("$spec is out of range");
        if($min_brightness < 0 or $min_brightness > 255) throw new Exception("$min_brightness is out of range");

        $hash = md5($text);  //Gen hash of text
        $colors = array();
        for($i=0; $i<3; $i++) {
            //convert hash into 3 decimal values between 0 and 255
            $colors[$i] = max(array(round(((hexdec(substr($hash, $spec * $i, $spec))) / hexdec(str_pad('', $spec, 'F'))) * 255), $min_brightness));
        }

        if($min_brightness > 0) {
            while(array_sum($colors) / 3 < $min_brightness) {
                for($i=0; $i<3; $i++) {
                    //increase each color by 10
                    $colors[$i] += 10;
                }
            }
        }

        $output = '';
        for($i=0; $i<3; $i++) {
            //convert each color to hex and append to output
            $output .= str_pad(dechex($colors[$i]), 2, 0, STR_PAD_LEFT);
        }

        return '#'.$output;
    }

}