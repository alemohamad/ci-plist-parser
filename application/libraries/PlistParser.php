<?php defined('BASEPATH') or exit('No direct script access allowed');

/**
 *  Plist Parser
 *  
 *  This class parses a plist configuration file and returns the config as an array. It's very easy to use and very effective.
 *  Plist is just a more strict form of XML. The only difference is that there are key-value pairs with seperate tags and the value have their types.
 *  
 *  Original code: http://phpftw.org/index.php?id=9
 **/

class PlistParser
{
    private $file;
    private $filename;
    private $xmlpath;

    public function __construct()
    {
        $this->setXMLPath(FCPATH);
    }

    public function setXMLPath($value)
    {
        $this->xmlpath = $value;
    }

    public function getXMLPath()
    {
        return $this->xmlpath;
    }

    public function loadFile($filename, $mode = 'r')
    {
        $this->filename = $filename;
        $this->file     = fopen($this->getXMLPath() . $filename, $mode);
    }

    public function getTree()
    {
        $plist = simplexml_load_file($this->getXMLPath() . $this->getFilename());
        $root  = $plist->children();
        $root  = $root[0];
        return $this->processElement($root->getName(), $root->children());
    }

    public function getFilename()
    {
        return $this->filename;
    }

    public function getConfig()
    {
        return $this->getTree();
    }

    public function processElement($type, $children)
    {
        switch ($type) {
            case 'true':
                return true;
                break;
            case 'false':
                return false;
                break;
            case 'boolean':
                return ($children == 'true' ? true : false);
                break;
            case 'integer':
                return intval((string) ($children));
                break;
            case 'string':
                return (string) ($children);
                break;
            case 'array':
                return $this->processArray($children);
                break;
            case 'dict':
                return $this->processDict($children);
                break;
        }
    }

    public function processArray($children)
    {
        $array = array();
        $type  = '';
        $value = '';
        foreach ($children as $child) {
            $type  = $child->getName();
            $value = $this->processElement($type, ($type == 'dict' || $type == 'array' ? $child->children() : $child));
            array_push($array, $value);
        }
        return $array;
    }

    public function processDict($children)
    {
        $dict          = array();
        $dict['&dict'] = '';
        $key           = '';
        $value         = '';
        $type          = '';
        foreach ($children as $child) {
            if (($child->getName() == 'key') && !$key) {
                $key = (string) ($child);
            } else if ($key) {
                $type       = $child->getName();
                $value      = $this->processElement($type, ($type == 'dict' || $type == 'array' ? $child->children() : $child));
                $dict[$key] = $value;
                $key        = '';
            }
        }
        return $dict;
    }

    public function write($content)
    {
        rewind($this->file);
        fwrite($this->file, $content);
    }

    public function save()
    {
        fclose($this->file);
    }
}

/* End of file PlistParser.php */
/* Location: ./application/libraries/PlistParser.php */