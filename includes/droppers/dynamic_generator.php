<?php
define('allowed_chars',"abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ");

class dynamic_generator
{
    private function junkLoops(bool $needsleep, int $sleep_depth):array
    {
        $types = array(
            1 => "array",
            2 => "string",
            3 => "int"
        );
        $loop_types = array(
            1 => "while",
            2 => "if",
            3 => "for",
            4 => "foreach"
        );
        $operations = array(
            1 => "or",
            2 => "and",
            3 => "||",
            4 => "&&"
        );
        $checks = array(
            1 => "is_null",
            2 => "empty",
            3 => "isset",
        );
        $pos_neg = array(
            1 => "!",
            2 => ""
        );
        $sleeper = null;
        switch ($needsleep) {
            case true:
                $for_looper = substr(str_shuffle(allowed_chars), 0, rand(3, 15));
                $foreach_key = substr(str_shuffle(allowed_chars), 0, rand(3, 15));
                $foreach_value = substr(str_shuffle(allowed_chars), 0, rand(3, 15));
                if ($sleep_depth > 5) {
                    $sleep_length = rand(10000, 50000);
                } else {
                    $sleep_length = rand(1000, 9000);
                }
                $sleeper = <<<SLEEPER
$loop_types[4] ( \$$for_looper as \$$foreach_key => \$$foreach_value ){\n\t
\tfor (\$i = 0; \$i <

SLEEPER;
                return array(
                    "loop_chunk" => $sleeper,
                    "foreach_key" => $for_looper
                );
            case false:
                $looper = $loop_types[rand(1, 2)];
                $sleeper = <<<SLEEPER
                \t (substr(str_shuffle(allowed_chars), 0, rand(3,15))){\n\t;

                SLEEPER;
                return array(
                    "1" => $sleeper
                );
        }
        return array(
            "skip"=>true
        );
    }

    private function randomString(){
        $a = '';
        switch (rand(0,15)){
            case 0:
                $f_name = substr(str_shuffle(allowed_chars), 0, rand(3,45));
                $a = "function ". $f_name . "(string \$". substr(str_shuffle(allowed_chars), 0, rand(3,45)) ."){\n";
                for ($i = 0; $i <= rand(1,15); $i++) {
                    $a .= "\t\$" . substr(str_shuffle(allowed_chars), 0, rand(3, 45)) . " = \"" . bin2hex(random_bytes(rand(3, 70))) . "\";\n";
                }
                $a .= "\treturn false;\n}\n\n";
                $a .= "{$f_name}('" . substr(str_shuffle(allowed_chars), 0, rand(3,45)) . "');\n";
                break;
            case 1|3|5|7|9:
                $junked = array(
                    "1" => substr(str_shuffle(allowed_chars), 0, rand(3,80)),
                    "2" => base64_encode(substr(str_shuffle(allowed_chars), 0, rand(3,80))),
                    "3" => bin2hex(random_bytes(rand(5,80)))
                );
                $a = "\$". substr(str_shuffle(allowed_chars), 0, rand(3,15)) . " = \"". $junked[rand(1,3)] . "\";\n";
                break;
            case 2|4|6|8|10:
                $a = "define('" . bin2hex(random_bytes(rand(3, 90))) . "', \"" . bin2hex(random_bytes(rand(5, 100))) . "\");\n";
                break;
            case 11:

                break;
            case 12:
                $a = "define('". bin2hex(random_bytes(rand(1,35))) . "', \"" . bin2hex(random_bytes(rand(5,100))) . "\");\n";
                break;
            case 13:
                $obfs_tmp = substr(str_shuffle(allowed_chars), 0, rand(3,15));
                $a = "\$" . $obfs_tmp . " = tmpfile();\nfwrite(\$".$obfs_tmp.",\"".substr(str_shuffle(allowed_chars), 0, rand(3,15))."\");\n";
                for ($i = 0; $i <= rand(10,15); $i++) {
                    $a .= "fwrite(\$".$obfs_tmp.", \"" . base64_encode(substr(str_shuffle(allowed_chars), 0, rand(3, 15))) . "\");\n";
                }
                $a .= "fseek(\$".$obfs_tmp.", 0);\n";
                $a .= "\$".substr(str_shuffle(allowed_chars), 0, rand(1,90))." = file(\$".$obfs_tmp.");\n";
                $a .= "fclose(\$".$obfs_tmp.");\n";
                break;
            case 14:
                $a = "// why is it not launching??????\n";
                break;
            case 15:
                $yy = rand(1997,(int)date("Y"));
                $mo = rand(1,12);
                $dd = rand(1,31);
                $a  .= "//created: \n". date("Y/m/d - l", mktime(null, null, null, $mo, $dd, $yy));
                break;
        }
        return $a;
    }

    private function encryptFile($filename):bool
    {
        if (!empty($filename) and is_file($filename)){
            return true;

        }else{
            return true;
        }
    }

    function begin_junk($file, $depth, $out, $mode)
    {
        $char_map_lower = array(
            "a" => "\\x61",
            "b" => "\\x62",
            "c" => "\\x63",
            "d" => "\\x64",
            "e" => "\\x65",
            "f" => "\\x66",
            "g" => "\\x67",
            "h" => "\\x68",
            "i" => "\\x69",
            "j" => "\\x6A",
            "k" => "\\x6B",
            "l" => "\\x6C",
            "m" => "\\x6D",
            "n" => "\\x6E",
            "o" => "\\x6F",
            "p" => "\\x70",
            "q" => "\\x71",
            "r" => "\\x72",
            "s" => "\\x73",
            "t" => "\\x74",
            "u" => "\\x75",
            "v" => "\\x76",
            "w" => "\\x77",
            "x" => "\\x78",
            "y" => "\\x79",
            "z" => "\\x7A",
            " " => "\\x20",
            "" => "\\x00",
            "!" => "\\x21",
            "?" => "\\x3F",
            "\"" => "\\x22",
            "'" => "\\x27",
            "\\" => "\\x5C",
            "/" => "\\x2F",
            "=" => "\\x3D",
            ">" => "\\x3E",
            "<" => "\\x3C",
            ":" => "\\x3A",
            ";" => "\\x3B",
            "-" => "\\x2D",
            "[" => "\\x5B",
            "]" => "\\x5D",
            "+" => "\\x2B",
            ")" => "\\x29",
            "(" => "\\x28",
            "%" => "\\x25",
            "^" => "\\x5E",
            "*" => "\\x2A",
            "&" => "\\x26",
            "#" => "\\x23",
            "@" => "\\x40",
            "`" => "\\x60",
            "~" => "\\x5F",
            "|" => "\\x7C",
            "}" => "\\x7D",
            "{" => "\\x7B",
            "\r" => "\\x0D",
            "\n" => "\\x0A",
            "$" => "\\x24",
            "_" => "\\x5F",
            "," => "\\x2C",
            "." => "\\x2E",
            "0" => "\\x30",
            "1" => "\\x31",
            "2" => "\\x32",
            "3" => "\\x33",
            "4" => "\\x34",
            "5" => "\\x35",
            "6" => "\\x36",
            "7" => "\\x37",
            "8" => "\\x38",
            "9" => "\\x39",
        );
        $b_encoded = array();
        if (!empty($file) and is_file($file) and !empty($depth)){
            foreach (file($file) as $letter){
                foreach (str_split($letter) as $word) {
                    array_push($b_encoded, $char_map_lower[strtolower($word)]);
                }
            }
            switch (strtolower($mode)){
                case "n":
                    $d = "<?php\neval(base64_decode(\"" .base64_encode(implode("", $b_encoded)) . "\"));\n";
                    fputs(fopen($out, "w"), $d, strlen($d));
                    break;
                case "ob":
                    $out_file = fopen($out, "w");
                    $key = bin2hex(random_bytes(rand(32,64)));
                    echo "Key: {$key}\nKey length: ". strlen($key)."\n";
                    fputs($out_file, "<?php\n", strlen("<?php\n"));
                    for ($i = 0; $i <= $depth; $i++) {
                        $ax = $this->randomString();
                        fputs($out_file, $ax, strlen($ax));
                    }
                    $returned = $this->randomString();
                    fputs($out_file, $returned, strlen($returned));
                    $i = 0;
                    $encrypted = '';
                    $text = base64_encode(implode("", $b_encoded));
                    foreach (str_split($text) as $char) {
                        $encrypted .= chr(ord($char) ^ ord($key{$i++ % strlen($key)}));
                    }
                    $b = base64_encode($encrypted);
                    $fun = substr(str_shuffle(allowed_chars), 0, rand(3,15));
                    $ad = substr(str_shuffle(allowed_chars), 0, rand(3,15));
                    $da = substr(str_shuffle(allowed_chars), 0, rand(3,15));
                    $f_name = substr(str_shuffle(allowed_chars), 0, rand(3,15));
                    $values = substr(str_shuffle(allowed_chars), 0, rand(3,15));
                    $chars = substr(str_shuffle(allowed_chars), 0, rand(3,15));
                    $iterator = substr(str_shuffle(allowed_chars), 0, rand(3,15));
                    $tt = substr(str_shuffle(allowed_chars), 0, rand(3,15));
                    $tt_name = substr(str_shuffle(allowed_chars), 0, rand(3,15));
                    if (!is_null($key)){
                        $a = "\$" . $f_name . " = \"" . (string)$key . "\";";
                    }
                    $do = <<<FULL
function $fun(string \$$values)
{
    $a
    \$$iterator = 0;
    if (!empty(\$$values)){
        \$$ad = \$$values;
        foreach (str_split(\$$ad) as \$$chars){
            \$$da .= chr(ord(\$$f_name{\$$iterator++ % strlen(\$$f_name)}) ^ ord(\$$chars));
        }
    }
    \$$tt = tempnam(sys_get_temp_dir(),"$tt_name");
    fwrite(fopen(\$$tt, "a+"), base64_decode(\$$da));
    if (substr(php_uname(), 0, 7) == 'Windows') {
        system("start /b php -F \$$tt");
    }else{
        system("nohup php -F \$$tt &");
    }
}
$fun(base64_decode("$b"));
FULL;
                    fputs($out_file, $do, strlen($do));
                    fclose($out_file);
                    break;
            }
        }else{
            $required_params = array();
            if (empty($mode)){
                array_push($required_params, ("mode cannot be empty. Please use either ob for obfuscation or n for plain."));
            }else if (empty($file)){
                array_push($required_params, "file cannot be empty.");
            }else if (!is_file($file)){
                array_push($required_params, "File needs to be of type file not string.(think fopen)");
            }
            throw new Exception("Please rectify the following errors: \n" . print_r($required_params) . "\n");
        }
    }

}