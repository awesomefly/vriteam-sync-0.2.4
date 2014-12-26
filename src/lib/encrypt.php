<?php
/**
                +------------------------------------------------------------------------------+
                |                           上线系统       授权协议                            |
                |                  版权所有(c) 2013 VRITEAM团队. 保留所有权利                  |
                +------------------------------------------------------------------------------+
                |本软件的著作权归VRITEAM团队所有。具体使用许可请看软件包中的LICENSE文件。或者访|
                |问我们的网站http://www.vriteam.com/sync/license。我们欢迎给使用并给我们提出宝 |
                |贵的意见和建议。感谢团队中的成员为项目所做的努力！                            |
                +------------------------------------------------------------------------------+
                |                               作者：VRITEAM团队                              |
                +------------------------------------------------------------------------------+

 */
function encrypt($data, $key = '') {

    $n = encrypt_resize($data, 4);

    $dlong[0]   = $n;
    $ndl = encrypt_str2long(1, $data, $dlong);

    $n = count($dlong);
    if (($n & 1) == 1) {
        $dlong[$n] = chr(0);
        $ndl++;
    }


    encrypt_resize($key, 16, true);
    if (!$key) $key = 'A vriteam product!';


    $nkl = encrypt_str2long(0, $key, $klong);


    $enc_data   = '';
    $w          = array(0, 0);
    $j          = 0;
    $k          = array(0, 0, 0, 0);
    for ($i = 0; $i < $ndl; ++$i) {

        if ($j + 4 <= $nkl) {
            $k[0] = $klong[$j];
            $k[1] = $klong[$j + 1];
            $k[2] = $klong[$j + 2];
            $k[3] = $klong[$j + 3];
        } else {
            $k[0] = $klong[$j % $nkl];
            $k[1] = $klong[($j + 1) % $nkl];
            $k[2] = $klong[($j + 2) % $nkl];
            $k[3] = $klong[($j + 3) % $nkl];
        }
        $j = ($j + 4) % $nkl;

        encrypt_encipherLong($dlong[$i], $dlong[++$i], $w, $k);


        $enc_data .= encrypt_long2str($w[0]);
        $enc_data .= encrypt_long2str($w[1]);
    }

    return $enc_data;
}




function decrypt($enc_data, $key = '') {

    $n_enc_dlong = encrypt_str2long(0, $enc_data, $enc_dlong);

    encrypt_resize($key, 16, true);
    if (!$key) $key = 'A vriteam product!';


    $nkl = encrypt_str2long(0, $key, $klong);


    $data   = '';
    $w      = array(0, 0);
    $j      = 0;
    $len    = 0;
    $k      = array(0, 0, 0, 0);
    $pos    = 0;

    for ($i = 0; $i < $n_enc_dlong; $i += 2) {

        if ($j + 4 <= $nkl) {
            $k[0] = $klong[$j];
            $k[1] = $klong[$j + 1];
            $k[2] = $klong[$j + 2];
            $k[3] = $klong[$j + 3];
        } else {
            $k[0] = $klong[$j % $nkl];
            $k[1] = $klong[($j + 1) % $nkl];
            $k[2] = $klong[($j + 2) % $nkl];
            $k[3] = $klong[($j + 3) % $nkl];
        }
        $j = ($j + 4) % $nkl;

        encrypt_decipherLong($enc_dlong[$i], $enc_dlong[$i + 1], $w, $k);


        if (0 == $i) {
            $len = $w[0];
            if (4 <= $len) {
                $data .= encrypt_long2str($w[1]);
            } else {
                $data .= substr(encrypt_long2str($w[1]), 0, $len % 4);
            }
        } else {
            $pos = ($i - 1) * 4;
            if ($pos + 4 <= $len) {
                $data .= encrypt_long2str($w[0]);

                if ($pos + 8 <= $len) {
                    $data .= encrypt_long2str($w[1]);
                } elseif ($pos + 4 < $len) {
                    $data .= substr(encrypt_long2str($w[1]), 0, $len % 4);
                }
            } else {
                $data .= substr(encrypt_long2str($w[0]), 0, $len % 4);
            }
        }
    }
    return $data;
}




function encrypt_encipherLong($y, $z, &$w, &$k) {
    $sum    = (integer) 0;
    $delta  = 0x9E3779B9;
    $n      = 32;

    while ($n-- > 0) {
        $y      = encrypt_add($y,
                encrypt_add($z << 4 ^ encrypt_rshift($z, 5), $z) ^
                encrypt_add($sum, $k[$sum & 3]));
        $sum    = encrypt_add($sum, $delta);
        $z      = encrypt_add($z,
                encrypt_add($y << 4 ^ encrypt_rshift($y, 5), $y) ^
                encrypt_add($sum, $k[encrypt_rshift($sum, 11) & 3]));
    }

    $w[0] = $y;
    $w[1] = $z;
}




function encrypt_decipherLong($y, $z, &$w, &$k) {

    $sum    = 0xC6EF3720;
    $delta  = 0x9E3779B9;
    $n      = 32;

    while ($n-- > 0) {
        $z      = encrypt_add($z,
                -(encrypt_add($y << 4 ^ encrypt_rshift($y, 5), $y) ^
                    encrypt_add($sum, $k[encrypt_rshift($sum, 11) & 3])));
        $sum    = encrypt_add($sum, -$delta);
        $y      = encrypt_add($y,
                -(encrypt_add($z << 4 ^ encrypt_rshift($z, 5), $z) ^
                    encrypt_add($sum, $k[$sum & 3])));
    }

    $w[0] = $y;
    $w[1] = $z;
}




function encrypt_resize(&$data, $size, $nonull = false) {
    $n      = strlen($data);
    $nmod   = $n % $size;
    if ( 0 == $nmod )
        $nmod = $size;

    if ($nmod > 0) {
        if ($nonull) {
            for ($i = $n; $i < $n - $nmod + $size; ++$i) {
                $data[$i] = $data[$i % $n];
            }
        } else {
            for ($i = $n; $i < $n - $nmod + $size; ++$i) {
                $data[$i] = chr(0);
            }
        }
    }
    return $n;
}

function encrypt_str2long($start, &$data, &$dlong) {
    $n = strlen($data);

    $tmp    = unpack('N*', $data);
    $j      = $start;

    foreach ($tmp as $value)
        $dlong[$j++] = $value;

    return $j;
}



function encrypt_long2str($l) {
    return pack('N', $l);
}

function encrypt_rshift($integer, $n) {

    if (0xffffffff < $integer || -0xffffffff > $integer)
        $integer = fmod($integer, 0xffffffff + 1);


    if (0x7fffffff < $integer) $integer -= 0xffffffff + 1.0;
    elseif (-0x80000000 > $integer) $integer += 0xffffffff + 1.0;


    if (0 > $integer) {
        $integer &= 0x7fffffff;                     
        $integer >>= $n;                            
        $integer |= 1 << (31 - $n);                 
    } else $integer >>= $n;                            

    return $integer;
}

function encrypt_add($i1, $i2) {
    $result = 0.0;

    foreach (func_get_args() as $value) {

        if (0.0 > $value) $value -= 1.0 + 0xffffffff;

        $result += $value;
    }


    if (0xffffffff < $result || -0xffffffff > $result)
        $result = fmod($result, 0xffffffff + 1);


    if (0x7fffffff < $result)
        $result -= 0xffffffff + 1.0;
    elseif (-0x80000000 > $result)
        $result += 0xffffffff + 1.0;

    return $result;
}
