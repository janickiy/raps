<?php

namespace App\Helpers;

class StringHelper
{
    /**
     * @param $data
     * @return array
     */
    public static function ObjectToArray($data): array
    {
        if (is_array($data) || is_object($data)) {
            $result = [];
            foreach ($data as $key => $value) {
                $result[$key] = self::ObjectToArray($value);
            }
            return $result;
        }
        return $data;
    }

    /**
     * @param string $gps
     * @return string
     */
    public static function gooleMap(string $gps): string
    {
        return '<a target="_blank" href="https://www.google.com/maps/@' . $gps . ',19z?entry=ttu">' . $gps . '</a>';
    }

    /**
     * @param string $str
     * @return string
     */
    public static function subFormula(string $str): string
    {
        return preg_replace('/(\d{1,2})/i', '<span class="sub">$1</span>',  $str);
    }

    /**
     * @param $el
     * @param bool $first
     * @return string
     */
    public static function tree($el, bool $first = true): string
    {
        if (is_object($el)) $el = (array)$el;

        if ($el) {

            if ($first) {
                $out = '<ul id="tree-checkbox" class="tree-checkbox treeview">';
            } else {
                $out = '<ul>';
            }

            foreach ($el as $k => $v) {

                if (is_object($v)) $v = (array)$v;

                if ($v) {

                    $out .= "<li><strong> " . $k . " :</strong> ";

                    if (is_array($v)) {
                        $out .= self::tree($v, false);
                    } else {
                        $out .= $v;
                    }

                    $out .= "</li>";
                }
            }

            $out .= "</ul>";

            return $out;
        }
    }

    /**
     * @param string $text
     * @param bool $toLower
     * @return string
     */
    public static function slug(string $text, bool $toLower = true): string
    {
        $text = trim($text);

        $tr = [
            "А" => "A",
            "Б" => "B",
            "В" => "V",
            "Г" => "G",
            "Д" => "D",
            "Е" => "E",
            "Ё" => "E",
            "Ж" => "J",
            "З" => "Z",
            "И" => "I",
            "Й" => "Y",
            "К" => "K",
            "Л" => "L",
            "М" => "M",
            "Н" => "N",
            "О" => "O",
            "П" => "P",
            "Р" => "R",
            "С" => "S",
            "Т" => "T",
            "У" => "U",
            "Ф" => "F",
            "Х" => "H",
            "Ц" => "TS",
            "Ч" => "CH",
            "Ш" => "SH",
            "Щ" => "SCH",
            "Ъ" => "",
            "Ы" => "YI",
            "Ь" => "",
            "Э" => "E",
            "Ю" => "YU",
            "Я" => "YA",
            "а" => "a",
            "б" => "b",
            "в" => "v",
            "г" => "g",
            "д" => "d",
            "е" => "e",
            "ё" => "e",
            "ж" => "j",
            "з" => "z",
            "и" => "i",
            "й" => "y",
            "к" => "k",
            "л" => "l",
            "м" => "m",
            "н" => "n",
            "о" => "o",
            "п" => "p",
            "р" => "r",
            "с" => "s",
            "т" => "t",
            "у" => "u",
            "ф" => "f",
            "х" => "h",
            "ц" => "ts",
            "ч" => "ch",
            "ш" => "sh",
            "щ" => "sch",
            "ъ" => "y",
            "ы" => "yi",
            "ь" => "",
            "э" => "e",
            "ю" => "yu",
            "я" => "ya",
            "«" => "",
            "»" => "",
            "№" => "",
            "Ӏ" => "",
            "’" => "",
            "ˮ" => "",
            "_" => "-",
            "'" => "",
            "`" => "",
            "^" => "",
            "\." => "",
            "," => "",
            ":" => "",
            ";" => "",
            "<" => "",
            ">" => "",
            "!" => "",
            "\(" => "",
            "\)" => "",
            '&' => "-"
        ];

        foreach ($tr as $ru => $en) {
            $text = mb_eregi_replace($ru, $en, $text);
        }

        if ($toLower) {
            $text = mb_strtolower($text);
        }

        $text = str_replace(' ', '-', $text);

        return $text;
    }

    /**
     * @param string $str
     * @param int $chars
     * @return string
     */
    public static function shortText(string $str, int $chars = 500): string
    {
        $pos = strpos(substr($str, $chars), " ");
        $srttmpend = strlen($str) > $chars ? '...' : '';

        return substr($str, 0, $chars + $pos) . (isset($srttmpend) ? $srttmpend : '');
    }

    /**
     * @param int $size
     * @param int $maxDecimals
     * @param string $mbSuffix
     * @return string
     */
    public static function formatSizeInMb(int $size, int $maxDecimals = 3, string $mbSuffix = "MB"): string
    {
        $mbSize = round($size / 1024 / 1024, $maxDecimals);

        return preg_replace("/\\.?0+$/", "", $mbSize) . $mbSuffix;
    }

    /**
     * @return mixed
     */
    public static function detectMaxUploadFileSize()
    {
        /**
         * Converts shorthands like "2M" or "512K" to bytes
         *
         * @param int $size
         * @return int|float
         * @throws Exception
         */
        $normalize = function ($size) {
            if (preg_match('/^(-?[\d\.]+)(|[KMG])$/i', $size, $match)) {
                $pos = array_search($match[2], ["", "K", "M", "G"]);
                $size = $match[1] * pow(1024, $pos);
            } else {
                return false;
            }
            return $size;
        };

        $limits = [];
        $limits[] = $normalize(ini_get('upload_max_filesize'));

        if (($max_post = $normalize(ini_get('post_max_size'))) != 0) {
            $limits[] = $max_post;
        }

        if (($memory_limit = $normalize(ini_get('memory_limit'))) != -1) {
            $limits[] = $memory_limit;
        }

        $maxFileSize = min($limits);

        return $maxFileSize;
    }

    /**
     * @return string
     */
    public static function maxUploadFileSize(): string
    {
        $maxUploadFileSize = self::detectMaxUploadFileSize();

        if (!$maxUploadFileSize or $maxUploadFileSize == 0) {
            $maxUploadFileSize = 2097152;
        }

        return self::formatSizeInMb($maxUploadFileSize);
    }

    /**
     * @param string $path
     * @return mixed
     */
    public static function getMime(string $path)
    {
        $path_info = getimagesize($path);

        return $path_info['mime'];
    }

    /**
     * @param string $string
     * @return array|string|string[]
     */
    public static function phone(string $string)
    {
        return str_replace([' ', '(', ')', '-'], '', $string);
    }

    /**
     * @param string $filename
     * @return string
     */
    public static function get_mime_type(string $filename): string
    {
        $idx = explode('.', $filename);
        $count_explode = count($idx);
        $idx = strtolower($idx[$count_explode - 1]);

        $mimet = [
            'txt' => 'text/plain',
            'htm' => 'text/html',
            'html' => 'text/html',
            'php' => 'text/html',
            'css' => 'text/css',
            'js' => 'application/javascript',
            'json' => 'application/json',
            'xml' => 'application/xml',
            'swf' => 'application/x-shockwave-flash',
            'flv' => 'video/x-flv',

            // images
            'png' => 'image/png',
            'jpe' => 'image/jpeg',
            'jpeg' => 'image/jpeg',
            'jpg' => 'image/jpeg',
            'gif' => 'image/gif',
            'bmp' => 'image/bmp',
            'ico' => 'image/vnd.microsoft.icon',
            'tiff' => 'image/tiff',
            'tif' => 'image/tiff',
            'svg' => 'image/svg+xml',
            'svgz' => 'image/svg+xml',

            // archives
            'zip' => 'application/zip',
            'rar' => 'application/x-rar-compressed',
            'exe' => 'application/x-msdownload',
            'msi' => 'application/x-msdownload',
            'cab' => 'application/vnd.ms-cab-compressed',

            // audio/video
            'mp3' => 'audio/mpeg',
            'qt' => 'video/quicktime',
            'mov' => 'video/quicktime',

            // adobe
            'pdf' => 'application/pdf',
            'psd' => 'image/vnd.adobe.photoshop',
            'ai' => 'application/postscript',
            'eps' => 'application/postscript',
            'ps' => 'application/postscript',

            // ms office
            'doc' => 'application/msword',
            'rtf' => 'application/rtf',
            'xls' => 'application/vnd.ms-excel',
            'ppt' => 'application/vnd.ms-powerpoint',
            'docx' => 'application/msword',
            'xlsx' => 'application/vnd.ms-excel',
            'pptx' => 'application/vnd.ms-powerpoint',

            // open office
            'odt' => 'application/vnd.oasis.opendocument.text',
            'ods' => 'application/vnd.oasis.opendocument.spreadsheet',
        ];

        return $mimet[$idx] ?? 'application/octet-stream';

    }
}
