<?php


namespace Krovitch\KrovitchBundle\Utils;


use Symfony\Component\Security\Acl\Exception\Exception;

class Svg
{
    protected $pattern = 'svg-test-%s';
    // we store already used ids to avoid duplication
    protected static $usedIds = array();

    public function importFiles(array $pathList)
    {
        if (!count($pathList)) {
            throw new Exception('You must import at least one path');
        }
        $svgFiles = array();

        foreach ($pathList as $path) {

            if (is_file($path)) {
                $file = $this->importFile($path);
                $svgFiles[$file['id']] = $file['content'];
            } else {
                throw new Exception($path . ' is not a file !');
            }
        }
        return $svgFiles;
    }

    protected function importFile($path)
    {
        $content = file_get_contents($path);
        $content = strstr($content, '<svg');

        // we must know if svg has an id
        // <svg> is the first tag (since we remove others)
        // TODO improve performance with regxep maybe...
        $svgEndPosition = strpos($content, '>');
        $svgTag = substr($content, 0, $svgEndPosition);
        // if it has not, we create a default
        if (($idPosition = strpos($svgTag, 'id=')) === false) {
            $count = 1;
            $id = sprintf($this->pattern, $count);

            while (in_array($id, self::$usedIds)) {
                $count++;
                $id = sprintf($this->pattern, $count);
            }
            // here we have an id
            $content = sprintf('<svg id="%s" %s', $id, substr($content, 4));
        } else {
            $p = strpos($svgTag, '"', $idPosition) + 1;
            $p2 = strpos($svgTag, '"', $p);
            $id = substr($svgTag, $p, $p2 - $p);
        }
        self::$usedIds[] = $id;

        return array('id' => $id, 'content' => $content);
    }

}